<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('auth');
    }

    public function loginAction()
    {
    	$userId = Zend_Registry::get('user_id');
		if ((!empty($userId)) && ($userId > 0)) {
			$this->_redirect('user/home');
		}
		$loginForm = new Form_Login();  
		if ($this->_request->isPost()) {
			$formData = $this->_request->getParams();
		    if ($loginForm->isValid($formData)) {
				$result = Model_Factory::getAuthModel()->userLogin($formData);
				if (!$result) {
					$this->view->errors = array('Login failed please check your email address and password.');
				}
			} else {
				$this->view->errors = $loginForm->getMessages();
			} 
		}
		$this->view->js = array('validate.js', 'html5_placeholders.js', 'handlers/auth/login.js');
    }
	
	public function resetPasswordAction()
	{
		$resetForm = new Form_ResetPassword();
		if ($this->_request->isPost()) {
			$formData = $this->_request->getParams();
		    if ($resetForm->isValid($formData)) {
				$result = Model_Factory::getAuthModel()->resetPassword($formData['email']);
				if (!$result) {
					$this->view->errors = array('Unable to reset password for that email address.');
				} else {
					$this->view->errors = array('Account password successfully reset.');
				}
			} else {
				$this->view->errors = $resetForm->getMessages();
			} 
		}	
		$this->view->js = array('validate.js', 'html5_placeholders.js', 'handlers/auth/reset-password.js');				
	}
	
	public function logoutAction()
	{
		Model_Factory::getAuthModel()->logout();
		$this->_redirect('auth/login');
	}	

}
