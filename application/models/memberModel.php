<?php 
defined('BASEPATH') OR exit('No direct access allowed');

class memberModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    private $id;
    private $site;
    private $tsp;
    private $fname;
    private $lname;
    private $username;
    private $password;
    private $contact;
    private $adddate;
    private $status;

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
    public function setFirstName($fname){
        $this->fname = $fname;
    }
    public function getFirstName(){
        return $this->fname;
    }
    public function setLastName($lname){
        $this->lname = $lname;
    }
    public function getLastName(){
        return $this->lname;
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
    public function setTsp($tsp){
        $this->tsp = $tsp;
    }
    public function getTsp(){
        return $this->tsp;
    }
    public function setContact($contact){
        $this->contact = $contact;
    }
    public function getContact(){
        return $this->contact;
    }
    public function setAddDate($adddate){
        $this->adddate = $adddate;
    }
    public function getAddDate(){
        return $this->adddate;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function getStatus(){
        return $this->status;
    }
    public function set($id,$site,$tsp,$fname,$lname,$username,$password,$contact,$adddate,$status){
        $this->setId($id);
        $this->setSite($site);
        $this->setTsp($tsp);
        $this->setFirstName($fname);
        $this->setLastName($lname);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setContact($contact);
        $this->setAddDate($adddate);
        $this->setStatus($status);
    }
    public function get(){
        return $this;
    }
    public function getAll(){
        return $this->db->select('*')->from('member')->order_by("id", "asc")->get()->custom_result_object('memberModel');       
    }
    public function find($id){
        $this->db->where('id', $id);
        return $this->db->select('*')->from('member')->get()->custom_row_object(0, 'memberModel');
    }
}
    
    