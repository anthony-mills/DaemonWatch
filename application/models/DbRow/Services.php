<?php
class Model_DbRow_Services extends Zend_Db_Table_Abstract {
	protected $_name = 'services';
	protected $_primary = array('id');

	public function addNewService($serviceData)
	{
		return $this->insert($serviceData);
	}	
	
	public function deleteService($serviceId, $userId)
	{
		$delete = array('id = ?' => $serviceId, 'user_id = ?' => $userId);
		$this->delete($delete);		
	}
	
	public function getServiceById($serviceId, $userId)
	{
		$select = $this->select()
						->where($this->getAdapter()->quoteInto('id = ?', $serviceId));
		if (!empty($userId)) {
			$select = $select->where($this->getAdapter()->quoteInto('user_id = ?', $userId));
		}
		$select->order('checked DESC');
		
		return $this->fetchRow($select);			
	}
	
	public function updateService($serviceData, $userId = NULL)
	{
		$where = array('id' => $serviceData['id']);
		if (!empty($userId)) {
			$where['user_id'] = $userId;
		}
		unset($serviceData['id']);
		$this->update($serviceData, $where);
	}

	public function updateServiceById($serviceData, $userId = NULL)
	{
		$where = array('id' => $serviceData['id']);
		if (!empty($userId)) {
			$where['user_id'] = $userId;
		}
		unset($serviceData['id']);
		$this->update($serviceData, $where);
	}
	
	public function checkServiceNameByHost($serviceName, $serviceId, $userId)
	{
		$select = $this->select()
						->where($this->getAdapter()->quoteInto('id != ?', $serviceId))
						->where($this->getAdapter()->quoteInto('name = ?', $serviceName))
						->where($this->getAdapter()->quoteInto('user_id = ?', $userId));
		return $this->fetchRow($select);																		
	}
	
	public function checkServicePortByHost($hostId, $servicePort, $serviceId, $userId) {
		$select = $this->select()
						->where($this->getAdapter()->quoteInto('host_id = ?', $hostId))
						->where($this->getAdapter()->quoteInto('port = ?', $servicePort))
						->where($this->getAdapter()->quoteInto('id = ?', $serviceId))							
						->where($this->getAdapter()->quoteInto('user_id = ?', $userId));
		return $this->fetchRow($select);		
	}
	
	public function toggleServiceStatus($serviceStatus, $serviceId, $userId = NULL)
	{
		$serviceData = array('active' => $serviceStatus);
		$where = array('id' => $serviceId);
		
		if (!empty($userId)) {
			$where['user_id'] = $userId;
		}
		$this->update($serviceData, $where);		
	}
	
}

	