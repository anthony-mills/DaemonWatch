<?php
class Shared_Log_Firebug
{
    protected $_logger;
    static $firebugLogger = null;

    protected function  __construct() {
        $writer = new Zend_Log_Writer_Firebug();
        $this->_logger = new Zend_Log($writer);
    }

    public static function getInstance(){
        if(self::$firebugLogger === null){
            self::$firebugLogger = new self();
        }

        return self::$firebugLogger;
    }

    public static function log($message, $severity = null){
        if(!$severity){
            $severity = Zend_Log::WARN;
        }
        self::getInstance()->getLog()->log($message, $severity);
    }

    public function getLog(){
        return $this->_logger;
    }
}