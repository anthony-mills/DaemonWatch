<?php
class Model_DbTable_UserRoles extends Zend_Db_Table_Abstract {
	protected $_name = 'user_roles';
	protected $_primary = array('id');

	public function getAllUserRoles()
	{
		$select = $this->select();
		return $this->fetchAll($select);		 
	}
			
}

	