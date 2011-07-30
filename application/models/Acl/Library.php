<?php

class Model_Acl_Library extends Zend_Acl {

    public function __construct() {
        $this->_addRolesToAcl();
        $this->_addResourcesToAcl();
        $this->_addDenyPermissions();
        $this->_addAllowPermissions();
    }

    protected function _addRolesToAcl() {
        $this->addRole(new Zend_Acl_Role('guests'));
        $this->addRole(new Zend_Acl_Role('users'), 'guests');
        $this->addRole(new Zend_Acl_Role('admin'), 'users');
    }

    protected function _addResourcesToAcl() {
        //Default controllers
        $this->add(new Zend_Acl_Resource('index'));
        $this->add(new Zend_Acl_Resource('error'));

        //Application specific controllers
        $this->add(new Zend_Acl_Resource('user'));
        $this->add(new Zend_Acl_Resource('auth'));
        $this->add(new Zend_Acl_Resource('host'));		
        $this->add(new Zend_Acl_Resource('admin'));
        $this->add(new Zend_Acl_Resource('services'));
        $this->add(new Zend_Acl_Resource('check-hosts'));		
    }

    protected function _addAllowPermissions() {
        $this
                ->allow('guests', 'index', array( 'index' ) )
                ->allow('guests', 'auth', array( 'login', 'reset-password', 'logout' ) )
				->allow('guests', 'check-hosts', array('check-all-services'))
                ->allow('guests', 'error')
				->allow('users', 'user', array('home', 'change-password', 'index', 'view-all'))
				->allow('users', 'host', array('add', 'view', 'edit', 'delete'))
				->allow('users', 'services', array('add', 'view', 'edit', 'history', 'delete', 'toggle-checks'))												
				->allow('users', 'auth', array('logout'))
				->allow('admin', 'user', array('home', 'change-password', 'index'))
				->allow('admin', 'host', array('add', 'view', 'edit', 'view-all', 'delete'))	
				->allow('admin', 'services', array('add', 'view', 'edit', 'history', 'delete', 'toggle-checks'))
				->allow('admin', 'check-hosts', array('check-all-services'))															
				->allow('admin', 'admin', array('home', 'create-user'));					
    }

    protected function _addDenyPermissions() {
        $this->deny('guests', 'user', array('logout'));
    }

    public function setDynamicPermissions() {
        
    }

}