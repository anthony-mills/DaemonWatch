<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    private $_frontController = null;

    private function _getFrontController() {
        if ($this->_frontController) {
            return $this->_frontController;
        }

        return $this->_frontController = Zend_Controller_Front::getInstance();
    }
	
	protected function _initAutoload() {
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
                    'namespace' => '',
                    'basePath' => APPLICATION_PATH . ''));
		Zend_Loader_Autoloader::getInstance()->registerNamespace('Shared_');
		
    }

    protected function _initDb()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", APPLICATION_ENV);
        
        $db = new Zend_Db_Adapter_Pdo_Mysql($config->resources->db->params);
        Zend_Db_Table::setDefaultAdapter($db);
    }
	
    protected function _initViewHelpers() {
        //setup the page
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();

        $view->setHelperPath(APPLICATION_PATH . '/views/helpers', '');
    }

    /**
     * Initialise the Acl
     */
    protected function _initAcl() {
        
        if (Zend_Auth::getInstance()->hasIdentity()) {
            /*
             * Get details from the AUTH instance. If the user
             * has an identity, set these to the registry.
             */
            Zend_Registry::set('userRole',
                                    Zend_Auth::getInstance()
                                    ->getStorage()->read()->userRole);
            Zend_Registry::set('user_id',
                                    Zend_Auth::getInstance()
                                    ->getStorage()->read()->user_id);
            Zend_Registry::set('email',
                                    Zend_Auth::getInstance()
                                    ->getStorage()->read()->email);

            /* We will also set the user's full name */
            $user = Model_DbRow_Factory::getUsersDbRow()->getUserById(Zend_Auth::getInstance()->getStorage()->read()->user_id);
			
            $userName = $user->first_name . " " . $user->last_name;
            Zend_Registry::set('user_name',$userName);

            $this->bootstrap('layout');
            $layout = $this->getResource('layout');
            $view = $layout->getView();
            $view->user_name = $userName;
  

        } else {
            /*
             * User has no identity and therefore is a guest user
             */
            Zend_Registry::set('userRole', 'guests');
            Zend_Registry::set('user_id', '0');
        }

        $acl = new Model_Acl_Library();
        $this->_getFrontController()->registerPlugin(new Plugin_AccessCheck($acl));
        Zend_Registry::set('acl', $acl);
        Zend_Registry::set('userAcl', new Model_Acl_User());
    }

    protected function _initUserActionsLogger() {
        $dbResource = $this->getPluginResource("db");
        $dbParameters = $dbResource->getParams();

        $db = Zend_Db::factory('PDO_MYSQL', $dbParameters);
        $columnMapping = array(
            'log_level' => 'priority',
            'description' => 'message',
            'user_id' => 'user_id',
            'timestamp' => 'timestamp'
        );

        $writer = new Zend_Log_Writer_Db($db, 'user_action_logs', $columnMapping);

        $log = new Zend_Log($writer);
        $log->setEventItem('user_id', Zend_Registry::get('user_id'));

        Zend_Registry::set('userActionsLog', $log);
    }
	

    protected function _initApplicationLogger() {
        $dbResource = $this->getPluginResource("db");
        $dbParameters = $dbResource->getParams();

        $db = Zend_Db::factory('PDO_MYSQL', $dbParameters);

        $columnMapping = array('log_level' => 'priority', 'description' => 'message',
        					   'timestamp' => 'timestamp');

        $writer = new Zend_Log_Writer_Db($db, 'application_logs', $columnMapping);

        Zend_Registry::set('appLog', new Zend_Log($writer));
    }

    protected function _initDateTime()
    {
    	date_default_timezone_set('UTC'); //sets the current timezone to UTC, used when writing entries to DB
    	Zend_Registry::set('dateTime_timezone_user', 'Australia/Sydney'); //sets the timezone of the user
    }	
}

