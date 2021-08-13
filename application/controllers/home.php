<?php 
defined('BASEPATH') OR EXIT('NO DIRECT SCRIPT ALLOWED');

class Home extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->page_data = array();
	}

	public function index()
	{
		/*  $dir = "\\\\192.168.67.57\\daw300nt\\data\\27022019.inf";

          
        $data = file_get_contents($dir);

        $skuList = explode(',', $data);
        $sk = array_chunk($skuList, 13);
        echo "<pre>";
        print_r($sk); exit;
        unset($skuList[0]);
        foreach($skuList as $key => $value){
           $array[] = explode(';', $value); 
        }
        echo "<pre>";
        print_r($array); exit;*/

		$this->load->view('front/index' , $this->page_data);
	}

	public function member_login(){

		$safe = 'yes';
        $char = '';
        foreach($_POST as $k=>$row){
            if (preg_match('/[\'^":()}{#~><>|=¬]/', $row,$match))
            {
                
                    $safe = 'no';
                    $char = $match[0];
                
            }
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username' , 'trim|required');
        $this->form_validation->set_rules('password', 'Password' , 'trim|required');
	
        if($this->form_validation->run() == FALSE){

        	echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
        }else{

        	if($safe == 'yes'){
        		$username = $this->input->post('username');
        		$password = $this->input->post('password');
        		$member  = $this->db->get_where('member', array('username' => $username, 'password' => sha1($password)))->result_array();
        		if($member){
        			if($member[0]['status'] == 0){
        				echo json_encode(array('response'=>FALSE, 'message'=>'Your account is not active please contact administrator')); exit;
        			}else{
        				$this->session->set_userdata('member_id', $member[0]['id']);
						$this->session->set_userdata('member_name', $member[0]['fname'] .' '.$member[0]['lname']);
						$this->session->set_userdata('site', $member[0]['site']);

        				echo json_encode(array('response' => TRUE , 'message' => 'Successful Login' , 'is_redirect' => TRUE , 'redirect_url' => base_url().'member'));
        			}

        		}else{
        			echo json_encode(array('response'=>FALSE, 'message'=>'Invalid Username or wrong password')); exit;
        		}
        	}else{
        		echo json_encode(array('response'=>FALSE, 'message'=>'Disallowed charecter : " '.$char.' " in the POST')); exit;
        	}
        }
	}


	public function toolplaza_login(){
		$safe = 'yes';
        $char = '';
        foreach($_POST as $k=>$row){
            if (preg_match('/[\'^":()}{#~><>|=¬]/', $row,$match))
            {
                
                    $safe = 'no';
                    $char = $match[0];
                
            }
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username' , 'trim|required');
        $this->form_validation->set_rules('password', 'Password' , 'trim|required');
	
        if($this->form_validation->run() == FALSE){

        	echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
        }else{

        	if($safe == 'yes'){
        		$username = $this->input->post('username');
        		$password = $this->input->post('password');
        		$supervisor  = $this->db->get_where('tpsupervisor', array('username' => $username, 'password' => sha1($password)))->result_array();
        		if($supervisor){
        			if($supervisor[0]['status'] == 0){
        				echo json_encode(array('response'=>FALSE, 'message'=>'Your account is not active please contact administrator')); exit;
        			}else{
        				$this->session->set_userdata('supervisor_id', $supervisor[0]['id']);
						$this->session->set_userdata('toolplaza', $supervisor[0]['tollplaza']);
						$this->session->set_userdata('site', $supervisor[0]['site']);
        				$this->session->set_userdata('supervisor_name', $supervisor[0]['fname'] .' '.$supervisor[0]['lname']);
        				echo json_encode(array('response' => TRUE , 'message' => 'Successful Login' , 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza'));
        			}

        		}else{
        			echo json_encode(array('response'=>FALSE, 'message'=>'Invalid Username or wrong password')); exit;
        		}
        	}else{
        		echo json_encode(array('response'=>FALSE, 'message'=>'Disallowed charecter : " '.$char.' " in the POST')); exit;
        	}
        }

	}
}

?>