<?php
class Model_Admin {
	
	public function addNewUser($userData)
	{
		$userResult = Model_DbRow_Factory::getUsersDbRow()->checkUserByEmail($userData['email']);
		if (!empty($userResult)) {
			return array('User email already exists in system');
		}
		
		$passwordDetails = Shared_User_Auth::generatePasswordAndHashAndSalt();
		$userData['password'] = $passwordDetails['passwordHash'];
		$userData['salt'] = $passwordDetails['salt'];		
		
		$emailData = array('firstName' => $userData['first_name'], 'userEmail' => $userData['email'], 'userPwd' => $passwordDetails['password']); 

		// Email the user their new account password 
		Service_Factory::getEmailService()->sendUserAccountDetails($emailData);
		
		Model_DbRow_Factory::getUsersDbRow()->addNewUser($userData);
		
		$clientDetails = Shared_Log_UserActions::clientDetails();
		$log = 'New user created ' . $userData['email'] . ' by ' . Zend_Registry::get('user_id') .  ' at '  . date('d/m/y h:i:sa ', time()) . ' from ' .
	   		   $clientDetails['client_ip'] . ' with ' . $clientDetails['user_agent'];
		Shared_Log_UserActions::log($log);	
		
		return array('User successfully created');
	}
	
	
	
}
	