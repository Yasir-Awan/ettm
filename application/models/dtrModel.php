<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class dtrModel extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    private $id;
    private $upload_type;
    private $user_id;
    private $toolplaza;    
    private $omc;    
    private $description;
    private $notes;
    private $class1;
    private $class2;
    private $class3;
    private $class4;
    private $class5;
    private $class6;
    private $class7;
    private $class8;
    private $class9;
    private $class10;
    private $total;
    private $for_date;
    private $status;
    private $state;
    private $adddate;
    private $toll_delay;
    private $actiondate;
    private $reason;
    private $file;
    private $user;
    private $toolplazaName;
    private $omcName;
    private $supportDocument;
    private $htmlclass;

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
    public function setUploadType($upload_type){
        $this->upload_type = $upload_type;
    }
    public function getUploadType(){
        return $this->upload_type;
    }
    public function setUserID($user_id){
        $this->user_id = $user_id;
    }
    public function getUserID(){
        return $this->user_id;
    }
    public function setUser($userfirstname, $userlastname){
        $this->user = $userfirstname.' '.$userlastname;
    }
    public function getUser(){
        return $this->user;
    }
    public function setToolplaza($toolplaza){
        $this->toolplaza = $toolplaza;
    }
    public function getToolplaza(){
        return $this->toolplaza;
    }
    public function setToolplazaName($toolplazaName){
        $this->toolplazaName = $toolplazaName;
    }
    public function getToolplazaName(){
        return $this->toolplazaName;
    }
    public function setOmc($omc){
        $this->omc = $omc;
    }
    public function getOmc(){
        return $this->omc;
    }
    public function setOmcName($omcName){
        $this->omcName = $omcName;
    }
    public function getOmcName(){
        return $this->omcName;
    }
    public function setDescription($description){
        $this->description = $description;
    }
    public function getDescription(){
        return $this->description;
    }
    public function setNotes($notes){
        $this->notes = $notes;
    }
    public function getNotes(){
        return $this->notes;
    }
    public function setClass1($class1){
        $this->class1 = $class1;
    }
    public function getClass1(){
        return $this->class1;
    }
    public function setClass2($class2){
        $this->class2 = $class2;
    }
    public function getClass2(){
        return $this->class2;
    }
    public function setClass3($class3){
        $this->class3 = $class3;
    }
    public function getClass3(){
        return $this->class3;
    }
    public function setClass4($class4){
        $this->class4 = $class4;
    }
    public function getClass4(){
        return $this->class4;
    }
    public function setClass5($class5){
        $this->class5 = $class5;
    }
    public function getClass5(){
        return $this->class5;
    }
    public function setClass6($class6){
        $this->class6 = $class6;
    }
    public function getClass6(){
        return $this->class6;
    }
    public function setClass7($class7){
        $this->class7 = $class7;
    }
    public function getClass7(){
        return $this->class7;
    }
    public function setClass8($class8){
        $this->class8 = $class8;
    }
    public function getClass8(){
        return $this->class8;
    }
    public function setClass9($class9){
        $this->class9 = $class9;
    }
    public function getClass9(){
        return $this->class9;
    }
    public function setClass10($class10){
        $this->class10 = $class10;
    }
    public function getClass10(){
        return $this->class10;
    }
    public function setTotal($total){
        $this->total = $total;
    }
    public function getTotal(){
        return $this->total;
    }
    public function setForDate($for_date){
        $this->for_date = $for_date;
    }
    public function getForDate(){
        return $this->for_date;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setState($state){
        $this->state = $state;
    }
    public function getState(){
        return $this->state;
    }
    public function setAddDate($adddate){
        $this->adddate = $adddate;
    }
    public function getAddDate(){
        return $this->adddate;
    }
    public function setTollDelay($toll_delay){
        $this->toll_delay = $toll_delay;
    }
    public function getTollDelay(){
        return $this->toll_delay;
    }
    public function setActionDate($actiondate){
        $this->actiondate = $actiondate;
    }
    public function getActionDate(){
        return $this->actiondate;
    }
    public function setReason($reason){
        $this->reason = $reason;
    }
    public function getReason(){
        return $this->reason;
    }
    public function setFile($file){
        $this->file = $file;
    }
    public function getFile(){
        return $this->file;
    }
    public function setSupportDocument($document){
        $this->supportDocument = $document;
    }
    public function getSupportDocument(){
        return $this->supportDocument;
    }
    public function setHtmlClass($htmlclass){
        $this->htmlclass = $htmlclass;
    }
    public function getHtmlClass(){
        return $this->htmlclass;
    }
    public function setClasses($class1, $class2, $class3, $class4, $class5, $class6, $class7, $class8, $class9, $class10){
        $this->setClass1($class1);
        $this->setClass2($class2);
        $this->setClass3($class3);
        $this->setClass4($class4);
        $this->setClass5($class5);
        $this->setClass6($class6);
        $this->setClass7($class7);
        $this->setClass8($class8);
        $this->setClass9($class9);
        $this->setClass10($class10);
    }
    public function set($id, $upload_type, $user_id, $toolplaza, $omc, $total, $for_date, $status, $adddate, $toll_delay, $actiondate, $reason, $file, $supportDocument){
        $this->setId($id);
        $this->setUploadType($upload_type);
        $this->setUserID($user_id);
        $this->setToolplaza($toolplaza);
        $this->setOmc($omc);
        $this->setTotal($total);
        $this->setForDate($for_date);
        $this->setStatus($status);
        $this->setAddDate($adddate);
        $this->setTollDelay($toll_delay);
        $this->setActionDate($actiondate);
        $this->setReason($reason);
        $this->setFile($file);
        $this->setSupportDocument($supportDocument);
    }
    public function get(){
        return $this;
    }
    public function toolGet(){
        
        $Toolplaza = $this->load->model('toolplazaModel');
		$Toolplaza = new toolplazaModel();
		$Toolplaza = $Toolplaza->find($this->getToolplaza());
        $this->setToolPlazaName($Toolplaza->getName());
        unset($Toolplaza);
    }
    public function userGet(){
        if($this->getUploadType() == 1){
                $user = $this->load->model('tpsupervisorModel');
			    $user = new tpsupervisorModel();	
                $user = $user->find($this->getUserID(), $this->getToolplaza());
            }
            elseif($this->getUploadType() == 2){
                $user = $this->load->model('memberModel');
			    $user = new memberModel();	
                $user = $user->find($this->getUserID());		    
            }            
            $this->setUser($user->getFirstName(), $user->getLastName());
            unset($user);

    }
    public function omcGet(){
            $Omc = $this->load->model('omcModel');
            $Omc = new omcModel();
            $Omc = $Omc->find($this->getOmc());
            $this->setOmcName($Omc->getName());
            unset($Omc);
    }
    public function supportDocumentGet(){
            $supportDocument = $this->load->model('dtrSupportingDocument');
            $supportDocument = new dtrSupportingDocument();              
            $supportDocument = $supportDocument->find($this->getId());            
            $this->setSupportDocument($supportDocument);
            unset($supportDocument);
    }
    public function setStateAndClass(){
        if($this->getStatus() == 0){
                $this->setState('Pending');
                $this->setHtmlClass('badge-primary');
            }
            elseif($this->getStatus() == 1){
                $this->setState('Approved');
                $this->setHtmlClass('badge-success');
            }
            elseif($this->getStatus() == 2){
                $this->setState('Rejected');
                $this->setHtmlClass('badge-danger');
            }
    }
    public function getAll(){
        $Dtrs = $this->db->select('*')->from('dtr')->order_by("id", "desc")->get()->custom_result_object('dtrModel');
        //echo '<pre>'; echo print_r($viewDtrList);exit;
        foreach($Dtrs as $Dtr){      
            $Dtr->toolGet();
            $Dtr->userGet();           
            $Dtr->omcGet(); 
            $Dtr->setStateAndClass();
            $Dtr->supportDocumentGet();         
            //echo '<pre>';print_r($Dtr);echo '</pre>' ;  
        } 
        //exit;      
        return $Dtrs;
    }
    public function getByUserId($user_id){
        $this->db->where('user_id', $user_id);      
        $Dtrs = $this->getAll();
        return $Dtrs;
    }
    public function getByUserIdAndTollplaza($user_id, $toll){
        if(isset($user_id)){
            $this->db->where('user_id', $user_id); 
        }              
        $Dtrs = $this->getByTollplaza($toll);
        return $Dtrs;        
    }
    public function find($id){
        $this->db->where('id', $id);
        $Dtrs = $this->getAll();
        return $Dtrs;
    }
    public function getByTollplaza($toll){
        $this->db->where('toolplaza', $toll);          
        $Dtrs = $this->getAll();
        return $Dtrs;
    }
    public function getByUserIdAndTollplazaLimited($user_id, $toll, $limit){
        $this->db->limit($limit);       
        $Dtrs = $this->getByUserIdAndTollplaza($user_id, $toll);
        return $Dtrs;        
    }
    public function getCountAll(){
        return $this->db->select('count(*) as count')->from('dtr')->order_by("id", "desc")->get()->result_object();
    }
    public function getByLimit($limit = false){
        $this->db->limit($limit);      
        $Dtrs = $this->getAll();
        return $Dtrs;
    }
    public function getLimitedList($user_id, $toll, $limit){
		$this->db->limit($limit);
		if($user_id && $toll){
			$this->db->where('toolplaza', $toll);
			$this->db->where('user_id', $id);
		}
		if($toll){
			$this->db->where('toolplaza', $toll);
		}
		$Dtrs = $this->getAll();
		
		return $Dtrs; 
    }
}