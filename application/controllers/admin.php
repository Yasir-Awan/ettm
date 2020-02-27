<?php 
defined('BASEPATH') OR exit('NO direct script is allowed');
class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->page_data = array();
		$this->page_data['page_url'] = current_url();
		$this->page_data['custom'] = '';
		$this->load->model('Admin_model');
		$this->load->model('dsr_model');
		$this->load->model('database_model'); 
		$this->load->model('calculation_model');
		$this->load->model('nha');
		$this->page_data['key'] = $this->db->get_where('settings',array('type' => 'google_map_api_key'))->row()->value;
	
	}

	public function index(){
		if(!$this->session->userdata('adminid'))
		{	
			return redirect('admin/login');
		}
		$data = $this->Admin_model->chartdata();

		// $this->load->model('General');
	 	// $this->General->notifications();
		$previous_year = date("Y-m-d",strtotime(@$data['chart']['month'].' -1 year'));
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
		$pre_year_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_year);
		$pre_month_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_monthDate);
		
		$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $data['mtr_id'] ))->result_array();
	    $month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		//echo "<pre>";
		//print_r($month_year); exit;
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];
        $sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] = $this->db->query($sql)->result_array();
		
		$this->page_data['mtrid'] = $data['mtr_id'];
		$this->page_data['plaza_id'] = $data['chart']['toolplaza_id'];
		$this->page_data['month'] = $data['chart']['month'];


		$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->page_data['chart'] = $data['chart'];

		$this->page_data['revenue'] = $data['revenue'];
		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_year_chart'] = $pre_year_data['chart'];
        $this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];
		$this->page_data['page'] = 'Dashboard';
		
		$this->load->view('back/dashboard', $this->page_data);
	}
	public function dashboard(){
		if(!$this->session->userdata('adminid')){	
			return redirect('admin/login');
		}
		$id = 'today';
		//Queries Section 
		$querydsr = 'SELECT * FROM dsr_updated WHERE DATE(datecreated) = DATE(NOW()) AND status = 1 ORDER BY ID DESC';
		$monthlydsr = 'SELECT * FROM dsr_updated WHERE DATE(datecreated) = DATE(NOW()) AND status = 1 ORDER BY ID DESC';
		$querydtr = 'SELECT * FROM dtr WHERE DATE(for_date) = DATE(NOW()-INTERVAL 1 DAY) AND status = 1 ORDER BY ID DESC';
		
		//Query on database section 
		$dsrmonth = $this->database_model->query($querydsr);
		$dtrmonth = $this->database_model->query($querydtr);
		
		//loading table from database
		$table = 'dsr_updated'; $where = array('');
		$dsrtool = $this->database_model->get_where($table, $where);
		$table = 'toolplaza'; $where = array('status' => '1');
		$tolplaza = $this->database_model->get_where($table, $where);
		
		//displaying database arrays
		$dsr = $dsrmonth->result_array();
		$dtr = $dtrmonth->result_array();
		
		//Counting database arrays
		$dsr_count = $dsrmonth->num_rows();
		$dtr_count = $dtrmonth->num_rows();
		$toolplaza = $tolplaza->num_rows();
		
		
		$today = date("d");
		$toolplaza_all = $toolplaza;
		$toolplaza_dsr = $toolplaza_all - $dsr_count;
		$toolplaza_dtr = $toolplaza_all - $dtr_count;
		
		$k = 0; $closed_lanes = 0; $open_lanes = 0; $faulty_cameras = 0;
		if($dsr){
			$cameras = 0; $faulty_cameras = $dsr[$k]['faulty_cameras'] = 0; $total_lanes = 0;
			foreach($dsr as $d){
				$table = 'toolplaza'; $where = array('id' => $d['toolplaza_id']);
				$dsr[$k]['tool'] = $toll[$k] = $this->database_model->get_where($table, $where)->result_array();
				$table = 'omc'; $where = array('id' => $d['omc']); 
				$omc[$k]['name'] = $this->database_model->get_where($table, $where)->row()->name;
				$r = 0;
				foreach($toll[$k] as $tool){
					$table = 'dsr_lane'; $where = array('dsr_id' => $d['id'], 'toolplaza_id' => $tool['id']);
					$dsr[$k]['lanes'] = $d_lane = $this->database_model->get_where($table, $where)->result_array();
					$l = 0;
					$dsr[$k]['closed_lanes'] = 0; $dsr[$k]['faulty_cameras'] = 0; $dsr[$k]['open_lanes'] = $open_lanes =  0;  
					foreach($dsr[$k]['lanes'] as $lane){
						if($lane){
							$lanes = $dsr[$k]['total_lanes'] = $dsr[$k]['total_lane_cameras'] = count($dsr[$k]['lanes']);
							if(isset($lane['lane_status'])){
									if($lane['lane_status'] == 1){ $dsr[$k]['closed_lanes']++; $closed_lanes++; }
									if($lane['lane_status'] == 0){ $dsr[$k]['open_lanes']++; } }

							if(isset($lane['lane_camera_status'])){
									if($lane['lane_camera_status'] == 1){ $dsr[$k]['faulty_cameras']++; $faulty_cameras++; }
								}
						}
						if(!$lane){}
						$l++;
					}				
					$c_lanes = $dsr[$k]['closed_lanes'];
					$r++;
				}
				$total_lanes = $total_lanes + $lanes;
				$tollplaza[$k] = $d['toolplaza_id'];
				
				$toolplaza_st[$k]['id'] = $d['toolplaza_id'];
				$toolplaza_st[$k]['omc_name'] = $omc[$k]['name'];
				$toolplaza_st[$k]['name'] = $toll[$k][0]['name'];
				$toolplaza_st[$k]['closed_lanes'] = $dsr[$k]['closed_lanes'];
				$toolplaza_st[$k]['total_lanes'] = $dsr[$k]['total_lanes'];
				$toolplaza_st['total_lanes'] = $total_lanes;
				$toolplaza_st['closed_lanes'] = $closed_lanes;
				$toolplaza_st[$k]['faulty_cameras'] = $dsr[$k]['faulty_cameras']++;
				$toolplaza_st['faulty_cameras'] = $faulty_cameras;
				$toolplaza_st[$k]['total_cameras'] = $dsr[$k]['total_lane_cameras'];
				$k++;
				$this->page_data['toolplaza_st'] = $toolplaza_st;
			}
		}
		elseif(!$dsr){
			$this->page_data['message_dsr'] = "Today, DSR is not uploaded yet.";
			$closed_lanes = ''; $open_lanes = ''; $faulty_cameras = ''; $total_lanes = ''; $cameras = '';
		}
		$k = 0; $total_traffic = 0; $total_revenue = 0;
		if($dtr){
			foreach($dtr as $d){
        		$sql = "Select * From terrif Where FIND_IN_SET (".$d['toolplaza']." ,toolplaza) AND (start_date <= '".$d['for_date']."' AND end_date >= '".$d['for_date']."')";
				$tarrif =  $this->database_model->query($sql)->result_array();	
				$select = 'name'; $table = 'toolplaza'; $where = array('id' => $d['toolplaza']);
				$toll = $this->database_model->get_select($select, $table, $where)->result_array();
				
				$toolplaza_ts[$k]['id'] = $d['toolplaza'];
				$toolplaza_ts[$k]['name'] = $toll[0]['name'];
				$toolplaza_ts[$k]['traffic'] = $traffic = $d['class1'] + $d['class2'] + $d['class3'] + $d['class4'] + $d['class5'] + $d['class6'] + $d['class7'] + $d['class8'] + $d['class9'] + $d['class10'];
				$toolplaza_ts[$k]['revenue'] = $revenue = ($d['class1'] * $tarrif[0]['class_1_value']) + ($d['class2'] * $tarrif[0]['class_2_value']) + ($d['class3'] * $tarrif[0]['class_3_value']) + ($d['class4'] * $tarrif[0]['class_4_value']) + ($d['class5'] * $tarrif[0]['class_5_value']) + ($d['class6'] * $tarrif[0]['class_6_value']) + ($d['class7'] * $tarrif[0]['class_7_value']) + ($d['class8'] * $tarrif[0]['class_8_value']) + ($d['class9'] * $tarrif[0]['class_9_value']) + ($d['class10'] * $tarrif[0]['class_10_value']);
				$toolplaza_ts['total_traffic'] = $total_traffic = $total_traffic + $traffic;
				$toolplaza_ts['total_revenue'] = $total_revenue = $total_revenue + $revenue;
				$k++;
			}
			$this->page_data['toolplaza_ts'] = $toolplaza_ts;
		}
		else{
			$this->page_data['message_dtr'] = "Today, DTR is not uploaded yet.";
		} 
		$this->page_data['id'] = $id;
		$this->page_data['dsr_count'] = $dsr_count;
		$this->page_data['toolplaza_dsr'] = $toolplaza_dsr;
		$this->page_data['dtr_count'] = $dtr_count;
		$this->page_data['toolplaza_dtr'] = $toolplaza_dtr;
		$this->page_data['dsr'] = $dsr;
		$this->page_data['dtr'] = $dtr;
		$this->page_data['total_lanes'] = isset($total_lanes);
		$this->page_data['closed_lanes'] = $closed_lanes;
		$this->page_data['faulty_cameras'] = $faulty_cameras;
		$this->page_data['cameras'] = $cameras;
		
		$this->page_data['page'] = 'Dashboard ST';
		$this->load->view('back/Ddashboard',$this->page_data);
	}
	public function daily_comprehensive_site_report(){
		if(!$this->session->userdata('adminid')){	
			return redirect('admin/login');
		}
		
		$data = $this->Admin_model->comprehensive_report($para1 = 'admin');	
		$this->page_data['toolplaza'] = $data['toolplaza'];
		$this->page_data['today'] = date('d-m-Y');
		$this->page_data['page'] = "Daily Comprehensive Site Report";
		$this->load->view('back/includes/dashboarddtrdsr/sitereport', $this->page_data);
	}
	public function dashboard_dsr(){
		$id = $this->input->post('id');
		
		if($id == "today"){ 
			$querydsr = 'SELECT * FROM dsr_updated WHERE DATE(datecreated) = DATE(NOW()) AND status = 1 ORDER BY ID DESC';
			$dsrmonth = $this->db->query($querydsr);
			$dsr = $dsrmonth->result_array();
			$dsr_count = $dsrmonth->num_rows();
			$toolplaza = $this->db->get_where('toolplaza', array('status' => '1'))->num_rows();
			$today = date("d");
			$toolplaza_dsr = $toolplaza - $dsr_count;$k = 0; $closed_lanes = 0; $open_lanes = 0; $cameras = 0; $total_lanes = 0; $faulty_cameras = 0;
			if($dsr){
				$cameras = 0; $faulty_cameras = $dsr[$k]['faulty_cameras'] = 0; 
				$total_lanes = 0;
				foreach($dsr as $d){

					$dsr[$k]['tool'] = $toll[$k] = $this->db->select('*')->from('toolplaza')->where(array('id' => $d['toolplaza_id']))->get()->result_array();
					$omc[$k]['name'] = $this->db->select('name')->from('omc')->where(array('id' => $d['omc']))->get()->row()->name;
					$r = 0;
					foreach($toll[$k] as $tool){
						$dsr[$k]['lanes'] = $d_lane = $this->db->get_where('dsr_lane', array('dsr_id' => $d['id'], 'toolplaza_id' => $tool['id']))->result_array();
						$l = 0;
						$dsr[$k]['closed_lanes'] = 0; $dsr[$k]['faulty_cameras'] = 0; $dsr[$k]['open_lanes'] = $open_lanes =  0;  
						foreach($dsr[$k]['lanes'] as $lane){

							if($lane){

								$lanes = $dsr[$k]['total_lanes'] = $dsr[$k]['total_lane_cameras'] = count($dsr[$k]['lanes']);


								/*?> <pre><?php echo '$total_lanes = '.$total_lanes;*/
								if(isset($lane['lane_status'])){
										if($lane['lane_status'] == 1){
											$dsr[$k]['closed_lanes']++;
											$closed_lanes++;
										}
										if($lane['lane_status'] == 0){
											$dsr[$k]['open_lanes']++;
										/*?> <pre><?php echo '$closed_lanes = '.$closed_lanes; exit;*/
										}


								}

								if(isset($lane['lane_camera_status'])){
										if($lane['lane_camera_status'] == 1){
											$dsr[$k]['faulty_cameras']++;
											$faulty_cameras++;
										/*?> <pre><?php echo '$closed_lanes = '.$closed_lanes; exit;*/
										}
									}


							}
							if(!$lane){

							}
							$l++;
						}				
						$c_lanes = $dsr[$k]['closed_lanes'];
						$r++;
					}
					$total_lanes = $total_lanes + $lanes;
					/*$closed_lanes = $closed_lanes + $c_lanes;*/
					/*?><pre> <?php echo print_r($dsr); ?></pre> <?php exit;*/
					$tollplaza[$k] = $d['toolplaza_id'];
					$toolplaza_st[$k]['id'] = $d['toolplaza_id'];
					$toolplaza_st[$k]['name'] = $toll[$k][0]['name'];
					$toolplaza_st[$k]['omc_name'] = $omc[$k]['name'];
					$toolplaza_st[$k]['closed_lanes'] = $dsr[$k]['closed_lanes'];
					$toolplaza_st[$k]['total_lanes'] = $dsr[$k]['total_lanes'];
					$toolplaza_st['total_lanes'] = $total_lanes;
					$toolplaza_st['closed_lanes'] = $closed_lanes;
					$toolplaza_st[$k]['faulty_cameras'] = $dsr[$k]['faulty_cameras']++;
					$toolplaza_st['faulty_cameras'] = $faulty_cameras;
					$toolplaza_st[$k]['total_cameras'] = $dsr[$k]['total_lane_cameras'];

					$k++;
					$this->page_data['toolplaza_st'] = $toolplaza_st;
				}



			}
			else{
				$this->page_data['message_dsr'] = "Today, DSR is not uploaded yet.";
			}
			/*?> <pre><?php echo print_r($toolplaza_st);exit;*/
			
			$this->page_data['dsr_count'] = $dsr_count;
			$this->page_data['toolplaza_dsr'] = $toolplaza_dsr;
			$total_lanes = $open_lanes;
			$this->page_data['dsr'] = $dsr;
			$this->page_data['total_lanes'] = $total_lanes;
			$this->page_data['closed_lanes'] = $closed_lanes;
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dsr", $this->page_data);
			
		}
		elseif($id == "yesterday"){ 
			$querydsr = 'SELECT * FROM dsr_updated WHERE DATE(datecreated) = DATE(NOW() - INTERVAL 1 DAY) AND status = 1 ORDER BY ID DESC';
			$dsrmonth = $this->db->query($querydsr);
			$dsr = $dsrmonth->result_array();
			$dsr_count = $dsrmonth->num_rows();
			$toolplaza = $this->db->get_where('toolplaza', array('status' => '1'))->num_rows();
			$today = (date("d")) - 1;
			$toolplaza_dsr = $toolplaza - $dsr_count;$k = 0; $closed_lanes = 0; $open_lanes = 0; $cameras = 0; $total_lanes = 0; $faulty_cameras = 0;
			if($dsr){
				$cameras = 0; $faulty_cameras = $dsr[$k]['faulty_cameras'] = 0; 
				$total_lanes = 0;
				foreach($dsr as $d){

					$dsr[$k]['tool'] = $toll[$k] = $this->db->select('*')->from('toolplaza')->where(array('id' => $d['toolplaza_id']))->get()->result_array();
					$omc[$k]['name'] = $this->db->select('name')->from('omc')->where(array('id' => $d['omc']))->get()->row()->name;
					$r = 0;
					foreach($toll[$k] as $tool){
						$dsr[$k]['lanes'] = $d_lane = $this->db->get_where('dsr_lane', array('dsr_id' => $d['id'], 'toolplaza_id' => $tool['id']))->result_array();
						$l = 0;
						$dsr[$k]['closed_lanes'] = 0; $dsr[$k]['faulty_cameras'] = 0; $dsr[$k]['open_lanes'] = $open_lanes =  0;  
						foreach($dsr[$k]['lanes'] as $lane){

							if($lane){

								$lanes = $dsr[$k]['total_lanes'] = $dsr[$k]['total_lane_cameras'] = count($dsr[$k]['lanes']);


								/*?> <pre><?php echo '$total_lanes = '.$total_lanes;*/
								if(isset($lane['lane_status'])){
										if($lane['lane_status'] == 1){
											$dsr[$k]['closed_lanes']++;
											$closed_lanes++;
										}
										if($lane['lane_status'] == 0){
											$dsr[$k]['open_lanes']++;
										/*?> <pre><?php echo '$closed_lanes = '.$closed_lanes; exit;*/
										}


								}

								if(isset($lane['lane_camera_status'])){
										if($lane['lane_camera_status'] == 1){
											$dsr[$k]['faulty_cameras']++;
											$faulty_cameras++;
										/*?> <pre><?php echo '$closed_lanes = '.$closed_lanes; exit;*/
										}
									}


							}
							if(!$lane){

							}
							$l++;
						}				
						$c_lanes = $dsr[$k]['closed_lanes'];
						$r++;
					}
					$total_lanes = $total_lanes + $lanes;
					/*$closed_lanes = $closed_lanes + $c_lanes;*/
					/*?><pre> <?php echo print_r($dsr); ?></pre> <?php exit;*/
					$tollplaza[$k] = $d['toolplaza_id'];
					$toolplaza_st[$k]['id'] = $d['toolplaza_id'];
					$toolplaza_st[$k]['name'] = $toll[$k][0]['name'];
					$toolplaza_st[$k]['omc_name'] = $omc[$k]['name'];
					$toolplaza_st[$k]['closed_lanes'] = $dsr[$k]['closed_lanes'];
					$toolplaza_st[$k]['total_lanes'] = $dsr[$k]['total_lanes'];
					$toolplaza_st['total_lanes'] = $total_lanes;
					$toolplaza_st['closed_lanes'] = $closed_lanes;
					$toolplaza_st[$k]['faulty_cameras'] = $dsr[$k]['faulty_cameras']++;
					$toolplaza_st['faulty_cameras'] = $faulty_cameras;
					$toolplaza_st[$k]['total_cameras'] = $dsr[$k]['total_lane_cameras'];

					$k++;
					$this->page_data['toolplaza_st'] = $toolplaza_st;
				}



			}
			else{
				$this->page_data['message_dsr'] = "Today, DSR is not uploaded yet.";
			}
			/*?> <pre><?php echo print_r($toolplaza_st);exit;*/
			
			$this->page_data['dsr_count'] = $dsr_count;
			$this->page_data['toolplaza_dsr'] = $toolplaza_dsr;
			$total_lanes = $open_lanes;
			$this->page_data['dsr'] = $dsr;
			$this->page_data['total_lanes'] = $total_lanes;
			$this->page_data['closed_lanes'] = $closed_lanes;
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dsr", $this->page_data);
			
		}
		elseif($id == "current-month"){/* echo 'working';exit;*/
			$querydsr = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW()) AND status = 1 ORDER BY ID DESC';
			$dsrmonth = $this->db->query($querydsr);
			$dsr = $dsrmonth->result_array();
			$dsr_count = $dsrmonth->num_rows();
			$tolplaza = $this->db->get_where('toolplaza', array('status' => '1'));
			$toolplaza = $tolplaza->num_rows();
			$today = date("d");
			$toolplaza = $toolplaza * $today;
			$toolplaza_dsr = $toolplaza - $dsr_count;
			$k = 0; 
			if($dsr){
				foreach($dsr as $d){
					$tollplaza[$k] = $d['toolplaza_id'];
					$k++;
					$this->page_data['tollplaza'] = $tollplaza;
				}
			}
			else{
				$this->page_data['message'] = "Today, DSR is not uploaded yet.";
			}
			$j = 0;
			foreach($tolplaza->result_array() as $toll){
				$query_dsr_toll = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW()) AND status = 1 AND toolplaza_id = '.$toll['id'].' ORDER BY ID DESC';
				$dsr_toll[$j] = $this->db->query($query_dsr_toll);
				$dsr_tool[$j]['count']= $dsr_toll[$j]->num_rows();
				$dsr_tool[$j]['not_uploaded'] = $today - $dsr_tool[$j]['count'];
				if($dsr_tool[$j]['count'] > $today){
					$dsr_tool[$j]['error'] = 'Approve/Disapprove';
				}
				if($dsr_tool[$j]['count'] < $today){
					$dsr_tool[$j]['error'] = 'DSR missing';
				}
				if($dsr_tool[$j]['count'] == 0){
					$dsr_tool[$j]['error'] = 'DSRs do not exist';
				}
				if($dsr_tool[$j]['count'] == $today){
					$dsr_tool[$j]['success'] = 'All DSR uploaded';
				}
				$j++;
			}
			$this->page_data['tool'] = $tolplaza->result_array();
			$this->page_data['days_count'] = $today; 
			$this->page_data['dsr_tool'] = $dsr_tool; 
			$this->page_data['toolplaza_dsr'] = $toolplaza_dsr;
			$this->page_data['dsr_count'] = $dsr_count;
			$this->page_data['toolplaza'] = $toolplaza;
			$this->page_data['dsr'] = $dsr;
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dsr", $this->page_data);
		}
		elseif($id == "current-quarter"){
			$querydsr = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW()) AND status = 1 ORDER BY ID DESC';
			$querydsr1 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 1 MONTH) AND status = 1 ORDER BY ID DESC';
			$querydsr2 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 2 MONTH) AND status = 1 ORDER BY ID DESC';
			$dsrmonth = $this->db->query($querydsr);
			$dsrmonth1 = $this->db->query($querydsr1);
			$dsrmonth2 = $this->db->query($querydsr2);
			$dsr = $dsrmonth->result_array();
			$dsr1 = $dsrmonth1->result_array();
			$dsr2 = $dsrmonth2->result_array();
			$dsr_count = $dsrmonth->num_rows() + $dsrmonth1->num_rows() + $dsrmonth2->num_rows();
			$tolplaza = $this->db->get_where('toolplaza', array('status' => '1'));
			$toolplaza = $tolplaza->num_rows();
			$one_month_day = date('d', strtotime('last day of -1 month'));
			$two_month_day =  date('d', strtotime('last day of -2 month'));
			$today = date("d");
			$days_count = $today + $one_month_day + $two_month_day;
			$toolplaza_all = $toolplaza * $days_count;
			$toolplaza_dsr = $toolplaza_all - $dsr_count;
			/*?><pre> <?php  echo print_r($dsr2) ?> </pre><?php exit;*/

			$k = 0; 
			if($dsr){
				foreach($dsr as $d){
					$tollplaza[$k] = $d['toolplaza_id'];
					$k++;
					$this->page_data['tollplaza'] = $tollplaza;
				}
			}
			else{
				$this->page_data['message'] = "DSR is not uploaded yet.";
			}
			$j = 0;
			foreach($tolplaza->result_array() as $toll){
				$query_dsr_toll_month_now = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW()) AND status = 1 AND toolplaza_id = '.$toll['id'].' ORDER BY ID DESC';
				$query_dsr_toll_month_last = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 1 MONTH) AND status = 1 AND toolplaza_id = '.$toll['id'].' ORDER BY ID DESC';
				$query_dsr_toll_month_last_2 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 2 MONTH) AND status = 1 AND toolplaza_id = '.$toll['id'].' ORDER BY ID DESC';
				$dsr_toll_month[$j] = $this->db->query($query_dsr_toll_month_now)->num_rows();
				$dsr_toll_month_last[$j] = $this->db->query($query_dsr_toll_month_last)->num_rows();
				$dsr_toll_month_last_2[$j] = $this->db->query($query_dsr_toll_month_last_2)->num_rows();
				$dsr_tool[$j]['count']= $dsr_toll_month[$j] + $dsr_toll_month_last[$j] + $dsr_toll_month_last_2[$j];
				$dsr_tool[$j]['not_uploaded'] = $days_count - $dsr_tool[$j]['count'];
				if($dsr_tool[$j]['count'] > $days_count){
					$dsr_tool[$j]['error'] = 'Approve/Disapprove';
				}
				if($dsr_tool[$j]['count'] < $days_count){
					$dsr_tool[$j]['error'] = 'DSR missing';
				}
				if($dsr_tool[$j]['count'] == 0){
					$dsr_tool[$j]['error'] = 'DSRs do not exist';
				}
				if($dsr_tool[$j]['count'] == $days_count){
					$dsr_tool[$j]['success'] = 'All DSR uploaded';
				}
				$j++;
			}
			$this->page_data['tool'] = $tolplaza->result_array();
			$this->page_data['days_count'] = $days_count; 
			$this->page_data['dsr_tool'] = $dsr_tool; 
			$this->page_data['toolplaza_dsr'] = $toolplaza_dsr;
			$this->page_data['dsr_count'] = $dsr_count;
			$this->page_data['toolplaza'] = $toolplaza;
			$this->page_data['dsr'] = $dsr;
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dsr", $this->page_data);
			
		}
		elseif($id == "current-semiannual"){
			$querydsr = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW()) AND status = 1 ORDER BY ID DESC';
			$querydsr1 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 1 MONTH) AND status = 1 ORDER BY ID DESC';
			$querydsr2 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 2 MONTH) AND status = 1 ORDER BY ID DESC';
			$querydsr3 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 3 MONTH) AND status = 1 ORDER BY ID DESC';
			$querydsr4 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 4 MONTH) AND status = 1 ORDER BY ID DESC';
			$querydsr5 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 5 MONTH) AND status = 1 ORDER BY ID DESC';
			$dsrmonth = $this->db->query($querydsr);
			$dsrmonth1 = $this->db->query($querydsr1);
			$dsrmonth2 = $this->db->query($querydsr2);
			$dsrmonth3 = $this->db->query($querydsr2);
			$dsrmonth4 = $this->db->query($querydsr2);
			$dsrmonth5 = $this->db->query($querydsr2);
			$dsr = $dsrmonth->result_array();
			$dsr1 = $dsrmonth1->result_array();
			$dsr2 = $dsrmonth2->result_array();
			$dsr_count = $dsrmonth->num_rows() + $dsrmonth1->num_rows() + $dsrmonth2->num_rows() + $dsrmonth3->num_rows() + $dsrmonth4->num_rows() + $dsrmonth5->num_rows();
			$tolplaza = $this->db->get_where('toolplaza', array('status' => '1'));
			$toolplaza = $tolplaza->num_rows();
			$one_month_day = date('d', strtotime('last day of -1 month'));
			$two_month_day =  date('d', strtotime('last day of -2 month'));
			$three_month_day =  date('d', strtotime('last day of -3 month'));
			$four_month_day =  date('d', strtotime('last day of -4 month'));
			$five_month_day =  date('d', strtotime('last day of -5 month'));
			$today = date("d");
			$days_count = $today + $one_month_day + $two_month_day + $three_month_day + $four_month_day + $five_month_day;
			$toolplaza_all = $toolplaza * $days_count;
			$toolplaza_dsr = $toolplaza_all - $dsr_count;
			/*?><pre> <?php  echo print_r($dsr_count) ?> </pre><?php exit;*/

			$k = 0; 
			if($dsr){
				foreach($dsr as $d){
					$tollplaza[$k] = $d['toolplaza_id'];
					$k++;
					$this->page_data['tollplaza'] = $tollplaza;
				}
			}
			else{
				$this->page_data['message'] = "Today, DSR is not uploaded yet.";
			}
			$j = 0;
			foreach($tolplaza->result_array() as $toll){
				$query_dsr_toll_month_now = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW()) AND status = 1 AND toolplaza_id = '.$toll['id'].' ORDER BY ID DESC';
				$query_dsr_toll_month_last = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 1 MONTH) AND status = 1 AND toolplaza_id = '.$toll['id'].' ORDER BY ID DESC';
				$query_dsr_toll_month_last_2 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 2 MONTH) AND status = 1 AND toolplaza_id = '.$toll['id'].' ORDER BY ID DESC';
				$query_dsr_toll_month_last_3 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 3 MONTH) AND status = 1 AND toolplaza_id = '.$toll['id'].' ORDER BY ID DESC';
				$query_dsr_toll_month_last_4 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 4 MONTH) AND status = 1 AND toolplaza_id = '.$toll['id'].' ORDER BY ID DESC';
				$query_dsr_toll_month_last_5 = 'SELECT * FROM dsr_updated WHERE MONTH(datecreated) = MONTH(NOW() - INTERVAL 5 MONTH) AND status = 1 AND toolplaza_id = '.$toll['id'].' ORDER BY ID DESC';
				$dsr_toll_month[$j] = $this->db->query($query_dsr_toll_month_now)->num_rows();
				$dsr_toll_month_last[$j] = $this->db->query($query_dsr_toll_month_last)->num_rows();
				$dsr_toll_month_last_2[$j] = $this->db->query($query_dsr_toll_month_last_2)->num_rows();
				$dsr_toll_month_last_3[$j] = $this->db->query($query_dsr_toll_month_last_3)->num_rows();
				$dsr_toll_month_last_4[$j] = $this->db->query($query_dsr_toll_month_last_4)->num_rows();
				$dsr_toll_month_last_5[$j] = $this->db->query($query_dsr_toll_month_last_5)->num_rows();
				$dsr_tool[$j]['count']= $dsr_toll_month[$j] + $dsr_toll_month_last[$j] + $dsr_toll_month_last_2[$j] + $dsr_toll_month_last_3[$j] + $dsr_toll_month_last_4[$j] + $dsr_toll_month_last_5[$j];
				$dsr_tool[$j]['not_uploaded'] = $days_count - $dsr_tool[$j]['count'];
				if($dsr_tool[$j]['count'] > $days_count){
					$dsr_tool[$j]['error'] = 'Approve/Disapprove';
				}
				if($dsr_tool[$j]['count'] < $days_count){
					$dsr_tool[$j]['error'] = 'DSR missing';
				}
				if($dsr_tool[$j]['count'] == 0){
					$dsr_tool[$j]['error'] = 'DSRs do not exist';
				}
				if($dsr_tool[$j]['count'] == $days_count){
					$dsr_tool[$j]['success'] = 'All DSR uploaded';
				}
				$j++;
			}
			$this->page_data['tool'] = $tolplaza->result_array();
			$this->page_data['days_count'] = $days_count; 
			$this->page_data['dsr_tool'] = $dsr_tool; 
			$this->page_data['toolplaza_dsr'] = $toolplaza_dsr;
			$this->page_data['dsr_count'] = $dsr_count;
			$this->page_data['toolplaza'] = $toolplaza;
			$this->page_data['dsr'] = $dsr;
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dsr", $this->page_data);
			
		}
		elseif($id == "today-dtr"){
			$querydtr = 'SELECT * FROM dtr WHERE DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY) AND status = 1 ORDER BY ID DESC';
			$dtrmonth = $this->db->query($querydtr);
			$dtr = $dtrmonth->result_array();
			$dtr_count = $dtrmonth->num_rows();
			$toolplaza = $this->db->get_where('toolplaza', array('status' => '1'))->num_rows();
			$today = date("d");
			$toolplaza = $toolplaza;
			$toolplaza = $toolplaza - $dtr_count;
			
			if($dtr){
				$k = 0; $total_traffic = 0; $total_revenue = 0;
				foreach($dtr as $d){
					$start_date = $d['for_date'];
					$end_date = $d['for_date'];
					$sql = "Select * From terrif Where FIND_IN_SET (".$d['toolplaza']." ,toolplaza) AND (start_date <= 		'".$start_date."' AND end_date >= '".$end_date."')";
					$tarrif =  $this->db->query($sql)->result_array();				
					$toll = $this->db->select('name')->from('toolplaza')->where(array('id' => $d['toolplaza']))->get()->result_array();

					$toolplaza_ts[$k]['id'] = $d['toolplaza'];
					$toolplaza_ts[$k]['name'] = $toll[0]['name'];
					$toolplaza_ts[$k]['traffic'] = $traffic = $d['class1'] + $d['class2'] + $d['class3'] + $d['class4'] + $d['class5'] + $d['class6'] + $d['class7'] + $d['class8'] + $d['class9'] + $d['class10'];
					$toolplaza_ts[$k]['revenue'] = $revenue = ($d['class1'] * $tarrif[0]['class_1_value']) + ($d['class2'] * $tarrif[0]['class_2_value']) + ($d['class3'] * $tarrif[0]['class_3_value']) + ($d['class4'] * $tarrif[0]['class_4_value']) + ($d['class5'] * $tarrif[0]['class_5_value']) + ($d['class6'] * $tarrif[0]['class_6_value']) + ($d['class7'] * $tarrif[0]['class_7_value']) + ($d['class8'] * $tarrif[0]['class_8_value']) + ($d['class9'] * $tarrif[0]['class_9_value']) + ($d['class10'] * $tarrif[0]['class_10_value']);
					$toolplaza_ts['total_traffic'] = $total_traffic = $total_traffic + $traffic;
					$toolplaza_ts['total_revenue'] = $total_revenue = $total_revenue + $revenue;
					$k++;
				}
				$this->page_data['toolplaza_ts'] = $toolplaza_ts;
			}
			else{
				$this->page_data['message_dtr'] = "Today, DTR is not uploaded yet.";
			} 
			$this->page_data['dtr_count'] = $dtr_count;
			$this->page_data['toolplaza_dtr'] = $toolplaza;
			
			$this->page_data['dtr'] = $dtr;
			
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dtr", $this->page_data);
		}
		elseif($id == "yesterday-dtr"){
			$querydtr = 'SELECT * FROM dtr WHERE DATE(for_date) = DATE(NOW() - INTERVAL 2 DAY) AND status = 1 ORDER BY ID DESC';
			$dtrmonth = $this->db->query($querydtr);
			$dtr = $dtrmonth->result_array();
			$dtr_count = $dtrmonth->num_rows();
			$toolplaza = $this->db->get_where('toolplaza', array('status' => '1'))->num_rows();
			$today = (date("d")) - 1;
			$toolplaza = $toolplaza;
			$toolplaza = $toolplaza - $dtr_count;
			
			if($dtr){
				$k = 0; $total_traffic = 0; $total_revenue = 0;
				foreach($dtr as $d){
					$start_date = $d['for_date'];
					$end_date = $d['for_date'];
					$sql = "Select * From terrif Where FIND_IN_SET (".$d['toolplaza']." ,toolplaza) AND (start_date <= 		'".$start_date."' AND end_date >= '".$end_date."')";
					$tarrif =  $this->db->query($sql)->result_array();				
					$toll = $this->db->select('name')->from('toolplaza')->where(array('id' => $d['toolplaza']))->get()->result_array();

					$toolplaza_ts[$k]['id'] = $d['toolplaza'];
					$toolplaza_ts[$k]['name'] = $toll[0]['name'];
					$toolplaza_ts[$k]['traffic'] = $traffic = $d['class1'] + $d['class2'] + $d['class3'] + $d['class4'] + $d['class5'] + $d['class6'] + $d['class7'] + $d['class8'] + $d['class9'] + $d['class10'];
					$toolplaza_ts[$k]['revenue'] = $revenue = ($d['class1'] * $tarrif[0]['class_1_value']) + ($d['class2'] * $tarrif[0]['class_2_value']) + ($d['class3'] * $tarrif[0]['class_3_value']) + ($d['class4'] * $tarrif[0]['class_4_value']) + ($d['class5'] * $tarrif[0]['class_5_value']) + ($d['class6'] * $tarrif[0]['class_6_value']) + ($d['class7'] * $tarrif[0]['class_7_value']) + ($d['class8'] * $tarrif[0]['class_8_value']) + ($d['class9'] * $tarrif[0]['class_9_value']) + ($d['class10'] * $tarrif[0]['class_10_value']);
					$toolplaza_ts['total_traffic'] = $total_traffic = $total_traffic + $traffic;
					$toolplaza_ts['total_revenue'] = $total_revenue = $total_revenue + $revenue;
					$k++;
				}
				$this->page_data['toolplaza_ts'] = $toolplaza_ts;
			}
			else{
				$this->page_data['message_dtr'] = "Today, DTR is not uploaded yet.";
			} 
			$this->page_data['dtr_count'] = $dtr_count;
			$this->page_data['toolplaza_dtr'] = $toolplaza;
			
			$this->page_data['dtr'] = $dtr;
			
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dtr", $this->page_data);
		}
		elseif($id == "current-month-dtr"){
			$querydtr = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW()) AND status = 1 ORDER BY ID DESC';
			$dtrmonth = $this->db->query($querydtr);
			$dtr = $dtrmonth->result_array();
			$dtr_count = $dtrmonth->num_rows();
			$tolplaza = $this->db->get_where('toolplaza', array('status' => '1'));
			$toolplaza = $tolplaza->num_rows();
			$today = (date("d")) - 1;
			$toolplaza = $toolplaza * $today;
			$toolplaza_dtr = $toolplaza - $dtr_count;
			
				$j = 0;
				foreach($tolplaza->result_array() as $toll){
					$query_dtr_toll[$j] = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW()) AND status = 1 AND toolplaza = '.$toll['id'].' ORDER BY ID DESC';

					$dtr_toll[$j] = $this->db->query($query_dtr_toll[$j]);
					$dtr_tool[$j]['count']= $dtr_toll[$j]->num_rows();
					$dtr_tool[$j]['not_uploaded'] = $today - $dtr_tool[$j]['count'];
					if($dtr_tool[$j]['count'] > $today){
						$dtr_tool[$j]['error'] = 'Approve/Disapprove';
					}
					if($dtr_tool[$j]['count'] < $today){
						$dtr_tool[$j]['error'] = 'DTR missing';
					}
					if($dtr_tool[$j]['count'] == 0){
						$dtr_tool[$j]['error'] = 'DTRs do not exist';
					}
					if($dtr_tool[$j]['count'] == $today){
						$dtr_tool[$j]['success'] = 'All DTR uploaded';
					}
					if(!$dtr){
						$this->page_data['message_dtr'] = "Today, DTR is not uploaded yet.";
					}
					$j++;
				}
			
			$this->page_data['tool'] = $tolplaza->result_array();
			$this->page_data['days_count'] = $today; 
			$this->page_data['dtr_tool'] = $dtr_tool; 
			/*?> <pre> <?php echo print_r($dtr_tool);exit;*/
			
			$this->page_data['dtr_count'] = $dtr_count;
			$this->page_data['toolplaza_dtr'] = $toolplaza_dtr;
			$this->page_data['dtr'] = $dtr;
			
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dtr", $this->page_data);
		}
		elseif($id == "current-quarter-dtr"){
			$querydtr = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW()) AND status = 1 ORDER BY ID DESC';
			$querydtr1 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH) AND status = 1 ORDER BY ID DESC';
			$querydtr2 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 2 MONTH) AND status = 1  AND status = 1 ORDER BY ID DESC';
			$dtrmonth = $this->db->query($querydtr);
			$dtrmonth1 = $this->db->query($querydtr1);
			$dtrmonth2 = $this->db->query($querydtr2);
			$dtr = $dtrmonth->result_array();
			$dtr1 = $dtrmonth1->result_array();
			$dtr2 = $dtrmonth2->result_array();
			$dtr_count = $dtrmonth->num_rows() + $dtrmonth1->num_rows() + $dtrmonth2->num_rows() ;
			$tolplaza = $this->db->get_where('toolplaza', array('status' => '1'));
			$toolplaza = $tolplaza->num_rows();
			$one_month_day = date('d', strtotime('last day of -1 month'));
			$two_month_day =  date('d', strtotime('last day of -2 month'));
			$today = date("d")-1;
			$days_count = $today + $one_month_day + $two_month_day;
			$toolplaza_all = $toolplaza * $days_count;
			$toolplaza_r = $toolplaza_all - $dtr_count;
			/*?><pre> <?php  echo print_r($dtr2) ?> </pre><?php exit;*/
				
				$j = 0;
				foreach($tolplaza->result_array() as $toll){
					$query_dtr_toll_month_now = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW()) AND status = 1 AND toolplaza = '.$toll['id'].' ORDER BY ID DESC';
					$query_dtr_toll_month_last = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH) AND status = 1 AND toolplaza = '.$toll['id'].' ORDER BY ID DESC';
					$query_dtr_toll_month_last_2 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 2 MONTH) AND status = 1 AND toolplaza = '.$toll['id'].' ORDER BY ID DESC';

					$dtr_toll_month[$j] = $this->db->query($query_dtr_toll_month_now)->num_rows();
					$dtr_toll_month_last[$j] = $this->db->query($query_dtr_toll_month_last)->num_rows();
					$dtr_toll_month_last_2[$j] = $this->db->query($query_dtr_toll_month_last_2)->num_rows();

					$dtr_tool[$j]['count']= $dtr_toll_month[$j] + $dtr_toll_month_last[$j] + $dtr_toll_month_last_2[$j];
					$dtr_tool[$j]['not_uploaded'] = $days_count - $dtr_tool[$j]['count'];
					if($dtr_tool[$j]['count'] > $days_count){
						$dtr_tool[$j]['error'] = 'Approve/Disapprove';
					}
					if($dtr_tool[$j]['count'] < $days_count){
						$dtr_tool[$j]['error'] = 'DTR missing';
					}
					if($dtr_tool[$j]['count'] == 0){
						$dtr_tool[$j]['error'] = 'DTRs do not exist';
					}
					if($dtr_tool[$j]['count'] == $days_count){
						$dtr_tool[$j]['success'] = 'All DTR uploaded';
					}
					if(!$dtr_tool[$j]['count']){
						$this->page_data['message_dtr'] = "Today, DTR is not uploaded yet.";
					}
					$j++;
				}
			
			
			$this->page_data['tool'] = $tolplaza->result_array();
			$this->page_data['days_count'] = $days_count; 
			$this->page_data['dtr_tool'] = $dtr_tool; 
			/*?> <pre> <?php  echo print_r($dtr);exit;*/
	
			$this->page_data['dtr_count'] = $dtr_count;
			$this->page_data['toolplaza_dtr'] = $toolplaza_r;
			
			$this->page_data['dtr'] = $dtr;
			
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dtr", $this->page_data);
		}
		elseif($id == "current-semiannual-dtr"){
			$querydtr = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW()) AND status = 1 ORDER BY ID DESC';
			$querydtr1 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH) AND status = 1 ORDER BY ID DESC';
			$querydtr2 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 2 MONTH) AND status = 1 ORDER BY ID DESC';
			$querydtr3 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 3 MONTH) AND status = 1 ORDER BY ID DESC';
			$querydtr4 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 4 MONTH) AND status = 1 ORDER BY ID DESC';
			$querydtr5 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 5 MONTH) AND status = 1 ORDER BY ID DESC';
			$dtrmonth = $this->db->query($querydtr);
			$dtrmonth1 = $this->db->query($querydtr1);
			$dtrmonth2 = $this->db->query($querydtr2);
			$dtrmonth3 = $this->db->query($querydtr2);
			$dtrmonth4 = $this->db->query($querydtr2);
			$dtrmonth5 = $this->db->query($querydtr2);
			$dtr = $dtrmonth->result_array();
			$dtr1 = $dtrmonth1->result_array();
			$dtr2 = $dtrmonth2->result_array();
			$dtr_count = $dtrmonth->num_rows() + $dtrmonth1->num_rows() + $dtrmonth2->num_rows() + $dtrmonth3->num_rows() + $dtrmonth4->num_rows() + $dtrmonth5->num_rows() ;
			
			$tolplaza = $this->db->get_where('toolplaza', array('status' => '1'));
			$toolplaza = $tolplaza->num_rows();
			$one_month_day = date('d', strtotime('last day of -1 month'));
			$two_month_day =  date('d', strtotime('last day of -2 month'));
			$three_month_day =  date('d', strtotime('last day of -3 month'));
			$four_month_day =  date('d', strtotime('last day of -4 month'));
			$five_month_day =  date('d', strtotime('last day of -5 month'));
			$today = date("d") - 1;
			$days_count = $today + $one_month_day + $two_month_day + $three_month_day + $four_month_day + $five_month_day;
			$toolplaza_all = $toolplaza * $days_count;
			$toolplaza_r = $toolplaza_all - $dtr_count;
			/*?><pre> <?php  echo print_r($dtr_count) ?> </pre><?php exit;*/
			
				$j = 0;
				foreach($tolplaza->result_array() as $toll){
					$query_dtr_toll_month_now = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW()) AND status = 1 AND toolplaza = '.$toll['id'].' ORDER BY ID DESC';
					$query_dtr_toll_month_last = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH) AND status = 1 AND toolplaza = '.$toll['id'].' ORDER BY ID DESC';
					$query_dtr_toll_month_last_2 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 2 MONTH) AND status = 1 AND toolplaza = '.$toll['id'].' ORDER BY ID DESC';
					$query_dtr_toll_month_last_3 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 3 MONTH) AND status = 1 AND toolplaza = '.$toll['id'].' ORDER BY ID DESC';
					$query_dtr_toll_month_last_4 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 4 MONTH) AND status = 1 AND toolplaza = '.$toll['id'].' ORDER BY ID DESC';
					$query_dtr_toll_month_last_5 = 'SELECT * FROM dtr WHERE MONTH(for_date) = MONTH(NOW() - INTERVAL 5 MONTH) AND status = 1 AND toolplaza = '.$toll['id'].' ORDER BY ID DESC';
					$dtr_toll_month[$j] = $this->db->query($query_dtr_toll_month_now)->num_rows();
					$dtr_toll_month_last[$j] = $this->db->query($query_dtr_toll_month_last)->num_rows();
					$dtr_toll_month_last_2[$j] = $this->db->query($query_dtr_toll_month_last_2)->num_rows();
					$dtr_toll_month_last_3[$j] = $this->db->query($query_dtr_toll_month_last_3)->num_rows();
					$dtr_toll_month_last_4[$j] = $this->db->query($query_dtr_toll_month_last_4)->num_rows();
					$dtr_toll_month_last_5[$j] = $this->db->query($query_dtr_toll_month_last_5)->num_rows();
					$dtr_tool[$j]['count']= $dtr_toll_month[$j] + $dtr_toll_month_last[$j] + $dtr_toll_month_last_2[$j] + $dtr_toll_month_last_3[$j] + $dtr_toll_month_last_4[$j] + $dtr_toll_month_last_5[$j];
					$dtr_tool[$j]['not_uploaded'] = $days_count - $dtr_tool[$j]['count'];
					if($dtr_tool[$j]['count'] > $days_count){
						$dtr_tool[$j]['error'] = 'Approve/Disapprove';
					}
					if($dtr_tool[$j]['count'] < $days_count){
						$dtr_tool[$j]['error'] = 'DTR missing';
					}
					if($dtr_tool[$j]['count'] == 0){
						$dtr_tool[$j]['error'] = 'DTRs do not exist';
					}
					if($dtr_tool[$j]['count'] == $days_count){
						$dtr_tool[$j]['success'] = 'All DTR uploaded';
					}
					if(!$dtr){
						$this->page_data['message_dtr'] = "Today, DTR is not uploaded yet.";
					}
					$j++;
				}
			
			$this->page_data['tool'] = $tolplaza->result_array();
			$this->page_data['days_count'] = $days_count; 
			$this->page_data['dtr_tool'] = $dtr_tool; 
			
			
			$this->page_data['dtr_count'] = $dtr_count;
			$this->page_data['toolplaza_dtr'] = $toolplaza_r;
			
			$this->page_data['dtr'] = $dtr;
			
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dtr", $this->page_data);
		}
	}
	public function dashboard_dtr(){
		$dat = "DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)";
		$href = "all-summary-pday";
		$current = explode("-",$href);
		$datatoday = $this->Admin_model->dashboard_dtr($dat,$href, $current);
		$this->page_data['dtr'] = $datatoday['dtr'];
		
		$this->page_data['date'] = $dat;
		$this->page_data['current'] = $current[1].$current[2];	
		$this->page_data['section'] = $current[1];
		$this->page_data['duration'] = $current[2];
		
		if($this->page_data['dtr']){
			
			$this->page_data['toolplazatoday'] = $datatoday['toolplaza'];
			$this->page_data['tollplazatoday'] = $datatoday['tollplaza'];
		}
		else{
			$this->page_data['message'] = "DTR is not uploaded Yesterday";
			$this->page_data['toolplazatoday'] = $datatoday['toolplaza'];
			$this->page_data['tollplazatoday'] = $datatoday['tollplaza'];
		}
		

		$this->page_data['page'] = 'DTR Dashboard';
		$this->load->view('back/dashboard_dtr', $this->page_data);
	}
	public function dashboard_dtr_day(){
		$dat = $this->input->post('date');
		$href = $this->input->post('href');

		if($dat && $href){
			$this->page_data['date'] = $dat;
			$this->page_data['href'] = $href;
			
			$current = explode("-",$href);

			$datatoday = $this->Admin_model->dashboard_dtr($dat,$href,$current);
			
			$this->page_data['dtr'] = $datatoday['dtr'];
			

			
			
			$this->page_data['current'] = $current[1].$current[2];

			$this->page_data['section'] = $current[1];
			$this->page_data['duration'] = $current[2];
			
			

			if($this->page_data['dtr']){

				$this->page_data['toolplazatoday'] = $datatoday['toolplaza'];
				$this->page_data['tollplazatoday'] = $datatoday['tollplaza'];
			}
			else{
				if($current[2] == 'pday'){
					$day = 'Yesterday';
				}elseif($current[2] == 'pweek'){
					$day = 'Previous Week';
				}elseif($current[2] == 'pmonth'){
					$day = 'Previous Month';
				}elseif($current[2] == 'today'){
					$day = 'Today';
				}
				$this->page_data['message'] = "DTR is not uploaded ".$day;
				
				$this->page_data['toolplazatoday'] = $datatoday['toolplaza'];
				$this->page_data['tollplazatoday'] = $datatoday['tollplaza'];
			}
			/*?> <pre><?php	echo print_r($this->page_data['message'] ); exit;*/
			$this->page_data['page'] = 'DTR Dashboard';

			$this->load->view('back/chartsdashboarddtr', $this->page_data);
			
		}
			


		
		
	}
	////TollPlaza Live Data
	public function toolplaza_live_data(){
		if(!$this->session->userdata('adminid')){	
			return redirect('admin/login');
		}
		$info = scandir('C:\Mandra');
		$j = 0;
		foreach($info as $fl){
			if(strpos($fl, 'TSaveBatchDBMessage')){
				$direct[$j] = explode('_TSaveBatchDBMessage.txt', $fl);
				$file_name[$j] = $direct[$j][0];
			}
			$j++;
		}
		$k = 0;
		foreach($file_name as $file_number){
			if($file_number){
				$filed[$k] = file_get_contents('C:\Mandra\\'.$file_number.'_TSaveBatchDBMessage.txt');
				
				$data[$k] = explode('End of Record',$filed[$k]);
				$i= 0;
				
				foreach($data[$k] as $transaction){
					if(strpos($transaction ,'SaveTransaction')){
						$internal[$k]['transaction'][$i] = explode('TSaveTransactionMessage',$transaction);
						
						$array[$k][$i] = array_map(
											function($v){
												return explode(PHP_EOL,$v);
											}, $internal[$k]['transaction'][$i]
										);
						$array[$k][$i][0] = '';
						$count = 0;
						if($array[$k][$i]){
							foreach($array[$k][$i][1] as $entry){
								if(strpos($entry, '=')){
									$array[$k][$i][1][$count] = explode('=', $entry);
									
									$toll_entry[$k][$i]['type'] = 'Transaction'; 
									$toll_entry[$k][$i]['Send mode'] = $array[$k][$i][1][1][1];
									$toll_entry[$k][$i]['pl_id'] = $array[$k][$i][1][2][1];
									$toll_entry[$k][$i]['ln_id'] = $array[$k][$i][1][3][1];
									$toll_entry[$k][$i]['dt_concluded'] = $array[$k][$i][1][4][1];
									$toll_entry[$k][$i]['tx_seq_nr'] = $array[$k][$i][1][5][1];
									$toll_entry[$k][$i]['ts_seq_nr'] = $array[$k][$i][1][6][1];
									$toll_entry[$k][$i]['us_id'] = $array[$k][$i][1][7][1];
									$toll_entry[$k][$i]['ent_plz_id'] = $array[$k][$i][1][8][1];
									$toll_entry[$k][$i]['ent_lane_id'] = $array[$k][$i][1][9][1];
									$toll_entry[$k][$i]['dt_started'] = $array[$k][$i][1][10][1];
									$toll_entry[$k][$i]['next_inc'] = $array[$k][$i][1][11][1];
									$toll_entry[$k][$i]['prev_inc'] = $array[$k][$i][1][12][1];
									$toll_entry[$k][$i]['ft_id'] = $array[$k][$i][1][13][1];
									$toll_entry[$k][$i]['pg_group'] = $array[$k][$i][1][14][1];
									$toll_entry[$k][$i]['cg_group'] = $array[$k][$i][1][15][1];
									$toll_entry[$k][$i]['vg_group'] = $array[$k][$i][1][16][1];
									$toll_entry[$k][$i]['mvc'] = $array[$k][$i][1][17][1];
									$toll_entry[$k][$i]['avc'] = $array[$k][$i][1][18][1];
									$toll_entry[$k][$i]['svc'] = $array[$k][$i][1][19][1];
									$toll_entry[$k][$i]['loc_curr'] = $array[$k][$i][1][20][1];
									$toll_entry[$k][$i]['loc_value'] = $array[$k][$i][1][21][1];
									$toll_entry[$k][$i]['ten_curr'] = $array[$k][$i][1][22][1];
									$toll_entry[$k][$i]['ten_value'] = $array[$k][$i][1][23][1];
									$toll_entry[$k][$i]['loc_change'] = $array[$k][$i][1][24][1];
									$toll_entry[$k][$i]['variance'] = $array[$k][$i][1][25][1];
									$toll_entry[$k][$i]['er_id'] = $array[$k][$i][1][26][1];
									$toll_entry[$k][$i]['pm_id'] = $array[$k][$i][1][27][1];
									$toll_entry[$k][$i]['card_nr'] = $array[$k][$i][1][28][1];
									$toll_entry[$k][$i]['ca_id'] = $array[$k][$i][1][29][1];
									$toll_entry[$k][$i]['ct_id'] = $array[$k][$i][1][30][1];
									$toll_entry[$k][$i]['conc_nr'] = $array[$k][$i][1][31][1];
									$toll_entry[$k][$i]['lm_id'] = $array[$k][$i][1][32][1];
									$toll_entry[$k][$i]['as_id'] = $array[$k][$i][1][33][1];
									$toll_entry[$k][$i]['reg_nr'] = $array[$k][$i][1][34][1];
									$toll_entry[$k][$i]['vouch_nr'] = $array[$k][$i][1][35][1];
									$toll_entry[$k][$i]['ac_nr'] = $array[$k][$i][1][36][1];
									$toll_entry[$k][$i]['rec_nr'] = $array[$k][$i][1][37][1];
									$toll_entry[$k][$i]['tick_nr'] = $array[$k][$i][1][38][1];
									$toll_entry[$k][$i]['bp_id'] = $array[$k][$i][1][39][1];
									$toll_entry[$k][$i]['fg_id'] = $array[$k][$i][1][40][1];
									$toll_entry[$k][$i]['dg_id'] = $array[$k][$i][1][41][1];
									$toll_entry[$k][$i]['rd_id'] = $array[$k][$i][1][42][1];
									$toll_entry[$k][$i]['rep_indic'] = $array[$k][$i][1][43][1];
									$toll_entry[$k][$i]['maint_indic'] = $array[$k][$i][1][44][1];
									$toll_entry[$k][$i]['req_indic'] = $array[$k][$i][1][45][1];
									$toll_entry[$k][$i]['iv_prt_indic'] = $array[$k][$i][1][46][1];
									$toll_entry[$k][$i]['ts_dt_started'] = $array[$k][$i][1][47][1];
									$toll_entry[$k][$i]['iv_nr'] = $array[$k][$i][1][48][1];
									$toll_entry[$k][$i]['td_id'] = $array[$k][$i][1][49][1];
									$toll_entry[$k][$i]['avc_seq_nr'] = $array[$k][$i][1][50][1];
									$toll_entry[$k][$i]['card_bank'] = $array[$k][$i][1][51][1];
									$toll_entry[$k][$i]['card_ac_nr'] = $array[$k][$i][1][52][1];
									$toll_entry[$k][$i]['tg_mfg_id'] = $array[$k][$i][1][53][1];
									$toll_entry[$k][$i]['tg_post_bal'] = $array[$k][$i][1][54][1];
									$toll_entry[$k][$i]['tg_reader'] = $array[$k][$i][1][55][1];
									$toll_entry[$k][$i]['tg_us_cat'] = $array[$k][$i][1][56][1];
									$toll_entry[$k][$i]['tg_card_type'] = $array[$k][$i][1][57][1];
									$toll_entry[$k][$i]['tg_serv_prov_id'] = $array[$k][$i][1][58][1];
									$toll_entry[$k][$i]['tg_issuer'] = $array[$k][$i][1][59][1];
									$toll_entry[$k][$i]['tg_tx_seq_nr'] = $array[$k][$i][1][60][1];
									
								}
								
								$count++;
							}
							
						}
						else{
							
						}
						
					}
					elseif(strpos($transaction ,'SaveIncident')){
						$internal[$k]['transaction'][$i] = explode('TSaveIncidentMessage',$transaction);
						
						$array[$k][$i] = array_map(
											function($v){
												return explode(PHP_EOL,$v);
											}, $internal[$k]['transaction'][$i]
										);
						$array[$k][$i][0] = '';
						$count = 0;
						if($array[$k][$i]){
							foreach($array[$k][$i][1] as $entry){
								if(strpos($entry, '=')){
									$array[$k][$i][1][$count] = explode('=', $entry);
									
									$toll_entry[$k][$i]['type'] = 'Incident'; 
									$toll_entry[$k][$i]['Send mode'] = $array[$k][$i][1][1][1];
									$toll_entry[$k][$i]['pl_id'] = $array[$k][$i][1][2][1];
									$toll_entry[$k][$i]['ln_id'] = $array[$k][$i][1][3][1];
									$toll_entry[$k][$i]['dt_generated'] = $array[$k][$i][1][4][1];
									$toll_entry[$k][$i]['in_seq_nr'] = $array[$k][$i][1][5][1];
									$toll_entry[$k][$i]['ir_type'] = $array[$k][$i][1][6][1];
									$toll_entry[$k][$i]['ir_subtype'] = $array[$k][$i][1][7][1];
									$toll_entry[$k][$i]['tx_seq_nr'] = $array[$k][$i][1][8][1];
									$toll_entry[$k][$i]['ts_seq_nr'] = $array[$k][$i][1][9][1];
									$toll_entry[$k][$i]['us_id'] = $array[$k][$i][1][10][1];
									$toll_entry[$k][$i]['ft_id'] = $array[$k][$i][1][11][1];
									$toll_entry[$k][$i]['pg_group'] = $array[$k][$i][1][12][1];
									$toll_entry[$k][$i]['cg_group'] = $array[$k][$i][1][13][1];
									$toll_entry[$k][$i]['vg_group'] = $array[$k][$i][1][14][1];
									$toll_entry[$k][$i]['mvc'] = $array[$k][$i][1][15][1];
									$toll_entry[$k][$i]['avc'] = $array[$k][$i][1][16][1];
									$toll_entry[$k][$i]['svc'] = $array[$k][$i][1][17][1];
									$toll_entry[$k][$i]['er_id'] = $array[$k][$i][1][18][1];
									$toll_entry[$k][$i]['pm_id'] = $array[$k][$i][1][19][1];
									$toll_entry[$k][$i]['card_nr'] = $array[$k][$i][1][20][1];
									$toll_entry[$k][$i]['ca_id'] = $array[$k][$i][1][21][1];
									$toll_entry[$k][$i]['ct_id'] = $array[$k][$i][1][22][1];
									$toll_entry[$k][$i]['tx_indic'] = $array[$k][$i][1][23][1];
									$toll_entry[$k][$i]['lm_id'] = $array[$k][$i][1][24][1];
									$toll_entry[$k][$i]['as_id'] = $array[$k][$i][1][25][1];
									$toll_entry[$k][$i]['rep_indic'] = $array[$k][$i][1][26][1];
									$toll_entry[$k][$i]['rd_id'] = $array[$k][$i][1][27][1];
									$toll_entry[$k][$i]['maint_indic'] = $array[$k][$i][1][28][1];
									$toll_entry[$k][$i]['req_indic'] = $array[$k][$i][1][29][1];
									$toll_entry[$k][$i]['ts_dt_started'] = $array[$k][$i][1][30][1];
									$toll_entry[$k][$i]['in_amt'] = $array[$k][$i][1][31][1];
									$toll_entry[$k][$i]['tg_bl_id'] = $array[$k][$i][1][32][1];
									$toll_entry[$k][$i]['tg_mfg_id'] = $array[$k][$i][1][33][1];
									$toll_entry[$k][$i]['tg_card_type'] = $array[$k][$i][1][34][1];
									$toll_entry[$k][$i]['tg_reader'] = $array[$k][$i][1][35][1];
									$toll_entry[$k][$i]['tg_tx_seq_nr'] = $array[$k][$i][1][36][1];
									
								}
								
								$count++;
							}
						}
					}
					else{
						$internal[$k]['transaction'][$i] = '';
						$array[$k][$i] = '';
					}
					$i++;
				}
			}
			else{
				$filed[$k] = '';
				$data[$k] = '';
				
			}
			$k++;
		}
		?><pre> <?php echo print_r($toll_entry); ?></pre> <?php exit;
		/*?><pre> <?php echo print_r($array); ?></pre> <?php exit;*/
		/*$i= 0;
		
		foreach($file as $line){
			if(strpos($line, 'SaveTransaction')){
				$data['start'][$i] = explode( 'TSaveTransactionMessage',$filed);
				$data['end'][$i] = explode( 'End of Record',$data['start'][$i][2]);
				if(!strpos($data['end'][$i],'Save')){
					
				}
			}
			
			$i++;
		}*/
		/*$data['file'] = file_get_contents('C:\Mandra\0000000294_TSaveBatchDBMessage.txt');
    	if(sizeof($data['file']) > 1){
    	foreach($data['file'] as $file){
    	$data['exp'] = explode('C:\Mandra\0000000294_TSaveBatchDBMessage.txt',$file);
    	}
    	}else{
     $data['exp'] = explode('C:\Mandra\0000000294_TSaveBatchDBMessage.txt',$data['file']);
    	}	*/
			
		?><pre><?php echo print_r($data[$k]['file']); ?></pre><?php exit; 
		$this->load->view('back/toolplaza_data', $data_end);
	}
	///////////////////////////////////////////////////////////////
	////	/** Login Logout START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function login(){
		$this->load->view('back/login');
	}
	public function do_login(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Email', 'required');
		$this->form_validation->set_rules('password','Password','required');
		if($this->form_validation->run() == FALSE){
			echo json_encode(array('response' => FALSE, 'message' => validation_errors()));

		}else{

			$admin_info  = $this->db->get_where('admin', array(
					'username' => $this->input->post('username'),
					'password' => sha1($this->input->post('password'))
				))->result_array();
			if($admin_info){
				$this->session->set_userdata('adminid',$admin_info[0]['id']);
				$this->session->set_userdata('fname',$admin_info[0]['fname']);
				$this->session->set_userdata('lname',$admin_info[0]['lname']);
				$this->session->set_userdata('role',$admin_info[0]['role']);
			 	$this->session->set_userdata('site',$admin_info[0]['site']);
                // echo "<pre>"; print_r($this->session->userdata('site')); exit;
				echo json_encode(array('response' => TRUE , 'message' => 'Successfull Login', 'is_redirect' => TRUE , 'redirect_url' => base_url().'admin/index'));
				
			}else{

				echo json_encode(array('response' => FALSE , 'message' => 'Invalid Username or wrong Passord')); exit;
			}
		}
	}
	public function logout(){

		$this->session->sess_destroy();
		redirect(base_url().'admin','refresh');
	}
	public function settings($para1 = ''){
		if(!$this->session->userdata('adminid'))
		{	
			return redirect('admin/login');
		}
		$this->load->library('form_validation');
		if($para1 == 'update_basic_info'){
			$this->form_validation->set_rules('fname','First Name','required|trim');
			$this->form_validation->set_rules('lname','Last Name','required|trim');
			$this->form_validation->set_rules('username','Username Name','required|trim');
			//$this->form_validation->set_rules('contact','First Name','required|trim');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			}else{
				$data = array();
				$data['fname'] = $this->input->post('fname');
				$data['lname'] = $this->input->post('lname');
				$data['username'] = $this->input->post('username');
				$this->db->where('id', $this->session->userdata('adminid'));
				$this->db->update('admin', $data);
				echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'admin/settings'));
            }		
		}elseif($para1 == 'update_pwd'){ 
				 $config=array(
				     array(
				          'field' => 'newpwd',
				          'label' => 'New Password',
				          'rules' => 'trim|required'
				          ),
				     array(
				          'field' => 'repwd',
				          'label' => 'Confirm Password',
				          'rules' => 'trim|required|matches[newpwd]'
				          )
				 );
				  $this->form_validation->set_rules('oldpwd','Old Password','required|trim');
				  $this->form_validation->set_rules($config);
				  if($this->form_validation->run() == FALSE){
				  		echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			
				  }else{
				  		$check_old = $this->db->get_where('admin',array('id' => $this->session->userdata('adminid'), 'password' => sha1($this->input->post('oldpwd'))))->result_array();
				  		//echo $this->db->last_query(); exit;
				  		if(empty($check_old)){
				  			echo json_encode(array('response' => FALSE , 'message' => 'You have enter incorrect old password')); exit;
				  		}else{
				  			$data = array();
				  			$data['password'] = sha1($this->input->post('newpwd'));
				  			$this->db->where('id', $this->session->userdata('adminid'));
							$this->db->update('admin', $data);
							echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'admin/settings'));
				  		}
				  }
		}
		else
		{
			$this->page_data['user'] = $this->db->get_where('admin',array('id' => $this->session->userdata('adminid')))->result_array();
			$this->page_data['page'] = 'settings';
			$this->load->view('back/settings',$this->page_data);
		}
		
	}
	
	///////////////////////////////////////////////////////////////
	////	/** Charts START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function check_tollplaza_dates($tollplaza = ''){
		$data = $this->Admin_model->get_tollplaza_dates($tollplaza);
		echo json_encode($data);
	}	
	public function searchforchart($para1 = ''){

		$tollplaza = $this->input->post('tollplaza');
		$month  = $this->input->post('formonth');
		$data = $this->Admin_model->get_chartdata($tollplaza, $month);
		
		$previous_year = date("Y-m-d",strtotime(@$data['chart']['month'].' -1 year'));
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
		$pre_year_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_year);
		
		$pre_month_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_monthDate);
		
		$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $data['mtr_id'] ))->result_array();
		$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];
        $sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		
		$this->page_data['mtrid'] = $data['mtr_id'];
		$this->page_data['page'] = 'Dashboard';
		$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->page_data['chart'] = $data['chart'];

		$this->page_data['revenue'] = $data['revenue'];
		$this->page_data['custom'] = 'custom_search';
		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_year_chart'] = $pre_year_data['chart'];
		$this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];
		
		$this->load->view('back/customize_chart_search', $this->page_data);
	}
	public function check_dtrtollplaza_dates($tollplaza = ''){
		$data = $this->Admin_model->get_dtrtollplaza_dates($tollplaza);
		
		
		echo json_encode($data);
	}		
	public function getdesiredchart(){
		if(!$this->session->userdata('adminid'))
		{	
			return redirect('admin/login');
		}
		$data = $this->Admin_model->chartdata();
		$previous_previous_month = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-2 month" ) );
		//echo $previous_previous_month; exit;
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
		$pre_pre_month_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_previous_month);
		$pre_month_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_monthDate);
		
		$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $data['mtr_id'] ))->result_array();
	    $month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		//echo "<pre>";
		//print_r($month_year); exit;
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];
        $sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] = $this->db->query($sql)->result_array();
		
		$this->page_data['mtrid'] = $data['mtr_id'];
		$this->page_data['plaza_id'] = $data['chart']['toolplaza_id'];
		$this->page_data['month'] = $data['chart']['month'];


		$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->page_data['chart'] = $data['chart'];

		$this->page_data['revenue'] = $data['revenue'];
		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_pre_month_chart'] = $pre_pre_month_data['chart'];
        $this->page_data['pre_pre_month_revenue'] = $pre_pre_month_data['revenue'];
		$this->page_data['page'] = 'Desired Chart';
		// echo "<pre>";
		// print_r($this->page_data); exit;
		$this->load->view('back/desired_chart', $this->page_data);
	}
	public function searchfordtrchart($para1 = ''){

		$tollplaza = $this->input->post('tollplaza');
		$month  = $this->input->post('formonth');
		
		$data = $this->Admin_model->dtr_chart_tooldata_month($tollplaza, $month);
		$this->page_data['month'] = $data['month'];
		$this->page_data['year'] = $data['year'];
		$this->page_data['dtr1'] = $data['dtr_first'];
		$this->page_data['dtr2'] = $data['dtr_first'];
		$this->page_data['page'] = 'Monthly DTR Chart';
		$this->page_data['custom'] = 'custom_search';
		$this->page_data['tollplaza'] = $data['tollplaza'];
		
		$this->load->view('back/customize_dtrchart_search', $this->page_data);
	}	
	public function searchfordtrmchart($para1 = ''){

		$month  = $this->input->post('formonth');
		
		$data = $this->Admin_model->dtrmchart_tooldata_month($month);
		/*?> <pre> <?php echo print_r($data);  ?> </pre> <?php exit;*/

		$this->page_data['month'] = $data['month'];
		$this->page_data['year'] = $data['year'];
		$this->page_data['dtr1'] = $data['dtr_tool_min'];
		$this->page_data['dtr2'] = $data['dtr_tool_min'];
		$this->page_data['page'] = 'M Traffic Chart';
		$this->page_data['custom'] = 'custom_search';
		$this->page_data['toll'] = $data['tollplaza'];
		$this->page_data['toolplaza'] = $data['toolplaza'];
		$this->load->view('back/customize_dtrmchart_search', $this->page_data);
	}
	public function searchfordesiredchart($para1 = ''){

		$tollplaza = $this->input->post('tollplaza');
		$month  = $this->input->post('formonth');
		$data = $this->Admin_model->get_chartdata($tollplaza, $month);
		$previous_previous_month = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-2 month" ) );
		//echo $previous_previous_month; exit;
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
		$pre_pre_month_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_previous_month);
		
		//$previous_year = date("Y-m-d",strtotime(@$data['chart']['month'].' -1 year'));
		//$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
		//$pre_year_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_year);
		$pre_month_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_monthDate);
		
		
		$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $data['mtr_id'] ))->result_array();
		$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];
        $sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		
		$this->page_data['mtrid'] = $data['mtr_id'];
		$this->page_data['page'] = 'Dashboard';
		$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->page_data['chart'] = $data['chart'];

		$this->page_data['revenue'] = $data['revenue'];
		$this->page_data['custom'] = 'custom_search';
		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_pre_month_chart'] = $pre_pre_month_data['chart'];
        $this->page_data['pre_pre_month_revenue'] = $pre_pre_month_data['revenue'];
        //echo '<pre>';
        //print_r($this->page_data); exit;
		$this->load->view('back/customize_desiredchart_search', $this->page_data);
	}
	public function get5yearchart(){
		if(!$this->session->userdata('adminid')){	
			return redirect('admin/login');
		}
		$duration = 6;
		for($year = 1; $year < $duration; $year++){
				$model_call[$year] = $this->model_call_nha_all_mtr_year($year);
			}
		$this->all_tollplaza_5year_mtr($model_call, $duration);
		
		
		$this->page_data['page'] = 'Five Years Chart';
		$this->page_data['duration'] = $duration;
		/*?> <pre><?php echo print_r($this->page_data); exit;*/
		/*?> <pre><?php echo print_r($tre_data); exit;*/
		$this->load->view('back/5yearchart', $this->page_data);
	}
	public function get5yeartollchart(){
		$time = 5;
		if($this->input->post('time') != NULL){
			$time = $this->input->post('time');
		}
		$duration = $time + 1;
		$id = $this->input->post('id');
		$this->page_data['duration'] = $duration;
		$this->page_data['page'] = 'Five Years Chart';
			if($id == 'none'){
				$this->page_data['id'] = $id;
				$id = '';
				for($year = 1; $year < $duration; $year++){
					$model_call[$year] = $this->model_call_nha_all_mtr_year($year, $duration);
				}
				$this->all_tollplaza_5year_mtr($model_call, $duration);
				
			}
			else{
				$this->page_data['id'] = $id;
				for($year = 1; $year < 6; $year++){
					$model_call[$year] = $this->model_call_nha_toll_mtr_year($year, $id);
				}
				$this->page_data['id'] = $id;
				$this->all_tollplaza_5year_mtr($model_call, $duration);
				
			}
		$this->load->view('back/includes/5yearchart/index', $this->page_data);
	}
	///////////////////////////////////////////////////////////////
	////	/** Traffic Counter Device *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function tcd($para1 = '', $para2 = ''){
		//It is worth mentioning here that the data collection from traffic counters is based on 5 classes and not 10 as done in MTR and DTR section.
		$this->page_data['page'] = 'Sensors Traffic Counting';
		if(!$this->session->userdata('adminid')){	
			return redirect('admin/login');
		}
		else{
			/*?> <pre> <?php echo print_r($this->session->userdata);exit;*/
			$this->load->model('tcd_model');
			$select = array('id','name'); $table = 'toolplaza'; $where = array('status' => '1');
			$this->page_data['toolplaza'] = $this->database_model->get_select($select, $table, $where)->result_array();
			$this->page_data['admin_name'] = $this->session->userdata['fname'].' '.$this->session->userdata['lname'];
			if($para1 == 'list'){
				$page = 'R';
				$table = 'tcd';
				$table_data = $this->tcd_model->get_table($table);
				$i = 0;
				foreach($table_data->result_array() as $row){
					$select = 'name'; 
					$table = 'toolplaza'; 
					$where = array('status' => '1', 'id' => $row['toolplaza_id']);
					$tcd_tool_name[$i] = $this->database_model->get_select($select, $table, $where)->result_array();

					$i++;
				}
				if(isset($tcd_tool_name)){
					$this->page_data['tool_name'] = $tcd_tool_name;
				}
				
				$this->page_data['tcd'] = $table_data->result_array();

				$this->load->view('back/tcd_list', $this->page_data);
			}
			elseif($para1 == 'add'){
				$page = 'C';			
				$this->load->view('back/add_tcd', $this->page_data);
			}
			elseif($para1 == 'do_add'){
				$page = 'C';
				$this->load->library('form_validation');
				$this->form_validation->set_rules('toolplaza_id','Tollplaza','required|trim');
				$this->form_validation->set_rules('datecreated','Date','required|trim');
				$this->form_validation->set_rules('description','Description','required|trim');
				$this->form_validation->set_rules('notes','Notes','required|trim');
				$this->form_validation->set_rules('class1','Car/Jeep passages','required|trim|is_natural');
				$this->form_validation->set_rules('class2','Wagons/Hiace passages','required|trim|is_natural');
				$this->form_validation->set_rules('class3','Buses/Coasters passages','required|trim|is_natural');
				$this->form_validation->set_rules('class4','2,3 Axle Trucks/Tractors/Trolleys passages','required|trim|is_natural');
				$this->form_validation->set_rules('class5','Above 3 Axle Articluated Trucks passages','required|trim|is_natural');
				$this->form_validation->set_rules('total','Total','required|trim|is_natural');
				if($this->form_validation->run() == FALSE){
					echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
				}else{

					$tcd_data['toolplaza_id'] = $this->input->post('toolplaza_id');
					$tcd_data['datecreated'] = $this->input->post('datecreated');
					$tcd_data['admin_id'] = $this->session->userdata('adminid');
					$tcd_data['class1'] = $this->input->post('class1');
					$tcd_data['class2'] = $this->input->post('class2');
					$tcd_data['class3'] = $this->input->post('class3');
					$tcd_data['class4'] = $this->input->post('class4');
					$tcd_data['class5'] = $this->input->post('class5');
					$tcd_data['total'] = $this->input->post('total');
					$tcd_data['status'] = '0';
					$tcd_data['add_date'] = time();
					$table = 'tcd'; $data = $tcd_data;
					$tcd_insert = $this->database_model->insert($table, $data);

					if(!$tcd_insert){
						echo json_encode(array('response' => FALSE , 'message' => 'Traffic Counter Report could not be added')); exit;
					}
					else{
						echo json_encode(array('response' => TRUE , 'message' => 'Added Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'admin/tcd'));
					}

				}
			}
			elseif($para1 == 'disapprove'){
				$page = 'U';
				$this->page_data['id'] = $id = $para2;
				$table = 'tcd'; $where = array('id' => $id);
				$check = $this->tcd_model->check_table($table, $where)->result_array();
				if(!$check){
					echo json_encode(array('response' => FALSE , 'message' => 'Traffic Counter Report does not exist')); exit;
				}
				else{
					$this->load->view('back/tcd_disapprove', $this->page_data);
				}
			}
			elseif($para1 == 'disapprove_do'){
				$page = 'U';
				$table = 'tcd'; $where = array('id' => $para2);
				$check = $this->database_model->get_where($table, $where)->result_array();
				if($check){
					if($check[0]['status'] == 0 || $check[0]['status'] == 1){
						if(empty($this->input->post('dissapprove_reason'))){
							echo json_encode(array('respose' => FALSE , 'message' => 'Please add reason for dissapproving this daily site report'));exit;	
						}
						else{
							$data['status'] = 2;
							$data['action_date'] = time();
							$data['disapprove_reason'] = $this->input->post('dissapprove_reason');
							$where = 'id'; $table = 'tcd';
							$this->database_model->update($where, $para2, $table, $data);
							echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/tcd')); exit;
						}
					}
					else{
						echo json_encode(array('respose' => FALSE , 'message' => 'Invalid Requestee'));exit;	
					}
				}
				else{
					echo json_encode(array('respose' => FALSE , 'message' => 'Invalid Request'));exit;		
				}
			}
			elseif($para1 == 'approve'){
				$data['status'] = 1;
				$data['action_date'] = time();
				$data['disapprove_reason'] = '';
				$where = 'id'; $table = 'tcd';
				$this->database_model->update($where, $para2, $table, $data);		
			}
			elseif($para1 == 'delete'){	
				$table = 'tcd'; $where = array('id' => $para2);
				$tcd_data = $this->database_model->get_where($table, $where)->result_array();
				$id = $dsr_updated[0]['supervisor_id'];
				$tool = $dsr_updated[0]['toolplaza_id'];
				$this->database_model->delete($para2, $table);			
			}
			elseif($para1 == 'view_reason'){
				$select = array('status','disapprove_reason'); $table = 'tcd'; $where = array('id' => $para2);
				$reason = $this->database_model->get_select($select,$table, $where)->result_array();
				/*?> <pre> <?php echo print_r($reason);exit;*/
				if($reason[0]['status'] == 2){
					echo "<span class='text-info'>".$reason[0]['disapprove_reason']."</span>";
				}
				else{
					echo "<span class='text-danger'>Invalid Request</span>";
				}
			}
			elseif($para1 == 'by_tollplaza'){
				if($para2 != ''){
					$select = 'id';$table = 'toolplaza'; $where = array('id' => $para2);
					$toolplaza = $this->database_model->get_select($select, $table, $where)->result_array();
					$tool = $toolplaza[0]['id'];
					$dsr = $this->tcd_model->_list($tool);
					$edit['dsr']  = $dsr;
					$this->load->view('back/dsr_list', $edit);
				}
				else{
					$tool = NULL;
					$dsr = $this->tcd_model->_list($tool);	
					$this->page_data['dsr']  = $dsr;
					$this->load->view('back/dsr_list', $this->page_data);
				}
			}
			else{
				$this->page_data['page'] = 'tcd';
				$this->load->view('back/tcd', $this->page_data);
			}
		}
	}
	public function traffic_counter_report($para1 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		else{
			$this->load->model('tcd_model');
			$table = 'tcd'; $where = array('id' => $para1);
			$tcd_data = $this->tcd_model->postload($table, $where);
			/*echo print_r($tcd_data);exit;*/
			/*?> <pre><?php echo print_r($tcd_data); exit;*/
			$this->load->view('back/tcd_report', $tcd_data);
		}
	}
	public function generate_tcrpdf($para1 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		else{
			$this->load->model('tcd_model');
			$table = 'tcd'; $where = array('id' => $para1);
			$tcd_data = $this->tcd_model->postload($table, $where);
			$pdfdata = $this->load->view('back/pdf_tcd', $tcd_data, TRUE);
			$para1 = 'TCR'; 
			if($para1 == 'TCR'){
				$para2 = 'Traffic Counter Report';
			}
			$pdf = $this->pdf_function($para1, $para2, $pdfdata);
		}

	}	
	//Algorithms
	public function all_tollplaza_5year_mtr($model_call, $duration){
		$total_traffic = 0; $total_not_exempt = 0; $total_exempt = 0; $total_revenue = 0; 
		for($year = 1; $year<$duration; $year++) {for($class = 1; $class < 6; $class++){ $total_not_exempt_clas[$class] = 0; $total_exempt_clas[$class] = 0; $total_revenue_clas[$class] = 0; $total_not_exempt_class[$year][$class] = 0; $total_exempt_class[$year][$class] = 0; $total_revenue_class[$year][$class] = 0;  } }
		for($year = 1; $year < $duration; $year++){
			$dat = $model_call[$year];
			$tre_data = $dat['tre_data']; $data = $dat['data'];
			
			$total_traffic = $total_traffic + $tre_data[$year]['total_traffic'];
			$total_not_exempt = $total_not_exempt + $tre_data[$year]['total_not_exempt'];
			$total_exempt = $total_exempt + $tre_data[$year]['total_exempt'];
			$total_revenue = $total_revenue + $tre_data[$year]['total_revenue'];
			if($data[$year]){
			for($class = 1; $class < 6; $class++){ 
				
				$total_not_exempt_class[$year][$class] = $total_not_exempt_class[$year][$class] + $tre_data[$year]['not_exempt'][$class]; 
				$total_exempt_class[$year][$class] = $total_exempt_class[$year][$class] + $tre_data[$year]['exempt'][$class];
				$total_revenue_class[$year][$class] = $total_revenue_class[$year][$class] + $tre_data[$year]['revenue'][$class];
				$total_not_exempt_clas[$class] = $total_not_exempt_clas[$class] + $tre_data[$year]['not_exempt'][$class];
				$total_exempt_clas[$class] = $total_exempt_clas[$class] + $tre_data[$year]['exempt'][$class];
				$total_revenue_clas[$class] = $total_revenue_clas[$class] + $tre_data[$year]['revenue'][$class];
			}
			}
			else{
				$this->page_data['message'] ='MTRs are not Uploaded yet';
			}
			$this->page_data['year'][$year] = $tre_data[$year]['year']; 
			$this->page_data['traffic'][$year] = $tre_data[$year]['total_traffic']; 
			$this->page_data['revenue'][$year] = $tre_data[$year]['total_revenue']; 
			$this->page_data['tollplaza'] = $tre_data[$year]['tollplaza'];
				
		}
		$name[1] = 'Car';
		$name[2] = 'Wagon';
		$name[3] = 'Truck';
		$name[4] = 'Bus';
		$name[5] = 'AT Truck';
		$this->page_data['data'] = $data;
		$this->page_data['tre_data'] = $tre_data;
		
		
		$this->page_data['total_traffic'] = $total_traffic;
		$this->page_data['name'] = $name;
		$this->page_data['total_not_exempt_class'] = $total_not_exempt_class;
		$this->page_data['total_not_exempt_clas'] = $total_not_exempt_clas;
		$this->page_data['total_not_exempt'] = $total_not_exempt;
		$this->page_data['total_exempt_class'] = $total_exempt_class;
		$this->page_data['total_exempt_clas'] = $total_exempt_clas;
		$this->page_data['total_exempt'] = $total_exempt;
		$this->page_data['total_revenue_class'] = $total_revenue_class;
		$this->page_data['total_revenue_clas'] = $total_revenue_clas;
		$this->page_data['total_revenue'] = $total_revenue;
		
		return $this->page_data;
	}
	public function model_call_nha_all_mtr_year($year){
		$data[$year] = $this->nha->mtr_per_year($year)->result_array();
		$tre_data[$year] = $this->nha->mtr_traffic_revenue_exempt($data[$year], $year);
		return ['data' => $data, 'tre_data' => $tre_data];
	}
	public function model_call_nha_toll_mtr_year($year, $toll){
		$data[$year] = $this->nha->mtr_toll_per_year($year, $toll)->result_array();
		$tre_data[$year] = $this->nha->mtr_traffic_revenue_exempt($data[$year], $year);
		return ['data' => $data, 'tre_data' => $tre_data];
	}
	public function pdf_function($para1, $para2, $pdfdata){
		$this->load->library("Pdf");
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('NHA '.$para1);
			$pdf->SetTitle('NHA '.$para2);
			$pdf->SetSubject($para1);
			$pdf->SetKeywords($para1.', PDF');

			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			$pdf->setFontSubsetting(true);
			$pdf->SetFont('dejavusans', '', 16, '', true);
			$pdf->AddPage('L', 'A2');

			$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
			$pdf->writeHTMLCell(0, 0, '', '', $pdfdata, 0, 1, 0, true, '', true);
			 $pdf->Output(strtolower($para1).'.pdf','I');
			//$pdf->Output(SERVER_RELATIVE_PATH . '/uploads/invoices/invoice' . $invoice_name . '.pdf', 'F');
		return $pdf;
	}
	///////////////////////////////////////////////////////////////
	////	/** DTR Charts START  *////////////////////
	///////////////////////////////////////////////////////////////
	public function dtr_chart($para1=''){
		if(!$this->session->userdata('adminid'))
		{	
			return redirect('admin/login');
		}
		$data = $this->Admin_model->dtr_chartdata();
		
		$datadtr = $this->db->select('*')->order_by('id','desc')->limit(1)->get('dtr')->result_array();
		$date_latest = date('n', strtotime($datadtr[0]['for_date']));
		$dtr_month_min=$this->db->where('MONTH(for_date)', $date_latest)->where('toolplaza',$datadtr[0]['toolplaza'])->order_by('for_date', 'asc')->get('dtr')->result_array();
		$dtr_month=$this->db->where('MONTH(for_date)', $date_latest)->where('toolplaza',$datadtr[0]['toolplaza'])->order_by('for_date', 'desc')->get('dtr')->result_array();
		$exempt = $this->db->get_where('dtr_exempt',array('dtr_id' => $datadtr[0]['id']))->result_array();
		
		$start_date = $dtr_month_min[0]['for_date'];
        $end_date = $dtr_month[0]['for_date'];
        
		$sql = "Select * From terrif Where FIND_IN_SET (".$dtr_month_min[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
        $tarrif =  $this->db->query($sql)->result_array();
		$this->page_data['dtr_month']=$data['chart']['month'];	
		$this->page_data['plaza_id'] = $data['chart']['toolplaza_id'];
		$this->page_data['month'] = $data['chart']['month'];

		$this->page_data['dtr'] = $dtr_month_min;
		$this->page_data['dtrid'] = $data['dtr_id'];
		$this->page_data['exempt'] = $this->db->get_where('dtr_exempt',array('dtr_id' => $this->page_data['dtrid']))->result_array();
		$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->page_data['chart'] = $data['chart'];
		$this->page_data['revenue'] = $data['revenue'];
		/*?> <pre> <?php echo print_r($this->page_data); exit; ?> </pre> <?php*/
		
		$this->page_data['page'] = 'Monthly DTR Chart';
				
		$this->load->view('back/dtr_chart', $this->page_data);
	}
	public function dtr_chart_tool($para1=''){
		if(!$this->session->userdata('adminid'))
		{	
			return redirect('admin/login');
		}
		$data = $this->Admin_model->dtr_chart_tooldata_asc();
		/*$datadesc = $this->Admin_model->dtr_chart_tooldata_desc();*/
		/*?> <pre> <?php echo print_r($data);  ?> </pre> <?php exit;*/

		$datadtr = $this->db->select('*')->order_by('id','desc')->limit(1)->get('dtr')->result_array();
		$this->page_data['month_asc']	= $data['month'];
		$this->page_data['tollplaza_asc'] = $data['tollplaza'];
		/*$this->page_data['month_desc']	= $datadesc['month'];
		$this->page_data['tollplaza_desc'] = $datadesc['tollplaza'];*/
		
		
		/*?> <pre> <?php echo print_r($this->page_data); exit; ?> </pre> <?php*/
		$this->page_data['page'] = 'M Traffic Chart';
		$this->load->view('back/dtr_chart_tool', $this->page_data);
	}

	///////////////////////////////////////////////////////////////
	////	/** DSR START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function dsr($para1 = '', $para2 = '', $para3 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		
		if($para1 == 'list'){
			$count = $this->input->post('count');
			if($count){
				$this->page_data['show'] = $count +200;
				$this->page_data['less'] = $count - 200;
				$id = NULL; $tool = NULL; $limit = $count;
				$dsr = $this->dsr_model->list_dsr_limit($id, $tool, $limit);
				$this->page_data['dsr']  = $dsr;
				$this->load->view('back/dsr_list', $this->page_data);
			}
			else{
				$this->page_data['show'] = 400;
				$id = NULL; $tool = NULL; $limit = 200;
				$dsr = $this->dsr_model->list_dsr_limit($id, $tool, $limit);
				$this->page_data['dsr']  = $dsr;
				$this->load->view('back/dsr_list', $this->page_data);
			}
		}
		elseif($para1 == 'by_tollplaza'){
			if($para2 != ''){
				$id = NULL;
				$table = 'toolplaza'; $where = array('id' => $para2);
				$toolplaza = $this->dsr_model->get_where($table, $where);
				$tool = $toolplaza[0]['id'];
				$dsr = $this->dsr_model->list_dsr($id, $tool);			
				$edit['dsr']  = $dsr;
				$this->load->view('back/dsr_list', $edit);
			}
			else{
				$id = NULL; $tool = NULL;
				$dsr = $this->dsr_model->list_dsr($id, $tool);			
				$this->page_data['dsr']  = $dsr;
				$this->load->view('back/dsr_list', $this->page_data);
			}
				
		}
		elseif($para1 == 'approve'){
			$data['status'] = 1;
			$data['updated_at'] = time();
			$where = 'id'; $table = 'dsr_updated';
			$this->dsr_model->update_dsr($where, $para2, $table, $data);		
		}
		elseif($para1 == 'disapprove'){
			$edit['id'] = $para2;
			$this->load->view('back/dsr_disapprove', $edit);
		}
		elseif($para1 == 'disapprove_do'){
			$table = 'dsr_updated'; $where = array('id' => $para2);
			$check = $this->dsr_model->get_where($table, $where);
			if($check){
				if($check[0]['status'] == 0 || $check[0]['status'] == 1){
					if(empty($this->input->post('dissapprove_reason'))){
						echo json_encode(array('respose' => FALSE , 'message' => 'Please add reason for dissapproving this daily site report'));exit;	
					}
					else{
						$data['status'] = 2;
						$data['updated_at'] = time();
						$data['disapprove_reason'] = $this->input->post('dissapprove_reason');
						$where = 'id'; $table = 'dsr_updated';
						$this->dsr_model->update_dsr($where, $para2, $table, $data);
						echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/dsr')); exit;
					}
				}
				else{
					echo json_encode(array('respose' => FALSE , 'message' => 'Invalid Requestee'));exit;	
				}
			}
			else{
				echo json_encode(array('respose' => FALSE , 'message' => 'Invalid Request'));exit;		
			}
		}
		elseif($para1 == 'view_reason'){
			$table = 'dsr_updated'; $where = array('id' => $para2);
			$reason = $this->dsr_model->get_where($table, $where);
			if($reason[0]['status'] == 2){
				echo "<span class='text-info'>".$reason[0]['disapprove_reason']."</span>";
			}
			else{
				echo "<span class='text-danger'>Invalid Request</span>";
			}
		}
		elseif($para1 == 'delete'){	
			$table = 'dsr_updated'; $where = array('id' => $para2);
			$dsr_updated = $this->dsr_model->get_where($table, $where);
			$id = $dsr_updated[0]['supervisor_id'];
			$tool = $dsr_updated[0]['toolplaza_id'];
			$this->dsr_model->delete_dsr($id, $para2);			
		}
		else{
			$edit['page'] = 'dsr'; $edit['page_url'] = $edit['page'];
			$table = 'toolplaza'; $where = array('status' => 1);
			$edit['tollplaza'] = $this->dsr_model->get_where($table, $where);
			$this->load->view('back/dsr', $edit);
		}
		
	}
	public function daily_site_report($para1 = ''){
		$table = 'dsr_updated'; $where = array('id' => $para1);
		$dsr_updated = $this->dsr_model->get_where($table, $where);
		$id = $dsr_updated[0]['supervisor_id'];
		$tool =  $dsr_updated[0]['toolplaza_id'];
		
		$page = 'R'; //CRUD Read
		//Some data is loaded to run data into dsr variable like Staff, north, south from dsr_lane, and dsr staff tables
		$preload_data =$this->dsr_model->sitereport_data_preload($id, $tool, $page, $para1);
		$edit = $preload_data;	 /*?><pre> <?php echo print_r($edit);exit;*/
		//data is loaded into dsr variable where new layout data is converted to old layout data so that it can be merged easily with older work
		$data  = $this->dsr_model->dsr_data($id, $tool, $edit,$para1);
		$edit['dsr'] = $data['dsr'];
		$edit['dsr_staff'] = $data['dsr_staff'];
		//Some data is loaded from dsr variable
		$data = $this->dsr_model->sitereport_data_post($edit);	
		$edit = $data; $edit['toolplaza_id'] = $tool;
		/*?><pre> <?php echo print_r($edit); exit;*/
		
		$this->load->view('front/toolplaza/sitereport', $edit);
	}
	
	///////////////////////////////////////////////////////////////
	////	/** Plaza Staff START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function tpstaff($para1 = '', $para2 = '', $para3 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['tpstaff'] = $this->db->get('tpstaff')->result_array();
			$this->load->view('back/tpstaff_list', $this->page_data);
		}
		elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('tpstaff');
		}
		else{
			$this->page_data['page'] = 'Toll Plaza Staff';
			$this->load->view('back/tpstaff', $this->page_data);
		}
		
	}
	public function tpstaff_add(){
		if(!$this->session->userdata('adminid')){			
			return redirect('admin/login');

		}
		$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->load->view('back/add_tpstaff', $this->page_data);
	}
	public function tpstaff_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  					<button type="button" class="close" data-dismiss="alert">&times;</button>
  					<strong>OOPS!</strong> Invalid Request
					</div>'; exit;

		}
		$this->page_data['tpstaff'] = $this->db->get_where('tpstaff',array('id' => $para1))->result_array();
		$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->load->view('back/edit_tpstaff', $this->page_data);
	}
   	public function tpstaff_add_do(){
		{
			if(!$this->session->userdata('adminid')){

				echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('first_name','First name','required|trim');
			$this->form_validation->set_rules('last_name','Last Name','required|trim');
			$this->form_validation->set_rules('toolplaza','Tool Plaza','required|trim');
			$this->form_validation->set_rules('designation','Designation','required|trim');
			$this->form_validation->set_rules('contact','Contact','required|trim');
			if($this->form_validation->run() == TRUE){
				$data = array(
						'tollplaza' 	=> $this->input->post('toolplaza'),
						'fname' 		=> $this->input->post('first_name'),
						'lname' 		=> $this->input->post('last_name'),
						'designation' 	=> $this->input->post('designation'),
						'contact' 		=> $this->input->post('contact'),
					);
				$this->db->insert('tpstaff', $data);
				echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/tpstaff')); exit;
			}
				else{

				echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
			}
		}
	}
	public function edit_tpstaff_do($staff_id = ''){
		if(!$staff_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}

		if(!$this->session->userdata('adminid')){
			
			echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First name','required|trim');
		$this->form_validation->set_rules('last_name','Last Name','required|trim');
		$this->form_validation->set_rules('status','Status','required|trim');
		
		$this->form_validation->set_rules('designation','Designation','required|trim');
		$this->form_validation->set_rules('contact','Contact','required|trim');
		if($this->form_validation->run() == TRUE){
			 $this->db->where('fname' , $this->input->post('first_name'));
			 $this->db->where('lname' , $this->input->post('last_name'));
			 $this->db->where('designation' , $this->input->post('designation'));
			 $this->db->where('id != ', $staff_id,FALSE);
			 $check_id = $this->db->get('tpstaff')->result_array();
			 if($check_id){
			 	echo json_encode(array('respose' => FALSE , 'message' => 'This Staff Member already exists'));exit;

			 }
			$data = array(
					
					'fname' 	=> $this->input->post('first_name'),
					'lname' 	=> $this->input->post('last_name'),
					'tollplaza' => $this->input->post('toolplaza'),
					'status' => $this->input->post('status'),				
					'designation' => $this->input->post('designation'),
					'contact' => $this->input->post('contact')
				);
			$this->db->where('id', $staff_id);
			$this->db->update('tpstaff', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/tpstaff')); exit;
		}
		else{

			echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		}

	}	

	///////////////////////////////////////////////////////////////
	////	/** TollPlaza START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function tollplaza($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['toolplza'] = $this->db->get('toolplaza')->result_array();
			$this->load->view('back/toolplaza_list', $this->page_data);
			
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('toolplaza');
		}elseif ($para1 == 'tp_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('toolplaza', $data);
           echo $para3;
        }elseif ($para1 == 'gm_publish_set') {
            $plaza = $para2;
            if ($para3 == 'true') {
                $data['google_map_status'] = '1';
            } else {
                $data['google_map_status'] = '0';
            }
            $this->db->where('id', $plaza);
            $this->db->update('toolplaza', $data);
			
           echo $para3;
        }else{
        	$this->page_data['page'] = 'Tollplaza';
			$this->load->view('back/tooolplaza', $this->page_data);
		}
		
		
	}
	public function toolplaza_add(){
		if(!$this->session->userdata('adminid')){
			return redirect('admin/login');
		}
		$this->load->view('back/add_toolplaza');
	}
	public function add_plaza_do(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('toolplazaname',' Tool Plaza Name','required|trim');
		if($this->form_validation->run() == TRUE){
			$data = array(
				'name' => $this->input->post('toolplazaname'),
				'status' => 0
				);
			$this->db->insert('toolplaza',$data);
			echo json_encode(array('response' => true, 'message' => 'Tool Plaza Added Successfully','is_redirect' => True,'redirect_url' => base_url().'admin/tollplaza')); exit;
		}else{

			echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;

		}
	}
	public function toolplaza_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;

		}
		$this->page_data['toolplza'] = $this->db->get_where('toolplaza',array('id' => $para1))->result_array();
		$this->load->view('back/edit_toolplaza', $this->page_data);
	}
	public function edit_plaza_do($plaza_id = ''){
		if(!$plaza_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('toolplazaname',' Tool Plaza Name','required|trim');
		if($this->form_validation->run() == TRUE){
			$data['name'] = $this->input->post('toolplazaname');
			$this->db->where('id',$plaza_id);
			$this->db->update('toolplaza',$data);
				echo json_encode(array('response' => true, 'message' => 'Tool plaza updated successfully','is_redirect' => True,'redirect_url' => base_url().'admin/tollplaza')); exit;
			}else{

				echo json_encode(array('response' => TRUE , 'message' => validation_errors())); exit;

		}
	}

	///////////////////////////////////////////////////////////////
	////	/** Supervisor START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function toolplaza_supervisor($para1 = '' , $para2 = '', $para3 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['supervisor'] = $this->db->get('tpsupervisor')->result_array();
			$this->load->view('back/toolplaza_supervisor_list', $this->page_data);

		}elseif ($para1 == 'tps_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('tpsupervisor', $data);
			
           echo $para3;
        }elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('tpsupervisor');
		}else{
			$this->page_data['page'] = 'Toll Plaza Supervisor';
			$this->load->view('back/tp_supervisor', $this->page_data);
		}

	}
	public function toolplaza_supervisor_add(){
		if(!$this->session->userdata('adminid'))
		{
			return redirect('admin/login');
		}
		$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->load->model('Inventory_model');
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
		$this->load->view('back/add_tpsupervisor', $this->page_data);
	}
	public function add_tpsupervisor_do(){
		if(!$this->session->userdata('adminid')){
			
			echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First name','required|trim');
		$this->form_validation->set_rules('last_name','Last Name','required|trim');
		$this->form_validation->set_rules('username','Username','required|trim|is_unique[tpsupervisor.username]');
		$this->form_validation->set_rules('Password','Password','required|trim');
		$this->form_validation->set_rules('role','Role','required|trim');
		$this->form_validation->set_rules('toolplaza','Tool Plaza','required|trim');
		$this->form_validation->set_rules('tsp_id','TSP Name','required|trim');
		$this->form_validation->set_rules('site_id','Site Name','required|trim');
		$this->form_validation->set_rules('contact','Contact','required|trim');
		if($this->form_validation->run() == TRUE){
			$data = array(
					'tollplaza' => $this->input->post('toolplaza'),
					'role' 		=> $this->input->post('role'),
					'tsp' 		=> $this->input->post('tsp_id'),
					'site'		=> $this->input->post('site_id'),
					'fname' 	=> $this->input->post('first_name'),
					'lname' 	=> $this->input->post('last_name'),
					'username' 	=> $this->input->post('username'),
					'password'  => sha1($this->input->post('Password')),
					'contact' 	=> $this->input->post('contact'),
					'adddate'   => time(),
					'status' 	=> 0
				);
			$this->db->insert('tpsupervisor', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/toolplaza_supervisor')); exit;
		}else{

			echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		}
	}
	public function toolplaza_supervisor_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  					<button type="button" class="close" data-dismiss="alert">&times;</button>
  					<strong>OOPS!</strong> Invalid Request
					</div>'; exit;

		}
		$this->page_data['supervisor'] = $this->db->get_where('tpsupervisor',array('id' => $para1))->result_array();
		$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->load->model('Inventory_model');
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
		$this->load->view('back/edit_tpsupervisor', $this->page_data);
	}
	public function edit_tpsupervisor_do($supervisor_id = '')	{
		if(!$supervisor_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}

		if(!$this->session->userdata('adminid')){
			
			echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First name','required|trim');
		$this->form_validation->set_rules('last_name','Last Name','required|trim');
		$this->form_validation->set_rules('username','User Name','required|trim');
		$this->form_validation->set_rules('toolplaza','Tool Plaza','required|trim');
		$this->form_validation->set_rules('role','Role','required|trim');
		$this->form_validation->set_rules('contact','Contact','required|trim');
		$this->form_validation->set_rules('tsp_id','TSP Name','required|trim');
		$this->form_validation->set_rules('site_id','Site Name','required|trim');
		if($this->form_validation->run() == TRUE){
			 $this->db->where('username' , $this->input->post('username'));
			 $this->db->where('id != ', $supervisor_id,FALSE);
			 $check_email = $this->db->get('tpsupervisor')->result_array();
			 if($check_email){
			 	echo json_encode(array('respose' => FALSE , 'message' => 'This Username address already exists'));exit;

			 }
			$data = array(
					'tollplaza' => $this->input->post('toolplaza'),
					'fname' 	=> $this->input->post('first_name'),
					'lname' 	=> $this->input->post('last_name'),
					'username' 	=> $this->input->post('username'),
					'role' 		=> $this->input->post('role'),
					'contact' 	=> $this->input->post('contact'),
					'tsp' 		=> $this->input->post('tsp_id'),
					'site' 		=> $this->input->post('site_id'),
					'adddate'   => time(),
					'status' 	=> 0
				);
			$this->db->where('id', $supervisor_id);
			$this->db->update('tpsupervisor', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/toolplaza_supervisor')); exit;
		}else{

			echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		}

	}
	public function toolplaza_supervisor_password($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;

		}
		$this->page_data['supervisor_id'] = $this->db->get_where('tpsupervisor',array('id' => $para1))->row()->id;
		$this->load->view('back/supervisor_password' , $this->page_data);
	}
	public function update_tpsupervisor_password($supervisor_id = ''){
		if(!$this->session->userdata('adminid')){
			
			echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		}
		if(!$supervisor_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password','Password','required|trim');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
		if($this->form_validation->run() == TRUE){
			 
			$data = array(
					'password' 	=> sha1($this->input->post('password'))
				);
			$this->db->where('id', $supervisor_id);
			$this->db->update('tpsupervisor', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/toolplaza_supervisor')); exit;
		}else{

			echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		}

	}
	
	///////////////////////////////////////////////////////////////
	////	/** Member START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function member($para1 = '' , $para2 = '', $para3 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['supervisor'] = $this->db->get('member')->result_array();
			$this->load->view('back/member_list', $this->page_data);

		}elseif ($para1 == 'tps_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('member', $data);
			
           echo $para3;
        }elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('member');
		}else{
			$this->page_data['page'] = 'Member';
			$this->load->view('back/member', $this->page_data);
		}

	}
	public function member_add(){
		$this->load->model('Inventory_model');
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
		$this->load->view('back/add_member', $this->page_data);

	}
	public function add_member_do(){

		if(!$this->session->userdata('adminid')){
			
			echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First name','required|trim');
		$this->form_validation->set_rules('last_name','Last Name','required|trim');
		$this->form_validation->set_rules('username','Username','required|trim|is_unique[member.username]');
		$this->form_validation->set_rules('Password','Password','required|trim');
		$this->form_validation->set_rules('contact','Contact','required|trim');
		$this->form_validation->set_rules('tsp_id','TSP Name','required|trim');
		$this->form_validation->set_rules('site_id','Site Name','required|trim');
		if($this->form_validation->run() == TRUE){
			$data = array(
					'fname' 	=> $this->input->post('first_name'),
					'lname' 	=> $this->input->post('last_name'),
					'username' 	=> $this->input->post('username'),
					'password'  => sha1($this->input->post('Password')),					
					'contact' => $this->input->post('contact'),
					'tsp' => $this->input->post('tsp_id'),
					'site' => $this->input->post('site_id'),
					'adddate'   => time(),
					'status' 	=> 0
				);
			$this->db->insert('member', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/member')); exit;
		}else{

			echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		}
	}
	public function member_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;

		}
		$this->page_data['member'] = $this->db->get_where('member',array('id' => $para1))->result_array();
		$this->load->model('Inventory_model');
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
		$this->load->view('back/edit_member', $this->page_data);
	}
	public function edit_member_do($member_id = ''){
		if(!$this->session->userdata('adminid')){
			
			echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		}
		if(!$member_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First name','required|trim');
		$this->form_validation->set_rules('last_name','Last Name','required|trim');
		$this->form_validation->set_rules('username','User Name','required|trim');	
		$this->form_validation->set_rules('contact','Contact','required|trim');
		$this->form_validation->set_rules('tsp_id','TSP Name','required|trim');
		$this->form_validation->set_rules('site_id','Site Name','required|trim');
		if($this->form_validation->run() == TRUE){
			 $this->db->where('username' , $this->input->post('username'));
			 $this->db->where('id != ', $member_id,FALSE);
			 $check_email = $this->db->get('member')->result_array();
			 if($check_email){
			 	echo json_encode(array('respose' => FALSE , 'message' => 'This Username address already exists'));exit;

			 }
			$data = array(
					
					'fname' 	=> $this->input->post('first_name'),
					'lname' 	=> $this->input->post('last_name'),
					'username' 	=> $this->input->post('username'),					
					'contact' => $this->input->post('contact'),
					'tsp' => $this->input->post('tsp_id'),
					'site' => $this->input->post('site_id'),
					'adddate'   => time(),
					'status' 	=> 0
				);
			$this->db->where('id', $member_id);
			$this->db->update('member', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/member')); exit;
		}else{

			echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		}

	}
	public function member_password($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;

		}
		$this->page_data['member_id'] = $this->db->get_where('member',array('id' => $para1))->row()->id;
		$this->load->view('back/member_password' , $this->page_data);
	}
	public function update_member_password($member_id = ''){
		if(!$this->session->userdata('adminid')){
			
			echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		}
		if(!$member_id){
			echo json_encode(array('response' => False , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password','Password','required|trim');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
		if($this->form_validation->run() == TRUE){
			 
			$data = array(
					
					'password' 	=> sha1($this->input->post('password'))
					
					
				);
			$this->db->where('id', $member_id);
			$this->db->update('member', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/member')); exit;
		}else{

			echo json_encode(array('respnose' => FALSE , 'message' => validation_errors()));exit;
		}
	}
	
/////////////////////////////////////////////////////
	/** sub admins START */
////////////////////////////////////////////////////
	public function admins($para1 = '' , $para2 = '', $para3 = ''){
		if(!$this->session->userdata('adminid'))
		{	
			return redirect('admin/login');
		}
		if($para1 == 'list'){
			$this->page_data['admin'] = $this->db->get('admin')->result_array();
			$this->load->view('back/admin_list', $this->page_data);

		}elseif ($para1 == 'tps_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('admin', $data);
			
           echo $para3;
        }elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('admin');
		}else{
			$this->page_data['page'] = 'admin';
			$this->load->view('back/admin', $this->page_data);
		}

	}
	public function admin_add(){
		$this->load->model('Inventory_model');
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
		$this->load->view('back/add_admin', $this->page_data);
	}
	public function add_admin_do(){

		if(!$this->session->userdata('adminid')){
			
			echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First name','required|trim');
		$this->form_validation->set_rules('last_name','Last Name','required|trim');
		$this->form_validation->set_rules('username','Username','required|trim|is_unique[member.username]');
		$this->form_validation->set_rules('Password','Password','required|trim');
		$this->form_validation->set_rules('contact','Contact','required|trim');
		$this->form_validation->set_rules('tsp_id','TSP Name','required|trim');
		$this->form_validation->set_rules('site_id','Site Name','required|trim');
		if($this->form_validation->run() == TRUE){
			$data = array(
					'fname' 	=> $this->input->post('first_name'),
					'lname' 	=> $this->input->post('last_name'),
					'username' 	=> $this->input->post('username'),
					'password'  => sha1($this->input->post('Password')),
					'tsp' => $this->input->post('tsp_id'),					
					'site' => $this->input->post('site_id'),
					'adddate'   => time(),
					'status' 	=> 0,
					'role'     =>  $this->input->post('role')
				);
			$this->db->insert('admin', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/admins')); exit;
		}else{

			echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		}
	}
	function admin_edit($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;

		}
		$this->load->model('Inventory_model');
		$this->page_data['admin'] = $this->db->get_where('admin',array('id' => $para1))->result_array();
		$this->page_data['sites'] = $this->Inventory_model->getsites();
		$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
		$this->load->view('back/edit_admin', $this->page_data);
	}
	function edit_admin_do($admin_id = ''){
		//echo $admin_id; exit;
		//if(!$this->session->userdata('adminid')){
			
		//	echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		//}
		if(!$admin_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('first_name','First name','required|trim');
		$this->form_validation->set_rules('last_name','Last Name','required|trim');
		$this->form_validation->set_rules('username','User Name','required|trim');
		$this->form_validation->set_rules('contact','Contact','required|trim');
		$this->form_validation->set_rules('role','Role','required|trim');
		$this->form_validation->set_rules('tsp_id','TSP Name','required|trim');
		$this->form_validation->set_rules('site_id','Site Name','required|trim');
		if($this->form_validation->run() == TRUE){
			 $this->db->where('username' , $this->input->post('username'));
			 $this->db->where('id != ', $admin_id,FALSE);
			 $check_email = $this->db->get('admin')->result_array();
			 if($check_email){
			 	echo json_encode(array('respose' => FALSE , 'message' => 'This Username address already exists'));exit;

			 }
			$data = array(
					
					'fname' => $this->input->post('first_name'),
					'lname' => $this->input->post('last_name'),
					'username' => $this->input->post('username'),			
					'contact' => $this->input->post('contact'),
					'adddate' => time(),
					'status' => 0,
					'role'=>$this->input->post('role'),
					'tsp' => $this->input->post('tsp_id'),
					'site' => $this->input->post('site_id')
				);
			$this->db->where('id', $admin_id);
			$this->db->update('admin', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/admins')); exit;
		}else{

			echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		}

	}
	public function admins_password($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;

		}
		$this->page_data['admin_id'] = $this->db->get_where('admin',array('id' => $para1))->row()->id;
		$this->load->view('back/admin_password' , $this->page_data);
	}
	public function update_admins_password($admin_id = ''){
		if(!$this->session->userdata('adminid')){
			
			echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		}
		if(!$admin_id){
			echo json_encode(array('response' => False , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password','Password','required|trim');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
		if($this->form_validation->run() == TRUE){
			 
			$data = array(
					
					'password' 	=> sha1($this->input->post('password'))
					
					
				);
			$this->db->where('id', $admin_id);
			$this->db->update('admin', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/admins')); exit;
		}else{

			echo json_encode(array('respnose' => FALSE , 'message' => validation_errors()));exit;
		}
	}

	/** sub admins END */

	///////////////////////////////////////////////////////////////
	////	/** Tarrif START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function tarrif($para1 = '', $para2 = '', $para3 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			
			$this->page_data['terrif']  = $this->db->get('terrif')->result_array();

			$this->load->view('back/terrif_list', $this->page_data);

		}elseif($para1 == 'view'){
			$this->page_data['terrif']  = $this->db->get_where('terrif',array('id' => $para2))->result_array();

			$this->load->view('back/view_terrif', $this->page_data);

		}elseif($para1 == 'add'){
			$this->page_data['plaza']  = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('back/tarrif_add', $this->page_data);

		}elseif($para1 == 'edit'){
			$this->page_data['plaza']  = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->page_data['terrif']  = $this->db->get_where('terrif',array('id' => $para2))->result_array();

			$this->load->view('back/edit_terrif', $this->page_data);

		}elseif($para1 == 'add_tarrif'){

			$plaza = $this->input->post('plaza');
			if(empty($plaza)){
				echo json_encode(array('respose' => FALSE , 'message' => 'Please choose plaza'));exit;	
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('class_1_desc','Class1 Description','required|trim');
			$this->form_validation->set_rules('class_1_rate','Class1 Rate','required|trim');
			$this->form_validation->set_rules('class_2_desc','Class2 Description','required|trim');
			$this->form_validation->set_rules('class_2_rate','Class2 Rate','required|trim');
			$this->form_validation->set_rules('class_3_desc','Class3 Description','required|trim');
			$this->form_validation->set_rules('class_3_rate','Class3 Rate','required|trim');
			$this->form_validation->set_rules('class_4_desc','Class4 Description','required|trim');
			$this->form_validation->set_rules('class_4_rate','Class4 Rate','required|trim');
			$this->form_validation->set_rules('class_5_desc','Class5 Description','required|trim');
			$this->form_validation->set_rules('class_5_rate','Class5 Rate','required|trim');
			$this->form_validation->set_rules('class_6_desc','Class6 Description','required|trim');
			$this->form_validation->set_rules('class_6_rate','Class6 Rate','required|trim');
			$this->form_validation->set_rules('class_7_desc','Class7 Description','required|trim');
			$this->form_validation->set_rules('class_7_rate','Class7 Rate','required|trim');
			$this->form_validation->set_rules('class_8_desc','Class8 Description','required|trim');
			$this->form_validation->set_rules('class_8_rate','Class8 Rate','required|trim');
			$this->form_validation->set_rules('class_9_desc','Class9 Description','required|trim');
			$this->form_validation->set_rules('class_9_rate','Class9 Rate','required|trim');
			$this->form_validation->set_rules('class_10_desc','Class10 Description','required|trim');
			$this->form_validation->set_rules('class_10_rate','Class10 Rate','required|trim');
			$this->form_validation->set_rules('start_date','Effective From','required|trim');
			$this->form_validation->set_rules('end_date','Effective To','required|trim');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('respnose' => FALSE , 'message' => validation_errors()));exit;
			}else{
				$plazas = implode (",", $plaza);
				$data['toolplaza'] 				= 	$plazas;
				$data['class_1_description'] 	= 	$this->input->post('class_1_desc');
				$data['class_1_value'] 			= 	$this->input->post('class_1_rate');
				$data['class_2_description'] 	= 	$this->input->post('class_2_desc');
				$data['class_2_value'] 			= 	$this->input->post('class_2_rate');
				$data['class_3_description'] 	= 	$this->input->post('class_3_desc');
				$data['class_3_value'] 			= 	$this->input->post('class_3_rate');
				$data['class_4_description'] 	= 	$this->input->post('class_4_desc');
				$data['class_4_value'] 			= 	$this->input->post('class_4_rate');
				$data['class_5_description'] 	= 	$this->input->post('class_5_desc');
				$data['class_5_value'] 			= 	$this->input->post('class_5_rate');
				$data['class_6_description'] 	= 	$this->input->post('class_6_desc');
				$data['class_6_value'] 			= 	$this->input->post('class_6_rate');
				$data['class_7_description'] 	= 	$this->input->post('class_7_desc');
				$data['class_7_value'] 			= 	$this->input->post('class_7_rate');
				$data['class_8_description'] 	= 	$this->input->post('class_8_desc');
				$data['class_8_value'] 			= 	$this->input->post('class_8_rate');
				$data['class_9_description'] 	= 	$this->input->post('class_9_desc');
				$data['class_9_value'] 			= 	$this->input->post('class_9_rate');
				$data['class_10_description'] 	= 	$this->input->post('class_10_desc');
				$data['class_10_value'] 		= 	$this->input->post('class_10_rate');
				$data['start_date'] 			= 	str_replace('/', '-', $this->input->post('start_date'));
				$data['end_date'] 				= 	str_replace('/', '-', $this->input->post('end_date'));
				$data['date'] 					= 	time();
				$this->db->insert('terrif',$data);
				echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/tarrif')); exit;


			}

		}elseif($para1 == 'update_terrif'){
			
			$plaza = $this->input->post('plaza');
			if(empty($plaza)){
				echo json_encode(array('respose' => FALSE , 'message' => 'Please choose plaza'));exit;	
			}
			$this->load->library('form_validation');
			$this->form_validation->set_rules('class_1_desc','Class1 Description','required|trim');
			$this->form_validation->set_rules('class_1_rate','Class1 Rate','required|trim');
			$this->form_validation->set_rules('class_2_desc','Class2 Description','required|trim');
			$this->form_validation->set_rules('class_2_rate','Class2 Rate','required|trim');
			$this->form_validation->set_rules('class_3_desc','Class3 Description','required|trim');
			$this->form_validation->set_rules('class_3_rate','Class3 Rate','required|trim');
			$this->form_validation->set_rules('class_4_desc','Class4 Description','required|trim');
			$this->form_validation->set_rules('class_4_rate','Class4 Rate','required|trim');
			$this->form_validation->set_rules('class_5_desc','Class5 Description','required|trim');
			$this->form_validation->set_rules('class_5_rate','Class5 Rate','required|trim');
			$this->form_validation->set_rules('class_6_desc','Class6 Description','required|trim');
			$this->form_validation->set_rules('class_6_rate','Class6 Rate','required|trim');
			$this->form_validation->set_rules('class_7_desc','Class7 Description','required|trim');
			$this->form_validation->set_rules('class_7_rate','Class7 Rate','required|trim');
			$this->form_validation->set_rules('class_8_desc','Class8 Description','required|trim');
			$this->form_validation->set_rules('class_8_rate','Class8 Rate','required|trim');
			$this->form_validation->set_rules('class_9_desc','Class9 Description','required|trim');
			$this->form_validation->set_rules('class_9_rate','Class9 Rate','required|trim');
			$this->form_validation->set_rules('class_10_desc','Class10 Description','required|trim');
			$this->form_validation->set_rules('class_10_rate','Class10 Rate','required|trim');
			$this->form_validation->set_rules('start_date','Effective From','required|trim');
			$this->form_validation->set_rules('end_date','Effective To','required|trim');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('respnose' => FALSE , 'message' => validation_errors()));exit;
			}else{
				$plazas = implode (",", $plaza);
				$data['toolplaza'] 				= 	$plazas;
				$data['class_1_description'] 	= 	$this->input->post('class_1_desc');
				$data['class_1_value'] 			= 	$this->input->post('class_1_rate');
				$data['class_2_description'] 	= 	$this->input->post('class_2_desc');
				$data['class_2_value'] 			= 	$this->input->post('class_2_rate');
				$data['class_3_description'] 	= 	$this->input->post('class_3_desc');
				$data['class_3_value'] 			= 	$this->input->post('class_3_rate');
				$data['class_4_description'] 	= 	$this->input->post('class_4_desc');
				$data['class_4_value'] 			= 	$this->input->post('class_4_rate');
				$data['class_5_description'] 	= 	$this->input->post('class_5_desc');
				$data['class_5_value'] 			= 	$this->input->post('class_5_rate');
				$data['class_6_description'] 	= 	$this->input->post('class_6_desc');
				$data['class_6_value'] 			= 	$this->input->post('class_6_rate');
				$data['class_7_description'] 	= 	$this->input->post('class_7_desc');
				$data['class_7_value'] 			= 	$this->input->post('class_7_rate');
				$data['class_8_description'] 	= 	$this->input->post('class_8_desc');
				$data['class_8_value'] 			= 	$this->input->post('class_8_rate');
				$data['class_9_description'] 	= 	$this->input->post('class_9_desc');
				$data['class_9_value'] 			= 	$this->input->post('class_9_rate');
				$data['class_10_description'] 	= 	$this->input->post('class_10_desc');
				$data['class_10_value'] 		= 	$this->input->post('class_10_rate');
				$data['start_date'] 			= 	str_replace('/', '-', $this->input->post('start_date'));
				$data['end_date'] 				= 	str_replace('/', '-', $this->input->post('end_date'));
				$data['date'] 		= 	time();
				$this->db->where('id', $para2);
				$this->db->update('terrif', $data);
				echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/tarrif')); exit;		
			}
			

		}else{
			$this->page_data['page'] = 'Tarrif';
			$this->load->view('back/terrif', $this->page_data);
		}
	}
	
	///////////////////////////////////////////////////////////////
	////	/** MTR START  *////////////////////
	///////////////////////////////////////////////////////////////
	public function mtr($para1 = '', $para2 = '', $para3 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->db->order_by('id','DESC');
			$this->page_data['mtr']  = $this->db->get('mtr')->result_array();
			$this->load->view('back/mtr_list', $this->page_data);

		}
		elseif($para1 == 'by_tollplaza'){
			if($para2 != ''){
				$this->db->where('toolplaza', $para2);
			}
				$this->db->order_by('id','DESC');
				$this->page_data['mtr']  = $this->db->get('mtr')->result_array();
				$this->load->view('back/mtr_list', $this->page_data);

		}
		elseif($para1 == 'approve'){
			$data['status'] = 1;
			$this->db->where('alert_type',2);
			$this->db->where('ref_id',$para2);
			$this->db->delete('alerts');
			$this->db->where('id',$para2);
			$this->db->update('mtr',$data);
		}
		elseif($para1 == 'delete'){
			$this->db->where('id',$para2);
			$record = $this->db->get('mtr');
			if($record->result_array()){
				$support = $this->db->get_where('supporting_document',array('mtr_id' => $para2))->result_array();
				if($support){
					foreach($support as $val){
						unlink('./uploads/supporting/'.$val['path']);
					}
					$this->db->where('mtr_id', $para2);
					$this->db->delete('supporting_document');
				}
				$file = $this->db->get_where('mtr',array('id' => $para2))->row()->file;
				unlink('./uploads/mtr/'.$file);
				$this->db->where('id', $para2);
				$this->db->delete('mtr');
			}
		}
		elseif($para1 == 'disapprove'){
			$this->page_data['mtr_id'] = $para2;
			$this->load->view('back/mtr_disapprove', $this->page_data);
		}
		elseif($para1 == 'view_reason'){
			$reason = $this->db->get_where('mtr',array('id' => $para2))->result_array();
			if($reason[0]['status'] == 2){
				echo "<span class='text-info'>".$reason[0]['reason']."</span>";
			}else{
				echo "<span class='text-danger'>Invalid Request</span>";
			}
			
		}
		elseif($para1 == 'disapprove_do'){
			$check = $this->db->get_where('mtr',array('id' => $para2))->result_array();
			if($check){
				// echo "<pre>"; print_r($check); exit;
				if($check[0]['status'] == 0 || $check[0]['status'] == 1){
					if(empty($this->input->post('dissapprove_reason'))){
						echo json_encode(array('respose' => FALSE , 'message' => 'Please add reason for dissapproving this monthly traffic report'));exit;	
					}
					else
					{
						$data['status'] = 2;
						$data['reason'] = $this->input->post('dissapprove_reason');
						$this->db->where('id', $para2);
						$this->db->update('mtr' , $data);
                        /**Notifications Start */
    
    
					  $notificatoin_msg = 'Your  '. date("F, Y",strtotime($check[0]['for_month'])) .' mtr disapproved.';
                      $mtrMonth = explode('-', $check[0]['for_month']);
                      $mtr_month = $mtrMonth[0].'-'.$mtrMonth[1].'-'.$mtrMonth[2];
                      
                      $data11 = array(
					 'user_type' => 3,
	   				 'user_id' => $this->session->userdata('adminid'),
					 'for_user_id' => $check[0]['user_id'],
					 'for_user_type' => $check[0]['upload_type'],
					 'alert_type'  => 2,
					 'ref_id' 	=> $para2,
					 'date' => date("Y-m-d H:i:s"),
					 'is_read' => 0,
					 'notification_msg' => $notificatoin_msg                
					  );
                     $this->db->insert('notifications', $data11);             

						echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/mtr')); exit;
					}
				}
				else
				{
					echo json_encode(array('respose' => FALSE , 'message' => 'Invalid Requestee'));exit;	
				}
			}else{
				echo json_encode(array('respose' => FALSE , 'message' => 'Invalid Request'));exit;		
			}
		} /**Notifications END */
		else{
			$this->page_data['page'] = 'MTR';
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('back/mtr', $this->page_data);
		}
	}
	public function monthly_traffic_report($para1 = ''){
	    $this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para1 ))->result_array();
	
		$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];

		$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		
		//echo $this->db->last_quer`y();
		//echo "<pre>";
		//print_r($this->page_data['terrif']); exit;
		$this->load->view('back/invoice', $this->page_data);
	}
	public function generate_pdf($para1 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para1 ))->result_array();
		$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];

		//$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza)";
		$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		//echo "<pre>";
		//print_r($this->page_data['terrif'] ); exit;
		$pdfdata = $this->load->view('back/invoice_pdf', $this->page_data, TRUE);

		$this->load->library("Pdf");
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('NHA MTR');
        $pdf->SetTitle('NHA Monthly Traffic Report');
        $pdf->SetSubject('MTR');
        $pdf->SetKeywords('MTR, PDF');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 16, '', true);
        $pdf->AddPage('L', 'A2');

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->writeHTMLCell(0, 0, '', '', $pdfdata, 0, 1, 0, true, '', true);
         $pdf->Output('mtr.pdf','I');
        //$pdf->Output(SERVER_RELATIVE_PATH . '/uploads/invoices/invoice' . $invoice_name . '.pdf', 'F');

	}	
	public function specific_mtr($para1 = '', $para2 = '' ){
		if($para1 == 'list')
		{
			$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para2))->result_array();
		    // $this->db->where('alert_type',2);
			// $this->db->where('ref_id',$para2);
			// $this->db->update('notifications',array('is_read' => 1))->result_array();	
			$this->load->view('back/mtr_list', $this->page_data);
		}
		else
		{
			
			$this->page_data['page'] = 'specific_mtr';
			$this->page_data['mtr_id'] = $para1;			
			$this->load->view('back/specific_mtr', $this->page_data);	
		}
	}
	public function view_supporting($para1 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		$this->page_data['support'] = $this->db->get_where('supporting_document',array('mtr_id' => $para1))->result_array();
		$this->load->view('back/suppporting_list', $this->page_data);

	}
	
	///////////////////////////////////////////////////////////////
	////	/** DTR START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function dtr($para1 = '', $para2 = '', $para3 = ''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->db->order_by('id','DESC');
			$this->page_data['dtr']  = $this->db->get('dtr')->result_array();
			$this->load->view('back/dtr_list', $this->page_data);

		}
		elseif($para1 == 'by_tollplaza'){
			if($para2 != ''){
				$this->db->where('toolplaza', $para2);
			}
				$this->db->order_by('id','DESC');
				$this->page_data['dtr']  = $this->db->get('dtr')->result_array();
				$this->load->view('back/dtr_list', $this->page_data);

		}
		elseif($para1 == 'approve'){
			$data['status'] = 1;
			$this->db->where('alert_type',2);
			$this->db->where('ref_id',$para2);
			$this->db->delete('alerts');
			$this->db->where('id',$para2);
			$this->db->update('dtr',$data);
		}
		elseif($para1 == 'delete'){
			$this->db->where('id',$para2);
			$record = $this->db->get('dtr');
			if($record->result_array()){
				$support = $this->db->get_where('dtr_supporting_document',array('dtr_id' => $para2))->result_array();
				if($support){
					foreach($support as $val){
						unlink('./uploads/supporting/'.$val['path']);
					}
					$this->db->where('dtr_id', $para2);
					$this->db->delete('dtr_supporting_document');
				}
				$file = $this->db->get_where('dtr',array('id' => $para2))->row()->file;
				unlink('./uploads/dtr/'.$file);
				$this->db->where('id', $para2);
				$this->db->delete('dtr');
			}
		}
		elseif($para1 == 'disapprove'){
			$this->page_data['dtr_id'] = $para2;
			$this->load->view('back/dtr_disapprove', $this->page_data);
		}
		elseif($para1 == 'view_reason'){
			$reason = $this->db->get_where('dtr',array('id' => $para2))->result_array();
			if($reason[0]['status'] == 2){
				echo "<span class='text-info'>".$reason[0]['reason']."</span>";
			}else{
				echo "<span class='text-danger'>Invalid Request</span>";
			}
			
		}
		elseif($para1 == 'disapprove_do'){
			$check = $this->db->get_where('dtr',array('id' => $para2))->result_array();
			if($check){
				// echo "<pre>"; print_r($check); exit;
				if($check[0]['status'] == 0 || $check[0]['status'] == 1){
					if(empty($this->input->post('dissapprove_reason'))){
						echo json_encode(array('response' => FALSE , 'message' => 'Please add reason for dissapproving this daily traffic report'));exit;	
					}
					else
					{
						$data['status'] = 2;
						$data['reason'] = $this->input->post('dissapprove_reason');
						$this->db->where('id', $para2);
						$this->db->update('dtr' , $data);
                        /**Notifications Start 
    
    
					  $notificatoin_msg = 'Your  '. date("F, Y",strtotime($check[0]['for_date'])) .' dtr disapproved.';
                      $mtrMonth = explode('-', $check[0]['for_date']);
                      $mtr_date = $mtrdate[0].'-'.$mtrdate[1].'-'.$mtrdate[2];
                      
                      $data11 = array(
					 'user_type' => 3,
	   				 'user_id' => $this->session->userdata('adminid'),
					 'for_user_id' => $check[0]['user_id'],
					 'for_user_type' => $check[0]['upload_type'],
					 'alert_type'  => 2,
					 'ref_id' 	=> $para2,
					 'date' => date("Y-m-d H:i:s"),
					 'is_read' => 0,
					 'notification_msg' => $notificatoin_msg                
					  );
                     $this->db->insert('notifications', $data11);             

						echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/dtr')); exit;*/
					}
				}
				else
				{
					echo json_encode(array('response' => TRUE , 'message' => 'Disapproved Successfully', 'is_redirect' =>TRUE, 'redirect_url' => base_url().'admin/dtr'));exit;	
				}
			}else{
				echo json_encode(array('response' => FALSE , 'message' => 'Invalid Request'));exit;		
			} /**Notifications END */
		}
		else{
			$this->page_data['page'] = 'dtr';
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('back/dtr', $this->page_data);
		}
	}
	public function daily_traffic_report($para1 = ''){
		$this->page_data['dtr'] = $this->db->get_where('dtr',array('id' => $para1 ))->result_array();
		$date = date('Y-m-d',strtotime($this->page_data['dtr'][0]['for_date']));
		$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['dtr'][0]['toolplaza']." ,toolplaza)  AND (start_date <= '".$date."' AND end_date >= '".$date."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		$this->load->view('back/dtr_invoice', $this->page_data);
	}
	public function dtr_generate_pdf($para1 = ''){
		$this->page_data['dtr'] = $this->db->get_where('dtr',array('id' => $para1 ))->result_array();
		/*$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];*/

		//$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza)";
		$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['dtr'][0]['toolplaza']." ,toolplaza)  AND (start_date <= '".$this->page_data['dtr'][0]['for_date']."' AND end_date >= '".$this->page_data['dtr'][0]['for_date']."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		$pdfdata = $this->load->view('front/toolplaza/dtr_invoice_pdf', $this->page_data, TRUE);

		$this->load->library("Pdf");
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('NHA DTR');
        $pdf->SetTitle('NHA Daily Traffic Report');
        $pdf->SetSubject('DTR');
        $pdf->SetKeywords('DTR, PDF');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 16, '', true);
        $pdf->AddPage('L', 'A2');

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->writeHTMLCell(0, 0, '', '', $pdfdata, 0, 1, 0, true, '', true);
         $pdf->Output('dtr.pdf','I');
        //$pdf->Output(SERVER_RELATIVE_PATH . '/uploads/invoices/invoice' . $invoice_name . '.pdf', 'F');

	}
	public function specific_dtr($para1 = '', $para2 = '' ){
		if($para1 == 'list')
		{
			$this->page_data['dtr'] = $this->db->get_where('dtr',array('id' => $para2))->result_array();
		    // $this->db->where('alert_type',2);
			// $this->db->where('ref_id',$para2);
			// $this->db->update('notifications',array('is_read' => 1))->result_array();	
			$this->load->view('back/dtr_list', $this->page_data);
		}
		else
		{
			
			$this->page_data['page'] = 'specific_dtr';
			$this->page_data['dtr_id'] = $para1;			
			$this->load->view('back/specific_dtr', $this->page_data);	
		}
	}
	public function view_dtrsupporting($para1 = ''){
		$this->page_data['support'] = $this->db->get_where('dtr_supporting_document',array('dtr_id' => $para1))->result_array();
		$this->load->view('back/suppporting_list', $this->page_data);

	}
	
