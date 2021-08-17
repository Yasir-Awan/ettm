<?php
defined('BASEPATH') or exit('NO direct script is allowed');
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
		$this->page_data['key'] = $this->db->get_where('settings', array('type' => 'google_map_api_key'))->row()->value;
	}

	public function index()
	{
		//echo "test"; die;
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		if ($this->session->userdata('adminid') == 22) {
			return redirect('NHMP_dashboard/index');
		}
		$data = $this->Admin_model->chartdata();
		// echo "<pre>";
		// print_r($data);
		// exit;
		// $this->load->model('General');
		// $this->General->notifications();
		$previous_year = date("Y-m-d", strtotime(@$data['chart']['month'] . ' -1 year'));
		$previous_monthDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(@$data['chart']['month'])) . "-1 month"));
		$pre_year_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_year);
		$pre_month_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_monthDate);

		$this->page_data['mtr'] = $this->db->get_where('mtr', array('id' => $data['mtr_id']))->result_array();
		$month_year = explode('-', $this->page_data['mtr'][0]['for_month']);
		//echo "<pre>";
		//print_r($month_year); exit;
		$start_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['end_date'];
		$sql = "Select * From terrif Where FIND_IN_SET (" . $this->page_data['mtr'][0]['toolplaza'] . " ,toolplaza) AND (start_date <= '" . $start_date . "' AND end_date >= '" . $end_date . "')";
		$this->page_data['terrif'] = $this->db->query($sql)->result_array();

		$this->page_data['mtrid'] = $data['mtr_id'];
		$this->page_data['plaza_id'] = $data['chart']['toolplaza_id'];
		$this->page_data['month'] = $data['chart']['month'];

		if ($this->session->userdata('adminid') == 28) {
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1, 'id' => 10))->result_array();
		}
		if ($this->session->userdata('adminid') == 29) {
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1, 'id' => 11))->result_array();
		} else {
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
		}
		$this->page_data['chart'] = $data['chart'];

		$this->page_data['revenue'] = $data['revenue'];
		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
		$this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
		$this->page_data['pre_year_chart'] = $pre_year_data['chart'];
		$this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];
		$this->page_data['page'] = 'Dashboard';

		$this->load->view('back/dashboard', $this->page_data);
	}
	/*Author: Numaan 
	Function name: dasboard Parameter Name $id, $tool
	Function: Its the main function that displays dashboardST
	Date Creation: Late
	Optimized Date: 5/10/2020*/
	public function dashboard()
	{
		date_default_timezone_set("Asia/Karachi");
		$this->load->model('dashboardst');
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$id = 'today';
		//Loading Tollplazas from Database
		$table = 'toolplaza';
		$where = array('status' => 1);
		$tool = $this->database_model->get_where($table, $where)->result_array();
		///DSR Area Start
		$this->dash_dsr($id, $tool);
		///DSR Area Closed
		///DTR Area Start 
		$dtrid = 'today-dtr';
		$this->dash_dtr($dtrid, $tool);
		///DTR Area End
		$this->page_data['id'] = $id;

		/*?><pre> <?php echo print_r($this->page_data);exit;*/
		$this->page_data['page'] = 'Dashboard ST';
		$this->load->view('back/Ddashboard', $this->page_data);
	}
	/*Author: Numaan 
	Function name: dasboard_dsr Parameter Name $id, $tool
	Function: It deals with all the ajax calls done from DashbaordST
	Date Creation: Late
	Optimized Date: 5/10/2020*/
	public function dashboard_dsr()
	{
		date_default_timezone_set("Asia/Karachi");
		$this->load->model('dashboardst');
		$id = $this->input->post('id');
		//Loading Tollplazas from Database
		$table = 'toolplaza';
		$where = array('status' => 1);
		$tool = $this->database_model->get_where($table, $where)->result_array();
		if ($id == "today" || $id == "yesterday" || $id == "current-month" || $id == "current-quarter" || $id == 'current-semiannual') {

			///DSR Area Start
			$this->dash_dsr($id, $tool);
			///DSR Area Closed
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dsr", $this->page_data);
		} elseif ($id == "today-dtr" || $id == "yesterday-dtr" || $id == "current-month-dtr" || $id == "current-quarter-dtr" || $id == "current-semiannual-dtr") {
			///DtR Area Start
			$this->dash_dtr($id, $tool);
			///DtR Area Closed
			/*?> <?php echo print_r($this->page_data);exit;*/
			$this->page_data['id'] = $id;
			$this->page_data['page'] = 'Dashboard ST';
			$this->load->view("back/includes/dashboarddtrdsr/dtr", $this->page_data);
		}
	}
	///Algorithms
	/*Author: Numaan 
	Function name: toll_dsr_all_dates
	Function: to get dsr of one tollplaza all dates, its used in dsr_dtr_all_dates function
	Date Creation: 5/29/2020*/
	//Date Optimization: 6/1/2020 for DTR
	public function toll_dsr_all_dates($toll_id, $tool_no, $post)
	{
		/* echo print_r(date('H:i:s',strtotime($post['upload_time'])));exit; */
		$data['tool'][$tool_no]['dsr'] = $this->dashboardst->dsr_extended($post['id'], $toll_id, $post);
		$data['tool'][$tool_no]['detail'] = $this->extend_id_dash($post['id'], $toll_id, $data['tool'][$tool_no]['dsr'], $post);
		$data['tool'][$tool_no]['dates'] = $this->dashboard_st_dates($post['id'], $data['tool'][$tool_no]['detail']);
		$dsr_no = 0;
		/* ?> <pre> <?php echo print_r($data['tool'][$tool_no]['dsr']);exit; */
		/*?><pre><?php*/
		if (isset($data['tool'][$tool_no]['dsr'])) {
			foreach ($data['tool'][$tool_no]['dsr'] as $dsr) {
				if (isset($dsr['dsr_date'])) {
					$dsr_date = $dsr['dsr_date'];
					$dsr_date_time = $dsr['dsr_date'] . ' ' . date('H:i:s', strtotime($post['upload_time']));
					$dsr_super_time = $dsr['dsr_date'] . ' ' . date('H:i:s', strtotime($post['supervise_time']));
					$upload = ((int)$dsr['created_at']);
				}
				if (isset($dsr['for_date'])) {
					$dsr_date = $dsr['for_date'];
					$dsr_date_time = $dsr['for_date'] . ' ' . date('H:i:s', strtotime($post['upload_time']));
					$dsr_super_time = $dsr['for_date'] . ' ' . date('H:i:s', strtotime($post['supervise_time']));
					$upload = ((int)$dsr['adddate']);
				}
				//$dsr_date_int = strtotime('-1 Days',$dsr_date_time);						
				if (strpos($post['id'], 'dtr')) {
					//echo gettype($dsr_date_time); exit;
					//if($dsr_date_time != "") $dsr_date_time = date('Y-m-d H:i:s',strtotime('-1 Days',$dsr_date_time));
					$upload = date('Y-m-d H:i:s', strtotime('-1 Days', $upload));
				} else {
					$upload = date('Y-m-d H:i:s', $upload);
				}
				$upload_difference = $this->time_difference($dsr_date_time, $upload);

				$data['tool'][$tool_no]['dsr'][$dsr_no]['dsr_date'] = date('j F Y', strtotime($dsr_date));
				$data['tool'][$tool_no]['dsr'][$dsr_no]['upload'] = $upload;
				if (isset($upload_difference)) {
					if ($upload_difference != '') {
						$data['tool'][$tool_no]['dsr'][$dsr_no]['upload_diff'] = $upload_difference;
					}
				}
				if (isset($dsr['supervised_at'])) {
					if ($dsr['supervised_at'] != '') {
						$supervise = (int)$dsr['supervised_at'];
						$supervise = date('Y-m-d H:i:s', $supervise);
						$supervise_difference = $this->time_difference($dsr_super_time, $supervise);
						$data['tool'][$tool_no]['dsr'][$dsr_no]['supervise'] = $supervise;
						if (isset($supervise_difference)) {
							if ($supervise_difference != '') {
								$data['tool'][$tool_no]['dsr'][$dsr_no]['supervise_diff'] = $supervise_difference;
							}
						}
					}
				}
				if (isset($dsr['actiondate'])) {
					if ($dsr['actiondate'] != '') {
						$supervise = (int)$dsr['actiondate'];
						$supervise = date('Y-m-d H:i:s', strtotime('-1 Days', $supervise));
						$supervise_difference = $this->time_difference($dsr_super_time, $supervise);
						$data['tool'][$tool_no]['dsr'][$dsr_no]['supervise'] = $supervise;
						if (isset($supervise_difference)) {
							if ($supervise_difference != '') {
								$data['tool'][$tool_no]['dsr'][$dsr_no]['supervise_diff'] = $supervise_difference;
							}
						}
					}
				}
				/*?> <?php echo '<br>upload_time is '.$this->input->post("$upload_time");
				?> <?php echo '<br>upload_toll_time is '.$upload;
				?> <?php echo '<br>upload_time_difference is '.$upload_difference;

				?> <?php echo '<br>supervised_time is '.$this->input->post("supervise_time");

				?> <?php echo '<br>supervised_toll_time is '; if(isset($supervise)) echo $supervise;
				?> <?php echo '<br>supervise_time_difference is '; if(isset($supervise)) echo $supervise_difference;
				?> <?php echo '<br>dsr_date_time is '.$dsr_date_time;
				?> <?php echo '<br>dsr_super_time is '.$dsr_super_time;	*/
				$dsr_no++;
			}
		}
		/*?><pre> <?php echo print_r($data);exit;*/
		return $data['tool'][$tool_no];
	}
	/*Author: Numaan
	Function name: time_difference
	Function: To get difference between two times ...
	Date Creation: 5/28/2020
	Optimized date : 5/29/2020*/
	public function time_difference($date1, $date2)
	{
		date_default_timezone_set("Asia/Karachi");
		$date_1 = date_create($date1);
		$date_2 = date_create($date2);
		$diff = date_diff($date_1, $date_2);

		if ($diff->y == 0) {
			$difference = $diff->m . ' Month ' . $diff->d . ' Days ' . $diff->h . ' Hours ' . $diff->i . ' Minutes';
		}
		if ($diff->y == 0 && $diff->m == 0) {
			$difference = $diff->d . ' Days ' . $diff->h . ' Hours ' . $diff->i . ' Minutes';
		}
		if ($diff->y == 0 && $diff->m == 0 && $diff->d == 0) {
			$difference = $diff->h . ' Hours ' . $diff->i . ' Minutes';
		}
		if ($diff->y == 0 && $diff->m == 0 && $diff->d == 0 && $diff->h == 0) {
			$difference = $diff->i . ' Minutes';
		}
		if ($diff->invert == 1) {
			$difference = '';
		}
		/*?><pre> <?php echo print_r($diff);*/
		return $difference;
	}
	/*Author: Numaan 
	Function name: dash_dsr Parameter Name $id, $tool
	Function: To get and display data for DSR portion in Dashboard ST
	Date Creation: 5/7/2020
	Optimized date : 5/10/2020*/
	public function dash_dsr($id, $tool)
	{
		date_default_timezone_set("Asia/Karachi");
		$dsr = $this->dashboardst->main($id);
		/*?><pre> <?php echo print_r($dsr);exit;*/
		/*?> <?php echo print_r($tool);exit;*/
		if ($id ==  'today' || $id == 'yesterday') {
			//calculation total lanes and closed lanes in all tollplazas
			$dsr[2]['all_tool'] = $this->dashboardst->data($id, NULL);
			//calculation total lanes and closed lanes in all tollplazas
			$dsr[2]['all_tool_lane_cameras'] = $this->dashboardst->lane_cameras($id, NULL);
			$toolplaza_st['total_lanes'] = $dsr[2]['all_tool'][0]['total_lanes'];
			$toolplaza_st['closed_lanes'] = $dsr[2]['all_tool'][0]['closed_lanes'];
			$toolplaza_st['faulty_cameras'] =  $dsr[2]['all_tool_lane_cameras'][0]['faulty_cameras'];
		}
		$t = 0;
		foreach ($tool as $toll) {

			$toolplaza_st['tool'][$t]['id'] = $toll['id'];
			$toolplaza_st['tool'][$t]['name'] = $toll['name'];
			$this->page_data['tool']['tool'][$t]['id'] = $toolplaza_st['tool'][$t]['id'];
			$this->page_data['tool']['tool'][$t]['name'] = $toolplaza_st['tool'][$t]['name'];
			if ($id == 'today' || $id == 'yesterday') {
				if (isset($dsr[1])) {
					$k = 0;
					foreach ($dsr[1] as $d) {
						if ($d['toolplaza_id'] == $toll['id']) {

							$table = 'view_dsr_lanes';
							$where = array('dsr_id' => $d['id'], 'toolplaza_id' => $d['toolplaza_id']);
							$dsr[1][$k]['lanes'] = $d_lane = $this->database_model->get_where($table, $where)->result_array();
							//calculating total lanes and closed lanes in respective tollplazas
							$dsr[2]['toolplaza'] = $this->dashboardst->data($id, $d['toolplaza_id']);

							//calculating total lanes and closed lanes in respective tollplazas
							$dsr[2]['tool_lane_cameras'] = $this->dashboardst->lane_cameras($id, $d['toolplaza_id']);

							$tollplaza[$k] = $d['toolplaza_id'];
							/*?><pre> <?php echo print_r($dsr[2]);exit;*/
							$toolplaza_st['tool'][$t]['dsr'][$k]['id'] = $d['id'];
							$toolplaza_st['tool'][$t]['dsr'][$k]['status'] = $d['status'];
							if (isset($toolplaza_st['tool'][$t]['dsr'][$k]['status'])) {
								if ($toolplaza_st['tool'][$t]['dsr'][$k]['status'] != 0) {
									$toolplaza_st['tool'][$t]['dsr'][$k]['omc_name'] = $d['omc_name'];
									$toolplaza_st['tool'][$t]['dsr'][$k]['closed_lanes'] = $dsr[2]['toolplaza'][0]['closed_lanes'];
									$toolplaza_st['tool'][$t]['dsr'][$k]['total_lanes'] = $dsr[2]['toolplaza'][0]['total_lanes'];

									$toolplaza_st['tool'][$t]['dsr'][$k]['faulty_cameras'] = $dsr[2]['tool_lane_cameras'][0]['faulty_cameras'];

									$toolplaza_st['tool'][$t]['dsr'][$k]['total_cameras'] = $dsr[2]['tool_lane_cameras'][0]['total_cameras'];
								}
								if ($toolplaza_st['tool'][$t]['dsr'][$k]['status'] == 0) {
									$toolplaza_st['tool'][$t]['dsr'][$k]['message'] = 'Pending';
								} elseif ($toolplaza_st['tool'][$t]['dsr'][$k]['status'] == 1) {
									$toolplaza_st['tool'][$t]['dsr'][$k]['message'] = 'Approved';
								} elseif ($toolplaza_st['tool'][$t]['dsr'][$k]['status'] == 2) {
									$toolplaza_st['tool'][$t]['dsr'][$k]['message'] = 'Rejected';
								}
							}
							$k++;
							$this->page_data['toolplaza_st']['tool'][$t]['dsr'] = $toolplaza_st['tool'][$t]['dsr'];
							$this->page_data['tool']['tool'] = $toolplaza_st['tool'];
							$this->page_data['tool']['tool'][$t]['dsr'] = $toolplaza_st['tool'][$t]['dsr'];
						}
					}
				}
			} else {
				$this->page_data['tool']['tool'][$t]['count'] = $this->dashboardst->data($id, $toll['id']);
			}

			$t++;
		}
		$this->page_data['dsr'] = $dsr;
	}
	/*Author: Numaan 
	Function name: dash_dtr Parameter Name $id, $tool
	Function: To get and display data for DSR portion in Dashboard ST
	Date Creation: 5/7/2020
	Optimized date : 5/10/2020*/
	public function dash_dtr($id, $tool)
	{
		date_default_timezone_set("Asia/Karachi");
		$dtr = $this->dashboardst->main($id);

		$t = 0;
		foreach ($tool as $toll) {
			$toolplaza_st['tool'][$t]['id'] = $toll['id'];
			$toolplaza_st['tool'][$t]['name'] = $toll['name'];
			$this->page_data['tool']['tool'][$t]['id'] = $toolplaza_st['tool'][$t]['id'];
			$this->page_data['tool']['tool'][$t]['name'] = $toolplaza_st['tool'][$t]['name'];
			if ($id == 'today-dtr' || $id == 'yesterday-dtr') {
				$dtr[2] = $this->dashboardst->total_traffic();
				$this->page_data['tool']['total_traffic'] = $dtr[2][0]['traffic'];
				$this->page_data['tool']['total_revenue'] = $dtr[2][0]['revenue'];
				$k = 0;
				foreach ($dtr[1] as $d) {
					if ($d['toolplaza_id'] == $toll['id']) {
						$toolplaza_st['tool'][$t]['dtr'][0]['id'] = $d['id'];
						$toolplaza_st['tool'][$t]['dtr'][0]['status'] = $d['status'];
						if ($toolplaza_st['tool'][$t]['dtr'][0]['status'] != 0) {
							$toolplaza_st['tool'][$t]['dtr'][0]['omc_name'] = $d['omc_name'];
							$toolplaza_st['tool'][$t]['dtr'][0]['total'] = $d['total'];
							$toolplaza_st['tool'][$t]['dtr'][0]['revenue'] = $d['revenue'];
							if ($toolplaza_st['tool'][$t]['dtr'][0]['status'] == 1) {
								$toolplaza_st['tool'][$t]['dtr'][0]['message'] = 'Approved';
							} elseif ($toolplaza_st['tool'][$t]['dtr'][0]['status'] == 2) {
								$toolplaza_st['tool'][$t]['dtr'][0]['message'] = 'Rejected';
							}
						}
						if ($toolplaza_st['tool'][$t]['dtr'][0]['status'] == 0)
							$toolplaza_st['tool'][$t]['dtr'][0]['message'] = 'Pending';

						$this->page_data['toolplaza_st']['tool'][$t]['dtr'] = $toolplaza_st['tool'][$t]['dtr'];
						$this->page_data['tool']['tool'][$t]['dtr'] = $toolplaza_st['tool'][$t]['dtr'];
					}
					$k++;
				}
			} else {
				$this->page_data['tool']['tool'][$t]['count'] = $this->dashboardst->data($id, $toll['id']);
			}
			/*$this->page_data['tool'] = $toolplaza_st;*/
			$t++;
		}

		/*?><pre> <?php echo print_r($this->page_data['tool']);exit;*/
		$this->page_data['dtr'] = $dtr;
	}
	/*Author: Numaan 
	Function name: dash_dsr_extend
	Function: To display dates of rejected and not uploaded dsr
	Date Creation: 5/12/2020*/
	public function dash_dsr_extend()
	{
		$this->load->model("dashboardst");

		$id = $this->input->post("id");
		$post = $this->input->post();
		/*Author: Numaan 
		Function name: extend_id_dash
		Function: To get data with respect to id
		Date added: 5/21/2020*/
		$toll = '';
		$dsr = '';
		$data = $this->extend_id_dash($id, $toll, $dsr, $post);
		/*Author: Numaan 
		Function name: dashboard_st_dates
		Function: To display dates of rejected and not uploaded dsr
		Date added: 5/21/2020*/
		$this->page_data['dates'] = $this->dashboard_st_dates($id, $data);
		$this->page_data['toolplaza'] = $data['toolplaza'];
		if (strpos($data['htmlid'], 'dtr')) {
			$this->load->view("back/includes/dashboarddtrdsr/dtrpanel/dtr_extended", $this->page_data);
		} else {
			$this->load->view("back/includes/dashboarddtrdsr/dsrpanel/dsr_extended", $this->page_data);
		}
	}
	/*Author: Numaan 
	Function name: repeating_date_check 
	Function: To check whether there are duplicates in dsrs and dtrs 
	Date Creation: 5/18/2020*/
	public function repeating_date_check()
	{
		date_default_timezone_set("Asia/Karachi");
		$this->load->model('dashboardst');
		$toll = $this->db->query('SELECT id, name FROM toolplaza WHERE status = "1"')->result_array();
		$t = 0;
		if (isset($toll)) {

			foreach ($toll as $tool) {
				$this->page_data['dtr_dsr'][$t] = $this->dashboardst->repeating_dates($tool['id']);
				$this->page_data['dtr_dsr'][$t]['name'] = $tool['name'];
				$t++;
			}
		}
		$this->page_data['page'] = "Duplicate Dates";
		$this->load->view('back/includes/dashboarddtrdsr/duplicates', $this->page_data);
	}
	/*Author: Numaan
	/*Author: Numaan
	Function name: dsr_dtr_all_dates
	Fuction: To display the dates of pending, rejected, not uploaded dates as well as their supervision and uploading time 
	Date Creation: 5/21/2020*/
	//Date Optimization: 5/28/2020
	//Date Optimization: 6/1/2020 for DTRs
	//Optimization: Added From and To date in time comparison
	//Date Optimization: 8/5/2020
	public function dsr_dtr_all_dates($para1 = '')
	{
		$this->load->library('form_validation');
		if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
			$this->form_validation->set_rules('from_date', 'From Date', 'required|trim');
			$this->form_validation->set_rules('to_date', 'To Date', 'required|trim');
		}
		$this->form_validation->set_rules('upload_time', 'Upload Time', 'required|trim');
		$this->form_validation->set_rules('supervise_time', 'Supervise Time', 'required|trim');
		if (isset($_POST['id'])) {
			$this->form_validation->set_rules('id', 'DSR/DTR type', 'required|trim');
		} else {
		}
		$this->form_validation->set_rules('tollplaza', 'Tollplaza', 'required|trim');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('back/includes/dashboarddtrdsr/not_found', $_POST);
		} else {
			$post['from_date'] = $this->input->post("from_date");
			$post['to_date'] = $this->input->post("to_date");
			$post['upload_time'] = $this->input->post("upload_time");
			$post['supervise_time'] = $this->input->post("supervise_time");
			$post['tollplaza'] = $this->input->post("tollplaza");
			$post['id'] = $this->input->post("id");
			if (strpos($post['id'], 'dtr')) {
				$data['toggle_dtr'] = 1;
			} else {
				$data['toggle_dtr'] = 0;
			}
			$data['htmlid'] = $post['id'];
			$upload_time = strtotime($post['upload_time']);
			$supervise_time = strtotime($post['supervise_time']);
			$upload_dst = date('H:i:s', $upload_time);
			$this->load->model("dashboardst");
			if ($post['tollplaza'] == 'all') {
				$tool = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
				$tool_no = 0;
				foreach ($tool as $toll) {
					$data['tool'][$tool_no] = $this->toll_dsr_all_dates($toll['id'], $tool_no, $post);
					$tool_no++;
				}
			} else {
				$tool_no = 0;
				$data['tool'][$tool_no] = $this->toll_dsr_all_dates($post['tollplaza'], $tool_no, $post);
			}
			/* ?> <pre><?php echo print_r($data);exit; */
			$this->page_data = $data;
			$this->load->view('back/includes/dashboarddtrdsr/time_report', $this->page_data);
		}
	}
	/*Author: Numaan
	Function name: dsr_dtr_all_dates
	Fuction: To display the dates of pending, rejected, not uploaded dates as well as their supervision and uploading time 
    Date Creation: 5/21/2020
    Optimization: replaced the yearly, quarter, monthly dates with input dates from user*/
	public function dashboard_st_dates($id, $data)
	{
		/* ?><pre> <?php echo print_r($data);exit;  */
		if (isset($data['from_date']) && isset($data['to_date'])) {
			for ($i = strtotime($data['from_date']); $i < strtotime($data['to_date']); $i += 86400) {
				$list[] = date('Y-m-d', $i);
			}
		} else {
			for ($i = $data['start_time']; $i < $data['end_time']; $i += 86400) {
				$list[] = date('Y-m-d', $i);
			}
		}

		$missing_days = array_diff($list, $data['dsr_dtr_dates'][0]);
		/*?> <pre><?php echo print_r($list);exit;*/
		$mis = 0;
		foreach ($missing_days as $miss) {
			$missing[] = date('j F Y', strtotime($miss));
			$mis++;
		}
		$days = 0;
		foreach ($list as $date) {
			$no = 0;
			foreach ($data['dsr_dtr'] as $d) {
				if (strpos($id, 'dtr')) {
					if ($d['for_date'] == $date) {
						if ($d['status'] == 2) {
							$rejected[] = date("j F Y", strtotime($date));
						}
						if ($d['status'] == 1) {
							$approved[] = date("j F Y", strtotime($date));
						}
						if ($d['status'] == 0) {
							$pending[] = date("j F Y", strtotime($date));
						}
					}
				} else {
					if ($d['dsr_date'] == $date) {
						if ($d['status'] == 2) {
							$rejected[] = date("j F Y", strtotime($date));
						}
						if ($d['status'] == 1) {
							$approved[] = date("j F Y", strtotime($date));
						}
						if ($d['status'] == 0) {
							$pending[] = date("j F Y", strtotime($date));
						}
					}
				}
				$no++;
			}
			$days++;
		}
		if (isset($data['dsr_dtr'])) {
			$number = 0;
			foreach ($data['dsr_dtr'] as $d) {
				$number++;
			}
		}
		if (isset($rejected)) {

			$data['rejected'] = $rejected;
		}
		if (isset($dates['pending'])) {

			$data['pending'] = $pending;
		}
		if (isset($missing)) {
			$data['missing'] = $missing;
		}
		return $data;
	}
	/*Author: Numaan
	Function name: extend_id_dash
	Fuction: To get data on the basis of id
    Date Creation: 5/21/2020
    Optimization: Added input dates from user to get data according to them
    Date Optimization: 8/6/2020*/
	public function extend_id_dash($id, $toll, $dsr, $post)
	{
		$id_array[] = explode("-", $id);
		if ($id == NULL) {
			$data['toll'] = $toll;
			$data['htmlid'] = '';
		} elseif ($toll == NULL) {
			$data['toll'] = $id_array[0][4];
		} else {
			$data['toll'] = $toll;
			if (strpos($id, 'dtr')) {
				if (isset($id_array[0][2])) {
					$data['htmlid'] = $id_array[0][0] . "-" . $id_array[0][1] . "-" . $id_array[0][2];
				} else {
					$data['htmlid'] = $id_array[0][0] . "-" . $id_array[0][1];
				}
			} else {
				if (isset($id_array[0][1])) {
					$data['htmlid'] = $id_array[0][0] . "-" . $id_array[0][1];
				} else {
					$data['htmlid'] = $id_array[0][0];
				}
			}
		}

		if (strpos($id, 'dtr')) {
			if (isset($id_array[0][2])) {
				$data['htmlid'] = $id_array[0][0] . "-" . $id_array[0][1] . "-" . $id_array[0][2];
			} else {
				$data['htmlid'] = $id_array[0][0] . "-" . $id_array[0][1];
			}
		}
		if (strpos($id, 'dsr')) {
			$data['htmlid'] = $id_array[0][0] . "-" . $id_array[0][1];
		}
		$data['toolplaza'] = $this->db->get_where('toolplaza', array('id' => $data['toll']))->row()->name;
		if ($data['htmlid'] != NULL) {
			$data['dsr_dtr'] = $this->dashboardst->dsr_extended($data['htmlid'], $data['toll'], $post);
		} else {
			$data['dsr_dtr'] = $dsr;
		}


		if (strpos($id, 'dtr')) {
			$data['dsr_dtr_dates'][] = array_column($data['dsr_dtr'], 'for_date');
			/*?> <?php echo print_r($data);exit;*/
		} else {
			$data['dsr_dtr_dates'][] = array_column($data['dsr_dtr'], 'dsr_date');
			/*?> <?php echo print_r($data);exit;*/
		}
		if ($id == NULL) {
			$data['dsr_dtr_dates'][] = array_column($dsr, 'dsr_date');
		}
		$today_date = date('Y-m-d');

		if (strpos($id, 'semiannual')) {
			$start_date = date('Y-m', strtotime('-5 months')) . '-01';
			$data['start_time'] = strtotime($start_date);
			/*echo $start_date;exit;*/
		}
		if (strpos($id, 'quarter')) {
			$start_date = date('Y-m', strtotime('-2 months')) . '-01';
			$data['start_time'] = strtotime($start_date);
			/*echo $start_date;exit;*/
		}
		if (strpos($id, 'month')) {
			$start_date = date('Y-m') . '-01';
			$data['start_time'] = strtotime($start_date);
		}
		if (strpos($id, 'semiannual-dtr')) {
			$start_date = date('Y-m', strtotime('-5 months')) . '-01';
			$data['end_time'] = strtotime($today_date);
			/*echo $start_date;exit;*/
		}
		if (strpos($id, 'quarter-dtr')) {
			$start_date = date('Y-m', strtotime('-2 months')) . '-01';
			$data['start_time'] = strtotime($start_date);
			$data['end_time'] = strtotime($today_date);
			/*echo $start_date;exit;*/
		}
		if (strpos($id, 'month-dtr')) {
			$start_date = date('Y-m') . '-01';
			$data['start_time'] = strtotime($start_date);
			$data['end_time'] = strtotime($today_date);
			/*echo $start_date;exit;*/
		}
		/*$start_date = $year."-".$month."-01";*/

		if (strpos($id, 'dtr')) {
			if (strpos($id, 'semiannual-dtr')) {
				$start_date = date('Y-m', strtotime('-5 months')) . '-01';
				$data['start_time'] = strtotime($start_date);
				$data['end_time'] = strtotime($today_date);
				/*echo $start_date;exit;*/
			}
			if (strpos($id, 'quarter-dtr')) {
				$start_date = date('Y-m', strtotime('-2 months')) . '-01';
				$data['start_time'] = strtotime($start_date);
				$data['end_time'] = strtotime($today_date);
				/*echo $start_date;exit;*/
			}
			if (strpos($id, 'month-dtr')) {
				$start_date = date('Y-m') . '-01';
				$data['start_time'] = strtotime($start_date);
				$data['end_time'] = strtotime($today_date) + 86400;
				/*echo $start_date;exit;*/
			}
			/*$data['end_time'] = strtotime($today_date);*/
		} else {
			$data['end_time'] = strtotime($today_date) + 86400;
		}
		//added input dates in the data array to load next functions from it 
		if (isset($post['from_date']) && isset($post['to_date'])) {
			$data['from_date'] = $post['from_date'];
			$data['to_date'] = $post['to_date'];
		}

		/*?> <pre> <?php echo 'id = '.$id;
		?>  <?php echo '<br>Start Date = '.date('Y-m-d',$data['start_time']);
		?>  <?php echo '<br>End Date = '.date('Y-m-d',$data['end_time']);exit;*/
		return $data;
	}
	public function daily_comprehensive_site_report()
	{
		date_default_timezone_set("Asia/Karachi");
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$date = date('Y-m-d');
		$data = $this->dsr_model->comprehensive($date);
		$this->page_data['toolplaza'] = $data['toolplaza'];
		$this->page_data['inventory'] = $data['inventory'];
		$this->page_data['today'] = date('d-m-Y');
		$this->page_data['page'] = "Daily Comprehensive Site Report";
		$this->load->view('back/includes/dashboarddtrdsr/sitereport', $this->page_data);
	}
	public function dashboard_dtr()
	{
		date_default_timezone_set("Asia/Karachi");
		$dat = "DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)";
		$href = "all-summary-pday";
		$current = explode("-", $href);
		$datatoday = $this->Admin_model->dashboard_dtr($dat, $href, $current);
		$this->page_data['dtr'] = $datatoday['dtr'];

		$this->page_data['date'] = $dat;
		$this->page_data['current'] = $current[1] . $current[2];
		$this->page_data['section'] = $current[1];
		$this->page_data['duration'] = $current[2];

		if ($this->page_data['dtr']) {

			$this->page_data['toolplazatoday'] = $datatoday['toolplaza'];
			$this->page_data['tollplazatoday'] = $datatoday['tollplaza'];
		} else {
			$this->page_data['message'] = "DTR is not uploaded Yesterday";
			$this->page_data['toolplazatoday'] = $datatoday['toolplaza'];
			$this->page_data['tollplazatoday'] = $datatoday['tollplaza'];
		}


		$this->page_data['page'] = 'DTR Dashboard';
		$this->load->view('back/dashboard_dtr', $this->page_data);
	}
	public function dashboard_dtr_day()
	{
		date_default_timezone_set("Asia/Karachi");
		$dat = $this->input->post('date');
		$href = $this->input->post('href');

		if ($dat && $href) {
			$this->page_data['date'] = $dat;
			$this->page_data['href'] = $href;

			$current = explode("-", $href);

			$datatoday = $this->Admin_model->dashboard_dtr($dat, $href, $current);

			$this->page_data['dtr'] = $datatoday['dtr'];




			$this->page_data['current'] = $current[1] . $current[2];

			$this->page_data['section'] = $current[1];
			$this->page_data['duration'] = $current[2];



			if ($this->page_data['dtr']) {

				$this->page_data['toolplazatoday'] = $datatoday['toolplaza'];
				$this->page_data['tollplazatoday'] = $datatoday['tollplaza'];
			} else {
				if ($current[2] == 'pday') {
					$day = 'Yesterday';
				} elseif ($current[2] == 'pweek') {
					$day = 'Previous Week';
				} elseif ($current[2] == 'pmonth') {
					$day = 'Previous Month';
				} elseif ($current[2] == 'today') {
					$day = 'Today';
				}
				$this->page_data['message'] = "DTR is not uploaded " . $day;

				$this->page_data['toolplazatoday'] = $datatoday['toolplaza'];
				$this->page_data['tollplazatoday'] = $datatoday['tollplaza'];
			}
			/*?> <pre><?php	echo print_r($this->page_data['message'] ); exit;*/
			$this->page_data['page'] = 'DTR Dashboard';

			$this->load->view('back/chartsdashboarddtr', $this->page_data);
		}
	}
	public function dashboard_live()
	{
		date_default_timezone_set("Asia/Karachi");
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$this->load->model('live_model');
		/*When Calculating total for all the live data*/
		$date = NULL;
		$data['total'] = $this->live_model->total($date)->result_array();
		/*wHEN Calculating total for today's live data*/
		$date = date('Y-m-d');
		$data['today'] = $this->live_model->total($date)->result_array();
		$data['page_assets']['css'] 	= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/back/css/odometer-theme-car.css"/>\n<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/back/css/dashboard_live.css"/>';
		$data['page_assets']['js'] 	= '<script src="' . base_url() . 'assets/back/js/odometer.js"></script>';
		$data['page'] = 'dashboard_live';
		/*?> <pre> <?php echo print_r($data);exit;*/
		$this->page_data = $data;
		$this->load->view('back/live', $this->page_data);
	}
	public function live_data()
	{
		$this->load->model('live_model');
		$date = NULL;
		$total = $this->live_model->total($date)->result_array();
		$date = date('Y-m-d');
		$today = $this->live_model->total($date)->result_array();
		echo json_encode(array('total' => $total[0], 'today' => $today[0]));
	}
	////TollPlaza Live Data
	public function toolplaza_live_data()
	{
		if (!$this->session->userdata('adminid')) {
			return redirect('admin/login');
		}
		$info = scandir('C:\Mandra');
		$j = 0;
		foreach ($info as $fl) {
			if (strpos($fl, 'TSaveBatchDBMessage')) {
				$direct[$j] = explode('_TSaveBatchDBMessage.txt', $fl);
				$file_name[$j] = $direct[$j][0];
			}
			$j++;
		}
		$k = 0;
		foreach ($file_name as $file_number) {
			if ($file_number) {
				$filed[$k] = file_get_contents('C:\Mandra\\' . $file_number . '_TSaveBatchDBMessage.txt');

				$data[$k] = explode('End of Record', $filed[$k]);
				$i = 0;

				foreach ($data[$k] as $transaction) {
					if (strpos($transaction, 'SaveTransaction')) {
						$internal[$k]['transaction'][$i] = explode('TSaveTransactionMessage', $transaction);

						$array[$k][$i] = array_map(
							function ($v) {
								return explode(PHP_EOL, $v);
							},
							$internal[$k]['transaction'][$i]
						);
						$array[$k][$i][0] = '';
						$count = 0;
						if ($array[$k][$i]) {
							foreach ($array[$k][$i][1] as $entry) {
								if (strpos($entry, '=')) {
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
						} else {
						}
					} elseif (strpos($transaction, 'SaveIncident')) {
						$internal[$k]['transaction'][$i] = explode('TSaveIncidentMessage', $transaction);

						$array[$k][$i] = array_map(
							function ($v) {
								return explode(PHP_EOL, $v);
							},
							$internal[$k]['transaction'][$i]
						);
						$array[$k][$i][0] = '';
						$count = 0;
						if ($array[$k][$i]) {
							foreach ($array[$k][$i][1] as $entry) {
								if (strpos($entry, '=')) {
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
					} else {
						$internal[$k]['transaction'][$i] = '';
						$array[$k][$i] = '';
					}
					$i++;
				}
			} else {
				$filed[$k] = '';
				$data[$k] = '';
			}
			$k++;
		}
?>
		<pre> <?php echo print_r($toll_entry); ?></pre> <?php exit;
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

														?>
		<pre><?php echo print_r($data[$k]['file']); ?></pre><?php exit;
															$this->load->view('back/toolplaza_data', $data_end);
														}
														///////////////////////////////////////////////////////////////
														////	/** Login Logout START  *////////////////////
														///////////////////////////////////////////////////////////////

														public function login()
														{
															$this->load->view('back/login');
														}
														public function do_login()
														{

															$this->load->library('form_validation');
															$this->form_validation->set_rules('username', 'Email', 'required');
															$this->form_validation->set_rules('password', 'Password', 'required');
															if ($this->form_validation->run() == FALSE) {
																echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
															} else {

																$admin_info  = $this->db->get_where('admin', array(
																	'username' => $this->input->post('username'),
																	'password' => sha1($this->input->post('password'))
																))->result_array();
																if ($admin_info) {
																	$this->session->set_userdata('adminid', $admin_info[0]['id']);
																	$this->session->set_userdata('fname', $admin_info[0]['fname']);
																	$this->session->set_userdata('lname', $admin_info[0]['lname']);
																	$this->session->set_userdata('role', $admin_info[0]['role']);
																	$this->session->set_userdata('site', $admin_info[0]['site']);
																	// echo "<pre>"; print_r($this->session->userdata('site')); exit;
																	if ($this->session->userdata('role') == 3 || $this->session->userdata('role') == 5) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Successfull Login', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'inventory/first_page'));
																	}
																	if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 2 || $this->session->userdata('role') == 4) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Successfull Login', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/index'));
																	}
																} else {

																	echo json_encode(array('response' => FALSE, 'message' => 'Invalid Username or wrong Passord'));
																	exit;
																}
															}
														}
														public function logout()
														{

															$this->session->sess_destroy();
															redirect(base_url() . 'admin', 'refresh');
														}
														public function settings($para1 = '')
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															$this->load->library('form_validation');
															if ($para1 == 'update_basic_info') {
																$this->form_validation->set_rules('fname', 'First Name', 'required|trim');
																$this->form_validation->set_rules('lname', 'Last Name', 'required|trim');
																$this->form_validation->set_rules('username', 'Username Name', 'required|trim');
																//$this->form_validation->set_rules('contact','First Name','required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$data = array();
																	$data['fname'] = $this->input->post('fname');
																	$data['lname'] = $this->input->post('lname');
																	$data['username'] = $this->input->post('username');
																	$this->db->where('id', $this->session->userdata('adminid'));
																	$this->db->update('admin', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/settings'));
																}
															} elseif ($para1 == 'update_pwd') {
																$config = array(
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
																$this->form_validation->set_rules('oldpwd', 'Old Password', 'required|trim');
																$this->form_validation->set_rules($config);
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$check_old = $this->db->get_where('admin', array('id' => $this->session->userdata('adminid'), 'password' => sha1($this->input->post('oldpwd'))))->result_array();
																	//echo $this->db->last_query(); exit;
																	if (empty($check_old)) {
																		echo json_encode(array('response' => FALSE, 'message' => 'You have enter incorrect old password'));
																		exit;
																	} else {
																		$data = array();
																		$data['password'] = sha1($this->input->post('newpwd'));
																		$this->db->where('id', $this->session->userdata('adminid'));
																		$this->db->update('admin', $data);
																		echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/settings'));
																	}
																}
															} else {
																$this->page_data['user'] = $this->db->get_where('admin', array('id' => $this->session->userdata('adminid')))->result_array();
																$this->page_data['page'] = 'settings';
																$this->load->view('back/settings', $this->page_data);
															}
														}

														///////////////////////////////////////////////////////////////
														////	/** Charts START  *////////////////////
														///////////////////////////////////////////////////////////////

														public function check_tollplaza_dates($tollplaza = '')
														{
															$data = $this->Admin_model->get_tollplaza_dates($tollplaza);
															echo json_encode($data);
														}
														public function searchforchart($para1 = '')
														{

															$tollplaza = $this->input->post('tollplaza');
															$month  = $this->input->post('formonth');
															$data = $this->Admin_model->get_chartdata($tollplaza, $month);

															$previous_year = date("Y-m-d", strtotime(@$data['chart']['month'] . ' -1 year'));
															$previous_monthDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(@$data['chart']['month'])) . "-1 month"));
															$pre_year_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_year);

															$pre_month_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_monthDate);

															$this->page_data['mtr'] = $this->db->get_where('mtr', array('id' => $data['mtr_id']))->result_array();
															$month_year = explode('-', $this->page_data['mtr'][0]['for_month']);
															$start_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['start_date'];
															$end_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['end_date'];
															$sql = "Select * From terrif Where FIND_IN_SET (" . $this->page_data['mtr'][0]['toolplaza'] . " ,toolplaza) AND (start_date <= '" . $start_date . "' AND end_date >= '" . $end_date . "')";
															$this->page_data['terrif'] =  $this->db->query($sql)->result_array();

															$this->page_data['mtrid'] = $data['mtr_id'];
															$this->page_data['page'] = 'Dashboard';
															$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
															$this->page_data['chart'] = $data['chart'];

															$this->page_data['revenue'] = $data['revenue'];
															$this->page_data['custom'] = 'custom_search';
															$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
															$this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
															$this->page_data['pre_year_chart'] = $pre_year_data['chart'];
															$this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];

															$this->load->view('back/customize_chart_search', $this->page_data);
														}
														public function check_dtrtollplaza_dates($tollplaza = '')
														{
															$data = $this->Admin_model->get_dtrtollplaza_dates($tollplaza);


															echo json_encode($data);
														}
														public function getdesiredchart()
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															$data = $this->Admin_model->chartdata();
															$previous_previous_month = date("Y-m-d", strtotime(date("Y-m-d", strtotime(@$data['chart']['month'])) . "-2 month"));
															//echo $previous_previous_month; exit;
															$previous_monthDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(@$data['chart']['month'])) . "-1 month"));
															$pre_pre_month_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_previous_month);
															$pre_month_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_monthDate);

															$this->page_data['mtr'] = $this->db->get_where('mtr', array('id' => $data['mtr_id']))->result_array();
															$month_year = explode('-', $this->page_data['mtr'][0]['for_month']);
															//echo "<pre>";
															//print_r($month_year); exit;
															$start_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['start_date'];
															$end_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['end_date'];
															$sql = "Select * From terrif Where FIND_IN_SET (" . $this->page_data['mtr'][0]['toolplaza'] . " ,toolplaza) AND (start_date <= '" . $start_date . "' AND end_date >= '" . $end_date . "')";
															$this->page_data['terrif'] = $this->db->query($sql)->result_array();

															$this->page_data['mtrid'] = $data['mtr_id'];
															$this->page_data['plaza_id'] = $data['chart']['toolplaza_id'];
															$this->page_data['month'] = $data['chart']['month'];


															$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
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
														public function searchfordtrchart($para1 = '')
														{

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
														public function searchfordtrmchart($para1 = '')
														{

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
														public function searchfordesiredchart($para1 = '')
														{

															$tollplaza = $this->input->post('tollplaza');
															$month  = $this->input->post('formonth');
															$data = $this->Admin_model->get_chartdata($tollplaza, $month);
															$previous_previous_month = date("Y-m-d", strtotime(date("Y-m-d", strtotime(@$data['chart']['month'])) . "-2 month"));
															//echo $previous_previous_month; exit;
															$previous_monthDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(@$data['chart']['month'])) . "-1 month"));
															$pre_pre_month_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_previous_month);

															//$previous_year = date("Y-m-d",strtotime(@$data['chart']['month'].' -1 year'));
															//$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
															//$pre_year_data = $this->Admin_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_year);
															$pre_month_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_monthDate);


															$this->page_data['mtr'] = $this->db->get_where('mtr', array('id' => $data['mtr_id']))->result_array();
															$month_year = explode('-', $this->page_data['mtr'][0]['for_month']);
															$start_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['start_date'];
															$end_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['end_date'];
															$sql = "Select * From terrif Where FIND_IN_SET (" . $this->page_data['mtr'][0]['toolplaza'] . " ,toolplaza) AND (start_date <= '" . $start_date . "' AND end_date >= '" . $end_date . "')";
															$this->page_data['terrif'] =  $this->db->query($sql)->result_array();

															$this->page_data['mtrid'] = $data['mtr_id'];
															$this->page_data['page'] = 'Dashboard';
															$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
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
														public function get5yearchart()
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															$duration = 6;
															for ($year = 1; $year < $duration; $year++) {
																$model_call[$year] = $this->model_call_nha_all_mtr_year($year);
															}
															$this->all_tollplaza_5year_mtr($model_call, $duration);


															$this->page_data['page'] = 'Five Years Chart';
															$this->page_data['duration'] = $duration;
															/*?> <pre><?php echo print_r($this->page_data); exit;*/
															/*?> <pre><?php echo print_r($tre_data); exit;*/
															$this->load->view('back/5yearchart', $this->page_data);
														}
														public function get5yeartollchart()
														{
															$time = 5;
															if ($this->input->post('time') != NULL) {
																$time = $this->input->post('time');
															}
															$duration = $time + 1;
															$id = $this->input->post('id');
															$this->page_data['duration'] = $duration;
															$this->page_data['page'] = 'Five Years Chart';
															if ($id == 'none') {
																$this->page_data['id'] = $id;
																$id = '';
																for ($year = 1; $year < $duration; $year++) {
																	$model_call[$year] = $this->model_call_nha_all_mtr_year($year, $duration);
																}
																$this->all_tollplaza_5year_mtr($model_call, $duration);
															} else {
																$this->page_data['id'] = $id;
																for ($year = 1; $year < 6; $year++) {
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

														public function tcd($para1 = '', $para2 = '')
														{
															//It is worth mentioning here that the data collection from traffic counters is based on 5 classes and not 10 as done in MTR and DTR section.
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															} else {
																/*?> <pre> <?php echo print_r($this->session->userdata);exit;*/
																$this->load->model('tcd_model');
																$select = array('id', 'name');
																$table = 'toolplaza';
																$this->page_data['toolplaza'] = $this->database_model->select_from($select, $table)->result_array();
																$this->page_data['admin_name'] = $this->session->userdata['fname'] . ' ' . $this->session->userdata['lname'];
																if ($para1 == 'list') {
																	$page = 'R';
																	$data = $this->tcd_model->lisst();
																	$this->page_data['tcd'] = $data['tcd'];
																	$this->page_data['tool_name'] = $data['tool_name'];
																	$this->load->view('back/tcd_list', $this->page_data);
																} elseif ($para1 == 'add') {
																	$this->page_data['page'] = $page = 'C';
																	$this->load->view('back/add_tcd', $this->page_data);
																} elseif ($para1 == 'do_add') {
																	$page = 'C';
																	$this->load->library('form_validation');
																	$this->form_validation->set_rules('toolplaza_id', 'Tollplaza', 'required|trim');
																	$this->form_validation->set_rules('datecreated', 'Date', 'required|trim');
																	$this->form_validation->set_rules('survey_month', 'Survey Month', 'required|trim');
																	$this->form_validation->set_rules('description', 'Description', 'required|trim');
																	$this->form_validation->set_rules('notes', 'Notes', 'required|trim');
																	$this->form_validation->set_rules('class1', 'Car/Jeep passages', 'required|trim|is_natural');
																	$this->form_validation->set_rules('class2', 'Wagons/Hiace passages', 'required|trim|is_natural');
																	$this->form_validation->set_rules('class3', 'Buses/Coasters passages', 'required|trim|is_natural');
																	$this->form_validation->set_rules('class4', '2,3 Axle Trucks/Tractors/Trolleys passages', 'required|trim|is_natural');
																	$this->form_validation->set_rules('class5', 'Above 3 Axle Articluated Trucks passages', 'required|trim|is_natural');
																	$this->form_validation->set_rules('total', 'Total', 'required|trim|is_natural');
																	if ($this->form_validation->run() == FALSE) {
																		echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																		exit;
																	} else {

																		$tcd_data['toolplaza_id'] = $this->input->post('toolplaza_id');
																		$tcd_data['survey_month'] = $this->input->post('survey_month');
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
																		$table = 'tcd';
																		$data = $tcd_data;
																		$tcd_insert = $this->database_model->insert($table, $data);

																		if (!$tcd_insert) {
																			echo json_encode(array('response' => FALSE, 'message' => 'Traffic Counter Report could not be added'));
																			exit;
																		} else {
																			echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tcd'));
																		}
																	}
																} elseif ($para1 == 'edit') {
																	$this->page_data['page'] = $page = 'U';
																	$tcd = $this->tcd_model->specific_tcr($para2);
																	$this->page_data['tcd'] = $this->tcd_model->tcr_edit_data($para2, $tcd[0]);

																	$this->load->view('back/add_tcd', $this->page_data);
																} elseif ($para1 == 'do_edit') {
																	$this->load->library('form_validation');
																	$this->form_validation->set_rules('toolplaza_id', 'Tollplaza', 'required|trim');
																	$this->form_validation->set_rules('datecreated', 'Date', 'required|trim');
																	$this->form_validation->set_rules('survey_month', 'Survey Month', 'required|trim');
																	$this->form_validation->set_rules('description', 'Description', 'required|trim');
																	$this->form_validation->set_rules('notes', 'Notes', 'required|trim');
																	$this->form_validation->set_rules('class1', 'Car/Jeep passages', 'required|trim|is_natural');
																	$this->form_validation->set_rules('class2', 'Wagons/Hiace passages', 'required|trim|is_natural');
																	$this->form_validation->set_rules('class3', 'Buses/Coasters passages', 'required|trim|is_natural');
																	$this->form_validation->set_rules('class4', '2,3 Axle Trucks/Tractors/Trolleys passages', 'required|trim|is_natural');
																	$this->form_validation->set_rules('class5', 'Above 3 Axle Articluated Trucks passages', 'required|trim|is_natural');
																	$this->form_validation->set_rules('total', 'Total', 'required|trim|is_natural');
																	if ($this->form_validation->run() == FALSE) {
																		echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																		exit;
																	} else {

																		$tcd_data['toolplaza_id'] = $this->input->post('toolplaza_id');
																		$tcd_data['survey_month'] = $this->input->post('survey_month');
																		$tcd_data['datecreated'] = $this->input->post('datecreated');
																		$tcd_data['admin_id'] = $this->session->userdata('adminid');
																		$tcd_data['class1'] = $this->input->post('class1');
																		$tcd_data['class2'] = $this->input->post('class2');
																		$tcd_data['class3'] = $this->input->post('class3');
																		$tcd_data['class4'] = $this->input->post('class4');
																		$tcd_data['class5'] = $this->input->post('class5');
																		$tcd_data['total'] = $this->input->post('total');
																		$tcd_data['status'] = '0';
																		$tcd_data['action_date'] = time();
																		$table = 'tcd';
																		$data = $tcd_data;
																		$where = 'id';
																		$tcd_update = $this->database_model->update($where, $para2, $table, $data);
																		if (!$tcd_update) {
																			echo json_encode(array('response' => FALSE, 'message' => 'Traffic Counter Report could not be added'));
																			exit;
																		} else {
																			echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tcd'));
																		}
																	}
																} elseif ($para1 == 'disapprove') {
																	$page = 'U';
																	$this->page_data['id'] = $id = $para2;
																	$table = 'tcd';
																	$where = array('id' => $id);
																	$check = $this->tcd_model->check_table($table, $where)->result_array();
																	if (!$check) {
																		echo json_encode(array('response' => FALSE, 'message' => 'Traffic Counter Report does not exist'));
																		exit;
																	} else {
																		$this->load->view('back/tcd_disapprove', $this->page_data);
																	}
																} elseif ($para1 == 'disapprove_do') {
																	$page = 'U';
																	$table = 'tcd';
																	$where = array('id' => $para2);
																	$check = $this->database_model->get_where($table, $where)->result_array();
																	if ($check) {
																		if ($check[0]['status'] == 0 || $check[0]['status'] == 1) {
																			if (empty($this->input->post('dissapprove_reason'))) {
																				echo json_encode(array('respose' => FALSE, 'message' => 'Please add reason for dissapproving this daily site report'));
																				exit;
																			} else {
																				$data['status'] = 2;
																				$data['action_date'] = time();
																				$data['disapprove_reason'] = $this->input->post('dissapprove_reason');
																				$where = 'id';
																				$table = 'tcd';
																				$this->database_model->update($where, $para2, $table, $data);
																				echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tcd'));
																				exit;
																			}
																		} else {
																			echo json_encode(array('respose' => FALSE, 'message' => 'Invalid Requestee'));
																			exit;
																		}
																	} else {
																		echo json_encode(array('respose' => FALSE, 'message' => 'Invalid Request'));
																		exit;
																	}
																} elseif ($para1 == 'approve') {
																	$data['status'] = 1;
																	$data['action_date'] = time();
																	$data['disapprove_reason'] = '';
																	$where = 'id';
																	$table = 'tcd';
																	$this->database_model->update($where, $para2, $table, $data);
																} elseif ($para1 == 'delete') {
																	$table = 'tcd';
																	$where = array('id' => $para2);
																	$tcd_data = $this->database_model->get_where($table, $where)->result_array();
																	$id = $dsr_updated[0]['supervisor_id'];
																	$tool = $dsr_updated[0]['toolplaza_id'];
																	$this->database_model->delete($para2, $table);
																} elseif ($para1 == 'view_reason') {
																	$select = array('status', 'disapprove_reason');
																	$table = 'tcd';
																	$where = array('id' => $para2);
																	$reason = $this->database_model->get_select($select, $table, $where)->result_array();
																	/*?> <pre> <?php echo print_r($reason);exit;*/
																	if ($reason[0]['status'] == 2) {
																		echo "<span class='text-info'>" . $reason[0]['disapprove_reason'] . "</span>";
																	} else {
																		echo "<span class='text-danger'>Invalid Request</span>";
																	}
																} elseif ($para1 == 'by_tollplaza') {
																	$page = 'R';
																	if ($para2 != '') {
																		$data = $this->tcd_model->_list($para2);
																		$this->page_data['tcd'] = $data['tcd'];
																		if (isset($data['tool_name'])) {
																			$this->page_data['tool_name'] = $data['tool_name'];
																		}

																		$this->load->view('back/tcd_list', $this->page_data);
																	} else {
																		$para2 = NULL;
																		$data = $this->tcd_model->lisst();
																		$this->page_data['tcd'] = $data['tcd'];
																		$this->page_data['tool_name'] = $data['tool_name'];
																		$this->load->view('back/tcd_list', $this->page_data);
																	}
																} else {
																	$this->page_data['page'] = 'tcd';
																	$this->page_data['page'] = 'Sensors Traffic Counting';
																	$this->load->view('back/tcd', $this->page_data);
																}
															}
														}
														public function traffic_counter_report($para1 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															} else {
																$this->load->model('tcd_model');
																$table = 'tcd';
																$where = array('id' => $para1);
																$tcd_data = $this->tcd_model->postload($table, $where);
																/*echo print_r($tcd_data);exit;*/
																/*?> <pre><?php echo print_r($tcd_data); exit;*/
																$this->load->view('back/tcd_report', $tcd_data);
															}
														}
														public function generate_tcrpdf($para1 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															} else {
																$this->load->model('tcd_model');
																$table = 'tcd';
																$where = array('id' => $para1);
																$tcd_data = $this->tcd_model->postload($table, $where);
																$pdfdata = $this->load->view('back/pdf_tcd', $tcd_data, TRUE);
																$para1 = 'TCR';
																if ($para1 == 'TCR') {
																	$para2 = 'Traffic Counter Report';
																}
																$pdf = $this->pdf_function($para1, $para2, $pdfdata);
															}
														}
														//Algorithms
														//Author: Numaan
														//Purpose: Limit DSR in list of Daily Site Reports Page dsr.list
														//Function Name: dsr_limit
														public function dsr_limit($count, $para2)
														{
															if ($count) {
																$feat['show'] = $count + 200;
																$feat['less'] = $count - 200;
																$id = $para2;
																$tool = NULL;
																$limit = $count;
																$dsr = $this->dsr_model->list_dsr_limit($id, $tool, $limit);
																return array('dsr' => $dsr, 'feat' => $feat);
															} else {
																$feat['show'] = 400;
																$id = $para2;
																$tool = NULL;
																$limit = 200;
																$dsr = $this->dsr_model->list_dsr_limit($id, $tool, $limit);
																return array('dsr' => $dsr, 'feat' => $feat);
															}
														}
														public function dsr_by_toolplaza($para2)
														{
															if ($para2 != '') {
																$id = NULL;
																$table = 'toolplaza';
																$where = array('id' => $para2);
																$toolplaza = $this->dsr_model->get_where($table, $where);
																$tool = $toolplaza[0]['id'];
																$dsr['dsr'] = $this->dsr_model->list_dsr($id, $tool);
																$edit['dsr']  = $dsr;
																$this->load->view('back/dsr_list', $edit);
															} else {
																$id = NULL;
																$tool = NULL;
																$dsr['dsr'] = $this->dsr_model->list_dsr($id, $tool);
																$this->page_data['dsr']  = $dsr;
																$this->load->view('back/dsr_list', $this->page_data);
															}
														}
														public function all_tollplaza_5year_mtr($model_call, $duration)
														{
															$total_traffic = 0;
															$total_not_exempt = 0;
															$total_exempt = 0;
															$total_revenue = 0;
															for ($year = 1; $year < $duration; $year++) {
																for ($class = 1; $class < 6; $class++) {
																	$total_not_exempt_clas[$class] = 0;
																	$total_exempt_clas[$class] = 0;
																	$total_revenue_clas[$class] = 0;
																	$total_not_exempt_class[$year][$class] = 0;
																	$total_exempt_class[$year][$class] = 0;
																	$total_revenue_class[$year][$class] = 0;
																}
															}
															for ($year = 1; $year < $duration; $year++) {
																$dat = $model_call[$year];
																$tre_data = $dat['tre_data'];
																$data = $dat['data'];

																$total_traffic = $total_traffic + $tre_data[$year]['total_traffic'];
																$total_not_exempt = $total_not_exempt + $tre_data[$year]['total_not_exempt'];
																$total_exempt = $total_exempt + $tre_data[$year]['total_exempt'];
																$total_revenue = $total_revenue + $tre_data[$year]['total_revenue'];
																if ($data[$year]) {
																	for ($class = 1; $class < 6; $class++) {

																		$total_not_exempt_class[$year][$class] = $total_not_exempt_class[$year][$class] + $tre_data[$year]['not_exempt'][$class];
																		$total_exempt_class[$year][$class] = $total_exempt_class[$year][$class] + $tre_data[$year]['exempt'][$class];
																		$total_revenue_class[$year][$class] = $total_revenue_class[$year][$class] + $tre_data[$year]['revenue'][$class];
																		$total_not_exempt_clas[$class] = $total_not_exempt_clas[$class] + $tre_data[$year]['not_exempt'][$class];
																		$total_exempt_clas[$class] = $total_exempt_clas[$class] + $tre_data[$year]['exempt'][$class];
																		$total_revenue_clas[$class] = $total_revenue_clas[$class] + $tre_data[$year]['revenue'][$class];
																	}
																} else {
																	$this->page_data['message'] = 'MTRs are not Uploaded yet';
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
														public function model_call_nha_all_mtr_year($year)
														{
															$data[$year] = $this->nha->mtr_per_year($year)->result_array();
															$tre_data[$year] = $this->nha->mtr_traffic_revenue_exempt($data[$year], $year);
															return ['data' => $data, 'tre_data' => $tre_data];
														}
														public function model_call_nha_toll_mtr_year($year, $toll)
														{
															$data[$year] = $this->nha->mtr_toll_per_year($year, $toll)->result_array();
															$tre_data[$year] = $this->nha->mtr_traffic_revenue_exempt($data[$year], $year);
															return ['data' => $data, 'tre_data' => $tre_data];
														}
														public function pdf_function($para1, $para2, $pdfdata)
														{
															$this->load->library("Pdf");
															$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

															$pdf->SetCreator(PDF_CREATOR);
															$pdf->SetAuthor('NHA ' . $para1);
															$pdf->SetTitle('NHA ' . $para2);
															$pdf->SetSubject($para1);
															$pdf->SetKeywords($para1 . ', PDF');

															$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
															$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
															$pdf->Output(strtolower($para1) . '.pdf', 'I');
															//$pdf->Output(SERVER_RELATIVE_PATH . '/uploads/invoices/invoice' . $invoice_name . '.pdf', 'F');
															return $pdf;
														}
														///////////////////////////////////////////////////////////////
														////	/** DTR Charts START  *////////////////////
														///////////////////////////////////////////////////////////////
														public function dtr_chart($para1 = '')
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															$data = $this->Admin_model->dtr_chartdata();

															$datadtr = $this->db->select('*')->order_by('id', 'desc')->limit(1)->get('dtr')->result_array();
															$date_latest = date('n', strtotime($datadtr[0]['for_date']));
															$dtr_month_min = $this->db->where('MONTH(for_date)', $date_latest)->where('toolplaza', $datadtr[0]['toolplaza'])->order_by('for_date', 'asc')->get('dtr')->result_array();
															$dtr_month = $this->db->where('MONTH(for_date)', $date_latest)->where('toolplaza', $datadtr[0]['toolplaza'])->order_by('for_date', 'desc')->get('dtr')->result_array();
															$exempt = $this->db->get_where('dtr_exempt', array('dtr_id' => $datadtr[0]['id']))->result_array();

															$start_date = $dtr_month_min[0]['for_date'];
															$end_date = $dtr_month[0]['for_date'];

															$sql = "Select * From terrif Where FIND_IN_SET (" . $dtr_month_min[0]['toolplaza'] . " ,toolplaza) AND (start_date <= '" . $start_date . "' AND end_date >= '" . $end_date . "')";
															$tarrif =  $this->db->query($sql)->result_array();
															$this->page_data['dtr_month'] = $data['chart']['month'];
															$this->page_data['plaza_id'] = $data['chart']['toolplaza_id'];
															$this->page_data['month'] = $data['chart']['month'];

															$this->page_data['dtr'] = $dtr_month_min;
															$this->page_data['dtrid'] = $data['dtr_id'];
															$this->page_data['exempt'] = $this->db->get_where('dtr_exempt', array('dtr_id' => $this->page_data['dtrid']))->result_array();
															$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
															$this->page_data['chart'] = $data['chart'];
															$this->page_data['revenue'] = $data['revenue'];
															/*?> <pre> <?php echo print_r($this->page_data); exit; ?> </pre> <?php*/

															$this->page_data['page'] = 'Monthly DTR Chart';

															$this->load->view('back/dtr_chart', $this->page_data);
														}
														public function dtr_chart_tool($para1 = '')
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															$data = $this->Admin_model->dtr_chart_tooldata_asc();
															/*$datadesc = $this->Admin_model->dtr_chart_tooldata_desc();*/
															/*?> <pre> <?php echo print_r($data);  ?> </pre> <?php exit;*/

															$datadtr = $this->db->select('*')->order_by('id', 'desc')->limit(1)->get('dtr')->result_array();
															$this->page_data['month_asc']	= $data['month'];
															$this->page_data['tollplaza_asc'] = $data['tollplaza'];
															/*$this->page_data['month_desc']	= $datadesc['month'];
		$this->page_data['tollplaza_desc'] = $datadesc['tollplaza'];*/


															/*?> <pre> <?php echo print_r($this->page_data); exit; ?> </pre> <?php*/
															$this->page_data['page'] = 'M Traffic Chart';
															$this->load->view('back/dtr_chart_tool', $this->page_data);
														}
														public function dtr_comparison_chart()
														{

															$this->load->model('dtr_model');
															$this->load->library('form_validation');
															$this->form_validation->set_rules('month', 'Month', 'required|trim');
															$this->form_validation->set_rules('start_date', 'Start Date', 'required|trim');
															$this->form_validation->set_rules('end_date', 'End Date', 'required|trim');
															if ($this->form_validation->run() == FALSE) {

																$this->load->view('back/dtr_chart/not_found', $this->page_data);
															} else {
																/*if($this->input->post('sub') != NULL){*/
																//$this->page_data['form_attr'] = 'href="'.base_url().'admin/dtr_comparison_chart" formtarget="_blank"';
																$this->load->library('form_validation');
																$this->form_validation->set_rules('month', 'Month', 'required|trim');
																$this->form_validation->set_rules('start_date', 'Start Date', 'required|trim');
																$this->form_validation->set_rules('end_date', 'End Date', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																} else {
																	/* ?><pre> <?php echo print_r($this->input->post());exit; */
																	$mon = $this->input->post('month');
																	$month = $mon . '-01';
																	$first_date = $this->input->post('start_date');
																	$second_date = $this->input->post('end_date');

																	$begin = new DateTime($first_date);
																	$end = new DateTime($second_date);
																	$end->modify('+1');
																	$end->setTime(0, 0, 1);
																	$period = new DatePeriod(
																		$begin,
																		new DateInterval('P1D'),
																		$end
																	);

																	$this->page_data = $this->dtr_model->toolplaza($month, $period, $first_date, $second_date);
																	$this->page_data['month'] = date('F', strtotime($month));

																	$this->page_data['form_attr'] = '';
																	/*?><pre><?php echo print_r($this->page_data);exit;*/
																	if ($this->page_data['tool'][0]['month_total'] == 0) {
																		$this->load->view('back/dtr_chart/traffic_not_found', $this->page_data);
																	} else {
																		$this->load->view('back/dtr_chart/main', $this->page_data);
																	}
																}
															}
														}


														///////////////////////////////////////////////////////////////
														////	/** DSR START  *////////////////////
														///////////////////////////////////////////////////////////////
														//Author: Numaan Javed
														//Purpose: View and Supervise All Daily Site Reports from Tollplaza
														//Function Name: dsr
														public function dsr($para1 = '', $para2 = '', $para3 = '')
														{
															date_default_timezone_set("Asia/Karachi");
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}

															if ($para1 == 'list') {
																$count = $this->input->post('count');
																$dsr = $this->dsr_limit($count, $para2);
																$this->page_data['dsr'] = $dsr;
																/*?> <pre><?php echo print_r($this->page_data);*/
																$this->load->view('back/dsr_list', $this->page_data);
															} elseif ($para1 == 'by_tollplaza') {
																$this->dsr_by_toolplaza($para2);
															} elseif ($para1 == 'approve') {
																$data['status'] = 1;
																$data['disapprove_reason'] = NULL;
																$data['supervised_at'] = time();
																$where = 'id';
																$table = 'dsr';
																$this->dsr_model->update_dsr($where, $para2, $table, $data);
															} elseif ($para1 == 'disapprove') {
																$edit['id'] = $para2;
																$this->load->view('back/dsr_disapprove', $edit);
															} elseif ($para1 == 'disapprove_do') {
																$table = 'dsr';
																$where = array('id' => $para2);
																$check = $this->dsr_model->get_where($table, $where);
																if ($check) {
																	if ($check[0]['status'] == 0 || $check[0]['status'] == 1) {
																		if (empty($this->input->post('dissapprove_reason'))) {
																			echo json_encode(array('respose' => FALSE, 'message' => 'Please add reason for dissapproving this daily site report'));
																			exit;
																		} else {
																			$data['status'] = 2;
																			$data['supervised_at'] = time();
																			$data['disapprove_reason'] = $this->input->post('dissapprove_reason');
																			$where = 'id';
																			$table = 'dsr';
																			$this->dsr_model->update_dsr($where, $para2, $table, $data);
																			echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/dsr'));
																			exit;
																		}
																	} else {
																		echo json_encode(array('respose' => FALSE, 'message' => 'Invalid Requestee'));
																		exit;
																	}
																} else {
																	echo json_encode(array('respose' => FALSE, 'message' => 'Invalid Request'));
																	exit;
																}
															} elseif ($para1 == 'view_reason') {
																$table = 'dsr';
																$where = array('id' => $para2);
																$reason = $this->dsr_model->get_where($table, $where);
																if ($reason[0]['status'] == 2) {
																	echo "<span class='text-info'>" . $reason[0]['disapprove_reason'] . "</span>";
																} else {
																	echo "<span class='text-danger'>Invalid Request</span>";
																}
															} elseif ($para1 == 'delete') {
																$table = 'dsr';
																$where = array('id' => $para2);
																$dsr_updated = $this->dsr_model->get_where($table, $where);
																$id = $dsr_updated[0]['supervisor_id'];
																$tool = $dsr_updated[0]['toolplaza_id'];
																$this->dsr_model->delete_dsr($id, $para2);
															} else {
																$edit['page'] = 'dsr';
																$edit['page_url'] = $edit['page'];
																$table = 'toolplaza';
																$where = array('status' => 1);
																$edit['tollplaza'] = $this->dsr_model->get_where($table, $where);
																$this->load->view('back/dsr', $edit);
															}
														}
														//Author: Numaan Javed
														//Purpose: View detailed Single DSR from Tollplaza
														//Function Name: daily_site_report
														public function daily_site_report($para1 = '')
														{
															//date_default_timezone_set("Asia/Karachi");
															$table = 'dsr';
															$where = array('id' => $para1);
															$dsr_updated = $this->dsr_model->get_where($table, $where);
															if (isset($dsr_updated[0])) {
																$id = $dsr_updated[0]['supervisor_id'];
																$tool =  $dsr_updated[0]['toolplaza_id'];

																$page = 'R'; //CRUD Read 
																//Some data is loaded to run data into dsr variable like Staff, north, south from dsr_lane, and dsr staff tables
																$edit['read'] = $this->dsr_model->sitereport_data_preload($id, $tool, $page, $para1);
																//data is loaded into dsr variable where new layout data is converted to old layout data so that it can be merged easily with older work 
																$edit = $this->dsr_model->dsr_data($id, $tool, $edit['read'], $para1);
															}


															/*?><pre> <?php echo print_r($edit);exit;*/
															if (isset($edit['dsr'][0]['id'])) {
																$this->load->view('front/toolplaza/sitereport-custom', $edit);
															} else {
																$this->load->view('front/toolplaza/dsr/errors/not_found');
															}
														}
														//DSR Settings
														public function inventory($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['inventory'] = $this->db->get('dsr_inventory')->result_array();
																$this->load->view('back/dsr/inventory_list', $this->page_data);
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('dsr_inventory');
															} elseif ($para1 == 'tp_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('dsr_inventory', $data);

																echo $para3;
															} elseif ($para1 == 'add') {
																$this->load->view('back/dsr/inventory_add', $this->page_data);
															} elseif ($para1 == 'add_do') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('name', 'Inventory Name', 'required|trim');
																$this->form_validation->set_rules('installed_at', 'Installed at', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$data  = array();
																	$data['name'] 	= $this->input->post('name');
																	$data['installed_at'] 	= $this->input->post('installed_at');
																	$data['status'] = 0;
																	$data['created_at'] 	= time();
																	$this->db->insert('dsr_inventory', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/inventory'));
																	exit;
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['inventory'] = $this->db->get_where('dsr_inventory', array('id' => $para2))->result_array();
																$this->load->view('back/dsr/inventory_add', $this->page_data);
															} elseif ($para1 == 'update') {
																$data  = array();
																$data['name'] 	= $this->input->post('name');
																$data['installed_at'] 	= $this->input->post('installed_at');
																$data['updated_at'] 	= time();
																$this->db->where('id', $para2);
																$upd = $this->db->update('dsr_inventory', $data);
																if (!$upd) {
																	echo json_encode(array('response' => FALSE, 'message' => 'Update Failed'));
																	exit;
																} else {
																	echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/inventory'));
																	exit;
																}
															} else {
																$this->page_data['page'] = 'DSR Inventory';
																$this->load->view('back/inventory', $this->page_data);
															}
														}
														public function dsr_features($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															} else {
																$this->load->model('features');
																$this->load->model('dsr_model');
																if ($para1 == 'list') {
																	$this->page_data['features'] = $this->db->get('dsr_features')->result_array();
																	$this->load->view('back/dsr/features_list', $this->page_data);
																} elseif ($para1 == 'delete') {
																	$this->db->where('id', $para2);
																	$this->db->delete('dsr_features');
																} elseif ($para1 == 'tp_publish_set') {
																	$article = $para2;
																	if ($para3 == 'true') {
																		$data['status'] = '1';
																	} else {
																		$data['status'] = '0';
																	}
																	$data['updated_at'] = time();
																	$this->db->where('id', $article);
																	$this->db->update('dsr_features', $data);
																	echo $para3;
																} elseif ($para1 == 'add') {
																	$this->page_data['options'] = $this->features->options();
																	$this->load->view('back/dsr/features_add', $this->page_data);
																} elseif ($para1 == 'add_do') {
																	$this->load->library('form_validation');
																	$this->form_validation->set_rules('name', 'Feature Name', 'required|trim');
																	$this->form_validation->set_rules('type', 'Type', 'required|trim');
																	if ($this->form_validation->run() == FALSE) {
																		echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																		exit;
																	} else {

																		$data  = array();
																		$data['name'] 	= $this->input->post('name');
																		$data['type'] 	= $this->input->post('type');
																		$data['detail'] 	= $this->input->post('detail');
																		$data['status'] = 0;
																		$data['created_at'] 	= time();
																		$this->db->insert('dsr_features', $data);
																		$options = $this->input->post('options');
																		$features = $this->dsr_model->retrieve_last('dsr_features', 'id');
																		$feature_id = $features[0]['id'];
																		if (isset($options)) {
																			$i = 0;
																			foreach ($options as $option) {
																				$m2m_data['feature_id'] = $feature_id;
																				$m2m_data['option_id'] = $option;
																				$m2m_ins = $this->db->insert('dsr_m2m_features_options', $m2m_data);
																				$i++;
																			}
																		}
																		echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/dsr_features'));
																		exit;
																	}
																} elseif ($para1 == 'edit') {
																	$this->page_data['features'] = $features =  $this->db->get_where('dsr_features', array('id' => $para2))->result_array();
																	if ($features[0]['type'] == 1 || $features[0]['type'] == 2) {

																		$this->page_data['options'] = $options = $this->features->options();
																		$selected_options = $this->features->options_selected($para2);
																		$i = 0;
																		foreach ($selected_options as $selected) {
																			$this->page_data['opted'][$selected['option_id'] - 1]['id'] = $selected['option_id'];
																			$i++;
																		}
																	}
																	/*?> <pre><?php echo print_r($this->page_data['features']);exit;*/
																	$this->load->view('back/dsr/features_add', $this->page_data);
																} elseif ($para1 == 'update') {
																	$data  = array();
																	$data['name'] 	= $this->input->post('name');
																	$data['type'] 	= $this->input->post('type');
																	$data['detail'] 	= $this->input->post('detail');
																	$data['updated_at'] 	= time();
																	$this->db->where('id', $para2);
																	$upd = $this->db->update('dsr_features', $data);

																	$this->db->where(array('feature_id' => $para2));
																	$del_m2m_fm = $this->db->delete('dsr_m2m_features_options');
																	$options = $this->input->post('options');
																	if (isset($options)) {
																		$i = 0;
																		foreach ($options as $option) {
																			$m2m_data['feature_id'] = $para2;
																			$m2m_data['option_id'] = $option;
																			$m2m_ins = $this->db->insert('dsr_m2m_features_options', $m2m_data);
																			$i++;
																		}
																	}
																	if (!$upd) {
																		echo json_encode(array('response' => FALSE, 'message' => 'Update Failed'));
																		exit;
																	} else {
																		echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/dsr_features'));
																		exit;
																	}
																} else {
																	$this->page_data['page'] = 'DSR Features';
																	$this->load->view('back/dsr_features', $this->page_data);
																}
															}
														}
														public function dsr_feature_options($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															$this->load->model('features');
															if ($para1 == 'list') {
																$this->page_data['options'] = $this->db->get('dsr_options')->result_array();
																$this->load->view('back/dsr/options_list', $this->page_data);
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('dsr_options');
															} elseif ($para1 == 'tp_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$data['updated_at'] = time();
																$this->db->where('id', $article);
																$this->db->update('dsr_options', $data);

																echo $para3;
															} elseif ($para1 == 'add') {
																$this->load->view('back/dsr/options_add', $this->page_data);
															} elseif ($para1 == 'add_do') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('name', 'Option Name', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$data  = array();
																	$data['name'] 	= $this->input->post('name');
																	$data['type'] = $this->input->post('type');
																	$data['value'] = $this->input->post('value');
																	$data['status'] = 0;
																	$data['created_at'] 	= time();
																	$this->db->insert('dsr_options', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/dsr_feature_options'));
																	exit;
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['options'] = $this->db->get_where('dsr_options', array('id' => $para2))->result_array();
																$this->load->view('back/dsr/options_add', $this->page_data);
															} elseif ($para1 == 'update') {

																$data  = array();
																$data['name'] 	= $this->input->post('name');
																$data['type'] = $this->input->post('type');
																$data['value'] = $this->input->post('value');
																$data['updated_at'] 	= time();
																$this->db->where('id', $para2);
																$upd = $this->db->update('dsr_options', $data);
																if (!$upd) {
																	echo json_encode(array('response' => FALSE, 'message' => 'Update Failed'));
																	exit;
																} else {
																	echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/dsr_feature_options'));
																	exit;
																}
															} else {
																$this->page_data['page'] = 'DSR Feature Options';
																$this->load->view('back/dsr_feature_options', $this->page_data);
															}
														}
														public function dsr_generator_log_features($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															} else {
																$this->load->model('features');
																$this->load->model('dsr_model');
																if ($para1 == 'list') {
																	$this->page_data['features'] = $this->db->get('dsr_generator_log_features')->result_array();
																	$this->load->view('back/dsr/generator/log/features/list', $this->page_data);
																} elseif ($para1 == 'delete') {
																	$this->db->where('id', $para2);
																	$this->db->delete('dsr_generator_log_features');
																} elseif ($para1 == 'tp_publish_set') {
																	$article = $para2;
																	if ($para3 == 'true') {
																		$data['status'] = '1';
																	} else {
																		$data['status'] = '0';
																	}
																	$data['updated_at'] = time();
																	$this->db->where('id', $article);
																	$this->db->update('dsr_generator_log_features', $data);

																	echo $para3;
																} elseif ($para1 == 'add') {
																	$this->page_data['options'] = $this->features->options();
																	$this->load->view('back/dsr/generator/log/features/add', $this->page_data);
																} elseif ($para1 == 'add_do') {
																	$this->load->library('form_validation');
																	$this->form_validation->set_rules('name', 'Feature Name', 'required|trim');
																	$this->form_validation->set_rules('type', 'Type', 'required|trim');
																	if ($this->form_validation->run() == FALSE) {
																		echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																		exit;
																	} else {

																		$data  = array();
																		$data['name'] 	= $this->input->post('name');
																		$data['type'] 	= $this->input->post('type');
																		$data['detail'] 	= $this->input->post('detail');
																		$data['status'] = 0;
																		$data['created_at'] 	= time();
																		$this->db->insert('dsr_generator_log_features', $data);
																		$options = $this->input->post('options');
																		$features = $this->dsr_model->retrieve_last('dsr_generator_log_features', 'id');
																		$feature_id = $features[0]['id'];
																		if (isset($options)) {
																			$i = 0;
																			foreach ($options as $option) {
																				$m2m_data['feature_id'] = $feature_id;
																				$m2m_data['option_id'] = $option;
																				$m2m_ins = $this->db->insert('dsr_m2m_generator_log_features_options', $m2m_data);
																				$i++;
																			}
																		}
																		echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/dsr_generator_log_features'));
																		exit;
																	}
																} elseif ($para1 == 'edit') {
																	$this->page_data['features'] = $features =  $this->db->get_where('dsr_generator_log_features', array('id' => $para2))->result_array();
																	if ($features[0]['type'] == 1 || $features[0]['type'] == 2) {

																		$this->page_data['options'] = $options = $this->features->options();
																		$selected_options = $this->features->generator_log_options_selected($para2);
																		$i = 0;
																		foreach ($selected_options as $selected) {
																			$this->page_data['opted'][$selected['option_id'] - 1]['id'] = $selected['option_id'];
																			$i++;
																		}
																	}
																	/*?> <pre><?php echo print_r($this->page_data['features']);exit;*/
																	$this->load->view('back/dsr/generator/log/features/add', $this->page_data);
																} elseif ($para1 == 'update') {
																	$data  = array();
																	$data['name'] 	= $this->input->post('name');
																	$data['type'] 	= $this->input->post('type');
																	$data['detail'] 	= $this->input->post('detail');
																	$data['updated_at'] 	= time();
																	$this->db->where('id', $para2);
																	$upd = $this->db->update('dsr_generator_log_features', $data);

																	$this->db->where(array('feature_id' => $para2));
																	$del_m2m_fm = $this->db->delete('dsr_m2m_generator_log_features_options');
																	$options = $this->input->post('options');
																	if (isset($options)) {
																		$i = 0;
																		foreach ($options as $option) {
																			$m2m_data['feature_id'] = $para2;
																			$m2m_data['option_id'] = $option;
																			$m2m_ins = $this->db->insert('dsr_m2m_generator_log_features_options', $m2m_data);
																			$i++;
																		}
																	}
																	if (!$upd) {
																		echo json_encode(array('response' => FALSE, 'message' => 'Update Failed'));
																		exit;
																	} else {
																		echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/dsr_generator_log_features'));
																		exit;
																	}
																} else {
																	$this->page_data['page'] = 'DSR Generator Log Features';
																	$this->load->view('back/dsr_generator_log_features', $this->page_data);
																}
															}
														}

														///////////////////////////////////////////////////////////////
														////	/** Plaza Staff START  *////////////////////
														///////////////////////////////////////////////////////////////

														public function tpstaff($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['tpstaff'] = $this->db->get('tpstaff')->result_array();
																$this->load->view('back/tpstaff_list', $this->page_data);
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('tpstaff');
															} else {
																$this->page_data['page'] = 'Toll Plaza Staff';
																$this->load->view('back/tpstaff', $this->page_data);
															}
														}
														public function tpstaff_add()
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															$this->page_data['toolplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
															$this->load->view('back/add_tpstaff', $this->page_data);
														}
														public function tpstaff_edit($para1 = '')
														{
															if (!$para1) {
																echo '<div class="alert alert-dismissible alert-danger">
  					<button type="button" class="close" data-dismiss="alert">&times;</button>
  					<strong>OOPS!</strong> Invalid Request
					</div>';
																exit;
															}
															$this->page_data['tpstaff'] = $this->db->get_where('tpstaff', array('id' => $para1))->result_array();
															$this->page_data['toolplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
															$this->load->view('back/edit_tpstaff', $this->page_data);
														}
														public function tpstaff_add_do()
														{ {
																if (!$this->session->userdata('adminid')) {

																	echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																	exit;
																}
																$this->load->library('form_validation');
																$this->form_validation->set_rules('first_name', 'First name', 'required|trim');
																$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
																$this->form_validation->set_rules('toolplaza', 'Tool Plaza', 'required|trim');
																$this->form_validation->set_rules('designation', 'Designation', 'required|trim');
																$this->form_validation->set_rules('contact', 'Contact', 'required|trim');
																if ($this->form_validation->run() == TRUE) {
																	$data = array(
																		'tollplaza' 	=> $this->input->post('toolplaza'),
																		'fname' 		=> $this->input->post('first_name'),
																		'lname' 		=> $this->input->post('last_name'),
																		'designation' 	=> $this->input->post('designation'),
																		'contact' 		=> $this->input->post('contact'),
																	);
																	$this->db->insert('tpstaff', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tpstaff'));
																	exit;
																} else {

																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																}
															}
														}
														public function edit_tpstaff_do($staff_id = '')
														{
															if (!$staff_id) {
																echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
																exit;
															}

															if (!$this->session->userdata('adminid')) {

																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('first_name', 'First name', 'required|trim');
															$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
															$this->form_validation->set_rules('status', 'Status', 'required|trim');

															$this->form_validation->set_rules('designation', 'Designation', 'required|trim');
															$this->form_validation->set_rules('contact', 'Contact', 'required|trim');
															if ($this->form_validation->run() == TRUE) {
																$this->db->where('fname', $this->input->post('first_name'));
																$this->db->where('lname', $this->input->post('last_name'));
																$this->db->where('designation', $this->input->post('designation'));
																$this->db->where('id != ', $staff_id, FALSE);
																$check_id = $this->db->get('tpstaff')->result_array();
																if ($check_id) {
																	echo json_encode(array('respose' => FALSE, 'message' => 'This Staff Member already exists'));
																	exit;
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
																echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tpstaff'));
																exit;
															} else {

																echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}

														///////////////////////////////////////////////////////////////
														////	/** TollPlaza START  *////////////////////
														///////////////////////////////////////////////////////////////

														public function tollplaza($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['toolplza'] = $this->db->get('toolplaza')->result_array();
																$this->load->view('back/toolplaza_list', $this->page_data);
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('toolplaza');
																$this->db->query('DELETE FROM tp_lanes WHERE tollplaza = ' . $para2);
															} elseif ($para1 == 'tp_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('toolplaza', $data);
																echo $para3;
															} elseif ($para1 == 'gm_publish_set') {
																$plaza = $para2;
																if ($para3 == 'true') {
																	$data['google_map_status'] = '1';
																} else {
																	$data['google_map_status'] = '0';
																}
																$this->db->where('id', $plaza);
																$this->db->update('toolplaza', $data);

																echo $para3;
															} else {
																$this->page_data['page'] = 'Tollplaza';
																$this->load->view('back/tooolplaza', $this->page_data);
															}
														}
														public function toolplaza_add()
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
																return redirect('admin/login');
															}
															$bound = $this->Admin_model->toolplaza_bound();
															$no = 0;
															foreach ($bound as $b) {
																$this->page_data['bound'][$no]['id'] = $b['id'];
																$this->page_data['bound'][$no]['name'] = $b['name'];
																$no++;
															}
															$this->load->view('back/add_toolplaza', $this->page_data);
														}
														public function add_plaza_do()
														{
															$this->load->library('form_validation');
															$this->form_validation->set_rules('toolplazaname', ' Tool Plaza Name', 'required|trim');
															$this->form_validation->set_rules('toolplazabound1', ' Tool Plaza Bound 1', 'required|trim');
															$this->form_validation->set_rules('toolplazabound2', ' Tool Plaza Bound 2', 'required|trim');
															$this->form_validation->set_rules('numberoflanes', ' Total Lanes in Bound', 'required|trim');
															if ($this->form_validation->run() == TRUE) {
																$data = array(
																	'name' => $this->input->post('toolplazaname'),
																	'status' => 0
																);
																$ins_tp = $this->db->insert('toolplaza', $data);
																$table = 'toolplaza';
																$order_by = 'id';
																$tp_last = $this->Admin_model->retrieve_last($table, $order_by);
																if (isset($tp_last)) {


																	$bound = $this->Admin_model->toolplaza_bound();
																	$lanes = $this->input->post('numberoflanes');
																	$bound1 = $this->input->post('toolplazabound1');
																	$bound2 = $this->input->post('toolplazabound2');
																	$tool_id = $tp_last[0]['id'];
																	$no = 0;
																	foreach ($bound as $b) {
																		if ($bound1 == $b['id']) {
																			for ($v = 1; $v <= $lanes; $v++) {
																				$tp_lane[$no][$v] = $this->bound_toolplaza($lanes, $v, $tool_id, $b);
																				$this->db->insert('tp_lanes', $tp_lane[$no][$v]);
																			}
																		}
																		if ($bound2 == $b['id']) {
																			for ($v = 1; $v <= $lanes; $v++) {
																				$tp_lane[$no][$v] = $this->bound_toolplaza($lanes, $v, $tool_id, $b);
																				$this->db->insert('tp_lanes', $tp_lane[$no][$v]);
																			}
																		}

																		$no++;
																	}
																}

																echo json_encode(array('response' => true, 'message' => 'Tool Plaza Added Successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'admin/tollplaza'));
																exit;
															} else {

																echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
																exit;
															}
														}
														public function toolplaza_edit($para1 = '')
														{
															if (!$para1) {
																echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
																exit;
															}
															$this->page_data['toolplza'] = $this->db->get_where('toolplaza', array('id' => $para1))->result_array();
															$this->page_data['bound'] = $this->db->query('SELECT * FROM dsr_bound')->result_array();
															$tp_lanes = $this->db->query('SELECT * FROM tp_lanes WHERE tollplaza = ' . $para1)->result_array();
															$no = 0;
															$lane_count = count($tp_lanes);
															$bound_count = count($this->page_data['bound']);
															foreach ($this->page_data['bound'] as $b) {
																$l_no = 0;
																foreach ($tp_lanes as $lane) {
																	if ($lane['bound'] == 'N') {
																		$this->page_data['value'][0] = 1;
																	}
																	if ($lane['bound'] == 'S') {
																		$this->page_data['value'][1] = 2;
																	}
																	$l_no++;
																}
																$no++;
															}
															if (isset($this->page_data['value'])) {
																$bound_count = count($this->page_data['value']);
															}
															$this->page_data['numberoflanes'] = $lane_count / $bound_count;
															/*?> <pre> <?php echo print_r($this->page_data['value']);exit;*/
															$this->load->view('back/edit_toolplaza', $this->page_data);
														}
														public function edit_plaza_do($plaza_id = '')
														{
															if (!$plaza_id) {
																echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('toolplazaname', ' Tool Plaza Name', 'required|trim');
															$this->form_validation->set_rules('toolplazabound1', ' Tool Plaza Bound 1', 'required|trim');
															$this->form_validation->set_rules('toolplazabound2', ' Tool Plaza Bound 2', 'required|trim');
															$this->form_validation->set_rules('numberoflanes', ' Total Lanes in Bound', 'required|trim');
															if ($this->form_validation->run() == TRUE) {
																$data['name'] = $this->input->post('toolplazaname');
																$this->db->where('id', $plaza_id);
																$this->db->update('toolplaza', $data);
																$this->db->query('DELETE FROM tp_lanes WHERE tollplaza = ' . $plaza_id);
																$bound = $this->Admin_model->toolplaza_bound();
																$lanes = $this->input->post('numberoflanes');
																$bound1 = $this->input->post('toolplazabound1');
																$bound2 = $this->input->post('toolplazabound2');
																$tool_id = $plaza_id;
																$no = 0;
																foreach ($bound as $b) {
																	if ($bound1 == $b['id']) {
																		for ($v = 1; $v <= $lanes; $v++) {
																			$tp_lane[$no][$v] = $this->bound_toolplaza($lanes, $v, $tool_id, $b);
																			$this->db->insert('tp_lanes', $tp_lane[$no][$v]);
																		}
																	}
																	if ($bound2 == $b['id']) {
																		for ($v = 1; $v <= $lanes; $v++) {
																			$tp_lane[$no][$v] = $this->bound_toolplaza($lanes, $v, $tool_id, $b);
																			$this->db->insert('tp_lanes', $tp_lane[$no][$v]);
																		}
																	}
																	$no++;
																}
																echo json_encode(array('response' => true, 'message' => 'Tool plaza updated successfully', 'is_redirect' => True, 'redirect_url' => base_url() . 'admin/tollplaza'));
																exit;
															} else {

																echo json_encode(array('response' => TRUE, 'message' => validation_errors()));
																exit;
															}
														}
														//Algorithm
														private function bound_toolplaza($lanes, $v, $tool_id, $b)
														{

															$tp_lane['tollplaza'] = $tool_id;
															$tp_lane['name'] = $b['abr'] . $v;
															$tp_lane['bound'] = $b['abr'];

															return $tp_lane;
														}

														///////////////////////////////////////////////////////////////
														////	/** Supervisor START  *////////////////////
														///////////////////////////////////////////////////////////////

														public function toolplaza_supervisor($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['supervisor'] = $this->db->get('tpsupervisor')->result_array();
																$this->load->view('back/toolplaza_supervisor_list', $this->page_data);
															} elseif ($para1 == 'tps_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('tpsupervisor', $data);

																echo $para3;
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('tpsupervisor');
															} else {
																$this->page_data['page'] = 'Toll Plaza Supervisor';
																$this->load->view('back/tp_supervisor', $this->page_data);
															}
														}
														public function toolplaza_supervisor_add()
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															$this->page_data['toolplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
															$this->load->model('Inventory_model');
															$this->page_data['sites'] = $this->Inventory_model->getsites();
															$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
															$this->load->view('back/add_tpsupervisor', $this->page_data);
														}
														public function add_tpsupervisor_do()
														{
															if (!$this->session->userdata('adminid')) {

																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('first_name', 'First name', 'required|trim');
															$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
															$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[tpsupervisor.username]');
															$this->form_validation->set_rules('Password', 'Password', 'required|trim');
															$this->form_validation->set_rules('role', 'Role', 'required|trim');
															$this->form_validation->set_rules('toolplaza', 'Tool Plaza', 'required|trim');
															$this->form_validation->set_rules('tsp_id', 'TSP Name', 'required|trim');
															$this->form_validation->set_rules('site_id', 'Site Name', 'required|trim');
															$this->form_validation->set_rules('contact', 'Contact', 'required|trim');
															if ($this->form_validation->run() == TRUE) {
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
																echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/toolplaza_supervisor'));
																exit;
															} else {

																echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}
														public function toolplaza_supervisor_edit($para1 = '')
														{
															if (!$para1) {
																echo '<div class="alert alert-dismissible alert-danger">
  					<button type="button" class="close" data-dismiss="alert">&times;</button>
  					<strong>OOPS!</strong> Invalid Request
					</div>';
																exit;
															}
															$this->page_data['supervisor'] = $this->db->get_where('tpsupervisor', array('id' => $para1))->result_array();
															$this->page_data['toolplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
															$this->load->model('Inventory_model');
															$this->page_data['sites'] = $this->Inventory_model->getsites();
															$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
															$this->load->view('back/edit_tpsupervisor', $this->page_data);
														}
														public function edit_tpsupervisor_do($supervisor_id = '')
														{
															if (!$supervisor_id) {
																echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
																exit;
															}

															if (!$this->session->userdata('adminid')) {

																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('first_name', 'First name', 'required|trim');
															$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
															$this->form_validation->set_rules('username', 'User Name', 'required|trim');
															$this->form_validation->set_rules('toolplaza', 'Tool Plaza', 'required|trim');
															$this->form_validation->set_rules('role', 'Role', 'required|trim');
															$this->form_validation->set_rules('contact', 'Contact', 'required|trim');
															$this->form_validation->set_rules('tsp_id', 'TSP Name', 'required|trim');
															$this->form_validation->set_rules('site_id', 'Site Name', 'required|trim');
															if ($this->form_validation->run() == TRUE) {
																$this->db->where('username', $this->input->post('username'));
																$this->db->where('id != ', $supervisor_id, FALSE);
																$check_email = $this->db->get('tpsupervisor')->result_array();
																if ($check_email) {
																	echo json_encode(array('respose' => FALSE, 'message' => 'This Username address already exists'));
																	exit;
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
																echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/toolplaza_supervisor'));
																exit;
															} else {

																echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}
														public function toolplaza_supervisor_password($para1 = '')
														{
															if (!$para1) {
																echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
																exit;
															}
															$this->page_data['supervisor_id'] = $this->db->get_where('tpsupervisor', array('id' => $para1))->row()->id;
															$this->load->view('back/supervisor_password', $this->page_data);
														}
														public function update_tpsupervisor_password($supervisor_id = '')
														{
															if (!$this->session->userdata('adminid')) {

																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															if (!$supervisor_id) {
																echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('password', 'Password', 'required|trim');
															$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
															if ($this->form_validation->run() == TRUE) {

																$data = array(
																	'password' 	=> sha1($this->input->post('password'))
																);
																$this->db->where('id', $supervisor_id);
																$this->db->update('tpsupervisor', $data);
																echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/toolplaza_supervisor'));
																exit;
															} else {

																echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}

														///////////////////////////////////////////////////////////////
														////	/** Member START  *////////////////////
														///////////////////////////////////////////////////////////////

														public function member($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['supervisor'] = $this->db->get('member')->result_array();
																$this->load->view('back/member_list', $this->page_data);
															} elseif ($para1 == 'tps_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('member', $data);

																echo $para3;
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('member');
															} else {
																$this->page_data['page'] = 'Member';
																$this->load->view('back/member', $this->page_data);
															}
														}
														public function member_add()
														{
															$this->load->model('Inventory_model');
															$this->page_data['sites'] = $this->Inventory_model->getsites();
															$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
															$this->load->view('back/add_member', $this->page_data);
														}
														public function add_member_do()
														{

															if (!$this->session->userdata('adminid')) {

																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('first_name', 'First name', 'required|trim');
															$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
															$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[member.username]');
															$this->form_validation->set_rules('Password', 'Password', 'required|trim');
															$this->form_validation->set_rules('contact', 'Contact', 'required|trim');
															$this->form_validation->set_rules('tsp_id', 'TSP Name', 'required|trim');
															$this->form_validation->set_rules('site_id', 'Site Name', 'required|trim');
															if ($this->form_validation->run() == TRUE) {
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
																echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/member'));
																exit;
															} else {

																echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}
														public function member_edit($para1 = '')
														{
															if (!$para1) {
																echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
																exit;
															}
															$this->page_data['member'] = $this->db->get_where('member', array('id' => $para1))->result_array();
															$this->load->model('Inventory_model');
															$this->page_data['sites'] = $this->Inventory_model->getsites();
															$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
															$this->load->view('back/edit_member', $this->page_data);
														}
														public function edit_member_do($member_id = '')
														{
															if (!$this->session->userdata('adminid')) {

																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															if (!$member_id) {
																echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('first_name', 'First name', 'required|trim');
															$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
															$this->form_validation->set_rules('username', 'User Name', 'required|trim');
															$this->form_validation->set_rules('contact', 'Contact', 'required|trim');
															$this->form_validation->set_rules('tsp_id', 'TSP Name', 'required|trim');
															$this->form_validation->set_rules('site_id', 'Site Name', 'required|trim');
															if ($this->form_validation->run() == TRUE) {
																$this->db->where('username', $this->input->post('username'));
																$this->db->where('id != ', $member_id, FALSE);
																$check_email = $this->db->get('member')->result_array();
																if ($check_email) {
																	echo json_encode(array('respose' => FALSE, 'message' => 'This Username address already exists'));
																	exit;
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
																echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/member'));
																exit;
															} else {

																echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}
														public function member_password($para1 = '')
														{
															if (!$para1) {
																echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
																exit;
															}
															$this->page_data['member_id'] = $this->db->get_where('member', array('id' => $para1))->row()->id;
															$this->load->view('back/member_password', $this->page_data);
														}
														public function update_member_password($member_id = '')
														{
															if (!$this->session->userdata('adminid')) {

																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															if (!$member_id) {
																echo json_encode(array('response' => False, 'message' => 'Invalid Request'));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('password', 'Password', 'required|trim');
															$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
															if ($this->form_validation->run() == TRUE) {

																$data = array(

																	'password' 	=> sha1($this->input->post('password'))


																);
																$this->db->where('id', $member_id);
																$this->db->update('member', $data);
																echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/member'));
																exit;
															} else {

																echo json_encode(array('respnose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}

														/////////////////////////////////////////////////////
														/** sub admins START */
														////////////////////////////////////////////////////
														public function admins($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['admin'] = $this->db->get('admin')->result_array();
																$this->load->view('back/admin_list', $this->page_data);
															} elseif ($para1 == 'tps_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('admin', $data);

																echo $para3;
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('admin');
															} else {
																$this->page_data['page'] = 'admin';
																$this->load->view('back/admin', $this->page_data);
															}
														}
														public function admin_add()
														{
															$this->load->model('Inventory_model');
															$this->page_data['sites'] = $this->Inventory_model->getsites();
															$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
															$this->load->view('back/add_admin', $this->page_data);
														}
														public function add_admin_do()
														{

															if (!$this->session->userdata('adminid')) {

																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('first_name', 'First name', 'required|trim');
															$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
															$this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[member.username]');
															$this->form_validation->set_rules('Password', 'Password', 'required|trim');
															$this->form_validation->set_rules('contact', 'Contact', 'required|trim');
															$this->form_validation->set_rules('tsp_id', 'TSP Name', 'required|trim');
															$this->form_validation->set_rules('site_id', 'Site Name', 'required|trim');
															if ($this->form_validation->run() == TRUE) {
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
																echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/admins'));
																exit;
															} else {

																echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}
														function admin_edit($para1 = '')
														{
															if (!$para1) {
																echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
																exit;
															}
															$this->load->model('Inventory_model');
															$this->page_data['admin'] = $this->db->get_where('admin', array('id' => $para1))->result_array();
															$this->page_data['sites'] = $this->Inventory_model->getsites();
															$this->page_data['tsps'] = $this->Inventory_model->get_tsps();
															$this->load->view('back/edit_admin', $this->page_data);
														}
														function edit_admin_do($admin_id = '')
														{
															//echo $admin_id; exit;
															//if(!$this->session->userdata('adminid')){

															//	echo json_encode(array('respose' => FALSE , 'message' => "Please Login to continue"));exit;

															//}
															if (!$admin_id) {
																echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('first_name', 'First name', 'required|trim');
															$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
															$this->form_validation->set_rules('username', 'User Name', 'required|trim');
															$this->form_validation->set_rules('contact', 'Contact', 'required|trim');
															$this->form_validation->set_rules('role', 'Role', 'required|trim');
															$this->form_validation->set_rules('tsp_id', 'TSP Name', 'required|trim');
															$this->form_validation->set_rules('site_id', 'Site Name', 'required|trim');
															if ($this->form_validation->run() == TRUE) {
																$this->db->where('username', $this->input->post('username'));
																$this->db->where('id != ', $admin_id, FALSE);
																$check_email = $this->db->get('admin')->result_array();
																if ($check_email) {
																	echo json_encode(array('respose' => FALSE, 'message' => 'This Username address already exists'));
																	exit;
																}
																$data = array(

																	'fname' => $this->input->post('first_name'),
																	'lname' => $this->input->post('last_name'),
																	'username' => $this->input->post('username'),
																	'contact' => $this->input->post('contact'),
																	'adddate' => time(),
																	'status' => 0,
																	'role' => $this->input->post('role'),
																	'tsp' => $this->input->post('tsp_id'),
																	'site' => $this->input->post('site_id')
																);
																$this->db->where('id', $admin_id);
																$this->db->update('admin', $data);
																echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/admins'));
																exit;
															} else {

																echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}
														public function admins_password($para1 = '')
														{
															if (!$para1) {
																echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
																exit;
															}
															$this->page_data['admin_id'] = $this->db->get_where('admin', array('id' => $para1))->row()->id;
															$this->load->view('back/admin_password', $this->page_data);
														}
														public function update_admins_password($admin_id = '')
														{
															if (!$this->session->userdata('adminid')) {

																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															if (!$admin_id) {
																echo json_encode(array('response' => False, 'message' => 'Invalid Request'));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('password', 'Password', 'required|trim');
															$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
															if ($this->form_validation->run() == TRUE) {

																$data = array(

																	'password' 	=> sha1($this->input->post('password'))


																);
																$this->db->where('id', $admin_id);
																$this->db->update('admin', $data);
																echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/admins'));
																exit;
															} else {

																echo json_encode(array('respnose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}

														/** sub admins END */

														///////////////////////////////////////////////////////////////
														////	/** Tarrif START  *////////////////////
														///////////////////////////////////////////////////////////////

														public function tarrif($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {

																$this->page_data['terrif']  = $this->db->get('terrif')->result_array();

																$this->load->view('back/terrif_list', $this->page_data);
															} elseif ($para1 == 'view') {
																$this->page_data['terrif']  = $this->db->get_where('terrif', array('id' => $para2))->result_array();

																$this->load->view('back/view_terrif', $this->page_data);
															} elseif ($para1 == 'add') {
																$this->page_data['plaza']  = $this->db->get('toolplaza')->result_array();
																$this->load->view('back/tarrif_add', $this->page_data);
															} elseif ($para1 == 'edit') {
																$this->page_data['plaza']  = $this->db->get('toolplaza')->result_array();
																$this->page_data['terrif']  = $this->db->get_where('terrif', array('id' => $para2))->result_array();

																$this->load->view('back/edit_terrif', $this->page_data);
															} elseif ($para1 == 'add_tarrif') {

																$plaza = $this->input->post('plaza');
																if (empty($plaza)) {
																	echo json_encode(array('respose' => FALSE, 'message' => 'Please choose plaza'));
																	exit;
																}
																$this->load->library('form_validation');
																$this->form_validation->set_rules('class_1_desc', 'Class1 Description', 'required|trim');
																$this->form_validation->set_rules('class_1_rate', 'Class1 Rate', 'required|trim');
																$this->form_validation->set_rules('class_2_desc', 'Class2 Description', 'required|trim');
																$this->form_validation->set_rules('class_2_rate', 'Class2 Rate', 'required|trim');
																$this->form_validation->set_rules('class_3_desc', 'Class3 Description', 'required|trim');
																$this->form_validation->set_rules('class_3_rate', 'Class3 Rate', 'required|trim');
																$this->form_validation->set_rules('class_4_desc', 'Class4 Description', 'required|trim');
																$this->form_validation->set_rules('class_4_rate', 'Class4 Rate', 'required|trim');
																$this->form_validation->set_rules('class_5_desc', 'Class5 Description', 'required|trim');
																$this->form_validation->set_rules('class_5_rate', 'Class5 Rate', 'required|trim');
																$this->form_validation->set_rules('class_6_desc', 'Class6 Description', 'required|trim');
																$this->form_validation->set_rules('class_6_rate', 'Class6 Rate', 'required|trim');
																$this->form_validation->set_rules('class_7_desc', 'Class7 Description', 'required|trim');
																$this->form_validation->set_rules('class_7_rate', 'Class7 Rate', 'required|trim');
																$this->form_validation->set_rules('class_8_desc', 'Class8 Description', 'required|trim');
																$this->form_validation->set_rules('class_8_rate', 'Class8 Rate', 'required|trim');
																$this->form_validation->set_rules('class_9_desc', 'Class9 Description', 'required|trim');
																$this->form_validation->set_rules('class_9_rate', 'Class9 Rate', 'required|trim');
																$this->form_validation->set_rules('class_10_desc', 'Class10 Description', 'required|trim');
																$this->form_validation->set_rules('class_10_rate', 'Class10 Rate', 'required|trim');
																$this->form_validation->set_rules('start_date', 'Effective From', 'required|trim');
																$this->form_validation->set_rules('end_date', 'Effective To', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respnose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$plazas = implode(",", $plaza);
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
																	$this->db->insert('terrif', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tarrif'));
																	exit;
																}
															} elseif ($para1 == 'update_terrif') {

																$plaza = $this->input->post('plaza');
																if (empty($plaza)) {
																	echo json_encode(array('respose' => FALSE, 'message' => 'Please choose plaza'));
																	exit;
																}
																$this->load->library('form_validation');
																$this->form_validation->set_rules('class_1_desc', 'Class1 Description', 'required|trim');
																$this->form_validation->set_rules('class_1_rate', 'Class1 Rate', 'required|trim');
																$this->form_validation->set_rules('class_2_desc', 'Class2 Description', 'required|trim');
																$this->form_validation->set_rules('class_2_rate', 'Class2 Rate', 'required|trim');
																$this->form_validation->set_rules('class_3_desc', 'Class3 Description', 'required|trim');
																$this->form_validation->set_rules('class_3_rate', 'Class3 Rate', 'required|trim');
																$this->form_validation->set_rules('class_4_desc', 'Class4 Description', 'required|trim');
																$this->form_validation->set_rules('class_4_rate', 'Class4 Rate', 'required|trim');
																$this->form_validation->set_rules('class_5_desc', 'Class5 Description', 'required|trim');
																$this->form_validation->set_rules('class_5_rate', 'Class5 Rate', 'required|trim');
																$this->form_validation->set_rules('class_6_desc', 'Class6 Description', 'required|trim');
																$this->form_validation->set_rules('class_6_rate', 'Class6 Rate', 'required|trim');
																$this->form_validation->set_rules('class_7_desc', 'Class7 Description', 'required|trim');
																$this->form_validation->set_rules('class_7_rate', 'Class7 Rate', 'required|trim');
																$this->form_validation->set_rules('class_8_desc', 'Class8 Description', 'required|trim');
																$this->form_validation->set_rules('class_8_rate', 'Class8 Rate', 'required|trim');
																$this->form_validation->set_rules('class_9_desc', 'Class9 Description', 'required|trim');
																$this->form_validation->set_rules('class_9_rate', 'Class9 Rate', 'required|trim');
																$this->form_validation->set_rules('class_10_desc', 'Class10 Description', 'required|trim');
																$this->form_validation->set_rules('class_10_rate', 'Class10 Rate', 'required|trim');
																$this->form_validation->set_rules('start_date', 'Effective From', 'required|trim');
																$this->form_validation->set_rules('end_date', 'Effective To', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respnose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$plazas = implode(",", $plaza);
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
																	echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tarrif'));
																	exit;
																}
															} else {
																$this->page_data['page_assets']['css'] 	= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/back/chosen/chosen.min.css"/>';
																$this->page_data['page_assets']['js'] 	= '<script src="' . base_url() . 'assets/back/chosen/chosen.jquery.min.js"></script>';
																$this->page_data['page'] = 'Tarrif';
																$this->load->view('back/terrif', $this->page_data);
															}
														}

														///////////////////////////////////////////////////////////////
														////	/** MTR START  *////////////////////
														///////////////////////////////////////////////////////////////
														public function mtr($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->db->order_by('id', 'DESC');
																$this->page_data['mtr']  = $this->db->get('mtr')->result_array();
																$this->load->view('back/mtr_list', $this->page_data);
															} elseif ($para1 == 'by_tollplaza') {
																if ($para2 != '') {
																	$this->db->where('toolplaza', $para2);
																}
																$this->db->order_by('id', 'DESC');
																$this->page_data['mtr']  = $this->db->get('mtr')->result_array();
																$this->load->view('back/mtr_list', $this->page_data);
															} elseif ($para1 == 'approve') {
																$data['status'] = 1;
																// $this->db->where('alert_type',2);
																// $this->db->where('ref_id',$para2);
																// $this->db->delete('alerts');
																$this->db->where('id', $para2);
																$this->db->update('mtr', $data);
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$record = $this->db->get('mtr');
																if ($record->result_array()) {
																	$support = $this->db->get_where('supporting_document', array('mtr_id' => $para2))->result_array();
																	if ($support) {
																		foreach ($support as $val) {
																			unlink('./uploads/supporting/' . $val['path']);
																		}
																		$this->db->where('mtr_id', $para2);
																		$this->db->delete('supporting_document');
																	}
																	$file = $this->db->get_where('mtr', array('id' => $para2))->row()->file;
																	unlink('./uploads/mtr/' . $file);
																	$this->db->where('id', $para2);
																	$this->db->delete('mtr');
																}
															} elseif ($para1 == 'disapprove') {
																$this->page_data['mtr_id'] = $para2;
																$this->load->view('back/mtr_disapprove', $this->page_data);
															} elseif ($para1 == 'view_reason') {
																$reason = $this->db->get_where('mtr', array('id' => $para2))->result_array();
																if ($reason[0]['status'] == 2) {
																	echo "<span class='text-info'>" . $reason[0]['reason'] . "</span>";
																} else {
																	echo "<span class='text-danger'>Invalid Request</span>";
																}
															} elseif ($para1 == 'disapprove_do') {
																$check = $this->db->get_where('mtr', array('id' => $para2))->result_array();
																if ($check) {
																	// echo "<pre>"; print_r($check); exit;
																	if ($check[0]['status'] == 0 || $check[0]['status'] == 1) {
																		if (empty($this->input->post('dissapprove_reason'))) {
																			echo json_encode(array('respose' => FALSE, 'message' => 'Please add reason for dissapproving this monthly traffic report'));
																			exit;
																		} else {
																			$data['status'] = 2;
																			$data['reason'] = $this->input->post('dissapprove_reason');
																			$this->db->where('id', $para2);
																			$this->db->update('mtr', $data);
																			/**Notifications Start */


																			$notificatoin_msg = 'Your  ' . date("F, Y", strtotime($check[0]['for_month'])) . ' mtr disapproved.';
																			$mtrMonth = explode('-', $check[0]['for_month']);
																			$mtr_month = $mtrMonth[0] . '-' . $mtrMonth[1] . '-' . $mtrMonth[2];

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

																			echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/mtr'));
																			exit;
																		}
																	} else {
																		echo json_encode(array('respose' => FALSE, 'message' => 'Invalid Requestee'));
																		exit;
																	}
																} else {
																	echo json_encode(array('respose' => FALSE, 'message' => 'Invalid Request'));
																	exit;
																}
															}
															/**Notifications END */
															else {
																$this->page_data['page'] = 'MTR';
																$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
																$this->load->view('back/mtr', $this->page_data);
															}
														}
														public function monthly_traffic_report($para1 = '')
														{
															$this->page_data['mtr'] = $this->db->get_where('mtr', array('id' => $para1))->result_array();

															$month_year = explode('-', $this->page_data['mtr'][0]['for_month']);
															$start_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['start_date'];
															$end_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['end_date'];

															$sql = "Select * From terrif Where FIND_IN_SET (" . $this->page_data['mtr'][0]['toolplaza'] . " ,toolplaza) AND (start_date <= '" . $start_date . "' AND end_date >= '" . $end_date . "')";
															$this->page_data['terrif'] =  $this->db->query($sql)->result_array();

															//echo $this->db->last_quer`y();
															//echo "<pre>";
															//print_r($this->page_data['terrif']); exit;
															$this->load->view('back/invoice', $this->page_data);
														}
														public function generate_pdf($para1 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															$this->page_data['mtr'] = $this->db->get_where('mtr', array('id' => $para1))->result_array();
															$month_year = explode('-', $this->page_data['mtr'][0]['for_month']);
															$start_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['start_date'];
															$end_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['end_date'];

															//$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza)";
															$sql = "Select * From terrif Where FIND_IN_SET (" . $this->page_data['mtr'][0]['toolplaza'] . " ,toolplaza) AND (start_date <= '" . $start_date . "' AND end_date >= '" . $end_date . "')";
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

															$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
															$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
															$pdf->Output('mtr.pdf', 'I');
															//$pdf->Output(SERVER_RELATIVE_PATH . '/uploads/invoices/invoice' . $invoice_name . '.pdf', 'F');

														}
														public function specific_mtr($para1 = '', $para2 = '')
														{
															if ($para1 == 'list') {
																$this->page_data['mtr'] = $this->db->get_where('mtr', array('id' => $para2))->result_array();
																// $this->db->where('alert_type',2);
																// $this->db->where('ref_id',$para2);
																// $this->db->update('notifications',array('is_read' => 1))->result_array();	
																$this->load->view('back/mtr_list', $this->page_data);
															} else {

																$this->page_data['page'] = 'specific_mtr';
																$this->page_data['mtr_id'] = $para1;
																$this->load->view('back/specific_mtr', $this->page_data);
															}
														}
														public function view_supporting($para1 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															$this->page_data['support'] = $this->db->get_where('supporting_document', array('mtr_id' => $para1))->result_array();
															$this->load->view('back/suppporting_list', $this->page_data);
														}

														///////////////////////////////////////////////////////////////
														////	/** DTR START  *////////////////////
														///////////////////////////////////////////////////////////////

														public function dtr($para1 = '', $para2 = '', $para3 = '')
														{
															//date_default_timezone_set("Asia/Karachi");
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}

															date_default_timezone_set("Asia/Karachi");
															if ($para1 == 'list') {
																$this->db->order_by('id', 'DESC');
																$this->page_data['dtr']  = $this->db->get('dtr')->result_array();
																/*?> <pre> <?php echo print_r(date('F j, Y, g:i a',$this->page_data['dtr'][0]['adddate'])); exit; ?> </pre> <?php */
																/*?> <pre><?php echo print_r($this->page_data); exit; */
																$this->load->view('back/dtr_list', $this->page_data);
															} elseif ($para1 == 'by_tollplaza') {
																if ($para2 != '') {
																	$this->db->where('toolplaza', $para2);
																}
																$this->db->order_by('id', 'DESC');
																$this->page_data['dtr']  = $this->db->get('dtr')->result_array();
																$this->load->view('back/dtr_list', $this->page_data);
															} elseif ($para1 == 'approve') {

																$data['status'] = 1;
																$data['actiondate'] = time();
																$this->db->limit(1);
																// $this->db->where('alert_type',2);
																// $this->db->where('ref_id',$para2);
																// $this->db->delete('alerts');
																$this->db->where('id', $para2);
																$this->db->update('dtr', $data);
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$record = $this->db->get('dtr');
																if ($record->result_array()) {
																	$support = $this->db->get_where('dtr_supporting_document', array('dtr_id' => $para2))->result_array();
																	if ($support) {
																		foreach ($support as $val) {
																			unlink('./uploads/supporting/' . $val['path']);
																		}
																		$this->db->where('dtr_id', $para2);
																		$this->db->delete('dtr_supporting_document');
																	}
																	$file = $this->db->get_where('dtr', array('id' => $para2))->row()->file;
																	unlink('./uploads/dtr/' . $file);
																	$this->db->where('id', $para2);
																	$this->db->delete('dtr');
																}
															} elseif ($para1 == 'disapprove') {
																$this->page_data['dtr_id'] = $para2;
																$this->load->view('back/dtr_disapprove', $this->page_data);
															} elseif ($para1 == 'approved') {
																$this->page_data['dtr_id'] = $para2;
																$this->load->view('back/dtr_disapprove', $this->page_data);
															} elseif ($para1 == 'view_reason') {
																$reason = $this->db->get_where('dtr', array('id' => $para2))->result_array();
																if ($reason[0]['status'] == 2) {
																	echo "<span class='text-info'>" . $reason[0]['reason'] . "</span>";
																} else {
																	echo "<span class='text-danger'>Invalid Request</span>";
																}
															} elseif ($para1 == 'disapprove_do') {
																$check = $this->db->get_where('dtr', array('id' => $para2))->result_array();
																if ($check) {
																	// echo "<pre>"; print_r($check); exit;
																	if ($check[0]['status'] == 0 || $check[0]['status'] == 1) {
																		if (empty($this->input->post('dissapprove_reason'))) {
																			echo json_encode(array('response' => FALSE, 'message' => 'Please add reason for dissapproving this daily traffic report'));
																			exit;
																		} else {
																			$data['status'] = 2;
																			$data['actiondate'] = time();
																			$data['reason'] = $this->input->post('dissapprove_reason');
																			$this->db->limit(1);
																			$this->db->where('id', $para2);
																			$this->db->update('dtr', $data);
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
																	} else {
																		echo json_encode(array('response' => TRUE, 'message' => 'Disapproved Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/dtr'));
																		exit;
																	}
																} else {
																	echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																	exit;
																}
																/**Notifications END */
															} else {
																$this->page_data['page'] = 'dtr';
																$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
																$this->load->view('back/dtr', $this->page_data);
															}
														}
														public function daily_traffic_report($para1 = '')
														{
															$this->page_data['dtr'] = $this->db->get_where('dtr', array('id' => $para1))->result_array();
															$date = date('Y-m-d', strtotime($this->page_data['dtr'][0]['for_date']));
															$sql = "Select * From terrif Where FIND_IN_SET (" . $this->page_data['dtr'][0]['toolplaza'] . " ,toolplaza)  AND (start_date <= '" . $date . "' AND end_date >= '" . $date . "')";
															$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
															$this->load->view('back/dtr_invoice', $this->page_data);
														}
														public function dtr_generate_pdf($para1 = '')
														{
															$this->page_data['dtr'] = $this->db->get_where('dtr', array('id' => $para1))->result_array();
															/*$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];*/

															//$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza)";
															$sql = "Select * From terrif Where FIND_IN_SET (" . $this->page_data['dtr'][0]['toolplaza'] . " ,toolplaza)  AND (start_date <= '" . $this->page_data['dtr'][0]['for_date'] . "' AND end_date >= '" . $this->page_data['dtr'][0]['for_date'] . "')";
															$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
															$pdfdata = $this->load->view('front/toolplaza/dtr_invoice_pdf', $this->page_data, TRUE);

															$this->load->library("Pdf");
															$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
															$pdf->SetCreator(PDF_CREATOR);
															$pdf->SetAuthor('NHA DTR');
															$pdf->SetTitle('NHA Daily Traffic Report');
															$pdf->SetSubject('DTR');
															$pdf->SetKeywords('DTR, PDF');

															$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
															$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
															$pdf->Output('dtr.pdf', 'I');
															//$pdf->Output(SERVER_RELATIVE_PATH . '/uploads/invoices/invoice' . $invoice_name . '.pdf', 'F');

														}
														public function specific_dtr($para1 = '', $para2 = '')
														{
															if ($para1 == 'list') {
																$this->page_data['dtr'] = $this->db->get_where('dtr', array('id' => $para2))->result_array();
																// $this->db->where('alert_type',2);
																// $this->db->where('ref_id',$para2);
																// $this->db->update('notifications',array('is_read' => 1))->result_array();	
																$this->load->view('back/dtr_list', $this->page_data);
															} else {

																$this->page_data['page'] = 'specific_dtr';
																$this->page_data['dtr_id'] = $para1;
																$this->load->view('back/specific_dtr', $this->page_data);
															}
														}
														public function view_dtrsupporting($para1 = '')
														{
															$this->page_data['support'] = $this->db->get_where('dtr_supporting_document', array('dtr_id' => $para1))->result_array();
															$this->load->view('back/suppporting_list', $this->page_data);
														}

														/////////////////////////////////////////////////////////////////////////////////////////////////////
														/////////////////////////////////////////////// Location ///////////////////////////////////////////
														///////////////////////////////////////////////////////////////////

														public function location($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['location'] = $this->db->get('location')->result_array();
																$this->load->view('back/location_list', $this->page_data);
															} elseif ($para1 == 'add') {
																$this->load->view('back/location_add', $this->page_data);
															} elseif ($para1 == 'edit') {
																$this->page_data['location'] = $this->db->get_where('location', array('id' => $para2))->result_array();
																if (!$this->page_data['location']) {
																	echo "<span class='text-danger'>Invalid Request</span>";
																	exit;
																}
																$this->load->view('back/location_edit', $this->page_data);
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('location');
															} elseif ($para1 == 'update') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('location', 'Tool Plaza Location', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {

																	$data['name'] = $this->input->post('location');
																	$this->db->where('id', $para2);
																	$this->db->update('location', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/location'));
																	exit;
																}
															} elseif ($para1 == 'add_do') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('location', 'Tool Plaza Location', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {

																	$data['name'] = $this->input->post('location');
																	$this->db->insert('location', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/location'));
																	exit;
																}
															} else {
																$this->page_data['page'] = 'Locations';
																$this->load->view('back/location', $this->page_data);
															}
														}

														///////////////////////////////////////////////////////////////
														////	/** OMC START  *////////////////////
														///////////////////////////////////////////////////////////////

														public function omc($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['omc'] = $this->db->get('omc')->result_array();
																$this->load->view('back/omc_list', $this->page_data);
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('omc');
															} elseif ($para1 == 'tp_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('omc', $data);

																echo $para3;
															} elseif ($para1 == 'add') {
																$this->page_data['toolplaza'] = $this->Admin_model->getSites();
																$this->load->view('back/add_omc', $this->page_data);
															} elseif ($para1 == 'add_do') {
																// echo "<pre>"; print_r($_POST); exit;
																$this->load->library('form_validation');
																$this->form_validation->set_rules('omcname', 'OMC Name', 'required|trim');
																$this->form_validation->set_rules('username', 'OMC User Name', 'required|trim');
																$this->form_validation->set_rules('Password', 'OMC Password', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$data  = array();
																	$data['name'] 	= $this->input->post('omcname');
																	$data['username'] 	= $this->input->post('username');
																	$data['site'] 	= $this->input->post('omcname');
																	$data['password'] 	= $this->input->post('Password');
																	$data['status'] = 0;
																	$data['date'] 	= time();
																	$this->db->insert('omc', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/omc'));
																	exit;
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['omc'] = $this->db->get_where('omc', array('id' => $para2))->result_array();
																$this->load->view('back/edit_omc', $this->page_data);
															} elseif ($para1 == 'update') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('omcname', 'OMC Name', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {

																	$data  = array();
																	$data['name'] 	= $this->input->post('omcname');
																	$data['date'] 	= time();
																	$this->db->where('id', $para2);
																	$this->db->update('omc', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/omc'));
																	exit;
																}
															} else {
																$this->page_data['page'] = 'OMC';
																$this->load->view('back/omc', $this->page_data);
															}
														}

														public function omc_password($para1 = '')
														{
															if (!$para1) {
																echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
																exit;
															}

															$this->page_data['omc_id'] = $this->db->get_where('omc', array('id' => $para1))->row()->id;
															$this->load->view('back/omc_password', $this->page_data);
														}
														public function update_omc_password($omc_id = '')
														{
															if (!$this->session->userdata('adminid')) {

																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															if (!$omc_id) {
																echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('password', 'Password', 'required|trim');
															$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
															if ($this->form_validation->run() == TRUE) {

																$data = array(
																	'password' 	=> sha1($this->input->post('password'))
																);
																$this->db->where('id', $omc_id);
																$this->db->update('omc', $data);
																echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/omc'));
																exit;
															} else {

																echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}

														///////////////////////////////////////////////////////////////
														////	/** weightstation START  *////////////////////
														///////////////////////////////////////////////////////////////
														public function weighstation($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {

																$sql = "Select weighstation.*,routes.name as routename From weighstation
			LEFT OUTER JOIN routes on weighstation.route = routes.id 
			ORDER BY FIELD(`status`, 1, 0)";
																$this->page_data['weigh'] = $this->db->query($sql)->result_array();
																$this->load->view('back/weighstation_list', $this->page_data);
															} elseif ($para1 == 'custom_search') {
																$post_data = $this->input->post();
																if ($post_data['srch_crt'] == 1) {
																	$sql = "Select weighstation.*,routes.name as routename From weighstation
						LEFT OUTER JOIN routes on weighstation.route = routes.id 
						WHERE loc = " . $post_data['search_value'] . "
						ORDER BY FIELD(`status`, 1, 0)";
																} elseif ($post_data['srch_crt'] == 2) {
																	$sql = "Select weighstation.*,routes.name as routename From weighstation
						LEFT OUTER JOIN routes on weighstation.route = routes.id 
						WHERE route = " . $post_data['search_value'] . "
						ORDER BY FIELD(`status`, 1, 0)";
																}
																$this->page_data['weigh'] = $this->db->query($sql)->result_array();
																$this->load->view('back/weighstationcustom_list', $this->page_data);
															} elseif ($para1 == 'search_type') {
																$type = $para2;
																$div = '';
																switch ($type) {
																	case 1:
																		$div = '<select class="form-control required" name="search_value" id="search_value">
        					<option value="">Select Location</option>
      	  					<option value="1">Motorway</option>
          					<option value="2">National Highway</option>
          					
      					</select>';
																		break;
																	case 2:
																		$routes = $this->db->get('routes')->result_array();
																		$div = '<select class="form-control required" name="search_value" id="search_value">
					<option value="">Select Route</option>';
																		foreach ($routes as $r) {
																			$div .= '<option value="' . $r['id'] . '">' . $r['name'] . '</option>';
																		}
																		$div .= '</select>';
																		break;
																}
																echo $div;
															} elseif ($para1 == 'add') {
																$this->page_data['routes'] = $this->db->get('routes')->result_array();
																$this->load->view('back/weighstation_add', $this->page_data);
															} elseif ($para1 == 'do_add') {

																$this->load->library('form_validation');
																$this->form_validation->set_rules('name', 'Weigh station name', 'required|trim');
																$this->form_validation->set_rules('loc', 'Weigh station location', 'required|trim');
																$this->form_validation->set_rules('route', 'Weigh station route', 'required|trim');

																if ($this->input->post('type') == 1) {
																	$this->form_validation->set_rules('ip_address', 'IP address', 'required|trim|valid_ip');
																} elseif ($this->input->post('type') == 2) {
																	$this->form_validation->set_rules('ftp_address', 'FTP address', 'required|trim|valid_ip');
																}
																// if($this->input->post('sofware_type') == 2){
																// 	$this->form_validation->set_rules('file_index','Index file Required','required|trim|numeric');

																// }
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$insert = $this->Admin_model->add_weighstation($post);
																	if ($insert) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/weighstation'));
																		exit;
																	}
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['weigh'] = $this->db->get_where('weighstation', array('id' => $para2))->result_array();
																$this->page_data['routes'] = $this->db->get('routes')->result_array();
																$this->load->view('back/weighstation_edit', $this->page_data);
															} elseif ($para1 == 'update') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('name', 'Weigh station name', 'required|trim');
																$this->form_validation->set_rules('loc', 'Weigh station location', 'required|trim');
																$this->form_validation->set_rules('route', 'Weigh station route', 'required|trim');

																if ($this->input->post('type') == 1) {
																	$this->form_validation->set_rules('ip_address', 'IP address', 'required|trim|valid_ip');
																} elseif ($this->input->post('type') == 2) {
																	$this->form_validation->set_rules('ftp_address', 'FTP address', 'required|trim|valid_ip');
																}
																// if($this->input->post('sofware_type') == 2){
																// 	$this->form_validation->set_rules('file_index','Index file Required','required|trim|numeric');

																// }
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$weigh_id = $para2;
																	$update = $this->Admin_model->update_weighstation($weigh_id, $post);
																	if ($update) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/weighstation'));
																		exit;
																	} else {
																		echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																		exit;
																	}
																}
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('weighstation');
															} elseif ($para1 == 'tp_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$type = $this->db->get_where('weighstation', array('id' => $article))->row()->software_type;
																if ($type == 0) {
																	echo "action";
																	exit;
																}
																$this->db->where('id', $article);
																$this->db->update('weighstation', $data);

																echo $para3;
															} elseif ($para1 == 'gm_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['gm_status'] = '1';
																} else {
																	$data['gm_status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('weighstation', $data);

																echo $para3;
															} elseif ($para1 == 'camera_publish_set') {
																// echo $para2; exit;
																$article = $para2;
																if ($para3 == 'true') {
																	$data['cam_status'] = '1';
																} else {
																	$data['cam_status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('weighstation', $data);

																echo $para3;
															} else {
																$this->page_data['page'] = 'Weighstation';
																$this->load->view('back/weighstation', $this->page_data);
															}
														}
														public function weighlimit($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['weigh'] = $this->db->get('weigh_limit')->result_array();
																$this->load->view('back/weighlimit_list', $this->page_data);
															} elseif ($para1 == 'add') {
																$this->page_data['category'] = $this->db->get('weigh_category')->result_array();
																$this->load->view('back/weighlimit_add', $this->page_data);
															} elseif ($para1 == 'do_add') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('cat', 'No of Axles', 'required|trim');
																$this->form_validation->set_rules('weighlimit', 'Weight Limit', 'required|trim|numeric');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	////check weather this category code already exists in weighlimit table////
																	$post = $this->input->post();
																	$code = $this->db->get_where('weigh_category', array('id' => $post['cat']))->row()->code;
																	$check = $this->db->get_where('weigh_limit', array('category_code' => $code))->result_array();
																	if ($check) {

																		echo json_encode(array('response' => False, 'message' => 'Weighlimit for this category already exists', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/weighlimit'));
																		exit;
																	}

																	$insert = $this->Admin_model->add_weighlimit($post);
																	if ($insert) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/weighlimit'));
																		exit;
																	}
																}
															} elseif ($para1 == 'edit') {
																//$this->db->where('id !=', $para2);
																$this->page_data['category'] = $this->db->get('weigh_category')->result_array();
																$this->page_data['limit'] = $this->db->get_where('weigh_limit', array('id' => $para2))->result_array();
																$this->load->view('back/weighlimit_edit', $this->page_data);
															} elseif ($para1 == 'update') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('cat', 'No of Axles', 'required|trim');
																$this->form_validation->set_rules('weighlimit', 'Weight Limit', 'required|trim|numeric');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$code = $this->db->get_where('weigh_category', array('id' => $post['cat']))->row()->code;
																	$this->db->where('id!=', $para2);
																	$this->db->where('category_code', $code);
																	$check = $this->db->get('weigh_limit')->result_array();


																	if ($check) {
																		echo json_encode(array('response' => FALSE, 'message' => 'This axle limit already exist, please choose different one'));
																		exit;
																	}
																	$id = $para2;
																	$update = $this->Admin_model->update_limit($id, $post);
																	if ($update) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/weighlimit'));
																		exit;
																	} else {
																		echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																		exit;
																	}
																}
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('weigh_limit');
															} else {
																$this->page_data['page'] = 'Weightlimit';
																$this->load->view('back/weighlimit', $this->page_data);
															}
														}

														public function CamerasList()
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															$this->page_data['page'] = 'Cameras List';
															$this->page_data['weigh'] = $this->db->get('view_weighstation_camera_list')->result_array();
															$this->load->view('back/weighstation_cameras_list', $this->page_data);
														}

														public function weighstation_custom_data()
														{
															$this->page_data['page'] = 'weighstation custom data';
															$this->page_data['weighstations'] = $this->db->get_where('weighstation', array('status' => 1, 'software_type' => 1))->result_array();
															$this->load->view('back/weighstation_custom_data', $this->page_data);
														}

														public function search_weighstation_custom_data()
														{
															$ins_data = array();
															$allowed = $this->db->get('weigh_limit')->result_array();
															foreach ($allowed as $key => $val) {
																$check_cat[$key] = $val['category_code'];
															}
															$weigh = $this->input->post('weighstation');

															$date = rtrim(str_replace('/', '-', $this->input->post('day')), '-');;
															$new_date = date('Y-m-d', strtotime($date));
															$weighstation = $this->db->get_where('weighstation', array('id' => $weigh, 'status' => 1))->result_array();
															// echo $this->db->last_query();
															// echo '<pre>';
															// print_r($check); exit;
															if (!$weighstation) {
																echo json_encode(array('response' => FALSE, 'message' => 'No weighstation found for your search'));
																exit;
															}
															$getfile =  str_replace('-', '', $date);
															if ($weighstation[0]['type'] == 1) {
																$dir = "\\\\" . $weighstation[0]['address'] . "\\daw300nt\\";
															} elseif ($weighstation[0]['type'] == 2) {
																$dir = "ftp://" . $weighstation[0]['address'] . "/";
															}
															if ($weighstation[0]['type'] == 2) {
																$conn_id = ftp_connect($weighstation[0]['address']);
															} elseif ($weighstation[0]['type'] == 1) {
																//$fp = @fsockopen($row['address'], 80, $errno, $errstr,5);
															}

															if ($weighstation[0]['type'] == 2 && !$conn_id) {
																echo json_encode(array('response' => FALSE, 'message' => 'Unable to connect to weighstation'));
																exit;
															} else {
																$id = $weighstation[0]['id'];
																$newdate = date('Y-m-d', strtotime($date));

																$query = $this->db->query("SELECT COUNT(id) as count_id
                               FROM weighstation_data
                               WHERE weigh_id = '$id' AND date = '$new_date'");
																$c = $query->row()->count_id;
																//echo $this->db->last_query(); exit;
																$file = $dir . $getfile . ".dat";
																$file1 = $dir . $getfile . ".inf";
																if (file_exists($file)) {
																	$data = file_get_contents($file);
																	if (file_exists($file1)) {
																		$data1 = file_get_contents($file1);
																	}
																	$data_exp = explode(PHP_EOL, $data);
																	$data_exp = array_values(array_filter($data_exp));

																	//$sku = array_slice($data_exp, ($c)) ;
																	$sku = $data_exp;

																	if ($sku) {
																		$array = array();
																		foreach ($sku as $value) {
																			$array[] = explode(';', $value);
																		}

																		$data_final = $array;
																		if (file_exists($file1)) {
																			$data1 = array_filter(explode(PHP_EOL, $data1));
																			$data1_final = array();
																			foreach ($data1 as $key11 => $val11) {
																				$data1_final[$key11] = explode(';', $val11);
																			}
																		}

																		if (!empty($data_final)) {

																			foreach ($data_final as $key => $rowval) {
																				$cat_code = trim($rowval[7]);
																				$index =  array_search($cat_code, array_column($allowed, 'category_code'));
																				if (in_array($cat_code, $check_cat)) {
																					$ins_data[$key]['weigh_id'] = $weighstation[0]['id'];
																					$d = explode('/', $rowval[0]);
																					$datwe = $d[2] . '-' . $d[0] . '-' . $d[1];
																					$ins_data[$key]['date'] = $datwe;

																					$ins_data[$key]['time'] = $rowval[1];
																					$ins_data[$key]['ticket_no'] = $rowval[4];
																					$ins_data[$key]['vehicle_no'] = $rowval[5];
																					$type = mb_substr(trim($rowval[7]), 0, 1);

																					$ins_data[$key]['type'] = $type;

																					$weight_lmit = $allowed[$index]['weigh_limit'];

																					$weight = 0;
																					for ($i = 11; $i < 11 + $type; $i++) {
																						$weight += $rowval[$i];
																					}

																					$ins_data[$key]['weight'] = $weight;
																					$ins_data[$key]['vehicle_code'] = $cat_code;
																					if ($weight_lmit < $weight) {
																						$diff = $weight - $weight_lmit;
																						$ins_data[$key]['exces_weight'] = $diff;

																						$ins_data[$key]['percent_overload'] = round(($diff / $weight_lmit) * 100, 2);
																						$ins_data[$key]['status'] = 2;
																					} else {
																						$ins_data[$key]['exces_weight'] = 0;
																						$ins_data[$key]['percent_overload'] = 0;
																						$ins_data[$key]['status'] = 1;
																					}

																					$search = $rowval[4];
																					$ins_data[$key]['haulier'] = '';
																					$ins_data[$key]['fine'] = '';
																					if (file_exists($file1)) {
																						foreach ($data1_final as $val) {
																							//echo "@".trim($val[2])."==".trim($search).".<br>";
																							if (trim($val[2]) == trim($search)) {

																								$ins_data[$key]['haulier'] = trim(preg_replace('/[0-9.]+/', '', $val[6]));
																								$ins_data[$key]['fine'] = trim($val[7]);
																							} else {
																							}
																						}
																					}
																				}
																			}
																		}
																	} else {
																		echo json_encode(array('response' => FALSE, 'message' => 'You already have data for this date'));
																		exit;
																	}
																} else {
																	echo json_encode(array('response' => FALSE, 'message' => 'No data found for this date'));
																	exit;
																}
																if ($ins_data) {
																	$ins_data = array_values(array_slice($ins_data, $c));
																	if ($ins_data) {
																		$this->db->insert_batch('weighstation_data', $ins_data);
																		echo json_encode(array('response' => TRUE, 'message' => 'Data retrieved successfully'));
																		exit;
																	} else {
																		echo json_encode(array('response' => FALSE, 'message' => 'You already have complete date for this date'));
																		exit;
																	}
																}
															}
														}
														// 	public function weighstation_report($para1 = '' , $para2 = '', $para3 =''){
														// 		if(!$this->session->userdata('adminid')){

														// 			return redirect('admin/login');

														// 		}

														//         	$this->page_data['page'] = 'weighstation daily report';
														//         	$this->page_data['weighstation'] = $this->db->get_where('weighstation',array('status' => 1))->result_array();
														// 			// $sql =	"SELECT weighstation.id, date, name, sum(case when weighstation_data.ticket_no != '' then 1 else 0 end) AS total_vehicles,
														//    // 				 		sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
														//    // 				 		sum(case when weighstation_data.status = 2 then fine else 0 end) fined
														//    // 				 		 FROM weighstation
														//    //  					LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
														//    //  					WHERE weighstation.status = 1   GROUP BY weighstation.id";

														//     // 		$sql = " SELECT  id , name
														// 				// FROM    weighstation a
														//     //     LEFT OUTER JOIN
														//     //     (
														//     //         SELECT  weigh_id ,COUNT('weighstation_data.ticket_no') AS total_vehicles , MAX(date) date,sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
														//    	// 			 		sum(case when weighstation_data.status = 2 then fine else 0 end) fined

														//     //         FROM    weighstation_data
														//     //         GROUP BY date
														//     //     ) b ON a.id = b.weigh_id ";
														// 		    $sql = 'SELECT weighstation.id , weighstation.name,
														// 		    weighstation_data.weigh_id,
														// 			weighstation.last_updated,
														// 		    weighstation_data.date,
														// 		    COUNT(weighstation_data.ticket_no) AS total_vehicles,
														// 		    sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
														// 		    sum(case when weighstation_data.status = 2 then fine else 0 end) fined
														// 			FROM
														// 		    weighstation
														// 		    LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
														// 			WHERE weighstation_data.date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = weighstation.id)
														// 			GROUP BY
														// 		    weighstation.id; ';

														// 			$query= $this->db->query($sql);

														// 			$this->page_data['record'] = $query->result_array(); 

														// 			$this->load->view('back/weighstation_data', $this->page_data);




														// 	}
														public function weighstation_dashboard($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}

															$this->page_data['page'] = 'weighstation daily report';
															$weigh = $this->db->get_where('weighstation', array('status' => 1))->result_array();
															$this->page_data['weighstation'] = $weigh; //$this->db->get_where('weighstation',array('status' => 1))->result_array();

															$records = array();
															$counter = 0;
															foreach ($weigh as $row) {
																$sqli = 'SELECT weigh_id,date,
			COUNT(ticket_no) AS total_vehicles,
			sum(case when status = 2 then 1 else 0 end) overloaded,
			sum(case when status = 2 then fine else 0 end) fined
			FROM
			weighstation_data
			WHERE date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = ' . $row["id"] . ')
			AND weigh_id = ' . $row["id"];
																$datas =  $this->db->query($sqli)->result_array();
																//echo "<pre>";
																//print_r($datas); exit;
																$records[$counter]['id'] = $row['id'];
																$records[$counter]['name'] = $row['name'];
																$records[$counter]['total_vehicles'] = $datas[0]['total_vehicles'];
																if ($datas[0]['overloaded']) {
																	$records[$counter]['overloaded'] = $datas[0]['overloaded'];
																} else {
																	$records[$counter]['overloaded'] = 0;
																}
																if ($datas[0]['fined']) {
																	$records[$counter]['fined'] = $datas[0]['fined'];
																} else {
																	$records[$counter]['fined'] = 0;
																}
																if ($datas[0]['date']) {
																	$records[$counter]['date'] = $datas[0]['date'];
																} else {
																	$records[$counter]['date'] = date('Y-m-d');
																}
																//$records[$counter]['last_updated'] = $row['last_updated'];
																$records[$counter]['last_updated'] = $row['last_updated'];
																$records[$counter]['con_status'] = $row['con_status'];
																$counter++;
															}
															// echo "<pre>";
															// print_r($records); exit;
															//    $sql = 'SELECT weighstation.id ,weighstation.con_status as con_status, weighstation.name,
															//    weighstation_data.weigh_id,
															// weighstation.last_updated,
															//    weighstation_data.date,
															//    COUNT(weighstation_data.ticket_no) AS total_vehicles,
															//    sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
															//    sum(case when weighstation_data.status = 2 then fine else 0 end) fined
															// FROM
															//    weighstation
															//    LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
															// WHERE weighstation_data.date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = weighstation.id)
															// AND weighstation.status = 1
															// GROUP BY
															//    weighstation.id';
															// $query= $this->db->query($sql);
															$sql1 = "SELECT 
		DATE_FORMAT(weighstation_data.date, '%M, %Y') as date,
		COUNT(ticket_no) AS total_vehicles_m,
		sum(case when weighstation.loc = 1 then 1 else 0 end) total_vehicles_m_m,
		sum(case when weighstation.loc = 2 then 1 else 0 end) total_vehicles_m_h,
		sum(case when weighstation_data.status = 2 and weighstation.loc = 2 then 1 else 0 end) overloaded_m_h,
		sum(case when weighstation_data.status = 2 and weighstation.loc = 2 then percent_overload else 0 end) sum_percentage,
		sum(case when weighstation_data.status = 2 and weighstation.loc = 1 then 1 else 0 end) overloaded_m_m,
		sum(case when weighstation_data.status = 2 then fine else 0 end) fined_m,
		sum(case when weighstation_data.status = 2 AND weighstation.loc = 2 AND fine = 0 then 1 else 0 end) without_fine
		
		FROM
		weighstation_data
		LEFT OUTER JOIN weighstation ON weighstation_data.weigh_id = weighstation.id
		
		 WHERE MONTH(date) = '" . date('m') . "' AND YEAR(date) = '" . date('Y') . "'";
															$this->page_data['month_count'] = $this->db->query($sql1)->result_array();
															// echo "<pre>";
															// print_r($this->page_data['month_count']); exit;
															//$this->page_data['record'] = $query->result_array(); 
															$this->page_data['page_assets']['css'] 	= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/back/css/odometer-theme-car.css"/>';
															$this->page_data['page_assets']['js'] 	= '<script src="' . base_url() . 'assets/back/js/odometer.js"></script>';

															$this->page_data['record'] = $records;
															// echo print_r($this->page_data);
															$this->load->view('back/weighstation_data', $this->page_data);
														}

														public function weighstation_daily_report($para1 = '', $para2 = '', $para3 = '')
														{
															if ($para1 == 'post') {
																$weighstation = $this->input->post('weighstation');
																$date = str_replace('/', '-', $this->input->post('day'));
																$first_day_of_month = strtotime(date('Y-m-01'));
																$last_day_of_month = strtotime(date('Y-m-t'));

																$comp_date = strtotime($date);
																////////  check if selected date is current month or previous month ///////
																if (($comp_date >= $first_day_of_month) && ($comp_date <= $last_day_of_month)) {
																	$this->page_data['weighstation'] = $this->db->select('*')->where('weigh_id', $weighstation)->where('date', $date)->order_by('id', 'desc')->get('weighstation_data')->result_array();
																} else {
																	$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_pre_record_day($weighstation, $date);
																}

																$this->page_data['weigh'] = $weighstation;
																$this->page_data['date'] = $date;
																$this->load->view('back/weighstation_daily_report_search', $this->page_data);
															} elseif ($para1 == 'by_weighstation') {
																$weighstation = $para2;
																$this->page_data['weigh'] = $weighstation;
																$data = $this->Admin_model->get_weighstations_dates($weighstation);
																$this->page_data['dates'] = $data;
																$this->page_data['weighs'] = $this->db->get_where('weighstation', array('status' => 1))->result_array();
																//	echo"test"; die;
																$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_daily_report($weighstation);

																$this->page_data['page'] = 'weighstation daily report';
																$this->load->view('back/weighstation_daily_report', $this->page_data);
															}
														}

														function get_weighstation_data()
														{
															// $sql = 'SELECT weighstation.id ,weighstation.con_status as con_status, weighstation.name,
															//     weighstation_data.weigh_id,
															// 	weighstation.last_updated,
															//     weighstation_data.date,
															//     COUNT(weighstation_data.ticket_no) AS total_vehicles,
															//     sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
															//     sum(case when weighstation_data.status = 2 then fine else 0 end) fined
															// 	FROM
															//     weighstation
															//     LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
															// 	WHERE weighstation_data.date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = weighstation.id)
															// 	AND weighstation.status = 1
															// 	GROUP BY
															//     weighstation.id';
															// 	$query= $this->db->query($sql);
															// 	$result = $query->result_array();
															//   		foreach($result as $key => $value){
															// 		$result[$key]['last_updated'] = date('F j, Y, g:i a', $value['last_updated']);
															// 		$result[$key]['date'] = date('F j, Y', strtotime( $value['date']));

															// 	}

															//////////////////////////////////////
															$weigh = $this->db->get_where('weighstation', array('status' => 1))->result_array();
															//$this->page_data['weighstation'] = $weigh;//$this->db->get_where('weighstation',array('status' => 1))->result_array();
															$records = array();
															$counter = 0;
															foreach ($weigh as $row) {
																$sqli = 'SELECT weigh_id,weighstation_data.date,
			COUNT(ticket_no) AS total_vehicles,
			sum(case when status = 2 then 1 else 0 end) overloaded,
			sum(case when status = 2 then fine else 0 end) fined
			FROM
			weighstation_data
			WHERE weighstation_data.date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = ' . $row["id"] . ')
			AND weigh_id = ' . $row["id"];
																$datas =  $this->db->query($sqli)->result_array();
																$records[$counter]['id'] = $row['id'];
																$records[$counter]['name'] = $row['name'];
																$records[$counter]['total_vehicles'] = $datas[0]['total_vehicles'];
																if ($datas[0]['overloaded']) {
																	$records[$counter]['overloaded'] = $datas[0]['overloaded'];
																} else {
																	$records[$counter]['overloaded'] = 0;
																}
																if ($datas[0]['fined']) {
																	$records[$counter]['fined'] = $datas[0]['fined'];
																} else {
																	$records[$counter]['fined'] = 0;
																}
																if ($datas[0]['date']) {
																	$records[$counter]['date'] = date('F j, Y', strtotime($datas[0]['date']));
																} else {
																	$records[$counter]['date'] = date('F j, Y');
																}
																$records[$counter]['last_updated'] = @date('F j, Y, g:i a', $row['last_updated']);
																$records[$counter]['con_status'] = $row['con_status'];
																$counter++;
															}

															////////////////////////
															$sql1 = "SELECT 
		DATE_FORMAT(date, '%M, %Y') as date,
		COUNT(ticket_no) AS total_vehicles_m,
		sum(case when weighstation.loc = 1 then 1 else 0 end) total_vehicles_m_m,
		sum(case when weighstation.loc = 2 then 1 else 0 end) total_vehicles_m_h,
		sum(case when weighstation_data.status = 2 and weighstation.loc = 2 then 1 else 0 end) overloaded_m_h,
		sum(case when weighstation_data.status = 2 and weighstation.loc = 2 then percent_overload else 0 end) sum_percentage,
		sum(case when weighstation_data.status = 2 and weighstation.loc = 1 then 1 else 0 end) overloaded_m_m,
		sum(case when weighstation_data.status = 2 then fine else 0 end) fined_m,
		sum(case when weighstation_data.status = 2 AND weighstation.loc = 2 AND fine = 0 then 1 else 0 end) without_fine
		
		FROM
		weighstation_data
		LEFT OUTER JOIN weighstation ON weighstation_data.weigh_id = weighstation.id
		
		 WHERE MONTH(date) = '" . date('m') . "' AND YEAR(date) = '" . date('Y') . "'";
															$monthly = $this->db->query($sql1)->result_array();

															echo json_encode(array('records' => $records, 'monthly' => $monthly));
														}
														public function daily_weighstation_pdf($para1 = '', $para2 = '')
														{
															//$this->page_data['weighstation'] = $this->db->select('*')->where('weigh_id',$para1)->where('date', $para2)->order_by('id','desc')->get('weighstation_data')->result_array();
															///////////////////////////
															$weighstation = $para1;
															$date = $para2;
															$first_day_of_month = strtotime(date('Y-m-01'));
															$last_day_of_month = strtotime(date('Y-m-t'));
															$comp_date = strtotime($date);

															////////  check if selected date is current month or previous month ///////
															if (($comp_date >= $first_day_of_month) && ($comp_date <= $last_day_of_month)) {
																$this->page_data['weighstation'] = $this->db->select('*')->where('weigh_id', $weighstation)->where('date', $para2)->order_by('id', 'desc')->get('weighstation_data')->result_array();
															} else {
																$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_pre_record_day($weighstation, $date);
															}
															$totalVehicles = 0;
															$totalOverloaded = 0;
															$lessThanTen = 0;
															$lessThanTwenty = 0;
															$lessThanThirty = 0;
															$lessThanFourty = 0;
															$greaterThanFourty = 0;
															foreach ($this->page_data['weighstation'] as $row) {
																$totalVehicles++;
																if ($row['exces_weight'] > 0) {
																	$totalOverloaded++;
																}
																if ($row['exces_weight'] > 0 && $row['exces_weight'] <= 10) {
																	$lessThanTen++;
																}
																if ($row['exces_weight'] > 10 && $row['exces_weight'] <= 20) {
																	$lessThanTwenty++;
																}
																if ($row['exces_weight'] > 20 && $row['exces_weight'] <= 30) {
																	$lessThanThirty++;
																}
																if ($row['exces_weight'] > 30 && $row['exces_weight'] <= 40) {
																	$lessThanFourty++;
																}
																if ($row['exces_weight'] > 40) {
																	$greaterThanFourty++;
																}
															}
															$this->page_data['totalVehicles'] = $totalVehicles;
															$this->page_data['totalOverloaded'] = $totalOverloaded;
															$this->page_data['lessThanTen'] = $lessThanTen;
															$this->page_data['lessThanTwenty'] = $lessThanTwenty;
															$this->page_data['lessThanThirty'] = $lessThanThirty;
															$this->page_data['lessThanFourty'] = $lessThanFourty;
															$this->page_data['greaterThanFourty'] = $greaterThanFourty;
															////////////////////////////////	
															$report  = $this->load->view('back/weighstation_data_pdf', $this->page_data, TRUE);
															$this->load->library("Pdf");
															$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
															$pdf->SetCreator(PDF_CREATOR);
															$pdf->SetAuthor('NHA Weigh Station Report');
															$pdf->SetTitle('NHA Daily Weigh Station Report');
															$pdf->SetSubject('Weighststion Daily Report');
															$pdf->SetKeywords('Weigh Report, PDF');

															$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
															$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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

															$pdf->Output('Weigh Station Report.pdf', 'I');
														}

														public function timeslice_weighstation_pdf($para1 = '', $para2 = '')
														{
															//$this->page_data['weighstation'] = $this->db->select('*')->where('weigh_id',$para1)->where('date', $para2)->order_by('id','desc')->get('weighstation_data')->result_array();
															///////////////////////////
															$weighstation = $para1;
															$date = $para2;
															$first_day_of_month = strtotime(date('Y-m-01'));
															$last_day_of_month = strtotime(date('Y-m-t'));
															$comp_date = strtotime($date);

															////////  check if selected date is current month or previous month ///////
															if (($comp_date >= $first_day_of_month) && ($comp_date <= $last_day_of_month)) {
																$queryData = $this->db->select('*')->where('weigh_id', $weighstation)->where('date', $para2)->order_by('time', 'asc')->get('weighstation_data')->result_array();
															} else {
																$queryData = $this->Admin_model->get_weighstation_pre_record_day($weighstation, $date);
															}
															$oldTime = '';
															$timeSliceData = array();
															$index = 0;
															$flag = 0;
															foreach ($queryData as $row) {
																if ($index >= 1) {
																	$date_a = new DateTime($row['time']);
																	$date_b = new DateTime($oldTime);
																	$interval = date_diff($date_a, $date_b);
																	$timeGapValue = $interval->format('%h:%i:%s');
																	$exactVal = explode(":", $timeGapValue);
																	if ($exactVal[1] > 15) {
																		if ($flag == 0) {
																			$timeSliceData[] = $queryData[--$index];
																			$flag++;
																		}
																		$timeSliceData[] = $row;
																	}
																}
																$oldTime = $row['time'];
																$index++;
															}
															// echo "<pre>"; print_r($timeSliceData); exit;
															// echo "<pre>"; print_r($queryData); exit;

															$this->page_data['timeSliceData'] = $timeSliceData;
															$totalVehicles = 0;
															$totalOverloaded = 0;
															$lessThanTen = 0;
															$lessThanTwenty = 0;
															$lessThanThirty = 0;
															$lessThanFourty = 0;
															$greaterThanFourty = 0;
															foreach ($timeSliceData as $row) {
																$totalVehicles++;
																if ($row['exces_weight'] > 0) {
																	$totalOverloaded++;
																}
																if ($row['exces_weight'] > 0 && $row['exces_weight'] <= 10) {
																	$lessThanTen++;
																}
																if ($row['exces_weight'] > 10 && $row['exces_weight'] <= 20) {
																	$lessThanTwenty++;
																}
																if ($row['exces_weight'] > 20 && $row['exces_weight'] <= 30) {
																	$lessThanThirty++;
																}
																if ($row['exces_weight'] > 30 && $row['exces_weight'] <= 40) {
																	$lessThanFourty++;
																}
																if ($row['exces_weight'] > 40) {
																	$greaterThanFourty++;
																}
															}
															$this->page_data['totalVehicles'] = $totalVehicles;
															$this->page_data['totalOverloaded'] = $totalOverloaded;
															$this->page_data['lessThanTen'] = $lessThanTen;
															$this->page_data['lessThanTwenty'] = $lessThanTwenty;
															$this->page_data['lessThanThirty'] = $lessThanThirty;
															$this->page_data['lessThanFourty'] = $lessThanFourty;
															$this->page_data['greaterThanFourty'] = $greaterThanFourty;
															////////////////////////////////	
															$report  = $this->load->view('back/weighstation_timeslice_pdf', $this->page_data, TRUE);
															$this->load->library("Pdf");
															$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
															$pdf->SetCreator(PDF_CREATOR);
															$pdf->SetAuthor('NHA Weigh Station Report');
															$pdf->SetTitle('NHA Daily Weigh Station Report');
															$pdf->SetSubject('Weighststion Daily Report');
															$pdf->SetKeywords('Weigh Report, PDF');

															$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
															$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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

															$pdf->Output('Time Slice Report.pdf', 'I');
														}

														public function weighstation_categories($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['weigh_cat'] = $this->db->get('weigh_category')->result_array();
																$this->load->view('back/weighstation_category_list', $this->page_data);
															} elseif ($para1 == 'add') {
																$this->load->view('back/weighstation_cat_add', $this->page_data);
															} elseif ($para1 == 'do_add') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('name', 'Category Name', 'required|trim');
																$this->form_validation->set_rules('axle', 'No of Axle', 'required|trim|numeric');
																$this->form_validation->set_rules('code', 'Category Code', 'required|trim|numeric');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$insert = $this->Admin_model->add_weighstation_cat($post);
																	if ($insert) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/weighstation_categories'));
																		exit;
																	}
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['weigh'] = $this->db->get_where('weigh_category', array('id' => $para2))->result_array();
																$this->load->view('back/weighstation_cat_edit', $this->page_data);
															} elseif ($para1 == 'update') {

																$this->load->library('form_validation');
																$this->form_validation->set_rules('name', 'Category Name', 'required|trim');
																$this->form_validation->set_rules('axle', 'No of Axle', 'required|trim|numeric');
																$this->form_validation->set_rules('code', 'Category Code', 'required|trim|numeric');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$id = $para2;
																	$update = $this->Admin_model->update_weighstation_cat($id, $post);
																	if ($update) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/weighstation_categories'));
																		exit;
																	} else {
																		echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																		exit;
																	}
																}
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('weigh_category');
															} else {
																$this->page_data['page'] = 'Weighstation Category';
																$this->load->view('back/weighstation_category', $this->page_data);
															}
														}

														///////////////////////////////////////////////////////////////////
														public function weighstation_consolidated_report($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}


															$sql_categories = "SELECT GROUP_CONCAT(code) as code FROM weigh_category GROUP BY axle";

															$result_category = $this->db->query($sql_categories)->result_array();

															$sql = 'SELECT weighstation.id ,weighstation.con_status as con_status, weighstation.name,
		    weighstation_data.weigh_id,DATE_FORMAT(weighstation_data.date, "%M %Y") AS datemade,
		    COUNT(weighstation_data.ticket_no) AS total_vehicles,
		    sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
		    sum(case when weighstation_data.status = 2 then fine else 0 end) fined,
		    sum(case when weighstation_data.status = 2 AND fine = 0 then 1 else 0 end) without_fine,
		    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[0]["code"] . ') then 1 else 0 end) 2ax_overloaded,
		    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[1]["code"] . ') then 1 else 0 end) 3ax_overloaded,
		    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[2]["code"] . ') then 1 else 0 end) 4ax_overloaded,
		    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[3]["code"] . ') then 1 else 0 end) 5ax_overloaded,
		    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[4]["code"] . ') then 1 else 0 end) 6ax_overloaded,
		    sum(case when weighstation_data.status = 2 then 1 else 0 end) total_vehicles_overloaded,
		    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[0]["code"] . ') then 1 else 0 end) 2ax_inload,
		    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[1]["code"] . ') then 1 else 0 end) 3ax_inload,
		    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[2]["code"] . ') then 1 else 0 end) 4ax_inload,
		    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[3]["code"] . ') then 1 else 0 end) 5ax_inload,
		    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[4]["code"] . ') then 1 else 0 end) 6ax_inload,
		    sum(case when weighstation_data.status = 1 then 1 else 0 end) total_vehicles_inload

			FROM
		    weighstation
		    LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
			WHERE MONTH(date) = "' . date('m') . '" AND YEAR(date) = "' . date('Y') . '"
			AND weighstation.status = 1
			GROUP BY
		    weighstation.id';
															$query = $this->db->query($sql);
															$records = $query->result_array();

															$this->page_data['record'] = $records;
															$this->page_data['page'] = 'consolidated';

															$this->load->view('back/weigh_consold_report', $this->page_data);
														}
														///////////////////////////////////////
														public function weighstation_consolidated_report_search($para1 = '', $para2 = '', $para3 = '')
														{
															if ($para1 == 'post') {

																$date = explode('/', $this->input->post('day'));
																$s_date = str_replace('/', '-', $this->input->post('day'));
																$c_date = date('m-Y');
																if ($s_date == $c_date) {
																	$sql_categories = "SELECT GROUP_CONCAT(code) as code FROM weigh_category GROUP BY axle";
																	$result_category = $this->db->query($sql_categories)->result_array();
																	$sql = 'SELECT weighstation.id ,weighstation.con_status as con_status, weighstation.name,
					    weighstation_data.weigh_id,DATE_FORMAT(weighstation_data.date, "%M %Y") AS datemade,
					    COUNT(weighstation_data.ticket_no) AS total_vehicles,
					    sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
					    sum(case when weighstation_data.status = 2 then fine else 0 end) fined,
					    sum(case when weighstation_data.status = 2 AND fine = 0 then 1 else 0 end) without_fine,
					    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[0]["code"] . ') then 1 else 0 end) 2ax_overloaded,
					    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[1]["code"] . ') then 1 else 0 end) 3ax_overloaded,
					    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[2]["code"] . ') then 1 else 0 end) 4ax_overloaded,
					    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[3]["code"] . ') then 1 else 0 end) 5ax_overloaded,
					    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[4]["code"] . ') then 1 else 0 end) 6ax_overloaded,
					    sum(case when weighstation_data.status = 2 then 1 else 0 end) total_vehicles_overloaded,
					    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[0]["code"] . ') then 1 else 0 end) 2ax_inload,
					    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[1]["code"] . ') then 1 else 0 end) 3ax_inload,
					    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[2]["code"] . ') then 1 else 0 end) 4ax_inload,
					    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[3]["code"] . ') then 1 else 0 end) 5ax_inload,
					    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[4]["code"] . ') then 1 else 0 end) 6ax_inload,
					    sum(case when weighstation_data.status = 1 then 1 else 0 end) total_vehicles_inload

						FROM
					    weighstation
					    LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
						WHERE MONTH(date) = "' . date('m') . '" AND YEAR(date) = "' . date('Y') . '"
						AND weighstation.status = 1
						GROUP BY
					    weighstation.id';
																	$query = $this->db->query($sql);
																	$records = $query->result_array();
																	$this->page_data['record'] = $records;
																	$this->page_data['page'] = 'weighstation daily report';
																	$this->load->view('back/weigh_consold_report_search_current', $this->page_data);
																} else {
																	$sql = 'SELECT weighstation.id as weighstation_id , weighstation.name,
					    weighstation_sum.*,DATE_FORMAT(weighstation_sum.date, "%M %Y") AS datemade
						FROM
					    weighstation
					    LEFT OUTER JOIN weighstation_sum ON weighstation.id = weighstation_sum.weigh_id
						WHERE MONTH(date) = "' . date($date[0]) . '" AND YEAR(date) = "' . date($date[1]) . '"
						AND weighstation.status = 1
						GROUP BY
					    weighstation.id,weighstation_sum.date ORDER BY weighstation_sum.date DESC';
																	$query = $this->db->query($sql);
																	$records = $query->result_array();
																	$arr = array();

																	foreach ($records as $key => $item) {
																		$arr[$item['weigh_id']][$key] = $item;
																	}

																	ksort($arr, SORT_NUMERIC);
																	$recc = array();
																	foreach ($arr as $key => $value) {

																		$total_vehc = 0;
																		$total_fined = 0;
																		$two_ax_inload = 0;
																		$three_ax_inload = 0;
																		$ffs_ax_inload = 0;
																		$total_inload = 0;
																		$two_ax_overload = 0;
																		$three_ax_overload = 0;
																		$ffs_ax_overload = 0;
																		$total_overload = 0;
																		foreach ($value as $keyy11 => $value11) {
																			$total_fined = $total_fined + $value11['fined'];
																			$total_vehc 	= $total_vehc + $value11['total_vehicles'];
																			$inlimit_details = json_decode($value11['in_limit_detail'], true);
																			$overload_details = json_decode($value11['overloaded_detail'], true);
																			$two_ax_inload 	= $two_ax_inload + $inlimit_details['2ax'];
																			$three_ax_inload = $three_ax_inload + $inlimit_details['3ax'];
																			$ffs_ax_inload = $ffs_ax_inload + $inlimit_details['4ax'] + $inlimit_details['5ax'] + $inlimit_details['6ax'];
																			$total_inload = $total_inload + $inlimit_details['total'];
																			$two_ax_overload = $two_ax_overload + $overload_details['2ax'];
																			$three_ax_overload = $three_ax_overload + $overload_details['3ax'];
																			$ffs_ax_overload = $ffs_ax_overload + $overload_details['4ax'] + $overload_details['5ax'] + $overload_details['6ax'];
																			$total_overload = $total_overload + $overload_details['total'];
																		}
																		$recc[$key]['weigh_id'] = $value11['weigh_id'];
																		$recc[$key]['name'] = $value11['name'];
																		$recc[$key]['datemade'] = $value11['datemade'];
																		$recc[$key]['fined'] = $total_fined;
																		$recc[$key]['total_vehicles'] = $total_vehc;
																		$recc[$key]['2ax_inload'] = $two_ax_inload;
																		$recc[$key]['3ax_inload'] = $three_ax_inload;
																		$recc[$key]['456ax_inload'] = $ffs_ax_inload;
																		$recc[$key]['total_vehicles_inload'] = $total_inload;
																		$recc[$key]['2ax_overloaded'] = 	$two_ax_overload;
																		$recc[$key]['3ax_overloaded'] = 	$three_ax_overload;
																		$recc[$key]['456ax_overloaded'] = $ffs_ax_overload;
																		$recc[$key]['total_vehicles_overloaded'] = $total_overload;
																	}

																	$this->page_data['record'] = array_values($recc);
																	$this->page_data['page'] = 'weighstation daily report';
																	$this->load->view('back/weigh_consold_report_search', $this->page_data);
																}
															}
														}

														////////////////////////////////////////////////////////////////////////////////////////////////////
														///////////////////////////////////////////////////////////////////////////////////////////////////
														///////////////////////////////////////////////////////////////////////////////////////////////////
														public function weighstation_consolidated_report_pdf($para1 = '', $para2 = '')
														{

															$date = explode('-', $para1);
															$s_date = $para1;
															$c_date = date('m-Y');
															if ($s_date == $c_date) {
																$sql_categories = "SELECT GROUP_CONCAT(code) as code FROM weigh_category GROUP BY axle";
																$result_category = $this->db->query($sql_categories)->result_array();
																$sql = 'SELECT weighstation.id ,weighstation.con_status as con_status, weighstation.name,
					    weighstation_data.weigh_id,DATE_FORMAT(weighstation_data.date, "%M %Y") AS datemade,
					    COUNT(weighstation_data.ticket_no) AS total_vehicles,
					    sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
					    sum(case when weighstation_data.status = 2 then fine else 0 end) fined,
					    sum(case when weighstation_data.status = 2 AND fine = 0 then 1 else 0 end) without_fine,
					    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[0]["code"] . ') then 1 else 0 end) 2ax_overloaded,
					    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[1]["code"] . ') then 1 else 0 end) 3ax_overloaded,
					    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[2]["code"] . ') then 1 else 0 end) 4ax_overloaded,
					    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[3]["code"] . ') then 1 else 0 end) 5ax_overloaded,
					    sum(case when weighstation_data.status = 2 AND vehicle_code IN (' . $result_category[4]["code"] . ') then 1 else 0 end) 6ax_overloaded,
					    sum(case when weighstation_data.status = 2 then 1 else 0 end) total_vehicles_overloaded,
					    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[0]["code"] . ') then 1 else 0 end) 2ax_inload,
					    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[1]["code"] . ') then 1 else 0 end) 3ax_inload,
					    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[2]["code"] . ') then 1 else 0 end) 4ax_inload,
					    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[3]["code"] . ') then 1 else 0 end) 5ax_inload,
					    sum(case when weighstation_data.status = 1 AND vehicle_code IN (' . $result_category[4]["code"] . ') then 1 else 0 end) 6ax_inload,
					    sum(case when weighstation_data.status = 1 then 1 else 0 end) total_vehicles_inload

						FROM
					    weighstation
					    LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
						WHERE MONTH(date) = "' . date('m') . '" AND YEAR(date) = "' . date('Y') . '"
						AND weighstation.status = 1
						GROUP BY
					    weighstation.id';

																$query = $this->db->query($sql);
																$records = $query->result_array();
																$this->page_data['record'] = $records;
																$this->page_data['page'] = 'weighstation daily report';
																$pdfdata = $this->load->view('back/weigh_consold_report_current_pdf', $this->page_data, TRUE);
															} else {
																$sql = 'SELECT weighstation.id as weighstation_id , weighstation.name,
					    weighstation_sum.*,DATE_FORMAT(weighstation_sum.date, "%M %Y") AS datemade
						FROM
					    weighstation
					    LEFT OUTER JOIN weighstation_sum ON weighstation.id = weighstation_sum.weigh_id
						WHERE MONTH(date) = "' . date($date[0]) . '" AND YEAR(date) = "' . date($date[1]) . '"
						AND weighstation.status = 1
						GROUP BY
					    weighstation.id,weighstation_sum.date ORDER BY weighstation_sum.date DESC';
																$query = $this->db->query($sql);
																$records = $query->result_array();
																$arr = array();

																foreach ($records as $key => $item) {
																	$arr[$item['weigh_id']][$key] = $item;
																}

																ksort($arr, SORT_NUMERIC);
																$recc = array();
																foreach ($arr as $key => $value) {

																	$total_vehc = 0;
																	$total_fined = 0;
																	$two_ax_inload = 0;
																	$three_ax_inload = 0;
																	$ffs_ax_inload = 0;
																	$total_inload = 0;
																	$two_ax_overload = 0;
																	$three_ax_overload = 0;
																	$ffs_ax_overload = 0;
																	$total_overload = 0;
																	foreach ($value as $keyy11 => $value11) {
																		$total_fined = $total_fined + $value11['fined'];
																		$total_vehc 	= $total_vehc + $value11['total_vehicles'];
																		$inlimit_details = json_decode($value11['in_limit_detail'], true);
																		$overload_details = json_decode($value11['overloaded_detail'], true);
																		$two_ax_inload 	= $two_ax_inload + $inlimit_details['2ax'];
																		$three_ax_inload = $three_ax_inload + $inlimit_details['3ax'];
																		$ffs_ax_inload = $ffs_ax_inload + $inlimit_details['4ax'] + $inlimit_details['5ax'] + $inlimit_details['6ax'];
																		$total_inload = $total_inload + $inlimit_details['total'];
																		$two_ax_overload = $two_ax_overload + $overload_details['2ax'];
																		$three_ax_overload = $three_ax_overload + $overload_details['3ax'];
																		$ffs_ax_overload = $ffs_ax_overload + $overload_details['4ax'] + $overload_details['5ax'] + $overload_details['6ax'];
																		$total_overload = $total_overload + $overload_details['total'];
																	}
																	$recc[$key]['weigh_id'] = $value11['weigh_id'];
																	$recc[$key]['name'] = $value11['name'];
																	$recc[$key]['datemade'] = $value11['datemade'];
																	$recc[$key]['fined'] = $total_fined;
																	$recc[$key]['total_vehicles'] = $total_vehc;
																	$recc[$key]['2ax_inload'] = $two_ax_inload;
																	$recc[$key]['3ax_inload'] = $three_ax_inload;
																	$recc[$key]['456ax_inload'] = $ffs_ax_inload;
																	$recc[$key]['total_vehicles_inload'] = $total_inload;
																	$recc[$key]['2ax_overloaded'] = 	$two_ax_overload;
																	$recc[$key]['3ax_overloaded'] = 	$three_ax_overload;
																	$recc[$key]['456ax_overloaded'] = $ffs_ax_overload;
																	$recc[$key]['total_vehicles_overloaded'] = $total_overload;
																}

																$this->page_data['record'] = array_values($recc);
																$this->page_data['page'] = 'weighstation daily report';
																$pdfdata = $this->load->view('back/weigh_consold_report_pdf', $this->page_data, TRUE);
															}

															$this->load->library("Pdf");
															$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
															$pdf->SetCreator(PDF_CREATOR);
															$pdf->SetAuthor('NHA MTR');
															$pdf->SetTitle('NHA Monthly Traffic Report');
															$pdf->SetSubject('MTR');
															$pdf->SetKeywords('MTR, PDF');

															$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
															$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
															$pdf->SetFont('dejavusans', '', 14, '', true);
															$pdf->AddPage('P', 'A4');

															$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
															$pdf->writeHTMLCell(0, 0, '', '', $pdfdata, 0, 1, 0, true, '', true);
															$pdf->Output('mtr.pdf', 'I');
														}

														//////////////

														public function weighstation_monthly_report($para1 = '', $para2 = '', $para3 = '')
														{
															if ($para1 == 'post') {
																// echo "in If"; 
																$weighstation = $this->input->post('weighstation');
																$date = $this->input->post('day');
																// echo $date; exit;
																$this->page_data['general'] = $this->Admin_model->search_weighstation_monthly_report($weighstation, $date);
																$this->page_data['weighstation'] = $this->page_data['general']['new_result'];
																// echo "<pre>"; print_r($this->page_data['weighstation']); exit;
																// $this->page_data['weighstation_data'] = $this->Admin_model->search_weighstation_monthly_data($weighstation,$date);
																$this->page_data['weigh'] = $weighstation;
																$this->page_data['date'] = $date;
																$this->load->view('back/weighstation_monthly_report_search', $this->page_data);
															} elseif ($para1 == 'by_weighstation') {

																$weighstation = $para2;
																$this->page_data['weigh'] = $weighstation;
																$data = $this->Admin_model->get_weighstations_months($weighstation);

																$this->page_data['dates'] = $data;
																$this->page_data['weighs'] = $this->db->get_where('weighstation', array('status' => 1))->result_array();
																$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_monthly_report($weighstation);

																$this->page_data['page'] = 'weighstation daily report';
																$this->load->view('back/weighstation_monthly_report', $this->page_data);
															}
														}


														public function monthly_weighstation_pdf($para1 = '', $para2 = '')
														{
															$weighstation = $para1;
															$date = $para2;
															$this->page_data['weigh'] = $weighstation;
															$d = explode('-', $para2);
															$newdate = implode('/', array(@$d[1], @$d[0]));
															$this->page_data['general_data'] = $this->Admin_model->search_weighstation_monthly_report($weighstation, $newdate);
															// echo "<pre>"; print_r($this->page_data['general_data']); exit;
															$this->page_data['weighstation'] = $this->page_data['general_data']['new_result'];
															if (!empty($this->page_data['general_data']['result_data'])) {
																$this->page_data['weighstation_data'] = $this->page_data['general_data']['result_data'];
															}
															$counter = 0;
															$two_ax_upto_ten = 0;
															$two_ax_upto_twenty = 0;
															$two_ax_upto_thirty = 0;
															$two_ax_upto_fourty = 0;
															$two_ax_greater_fourty = 0;
															$three_ax_upto_ten = 0;
															$three_ax_upto_twenty = 0;
															$three_ax_upto_thirty = 0;
															$three_ax_upto_fourty = 0;
															$three_ax_greater_fourty = 0;
															$more_ax_upto_ten = 0;
															$more_ax_upto_twenty = 0;
															$more_ax_upto_thirty = 0;
															$more_ax_upto_fourty = 0;
															$more_ax_greater_fourty = 0;
															// echo "<pre>"; print_r($this->page_data['weighstation']); exit;
															foreach ($this->page_data['weighstation_data'] as $datedRecord) {
																foreach ($datedRecord as $vehicleWeighed) {
																	// echo "<pre>"; print_r($vehicleWeighed); exit;
																	if ($vehicleWeighed['vehicle_code'] == 200 || $vehicleWeighed['vehicle_code'] == 210) {
																		if ($vehicleWeighed['exces_weight'] > 0 && $vehicleWeighed['exces_weight'] <= 10) {
																			$two_ax_upto_ten++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 10 && $vehicleWeighed['exces_weight'] <= 20) {
																			$two_ax_upto_twenty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 20 && $vehicleWeighed['exces_weight'] <= 30) {
																			$two_ax_upto_thirty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 30 && $vehicleWeighed['exces_weight'] <= 40) {
																			$two_ax_upto_fourty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 40) {
																			$two_ax_greater_fourty++;
																		}
																	}
																	if ($vehicleWeighed['vehicle_code'] == 300 || $vehicleWeighed['vehicle_code'] == 310) {
																		if ($vehicleWeighed['exces_weight'] > 0 && $vehicleWeighed['exces_weight'] <= 10) {
																			$three_ax_upto_ten++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 10 && $vehicleWeighed['exces_weight'] <= 20) {
																			$three_ax_upto_twenty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 20 && $vehicleWeighed['exces_weight'] <= 30) {
																			$three_ax_upto_thirty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 30 && $vehicleWeighed['exces_weight'] <= 40) {
																			$three_ax_upto_fourty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 40) {
																			$three_ax_greater_fourty++;
																		}
																	}
																	if ($vehicleWeighed['vehicle_code'] == 400 || $vehicleWeighed['vehicle_code'] == 410 || $vehicleWeighed['vehicle_code'] == 420 || $vehicleWeighed['vehicle_code'] == 430 || $vehicleWeighed['vehicle_code'] == 630) {
																		if ($vehicleWeighed['exces_weight'] > 0 && $vehicleWeighed['exces_weight'] <= 10) {
																			$more_ax_upto_ten++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 10 && $vehicleWeighed['exces_weight'] <= 20) {
																			$more_ax_upto_twenty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 20 && $vehicleWeighed['exces_weight'] <= 30) {
																			$more_ax_upto_thirty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 30 && $vehicleWeighed['exces_weight'] <= 40) {
																			$more_ax_upto_fourty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 40) {
																			$more_ax_greater_fourty++;
																		}
																	}
																	if ($vehicleWeighed['vehicle_code'] == 510 || $vehicleWeighed['vehicle_code'] == 520 || $vehicleWeighed['vehicle_code'] == 530 || $vehicleWeighed['vehicle_code'] == 570 || $vehicleWeighed['vehicle_code'] == 690) {
																		if ($vehicleWeighed['exces_weight'] > 0 && $vehicleWeighed['exces_weight'] <= 10) {
																			$more_ax_upto_ten++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 10 && $vehicleWeighed['exces_weight'] <= 20) {
																			$more_ax_upto_twenty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 20 && $vehicleWeighed['exces_weight'] <= 30) {
																			$more_ax_upto_thirty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 30 && $vehicleWeighed['exces_weight'] <= 40) {
																			$more_ax_upto_fourty++;
																		}
																		if ($vehicleWeighed['exces_weight'] > 40) {
																			$more_ax_greater_fourty++;
																		}
																	}
																}
															}
															$this->page_data['two_ax_upto_ten'] = $two_ax_upto_ten;
															$this->page_data['two_ax_upto_twenty'] = $two_ax_upto_twenty;
															$this->page_data['two_ax_upto_thirty'] = $two_ax_upto_thirty;
															$this->page_data['two_ax_upto_fourty'] = $two_ax_upto_fourty;
															$this->page_data['two_ax_greater_fourty'] = $two_ax_greater_fourty;

															$this->page_data['three_ax_upto_ten'] = $three_ax_upto_ten;
															$this->page_data['three_ax_upto_twenty'] = $three_ax_upto_twenty;
															$this->page_data['three_ax_upto_thirty'] = $three_ax_upto_thirty;
															$this->page_data['three_ax_upto_fourty'] = $three_ax_upto_fourty;
															$this->page_data['three_ax_greater_fourty'] = $three_ax_greater_fourty;

															$this->page_data['more_ax_upto_ten'] = $more_ax_upto_ten;
															$this->page_data['more_ax_upto_twenty'] = $more_ax_upto_twenty;
															$this->page_data['more_ax_upto_thirty'] = $more_ax_upto_thirty;
															$this->page_data['more_ax_upto_fourty'] = $more_ax_upto_fourty;
															$this->page_data['more_ax_greater_fourty'] = $more_ax_greater_fourty;

															$report  = $this->load->view('back/weighstation_monthly_pdf', $this->page_data, TRUE);
															$this->load->library("Pdf");
															$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
															$pdf->SetCreator(PDF_CREATOR);
															$pdf->SetAuthor('NHA Monthly Weighstation Report');
															$pdf->SetTitle('NHA Monthly Weighstation Report');
															$pdf->SetSubject('MWR');
															$pdf->SetKeywords('MWR, PDF');

															$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
															$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
															$pdf->Output('Weigh Station Monthly Report.pdf', 'I');
														}

														/** WeighStation Summary Report START */
														public function weighstation_summary_report($para1 = '', $para2 = '', $para3 = '')
														{

															if ($para1 == 'by_weighstation') {
																$weighstation = $para2;
																$this->page_data['weigh'] = $weighstation;
																$data = $this->Admin_model->get_weighstations_months($weighstation);
																$this->page_data['dates'] = $data;
																$this->page_data['weighs'] = $this->db->get_where('weighstation', array('status' => 1))->result_array();
																$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_summary_report($weighstation);

																$this->page_data['page'] = 'weighstation Summary report';
																$this->load->view('back/weighstation_summary_report', $this->page_data);
															}
														}
														/** WeighStation Summary Report END */

														//////////////////////////////////////////////////////
														////////** Dashboard Timer START *//////////////
														//////////////////////////////////////////////////////

														public function dashboard_timer($para1 = '')
														{

															$plaza = $this->input->post('plaza_id');
															$month = $this->input->post('month');

															$data = $this->Admin_model->timer_chartdata($plaza, $month);
															$previous_year = date("Y-m-d", strtotime(@$data['chart']['month'] . ' -1 year'));
															$previous_monthDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(@$data['chart']['month'])) . "-1 month"));
															$pre_year_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_year);
															$pre_month_data = $this->Admin_model->get_chart_by(@$data['chart']['toolplaza_id'], $previous_monthDate);

															$this->page_data['mtr'] = $this->db->get_where('mtr', array('id' => $data['mtr_id']))->result_array();
															$month_year = explode('-', $this->page_data['mtr'][0]['for_month']);
															$start_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['start_date'];
															$end_date = $month_year[0] . '-' . $month_year[1] . '-' . $this->page_data['mtr'][0]['end_date'];
															$sql = "Select * From terrif Where FIND_IN_SET (" . $this->page_data['mtr'][0]['toolplaza'] . " ,toolplaza) AND (start_date <= '" . $start_date . "' AND end_date >= '" . $end_date . "')";
															$this->page_data['terrif'] = $this->db->query($sql)->result_array();

															$month  = $this->input->post('month');
															$this->page_data['mtrid'] = $data['mtr_id'];
															$this->page_data['plaza_id'] = $plaza;
															$this->page_data['month'] = $month;

															$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
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

														public function notify_counter($para1 = '')
														{
															$this->db->where('for_user_type', 3);
															$this->db->where('for_user_id', $this->session->userdata('adminid'));
															$this->db->where('user_type', 1);
															$this->db->where('is_read', 0);
															$this->db->order_by("id", "desc");
															$this->db->limit(5);
															$disapprovedMtrs = $this->db->get('notifications')->result_array();
															//echo $this->db->last_query(); exit;

															if (!empty($disapprovedMtrs)) {
																$notifyCounter = 0;
																foreach ($disapprovedMtrs as $row) {
																	$notifyCounter++;
																}
															}
															if (!empty($disapprovedMtrs)) {
																if ($notifyCounter > 3) {
																	echo "3+";
																} else {
																	echo $notifyCounter;
																}
															}
														}
														public function notify_msg($para1 = '')
														{
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
															$this->db->where('for_user_type', 3);
															$this->db->where('for_user_id', $this->session->userdata('supervisor_id'));
															$this->db->or_where('user_type', 1);
															$this->db->or_where('user_type', 2);
															$this->db->order_by("id", "desc");
															$this->db->limit(3);
															$this->page_data['notifications'] = $this->db->get('notifications')->result();


															//echo "<pre>";
															//print_r($this->page_data['notifications']); exit;
															//echo $this->db->last_query(); exit;
															$this->load->view('back/notify_msg', $this->page_data);
														}
														public function delete_notification($para1 = '')
														{
															$this->db->where('id', $this->input->post('id'));
															$this->db->delete('notifications');
															return redirect('admin/notify_msg/');
														}

														/////////////////////google maps section start here/////////////////////////////////////////

														public function googlelocations($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}

															if ($para1 == 'list') {
																$this->page_data['googl'] = $this->db->get('google_locations')->result_array();

																$this->load->view('back/googlelocations_list', $this->page_data);
															} elseif ($para1 == 'add') {
																$this->page_data['page'] = 'Google Locations';
																$this->page_data['roads'] = $this->db->get_where('roads', array('status' => 1))->result_array();
																$this->page_data['page_assets']['js'] = '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places,drawing&key=' . $this->page_data['key'] . '"></script>';

																$this->load->view('back/googlelocations_add', $this->page_data);
															} elseif ($para1 == 'do_add') {
																// echo "<pre>";
																// print_r($_POST); exit;
																$this->load->library('form_validation');
																$this->form_validation->set_rules('name', 'Location name', 'required|trim');
																$this->form_validation->set_rules('type', 'Location', 'required|trim');
																$this->form_validation->set_rules('address', 'Location address', 'required|trim');
																$this->form_validation->set_rules('state', 'Privience', 'required|trim');
																//$this->form_validation->set_rules('chainage','Chainage','required|trim');
																$this->form_validation->set_rules('lat', 'Latitude', 'required|trim');
																$this->form_validation->set_rules('lang', 'Longitude', 'required|trim');
																$this->form_validation->set_rules('road', 'Road', 'required|trim');

																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$insert = $this->Admin_model->add_googlelocations($post);
																	if ($insert) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/googlelocations'));
																		exit;
																	}
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['location'] = $this->db->get_where('google_locations', array('id' => $para2))->result_array();
																$this->page_data['roads'] = $this->db->get_where('roads', array('status' => 1))->result_array();
																$this->page_data['page_assets']['js'] = '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places,drawing&key=' . $this->page_data['key'] . '"></script>';

																$this->page_data['page'] = 'Google Locations';
																$this->load->view('back/googlelocations_edit', $this->page_data);
															} elseif ($para1 == 'update') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('name', 'Location name', 'required|trim');
																$this->form_validation->set_rules('type', 'Location', 'required|trim');
																$this->form_validation->set_rules('address', 'Location address', 'required|trim');
																$this->form_validation->set_rules('state', 'Privience', 'required|trim');
																//$this->form_validation->set_rules('chainage','Chainage','required|trim');
																$this->form_validation->set_rules('lat', 'Latitude', 'required|trim');
																$this->form_validation->set_rules('lang', 'Longitude', 'required|trim');
																$this->form_validation->set_rules('road', 'Road', 'required|trim');
																//$this->load->library('form_validation');
																//$this->form_validation->set_rules('name','Weighstation name','required|trim');

																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$google_id = $para2;
																	$update = $this->Admin_model->update_googlelocations($google_id, $post);
																	if ($update) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/googlelocations'));
																		exit;
																	}
																}
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('google_locations');
															} elseif ($para1 == 'tp_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('google_locations', $data);

																echo $para3;
															} else {
																$this->page_data['page'] = 'Google Locations';
																$this->load->view('back/google_locations', $this->page_data);
															}
														}
														function getgoogledata($para1 = '')
														{
															$div = '';
															$div .= '<div class="form-group">';
															if ($para1 == 1) {
																$div .= ' <label for="exampleInputEmail1" style="font-weight: 900;">Toll Plaza</label>
                                  <select class="form-control required" name="loc_id" id="loc_id">
                                        <option value="">Choose Plaza</option>';

																$tollplaza = $this->db->get_where('toolplaza', array('google_map_status' => 1))->result_array();
																foreach ($tollplaza as $row) {
																	$div .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
																}
															} elseif ($para1 == 2) {
																$div .= ' <label for="exampleInputEmail1" style="font-weight: 900;">Weighstation</label>
                                  <select class="form-control required" name="loc_id" id="loc_id">
                                        <option value="">Choose Weighstation</option>';
																$weighstation = $this->db->get_where('weighstation', array('gm_status' => 1))->result_array();
																foreach ($weighstation as $row) {
																	$div .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
																}
															}
															$div .= '</select>
               </div>';
															echo $div;
														}

														public function googleroads($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['googl'] = $this->db->get('roads')->result_array();

																$this->load->view('back/googleroads_list', $this->page_data);
															} elseif ($para1 == 'add') {
																$this->page_data['page'] = 'Google Roads';
																$this->page_data['page_assets']['js'] = '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places,drawing&key=' . $this->page_data['key'] . '"></script>';

																$this->load->view('back/googleroads_add', $this->page_data);
															} elseif ($para1 == 'do_add') {

																$this->load->library('form_validation');
																$this->form_validation->set_rules('name', 'Road name', 'required|trim');
																$this->form_validation->set_rules('address', 'Road address', 'required|trim');
																$this->form_validation->set_rules('route', 'Route', 'required|trim');

																if (!$this->input->post('road_data')) {
																	echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																	exit;
																}
																if (!$this->input->post('lat')) {
																	echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																	exit;
																}
																if (!$this->input->post('lang')) {
																	echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																	exit;
																}
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$insert = $this->Admin_model->add_googleroads($post);
																	if ($insert) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/googleroads'));
																		exit;
																	}
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['road'] = $this->db->get_where('roads', array('id' => $para2))->result_array();
																$this->page_data['page'] = 'Google Roads';
																$this->page_data['page_assets']['js'] = '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places,drawing&key=' . $this->page_data['key'] . '"></script>';

																$this->load->view('back/googleroads_edit', $this->page_data);
															} elseif ($para1 == 'do_update') {

																$this->load->library('form_validation');
																$this->form_validation->set_rules('name', 'Road name', 'required|trim');
																$this->form_validation->set_rules('address', 'Road address', 'required|trim');
																$this->form_validation->set_rules('route', 'Route', 'required|trim');
																if (!$this->input->post('road_data')) {
																	echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																	exit;
																}
																if (!$this->input->post('lat')) {
																	echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																	exit;
																}
																if (!$this->input->post('lang')) {
																	echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																	exit;
																}
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$google_id = $para2;

																	$update = $this->Admin_model->update_googleroads($google_id, $post);
																	if ($update) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/googleroads'));
																		exit;
																	}
																}
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('roads');
															} elseif ($para1 == 'tp_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('roads', $data);

																echo $para3;
															} else {
																$this->page_data['page'] = 'Google Roads';
																$this->load->view('back/google_roads', $this->page_data);
															}
														}

														function site_settings($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															if ($this->session->userdata('role') == 1) {
																return redirect('admin');
															}
															$this->load->library('form_validation');
															if ($para1 == 'update_map_key') {
																$this->form_validation->set_rules('apikey', 'Api Key', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$data = array();
																	$data['value'] = $this->input->post('apikey');
																	$this->db->where('type', 'google_map_api_key');
																	$this->db->update('settings', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/site_settings'));
																}
															} else {
																$this->page_data['user'] = $this->db->get_where('admin', array('id' => $this->session->userdata('adminid')))->result_array();
																$this->page_data['page'] = 'site settings';
																$this->load->view('back/site_settings', $this->page_data);
															}
														}


														/////////////////MAP SECTION STARTS HERE////////
														public function map($para1 = '')
														{

															$this->page_data['page'] = 'map';
															$this->page_data['roads'] = $this->db->get_where('google_locations', array('status' => 1))->result_array();
															$this->page_data['locations'] = $this->db->get_where('google_locations', array('status' => 1))->result_array();
															$this->page_data['roads'] = $this->db->get_where('roads', array('status' => 1))->result_array();
															$this->page_data['page_assets']['js'] = '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places,drawing&key=' . $this->page_data['key'] . '"></script>';

															$this->load->view('back/mapview', $this->page_data);
														}

														public function getcontents($para1 = '')
														{
															$this->page_data['location'] = $this->db->get_where('google_locations', array('id' => $para1))->result_array();
															$this->page_data['info_data'] = array();
															if ($this->page_data['location']) {
																if ($this->page_data['location'][0]['type'] == 1) {
																	$data = $this->db->select('*')->where('toolplaza', $this->page_data['location'][0]['location_id'])->order_by('for_month', 'desc')->limit(1)->get('mtr')->result_array();
																	if ($data) {
																		$tp_data = $this->Admin_model->getinfodetails_tp($data);
																	} else {
																		$tp_data = '';
																	}
																	$this->page_data['info_data'] = $tp_data;
																} elseif ($this->page_data['location'][0]['type'] == 2) {
																	$this->page_data['info_data'] = array();
																}
															}
															$this->load->view('back/infodata', $this->page_data);
														}

														function searchforgoogledata()
														{
															$locations = array();
															if ($this->input->post('alltollplaza')) {
																$locations[] = 1;
															}

															if ($this->input->post('allweighstation')) {
																$locations[] = 2;
															}
															if ($this->input->post('cameras')) {
																$locations[] = 3;
															}
															if ($this->input->post('wis')) {
																$locations[] = 4;
															}
															if ($this->input->post('vms')) {
																$locations[] = 5;
															}
															if ($this->input->post('advisory_radio')) {
																$locations[] = 6;
															}

															if ($this->input->post('erst')) {
																$locations[] = 7;
															}
															if ($this->input->post('microwavevd')) {
																$locations[] = 8;
															}

															if ($this->input->post('speedes')) {
																$locations[] = 9;
															}
															if ($this->input->post('efine')) {
																$locations[] = 10;
															}
															if ($this->input->post('ofc')) {
																$locations[] = 11;
															}
															if ($this->input->post('service')) {
																$locations[] = 12;
															}
															if ($this->input->post('rest')) {
																$locations[] = 13;
															}

															if ($this->input->post('specific_road')) {
																if ($this->input->post('specific_road') == 'all') {
																	$this->page_data['roads'] = $this->db->get_where('roads', array('status' => 1))->result_array();
																	if ($locations) {
																		$this->db->where('status', 1);
																		$this->db->where_in('type', $locations);
																		$this->page_data['locations'] = $this->db->get('google_locations')->result_array();
																	} else {
																		$this->page_data['locations'] = '';
																	}
																} else {
																	$this->page_data['roads'] = $this->db->get_where('roads', array('status' => 1, 'id' => $this->input->post('specific_road')))->result_array();
																	if ($locations) {
																		$this->db->where('status', 1);
																		$this->db->where('road_id', $this->input->post('specific_road'));
																		$this->db->where_in('type', $locations);
																		$this->page_data['locations'] = $this->db->get('google_locations')->result_array();
																	} else {
																		$this->page_data['locations'] = '';
																	}
																}
															} else {
																$this->page_data['roads'] = '';
																if ($locations) {
																	$this->db->where('status', 1);
																	$this->db->where_in('type', $locations);
																	$this->page_data['locations'] = $this->db->get('google_locations')->result_array();
																} else {
																	$this->page_data['locations'] = '';
																}
															}

															if (empty($this->input->post())) {
																$this->page_data['roads'] = $this->db->get_where('roads', array('status' => 1))->result_array();
																$this->page_data['locations'] = '';
															}
															//echo $this->db->last_query(); exit;
															$this->load->view('back/searchforgoogledata', $this->page_data);
														}
														public function traffic_counting($para1 = '', $para2 = '')
														{
															if ($para1 == 'list') {
																$this->db->order_by('id', 'DESC');
																$this->page_data['counter']  = $this->db->get('traffic_counter')->result_array();
																$this->load->view('back/traffic_counter_list', $this->page_data);
															} elseif ($para1 == 'by_tp') {
																$this->db->order_by('id', 'DESC');
																$this->page_data['counter']  = $this->db->get_where('traffic_counter', array('tollplaza' => $para2))->result_array();
																$this->load->view('back/traffic_counter_list', $this->page_data);
															} elseif ($para1 == 'session_start') {
																$check = $this->db->get_where('traffic_counter', array('id' => $para2))->result_array();
																$this->page_data['error'] = '';
																if ($check[0]['video_end_date']) {
																	$this->page_data['error'] = "You can't reopen a completed session";
																}
																$this->page_data['session_data'] = $this->db->get_where('traffic_counter', array('id' => $para2))->result_array();
																$this->page_data['insert_id'] = $para2;
																$this->page_data['page_name'] = 'traffic_counting';
																$this->load->view('front/member/traffic_counter_session', $this->page_data);
															} elseif ($para1 == 'view') {
																$this->page_data['session'] = $this->db->get_where('traffic_counter', array('id' => $para2))->result_array();
																$this->load->view('back/traffic_counter_details', $this->page_data);
															} elseif ($para1 == 'do_add') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('tollplaza', "Toll Plaza", 'required');
																$this->form_validation->set_rules('for_month', "Date", 'required');
																$this->form_validation->set_rules('timey', "Time", 'required');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$datetime = strtotime(str_replace('/', '-', $this->input->post('for_month')) . ' ' . $this->input->post('timey'));
																	$sql = "SELECT * FROM `traffic_counter` WHERE tollplaza = " . $this->input->post('tollplaza') . " AND " . $datetime . " between video_start_date and video_end_date";
																	$result = $this->db->query($sql)->result_array();

																	if ($result) {
																		echo json_encode(array('response' => FALSE, 'message' => 'Session of this date time already exists'));
																		exit;
																	}
																	$insert_data = array();
																	$insert_data['tollplaza'] = $this->input->post('tollplaza');
																	$insert_data['user_id'] = $this->session->userdata('member_id');
																	$insert_data['user_type'] = 2;
																	$insert_data['video_start_date'] = $datetime;
																	$insert_data['session_start_date'] = time();
																	$this->db->insert('traffic_counter', $insert_data);
																	$insert_id = $this->db->insert_id();

																	echo json_encode(array('response' => TRUE, 'message' => "Session started", 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'member/traffic_counting/session_start/' . $insert_id));
																	exit;
																}
															} else if ($para1 == 'traffic_add') {

																$values = json_decode($this->input->post('result'));
																$session_id = $this->input->post('session');
																$data[$values[0]->key] = $values[0]->value;
																$this->db->where('id', $session_id);
																$this->db->update('traffic_counter', $data);
															} elseif ($para1 == 'add') {
																$this->page_data['toolplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
																$this->load->view('front/member/counter_add', $this->page_data);
															} elseif ($para1 == 'update') {
																$this->page_data['session_id'] = $para2;
																$this->load->view('front/member/counter_update', $this->page_data);
															} elseif ($para1 == 'do_update') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('end_date', "Video end date", 'required');
																$this->form_validation->set_rules('end_time', "video end time", 'required');

																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$update_data = array();
																	$session_id = $this->input->post('session_id');
																	$video_start_date = $this->db->get_where('traffic_counter', array('id' => $session_id))->row()->video_start_date;
																	$datetime = strtotime(str_replace('/', '-', $this->input->post('end_date')) . ' ' . $this->input->post('end_time'));
																	if ($datetime <= $video_start_date) {
																		echo json_encode(array('response' => FALSE, 'message' => 'Invalid date time'));
																		exit;
																	}
																	$update_data['video_end_date'] = $datetime;
																	$update_data['session_end_date'] = time();
																	$this->db->where('id', $session_id);
																	$this->db->update('traffic_counter', $update_data);

																	echo json_encode(array('response' => TRUE, 'message' => "Session updated successfully", 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'member/traffic_counting/'));
																	exit;
																}
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('traffic_counter');
															} else {

																$this->page_data['page'] = 'traffic_counting';
																$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
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
														public function date_changer()
														{
															$count = 0;

															$dsr_updated = $this->db->order_by('id', 'ASC')->get('dsr_updated')->result_array();

															/*foreach($lanes as $lane){
			echo $lane['tollplaza'];echo '<br>';
		}
		*/


															$i = 0;
															foreach ($dsr_updated as $d) {
																$tool_id[$i]['id'] = $d['toolplaza_id'];
																$dsr_id = $d['id'];
																echo '##';
																$lanes[$i] = $this->db->order_by('id', 'ASC')->get_where('dsr_lane', array('dsr_id' => $d['id']))->result_array();
																$j = 0;
																foreach ($lanes[$i] as $lane) {
																	$data['toolplaza_id'] = $tool_id[$i]['id'];
																	echo $d['id'] . ' ' . $lane['lane_id'] . '<br>';
																	$this->db->where('dsr_id', $lane['dsr_id']);
																	$this->db->update('dsr_lane', $data);
																	$count++;
																	echo $lane['id'];
																	echo ' ';
																	echo $count;
																	$j++;
																}

																$i++;
															}/*?> <pre><?php echo print_r($lanes);*/
														}
														/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
														///////////////////////////////////////////   TOLL PLAZA LIVE DATA START HERE  /////////////////////////////////
														///////////////////////////////////////////////////////////////////////////////////////////////////////////////



														///////////////////////toll plaza Live data///////////////////////
														public function toll_plaza_report($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

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

															$query = $this->db->query($sql);

															$this->page_data['record'] = $query->result_array();
															//echo "<pre>";
															//print_r($this->page_data['record']); exit;
															$this->load->view('back/tollplaza_data', $this->page_data);
														}


														function get_tollplaza_data()
														{
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
															$query = $this->db->query($sql);

															echo json_encode($query->result_array());
														}

														///////////////Tollplaza Lanes///////////////////

														public function tollplaza_lanes($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['lanes'] = $this->db->get('tollplaza_lanes')->result_array();
																$this->load->view('back/tollplaza_lanes_list', $this->page_data);
															} elseif ($para1 == 'add') {
																$sql = "Select tollplaza_live.tollplaza_id,toolplaza.id,toolplaza.name FROM tollplaza_live JOIN toolplaza ON 
			tollplaza_live.tollplaza_id = toolplaza.id WHERE tollplaza_live.status = 1";

																$this->page_data['tollplaza'] = $this->db->query($sql)->result_array();
																$this->load->view('back/tollplaza_lanes_add', $this->page_data);
															} elseif ($para1 == 'do_add') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('tollplaza', 'Tollplaza', 'required|trim');
																$this->form_validation->set_rules('name', 'Lane', 'required|trim');
																$this->form_validation->set_rules('type', 'Lane Type', 'required|trim');
																$this->form_validation->set_rules('ip_address', 'Lane IP Address', 'required|trim|valid_ip');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$check = $this->db->get_where('tollplaza_lanes', array('toll_plaza' => $this->input->post('tollplaza'), 'ipaddress' => trim($this->input->post('ip_address'))))->result_array();
																	if ($check) {
																		echo json_encode(array('respose' => FALSE, 'message' => "Lane (IP Address) for this Tollplaza already exists"));
																		exit;
																	}

																	$insert_data = array();
																	$insert_data['toll_plaza'] = $this->input->post('tollplaza');
																	$insert_data['name'] = $this->input->post('name');
																	$insert_data['type'] = $this->input->post('type');
																	$insert_data['ipaddress'] = $this->input->post('ip_address');
																	$insert_data['date'] = time();
																	$this->db->insert('tollplaza_lanes', $insert_data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tollplaza_lanes'));
																	exit;
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['lane'] = $this->db->get_where('tollplaza_lanes', array('id' => $para2))->result_array();
																$sql = "Select tollplaza_live.tollplaza_id,toolplaza.id,toolplaza.name FROM tollplaza_live JOIN toolplaza ON 
			tollplaza_live.tollplaza_id = toolplaza.id WHERE tollplaza_live.status = 1";

																$this->page_data['tollplaza'] = $this->db->query($sql)->result_array();
																$this->load->view('back/tollplaza_lanes_edit', $this->page_data);
															} elseif ($para1 == 'do_update') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('tollplaza', 'Tollplaza', 'required|trim');
																$this->form_validation->set_rules('name', 'Lane', 'required|trim');
																$this->form_validation->set_rules('type', 'Lane Type', 'required|trim');
																$this->form_validation->set_rules('ip_address', 'Lane IP Address', 'required|trim|valid_ip');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$this->db->where('id !=', $para2);
																	$this->db->where('toll_plaza', $this->input->post('tollplaza'));
																	$this->db->where('ipaddress', trim($this->input->post('ip_address')));
																	$check = $this->db->get('tollplaza_lanes')->result_array();
																	if ($check) {
																		echo json_encode(array('respose' => FALSE, 'message' => "Lane (IP Address) for this Tollplaza already exists"));
																		exit;
																	}
																	$insert_data = array();
																	$insert_data['toll_plaza'] = $this->input->post('tollplaza');
																	$insert_data['name'] = $this->input->post('name');
																	$insert_data['type'] = $this->input->post('type');
																	$insert_data['ipaddress'] = $this->input->post('ip_address');
																	$insert_data['date'] = time();
																	$this->db->where('id', $para2);
																	$this->db->update('tollplaza_lanes', $insert_data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tollplaza_lanes'));
																	exit;
																}
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('tollplaza_lanes');
															} elseif ($para1 == 'tp_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('tollplaza_lanes', $data);
																echo $para3;
															} else {
																$this->page_data['page'] = 'Tollplaza_lanes';
																$this->load->view('back/tollplaza_lanes', $this->page_data);
															}
														}

														///////////////Tollplaza Lanes///////////////////

														public function tollplaza_live($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['tollplaza_live'] = $this->db->get('tollplaza_live')->result_array();
																$this->load->view('back/tollplaza_live_list', $this->page_data);
															} elseif ($para1 == 'add') {
																$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
																$this->load->view('back/tollplaza_live_add', $this->page_data);
															} elseif ($para1 == 'do_add') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('tollplaza', 'Tollplaza', 'required|trim');
																$this->form_validation->set_rules('services', 'Services', 'required|trim');
																$this->form_validation->set_rules('server_type', 'Server Type', 'required|trim');
																$this->form_validation->set_rules('type', 'Server Type', 'required|trim');
																$this->form_validation->set_rules('ip_address', 'Server IP Address', 'required|trim|valid_ip');
																$this->form_validation->set_rules('port', 'Server Port', 'required|trim');
																$this->form_validation->set_rules('username', 'Username', 'required|trim');
																$this->form_validation->set_rules('pwd', 'Password', 'required|trim');

																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
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
																	$this->db->insert('tollplaza_live', $insert_data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tollplaza_live'));
																	exit;
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['tollplaza_live'] = $this->db->get_where('tollplaza_live', array('id' => $para2))->result_array();
																$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
																$this->load->view('back/tollplaza_live_edit', $this->page_data);
															} elseif ($para1 == 'do_update') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('tollplaza', 'Tollplaza', 'required|trim');
																$this->form_validation->set_rules('services', 'Services', 'required|trim');
																$this->form_validation->set_rules('server_type', 'Server Type', 'required|trim');
																$this->form_validation->set_rules('type', 'Server Type', 'required|trim');
																$this->form_validation->set_rules('ip_address', 'Server IP Address', 'required|trim|valid_ip');
																$this->form_validation->set_rules('port', 'Server Port', 'required|trim');
																$this->form_validation->set_rules('username', 'Username', 'required|trim');
																$this->form_validation->set_rules('pwd', 'Password', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
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
																	$this->db->where('id', $para2);
																	$this->db->update('tollplaza_live', $insert_data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/tollplaza_live'));
																	exit;
																}
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('tollplaza_live');
															} elseif ($para1 == 'tp_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('tollplaza_live', $data);
																echo $para3;
															} else {
																$this->page_data['page'] = 'Tollplaza_live';
																$this->load->view('back/tollplaza_live', $this->page_data);
															}
														}
														/*public function dsr_lane_closed_transfer_data(){
		$dsr_lane = $this->db->select('id,lane_closed,lane_closed_from,lane_closed_to,lane_closed_description')->from('dsr_lane')->where(array('lane_status' => 1))->get()->result_array();
		$i = 0;
		foreach($dsr_lane as $lane){
			$data[$i]['dsr_lane'] = $lane['id'];
			$data[$i]['closed_by'] = $lane['lane_closed'];
			$data[$i]['closed_from'] = $lane['lane_closed_from'];
			$data[$i]['closed_to'] = $lane['lane_closed_to'];
			$data[$i]['description'] = $lane['lane_closed_description'];
			$i++;
		}
		?> <pre><?php echo print_r($data);exit;
	}*/

														////////////////////////////////////////////////////////////////////////
														/////////////////////////Routes Start Here//////////////////////////////
														////////////////////////////////////////////////////////////////////////


														public function routes($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {

																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['routes'] = $this->db->get('routes')->result_array();
																$this->load->view('back/routes_list', $this->page_data);
															} elseif ($para1 == 'add') {
																$this->load->view('back/routes_add', $this->page_data);
															} elseif ($para1 == 'do_add') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('title', 'Route Name', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$insert = $this->Admin_model->add_route($post);
																	if ($insert) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Added successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/routes'));
																		exit;
																	}
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['route'] = $this->db->get_where('routes', array('id' => $para2))->result_array();
																$this->load->view('back/route_edit', $this->page_data);
															} elseif ($para1 == 'do_update') {

																$this->load->library('form_validation');
																$this->form_validation->set_rules('title', 'Route Name', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$post = $this->input->post();
																	$id = $para2;
																	$update = $this->Admin_model->update_route($id, $post);
																	if ($update) {
																		echo json_encode(array('response' => TRUE, 'message' => 'Updated successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/routes'));
																		exit;
																	} else {
																		echo json_encode(array('response' => FALSE, 'message' => 'Invalid Request'));
																		exit;
																	}
																}
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('routes');
															} else {
																$this->page_data['page'] = 'Routes';
																$this->load->view('back/routes', $this->page_data);
															}
														}
														// to transfer dsr from version 1 to version 2
														public function dsr_main_transfer_data()
														{
															$this->load->model('older_to_newer');
															$this->older_to_newer->DSR_main_transfer();
														}
														///////////////////////////////////////////////////////////////
														////	/** Weigh Company START  *////////////////////
														///////////////////////////////////////////////////////////////

														public function WeighCompany($para1 = '', $para2 = '', $para3 = '')
														{
															if (!$this->session->userdata('adminid')) {
																return redirect('admin/login');
															}
															if ($para1 == 'list') {
																$this->page_data['weigh_users'] = $this->db->get('weigh_company')->result_array();
																$this->load->view('back/WeighUsers/WeighstationUsersList', $this->page_data);
															} elseif ($para1 == 'delete') {
																$this->db->where('id', $para2);
																$this->db->delete('weigh_company');
															} elseif ($para1 == 'tp_publish_set') {
																$article = $para2;
																if ($para3 == 'true') {
																	$data['status'] = '1';
																} else {
																	$data['status'] = '0';
																}
																$this->db->where('id', $article);
																$this->db->update('omc', $data);

																echo $para3;
															} elseif ($para1 == 'add') {
																$this->page_data['toolplaza'] = $this->Admin_model->getSites();
																$this->load->view('back/WeighUsers/add_weighuser', $this->page_data);
															} elseif ($para1 == 'add_do') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('sur_name', 'Name', 'required|trim');
																$this->form_validation->set_rules('username', 'User Name', 'required|trim');
																$this->form_validation->set_rules('Password', 'Password', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$data  = array();
																	$data['name'] 	= $this->input->post('sur_name');
																	$data['username'] 	= $this->input->post('username');
																	$data['weigh_company'] 	= $this->input->post('company');
																	$data['password'] 	= $this->input->post('Password');
																	$data['status'] = 0;
																	$data['add_date'] 	= time();
																	$this->db->insert('weigh_company', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Added Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/WeighCompany'));
																	exit;
																}
															} elseif ($para1 == 'edit') {
																$this->page_data['weigh_company'] = $this->db->get_where('weigh_company', array('id' => $para2))->result_array();
																$this->load->view('back/WeighUsers/edit_weighuser', $this->page_data);
															} elseif ($para1 == 'update') {
																$this->load->library('form_validation');
																$this->form_validation->set_rules('sur_name', 'Name', 'required|trim');
																$this->form_validation->set_rules('username', 'User Name', 'required|trim');
																$this->form_validation->set_rules('Password', 'Password', 'required|trim');
																if ($this->form_validation->run() == FALSE) {
																	echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																	exit;
																} else {
																	$data  = array();
																	$data['name'] 	= $this->input->post('sur_name');
																	$data['username'] 	= $this->input->post('username');
																	$data['weigh_company'] 	= $this->input->post('company');
																	$data['password'] 	= $this->input->post('Password');
																	$data['status'] = 0;
																	$data['add_date'] 	= time();
																	$this->db->where('id', $para2);
																	$this->db->update('weigh_company', $data);
																	echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/WeighCompany'));
																	exit;
																}
															} else {
																$this->page_data['page'] = 'Weigh Users';
																$this->load->view('back/WeighUsers/WeighstationUsers', $this->page_data);
															}
														}
														public function weigh_password($para1 = '')
														{
															if (!$para1) {
																echo '<div class="alert alert-dismissible alert-danger">
  				<button type="button" class="close" data-dismiss="alert">&times;</button>
  				<strong>OOPS!</strong> Invalid Request
				</div>';
																exit;
															}
															$this->page_data['weigh_id'] = $this->db->get_where('weigh_company', array('id' => $para1))->row()->id;
															$this->load->view('back/WeighUsers/weigh_password', $this->page_data);
														}
														public function update_weigh_password($weigh_id = '')
														{
															if (!$this->session->userdata('adminid')) {
																echo json_encode(array('respose' => FALSE, 'message' => "Please Login to continue"));
																exit;
															}
															if (!$weigh_id) {
																echo json_encode(array('response' => TRUE, 'message' => 'Invalid Request'));
																exit;
															}
															$this->load->library('form_validation');
															$this->form_validation->set_rules('password', 'Password', 'required|trim');
															$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
															if ($this->form_validation->run() == TRUE) {
																$data = array(
																	'password' 	=> sha1($this->input->post('password'))
																);
																$this->db->where('id', $weigh_id);
																$this->db->update('weigh_company', $data);
																echo json_encode(array('response' => TRUE, 'message' => 'Updated Successfully', 'is_redirect' => TRUE, 'redirect_url' => base_url() . 'admin/WeighCompany'));
																exit;
															} else {
																echo json_encode(array('respose' => FALSE, 'message' => validation_errors()));
																exit;
															}
														}

														/** Traffic Counting Entry Start */
														public function Traffic_View($para1 = '', $para2 = '')
														{
															if ($para1 == 'list') {
																$this->db->order_by('id', 'DESC');
																$this->page_data['counter']  = $this->db->get('traffic_counting')->result_array();
																$this->load->view('back/traffic_view_list', $this->page_data);
															} elseif ($para1 == 'view') {
																$this->page_data['session'] = $this->db->get_where('traffic_counting', array('id' => $para2))->result_array();
																$this->load->view('back/traffic_entry_details', $this->page_data);
															} elseif ($para1 == 'print_view') {
																$this->page_data['counting'] = $this->db->get_where('traffic_counting', array('id' => $para2))->result_array();
																$site = $this->db->get_where('toolplaza', array('id' => $this->page_data['counting'][0]['site_id']))->result_array();
																$this->page_data['plaza_name'] = $site[0]['name'];
																if ($this->page_data['counting'][0]['bound'] == 1) {
																	$this->page_data['bound'] = 'North';
																}
																if ($this->page_data['counting'][0]['bound'] == 2) {
																	$this->page_data['bound'] = 'South';
																}

																$this->load->view('back/print_view', $this->page_data);
															} else {
																$this->page_data['page'] = 'traffic_entry';
																$this->page_data['tollplaza'] = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
																$this->load->view('back/traffic_view', $this->page_data);
															}
														}
														/** Traffic Counting Entry End */
													}
