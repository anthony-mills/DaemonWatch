<?php
class Model_DbRow_Hosts extends Zend_Db_Table_Abstract {
	protected $_name = 'hosts';
	protected $_primary = array('id');

	public function addNewHost($hostData)
	{
		return $this->insert($hostData);
	}	
	
	public function deleteHost($hostId, $userId = NULL)
	{
		if (!empty($userId)) {
			$delete = array('id = ?' => $hostId, 'user_id = ?' => $userId);
			$this->delete($delete);
		} else {
			$where = $this->getAdapter()->quoteInto('id = ?', $hostId);		
			$this->delete($where);					
		}	
	}
	
	public function getHostById($hostId, $userId = NULL) 
	{
		    $select = $this->select()
                        ->where($this->getAdapter()->quoteInto('id = ?', $hostId));
			if (!empty($userId)) {
				$select = $select->where($this->getAdapter()->quoteInto('user_id = ?', $userId));
			}
			return $this->fetchRow($select);	
	}
	
	public function updateHostById($hostId, $hostData)
	{	
		$this->update($hostData, 'id = ' . $hostId);
	}
	
		
}

	