<?php
/**
 * This class is the single point of access to instantiate DbTable classes.
 * This class prevents instantiating multiple objects of the DbTable classes.
 */
class Model_DbTable_Factory
{
    protected static $_usersDbTable;
    protected static $_hostsDbTable;	
    protected static $_servicesDbTable;
    protected static $_serviceChecksDbTable;	
    protected static $_userRolesDbTable;	
	
    /**
     * @return Model_DbTable_Users
     */
    public static function getUsersDbTable(){
        if( self::$_usersDbTable === NULL ){
            self::$_usersDbTable = new Model_DbTable_Users();
        }

        return self::$_usersDbTable;
    }
	
    /**
     * @return Model_DbTable_Hosts
     */
    public static function getHostsDbTable(){
        if( self::$_hostsDbTable === NULL ){
            self::$_hostsDbTable = new Model_DbTable_Hosts();
        }

        return self::$_hostsDbTable;
    }
	
    /**
     * @return Model_DbTable_Services
     */
    public static function getServicesDbTable(){
        if( self::$_servicesDbTable === NULL ){
            self::$_servicesDbTable = new Model_DbTable_Services();
        }

        return self::$_servicesDbTable;
    }	
	
    /**
     * @return Model_DbTable_Services
     */
    public static function getServiceChecksDbTable(){
        if( self::$_serviceChecksDbTable === NULL ){
            self::$_serviceChecksDbTable = new Model_DbTable_ServiceChecks();
        }

        return self::$_serviceChecksDbTable;
    }	
	
	/**
     * @return Model_DbTable_UserRoles
     */
    public static function getUserRolesDbTable(){
        if( self::$_userRolesDbTable === NULL ){
            self::$_userRolesDbTable = new Model_DbTable_UserRoles();
        }

        return self::$_userRolesDbTable;
    }		
}