<?php

class Service_Email {

    protected $_mail = NULL;
    protected $_view = NULL;
    protected $_viewScriptPath = '/views/scripts/';
    protected $_emailConfiguration = NULL;
    protected $_appConfiguration = NULL;
    protected $_appConfigurationFilePath = '/configs/application.ini';		
    protected $_emailConfigurationFilePath = '/configs/email.ini';

    public function __construct() {

        $this->_emailConfiguration = new Zend_Config_Ini(APPLICATION_PATH . $this->_emailConfigurationFilePath, APPLICATION_ENV);
        $this->_appConfiguration = new Zend_Config_Ini(APPLICATION_PATH . $this->_appConfigurationFilePath, APPLICATION_ENV);		
        $this->_setupView();
        $this->_setupMailTransport();
        $this->_mail = new Zend_Mail();
    }

    protected function _setupView() {

        $this->_view = new Zend_view();
        $this->_view->setScriptPath(APPLICATION_PATH . $this->_viewScriptPath);
    }

    protected function _setupMailTransport() {

        $emailConfig = array(
            'auth' => 'login',
            'username' => $this->_emailConfiguration->settings->username,
            'password' => $this->_emailConfiguration->settings->password,
            'port' => $this->_emailConfiguration->settings->port,
        );
        
        if (!empty($this->_emailConfiguration->settings->ssl)) {
        	$emailConfig['ssl'] = $this->_emailConfiguration->settings->ssl;
        }
        $server = $this->_emailConfiguration->settings->server;

        $transport = new Zend_Mail_Transport_Smtp($server, $emailConfig);
        Zend_Mail::setDefaultTransport($transport);
    }

    /**
     * Sends an email to a user with their 
	 * new password.
     * 
     * @param array $data
     * @return bool
     */
    public function sendUserAccountDetails(array $data) {
    	$siteName = $this->_appConfiguration->site->name;
		$data['siteName'] = $siteName;
        $htmlMessage = $this->_view->partial(
                        'admin/email/new-user-account-html.phtml',
                        $data
        );

        $nonHtmlMessage = $this->_view->partial(
                        'admin/email/new-user-account-text.phtml',
                        $data
        );

        $this->_mail = new Zend_Mail();
		$siteName = $this->_appConfiguration->site->name;
        $this->_mail->setSubject('Your account on ' . $siteName . ' has been created');
        $this->_mail->setFrom($this->_emailConfiguration->name->noreply, $this->_emailConfiguration->email->noreply);
        $this->_mail->setReplyTo($this->_emailConfiguration->name->support, $this->_emailConfiguration->email->support);
        $this->_mail->addTo($data['userEmail']);
        $this->_mail->setBodyHtml($htmlMessage);
        $this->_mail->setBodyText($nonHtmlMessage);

        //send the message
        try {
            $result = $this->_mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Sends a email with a new password in it.
     * $data should contain the following keys:
     * - email: the email address of the user
     * - password: the new password for the user
     * 
     * @param array $data
     * @return bool
     */
    public function sendResetPassword(array $data) {
        $htmlMessage = $this->_view->partial(
                        'auth/email/password-reset-html.phtml',
                        $data
        );

        $nonHtmlMessage = $this->_view->partial(
                        'auth/email/password-reset-text.phtml',
                        $data
        );

        $this->_mail = new Zend_Mail();
        $this->_mail->setSubject('Your password has been reset');
        $this->_mail->setFrom($this->_configuration->name->noreply, $this->_configuration->email->noreply);
        $this->_mail->setReplyTo($this->_configuration->name->support, $this->_configuration->email->support);
        $this->_mail->addTo($data['email']);
        $this->_mail->setBodyHtml($htmlMessage);
        $this->_mail->setBodyText($nonHtmlMessage);

        //send the message
        try {
            $result = $this->_mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
	
    protected function _sendToMultipleAddresses($users, $htmlMessage, $nonHtmlMessage){
        foreach ($users as $user) {
            $this->_mail->addTo($user['email'], $user['preferredName']);
            $this->_mail->setBodyHtml($htmlMessage);
            $this->_mail->setBodyText($nonHtmlMessage);
            $result = $this->_mail->send();
        }
    }

}