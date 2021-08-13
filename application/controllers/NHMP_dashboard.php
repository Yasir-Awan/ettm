<?php 
defined('BASEPATH') OR exit('NO direct script is allowed');
class NHMP_dashboard extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();
		$this->page_data = array();
		$this->page_data['page_url'] = current_url();
		$this->page_data['custom'] = '';
		$this->load->model('Admin_model');
		$this->load->model('nha');
		$this->page_data['key'] = $this->db->get_where('settings',array('type' => 'google_map_api_key'))->row()->value;
    }
    /*Author: YASIR 
	Function name: NHMPdasboard
	Function: Its the main function that displays dashboardNHMP
	Date Creation: 01/02/2021
	Optimized Date: NOT NOW*/
	public function index(){
		if(!$this->session->userdata('adminid')==22)
		{	
			return redirect('admin/login');
        }

		$records = $this->Admin_model->nhmp($month);
		$mtr = array();
		$mtrid = array();
		$plazaid = array();
		$month = array();
		$traffic = array();
		$revenue = array();
		// echo "<pre>"; print_r($records); exit;
		$index = 0;
		foreach($records['chart'] as $data){
			// echo "<pre>"; print_r($data); exit;
		$previous_year = date("Y-m-d",strtotime(@$data['month'].' -1 year'));
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['month'] ) ) . "-1 month" ) );
		$pre_year_data = $this->Admin_model->get_chart_by( @$data['toolplaza_id'], $previous_year);
		$pre_month_data = $this->Admin_model->get_chart_by( @$data['toolplaza_id'], $previous_monthDate);
		
		$mtr[] = $this->db->get_where('mtr',array('id' => $data['mtr_id'] ))->result_array();
		// echo "<pre>"; print_r($mtr); exit;
	    $month_year = explode('-',$mtr[0][0]['for_month']);
		//echo "<pre>";
		//print_r($month_year); exit;
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$mtr[0][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$mtr[0][0]['end_date'];
        $sql = "Select * From terrif Where FIND_IN_SET (".$mtr[0][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] = $this->db->query($sql)->result_array();
		
		$this->page_data['mtrid'] = $data['mtr_id'];
		$this->page_data['plaza_id'] = $data['toolplaza_id'];
		$this->page_data['month'] = $data['month'];
				
		$this->page_data['charts'] = $records['chart'];

		$this->page_data['revenue'] = $records['revenue'];
		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_year_chart'] = $pre_year_data['chart'];
		$this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];
		$index++;
		}
		// echo "<pre>"; print_r($mtr); exit;
		$this->page_data['mtr'] = $mtr;
		// echo "<pre>"; print_r($this->page_data); exit;
		$this->page_data['page'] = 'NHMP Dashboard';
		$this->load->view('back/nhmp_dashboard',$this->page_data);
	}
	public function logout(){

		$this->session->sess_destroy();
		redirect(base_url().'admin','refresh');
	}
	public function searchformonth($para1 = ''){

		$month  = $this->input->post('fornhmpmonth');
		$records = $this->Admin_model->nhmp($month);
		
		$mtr = array();
		$mtrid = array();
		$plazaid = array();
		$month = array();
		$traffic = array();
		$revenue = array();
		// echo "<pre>"; print_r($records); exit;
		$index = 0;
		foreach($records['chart'] as $data){
			// echo "<pre>"; print_r($data); exit;
		$previous_year = date("Y-m-d",strtotime(@$data['month'].' -1 year'));
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['month'] ) ) . "-1 month" ) );
		$pre_year_data = $this->Admin_model->get_chart_by( @$data['toolplaza_id'], $previous_year);
		$pre_month_data = $this->Admin_model->get_chart_by( @$data['toolplaza_id'], $previous_monthDate);
		
		$mtr[] = $this->db->get_where('mtr',array('id' => $data['mtr_id'] ))->result_array();
		// echo "<pre>"; print_r($mtr); exit;
	    $month_year = explode('-',$mtr[0][0]['for_month']);
		//echo "<pre>";
		//print_r($month_year); exit;
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$mtr[0][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$mtr[0][0]['end_date'];
        $sql = "Select * From terrif Where FIND_IN_SET (".$mtr[0][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] = $this->db->query($sql)->result_array();
		
		$this->page_data['mtrid'] = $data['mtr_id'];
		$this->page_data['plaza_id'] = $data['toolplaza_id'];
		$this->page_data['month'] = $data['month'];
				
		$this->page_data['charts'] = $records['chart'];

		$this->page_data['revenue'] = $records['revenue'];
		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_year_chart'] = $pre_year_data['chart'];
		$this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];
		$index++;
		}
		// echo "<pre>"; print_r($mtr); exit;
		$this->page_data['mtr'] = $mtr;
		// echo "<pre>"; print_r($this->page_data); exit;
		$this->page_data['page'] = 'NHMP Dashboard';
		$this->load->view('back/nhmp_formonth_dashboard',$this->page_data);
	}
}
?>