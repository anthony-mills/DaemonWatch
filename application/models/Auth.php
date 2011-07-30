<?php
class Model_Auth {
	protected $_authAdapter;
	protected $_userDbTableName = 'users';
    protected $_identityColumn = 'email';
	protected $_userData;
		
    public function logout() 
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        Zend_Session::destroy();
    }
		
	public function userLogin($loginData)
	{
        if (Zend_Auth::getInstance()->hasIdentity()) {
            Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->gotoSimple('home', 'user');
        }	
		$loginResult = Model_DbRow_Factory::getUsersDbRow()->checkUserCredentials($loginData['email'], $loginData['password']);
		if (!$loginResult) {
			return FALSE;
		} else {
			$clientDetails = Shared_Log_UserActions::clientDetails();			  
	   		$log = 'User: ' . $loginResult->email . ' (id #' . $loginResult->id . ') logged in at ' . date('d/m/y h:i:sa ', time()) . ' from ' .
	   			   $clientDetails['client_ip'] . ' with ' . $clientDetails['user_agent'];			
			Shared_Log_UserActions::log($log);
			
			$userData = array('user_id' => $loginResult->id, 
							  'email' => $loginResult->email,
							  'first_name' => $loginResult->first_name,
							  'last_name' => $loginResult->last_name);
			$userRole = Model_DbRow_Factory::getUserRolesDbRow()->getUserRoleById($loginResult->user_role);

			if (!empty($userRole)) {	
				$userData['userRole'] = $userRole->value;
			}	
			Zend_Auth::getInstance()->getStorage()->write( (object) $userData);
            Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->gotoSimple('home', 'user');
		}		
		
	} 
	
	public function resetPassword($emailAddress)
	{					
		$passwordDetails = Shared_User_Auth::generatePasswordAndHashAndSalt();
		$userDetails = array('password' => $passwordDetails['passwordHash'], 'salt' => $passwordDetails['salt']);

		$result = Model_DbRow_Factory::getUsersDbRow()->updateUserPassword($emailAddress, $userDetails);
		$clientDetails = Shared_Log_UserActions::clientDetails();
		
		if ($result) {
			$log = 'Password reset requested for ' . $emailAddress . ' at '  . date('d/m/y h:i:sa ', time()) . ' from ' .
	   			   $clientDetails['client_ip'] . ' with ' . $clientDetails['user_agent'];
				   
			Service_Factory::getEmailService()->sendResetPassword(array('email' => $emailAddress, 'password' => $passwordDetails['password']));
		} else {
			$log .= 'Password reset requested on non-existant account ' . $emailAddress . ' at '  . date('d/m/y h:i:sa ', time()) . ' from ' .
	   			   $clientDetails['client_ip'] . ' with ' . $clientDetails['user_agent'];
		}
		Shared_Log_UserActions::log($log);
		return $result;		
	}
	
	public function changePassword($password, $userId = NULL)
	{
		if (empty($userId)) {
			$userId = Zend_Registry::get('user_id');
		}
		$result = Model_DbRow_Factory::getUsersDbRow()->updateUserPasswordById($userId, $password);
		if ($result) {
			$clientDetails = Shared_Log_UserActions::clientDetails();
			$log = 'Password changed for user # ' . $userId . ' at '  . date('d/m/y h:i:sa ', time()) . ' from ' .
	   			   $clientDetails['client_ip'] . ' with ' . $clientDetails['user_agent'];
			Shared_Log_UserActions::log($log);	
			return TRUE;   
		} 
		return FALSE;
	}
}
	