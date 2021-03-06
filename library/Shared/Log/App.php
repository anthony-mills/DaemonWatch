<?php
class Shared_Log_App
{
    /**
     *
     * @var Zend_Log
     */
    protected $logger;

    /**
     *
     * @var Shared_Log_App
     */
    static $dbLogger = null;

    /**
     *
     * @return Shared_Log_App
     */
    public static function getInstance()
    {
        if (self::$dbLogger === null)
        {
            self::$dbLogger = new self();
        }
        return self::$dbLogger;
    }
    /**
     *
     * @return Zend_Log
     */
    public function getLog()
    {
        return $this->logger;
    }

    protected function __construct()
    {
        $this->logger = Zend_Registry::get('appLog');
    }
    
    /**
     *
     * @param String $message
     * @param Zend_Log $severity
     */

    public static function log($message, $severity = Zend_Log::INFO)
    {
        self::getInstance()->getLog()->log($message, $severity);
    }
}