<?php
/**
 * A factory class that returns instances of Models
 */
class Model_Factory
{

    protected static $_authModel;
    protected static $_userModel;
    protected static $_hostModel;
   	protected static $_adminModel;	
    protected static $_servicesModel;	
    protected static $_checkHostsModel;	
	protected static $_graphModel;			
	protected static $_hostStastisticsModel;
	
    /**
     * @return Model_Auth
     */
    public static function getAuthModel()
    {
        if(self::$_authModel  === null){
            self::$_authModel = new Model_Auth();
        }

        return self::$_authModel;
    }

    /**
     * @return Model_User
     */
    public static function getUserModel()
    {
        if(self::$_userModel  === null){
            self::$_userModel = new Model_User();
        }

        return self::$_userModel;
    }

    /**
     * @return Model_Admin
     */
    public static function getAdminModel()
    {
        if(self::$_adminModel  === null){
            self::$_adminModel = new Model_Admin();
        }

        return self::$_adminModel;
    }
		
    /**
     * @return Model_User
     */
    public static function getHostModel()
    {
        if(self::$_hostModel  === null){
            self::$_hostModel = new Model_Host();
        }

        return self::$_hostModel;
    }
	
    /**
     * @return Model_Service
     */
    public static function getServicesModel()
    {
        if(self::$_servicesModel  === null){
            self::$_servicesModel = new Model_Services();
        }

        return self::$_servicesModel;
    }

    /**
     * @return Model_Service
     */
    public static function getCheckHostsModel()
    {
        if(self::$_checkHostsModel  === null){
            self::$_checkHostsModel = new Model_CheckHosts();
        }

        return self::$_checkHostsModel;
    }
	
    /**
     * @return Model_Graph
     */
    public static function getGraphModel()
    {
        if(self::$_graphModel  === null){
            self::$_graphModel = new Model_Graph();
        }

        return self::$_graphModel;
    }	
	
	/**
	 * @return Model_HostStatistics
	 */
	public static function getHostStatisticsModel() 
	{
        if(self::$_hostStastisticsModel  === null){
            self::$_hostStastisticsModel = new Model_HostStatistics();
        }

        return self::$_hostStastisticsModel;		
	}
}	
?>
