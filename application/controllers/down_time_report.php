<?php
defined('BASEPATH') OR exit('NO direct script is allowed');
class Down_time_report extends CI_Controller
{
    public function __construct()
	{
		parent::__construct();

		$this->load->model('Admin_model');

		$this->page_data = array();
		$this->page_data['css'] = '';
		$this->page_data['js'] = '';

		$this->page_data['page_url'] = current_url();
		$this->page_data['custom'] = '';
		
		// $this->load->model('Admin_model');

		// $this->load->model('dsr_model');
		// //echo date("F j, Y, h:i:s A", 1591315200); exit;
		// $this->load->model('database_model'); 
		// $this->load->model('calculation_model');
		$this->load->model('nha');
		// $this->page_data['key'] = $this->db->get_where('settings',array('type' => 'google_map_api_key'))->row()->value;
	
	}


    public function index($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			return redirect('admin/login');
		}		
			// echo "Hi yasir"; exit;
			// $data = $this->Admin_model->get_weighstations_dates($weighstation);
	
				// $this->page_data['dates'] = $data;
				$this->page_data['weighs'] = $this->db->get_where('weighstation',array('status' => 1))->result_array();
				// $this->page_data['weighstation'] = $this->Admin_model->get_weighstation_daily_report($weighstation);
					//  echo "<pre>";
				//  print_r($this->page_data['weighs']); exit;
				$this->page_data['category'] = $this->db->get('weigh_category')->result_array();

			$this->page_data['page'] = 'downtime_report';
			$this->load->view('back/downtime_report_view', $this->page_data);	
	}

	public function weighstation_dates($para1='', $para2='', $para3=''){
		if(!$this->session->userdata('adminid')){
			return redirect('admin/login');
		}
		$weighstation = $para1;
			$this->page_data['weigh'] = $weighstation;
			$data = $this->Admin_model->get_weighstations_dates($weighstation);
			echo json_encode($data);	
	}

	public function system_status($para1='',$para2='',$para3=''){

		if($para1 == 'post'){
			$weighstation = $this->input->post('weigh');
			$date = str_replace('/','-', $this->input->post('day'));
			$queryData = $this->db->select('*')->where('weigh_id',$weighstation)->like('date', $date)->order_by('id','asc')->get('weighstation_logs')->result_array();
			$this->page_data['category'] = $this->db->get('weigh_category')->result_array();

			$maxVal = count($queryData);
			$index= -1;
			$systemStatus = array();
			foreach($queryData as $key => $row){
				if($row['status']==0 && $key==0){
					$systemStatus[] = $row;
				}
				if($index > -1){
					if($queryData[$index]['status']==0 ){
						if($row['status']==1 ){
						$systemStatus[] = $row;
						}
					}
					if($queryData[$index]['status']==1 ){
						if($row['status']==0 ){
						$systemStatus[] = $row;
						}
					}
					if($queryData[$index]['status']==2 ){
						if($row['status']==0||$row['status']==1){
						$systemStatus[] = $row;
						}
					}
				}
				$index++;
			}

			$exactData = array();
			$nextIndex = 1;
			
			$time = array();
			foreach($systemStatus as $key => $row){	$time[] =	explode(" ",$row['date']);	}
			$maxIndex =	count($systemStatus);
			
			foreach($time as $key=>$row){
				$dates = $row[0];
				$start_time = $row[1];
				if($nextIndex == $maxIndex ){
					$end_time = $time[--$nextIndex][1];
				}else{
					$end_time = $time[$nextIndex][1];
				}
				$date_a = new DateTime($start_time);
				$date_b = new DateTime($end_time);
				$interval = date_diff($date_a,$date_b);
				$timeGapValue = $interval->format('%h:%i:%s'); 
				$exactVal = explode(":",$timeGapValue);
				if($exactVal[1] > 30 || $exactVal[0] >= 1 )
				{
					if($exactVal[0] >= 1){
						$weighData[] = $this->db->select('*')->where('weigh_id',$weighstation)->where('date', $dates)->where('time>', $start_time)->where('time<', $end_time)->order_by('id','asc')->count_all_results('weighstation_data');
						if(!isset($weighData)){	$exactData[] = $systemStatus[$key]; }
					}
					else{
						$weighData[] = $this->db->select('*')->where('weigh_id',$weighstation)->where('date', $dates)->where('time>', $start_time)->where('time<', $end_time)->order_by('id','asc')->count_all_results('weighstation_data');
						if(!isset($weighData)){	$exactData[] = $systemStatus[$key]; }
					}
				}
				$nextIndex++;
			}
			// echo "<pre>"; print_r($timeGapValue); exit;
			// echo "<pre>"; print_r($weighData);
			echo "<pre>"; print_r($time);
			echo "<pre>"; print_r($exactData);
			// echo "<pre>"; print_r($systemStatus);
			exit;
			$this->page_data['weighstation'] = $queryData;
			$this->page_data['weigh'] = $weighstation;
			$this->page_data['date'] = $date;
			$this->load->view('back/weighstation_daily_report_search', $this->page_data);	
		}	
	}
}
?>