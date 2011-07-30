<?php

class AdminController extends Zend_Controller_Action
{
	public function createUserAction()
	{
		$this->view->js = array('validate.js', 'select_skin.js', 'html5_placeholders.js','handlers/services/add.js');
		$this->view->userRoles = Model_DbTable_Factory::getUserRolesDbTable()->getAllUserRoles()->toArray();
	}
}