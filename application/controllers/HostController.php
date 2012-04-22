<?php

class HostController extends Zend_Controller_Action
{

    public function init()
    {

    }

	public function addAction()
	{
		$addHostForm = new Form_AddHost(); 
		if ($this->_request->isPost()) {
			$formData = $this->_request->getParams();
		    if ($addHostForm->isValid($formData)) {
				$validator = new Zend_Validate_Hostname(Zend_Validate_Hostname::ALLOW_IP | Zend_Validate_Hostname::ALLOW_DNS);
				if ($validator->isValid($formData['hostName'])) {
					$formData = array('name' => $formData['name'], 'hostName' => $formData['hostName']);
					$result = Model_Factory::getHostModel()->addNewHost($formData);
					if (!$result) {
						$this->view->errors = array('Hostname unable to be saved');
						$this->view->formData = $formData;
					} elseif (is_array($result)) {
						$this->view->errors = $result;
						$this->view->formData = $formData;
					} else {
						$this->view->errors = array('Host successfully saved');						
					}
				} else {
					$this->view->errors = array('Hostname or IP address is not valid');
				}
			} else {
				$this->view->errors = $addHostForm->getMessages();
			} 
		}	
		$this->view->js = array('validate.js', 'html5_placeholders.js', 'handlers/hosts/add.js');
	}
	
	public function viewAllAction()
	{
		$userId = Zend_Registry::get('user_id');
		$this->view->userHosts = Model_Factory::getHostModel()->getUserHosts($userId);
		$this->view->js = array('facebox.js', 'handlers/hosts/view-all.js');			
	}
	
	public function deleteAction()
	{
		$this->_helper->layout()->disableLayout();
		$confirmed = $this->_request->getParam("confirmed");
		$hostId = $this->_request->getParam("hostId");
		if (($confirmed == 1) && (!empty($hostId)) && (is_numeric($hostId))) {		
			$this->_helper->viewRenderer->setNoRender(true);
			$userId = Zend_Registry::get('user_id');
			$result = Model_Factory::getHostModel()->deleteHost( (int) $hostId, $userId);
			$this->_redirect('host/view-all');

		} 
		if (is_numeric($hostId)) {
			$this->view->hostId = $hostId; 
		} else {
				$this->_redirect('user/home');
				exit; 				
		}
		
	}
	
	public function editAction()
	{
		$addHostForm = new Form_AddHost();
		$userId = Zend_Registry::get('user_id'); 
		
		if ($this->_request->isPost()) {
			$formData = $this->_request->getParams();
		    if ($addHostForm->isValid($formData)) {
				$validator = new Zend_Validate_Hostname(Zend_Validate_Hostname::ALLOW_IP | Zend_Validate_Hostname::ALLOW_DNS);
				if (($validator->isValid($formData['hostName'])) && (is_numeric($formData['hostId']))) {
					$formData = array('name' => $formData['name'], 'hostName' => $formData['hostName'], 'hostId' => $formData['hostId']);
					$result = Model_Factory::getHostModel()->updateExistingHost($formData, $userId);
					if (!$result) {
						$this->view->formData = $formData;
						$this->view->errors = array('Host successfully updated');
					} elseif (is_array($result)) {
						$this->view->errors = $result;
						$this->view->formData = $formData;
					}
				} else {
					$this->view->errors = array('Hostname or IP address is not valid');
					$this->view->formData = $formData;
				}
			} else {
				$this->view->errors = $addHostForm->getMessages();
			} 
		} else {
			// Prepopulate the form with data
			$hostId = $this->_request->getParam("hostId",null);
			if (!empty($hostId)) {			
				$result = Model_Factory::getHostModel()->getHostById($hostId, $userId);
				if (!empty($result)) {
					$this->view->formData = array('name' => $result->name, 'hostName' => $result['hostname']);
				} else {
					$this->_redirect('user/home');					
				}
			} else {
				$this->_redirect('user/home');
			}
			
		}
		$this->view->js = array('validate.js', 'handlers/hosts/edit.js');		
	}


}
