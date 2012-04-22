<?php
class Model_DbRow_Users extends Zend_Db_Table_Abstract {
	protected $_name = 'users';
	protected $_primary = array('id');

	public function checkUserByEmail($email)
	{
        $select = $this->select()
                        ->where($this->getAdapter()->quoteInto('email = ?', $email));
		return $this->fetchRow($select);
	}	
		
	public function getUserById($userId)
	{
        $select = $this->select()
                        ->where($this->getAdapter()->quoteInto('id = ?', $userId));
		return $this->fetchRow($select);
	}		
		
	public function checkUserCredentials($email, $password)
	{
		$user = $this->checkUserByEmail($email);
		if (!empty($user)) {
			$hashedPass = sha1($user->salt . $password);
			if ($user->password == $hashedPass) {
				return $user;
			} 
		}
		return FALSE;
	}	
	
	public function updateUserPassword($email, $passwordData)
	{
		$row = $this->fetchRow($this->select()->where($this->getAdapter()->quoteInto('email = ?', $email)));
		if (!empty($row)) {
			$row->password = $passwordData['password'];
	        $row->salt = $passwordData['salt'];
			$row->save();
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function updateUserPasswordById($userId, $password)
	{
		$row = $this->fetchRow($this->select()->where($this->getAdapter()->quoteInto('id = ?', $userId)));
		if (!empty($row)) {
			$row->password = sha1($row->salt . $password);
			$row->save();
			return TRUE;
		} 
		return FALSE;
	}
	
	public function addNewUser($userData)
	{
		return $this->insert($userData);
	}	
		
}

	