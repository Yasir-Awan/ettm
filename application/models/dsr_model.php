<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dsr_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
		date_default_timezone_set('Asia/Karachi');
	}
		


		
	public function dsr_tool($tool){
		$dsr_data = db()->select('*')->from('dsr_updated as dsr')->where(array('dsr.toolplaza_id' => $tool, 'dsr.datecreated' => date('Y-m-d',time())))->join('dsr_status as dsr1', 'dsr.id = dsr1.id')->join('dsr_doc as dsr2', 'dsr.id = dsr2.id')->get()->result_array();
		foreach($dsr_data as $dsr){
			$dsr_lane= db()->get_where('dsr_lane', array('dsr_id' => $dsr['id']))->result_array();
			$number = 0;
			$dsr_attendance = db()->get_where('dsr_attendance', array('dsr_id' => $dsr['id']))->result_array();
			foreach($dsr_lane as $lane){
				$dsr_data[0]['lane'][$number]['name'] = db()->get_where('tp_lanes',array('id' => $lane['lane_id']))->row()->name;
					$dsr_data[0]['lane'][$number]['lane_status'] = $lane['lane_status'];
					$dsr_data[0]['lane'][$number]['lane_closed'] = $lane['lane_closed'];
					$dsr_data[0]['lane'][$number]['lane_closed_from'] = $lane['lane_closed_from'];
					$dsr_data[0]['lane'][$number]['lane_closed_to'] = $lane['lane_closed_to'];
					$dsr_data[0]['lane'][$number]['lane_closed_description'] = $lane['lane_closed_description'];
					$dsr_data[0]['lane'][$number]['lane_camera_status'] = $lane['lane_camera_status'];
					$dsr_data[0]['lane'][$number]['lane_camera_faulty_description'] = $lane['lane_camera_faulty_description'];
					$dsr_data[0]['lane'][$number]['inventory_ohls_status'] = $lane['inventory_ohls_status'];
					$dsr_data[0]['lane'][$number]['inventory_boom_arm_status'] = $lane['inventory_boom_arm_status'];
					$dsr_data[0]['lane'][$number]['inventory_boom_mechanical_status'] = $lane['inventory_boom_mechanical_status'];
					$dsr_data[0]['lane'][$number]['inventory_thermal_printer_status'] = $lane['inventory_thermal_printer_status'];
					$dsr_data[0]['lane'][$number]['inventory_tct_status'] = $lane['inventory_tct_status'];
					$dsr_data[0]['lane'][$number]['inventory_lanepc_status'] = $lane['inventory_lanepc_status'];
					$dsr_data[0]['lane'][$number]['inventory_traffic_light_status'] = $lane['inventory_traffic_light_status'];
					$dsr_data[0]['lane'][$number]['inventory_pfd_status'] = $lane['inventory_pfd_status'];
					$dsr_data[0]['lane'][$number]['inventory_ohls_description'] = $lane['inventory_ohls_description'];
					$dsr_data[0]['lane'][$number]['inventory_boom_arm_description'] = $lane['inventory_boom_arm_description'];
					$dsr_data[0]['lane'][$number]['inventory_boom_mechanical_description'] = $lane['inventory_boom_mechanical_description'];
					$dsr_data[0]['lane'][$number]['inventory_thermal_printer_description'] = $lane['inventory_thermal_printer_description'];
					$dsr_data[0]['lane'][$number]['inventory_tct_description'] = $lane['inventory_tct_description'];
					$dsr_data[0]['lane'][$number]['inventory_lanepc_description'] = $lane['inventory_lanepc_description'];
					$dsr_data[0]['lane'][$number]['inventory_traffic_light_description'] = $lane['inventory_traffic_light_description'];
					$dsr_data[0]['lane'][$number]['inventory_pfd_description'] = $lane['inventory_pfd_description'];
					$number++;
			}
			$number = 0;
				foreach($dsr_attendance as $attendance){
					$dsr_data[0]['attendance'][$number]['fname'] = db()->get_where('tpstaff',array('id' => $attendance['staff_id']))->row()->fname;
					$dsr_data[0]['attendance'][$number]['lname'] = db()->get_where('tpstaff',array('id' => $attendance['staff_id']))->row()->lname;
					$dsr_data[0]['attendance'][$number]['attendance_status'] = $attendance['attendance_status'];
					$dsr_data[0]['attendance'][$number]['leave_from'] = $attendance['leave_from'];
					$dsr_data[0]['attendance'][$number]['leave_to'] = $attendance['leave_to'];
					$number++;
				}
		}

		return array($dsr_data);
	}
	//This function is created to check whether the dsr of the parameter date is already present in the database or not
	public function dsr_date_checker($date, $tool){
		$dsr_date = $this->db->get_where('dsr_updated', array('datecreated' => $date,'toolplaza_id' => $tool))->result_array();
		
		return $dsr_date;
	}
	public function dsr_data($id, $tool, $edit,$para2){
		
		//Data is extracted in variable $dsr_data 
		$dsr_generator_log =  db()->get_where('dsr_generator_log', array('id' => $para2))->result_array();
		if($dsr_generator_log){
			$dsr_data = db()->select('*')->from('dsr_updated as dsr')->where(array('dsr.id' => $para2, 'dsr.supervisor_id' => $id))->join('dsr_status as dsr1', 'dsr.id = dsr1.id')->join('dsr_doc as dsr2', 'dsr.id = dsr2.id')->join('dsr_generator_log as dsr3', 'dsr.id = dsr3.id')->get()->result_array();
		}
		if(!$dsr_generator_log){
			$dsr_data = db()->select('*')->from('dsr_updated as dsr')->where(array('dsr.id' => $para2, 'dsr.supervisor_id' => $id))->join('dsr_status as dsr1', 'dsr.id = dsr1.id')->join('dsr_doc as dsr2', 'dsr.id = dsr2.id')->get()->result_array();
		}
				
				$lane_dsr = db()->get_where('dsr_lane', array('dsr_id' => $para2));
				$dsr_lane = $lane_dsr->result_array();
				/*?> <pre><?php echo print_r($dsr_data) ?> </pre><?php exit;*/
				$number = 0;
				$dsr_attendance = db()->get_where('dsr_attendance', array('dsr_id' => $para2))->result_array();
				foreach($dsr_lane as $lane){
					/*echo $lane['lane_id'];*/
					 $dsr_data[0]['lane'][$number]['name'] = db()->get_where('tp_lanes',array('id' => $lane['lane_id']))->row()->name;
					$dsr_data[0]['lane'][$number]['lane_status'] = $lane['lane_status'];
					$dsr_data[0]['lane'][$number]['lane_closed'] = $lane['lane_closed'];
					$dsr_data[0]['lane'][$number]['lane_closed_from'] = $lane['lane_closed_from'];
					$dsr_data[0]['lane'][$number]['lane_closed_to'] = $lane['lane_closed_to'];
					$dsr_data[0]['lane'][$number]['lane_closed_description'] = $lane['lane_closed_description'];
					$dsr_data[0]['lane'][$number]['lane_camera_status'] = $lane['lane_camera_status'];
					$dsr_data[0]['lane'][$number]['lane_camera_faulty_description'] = $lane['lane_camera_faulty_description'];
					$dsr_data[0]['lane'][$number]['inventory_ohls_status'] = $lane['inventory_ohls_status'];
					$dsr_data[0]['lane'][$number]['inventory_boom_arm_status'] = $lane['inventory_boom_arm_status'];
					$dsr_data[0]['lane'][$number]['inventory_boom_mechanical_status'] = $lane['inventory_boom_mechanical_status'];
					$dsr_data[0]['lane'][$number]['inventory_thermal_printer_status'] = $lane['inventory_thermal_printer_status'];
					$dsr_data[0]['lane'][$number]['inventory_tct_status'] = $lane['inventory_tct_status'];
					$dsr_data[0]['lane'][$number]['inventory_lanepc_status'] = $lane['inventory_lanepc_status'];
					$dsr_data[0]['lane'][$number]['inventory_traffic_light_status'] = $lane['inventory_traffic_light_status'];
					$dsr_data[0]['lane'][$number]['inventory_pfd_status'] = $lane['inventory_pfd_status'];
					$dsr_data[0]['lane'][$number]['inventory_ohls_description'] = $lane['inventory_ohls_description'];
					$dsr_data[0]['lane'][$number]['inventory_boom_arm_description'] = $lane['inventory_boom_arm_description'];
					$dsr_data[0]['lane'][$number]['inventory_boom_mechanical_description'] = $lane['inventory_boom_mechanical_description'];
					$dsr_data[0]['lane'][$number]['inventory_thermal_printer_description'] = $lane['inventory_thermal_printer_description'];
					$dsr_data[0]['lane'][$number]['inventory_tct_description'] = $lane['inventory_tct_description'];
					$dsr_data[0]['lane'][$number]['inventory_lanepc_description'] = $lane['inventory_lanepc_description'];
					$dsr_data[0]['lane'][$number]['inventory_traffic_light_description'] = $lane['inventory_traffic_light_description'];
					$dsr_data[0]['lane'][$number]['inventory_pfd_description'] = $lane['inventory_pfd_description'];
					$number++;
				}
				$number = 0;
				
					foreach($dsr_attendance as $attendance){

						$dsr_data[0]['attendance'][$number]['fname'] = db()->get_where('tpstaff',array('id' => $attendance['staff_id']))->row()->fname;
						$dsr_data[0]['attendance'][$number]['lname'] = db()->get_where('tpstaff',array('id' => $attendance['staff_id']))->row()->lname;
						$dsr_data[0]['attendance'][$number]['attendance_status'] = $attendance['attendance_status'];
						$dsr_data[0]['attendance'][$number]['leave_from'] = $attendance['leave_from'];
						$dsr_data[0]['attendance'][$number]['leave_to'] = $attendance['leave_to'];$number++;				
					}
				/*?> <pre> <?php echo print_r($dsr_data) ?></pre><?php exit;*/
				//Defining variables which relate to older DSR table which are used extensively in edit and add DSR pages.
				$dsr[0]['id'] = $dsr_data[0]['id'];

				$dsr[0]['toolplaza_id'] = $dsr_data[0]['toolplaza_id'];
				$dsr[0]['toolplaza_name'] = db()->get_where('toolplaza',array('id' => $tool))->row()->name; 
				$dsr[0]['supervisor_id'] = $dsr_data[0]['supervisor_id'];
				$dsr[0]['supervisor_name'] = db()->get_where('tpsupervisor',array('id' => $id))->row()->fname.' '.db()->get_where('tpsupervisor',array('id' => $id))->row()->lname;
				$dsr[0]['supervisor_contact'] = db()->get_where('tpsupervisor',array('id' => $id))->row()->contact;
				$dsr[0]['datecreated'] = $dsr_data[0]['datecreated'];
				$dsr[0]['omc'] = $dsr_data[0]['omc'];
				$dsr[0]['site_lsdu'] = $dsr_data[0]['status_lsdu'];
				$dsr[0]['site_dt'] = $dsr_data[0]['daily_traffic'];
				$dsr[0]['site_dr'] = $dsr_data[0]['daily_revenue'];
				$dsr[0]['frame'] = $dsr_data[0]['status_framegrabber'];
				$dsr[0]['image'] = $dsr_data[0]['image_status'];
				$dsr[0]['shutdown'] = $dsr_data[0]['status_shutdown'];
				$dsr[0]['shut_from'] = $dsr_data[0]['time_shut_from'];
				$dsr[0]['shut_to'] = $dsr_data[0]['time_shut_to'];
				$dsr[0]['mtrstatus'] = $dsr_data[0]['mtr_status'];
				$dsr[0]['apmtr'] = $dsr_data[0]['mtr_pending'];
				$dsr[0]['asmtr'] = $dsr_data[0]['mtr_archiving_status'];
				$dsr[0]['mtrupto'] = $dsr_data[0]['mtr_upto'];
				$dsr[0]['serverstatus'] = $dsr_data[0]['status_server'];
				$dsr[0]['ptzstatus1'] = $dsr_data[0]['ptz_north_status'];
				$dsr[0]['ptzfc_desc1'] = $dsr_data[0]['ptz_north_description'];
				$dsr[0]['ptzstatus2'] = $dsr_data[0]['ptz_south_status'];
				$dsr[0]['ptzfc_desc2'] = $dsr_data[0]['ptz_south_description'];
				$dsr[0]['linkissue'] = $dsr_data[0]['status_link'];
				$dsr[0]['lissue_desc'] = $dsr_data[0]['status_link_description'];
				$dsr[0]['pcbuilding'] = $dsr_data[0]['status_building'];
				$dsr[0]['pccleaning'] = $dsr_data[0]['status_cleaning'];
				$dsr[0]['pcreceipts'] = $dsr_data[0]['status_reciepts'];
				$dsr[0]['pcmeal'] = $dsr_data[0]['status_meal'];
				$dsr[0]['pcwater'] = $dsr_data[0]['status_water'];
				$dsr[0]['pcqueuing'] = $dsr_data[0]['status_queuing'];
				$dsr[0]['pcelectricity'] = $dsr_data[0]['status_electricity'];
				$dsr[0]['ecause'] = $dsr_data[0]['faulty_electricity_cause'];
				$dsr[0]['ereason'] = $dsr_data[0]['faulty_electricity_reason'];
				$dsr[0]['asrg'] = $dsr_data[0]['asrg'];
				$dsr[0]['refno'] = $dsr_data[0]['asrg_reference_no'];
				$dsr[0]['refduration'] = $dsr_data[0]['asrg_date'];
				$dsr[0]['asrg_detail'] = $dsr_data[0]['asrg_detail'];
				$dsr[0]['status'] = $dsr_data[0]['status'];
				$dsr[0]['disapprove_reason'] = $dsr_data[0]['disapprove_reason'];
			$dsr[0]['dsr_generator_log'] = $dsr_generator_log;
				if($dsr_generator_log){
						$dsr[0]['load_from'] = $dsr_data[0]['load_from'];
						$dsr[0]['load_to'] = $dsr_data[0]['load_to'];
						$dsr[0]['load_time'] = $dsr_data[0]['load_time'];
						$dsr[0]['generator_from'] = $dsr_data[0]['generator_from'];
						$dsr[0]['generator_to'] = $dsr_data[0]['generator_to'];
						$dsr[0]['generator_time'] = $dsr_data[0]['generator_time'];

						$dsr[0]['diesel_per_hour'] = $dsr_data[0]['diesel_per_hour'];
						$dsr[0]['diesel_consumed'] = $dsr_data[0]['diesel_consumed'];
						$dsr[0]['output_voltage'] = $dsr_data[0]['output_voltage'];

						$dsr[0]['fuel_level'] = $dsr_data[0]['fuel_level'];
						$dsr[0]['oil_level'] = $dsr_data[0]['oil_level'];
						$dsr[0]['oil_change'] = $dsr_data[0]['oil_change'];
						$dsr[0]['radiator_water_level'] = $dsr_data[0]['radiator_water_level'];
						$dsr[0]['battery_water_level'] = $dsr_data[0]['battery_water_level'];
						$dsr[0]['battery_terminal_condition'] = $dsr_data[0]['battery_terminal_condition'];


				}
				if(!$dsr_generator_log){
						$dsr[0]['log_status'] = 'No DSR Generated';
						$dsr[0]['load_from'] = '';
						$dsr[0]['load_to'] = '';
						$dsr[0]['load_time'] = '';
						$dsr[0]['generator_from'] = '';
						$dsr[0]['generator_to'] = '';
						$dsr[0]['generator_time'] = '';

						$dsr[0]['diesel_per_hour'] = '';
						$dsr[0]['diesel_consumed'] = '';
						$dsr[0]['output_voltage'] = '';

						$dsr[0]['fuel_level'] = '';
						$dsr[0]['oil_level'] = '';
						$dsr[0]['oil_change'] = '';
						$dsr[0]['radiator_water_level'] = '';
						$dsr[0]['battery_water_level'] = '';
						$dsr[0]['battery_terminal_condition'] = '';


				}
				//Defined Variable to load the north and south lanes from DSR as used in view
				$number = 0; $count = 0;
				
				foreach($edit['north'] as $n){				
					$number++;
					
					$dsr[0]['nlanestatus'.$number] = $dsr_data[0]['lane'][$count]['lane_status'];
					$dsr[0]['nlclosed'.$number] = $dsr_data[0]['lane'][$count]['lane_closed'];	
					$dsr[0]['nlclosed_from'.$number] = $dsr_data[0]['lane'][$count]['lane_closed_from'];
					$dsr[0]['nlclosed_to'.$number] = $dsr_data[0]['lane'][$count]['lane_closed_to'];
					$dsr[0]['nlclosed_description'.$number] = $dsr_data[0]['lane'][$count]['lane_closed_description'];
					$dsr[0]['ncstatus'.$number] = $dsr_data[0]['lane'][$count]['lane_camera_status'];	
					$dsr[0]['nfc_desc'.$number] = $dsr_data[0]['lane'][$count]['lane_camera_faulty_description'];
					$dsr[0]['nohlsstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_ohls_status'];
					$dsr[0]['nboomarmstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_boom_arm_status'];
					$dsr[0]['nboommechstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_boom_mechanical_status'];
					$dsr[0]['ntprinterstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_thermal_printer_status'];
					$dsr[0]['ntctstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_tct_status'];
					$dsr[0]['nlanepcstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_lanepc_status'];
					$dsr[0]['ntlightstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_traffic_light_status'];
					$dsr[0]['npfdstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_pfd_status'];
					$dsr[0]['nohlsdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_ohls_description'];
					$dsr[0]['nboomarmdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_boom_arm_description'];
					$dsr[0]['nboommechdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_boom_mechanical_description'];
					$dsr[0]['ntprinterdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_thermal_printer_description'];
					$dsr[0]['ntctdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_tct_description'];
					$dsr[0]['nlanepcdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_lanepc_description'];
					$dsr[0]['ntlightdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_traffic_light_description'];
					$dsr[0]['npfddesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_pfd_description'];
					/*?> <pre><?php echo print_r($n);	*/
					$count++;
				}
				$number = 0; 
				foreach($edit['south'] as $s){				
					$number++;

					$dsr[0]['slanestatus'.$number] = $dsr_data[0]['lane'][$count]['lane_status'];;
					$dsr[0]['slclosed'.$number] = $dsr_data[0]['lane'][$count]['lane_closed'];;
					$dsr[0]['slclosed_from'.$number] = $dsr_data[0]['lane'][$count]['lane_closed_from'];;
					$dsr[0]['slclosed_to'.$number] = $dsr_data[0]['lane'][$count]['lane_closed_to'];
					$dsr[0]['slclosed_description'.$number] = $dsr_data[0]['lane'][$count]['lane_closed_description'];
					$dsr[0]['scstatus'.$number] = $dsr_data[0]['lane'][$count]['lane_camera_status'];
					$dsr[0]['sfc_desc'.$number] = $dsr_data[0]['lane'][$count]['lane_camera_faulty_description'];
					$dsr[0]['sohlsstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_ohls_status'];
					$dsr[0]['sboomarmstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_boom_arm_status'];
					$dsr[0]['sboommechstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_boom_mechanical_status'];
					$dsr[0]['stprinterstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_thermal_printer_status'];
					$dsr[0]['stctstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_tct_status'];
					$dsr[0]['slanepcstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_lanepc_status'];
					$dsr[0]['stlightstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_traffic_light_status'];
					$dsr[0]['spfdstatus'.$number] = $dsr_data[0]['lane'][$count]['inventory_pfd_status'];
					$dsr[0]['sohlsdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_ohls_description'];
					$dsr[0]['sboomarmdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_boom_arm_description'];
					$dsr[0]['sboommechdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_boom_mechanical_description'];
					$dsr[0]['stprinterdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_thermal_printer_description'];
					$dsr[0]['stctdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_tct_description'];
					$dsr[0]['slanepcdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_lanepc_description'];
					$dsr[0]['stlightdesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_traffic_light_description'];
					$dsr[0]['spfddesc'.$number] = $dsr_data[0]['lane'][$count]['inventory_pfd_description'];
					
					$count++;
				}
				$number = 0; $count = 0;
				foreach($edit['staff'] as $staff){
					$number++;
					if($dsr_data[0]['attendance'][$count]){
						$dsr[0]['staff_'.$number] = $dsr_data[0]['attendance'][$count]['fname'].' '.$dsr_data[0]['attendance'][$count]['lname'];
						$dsr[0]['as'.$number.'status'] = $dsr_data[0]['attendance'][$count]['attendance_status'];
						$dsr[0]['as'.$number.'holidayfrom'] = $dsr_data[0]['attendance'][$count]['leave_from'];
						$dsr[0]['as'.$number.'holidayto'] = $dsr_data[0]['attendance'][$count]['leave_to'];
						
						$dsr_staff_attendance[$count]['name'] = $dsr_data[0]['attendance'][$count]['fname'].' '.$dsr_data[0]['attendance'][$count]['lname'];
						$dsr_staff_attendance[$count]['as_status'] = $dsr_data[0]['attendance'][$count]['attendance_status'];
						$dsr_staff_attendance[$count]['as_holidayfrom'] = $dsr_data[0]['attendance'][$count]['leave_from'];
						$dsr_staff_attendance[$count]['as_holidayto'] = $dsr_data[0]['attendance'][$count]['leave_to'];

						$count++;
					}


				}
				return array('dsr' => $dsr, 'dsr_attendance' => $dsr_attendance, 'dsr_staff' => $dsr_staff_attendance, 'dsr_lane' => $dsr_lane);
	}
	public function sitereport_data_preload($id, $tool, $page, $para1){
		if($page == 'U'){
			$edit['north'] = $this->db->get_where('tp_lanes', array('bound' => 'N', 'tollplaza' => $tool) )->result_array();
			$edit['south'] = $this->db->get_where('tp_lanes', array('bound' => 'S', 'tollplaza' => $tool) )->result_array();
			$edit['staff'] = $this->db->get_where('dsr_attendance', array('dsr_id' => $para1))->result_array();
			$edit['check'] = $this->db->get_where('dsr_updated', array('id' => $para1,'supervisor_id' => $id))->result_array();
			$edit['dsr_generator_log'] = $this->db->get_where('dsr_generator_log', array('id' => $para1))->result_array();
			$edit['dsr_updated_check'] = $this->db->get_where('dsr_updated', array('id' => $para1,'supervisor_id' => $id))->result_array();
		}
		elseif($page == 'R'){
			$edit['north'] = $this->db->get_where('dsr_lane', array('bound' => 'N','dsr_id' => $para1))->result_array();
			$edit['south'] = $this->db->get_where('dsr_lane', array('bound' => 'S','dsr_id' => $para1))->result_array();
			$edit['staff'] = $this->db->get_where('dsr_attendance', array('dsr_id' => $para1))->result_array();
		}
		elseif($page == 'C'){
			$edit['north'] = $this->db->get_where('tp_lanes', array('bound' => 'N', 'tollplaza' => $tool))->result_array();
			$edit['south'] = $this->db->get_where('tp_lanes', array('bound' => 'S', 'tollplaza' => $tool) )->result_array();
			$edit['staff'] = $this->db->get_where('tpstaff', array('tollplaza' => $tool, 'status' => 1))->result_array();
		}
		$edit['toolplaza'] = $this->db->get_where('toolplaza',array('id' => $tool))->row()->name;
				
		$edit['plaza_name'] = $this->db->get_where('toolplaza',array('id' => $tool))->row()->name;
		$edit['phone']		= $this->db->get_where('tpsupervisor', array('id' => $id))->row()->contact;
		$edit['supervisor_id'] = $id;
		$edit['supervisor_name'] = $this->db->get_where('tpsupervisor', array('id' => $id))->row()->fname.' '.$this->db->get_where('tpsupervisor', array('id' => $id))->row()->lname;
		$edit['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
		return $edit;
	}
	public function sitereport_data_post($edit){
		$edit['omc_name']   = $this->db->get_where('omc',array('id' => $edit['dsr'][0]['omc']))->row()->name;
		$edit['date']		= $edit['dsr'][0]['datecreated'];
		$edit['supervisor_id'] = $edit['dsr'][0]['supervisor_id'];
		
		
		return $edit;
	}
	public function list_dsr($id, $tool){
		// $this->db->order_by('id','DESC');
		// if($id && $tool){
		// 	$this->db->where('toolplaza_id', $tool);
		// 	$this->db->where('supervisor_id', $id);
		// }
		// if($tool){
		// 	$this->db->where('toolplaza_id', $tool);
		// }
		// $dsr = $this->db->get('dsr_updated')->result_array();
		
		$dsr = $this->db->query('CALL list_dsr(\''.$id.'\',\''.$tool.'\')')->result_array();
		$this->db->next_result();
		return $dsr; 
	}
	public function delete_dsr($id, $para2){
		
		

		$this->db->where('id', $para2);
		$dlt1 = $this->db->delete('dsr_updated');

		$this->db->where('dsr_id', $para2);
		$dlt2 = $this->db->delete('dsr_lane');

		$this->db->where('dsr_id', $para2);
		$dlt3 = $this->db->delete('dsr_attendance');

		$this->db->where('id', $para2);
		$dlt3 = $this->db->delete('dsr_doc');

		$this->db->where('id', $para2);
		$dlt3 = $this->db->delete('dsr_status');	
	}
	public function insert_dsr($table, $data){
		$this->db->limit(1);					
		$datadsr = $this->db->insert($table, $data);
		return true;
	}
	public function retrieve_last($table, $order_by){
		$data = $this->db->limit(1)->order_by($order_by, 'DESC')->get($table)->result_array();
		return $data;
	}
	public function update_dsr($where, $para2, $table, $data){
		$this->db->limit(1);
		$this->db->where($where, $para2);
		$upd = $this->db->update($table, $data);
		return $upd;
	}
	public function loop_update_dsr($where, $table, $data){
		$this->db->limit(1);
		$this->db->where($where);
		$upd = $this->db->update($table, $data);
		return $upd;
	}
	public function get_where($table, $where){
		$data = $this->db->get_where($table, $where)->result_array();
		return $data;
	}
	public function list_dsr_limit($id, $tool, $limit){
		// $this->db->order_by('id','DESC');
		// $this->db->limit($limit);
		// if($id && $tool){
		// 	$this->db->where('toolplaza_id', $tool);
		// 	$this->db->where('supervisor_id', $id);
		// }
		// if($tool){
		// 	$this->db->where('toolplaza_id', $tool);
		// }
		// $dsr = $this->db->get('dsr_updated')->result_array();
		$dsr = $this->db->query('CALL list_dsr_limit(\''.$id.'\',\''.$tool.'\',\''.$limit.'\')')->result_array();
		$this->db->next_result();
		return $dsr; 
	}
	
}