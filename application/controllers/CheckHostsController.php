<?php

class CheckHostsController extends Zend_Controller_Action
{
	
    public function init()
    {
		$this->_helper->layout()->disableLayout();    	
		$this->_helper->viewRenderer->setNoRender(true);
    }

	public function checkAllServicesAction()
	{
		$this->view->hostServices = Model_Factory::getCheckHostsModel()->checkNeededServices();
	}
}