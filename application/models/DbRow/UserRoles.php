<?php
class Model_DbRow_UserRoles extends Zend_Db_Table_Abstract {
	protected $_name = 'user_roles';
	protected $_primary = array('id');

	public function getUserRoleById($roleId)
	{
        $select = $this->select()
                        ->where($this->getAdapter()->quoteInto('id = ?', $roleId));
		return $this->fetchRow($select);
	}	
		
}

	