<?php
/**
 * A factory class that returns instances of Models
 */
class Model_Factory
{

    protected static $_authModel;
    protected static $_userModel;
    protected static $_hostModel;
    protected static $_servicesModel;	
    protected static $_checkHostsModel;			
	
    /**
     * @return Model_Auth
     */
    public static function getAuthModel(){
        if(self::$_authModel  === null){
            self::$_authModel = new Model_Auth();
        }

        return self::$_authModel;
    }

    /**
     * @return Model_User
     */
    public static function getUserModel(){
        if(self::$_userModel  === null){
            self::$_userModel = new Model_User();
        }

        return self::$_userModel;
    }
	
    /**
     * @return Model_User
     */
    public static function getHostModel(){
        if(self::$_hostModel  === null){
            self::$_hostModel = new Model_Host();
        }

        return self::$_hostModel;
    }
	
    /**
     * @return Model_Service
     */
    public static function getServicesModel(){
        if(self::$_servicesModel  === null){
            self::$_servicesModel = new Model_Services();
        }

        return self::$_servicesModel;
    }

	
    /**
     * @return Model_Service
     */
    public static function getCheckHostsModel(){
        if(self::$_checkHostsModel  === null){
            self::$_checkHostsModel = new Model_CheckHosts();
        }

        return self::$_checkHostsModel;
    }
}	
?>
