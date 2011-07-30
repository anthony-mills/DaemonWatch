<?php

class Service_Factory
{
    protected static $_email;
    protected static $_image;

    /**
     *
     * @return Service_Email
     */
    public static function getEmailService(){
        if(self::$_email  === null){
            self::$_email = new Service_Email();
        }

        return self::$_email;
    }

}
