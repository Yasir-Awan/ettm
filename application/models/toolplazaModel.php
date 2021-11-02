<?php 
defined('BASEPATH') OR exit('No direct access is allowed');

class toolplazaModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    private $id;
    private $name;
    private $google_map_status;
    private $status;
    private $omc;
    private $incharge_id;
    
    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }
    public function setGoogleMapStatus($google_map_status){
        $this->google_map_status = $google_map_status;
    }
    public function getGoogleMapStatus(){
        return $this->google_map_status;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setOmc($omc){
        $this->omc = $omc;
    }
    public function getOmc(){
        return $this->omc;
    }
    public function setInchargeId($incharge_id){
        $this->incharge_id = $incharge_id;
    }
    public function getInchargeId(){
        return $this->incharge_id;
    }
    public function set($id, $name, $google_map_status, $status, $omc, $incharge_id){
        $this->setId($id);
        $this->setName($name);
        $this->setGoogleMapStatus($google_map_status);
        $this->setStatus($status);
        $this->setOmc($omc);
        $this->setInchargeId($incharge_id);
    }
    public function get(){
        return $this;
    }
    public function getAll(){
        $this->db->where('status', 1);
        return $this->db->select('*')->from('toolplaza')->order_by("id", "asc")->get()->custom_result_object('toolplazaModel');       
    }
    public function find($id){
        $this->db->where('id', $id);
        return $this->db->select('*')->from('toolplaza')->get()->custom_row_object(0, 'toolplazaModel');
        //echo '<pre>';echo print_r($this->db->select('*')->from('toolplaza')->get()->result_array()); //->custom_row_object(0,'toolplazaModel');
    }
}