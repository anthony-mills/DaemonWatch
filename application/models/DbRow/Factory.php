<?php
/**
 * This class is the single point of access to instantiate DbRow classes.
 * This class prevents instantiating multiple objects of the DbRow classes.
 */
class Model_DbRow_Factory
{
    protected static $_usersDbRow;
	protected static $_userRolesDbRow;
	protected static $_hostsDbRow;
	protected static $_servicesDbRow;
	protected static $_serviceChecksDbRow;		

    /**
     * @return Model_DbRow_Users
     */
    public static function getUsersDbRow(){
        if( self::$_usersDbRow === NULL ){
            self::$_usersDbRow = new Model_DbRow_Users();
        }

        return self::$_usersDbRow;
    }
	
    /**
     * @return Model_DbRow_UserRoles
     */
    public static function getUserRolesDbRow(){
        if( self::$_userRolesDbRow === NULL ){
            self::$_userRolesDbRow = new Model_DbRow_UserRoles();
        }

        return self::$_userRolesDbRow;
    }
	
    /**
     * @return Model_DbRow_Hosts
     */
    public static function getHostsDbRow(){
        if( self::$_hostsDbRow === NULL ){
            self::$_hostsDbRow = new Model_DbRow_Hosts();
        }

        return self::$_hostsDbRow;
    }			
	
    /**
     * @return Model_DbRow_Services
     */
    public static function getServicesDbRow(){
        if( self::$_servicesDbRow === NULL ){
            self::$_servicesDbRow = new Model_DbRow_Services();
        }

        return self::$_servicesDbRow;
    }		
	
	/**
     * @return Model_DbRow_ServiceChecks
     */
    public static function getServiceChecksDbRow(){
        if( self::$_serviceChecksDbRow === NULL ){
            self::$_serviceChecksDbRow = new Model_DbRow_ServiceChecks();
        }

        return self::$_serviceChecksDbRow;
    }	
}