<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class dtrSupportingDocument extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    private $id;
    private $dtr_id;
    private $name;
    private $path;
    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
    public function setDtrId($dtr_id){
        $this->dtr_id = $dtr_id;
    }
    public function getDtrId(){
        return $this->dtr_id;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }
    public function setPath($path){
        $this->path = $path;
    }
    public function getPath(){
        return $this->path;
    }
    public function set($id, $dtr_id, $name, $path){
        $this->setId($id);
        $this->setDtrId($dtr_id);
        $this->setName($name);
        $this->setPath($path);
    }
    public function get(){
        return $this;
    }
    public function getAll(){
        return $this->db->select('*')->from('dtr_supporting_document')->order_by("id", "desc")->get()->custom_result_object('dtrSupportingDocument');
    }
    public function find($id){
        $this->db->where('dtr_id', $id);
        return $this->db->select('*')->from('dtr_supporting_document')->get()->custom_row_object(0, 'dtrSupportingDocument');
    }
}