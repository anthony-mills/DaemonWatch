<?php
class Model_Acl_User implements Zend_Acl_Role_Interface
{
    public $userRole = null;
    public $userId = null;

    public function __construct($userId = null, $userRole = null){
        if($userId != null){
            $this->userId = $userId;
        }else{
            $this->userId =  Zend_Registry::get('user_id');
        }

        if($userRole != null){
            $this->userRole = $userRole;
        }else{
            $this->userRole = Zend_Registry::get('userRole');
        }

    }

    public function getRoleId(){
        return $this->userRole;
    }
    
    public function getUserId(){
        return $this->userId;
    }
}