<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Model{
    private $id;
    private $alert_type;
    private $ref_id;
    private $date;
    private $user_type;
    private $user_id;
    private $for_user_type;
    private $for_user_id;
    private $notification_msg;
    private $is_read;
    private $name;
    private $table;
    private $lookupTable;

    public function __construct(){
        switch($this->alert_type){
            case 1: 
                $this->name = "Inventory";
                $this->lookupTable = 'assets';
                break;
            case 2:
                $this->name = "MTR";
                $this->lookupTable = 'mtr';
                break;
            case 3:
                $this->name = "DTR";
                $this->lookupTable = 'dtr';
                break;
            case 4:
                $this->name = "DSR";
                $this->lookupTable = 'dsr';
                break;
        }
    }
    public function setID($id){
        $this->id = $id;
    }
    public function getID(){
        return $this->id;
    }
    public function setAlertType($alert_type){
        $this->alert_type = $alert_type;
        switch($this->alert_type){
            case 1: 
                $this->name = "Inventory";
                $this->lookupTable = 'assets';
                break;
            case 2:
                $this->name = "MTR";
                $this->lookupTable = 'mtr';
                break;
            case 3:
                $this->name = "DTR";
                $this->lookupTable = 'dtr';
                break;
            case 4:
                $this->name = "DSR";
                $this->lookupTable = 'dsr';
                break;
        }
    }
    public function getAlertType(){
        return $this->alert_type;
    }
    public function setRefID($ref_id){
        $this->ref_id = $ref_id;
    }
    public function getRefID(){
        return $this->ref_id;
    }
    public function setDate($date){
        $this->date = $date;
    }
    public function getDate(){
        return $this->date;
    }
    public function setUserType($user_type){
        $this->user_type = $user_type;
    }
    public function getUserType(){
        return $this->user_type;
    }
    public function setUserID($user_id){
        $this->user_id = $user_id;
    }
    public function getUserID(){
        return $this->user_id;
    }
    public function setForUserType($for_user_type){
        $this->for_user_type = $for_user_type;
    }
    public function getForUserType(){
        return $this->for_user_type;
    }
    public function setForUserID($for_user_id){
        $this->for_user_id = $for_user_id;
    }
    public function getForUserID(){
        return $this->for_user_id;
    }
    public function setNotificationMsg($notification_msg){
        $this->notification_msg = $notification_msg;
    }
    public function getNotificationMsg(){
        return $this->notification_msg;
    }
    public function setIsRead($is_read){
        $this->is_read = $is_read;
    }
    public function getIsRead(){
        return $this->is_read;
    }
    public function setName($name){
        $this->name = $name;
        if($name == "Inventory") $this->setAlertType(1);
        if($name == "MTR") $this->setAlertType(2);
        if($name == "DTR") $this->setAlertType(3);
        if($name == "DSR") $this->setAlertType(4);
    }
    public function getName(){
        return $this->name;
    }
    public function setLookupTable($lookupTable){
        $this->lookupTable = $lookupTable;
    }
    public function getLookupTable(){
        return $this->lookupTable;
    }
    public function set($id, $alert_type, $ref_id, $date, $user_type, $user_id, $for_user_type, $for_user_id, $notification_msg, $is_read){
        $this->id               = $id;
        $this->alert_type       = $alert_type;
        $this->ref_id           = $ref_id;
        $this->date             = $date;
        $this->user_type        = $user_type;
        $this->user_id          = $user_id;
        $this->for_user_type    = $for_user_type;
        $this->for_user_id      = $for_user_id;
        $this->notification_msg = $notification_msg;
        $this->is_read          = $is_read;
    }
    public function get(){
        return array(
            'id'               => $this->id,
            'alert_type'       => $this->alert_type,
            'ref_id'           => $this->ref_id,
            'date'             => $this->date,
            'user_type'        => $this->user_type,
            'user_id'          => $this->user_id,
            'for_user_type'    => $this->for_user_type,
            'for_user_id'      => $this->for_user_id,
            'notification_msg' => $this->notification_msg,
            'is_read'          => $this->is_read
        );
    }
    public function create($alert_type, $ref_id, $date, $user_type, $user_id, $for_user_type, $for_user_id, $notification_msg, $is_read){
        $data = array(
            'alert_type'       => $alert_type,
            'ref_id'           => $ref_id,
            'date'             => $date,
            'user_type'        => $user_type,
            'user_id'          => $user_id,
            'for_user_type'    => $for_user_type,
            'for_user_id'      => $for_user_id,
            'notification_msg' => $notification_msg,
            'is_read'          => $is_read
        );
        $this->db->limit(1);					
		$this->db->insert('notifications', $data);        
        $retrieved = $this->db->get_where('notifications',$data)->custom_row_object(0, 'notifications');
        //$this->set_dsr($retrieved);
        //echo "<pre>"; print_r($retrieved->id);exit;
        return $retrieved;
    }
    public function read($for_user_type, $for_user_id){
        $this->db->where('for_user_type', $for_user_type);
        $this->db->where('for_user_id', $for_user_id);
        $this->db->where('is_read', 0);
		$retrieved = $this->db->select('*')->from('notifications')->order_by("id", "desc")->get()->custom_result_object('notifications');
        return $retrieved;
    }

    public function update($id, $alert_type, $ref_id, $date, $user_type, $user_id, $for_user_type, $for_user_id, $notification_msg, $is_read){
        $data = array(
            'id'               => $id,
            'alert_type'       => $alert_type,
            'ref_id'           => $ref_id,
            'date'             => $date,
            'user_type'        => $user_type,
            'user_id'          => $user_id,
            'for_user_type'    => $for_user_type,
            'for_user_id'      => $for_user_id,
            'notification_msg' => $notification_msg,
            'is_read'          => $is_read
        );
        $where = array('id' => $id);
        $this->db->limit(1);
		$this->db->where('id', $id);
		$upd = $this->db->update('notifications', $data);
        if(isset($upd)){
            return true;
        }
        else{
            return false;
        }
    }
        
    public function delete($id){
        $this->db->limit(1);
		$this->db->where('id', $id);
		if($this->db->delete('notifications')){
            return true;
        }
        else{
            return false;
        }
    }
    public function count($for_user_type, $for_user_id){
        $this->db->where('for_user_type', $for_user_type);
        $this->db->where('for_user_id', $for_user_id);
        $count = $this->db->select('*')->from('notifications')->order_by("id", "desc")->count_all_results();
        return $count;
    }
    public function countRead($for_user_type, $for_user_id){
        $this->db->where('for_user_type', $for_user_type);
        $this->db->where('for_user_id', $for_user_id);
        $this->db->where('is_read', 1);
        $count = $this->db->select('*')->from('notifications')->order_by("id", "desc")->count_all_results();
        return $count;
    }
    public function countUnread($for_user_type, $for_user_id){
        $this->db->where('for_user_type', $for_user_type);
        $this->db->where('for_user_id', $for_user_id);
        $this->db->where('is_read', 0);
        $count = $this->db->select('*')->from('notifications')->order_by("id", "desc")->count_all_results();
        return $count;
    }
    public function supervisorRead($for_user_id){        
        return $this->read(1,$for_user_id);
    }
    public function adminRead($for_user_id){        
        return $this->read(3,$for_user_id);
    }
    public function memberRead($for_user_id){
        return $this->read(2,$for_user_id);
    }
    public function supervisorCount($for_user_id){
        return $this->count(1, $for_user_id);
    }
    public function supervisorCountRead($for_user_id){
        return $this->countRead(1, $for_user_id);
    }
    public function supervisorCountUnread($for_user_id){
        return $this->countUnread(1, $for_user_id);
    }
    public function memberCount($for_user_id){
        return $this->count(2, $for_user_id);
    }
    public function memberCountRead($for_user_id){
        return $this->countRead(2, $for_user_id);
    }
    public function memberCountUnread($for_user_id){
        return $this->countUnread(2, $for_user_id);
    }
    public function adminCount($for_user_id){
        return $this->count(3, $for_user_id);
    }
    public function adminCountRead($for_user_id){
        return $this->countRead(3, $for_user_id);
    }
    public function adminCountUnread($for_user_id){
        return $this->countUnread(3, $for_user_id);
    }
    public function updateReadStatus($id){
        $data = array(
            'is_read'          => 1
        );
        $where = array('id' => $id);
        $this->db->limit(1);
		$this->db->where('id', $id);
		$upd = $this->db->update('notifications', $data);
        if(isset($upd)){
            return true;
        }
        else{
            return false;
        }
    }
    public function find($id){
        $this->db->where('id', $id);
		$retrieved = $this->db->select('*')->from('notifications')->order_by("id", "desc")->get()->custom_row_object(0,'notifications');
        return $retrieved;
    } 
    public function loadEntity($id){
        //echo '<pre>'. print_r($this->find($id)); exit;
        $this->ref_id =  $this->find($id)->getRefID();
        $this->lookupTable = $this->find($id)->getLookupTable();
        $this->alert_type = $this->find($id)->getAlertType();
        $data = array(
            'is_read' => 1
        );
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->update('notifications', $data);
        //echo '<pre>'. print_r($this->db->last_query()); exit;
        $this->db->where('id', $this->ref_id);
        $refe = $this->db->get($this->lookupTable)->result_array();
        return $refe;
    }
    public function supervisor($ref_id, $user_id, $function){
        $this->db->where('id', $ref_id);
        $lookup = $this->db->get($this->getLookupTable())->result_array();
        if($this->getAlertType() == 4){
            $this->user_id = $lookup[0]['supervisor_id'];
            $toolplaza_id = $lookup[0]['toolplaza_id'];
            $entity_date = date("d, F, Y",strtotime($lookup[0]['datecreated']));
        }
        else if($this->getAlertType() == 3){
            $this->user_id = $lookup[0]['user_id'];
            $toolplaza_id = $lookup[0]['toolplaza'];
            $entity_date = date("d, F, Y",strtotime($lookup[0]['for_date']));
        }
        else if($this->getAlertType() == 2){
            $this->user_id = $lookup[0]['user_id'];
            $toolplaza_id = $lookup[0]['toolplaza'];
            $entity_date = date("F, Y",strtotime($lookup[0]['for_month']));
        }
        $this->db->where('id',$this->user_id);
		$supervisor = $this->db->get('tpsupervisor')->result_array();
		$tollplaza =$this->db->get_where('toolplaza',array('id'=>$toolplaza_id,'status'=>1))->result_array();
        
        
		$notification_msg =  $tollplaza[0]['name']." ". $entity_date .' '.$this->name.' '.$function.'d';
        $date = date("Y-m-d H:i:s");
        $this->create($this->alert_type, $ref_id, $date, 1, $user_id, 3, 1, $notification_msg, 0);
    }
    public function admin($ref_id, $user_id, $function){
        $this->db->where('id',$ref_id);
		$lookup = $this->db->get($this->getLookupTable())->result_array();
        if($this->getAlertType() == 4){
            $this->for_user_id = $lookup[0]['supervisor_id'];
            $toolplaza_id = $lookup[0]['toolplaza_id'];
            $entity_date = date("d, F, Y",strtotime($lookup[0]['datecreated']));
        }
        else if($this->getAlertType() == 3){
            $this->for_user_id = $lookup[0]['user_id'];
            $toolplaza_id = $lookup[0]['toolplaza'];
            $entity_date = date("d, F, Y",strtotime($lookup[0]['for_date']));
        }
        else if($this->getAlertType() == 2){
            $this->for_user_id = $lookup[0]['user_id'];
            $toolplaza_id = $lookup[0]['toolplaza'];
            $entity_date = date("F, Y",strtotime($lookup[0]['for_month']));
        }
        
		$tollplaza =$this->db->get_where('toolplaza',array('id'=>$toolplaza_id,'status'=>1))->result_array();
		$notification_msg =  $tollplaza[0]['name']." ". $entity_date .' '.$this->name.' '.$function.'d';
        $date = date("Y-m-d H:i:s");
        $this->create($this->alert_type, $ref_id, $date, 3, $user_id, 1, $this->for_user_id, $notification_msg, 0);
    }
}