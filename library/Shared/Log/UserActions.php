<?php
class Shared_Log_UserActions
{
    /**
     *
     * @var Zend_Log
     */
    protected $logger;

    static $dbLogger = null;

    /**
     *
     * @return Shared_Log_UserActions
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
        $this->logger = Zend_Registry::get('userActionsLog');
    }
    
    /**
     *
     * @param String $message
     * @param Zend_Log $severity
     */

    public static function log($message, $severity = Zend_Log::INFO)
    {
//        self::getInstance()->getLog()
        self::getInstance()->getLog()->log($message, $severity);
    }
	
	/**
	 * Return the client Ip and user agent
	 * 
	 * @return array
	 * 
	 */
	public static function clientDetails() 
	{
		$userAgent = new Zend_Http_UserAgent();
		$clientDetails = array('user_agent' => $userAgent->getDevice()->getUserAgent());
		
		$clientDetails['client_ip'] = Shared_Log_UserActions::getClientIp();
		return $clientDetails;
	}	
	
	/**
	 * Return the ip address of the client machine
	 * 
	 *  @return string 
	 * 
	 */
	public static function getClientIp()
	{
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      		$clientIp = $_SERVER['HTTP_CLIENT_IP'];
    	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      		$clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
    	} else {
      		$clientIp = $_SERVER['REMOTE_ADDR'];
    	}
    	return $clientIp;		
	}	
}