/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////// Location ///////////////////////////////////////////
	///////////////////////////////////////////////////////////////////

	public function location($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['location'] = $this->db->get('location')->result_array();
			$this->load->view('back/location_list', $this->page_data);
			
		}elseif($para1 == 'add'){
			$this->load->view('back/location_add',$this->page_data);

		}elseif($para1 == 'edit'){
			$this->page_data['location'] = $this->db->get_where('location',array('id' => $para2))->result_array();
			if(!$this->page_data['location']){
				echo "<span class='text-danger'>Invalid Request</span>"; exit;
			}
			$this->load->view('back/location_edit',$this->page_data);
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('location');
		}elseif($para1 == 'update'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('location','Tool Plaza Location','required|trim');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
			}else{

				$data['name'] = $this->input->post('location');
				$this->db->where('id',$para2);
				$this->db->update('location',$data);
				echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/location')); exit; 
			}
		}elseif($para1 == 'add_do'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('location','Tool Plaza Location','required|trim');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
			}else{

				$data['name'] = $this->input->post('location');
				$this->db->insert('location',$data);
				echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/location')); exit; 
			}


		}else{
			$this->page_data['page'] = 'Locations';
			$this->load->view('back/location', $this->page_data);
		}
		
		
	}

	///////////////////////////////////////////////////////////////
	////	/** OMC START  *////////////////////
	///////////////////////////////////////////////////////////////

	public function omc($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['omc'] = $this->db->get('omc')->result_array();
			$this->load->view('back/omc_list', $this->page_data);
			
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('omc');
		}elseif ($para1 == 'tp_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('omc', $data);
			
           echo $para3;
        }elseif($para1 == 'add'){
			$this->page_data['toolplaza'] = $this->Admin_model->getSites();
        	$this->load->view('back/add_omc', $this->page_data);
        }elseif($para1 == 'add_do'){
        	// echo "<pre>"; print_r($_POST); exit;
        	$this->load->library('form_validation');
			$this->form_validation->set_rules('omcname','OMC Name','required|trim');
			$this->form_validation->set_rules('username','OMC User Name','required|trim');
			$this->form_validation->set_rules('Password','OMC Password','required|trim');
        	if($this->form_validation->run() == FALSE){
        		echo json_encode(array('respose' => FALSE , 'message' => validation_errors())); exit;

        	}else{
        		$data  = array();
				$data['name'] 	= $this->input->post('omcname');
				$data['user_name'] 	= $this->input->post('username');
				$data['site'] 	= $this->input->post('omcname');
				$data['password'] 	= $this->input->post('Password');
        		$data['status'] = 0;
        		$data['date'] 	= time();
        		$this->db->insert('omc', $data);
        		echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/omc')); exit; 
        	}

        }elseif($para1 == 'edit'){
        	$this->page_data['omc'] = $this->db->get_where('omc',array('id' => $para2))->result_array();
        	$this->load->view('back/edit_omc',$this->page_data);
        
        }elseif($para1 == 'update'){
        	$this->load->library('form_validation');
        	$this->form_validation->set_rules('omcname','OMC Name','required|trim');
        	if($this->form_validation->run() == FALSE){
        		echo json_encode(array('respose' => FALSE , 'message' => validation_errors())); exit;

        	}else{

        		$data  = array();
        		$data['name'] 	= $this->input->post('omcname');
        		$data['date'] 	= time();
        		$this->db->where('id', $para2);
        		$this->db->update('omc', $data);
        		echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/omc')); exit; 
        	}

        }else{
        	$this->page_data['page'] = 'OMC';
			$this->load->view('back/omc', $this->page_data);
		}
		
		
	}
	
	public function omc_password($para1 = ''){
		if(!$para1){
			echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>'; exit;

		}

		$this->page_data['omc_id'] = $this->db->get_where('omc',array('id' => $para1))->row()->id;
		$this->load->view('back/omc_password' , $this->page_data);
	}
	public function update_omc_password($omc_id = ''){
		if(!$this->session->userdata('adminid')){
			
			echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

		}
		if(!$omc_id){
			echo json_encode(array('response' => TRUE , 'message' => 'Invalid Request')); exit;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password','Password','required|trim');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
		if($this->form_validation->run() == TRUE){
			 
			$data = array(
					'password' 	=> sha1($this->input->post('password'))
				);
			$this->db->where('id', $omc_id);
			$this->db->update('omc', $data);
			echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/omc')); exit;
		}else{

			echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		}

	}	
	
	///////////////////////////////////////////////////////////////
	////	/** weightstation START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function weighstation($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$sql = "Select * From weighstation ORDER BY FIELD(`status`, 1, 0)";
											
			$this->page_data['weigh'] = $this->db->query($sql)->result_array();
			
			$this->load->view('back/weighstation_list', $this->page_data);
			
		}elseif($para1 == 'add'){
			$this->load->view('back/weighstation_add',$this->page_data);

		}elseif($para1 == 'do_add'){
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','Weighstation name','required|trim');
			if($this->input->post('type') == 1){
				$this->form_validation->set_rules('ip_address','IP address','required|trim|valid_ip');
			
			}elseif($this->input->post('type') == 2){
				$this->form_validation->set_rules('ftp_address','FTP address','required|trim|valid_ip');
			
			}
			// if($this->input->post('sofware_type') == 2){
			// 	$this->form_validation->set_rules('file_index','Index file Required','required|trim|numeric');
			
			// }
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE,'message' => validation_errors())); exit;
			}else{
				$post = $this->input->post();
				$insert = $this->Admin_model->add_weighstation($post);
				if($insert){
					echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/weighstation')); exit;
				}
			}

		}elseif($para1 == 'edit'){
			$this->page_data['weigh'] = $this->db->get_where('weighstation',array('id' => $para2))->result_array();
			$this->load->view('back/weighstation_edit', $this->page_data);

		}elseif($para1 == 'update'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','Weighstation name','required|trim');
			if($this->input->post('type') == 1){
				$this->form_validation->set_rules('ip_address','IP address','required|trim|valid_ip');
			
			}elseif($this->input->post('type') == 2){
				$this->form_validation->set_rules('ftp_address','FTP address','required|trim|valid_ip');
			
			}
			if($this->input->post('sofware_type') == 2){
				$this->form_validation->set_rules('file_index','Index file Required','required|trim|numeric');
			
			}
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE,'message' => validation_errors())); exit;
			}else{
				$post = $this->input->post();
				$weigh_id = $para2;
				$update = $this->Admin_model->update_weighstation($weigh_id, $post);
				if($update){
					echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/weighstation')); exit;
				}else{
					echo json_encode(array('response' => FALSE,'message' => 'Invalid Request')); exit;
				}
			}
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('weighstation');
		}elseif ($para1 == 'tp_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('weighstation', $data);
			
           echo $para3;
        }elseif ($para1 == 'gm_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['gm_status'] = '1';
            } else {
                $data['gm_status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('weighstation', $data);
			
           echo $para3;
        }else{
        	$this->page_data['page'] = 'Weighstation';
			$this->load->view('back/weighstation', $this->page_data);
		}
		
		
	}
	public function weighlimit($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['weigh'] = $this->db->get('weigh_limit')->result_array();
			$this->load->view('back/weighlimit_list', $this->page_data);
			
		}elseif($para1 == 'add'){
			$this->page_data['category'] = $this->db->get('weigh_category')->result_array();
			$this->load->view('back/weighlimit_add',$this->page_data);

		}elseif($para1 == 'do_add'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cat','No of Axles','required|trim');
			$this->form_validation->set_rules('weighlimit','Weight Limit','required|trim|numeric');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE,'message' => validation_errors())); exit;
			}else{
				////check weather this category code already exists in weighlimit table////
				$post = $this->input->post();
				$code = $this->db->get_where('weigh_category',array('id'=>$post['cat']))->row()->code;
       			$check = $this->db->get_where('weigh_limit',array('category_code' => $code))->result_array();
				if($check){
					
						echo json_encode(array('response' => False, 'message' => 'Weighlimit for this category already exists', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/weighlimit')); exit;
					
				}
				
				$insert = $this->Admin_model->add_weighlimit($post);
				if($insert){
					echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/weighlimit')); exit;
				}
			}

		}elseif($para1 == 'edit'){
			//$this->db->where('id !=', $para2);
			$this->page_data['category'] = $this->db->get('weigh_category')->result_array();
			$this->page_data['limit'] = $this->db->get_where('weigh_limit',array('id' => $para2))->result_array();
			$this->load->view('back/weighlimit_edit', $this->page_data);

		}elseif($para1 == 'update'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cat','No of Axles','required|trim');
			$this->form_validation->set_rules('weighlimit','Weight Limit','required|trim|numeric');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE,'message' => validation_errors())); exit;
			}else{
				$post = $this->input->post();
				$code = $this->db->get_where('weigh_category',array('id'=>$post['cat']))->row()->code;
       			$this->db->where('id!=', $para2);
       			$this->db->where('category_code', $code);
       			$check = $this->db->get('weigh_limit')->result_array();
				
				
				if($check){
					echo json_encode(array('response' => FALSE,'message' => 'This axle limit already exist, please choose different one')); exit;
				}
				$id = $para2;
				$update = $this->Admin_model->update_limit($id, $post);
				if($update){
					echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/weighlimit')); exit;
				}else{
					echo json_encode(array('response' => FALSE,'message' => 'Invalid Request')); exit;
				}
			}
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('weigh_limit');
		}else{
        	$this->page_data['page'] = 'Weightlimit';
			$this->load->view('back/weighlimit', $this->page_data);
			
		}
		
		
	}
	public function weighstation_custom_data(){
		$this->page_data['page'] = 'weighstation custom data';
		$this->page_data['weighstations'] = $this->db->get_where('weighstation',array('status' => 1,'software_type' => 1))-> result_array();
		$this->load->view('back/weighstation_custom_data', $this->page_data);
			
	}

	public function search_weighstation_custom_data(){
		$ins_data = array();
		$allowed = $this->db->get('weigh_limit')->result_array();
		foreach($allowed as $key => $val){
            $check_cat[$key] = $val['category_code']; 
        }
		$weigh = $this->input->post('weighstation');

		$date = rtrim(str_replace('/', '-' ,$this->input->post('day')), '-');;
		$new_date = date('Y-m-d',strtotime($date));
		$weighstation = $this->db->get_where('weighstation',array('id' => $weigh, 'status' => 1))->result_array();
		// echo $this->db->last_query();
		// echo '<pre>';
		// print_r($check); exit;
		if(!$weighstation){
				echo json_encode(array('response' => FALSE,'message' => 'No weighstation found for your search')); exit;
				
		}
		$getfile =  str_replace('-', '',$date);
	     if($weighstation[0]['type'] == 1){
                $dir = "\\\\".$weighstation[0]['address']."\\daw300nt\\";  
         }elseif($weighstation[0]['type'] == 2){
                $dir = "ftp://".$weighstation[0]['address']."/";
         }
         if($weighstation[0]['type'] == 2){
            $conn_id = ftp_connect($weighstation[0]['address']);

         }elseif($weighstation[0]['type'] == 1){
                //$fp = @fsockopen($row['address'], 80, $errno, $errstr,5);
         }

         if ($weighstation[0]['type'] == 2 && !$conn_id) {
             	echo json_encode(array('response' => FALSE,'message' => 'Unable to connect to weighstation')); exit;
				
         }else{
             	$id = $weighstation[0]['id'];
                $newdate = date('Y-m-d',strtotime($date));
                
                $query = $this->db->query("SELECT COUNT(id) as count_id
                               FROM weighstation_data
                               WHERE weigh_id = '$id' AND date = '$new_date'");
                $c = $query->row()->count_id;
                //echo $this->db->last_query(); exit;
             	$file = $dir.$getfile.".dat";
                $file1 = $dir.$getfile.".inf";
              	if(file_exists($file)){ 
                    $data = file_get_contents($file);
                    if(file_exists($file1)){
                        $data1 = file_get_contents($file1);
                    }
                    $data_exp = explode(PHP_EOL , $data);
                    $data_exp = array_values(array_filter($data_exp));
                    
                    //$sku = array_slice($data_exp, ($c)) ;
                    $sku = $data_exp;

                    if($sku){
	                    $array = array();
	                    foreach ($sku as $value) {
	                        $array[] = explode(';', $value);
	                    }

	                    $data_final = $array;
	                    if(file_exists($file1)){
	                        $data1 = array_filter(explode(PHP_EOL , $data1));
	                    	$data1_final = array();
	                        foreach($data1 as $key11 => $val11){
	                            $data1_final[$key11] = explode(';', $val11);
	                       }
	                    }
	                  
	                    if(!empty($data_final)){
	                       
	                        foreach ($data_final as $key => $rowval) {
	                            $cat_code = trim($rowval[7]);
	                            $index =  array_search($cat_code, array_column($allowed, 'category_code'));
	                            if(in_array($cat_code, $check_cat)){
	                                $ins_data[$key]['weigh_id'] = $weighstation[0]['id'];
	                                $d = explode('/', $rowval[0]);
	                                $datwe = $d[2].'-'.$d[0].'-'.$d[1];
	                                $ins_data[$key]['date'] = $datwe;
	                              
	                                $ins_data[$key]['time'] = $rowval[1];
	                                $ins_data[$key]['ticket_no'] = $rowval[4];
	                                $ins_data[$key]['vehicle_no'] = $rowval[5];
	                                $type = mb_substr(trim($rowval[7]), 0, 1);
	                                
	                                $ins_data[$key]['type'] = $type;
	                              
	                                $weight_lmit = $allowed[$index]['weigh_limit'];

	                                $weight = 0;
	                                for ($i = 11; $i < 11 + $type ; $i++) {
	                                    $weight += $rowval[$i];
	                                }

	                                $ins_data[$key]['weight'] = $weight;
	                                $ins_data[$key]['vehicle_code'] = $cat_code;
	                                if($weight_lmit < $weight){
	                                    $diff = $weight - $weight_lmit;
	                                    $ins_data[$key]['exces_weight'] = $diff;
	                                     
	                                    $ins_data[$key]['percent_overload'] = round(($diff / $weight_lmit) * 100,2); 
	                                    $ins_data[$key]['status'] = 2;
	                                }else{
	                                    $ins_data[$key]['exces_weight'] = 0; 
	                                    $ins_data[$key]['percent_overload'] = 0;
	                                    $ins_data[$key]['status'] = 1;
	                                }
	                                
	                                $search = $rowval[4];
	                                $ins_data[$key]['haulier'] = '';
	                                $ins_data[$key]['fine'] = '';
	                                if(file_exists($file1)){
	                                    foreach($data1_final as $val){
	                                    //echo "@".trim($val[2])."==".trim($search).".<br>";
	                                        if(trim($val[2]) == trim($search)){
	                                            
	                                            $ins_data[$key]['haulier'] = trim(preg_replace('/[0-9.]+/', '', $val[6]));
	                                            $ins_data[$key]['fine'] = trim($val[7]);
	                                        }else{

	                                        }

	                                    }
	                                }

	                            }

	                        }
	                       
	                    }
	                }else{
	                	 echo json_encode(array('response' => FALSE,'message' => 'You already have data for this date')); exit;
				
	                }
                }else{
                    echo json_encode(array('response' => FALSE,'message' => 'No data found for this date')); exit;
				
                }
                if($ins_data){
	               	$ins_data = array_values(array_slice($ins_data, $c));
	               	if($ins_data){
	               			$this->db->insert_batch('weighstation_data', $ins_data);
	               	 		echo json_encode(array('response' => TRUE,'message' => 'Data retrieved successfully')); exit;
				 
	               	}else{
	               			echo json_encode(array('response' => FALSE,'message' => 'You already have complete date for this date')); exit;
				 
	               	}
	               
            	}
         } 


	}
	public function weighstation_report($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		
        	$this->page_data['page'] = 'weighstation daily report';
        	$this->page_data['weighstation'] = $this->db->get_where('weighstation',array('status' => 1))->result_array();
			// $sql =	"SELECT weighstation.id, date, name, sum(case when weighstation_data.ticket_no != '' then 1 else 0 end) AS total_vehicles,
   // 				 		sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
   // 				 		sum(case when weighstation_data.status = 2 then fine else 0 end) fined
   // 				 		 FROM weighstation
   //  					LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
   //  					WHERE weighstation.status = 1   GROUP BY weighstation.id";
        	
    // 		$sql = " SELECT  id , name
				// FROM    weighstation a
    //     LEFT OUTER JOIN
    //     (
    //         SELECT  weigh_id ,COUNT('weighstation_data.ticket_no') AS total_vehicles , MAX(date) date,sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
   	// 			 		sum(case when weighstation_data.status = 2 then fine else 0 end) fined
   				 		
    //         FROM    weighstation_data
    //         GROUP BY date
    //     ) b ON a.id = b.weigh_id ";
		    $sql = 'SELECT weighstation.id , weighstation.name,
		    weighstation_data.weigh_id,
			weighstation.last_updated,
		    weighstation_data.date,
		    COUNT(weighstation_data.ticket_no) AS total_vehicles,
		    sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
		    sum(case when weighstation_data.status = 2 then fine else 0 end) fined
			FROM
		    weighstation
		    LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
			WHERE weighstation_data.date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = weighstation.id)
			GROUP BY
		    weighstation.id; ';

			$query= $this->db->query($sql);
			
			$this->page_data['record'] = $query->result_array(); 

			$this->load->view('back/weighstation_data', $this->page_data);

		
		
		
	}

	public function weighstation_daily_report($para1 = '' , $para2 = '', $para3 =''){
		if($para1 == 'post'){
			$weighstation = $this->input->post('weighstation');
			$date = str_replace('/','-', $this->input->post('day'));
			$this->page_data['weighstation'] = $this->db->select('*')->where('weigh_id',$weighstation)->where('date', $date)->order_by('id','desc')->get('weighstation_data')->result_array();
			$this->page_data['weigh'] = $weighstation;
			$this->page_data['date'] = $date;
			$this->load->view('back/weighstation_daily_report_search', $this->page_data);
			
		}
		elseif($para1 == 'by_weighstation'){
			$weighstation = $para2;
			$this->page_data['weigh'] = $weighstation;
			$data = $this->Admin_model->get_weighstations_dates($weighstation);
			$this->page_data['dates'] = $data;
			$this->page_data['weighs'] = $this->db->get_where('weighstation',array('status' => 1))->result_array();
		//	echo"test"; die;
			$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_daily_report($weighstation);
			
			$this->page_data['page'] = 'weighstation daily report';
			$this->load->view('back/weighstation_daily_report', $this->page_data);
			
		}

	}

	function get_weighstation_data(){
		$sql = 'SELECT weighstation.id , weighstation.name,
			weighstation.last_updated as last_updated,
    		weighstation_data.weigh_id,
    		weighstation_data.date as date,
    		COUNT(weighstation_data.ticket_no) AS total_vehicles,
    		sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
    		sum(case when weighstation_data.status = 2 then fine else 0 end) fined
			FROM
    			weighstation
    		LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
			WHERE weighstation_data.date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = weighstation.id)
			GROUP BY
   			 weighstation.id;';
				 $query= $this->db->query($sql);
			$result = $query->result_array();
    		 foreach($result as $key => $value){
				$result[$key]['last_updated'] = date('F j, Y, g:i a', $value['last_updated']);
				$result[$key]['date'] = date('F j, Y', strtotime( $value['date']));
			 
			}
    		    echo json_encode($result); 

	}
	public function daily_weighstation_pdf($para1 = '', $para2 = ''){
		$this->page_data['weighstation'] = $this->db->select('*')->where('weigh_id',$para1)->where('date', $para2)->order_by('id','desc')->get('weighstation_data')->result_array();
		$report  = $this->load->view('back/weighstation_data_pdf', $this->page_data, TRUE);
		$this->load->library("Pdf");
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('NHA MTR');
        $pdf->SetTitle('NHA Monthly Traffic Report');
        $pdf->SetSubject('MTR');
        $pdf->SetKeywords('MTR, PDF');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(5, 0, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 12, '', true);
        $pdf->AddPage('P', 'A4');

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->writeHTMLCell(0, 0, '', '', $report, 0, 1, 0, true, '', true);
         
         $pdf->Output('mtr.pdf','I');
	}

	public function weighstation_categories($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['weigh_cat'] = $this->db->get('weigh_category')->result_array();
			$this->load->view('back/weighstation_category_list', $this->page_data);
			
		}elseif($para1 == 'add'){
			$this->load->view('back/weighstation_cat_add',$this->page_data);

		}elseif($para1 == 'do_add'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','Category Name','required|trim');
			$this->form_validation->set_rules('axle','No of Axle','required|trim|numeric');
			$this->form_validation->set_rules('code','Category Code','required|trim|numeric');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE,'message' => validation_errors())); exit;
			}else{
				$post = $this->input->post();
				$insert = $this->Admin_model->add_weighstation_cat($post);
				if($insert){
					echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/weighstation_categories')); exit;
				}
			}

		}elseif($para1 == 'edit'){
			$this->page_data['weigh'] = $this->db->get_where('weigh_category',array('id' => $para2))->result_array();
			$this->load->view('back/weighstation_cat_edit', $this->page_data);

		}elseif($para1 == 'update'){

			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','Category Name','required|trim');
			$this->form_validation->set_rules('axle','No of Axle','required|trim|numeric');
			$this->form_validation->set_rules('code','Category Code','required|trim|numeric');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE,'message' => validation_errors())); exit;
			}else{
				$post = $this->input->post();
				$id = $para2;
				$update = $this->Admin_model->update_weighstation_cat($id, $post);
				if($update){
					echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/weighstation_categories')); exit;
				}else{
					echo json_encode(array('response' => FALSE,'message' => 'Invalid Request')); exit;
				}
			}
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('weigh_category');
		}else{
        	$this->page_data['page'] = 'Weighstation Category';
			$this->load->view('back/weighstation_category', $this->page_data);
			
		}
		
		
	}

  
	
	public function weighstation_monthly_report($para1 = '' , $para2 = '', $para3 =''){
		if($para1 == 'post'){

			$weighstation = $this->input->post('weighstation');
			$date = $this->input->post('day');
			$this->page_data['weighstation'] = $this->Admin_model->search_weighstation_monthly_report($weighstation,$date);
			$this->page_data['weigh'] = $weighstation;
			$this->page_data['date'] = $date;
			$this->load->view('back/weighstation_monthly_report_search', $this->page_data);
			
		}elseif($para1 == 'by_weighstation'){
			$weighstation = $para2;
			$this->page_data['weigh'] = $weighstation;
			$data = $this->Admin_model->get_weighstations_months($weighstation);
			$this->page_data['dates'] = $data;
			$this->page_data['weighs'] = $this->db->get_where('weighstation',array('status' => 1))->result_array();
			$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_monthly_report($weighstation);
			
			$this->page_data['page'] = 'weighstation daily report';
			$this->load->view('back/weighstation_monthly_report', $this->page_data);
			
		}

	}
	
	public function monthly_weighstation_pdf($para1 = '', $para2 = ''){
		$weighstation = $para1;
		$date = $para2;
		$this->page_data['weigh'] = $weighstation;
		$d = explode('-', $para2);
		$newdate = implode('/', array($d[1],$d[0]));
		
		$this->page_data['weighstation'] = $this->Admin_model->search_weighstation_monthly_report($weighstation,$newdate);
			
		$report  = $this->load->view('back/weighstation_monthly_pdf', $this->page_data, TRUE);
		$this->load->library("Pdf");
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('NHA Monthly Weighstation Report');
        $pdf->SetTitle('NHA Monthly Weighstation Report');
        $pdf->SetSubject('MWR');
        $pdf->SetKeywords('MWR, PDF');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(5, 0, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 12, '', true);
        $pdf->AddPage('P', 'A4');

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->writeHTMLCell(0, 0, '', '', $report, 0, 1, 0, true, '', true);
         
         $pdf->Output('mtr.pdf','I');
	}
	
   
