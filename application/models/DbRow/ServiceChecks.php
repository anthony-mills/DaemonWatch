<?php
class Model_DbRow_ServiceChecks extends Zend_Db_Table_Abstract {
	protected $_name = 'service_checks';
	protected $_primary = array('id');

	public function saveHostCheck($serviceCheckData)
	{
		return $this->insert($serviceCheckData);
	}	
	
}

	