<?php
class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract
{

    private $_acl = null;

    public function __construct(Zend_Acl $acl)
    {
        $this->_acl = $acl;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $resource = $request->getControllerName();
        $action = $request->getActionName(); 

        if(!$this->_acl->isAllowed(Zend_Registry::get('userRole'), $resource, $action)){
            //Send user to login screen if not allowed
           // die('ACCESS NOT ALLOWED');
           	$path = $resource . '/' . $action . '/';
           	
           	$params = $this->_request->getParams();
           	foreach($params as $key => $value) {
           		if (($key !='controller') && ($key !='action') && ($key !='module')) {
					$path .= $key . '/' . $value . '/';
           		}
           	}
           	setCookie('login_redirect', urlencode($path));
            $request->setControllerName('auth')
                    ->setActionName('login');
        }

        $this->_acl->setDynamicPermissions();
    }
}