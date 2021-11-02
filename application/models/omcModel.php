<?php 
defined('BASEPATH') OR exit('No direct access allowed');

class omcModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    private $id;
    private $name;
    private $username;
    private $password;
    private $site;
    private $status;
    private $date;

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
    public function setUsername($username){
        $this->username = $username;
    }
    public function getUsername(){
        return $this->username;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setSite($site){
        $this->site = $site;
    }
    public function getSite(){
        return $this->site;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setDate($date){
        $this->date = $date;
    }
    public function getDate(){
        return $this->date;
    }
    public function set($id, $name, $username, $password, $site, $status, $date){
        $this->setId($id);
        $this->setName($name);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setSite($site);
        $this->setStatus($status);
        $this->setDate($date);
    }
    public function get(){
        return $this;
    }
    public function getAll(){
        return $this->db->select('*')->from('omc')->order_by("id", "asc")->get()->custom_result_object('omcModel');       
    }
    public function find($id){
        $this->db->where('id', $id);
        return $this->db->select('*')->from('omc')->get()->custom_row_object(0, 'omcModel');
    }
}