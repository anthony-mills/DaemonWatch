<?php

class AdminController extends Zend_Controller_Action
{
	public function createUserAction()
	{
		$this->view->js = array('validate.js', 'select_skin.js', 'html5_placeholders.js','handlers/services/add.js');
		$this->view->userRoles = Model_DbTable_Factory::getUserRolesDbTable()->getAllUserRoles()->toArray();
		if ($this->_request->isPost()) {
			$addUserForm = new Form_Admin_AddUser(); 
			$formData = $this->_request->getPost();
			
			if ($addUserForm->isValid($formData)) {
				$result = Model_Factory::getAdminModel()->addNewUser($formData);	
				if (!$result) {
					$this->view->errors = array('User unable to be created');
				} else {
					$this->view->errors = $result;
				}
			}
		
		}		
	}
}