//////////////////////////////////////////////////////
////////** Dashboard Timer START *//////////////
//////////////////////////////////////////////////////

 	public function dashboard_timer($para1=''){
		$plaza = $this->input->post('plaza_id');
		$month = $this->input->post('month');
		$data = $this->Admin_model->timer_chartdata($plaza , $month);
		$previous_year = date("Y-m-d",strtotime(@$data['chart']['month'].' -1 year'));
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
		$pre_year_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_year);
		$pre_month_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_monthDate);
		
		$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $data['mtr_id'] ))->result_array();
		$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];
        $sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] = $this->db->query($sql)->result_array();
		$plazaId = $this->input->post('plaza_id');
	    $month  = $this->input->post('month');
		$this->page_data['mtrid'] = $data['mtr_id'];
		$this->page_data['plaza_id'] = $plazaId;
		$this->page_data['month'] = $month;

		$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->page_data['chart'] = $data['chart'];
		
		$this->page_data['revenue'] = $data['revenue'];
		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_year_chart'] = $pre_year_data['chart'];
        $this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];
		$this->page_data['page'] = 'Dashboard';
		// echo "<pre>";
		// print_r($this->page_data); exit;
		$this->load->view('back/timereload', $this->page_data);
	}
/** Dashboard Timer END */
	
	///////////////////////////////////////////////////////////////
	////	/** Notification START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function notify_counter($para1 = ''){	
		$this->db->where('for_user_type',3);
		$this->db->where('for_user_id',$this->session->userdata('adminid'));
		$this->db->where('user_type',1);
		$this->db->where('is_read',0);
		$this->db->order_by("id", "desc");
		$this->db->limit(5);
		$disapprovedMtrs = $this->db->get('notifications')->result_array();
		//echo $this->db->last_query(); exit;
               
                  if(!empty($disapprovedMtrs))
                  {
                    $notifyCounter = 0;
                    foreach($disapprovedMtrs as $row)
                    {   
                      $notifyCounter++;
					}
				}
				if(!empty($disapprovedMtrs))
                    { 
                      if($notifyCounter>3)
                      {
                       echo "3+"; 
                      }
                      else
                      {
                        echo $notifyCounter ;
                      }
                    }
	}
	public function notify_msg($para1 = ''){
		// $firstname = 'a';
        // $lastname = 'b';
        // $customer_mobile = 'd';
        // $this->db->select('*')->from('users')
        // ->group_start()
        //           ->where('a', $firstname)
        //           ->where('b', $lastname)
        //           ->where('c', '1')
        //           ->or_group_start()
        //                   ->where('d', $customer_mobile)
        //                   ->where('e', '1')
        //           ->group_end()
        //   ->group_end()
        // ->get();
	//    echo $this->db->last_query();
	    $this->db->where('for_user_type',3);
		$this->db->where('for_user_id',$this->session->userdata('supervisor_id'));
		$this->db->or_where('user_type',1);
		$this->db->or_where('user_type',2);
		$this->db->order_by("id", "desc");
		$this->db->limit(3);
		$this->page_data['notifications'] = $this->db->get('notifications')->result();
		
		
		//echo "<pre>";
		//print_r($this->page_data['notifications']); exit;
		//echo $this->db->last_query(); exit;
		$this->load->view('back/notify_msg', $this->page_data);		
	}
	public function delete_notification($para1 = '' ){
		$this->db->where('id', $this->input->post('id'));
		$this->db->delete('notifications');
		return redirect('admin/notify_msg/');		
	}

	/////////////////////google maps section start here/////////////////////////////////////////

	public function googlelocations($para1 = '', $para2 = '', $para3 = ''){
		if(!$this->session->userdata('adminid')){
			return redirect('admin/login');
		}
		
		if($para1 == 'list'){
			$this->page_data['googl'] = $this->db->get('google_locations')->result_array();
			
			$this->load->view('back/googlelocations_list', $this->page_data);

			
		}elseif($para1 == 'add'){
			$this->page_data['page'] = 'Google Locations';
			$this->page_data['roads'] = $this->db->get_where('roads',array('status' => 1))->result_array();
			$this->load->view('back/googlelocations_add',$this->page_data);

		}elseif($para1 == 'do_add'){
			// echo "<pre>";
			// print_r($_POST); exit;
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','Location name','required|trim');
			$this->form_validation->set_rules('type','Location','required|trim');
			$this->form_validation->set_rules('address','Location address','required|trim');
			$this->form_validation->set_rules('state','Privience','required|trim');
			//$this->form_validation->set_rules('chainage','Chainage','required|trim');
			$this->form_validation->set_rules('lat','Latitude','required|trim');
			$this->form_validation->set_rules('lang','Longitude','required|trim');
			$this->form_validation->set_rules('road','Road','required|trim');
			
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE,'message' => validation_errors())); exit;
			}else{
				$post = $this->input->post();
				$insert = $this->Admin_model->add_googlelocations($post);
				if($insert){
					echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/googlelocations')); exit;
				}
			}

		}elseif($para1 == 'edit'){
			$this->page_data['location'] = $this->db->get_where('google_locations',array('id' => $para2))->result_array();
			$this->page_data['roads'] = $this->db->get_where('roads',array('status' => 1))->result_array();
			
			$this->page_data['page'] = 'Google Locations';
			$this->load->view('back/googlelocations_edit',$this->page_data);

		}elseif($para1 == 'update'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','Location name','required|trim');
			$this->form_validation->set_rules('type','Location','required|trim');
			$this->form_validation->set_rules('address','Location address','required|trim');
			$this->form_validation->set_rules('state','Privience','required|trim');
			//$this->form_validation->set_rules('chainage','Chainage','required|trim');
			$this->form_validation->set_rules('lat','Latitude','required|trim');
			$this->form_validation->set_rules('lang','Longitude','required|trim');
			$this->form_validation->set_rules('road','Road','required|trim');
			//$this->load->library('form_validation');
			//$this->form_validation->set_rules('name','Weighstation name','required|trim');
			
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE,'message' => validation_errors())); exit;
			}else{
				$post = $this->input->post();
				$google_id = $para2;
				$update = $this->Admin_model->update_googlelocations($google_id , $post);
				if($update){
					echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/googlelocations')); exit;
				}
			}
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('google_locations');
		}elseif ($para1 == 'tp_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('google_locations', $data);
			
           echo $para3;
        }else{
        	$this->page_data['page'] = 'Google Locations';
			$this->load->view('back/google_locations', $this->page_data);
		}
	}
	function getgoogledata($para1 = ''){
		$div = '';
		$div .= '<div class="form-group">';
        if($para1 == 1){
        	$div .= ' <label for="exampleInputEmail1" style="font-weight: 900;">Toll Plaza</label>
                                  <select class="form-control required" name="loc_id" id="loc_id">
                                        <option value="">Choose Plaza</option>';
		
			$tollplaza = $this->db->get_where('toolplaza',array('google_map_status' => 1))->result_array();
			foreach($tollplaza as $row){
				$div .='<option value="'.$row["id"].'">'.$row["name"].'</option>';
			}
		}elseif($para1 == 2){
			$div .= ' <label for="exampleInputEmail1" style="font-weight: 900;">Weighstation</label>
                                  <select class="form-control required" name="loc_id" id="loc_id">
                                        <option value="">Choose Weighstation</option>';
			$weighstation = $this->db->get_where('weighstation',array('gm_status' => 1))->result_array();
			foreach($weighstation as $row){
				$div .='<option value="'.$row["id"].'">'.$row["name"].'</option>';
			}
			
		}
		 $div .= '</select>
               </div>';
               echo $div;
	}

	public function googleroads($para1 = '', $para2 = '', $para3 = ''){
		if(!$this->session->userdata('adminid')){
			return redirect('admin/login');
		}
		if($para1 == 'list'){
			$this->page_data['googl'] = $this->db->get('roads')->result_array();
			
			$this->load->view('back/googleroads_list', $this->page_data);

			
		}elseif($para1 == 'add'){
			$this->page_data['page'] = 'Google Roads';
			$this->load->view('back/googleroads_add',$this->page_data);

		}elseif($para1 == 'do_add'){
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','Road name','required|trim');
			$this->form_validation->set_rules('address','Road address','required|trim');
			$this->form_validation->set_rules('route','Route','required|trim');
			
			if(!$this->input->post('road_data')){
					echo json_encode(array('response' => FALSE,'message' => 'Invalid Request')); exit;
			
			}
			if(!$this->input->post('lat')){
					echo json_encode(array('response' => FALSE,'message' => 'Invalid Request')); exit;
			
			}
			if(!$this->input->post('lang')){
					echo json_encode(array('response' => FALSE,'message' => 'Invalid Request')); exit;
			
			}
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE,'message' => validation_errors())); exit;
			}else{
				$post = $this->input->post();
				$insert = $this->Admin_model->add_googleroads($post);
				if($insert){
					echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/googleroads')); exit;
				}
			}

		}elseif($para1 == 'edit'){
			$this->page_data['road'] = $this->db->get_where('roads',array('id' => $para2))->result_array();
			$this->page_data['page'] = 'Google Roads';
			$this->load->view('back/googleroads_edit',$this->page_data);

		}elseif($para1 == 'do_update'){

			$this->load->library('form_validation');
			$this->form_validation->set_rules('name','Road name','required|trim');
			$this->form_validation->set_rules('address','Road address','required|trim');
			$this->form_validation->set_rules('route','Route','required|trim');
			if(!$this->input->post('road_data')){
					echo json_encode(array('response' => FALSE,'message' => 'Invalid Request')); exit;
			
			}
			if(!$this->input->post('lat')){
					echo json_encode(array('response' => FALSE,'message' => 'Invalid Request')); exit;
			
			}
			if(!$this->input->post('lang')){
					echo json_encode(array('response' => FALSE,'message' => 'Invalid Request')); exit;
			
			}
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE,'message' => validation_errors())); exit;
			}else{
				$post = $this->input->post();
				$google_id = $para2;

				$update = $this->Admin_model->update_googleroads($google_id, $post);
				if($update){
					echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url().'admin/googleroads')); exit;
				}
			}
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('roads');
		}elseif ($para1 == 'tp_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('roads', $data);
			
           echo $para3;
        }else{
        	$this->page_data['page'] = 'Google Roads';
			$this->load->view('back/google_roads', $this->page_data);
		}
		
	}

	function site_settings($para1 = '' , $para2 = '', $para3 = ''){
			if(!$this->session->userdata('adminid'))
			{	
				return redirect('admin/login');
			}
			if($this->session->userdata('role') == 1){
				return redirect('admin');
			}
			$this->load->library('form_validation');
			if($para1 == 'update_map_key'){
				$this->form_validation->set_rules('apikey','Api Key','required|trim');
				if($this->form_validation->run() == FALSE){
					echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
				}else{
					$data = array();
					$data['value'] = $this->input->post('apikey');
					$this->db->where('type', 'google_map_api_key');
					$this->db->update('settings', $data);
					echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'admin/site_settings'));
	            }		
			}else{
				$this->page_data['user'] = $this->db->get_where('admin',array('id' => $this->session->userdata('adminid')))->result_array();
				$this->page_data['page'] = 'site settings';
				$this->load->view('back/site_settings',$this->page_data);
			}
		}


		/////////////////MAP SECTION STARTS HERE////////
	public function map($para1 = ''){
		
		$this->page_data['page'] = 'map';
		$this->page_data['roads'] = $this->db->get_where('google_locations',array('status' => 1))->result_array();
		$this->page_data['locations'] = $this->db->get_where('google_locations',array('status' => 1))->result_array();
		$this->page_data['roads'] = $this->db->get_where('roads',array('status' => 1))->result_array();
		$this->load->view('back/mapview', $this->page_data);
	}

	public function getcontents($para1 = ''){
		$this->page_data['location'] = $this->db->get_where('google_locations',array('id' => $para1))->result_array();
		$this->page_data['info_data'] = array();
		if($this->page_data['location'])
		{
			if($this->page_data['location'][0]['type'] == 1){
				$data = $this->db->select('*')->where('toolplaza', $this->page_data['location'][0]['location_id'])->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
				if($data){
					$tp_data = $this->Admin_model->getinfodetails_tp($data);
				}else{
					$tp_data = '';
				}
				$this->page_data['info_data'] = $tp_data;
			}elseif($this->page_data['location'][0]['type'] == 2){
				$this->page_data['info_data'] = array();
			}
		}
		$this->load->view('back/infodata', $this->page_data);
	}

	function searchforgoogledata(){
		$locations = array();
		if($this->input->post('alltollplaza')){
			$locations[] = 1;
		}

		if($this->input->post('allweighstation')){
			$locations[] = 2;
		}
		if($this->input->post('cameras')){
			$locations[] = 3;
		}
		if($this->input->post('wis')){
			$locations[] = 4;
		}
		if($this->input->post('vms')){
			$locations[] = 5;
		}
		if($this->input->post('advisory_radio')){
			$locations[] = 6;
		}
		
		if($this->input->post('erst')){
			$locations[] = 7;
		}
		if($this->input->post('microwavevd')){
			$locations[] = 8;
		}
		
		if($this->input->post('speedes')){
			$locations[] = 9;
			
		}
		if($this->input->post('efine')){
			$locations[] = 10;
		}
		if($this->input->post('ofc')){
			$locations[] = 11;
			
		}
		if($this->input->post('service')){
			$locations[] = 12;
			
		}
		if($this->input->post('rest')){
			$locations[] = 13;
			
		}
		
		if($this->input->post('specific_road')){
			if($this->input->post('specific_road') == 'all'){
				$this->page_data['roads'] = $this->db->get_where('roads',array('status' => 1))->result_array();
				if($locations){
					$this->db->where('status',1);
					$this->db->where_in('type', $locations);
					$this->page_data['locations'] = $this->db->get('google_locations')->result_array();
		
				}else{
					$this->page_data['locations'] = '';
		
				}
			}else{
				$this->page_data['roads'] = $this->db->get_where('roads',array('status' => 1,'id' => $this->input->post('specific_road')))->result_array();
				if($locations){
					$this->db->where('status',1);
					$this->db->where('road_id', $this->input->post('specific_road'));
					$this->db->where_in('type', $locations);
					$this->page_data['locations'] = $this->db->get('google_locations')->result_array();
		
				}else{
					$this->page_data['locations'] = '';
				}
				
			}  
		}else{
			$this->page_data['roads'] = '';
			if($locations){
				$this->db->where('status',1);
				$this->db->where_in('type', $locations);
				$this->page_data['locations'] = $this->db->get('google_locations')->result_array();
		
			}else{
				$this->page_data['locations'] = '';
		
			}
		}
		
		if(empty($this->input->post())){
				$this->page_data['roads'] = $this->db->get_where('roads',array('status' => 1))->result_array();
				$this->page_data['locations'] = '';
		}
		//echo $this->db->last_query(); exit;
		$this->load->view('back/searchforgoogledata', $this->page_data);
	

	}
	public function traffic_counting($para1 = '', $para2 =''){
		if($para1 == 'list')
		{
			$this->db->order_by('id','DESC');
			$this->page_data['counter']  = $this->db->get('traffic_counter')->result_array();
			$this->load->view('back/traffic_counter_list', $this->page_data);
		}
		elseif($para1 == 'session_start')
		{
			$check = $this->db->get_where('traffic_counter', array('id' => $para2))->result_array();
			$this->page_data['error'] = '';
			if($check[0]['video_end_date']){
				$this->page_data['error'] = "You can't reopen a completed session";
			}
			$this->page_data['session_data'] = $this->db->get_where('traffic_counter',array('id' => $para2))->result_array();
			$this->page_data['insert_id'] = $para2;
			$this->page_data['page_name'] = 'traffic_counting';
			$this->load->view('front/member/traffic_counter_session', $this->page_data); 

		}elseif($para1 == 'view'){
			$this->page_data['session'] = $this->db->get_where('traffic_counter', array('id' => $para2))->result_array();
			$this->load->view('back/traffic_counter_details', $this->page_data);
		}
		elseif($para1 == 'do_add')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tollplaza',"Toll Plaza",'required');
			$this->form_validation->set_rules('for_month',"Date",'required');
			$this->form_validation->set_rules('timey',"Time",'required');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			
			}else{
				$datetime = strtotime(str_replace('/', '-', $this->input->post('for_month')).' '.$this->input->post('timey'));
				$sql = "SELECT * FROM `traffic_counter` WHERE tollplaza = ".$this->input->post('tollplaza')." AND ".$datetime." between video_start_date and video_end_date";
				$result = $this->db->query($sql)->result_array();
				
				if($result){
					echo json_encode(array('response' => FALSE,'message' => 'Session of this date time already exists')); exit;
				}
				$insert_data = array();
				$insert_data['tollplaza'] = $this->input->post('tollplaza');
				$insert_data['user_id'] = $this->session->userdata('member_id');
				$insert_data['user_type'] = 2;
				$insert_data['video_start_date'] = $datetime;
				$insert_data['session_start_date'] = time();
				$this->db->insert('traffic_counter', $insert_data);
				$insert_id = $this->db->insert_id();

				echo json_encode(array('response' => TRUE, 'message' => "Session started", 'is_redirect' => TRUE, 'redirect_url' => base_url().'member/traffic_counting/session_start/'.$insert_id)); exit;
			}
		}else if($para1 == 'traffic_add'){

			$values = json_decode($this->input->post('result'));
			$session_id = $this->input->post('session');
			$data[$values[0]->key] = $values[0]->value;
			$this->db->where('id', $session_id);
			$this->db->update('traffic_counter', $data);
		}elseif($para1 == 'add'){
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('front/member/counter_add' , $this->page_data);
		}elseif($para1 == 'update'){
			$this->page_data['session_id'] = $para2;
			$this->load->view('front/member/counter_update' , $this->page_data);
		}elseif($para1 == 'do_update'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('end_date',"Video end date",'required');
			$this->form_validation->set_rules('end_time',"video end time",'required');
			
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			
			}else{
				$update_data = array();
				$session_id = $this->input->post('session_id');
				$video_start_date = $this->db->get_where('traffic_counter' , array('id' => $session_id))->row()->video_start_date;
				$datetime = strtotime(str_replace('/', '-', $this->input->post('end_date')).' '.$this->input->post('end_time'));
				if($datetime <= $video_start_date){
					echo json_encode(array('response' => FALSE, 'message' => 'Invalid date time')); exit;
				}
				$update_data['video_end_date'] = $datetime;
				$update_data['session_end_date'] = time();
				$this->db->where('id', $session_id);
				$this->db->update('traffic_counter', $update_data);

				echo json_encode(array('response' => TRUE, 'message' => "Session updated successfully", 'is_redirect' => TRUE, 'redirect_url' => base_url().'member/traffic_counting/')); exit;
			}
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('traffic_counter');	
		}else{
			
			$this->page_data['page'] = 'traffic_counting';
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('back/traffic_counter', $this->page_data);
		}
	}



	// function update_database(){
	// 	$this->db->order_by('id','DESC');
	// 	$data  = $this->db->get('traffic_counter')->result_array();
	// 	foreach($data as $row){

	// 		$this->db->where('id',$row['id']);
	// 		$this->db->update('traffic_counter',array('video_start_date' => strtotime($row['video_start_date1'].''.$row['video_start_time']) ,'video_end_date' => strtotime($row['video_end_date1'].''.$row['video_end_time'])));
	// 	}
	// }
	public function date_changer(){
		$count = 0;
		
		$dsr_updated = $this->db->order_by('id', 'ASC')->get('dsr_updated')->result_array();
		
		/*foreach($lanes as $lane){
			echo $lane['tollplaza'];echo '<br>';
		}
		*/


		$i = 0;
		foreach($dsr_updated as $d){
			$tool_id[$i]['id'] = $d['toolplaza_id'];
			$dsr_id = $d['id'];
			echo '##';
			$lanes[$i] = $this->db->order_by('id', 'ASC')->get_where('dsr_lane', array('dsr_id' => $d['id'] ))->result_array();
			$j = 0;
			foreach($lanes[$i] as $lane){
				$data['toolplaza_id'] = $tool_id[$i]['id'];
				echo $d['id'].' '.$lane['lane_id'].'<br>';
				$this->db->where('dsr_id', $lane['dsr_id']);
				$this->db->update('dsr_lane', $data);
				$count++;
				echo $lane['id']; echo ' '; echo $count;
				$j++;
			}
			
			$i++;
		}/*?> <pre><?php echo print_r($lanes);*/
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////   TOLL PLAZA LIVE DATA START HERE  /////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////



	///////////////////////toll plaza Live data///////////////////////
	public function toll_plaza_report($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		
        	$this->page_data['page'] = 'Tollplaza report';
        	
		    $sql = 'SELECT toolplaza.id , toolplaza.name,tollplaza_live.tollplaza_id,
		    transactions.tollplaza_id,
		    transactions.date,
		    COUNT(transactions.id) AS total_vehicles,
		    sum(case when (transactions.mvc = 1 and transactions.payment_code = "C") OR (transactions.mvc = 12 and transactions.svc = 1 and transactions.payment_code = "C") then 1 else 0 end) class1_paid,
		    sum(case when (transactions.mvc = 1 and transactions.payment_code = "V") OR (transactions.mvc = 12 and transactions.svc = 1 and transactions.payment_code = "V") then 1 else 0 end) class1_voilate,
		    sum(case when (transactions.mvc = 1 and (transactions.payment_code = "X" or transactions.payment_code = "P")) OR (transactions.mvc = 12 and transactions.svc = 1 and (transactions.payment_code = "X" or transactions.payment_code = "P")) then 1 else 0 end) class1_exempt,
		    sum(case when (transactions.mvc = 1) OR (transactions.mvc = 12 and transactions.svc = 1)  then 1 else 0 end) class1_total,
		    sum(case when (transactions.mvc = 2 and transactions.payment_code = "C") OR (transactions.mvc = 12 and transactions.svc = 2 and transactions.payment_code = "C") then 1 else 0 end) class2_paid,
		    sum(case when (transactions.mvc = 2 and transactions.payment_code = "V") OR (transactions.mvc = 12 and transactions.svc = 2 and transactions.payment_code = "V") then 1 else 0 end) class2_voilate,
		    sum(case when (transactions.mvc = 2 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) OR (transactions.mvc = 12 and transactions.svc = 2 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) then 1 else 0 end) class2_exempt,
		    sum(case when (transactions.mvc = 2) OR (transactions.mvc = 12 and transactions.svc = 2) then 1 else 0 end) class2_total,
		    sum(case when ((transactions.mvc = 3 and transactions.payment_code = "C")  OR  (transactions.mvc = 5 and transactions.payment_code = "C") or (transactions.mvc = 6 and transactions.payment_code = "C")) OR ((transactions.mvc = 12 and transactions.svc = 3 and transactions.payment_code = "C")  OR  (transactions.mvc = 12 and transactions.svc = 5 and transactions.payment_code = "C") or (transactions.mvc = 12 and transactions.svc = 6 and transactions.payment_code = "C"))  then 1 else 0 end) class3_paid,
		    sum(case when ((transactions.mvc = 3 and transactions.payment_code = "V")  OR  (transactions.mvc = 5 and transactions.payment_code = "V") or (transactions.mvc = 6 and transactions.payment_code = "V")) OR ((transactions.mvc = 12 and transactions.svc = 3 and transactions.payment_code = "V")  OR  (transactions.mvc = 12 and transactions.svc = 5 and transactions.payment_code = "V") or (transactions.mvc = 12 and transactions.svc = 6 and transactions.payment_code = "V")) then 1 else 0 end) class3_voilate,
		    sum(case when ((transactions.mvc = 3 and (transactions.payment_code = "X" OR transactions.payment_code = "P"))  OR  (transactions.mvc = 5 and (transactions.payment_code = "X" or transactions.payment_code = "P")) or (transactions.mvc = 6 and (transactions.payment_code = "X" or transactions.payment_code = "P"))) OR ((transactions.mvc = 12 and transactions.svc = 3 and (transactions.payment_code = "X" OR transactions.payment_code = "P"))  or  (transactions.mvc = 12 and transactions.svc = 5 and (transactions.payment_code = "X" or transactions.payment_code = "P")) or (transactions.mvc = 12 and transactions.svc = 6 and (transactions.payment_code = "X" or transactions.payment_code = "P")))  then 1 else 0 end) class3_exempt,
		    sum(case when (transactions.mvc = 3 or  transactions.mvc = 5 or transactions.mvc = 6) OR ((transactions.mvc = 12 and transactions.svc = 3) or  (transactions.mvc = 12 and transactions.svc = 5) or (transactions.mvc = 12 and transactions.svc = 6)) then 1 else 0 end) class3_total,
		    sum(case when (transactions.mvc = 4 and transactions.payment_code = "C") OR (transactions.mvc = 12 and transactions.svc = 4 and transactions.payment_code = "C") then 1 else 0 end) class4_paid,
		    sum(case when (transactions.mvc = 4 and transactions.payment_code = "V") OR (transactions.mvc = 12 and transactions.svc = 4 and transactions.payment_code = "V") then 1 else 0 end) class4_voilate,
		    sum(case when (transactions.mvc = 4 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) OR (transactions.mvc = 12 and transactions.svc = 4 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) then 1 else 0 end) class4_exempt,
		    sum(case when (transactions.mvc = 4) OR (transactions.mvc = 12 and transactions.svc = 4) then 1 else 0 end) class4_total,
		    sum(case when ((transactions.mvc = 7 and transactions.payment_code = "C") or (transactions.mvc = 8 and transactions.payment_code = "C") or  (transactions.mvc = 9 and transactions.payment_code = "C" ) or (transactions.mvc = 10 and transactions.payment_code = "C")) OR ((transactions.mvc = 12 and  transactions.svc = 7 and transactions.payment_code = "C") or (transactions.mvc = 12 and transactions.svc = 8 and transactions.payment_code = "C") or  (transactions.mvc = 12 and transactions.svc = 9 and transactions.payment_code = "C" ) or (transactions.mvc = 12 and  transactions.svc = 10 and transactions.payment_code = "C"))  then 1 else 0 end) class5_paid,
		    sum(case when ((transactions.mvc = 7 and transactions.payment_code = "V") or (transactions.mvc = 8 and transactions.payment_code = "V") or  (transactions.mvc = 9 and transactions.payment_code = "V" ) or (transactions.mvc = 10 and transactions.payment_code = "V")) OR ((transactions.mvc = 12 and transactions.svc = 7 and transactions.payment_code = "V") or (transactions.mvc = 12 and transactions.svc = 8 and transactions.payment_code = "V") or  (transactions.mvc = 12 and transactions.svc = 9 and transactions.payment_code = "V" ) or (transactions.mvc = 12 and transactions.svc = 10 and transactions.payment_code = "V")) then 1 else 0 end) class5_voilate,
		    sum(case when ((transactions.mvc = 7 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or (transactions.mvc = 8 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or  (transactions.mvc = 9 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or (transactions.mvc = 10 and (transactions.payment_code = "X" OR transactions.payment_code = "P"))) OR ((transactions.mvc = 12 and transactions.svc = 7 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or (transactions.mvc = 12 and transactions.svc = 8 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or  (transactions.mvc = 12 and transactions.svc = 9 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or (transactions.mvc = 12 and transactions.svc = 10 and (transactions.payment_code = "X" OR transactions.payment_code = "P"))) then 1 else 0 end) class5_exempt,
		    sum(case when (transactions.mvc = 7 or transactions.mvc = 8 or  transactions.mvc = 9 or transactions.mvc = 10) OR ((transactions.mvc = 12 and transactions.svc = 7) or (transactions.mvc = 12 and transactions.svc = 8) or  (transactions.mvc = 12 and transactions.svc = 9) or (transactions.mvc = 12 and transactions.svc = 10)) then 1 else 0 end) class5_total
		 
		  
			FROM
		    tollplaza_live
		    LEFT OUTER JOIN toolplaza ON tollplaza_live.tollplaza_id = toolplaza.id
		    LEFT OUTER JOIN transactions ON tollplaza_live.tollplaza_id = transactions.tollplaza_id
			WHERE date_format(transactions.date, "%Y-%m-%d") = (SELECT date_format(Max(date), "%Y-%m-%d") FROM transactions WHERE tollplaza_id = tollplaza_live.tollplaza_id)
			GROUP BY
		    tollplaza_live.tollplaza_id';

			$query= $this->db->query($sql);
			
			$this->page_data['record'] = $query->result_array(); 
			//echo "<pre>";
			//print_r($this->page_data['record']); exit;
			$this->load->view('back/tollplaza_data', $this->page_data);

		
		
		
	}


	function get_tollplaza_data(){
		$sql = 'SELECT toolplaza.id , toolplaza.name,tollplaza_live.tollplaza_id,
		    transactions.tollplaza_id,
		    DATE_FORMAT(transactions.date, " %M %d, %Y") as date,
		    
		    COUNT(transactions.id) AS total_vehicles,
		    sum(case when (transactions.mvc = 1 and transactions.payment_code = "C") OR (transactions.mvc = 12 and transactions.svc = 1 and transactions.payment_code = "C") then 1 else 0 end) class1_paid,
		    sum(case when (transactions.mvc = 1 and transactions.payment_code = "V") OR (transactions.mvc = 12 and transactions.svc = 1 and transactions.payment_code = "V") then 1 else 0 end) class1_voilate,
		    sum(case when (transactions.mvc = 1 and (transactions.payment_code = "X" or transactions.payment_code = "P")) OR (transactions.mvc = 12 and transactions.svc = 1 and (transactions.payment_code = "X" or transactions.payment_code = "P")) then 1 else 0 end) class1_exempt,
		    sum(case when (transactions.mvc = 1) OR (transactions.mvc = 12 and transactions.svc = 1)  then 1 else 0 end) class1_total,
		    sum(case when (transactions.mvc = 2 and transactions.payment_code = "C") OR (transactions.mvc = 12 and transactions.svc = 2 and transactions.payment_code = "C") then 1 else 0 end) class2_paid,
		    sum(case when (transactions.mvc = 2 and transactions.payment_code = "V") OR (transactions.mvc = 12 and transactions.svc = 2 and transactions.payment_code = "V") then 1 else 0 end) class2_voilate,
		    sum(case when (transactions.mvc = 2 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) OR (transactions.mvc = 12 and transactions.svc = 2 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) then 1 else 0 end) class2_exempt,
		    sum(case when (transactions.mvc = 2) OR (transactions.mvc = 12 and transactions.svc = 2) then 1 else 0 end) class2_total,
		    sum(case when ((transactions.mvc = 3 and transactions.payment_code = "C")  OR  (transactions.mvc = 5 and transactions.payment_code = "C") or (transactions.mvc = 6 and transactions.payment_code = "C")) OR ((transactions.mvc = 12 and transactions.svc = 3 and transactions.payment_code = "C")  OR  (transactions.mvc = 12 and transactions.svc = 5 and transactions.payment_code = "C") or (transactions.mvc = 12 and transactions.svc = 6 and transactions.payment_code = "C"))  then 1 else 0 end) class3_paid,
		    sum(case when ((transactions.mvc = 3 and transactions.payment_code = "V")  OR  (transactions.mvc = 5 and transactions.payment_code = "V") or (transactions.mvc = 6 and transactions.payment_code = "V")) OR ((transactions.mvc = 12 and transactions.svc = 3 and transactions.payment_code = "V")  OR  (transactions.mvc = 12 and transactions.svc = 5 and transactions.payment_code = "V") or (transactions.mvc = 12 and transactions.svc = 6 and transactions.payment_code = "V")) then 1 else 0 end) class3_voilate,
		    sum(case when ((transactions.mvc = 3 and (transactions.payment_code = "X" OR transactions.payment_code = "P"))  OR  (transactions.mvc = 5 and (transactions.payment_code = "X" or transactions.payment_code = "P")) or (transactions.mvc = 6 and (transactions.payment_code = "X" or transactions.payment_code = "P"))) OR ((transactions.mvc = 12 and transactions.svc = 3 and (transactions.payment_code = "X" OR transactions.payment_code = "P"))  or  (transactions.mvc = 12 and transactions.svc = 5 and (transactions.payment_code = "X" or transactions.payment_code = "P")) or (transactions.mvc = 12 and transactions.svc = 6 and (transactions.payment_code = "X" or transactions.payment_code = "P")))  then 1 else 0 end) class3_exempt,
		    sum(case when (transactions.mvc = 3 or  transactions.mvc = 5 or transactions.mvc = 6) OR ((transactions.mvc = 12 and transactions.svc = 3) or  (transactions.mvc = 12 and transactions.svc = 5) or (transactions.mvc = 12 and transactions.svc = 6)) then 1 else 0 end) class3_total,
		    sum(case when (transactions.mvc = 4 and transactions.payment_code = "C") OR (transactions.mvc = 12 and transactions.svc = 4 and transactions.payment_code = "C") then 1 else 0 end) class4_paid,
		    sum(case when (transactions.mvc = 4 and transactions.payment_code = "V") OR (transactions.mvc = 12 and transactions.svc = 4 and transactions.payment_code = "V") then 1 else 0 end) class4_voilate,
		    sum(case when (transactions.mvc = 4 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) OR (transactions.mvc = 12 and transactions.svc = 4 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) then 1 else 0 end) class4_exempt,
		    sum(case when (transactions.mvc = 4) OR (transactions.mvc = 12 and transactions.svc = 4) then 1 else 0 end) class4_total,
		    sum(case when ((transactions.mvc = 7 and transactions.payment_code = "C") or (transactions.mvc = 8 and transactions.payment_code = "C") or  (transactions.mvc = 9 and transactions.payment_code = "C" ) or (transactions.mvc = 10 and transactions.payment_code = "C")) OR ((transactions.mvc = 12 and  transactions.svc = 7 and transactions.payment_code = "C") or (transactions.mvc = 12 and transactions.svc = 8 and transactions.payment_code = "C") or  (transactions.mvc = 12 and transactions.svc = 9 and transactions.payment_code = "C" ) or (transactions.mvc = 12 and  transactions.svc = 10 and transactions.payment_code = "C"))  then 1 else 0 end) class5_paid,
		    sum(case when ((transactions.mvc = 7 and transactions.payment_code = "V") or (transactions.mvc = 8 and transactions.payment_code = "V") or  (transactions.mvc = 9 and transactions.payment_code = "V" ) or (transactions.mvc = 10 and transactions.payment_code = "V")) OR ((transactions.mvc = 12 and transactions.svc = 7 and transactions.payment_code = "V") or (transactions.mvc = 12 and transactions.svc = 8 and transactions.payment_code = "V") or  (transactions.mvc = 12 and transactions.svc = 9 and transactions.payment_code = "V" ) or (transactions.mvc = 12 and transactions.svc = 10 and transactions.payment_code = "V")) then 1 else 0 end) class5_voilate,
		    sum(case when ((transactions.mvc = 7 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or (transactions.mvc = 8 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or  (transactions.mvc = 9 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or (transactions.mvc = 10 and (transactions.payment_code = "X" OR transactions.payment_code = "P"))) OR ((transactions.mvc = 12 and transactions.svc = 7 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or (transactions.mvc = 12 and transactions.svc = 8 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or  (transactions.mvc = 12 and transactions.svc = 9 and (transactions.payment_code = "X" OR transactions.payment_code = "P")) or (transactions.mvc = 12 and transactions.svc = 10 and (transactions.payment_code = "X" OR transactions.payment_code = "P"))) then 1 else 0 end) class5_exempt,
		    sum(case when (transactions.mvc = 7 or transactions.mvc = 8 or  transactions.mvc = 9 or transactions.mvc = 10) OR ((transactions.mvc = 12 and transactions.svc = 7) or (transactions.mvc = 12 and transactions.svc = 8) or  (transactions.mvc = 12 and transactions.svc = 9) or (transactions.mvc = 12 and transactions.svc = 10)) then 1 else 0 end) class5_total
		 
		  
			FROM
		    tollplaza_live
		    LEFT OUTER JOIN toolplaza ON tollplaza_live.tollplaza_id = toolplaza.id
		    LEFT OUTER JOIN transactions ON tollplaza_live.tollplaza_id = transactions.tollplaza_id
			WHERE date_format(transactions.date, "%Y-%m-%d") = (SELECT date_format(Max(date), "%Y-%m-%d") FROM transactions WHERE tollplaza_id = tollplaza_live.tollplaza_id)
			GROUP BY
		    tollplaza_live.tollplaza_id';
        	     $query= $this->db->query($sql);
    		 
    		    echo json_encode($query->result_array()); 

	}

	///////////////Tollplaza Lanes///////////////////

	public function tollplaza_lanes($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['lanes'] = $this->db->get('tollplaza_lanes')->result_array();
			$this->load->view('back/tollplaza_lanes_list', $this->page_data);
			
		}elseif($para1 == 'add'){
			$sql = "Select tollplaza_live.tollplaza_id,toolplaza.id,toolplaza.name FROM tollplaza_live JOIN toolplaza ON 
			tollplaza_live.tollplaza_id = toolplaza.id WHERE tollplaza_live.status = 1";

			$this->page_data['tollplaza'] = $this->db->query($sql)->result_array();
			$this->load->view('back/tollplaza_lanes_add',$this->page_data);
		}elseif($para1 == 'do_add'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tollplaza','Tollplaza','required|trim');
			$this->form_validation->set_rules('name', 'Lane', 'required|trim');
			$this->form_validation->set_rules('type', 'Lane Type', 'required|trim');
			$this->form_validation->set_rules('ip_address', 'Lane IP Address', 'required|trim|valid_ip');
			if($this->form_validation->run() == FALSE){
			 		echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		
			}else{
				$check = $this->db->get_where('tollplaza_lanes',array('toll_plaza' => $this->input->post('tollplaza'),'ipaddress' => trim($this->input->post('ip_address'))))->result_array();
				if($check){
					echo json_encode(array('respose' => FALSE , 'message' => "Lane (IP Address) for this Tollplaza already exists"));exit;
				}
				
				$insert_data = array();
				$insert_data['toll_plaza'] = $this->input->post('tollplaza');
				$insert_data['name'] = $this->input->post('name');
				$insert_data['type'] = $this->input->post('type');
				$insert_data['ipaddress'] = $this->input->post('ip_address');
				$insert_data['date'] = time();
				$this->db->insert('tollplaza_lanes',$insert_data);
				echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/tollplaza_lanes')); exit;
		

			}
		}elseif($para1 == 'edit'){
			$this->page_data['lane'] = $this->db->get_where('tollplaza_lanes',array('id' => $para2))->result_array();
			$sql = "Select tollplaza_live.tollplaza_id,toolplaza.id,toolplaza.name FROM tollplaza_live JOIN toolplaza ON 
			tollplaza_live.tollplaza_id = toolplaza.id WHERE tollplaza_live.status = 1";

			$this->page_data['tollplaza'] = $this->db->query($sql)->result_array();
			$this->load->view('back/tollplaza_lanes_edit',$this->page_data);
		
		}elseif($para1 == 'do_update'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tollplaza','Tollplaza','required|trim');
			$this->form_validation->set_rules('name', 'Lane', 'required|trim');
			$this->form_validation->set_rules('type', 'Lane Type', 'required|trim');
			$this->form_validation->set_rules('ip_address', 'Lane IP Address', 'required|trim|valid_ip');
			if($this->form_validation->run() == FALSE){
			 		echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		
			}else{
				$this->db->where('id !=', $para2);
				$this->db->where('toll_plaza', $this->input->post('tollplaza'));
				$this->db->where('ipaddress', trim($this->input->post('ip_address')));
				$check = $this->db->get('tollplaza_lanes')->result_array();
				if($check){
					echo json_encode(array('respose' => FALSE , 'message' => "Lane (IP Address) for this Tollplaza already exists"));exit;
				}
				$insert_data = array();
				$insert_data['toll_plaza'] = $this->input->post('tollplaza');
				$insert_data['name'] = $this->input->post('name');
				$insert_data['type'] = $this->input->post('type');
				$insert_data['ipaddress'] = $this->input->post('ip_address');
				$insert_data['date'] = time();
				$this->db->where('id',$para2);
				$this->db->update('tollplaza_lanes',$insert_data);
				echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/tollplaza_lanes')); exit;
		

			}

		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('tollplaza_lanes');
		}elseif ($para1 == 'tp_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('tollplaza_lanes', $data);
           echo $para3;
        }else{
        	$this->page_data['page'] = 'Tollplaza_lanes';
			$this->load->view('back/tollplaza_lanes', $this->page_data);
		}
		
		
	}

	///////////////Tollplaza Lanes///////////////////

	public function tollplaza_live($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');

		}
		if($para1 == 'list'){
			$this->page_data['tollplaza_live'] = $this->db->get('tollplaza_live')->result_array();
			$this->load->view('back/tollplaza_live_list', $this->page_data);
			
		}elseif($para1 == 'add'){
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('back/tollplaza_live_add',$this->page_data);
		}elseif($para1 == 'do_add'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tollplaza','Tollplaza','required|trim');
			$this->form_validation->set_rules('services', 'Services', 'required|trim');
			$this->form_validation->set_rules('server_type', 'Server Type', 'required|trim');
			$this->form_validation->set_rules('type', 'Server Type', 'required|trim');
			$this->form_validation->set_rules('ip_address', 'Server IP Address', 'required|trim|valid_ip');
			$this->form_validation->set_rules('port', 'Server Port', 'required|trim');
			$this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('pwd', 'Password', 'required|trim');
			
			if($this->form_validation->run() == FALSE){
			 		echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		
			}else{
				$insert_data = array();
				$insert_data['tollplaza_id'] = $this->input->post('tollplaza');
				$insert_data['server_type'] = $this->input->post('server_type');
				$insert_data['type'] = $this->input->post('type');
				$insert_data['server_ip'] = $this->input->post('ip_address');
				$insert_data['services'] = $this->input->post('services');
				$insert_data['port'] = $this->input->post('port');
				$insert_data['username'] = $this->input->post('username');
				$insert_data['password'] = $this->input->post('pwd');
				$insert_data['date'] = time();
				$this->db->insert('tollplaza_live',$insert_data);
				echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/tollplaza_live')); exit;
		}
		}elseif($para1 == 'edit'){
			$this->page_data['tollplaza_live'] = $this->db->get_where('tollplaza_live',array('id' => $para2))->result_array();
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('back/tollplaza_live_edit',$this->page_data);
		
		}elseif($para1 == 'do_update'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tollplaza','Tollplaza','required|trim');
			$this->form_validation->set_rules('services', 'Services', 'required|trim');
			$this->form_validation->set_rules('server_type', 'Server Type', 'required|trim');
			$this->form_validation->set_rules('type', 'Server Type', 'required|trim');
			$this->form_validation->set_rules('ip_address', 'Server IP Address', 'required|trim|valid_ip');
			$this->form_validation->set_rules('port', 'Server Port', 'required|trim');
			$this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('pwd', 'Password', 'required|trim');
			if($this->form_validation->run() == FALSE){
			 		echo json_encode(array('respose' => FALSE , 'message' => validation_errors()));exit;
		
			}else{
				$insert_data = array();
				$insert_data['tollplaza_id'] = $this->input->post('tollplaza');
				$insert_data['server_type'] = $this->input->post('server_type');
				$insert_data['type'] = $this->input->post('type');
				$insert_data['server_ip'] = $this->input->post('ip_address');
				$insert_data['services'] = $this->input->post('services');
				$insert_data['port'] = $this->input->post('port');
				$insert_data['username'] = $this->input->post('username');
				$insert_data['password'] = $this->input->post('pwd');
				//$insert_data['date'] = time();
				$this->db->where('id',$para2);
				$this->db->update('tollplaza_live',$insert_data);
				echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully' , 'is_redirect' =>TRUE , 'redirect_url' => base_url().'admin/tollplaza_live')); exit;
		

			}

		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('tollplaza_live');
		}elseif ($para1 == 'tp_publish_set') {
            $article = $para2;
            if ($para3 == 'true') {
                $data['status'] = '1';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('id', $article);
            $this->db->update('tollplaza_live', $data);
           echo $para3;
        }else{
        	$this->page_data['page'] = 'Tollplaza_live';
			$this->load->view('back/tollplaza_live', $this->page_data);
		}
		
		
	}




	

}
