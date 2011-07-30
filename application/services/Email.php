<?php

class Service_Email {

    protected $_mail = NULL;
    protected $_view = NULL;
    protected $_viewScriptPath = '/views/scripts/';
    protected $_configuration = NULL;
    protected $_configurationFilePath = '/configs/email.ini';

    public function __construct() {

        $this->_configuration = new Zend_Config_Ini(APPLICATION_PATH . $this->_configurationFilePath, APPLICATION_ENV);
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
            'username' => $this->_configuration->settings->username,
            'password' => $this->_configuration->settings->password,
            'port' => $this->_configuration->settings->port,
        );
        
        if (!empty($this->_configuration->settings->ssl)) {
        	$emailConfig['ssl'] = $this->_configuration->settings->ssl;
        }
        $server = $this->_configuration->settings->server;

        $transport = new Zend_Mail_Transport_Smtp($server, $emailConfig);
        Zend_Mail::setDefaultTransport($transport);
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