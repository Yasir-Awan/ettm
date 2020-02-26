<?php
defined('BASEPATH') OR exit('NO DIRECT SCRIPT ALLOWED');
class Admin_crash extends CI_Controller{

    public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->page_data = array();
	}
    function index()
    {
      // $this->load->view('back/includes/header', $this->page_data);
      // $this->load->view('back/inventory/first_page', $this->page_data);
      // $this->load->view('back/includes/footer', $this->page_data);
      $this->page_data['page_url'] = current_url();
      $this->page_data['page'] = 'crash_data'; 
      $this->db->order_by('id','DESC');
      $this->page_data['cd']  = $this->db->get('crash_data')->result_array();
      $this->load->view('road_crash/back/accidentdata', $this->page_data);
    }


    public function crash_data($para1 = '', $para2 = '', $para3 = ''){
      if(!$this->session->userdata('adminid')){
        
        return redirect('admin/login');
  
      }
      if($para1 == 'list'){
        $this->db->order_by('id','DESC');
        $this->page_data['cd']  = $this->db->get('crash_data')->result_array();
        $this->load->view('road_crash/back/accidentdata', $this->page_data);
      }
      elseif($para1 == 'delete'){
        $this->db->where('id',$para2);
        $record = $this->db->get('crash_data');
        if($record->result_array()){
          $support = $this->db->get_where('crash_images',array('crash_id' => $para2))->result_array();
          if($support){
            foreach($support as $val){
              unlink('./crash_photos/temp/'.$val['path']);
            }
            $this->db->where('crash_id', $para2);
            $this->db->delete('crash_images');
          }
          $files = $this->db->get_where('crash_images',array('id' => $para2))->result_array();
          foreach($files as $file){
            unlink('./crash_photos/temp/'.$file);
          }
          
          $this->db->where('id', $para2);
          $this->db->delete('crash_data');
        }
      }
      else{
        $this->page_data['page'] = 'crash_data';
        $this->db->order_by('id','DESC');
        $this->page_data['cd']  = $this->db->get('crash_data')->result_array();

        $this->load->view('road_crash/back/first_page', $this->page_data);
      }
    }

    public function accident_detail($para1 = ''){
	    $this->page_data['detail'] = $this->db->get_where('crash_data',array('id' => $para1 ))->result_array();
	     
		// $month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		// $start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		// $end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];

		// $sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		// $this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		
		//echo $this->db->last_quer`y();
		//echo "<pre>";
		//print_r($this->page_data['terrif']); exit;
		$this->load->view('road_crash/back/details', $this->page_data);
  }
  
  public function view_attachment($para1 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		$this->page_data['photos'] = $this->db->get_where('crash_images',array('crash_id' => $para1))->result_array();
		$this->load->view('road_crash/back/crash_attachment', $this->page_data);

	}

    function display_datatable()
    {
        $this->db->order_by('id','DESC');
			$this->page_data['data']  = $this->db->get('crash_data')->result_array();
			$this->load->view('back/datatable', $this->page_data);
      
        
    }
    public function view_supporting($para1 = '')
    {	
		$this->page_data['support'] = $this->db->get_where('supporting_document',array('mtr_id' => $para1))->result_array();
		$this->load->view('back/suppporting_list', $this->page_data);
    }
    
    public function monthly_traffic_report($para1 = ''){
            // here we write code to get only text & all text data of an accident from database
		$this->load->view('back/invoice', $this->page_data);
	}
}
?>