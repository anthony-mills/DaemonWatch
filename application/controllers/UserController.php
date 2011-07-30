<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {

    }

	public function indexAction()
	{
		$this->_redirect('user/home');	
	}
	
	public function homeAction()
	{
		$this->view->userSummary = Model_Factory::getUserModel()->getUserSummary(Zend_Registry::get('user_id')); 		
	}
	
	public function changePasswordAction()
	{
		$loginForm = new Form_ChangePassword();  
		if ($this->_request->isPost()) {
			$formData = $this->_request->getParams();
		    if ($loginForm->isValid($formData)) {
				if ($formData['newPassword'] == $formData['repeatPassword']) {
					$result = Model_Factory::getAuthModel()->changePassword($formData['newPassword']);
					if (!$result) {
						$this->view->errors = array('Error updating passwords.'); 
					} else {
						$this->view->errors = array('Account password successfully updated.');
					}
				} else {
					$this->view->errors = array('The passwords you entered do not match.');
				}
			} else {
				$this->view->errors = $loginForm->getMessages();
			} 
		}	
		$this->view->js = array('validate.js', 'html5_placeholders.js', 'handlers/user/change-password.js');			
	}

}
