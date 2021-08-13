<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class older_to_newer extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
		//date_default_timezone_set('Asia/Karachi');
	}
	public function DSR_lane_inventory_transfer(){
		$dsr_lane = $this->db->get('dsr_lane')->result_array();
		$inventory = $this->db->get_where('dsr_inventory', array('installed_at' => 3, 'status' => 1))->result_array();
		$i = 0; $data = array();
		foreach($dsr_lane as $lane){
			$j = 0; 
			foreach($inventory as $invent){	
				$data['dsr_lane'] = $lane['id'];			
				$data['dsr_inventory'] = $invent['id'];
				if($lane['inventory_'.$invent['name'].'_status'] != NULL){
					$data['status'] = $lane['inventory_'.$invent['name'].'_status'];
					$data['description'] = $lane['inventory_'.$invent['name'].'_description'];
					$table = 'm2m_dsr_lane_inventory_description';
					$data_dsr_lane = $this->dsr_model->insert_dsr($table, $data);
				}
				echo 'dsr_lane = '.$i.' dsr_inventory = '.$j.'<br>';
				$j++;
			}
			$i++;
		}
	}
	public function DSR_lane_inventory_alter(){
		$m2m = $this->db->get_where('m2m_dsr_lane_inventory_description', array('dsr_inventory' => 9))->result_array();
		$i = 0;
		foreach($m2m as $m){
			if($m['status'] == 0){
				$data['status'] = 1;
				$this->db->where(array('id' => $m['id'])); 
				$this->db->update('m2m_dsr_lane_inventory_description', $data);
			}
			if($m['status'] == 1){
				$data['status'] = 2;
				$this->db->where(array('id' => $m['id'])); 
				$this->db->update('m2m_dsr_lane_inventory_description', $data);
			}
			echo 'Data updated '.$i.' times.<br>';
			$i++;
		}
	}
	public function DSR_lane_closed_transfer(){
		$dsr_lane = $this->db->select('id,lane_closed,lane_closed_from,lane_closed_to,lane_closed_description')->from('dsr_lane')->where(array('lane_status' => 1))->get()->result_array();
		$i = 0;
		foreach($dsr_lane as $lane){
			$data['dsr_lane'] = $lane['id'];
			$data['closed_by'] = $lane['lane_closed'];
			$data['closed_from'] = $lane['lane_closed_from'];
			$data['closed_to'] = $lane['lane_closed_to'];
			$data['description'] = $lane['lane_closed_description'];
			$this->db->insert('dsr_lane_closed', $data);
			echo '   '.$i;
			$i++;
		}
	}
	public function DSR_doc_asrg_transfer(){
		$dsr_doc = $this->db->select('dsr_doc_id,asrg,asrg_reference_no,asrg_date,asrg_detail')->from('dsr_doc')->where(array('asrg' => 2))->get()->result_array();
		$i = 0;
		foreach($dsr_doc as $doc){
			$data['dsr_doc'] = $doc['dsr_doc_id'];
			$data['reference_no'] = $doc['asrg_reference_no'];
			$data['date'] = $doc['asrg_date'];
			$data['detail'] = $doc['asrg_detail'];
			$this->db->insert('dsr_doc_asrg', $data);
			echo $data['dsr_doc'].'<br>';
			$i++;
		}
	}
	public function DSR_attendance_leave_transfer(){
		$dsr_attendance = $this->db->select('id,attendance_status,leave_from,leave_to')->from('dsr_attendance')->where(array('attendance_status' => 1))->get()->result_array();
		$i = 0;
		foreach($dsr_attendance as $doc){
			$data['dsr_attendance'] = $doc['id'];
			$data['leave_from'] = $doc['leave_from'];
			$data['leave_to'] = $doc['leave_to'];
			$this->db->insert('dsr_attendance_time', $data);
			echo $data['dsr_attendance'].'    ';
			$i++;
		}
	}
	public function DSR_main_transfer(){
		$old_dsr = $this->db->query('SELECT * FROM o_dsr_updated ORDER BY id ASC')->result_array();
		$old_dsr_status = $this->db->query('SELECT * FROM o_dsr_status ORDER BY id ASC')->result_array();
		$old_dsr_doc = $this->db->query('SELECT * FROM o_dsr_doc ORDER BY id ASC')->result_array();
		$old_dsr_lane = $this->db->query('SELECT id, dsr_id, lane_id, lane_status, lane_closed, lane_closed_from, lane_closed_to, lane_closed_description, lane_camera_status, lane_camera_faulty_description, inventory_ohls_status, inventory_boom_arm_status, inventory_boom_mechanical_status, inventory_thermal_printer_status, inventory_tct_status, inventory_lanepc_status, inventory_traffic_light_status, inventory_pfd_status, inventory_ohls_description, inventory_boom_arm_description, inventory_boom_mechanical_description, inventory_thermal_printer_description, inventory_tct_description, inventory_lanepc_description, inventory_traffic_light_description, inventory_pfd_description FROM o_dsr_lane ORDER BY id ASC')->result_array();
		$old_dsr_generator_log = $this->db->query('SELECT * FROM o_dsr_generator_log ORDER BY id ASC')->result_array();
		$old_dsr_attendance = $this->db->query('SELECT * FROM o_dsr_attendance ORDER BY id ASC')->result_array();
		$dsr_d_feature = $this->db->query('SELECT * FROM dsr_features WHERE type = 3 ORDER BY id ASC')->result_array();
		$dsr_ds_feature = $this->db->query('SELECT * FROM dsr_features WHERE type = 4 ORDER BY id ASC')->result_array();
		$dsr_generator_log_feature = $this->db->query('SELECT * FROM dsr_generator_log_features ORDER BY id ASC')->result_array();
		$dsr_bound = $this->db->query('SELECT * FROM dsr_bound')->result_array();
		$dsr_b_inv = $this->db->query('SELECT * FROM dsr_inventory WHERE installed_at = 2 AND status = 1')->result_array();
		$dsr_lane_inventory = $this->db->query('SELECT * FROM dsr_inventory WHERE installed_at = 3 AND status = 1')->result_array(); 
		$dsr_s_feature = $this->db->query('SELECT * FROM dsr_features WHERE type = 1 ORDER BY id ASC')->result_array();
		$dsr_r_feature = $this->db->query('SELECT * FROM dsr_features WHERE type = 2 ORDER BY id ASC')->result_array();
		$i = 0;
		foreach($old_dsr as $old){
			$data[$i]['id'] = $old['id']; 
			$data[$i]['toolplaza_id'] = $old['toolplaza_id']; 
			$data[$i]['supervisor_id'] = $old['supervisor_id']; 
			$data[$i]['omc_id'] = $old['omc']; 
			$data[$i]['status'] = $old['status']; 
			$data[$i]['disapprove_reason'] = $old['disapprove_reason']; 
			$data[$i]['version'] = 1;
			$data[$i]['datecreated'] = $old['datecreated']; 
			$data[$i]['created_at'] = $old['created_at']; 
			$data[$i]['updated_at'] = $old['updated_at'];
			
			$ins_data = $this->db->insert('dsr', $data[$i]);
			$table = 'dsr'; $order_by = 'id';
			$dsr_last = $this->dsr_model->retrieve_last($table, $order_by);
			if(!$ins_data){
				echo 'Data could not be inserted in DSR '.$old['id'].'.<br>';
			}
			else{
				echo 'Data inserted in DSR '.$old['id'].' Successfully.<br>';
				$doc_no = 0;
				foreach($old_dsr_doc as $doc){
					if($old['id'] == $doc['id']){
						$j = 0;
						foreach($dsr_d_feature as $feat){
							$d_feature[$i][$feat['id']]['dsr_id'] = $old['id'];
							$d_feature[$i][$feat['id']]['feature_id'] = $feat['id'];
							if($feat['id'] == 1){

								$d_feature[$i][$feat['id']]['value'] = $old['daily_traffic'];
							}
							if($feat['id'] == 2){
								$d_feature[$i][$feat['id']]['value'] = $old['daily_revenue'];
							}
							$j++;
						}
						$s_old_no = 0;
						foreach($dsr_s_feature as $feat){
							$s_feature[$i][$feat['id']]['dsr_id'] = $old['id'];
							$s_feature[$i][$feat['id']]['feature_id'] = $feat['id'];
							if(isset($doc['image_status'])){
								if($feat['id'] == 9){
									$s_feature[$i][$feat['id']]['status'] = $doc['image_status'];
								}
							}
							if(isset($doc['asrg'])){
								if($feat['id'] == 16){
									$s_feature[$i][$feat['id']]['status'] = $doc['asrg'] - 1;
									if($doc['asrg'] == 2){
										$s_feature[$i][$feat['id']]['status'] = 1;
										$dsr_asrg[$i][$feat['id']]['support_request'][0]['dsr_id'] = $old['id'];
										$dsr_asrg[$i][$feat['id']]['support_request'][0]['reference_no'] = $doc['asrg_reference_no'];
										$dsr_asrg[$i][$feat['id']]['support_request'][0]['date'] = $doc['asrg_date'];
										$dsr_asrg[$i][$feat['id']]['support_request'][0]['detail'] = $doc['asrg_detail'];
										$table = 'dsr_asrg'; $asrg = $dsr_asrg[$i][$feat['id']]['support_request'][0];
										$ins_asrg = $this->dsr_model->insert_dsr($table, $asrg);
										if(!$ins_asrg){
											echo 'Support Request for DSR '.$old['id'].' insert failed<br>';
										}
										else{
											echo 'Support Request for DSR '.$old['id'].' inserted successfully<br>';
										}
									}
								}
							}
							$s_old_no++;
						}
						
						$ds_feat_no = 0;
						foreach($dsr_ds_feature as $feat){
							$d_feature[$i][$feat['id']]['dsr_id'] = $old['id'];
							$d_feature[$i][$feat['id']]['feature_id'] = $feat['id'];
							if($feat['id'] == 4){
							
								$d_feature[$i][$feat['id']]['value'] = $doc['mtr_status'];
							}
							if($feat['id'] == 5){
							
								$d_feature[$i][$feat['id']]['value'] = $doc['mtr_upto'];
							}
							if($feat['id'] == 6){
								$d_feature[$i][$feat['id']]['value'] = $doc['mtr_archiving_status'];
							}	
							
							$ds_feat_no++;
						}
						
						foreach($dsr_d_feature as $feat){
							$d_feature[$i][$feat['id']]['dsr_id'] = $old['id'];
							$d_feature[$i][$feat['id']]['feature_id'] = $feat['id'];
							if($feat['id'] == 3){
								$d_feature[$i][$feat['id']]['value'] = $doc['mtr_pending'];
							}

							$ds_feat_no++;
						}
						
					}
					$doc_no++;
				}
				
				$s_feat_no = 0;
				foreach($dsr_s_feature as $feat){
					if($feat['id'] == 17){
						$s_feature[$i][$feat['id']]['status'] = 0;
						$glog_no = 0;
						foreach($old_dsr_generator_log as $glog){
							if($old['id'] == $glog['id']){
								$s_feature[$i][$feat['id']]['status'] = 1;
								$glog_dsr[$i][$feat['id']]['generator_log'][0]['dsr_id'] = $old['id'];
								$glog_dsr[$i][$feat['id']]['generator_log'][0]['time_from'] = $glog['generator_from'];
								$glog_dsr[$i][$feat['id']]['generator_log'][0]['time_to'] = $glog['generator_to'];
								$glog_dsr[$i][$feat['id']]['generator_log'][0]['total_time'] = $glog['generator_time'];
								$table = 'dsr_generator_log'; $glog_data = $glog_dsr[$i][$feat['id']]['generator_log'][0];
								$ins_glog = $this->dsr_model->insert_dsr($table, $glog_data);
								if(!$ins_glog){
									echo 'Generator Log for DSR '.$old['id'].' insert failed<br>';
								}
								else{
									echo 'Generator Log for DSR '.$old['id'].' inserted Successfully<br>';
									$table = 'dsr_generator_log'; $order_by = 'id';
									$glog_last = $this->dsr_model->retrieve_last($table, $order_by);
									$gen_feat = 0;
									foreach($dsr_generator_log_feature as $glogfeat){
										$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['dsr_id'] = $old['id'];
										$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['generator_log_id'] = $glog_last[0]['id'];
										$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['generator_log_feature_id'] = $glogfeat['id'];
										if($glogfeat['type'] == 3){
											if($glogfeat['id'] == 1){
												$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['value'] = $glog['diesel_per_hour'];
											}
											if($glogfeat['id'] == 2){
												$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['value'] = $glog['diesel_consumed'];
											}
											if($glogfeat['id'] == 3){
												$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['value'] = $glog['output_voltage'];
											}
										}
										if($glogfeat['type'] == 2){
											if($glogfeat['id'] == 4){
												$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['level'] = $glog['fuel_level'];
											}
											if($glogfeat['id'] == 5){
												$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['level'] = $glog['oil_level'];
											}
											if($glogfeat['id'] == 6){
												$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['level'] = $glog['oil_change'];
											}
											if($glogfeat['id'] == 7){
												$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['level'] = $glog['radiator_water_level'];
											}
											if($glogfeat['id'] == 8){
												$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['level'] = $glog['battery_water_level'];
											}
											if($glogfeat['id'] == 9){
												$dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat]['level'] = $glog['battery_terminal_condition'];
											}
										}
										$table = 'dsr_m2m_generator_log_m2m_features'; $glog_feat = $dsr_glog[$i][$feat['id']]['generator_log'][0]['features'][$gen_feat];
										$ins_glog_feat = $this->dsr_model->insert_dsr($table, $glog_feat);
										if(!$ins_glog_feat){
											echo 'Generator Log Feature '.$glogfeat['id'].' for DSR '.$old['id'].' insert failed<br>';
										}
										else{
											echo 'Generator Log Feature '.$glogfeat['id'].' for DSR '.$old['id'].' inserted Successfully<br>';
										}
										$gen_feat++;
									}
								}
								
								
							}
							$glog++;
						}
					}
					$s_feat_no++;
				}
				$s_no = 0;
				foreach($old_dsr_status as $old_s){
					if($old['id'] == $old_s['id']){
						if(isset($old_s['faulty_electricity_cause'])){
							if($old_s['faulty_electricity_cause'] == 2){
								$data[$i]['feedback'] = 'Generator is used.<br>'; 
							}
							if($old_s['faulty_electricity_cause'] == 3){
								$data[$i]['feedback'] = 'UPS is used.<br>'; 
							}
							
						}
						if(isset($old_s['faulty_electricity_reason'])){
							if(isset($data[$i]['feedback'])){
								$data[$i]['feedback'] .= 'Faulty Electricity Reason: '.$old_s['faulty_electricity_reason'].'<br>'; 
							}
						}
						if(isset($old_s['status_queuing'])){
							if(isset($data[$i]['feedback'])){
								$data[$i]['feedback'] .= ' Comments written in Queuing Section: '.$old_s['status_queuing']; 
							}
						}
						$where = 'id'; $para2 = $dsr_last[0]['id']; $table = 'dsr'; $updata = $data[$i];
						$this->dsr_model->update_dsr($where, $para2, $table, $updata);
						$s_feat_no = 0;
						foreach($dsr_s_feature as $feat){
							$s_feature[$i][$feat['id']]['dsr_id'] = $old['id'];
							$s_feature[$i][$feat['id']]['feature_id'] = $feat['id'];
							if($feat['detail'] == 0){
								if($feat['id'] == 7){
									$s_feature[$i][$feat['id']]['status'] = $old_s['status_lsdu'];
								}
								if($feat['id'] == 8){
									$s_feature[$i][$feat['id']]['status'] = $old_s['status_framegrabber'];
								}
								if($feat['id'] == 10){
									$s_feature[$i][$feat['id']]['status'] = $old_s['status_server'];
								}
								if($feat['id'] == 18){
									if($old_s['status_reciepts'] == 1){
										$s_feature[$i][$feat['id']]['status'] = $old_s['status_reciepts'] - 1;
									}
									if($old_s['status_reciepts'] == 2){
										$s_feature[$i][$feat['id']]['status'] = $old_s['status_reciepts'] - 1;
									}

								}
							}
							if($feat['detail'] == 1){
								if($feat['id'] == 11){
									$s_feature[$i][$feat['id']]['status'] = $old_s['status_link'];
									if($old_s['status_link'] == 1){
										$s_feature[$i][$feat['id']]['description'] = $old_s['status_link_description'];
									}
								}
							}
							
							if($feat['detail'] == 2){
								if($feat['id'] == 12){
									$s_feature[$i][$feat['id']]['status'] = 0;
								}
								if($feat['id'] == 13){
									$s_feature[$i][$feat['id']]['status'] = 0;
								}
								if($feat['id'] == 14){
									$s_feature[$i][$feat['id']]['status'] = $old_s['status_shutdown'];
									if($old_s['status_shutdown'] == 1){
										$s_feature[$i][$feat['id']]['time_from'] = $old_s['time_shut_from'];
										$s_feature[$i][$feat['id']]['time_to'] = $old_s['time_shut_to'];
									}
								}
								if($feat['id'] == 15){
									$s_feature[$i][$feat['id']]['status'] = $old_s['status_electricity'] - 1;
								}
								
							}
							$s_feat_no++;
						}
						
						$r_feat_no = 0;
						foreach($dsr_r_feature as $feat){
							$r_feature[$i][$feat['id']]['dsr_id'] = $old['id'];
							$r_feature[$i][$feat['id']]['feature_id'] = $feat['id'];
							if($feat['id'] == 19){
								$r_feature[$i][$feat['id']]['rating'] = $old_s['status_building'];
							}
							if($feat['id'] == 20){
								$r_feature[$i][$feat['id']]['rating'] = $old_s['status_cleaning'];
							}
							if($feat['id'] == 21){
								$r_feature[$i][$feat['id']]['rating'] = $old_s['status_meal'];
							}
							if($feat['id'] == 22){
								$r_feature[$i][$feat['id']]['rating'] = $old_s['status_water'];
							}
							$r_feat_no++;
						}
					}
					$s_no++;
				}
				$dsr_lane_no = 0;
				foreach($old_dsr_lane as $dlane){
					if($dlane['dsr_id'] == $old['id']){
						$l_status[$dsr_lane_no]['id'] = $dlane['id'];
						$l_status[$dsr_lane_no]['dsr_id'] = $dlane['dsr_id'];
						$l_status[$dsr_lane_no]['lane_id'] = $dlane['lane_id'];
						$l_status[$dsr_lane_no]['lane_status'] = $dlane['lane_status'];
						$table = 'dsr_lane'; $l_data = $l_status[$dsr_lane_no];
						$ins_l_data = $this->dsr_model->insert_dsr($table, $l_data);
						if(empty($ins_l_data)){
							echo 'Lane '.$dlane['lane_id'].' Status for DSR '.$dlane['dsr_id'].' insert failed<br>';
						}
						else{
							echo 'Lane '.$dlane['lane_id'].' Status for DSR '.$dlane['dsr_id'].' inserted successfully<br>';
						}
						if($dlane['lane_status'] == 1){
							if(isset($dlane['lane_closed'])){
								$l_closed[$dsr_lane_no]['dsr_id'] = $dlane['dsr_id'];
								$l_closed[$dsr_lane_no]['dsr_lane_id'] = $dlane['id'];
								$l_closed[$dsr_lane_no]['closed_by'] = $dlane['lane_closed'];
								$l_closed[$dsr_lane_no]['closed_from'] = $dlane['lane_closed_from'];
								$l_closed[$dsr_lane_no]['closed_to'] = $dlane['lane_closed_to'];
								$l_closed[$dsr_lane_no]['description'] = $dlane['lane_closed_description'];
								$table = 'dsr_lane_closed'; $lc_data = $l_closed[$dsr_lane_no];
								$ins_lc_data = $this->dsr_model->insert_dsr($table, $lc_data);
								if(empty($ins_lc_data)){
									echo 'Lane Closed '.$dlane['id'].' for Lane '.$dlane['lane_id'].' Status for DSR '.$dlane['dsr_id'].' insert failed<br>';
								}
								else{
									echo 'Lane Closed '.$dlane['id'].' for Lane '.$dlane['lane_id'].' Status for DSR '.$dlane['dsr_id'].' inserted successfully<br>';
								}
							}
							
							
						}
						$lane_inv = 0;
						foreach($dsr_lane_inventory as $inv){
							
							if($inv['id'] == 1){
								$lane_inventory['dsr_id'] = $dlane['dsr_id'];
								$lane_inventory['dsr_lane_id'] = $dlane['id'];
								$lane_inventory['dsr_inventory_id'] = $inv['id'];
								$lane_inventory['status'] = $dlane['lane_camera_status'] + 1;
								$lane_inventory['description'] = $dlane['lane_camera_faulty_description'];
								$table = 'dsr_m2m_inventory_lane'; $data_dlane = $lane_inventory;
								$ins_dlane = $this->dsr_model->insert_dsr($table, $data_dlane);
								if(empty($ins_dlane)){
									echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
								}
								else{
									echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
								}
								
							}
							if($inv['id'] == 2){
								if(isset($dlane['inventory_ohls_status'])){
									$lane_inventory['dsr_id'] = $dlane['dsr_id'];
									$lane_inventory['dsr_lane_id'] = $dlane['id'];
									$lane_inventory['dsr_inventory_id'] = $inv['id'];
									$lane_inventory['status'] = $dlane['inventory_ohls_status'];
									$lane_inventory['description'] = $dlane['inventory_ohls_description'];
									$table = 'dsr_m2m_inventory_lane'; $data_dlane = $lane_inventory;
									$ins_dlane = $this->dsr_model->insert_dsr($table, $data_dlane);
									if(empty($ins_dlane)){
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
									}
									else{
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
									}
								}
							}
							if($inv['id'] == 3){
								if(isset($dlane['inventory_boom_arm_status'])){
									$lane_inventory['dsr_id'] = $dlane['dsr_id'];
									$lane_inventory['dsr_lane_id'] = $dlane['id'];
									$lane_inventory['dsr_inventory_id'] = $inv['id'];
									$lane_inventory['status'] = $dlane['inventory_boom_arm_status'];
									$lane_inventory['description'] = $dlane['inventory_boom_arm_description'];
									$table = 'dsr_m2m_inventory_lane'; $data_dlane = $lane_inventory;
									$ins_dlane = $this->dsr_model->insert_dsr($table, $data_dlane);
									if(empty($ins_dlane)){
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
									}
									else{
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
									}
								}
							}
							if($inv['id'] == 4){
								if(isset($dlane['inventory_boom_mechanical_status'])){
									$lane_inventory['dsr_id'] = $dlane['dsr_id'];
									$lane_inventory['dsr_lane_id'] = $dlane['id'];
									$lane_inventory['dsr_inventory_id'] = $inv['id'];
									$lane_inventory['status'] = $dlane['inventory_boom_mechanical_status'];
									$lane_inventory['description'] = $dlane['inventory_boom_mechanical_description'];
									$table = 'dsr_m2m_inventory_lane'; $data_dlane = $lane_inventory;
									$ins_dlane = $this->dsr_model->insert_dsr($table, $data_dlane);
									if(empty($ins_dlane)){
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
									}
									else{
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
									}
								}
							}
							if($inv['id'] == 5){
								if(isset($dlane['inventory_thermal_printer_status'])){
									$lane_inventory['dsr_id'] = $dlane['dsr_id'];
									$lane_inventory['dsr_lane_id'] = $dlane['id'];
									$lane_inventory['dsr_inventory_id'] = $inv['id'];
									$lane_inventory['status'] = $dlane['inventory_thermal_printer_status'];
									$lane_inventory['description'] = $dlane['inventory_thermal_printer_description'];
									$table = 'dsr_m2m_inventory_lane'; $data_dlane = $lane_inventory;
									$ins_dlane = $this->dsr_model->insert_dsr($table, $data_dlane);
									if(empty($ins_dlane)){
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
									}
									else{
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
									}
								}
							}
							if($inv['id'] == 6){
								if(isset($dlane['inventory_tct_status'])){
									$lane_inventory['dsr_id'] = $dlane['dsr_id'];
									$lane_inventory['dsr_lane_id'] = $dlane['id'];
									$lane_inventory['dsr_inventory_id'] = $inv['id'];
									$lane_inventory['status'] = $dlane['inventory_tct_status'];
									$lane_inventory['description'] = $dlane['inventory_tct_description'];
									$table = 'dsr_m2m_inventory_lane'; $data_dlane = $lane_inventory;
									$ins_dlane = $this->dsr_model->insert_dsr($table, $data_dlane);
									if(empty($ins_dlane)){
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
									}
									else{
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
									}
								}
							}
							if($inv['id'] == 7){
								if(isset($dlane['inventory_lanepc_status'])){
									$lane_inventory['dsr_id'] = $dlane['dsr_id'];
									$lane_inventory['dsr_lane_id'] = $dlane['id'];
									$lane_inventory['dsr_inventory_id'] = $inv['id'];
									$lane_inventory['status'] = $dlane['inventory_lanepc_status'];
									$lane_inventory['description'] = $dlane['inventory_lanepc_description'];
									$table = 'dsr_m2m_inventory_lane'; $data_dlane = $lane_inventory;
									$ins_dlane = $this->dsr_model->insert_dsr($table, $data_dlane);
									if(empty($ins_dlane)){
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
									}
									else{
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
									}
								}
							}
							if($inv['id'] == 8){
								if(isset($dlane['inventory_traffic_light_status'])){
									$lane_inventory['dsr_id'] = $dlane['dsr_id'];
									$lane_inventory['dsr_lane_id'] = $dlane['id'];
									$lane_inventory['dsr_inventory_id'] = $inv['id'];
									$lane_inventory['status'] = $dlane['inventory_traffic_light_status'];
									$lane_inventory['description'] = $dlane['inventory_traffic_light_description'];
									$table = 'dsr_m2m_inventory_lane'; $data_dlane = $lane_inventory;
									$ins_dlane = $this->dsr_model->insert_dsr($table, $data_dlane);
									if(empty($ins_dlane)){
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
									}
									else{
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
									}
								}
							}
							if($inv['id'] == 9){
								if(isset($dlane['inventory_pfd_status'])){
									$lane_inventory['dsr_id'] = $dlane['dsr_id'];
									$lane_inventory['dsr_lane_id'] = $dlane['id'];
									$lane_inventory['dsr_inventory_id'] = $inv['id'];
									$lane_inventory['status'] = $dlane['inventory_pfd_status'];
									$lane_inventory['description'] = $dlane['inventory_pfd_description'];
									$table = 'dsr_m2m_inventory_lane'; $data_dlane = $lane_inventory;
									$ins_dlane = $this->dsr_model->insert_dsr($table, $data_dlane);
									if(empty($ins_dlane)){
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
									}
									else{
										echo 'Lane '.$dlane['lane_id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
									}
								}
							}
							
							$lane_inv++;
						}
						$dsr_lane_no++;
					}
					
				}
				$bound_no = 0;
				foreach($dsr_bound as $bound){
					$b_inv_no = 0;
					foreach($dsr_b_inv as $inv){
						if($bound['id'] == 1){
							if(isset($old['ptz_north_status'])){
								$b_inv[$i][$bound_no]['dsr_id'] = $old['id'];
								$b_inv[$i][$bound_no]['dsr_bound_id'] = $bound['id'];
								$b_inv[$i][$bound_no]['dsr_inventory_id'] = $inv['id'];
								if($bound['id'] == 1){
									$b_inv[$i][$bound_no]['status'] = $old['ptz_north_status'] + 1;
									$b_inv[$i][$bound_no]['description'] = $old['ptz_north_description'];
								}
								$table = 'dsr_m2m_inventory_bound'; $bound_status_data = $b_inv[$i][$bound_no];
								$ins_lane_status = $this->dsr_model->insert_dsr($table, $bound_status_data);
								if(empty($ins_lane_status)){
									echo 'Bound '.$bound['id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
								}
								else{
									echo 'Bound '.$bound['id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
								}
							}
						}
						if($bound['id'] == 2){
							if(isset($old['ptz_south_status'])){
								$b_inv[$i][$bound_no]['dsr_id'] = $old['id'];
								$b_inv[$i][$bound_no]['dsr_bound_id'] = $bound['id'];
								$b_inv[$i][$bound_no]['dsr_inventory_id'] = $inv['id'];
								if($bound['id'] == 2){
									$b_inv[$i][$bound_no]['status'] = $old['ptz_south_status'] + 1;
									$b_inv[$i][$bound_no]['description'] = $old['ptz_south_description'];
								}
								$table = 'dsr_m2m_inventory_bound'; $bound_status_data = $b_inv[$i][$bound_no];
								$ins_lane_status = $this->dsr_model->insert_dsr($table, $bound_status_data);
								if(empty($ins_lane_status)){
									echo 'Bound '.$bound['id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' insert failed<br>';
								}
								else{
									echo 'Bound '.$bound['id'].' Inventory '.$inv['id'].' for DSR '.$old['id'].' inserted successfully<br>';
								}
							}
						}
						
						
						
						$b_inv_no++;
					}
					/*if(isset($b_inv[$i])){
						foreach($b_inv[$i] as $b_inv){
							$ins_b_inv_data = $this->db->insert('dsr_m2m_inventory_bound', $b_inv);
							if(!$ins_b_inv_data){
								'Data could not be inserted in DSR '.$old['id'].' Bound '.$bound['id'].' Inventory Status';
							}
							else{
								echo 'Data inserted in DSR '.$old['id'].' Bound '.$bound['id'].' Inventory Status Successfully.<br>';
							}
						}
					}*/
					$bound_no++;
				}
				$d_feat = 1;
				foreach($d_feature[$i] as $feat){
					$table = 'dsr_m2m_d_features'; $data = $feat;
					$ins_d = $this->dsr_model->insert_dsr($table, $data);
					if(!$ins_d){
						echo 'Data could not be inserted in DSR '.$old['id'].' D Feature '.$feat['feature_id'];
					}
					else{
						echo 'Data inserted in DSR '.$old['id'].' D Feature '.$feat['feature_id'].' successfully<br>';
					}
					$d_feat++;
				}
				$s_feat = 0;
				foreach($s_feature[$i] as $feat){
					$table = 'dsr_m2m_s_features'; $data = $feat;
					$ins_d = $this->dsr_model->insert_dsr($table, $data);
					if(!$ins_d){
						echo 'Data could not be inserted in DSR '.$old['id'].' S Feature '.$feat['feature_id'];
					}
					else{
						echo 'Data inserted in DSR '.$old['id'].' S Feature '.$feat['feature_id'].' successfully<br>';
					}
					$s_feat++;
				}
				$r_feat = 0;
				foreach($r_feature[$i] as $feat){
					$table = 'dsr_m2m_r_features'; $data = $feat;
					$ins_d = $this->dsr_model->insert_dsr($table, $data);
					if(!$ins_d){
						echo 'Data could not be inserted in DSR '.$old['id'].' R Feature '.$feat['feature_id'];
					}
					else{
						echo 'Data inserted in DSR '.$old['id'].' R Feature '.$feat['feature_id'].' successfully<br>';
					}
					$r_feat++;
				}
				$attend = 0;
				foreach($old_dsr_attendance as $attendee){
					if($old['id'] == $attendee['dsr_id']){
						if($attendee['attendance_status'] != 0){
							$dsr_attend[$attend]['id'] = $attendee['id'];
							$dsr_attend[$attend]['dsr_id'] = $attendee['dsr_id'];
							$dsr_attend[$attend]['staff_id'] = $attendee['staff_id'];
							$dsr_attend[$attend]['attendance_status'] = $attendee['attendance_status'];
							$table = 'dsr_attendance'; $data_attend = $dsr_attend[$attend];
							$ins_attend = $this->dsr_model->insert_dsr($table, $data_attend);
							if(empty($ins_attend)){
								echo 'Attendance of staff id '.$attendee['staff_id'].' for DSR '.$old['id'].' insert failed<br>';
							}
							else{
								echo 'Attendance of staff id '.$attendee['staff_id'].' for DSR '.$old['id'].' inserted successfully<br>';
								if(isset($attendee['leave_from']) && isset($attendee['leave_to'])){
									$attend_leave[$attend]['dsr_id'] = $attendee['dsr_id'];
									$attend_leave[$attend]['dsr_attendance_id'] = $attendee['id'];
									$attend_leave[$attend]['leave_from'] = $attendee['leave_from'];
									$attend_leave[$attend]['leave_to'] = $attendee['leave_to'];
									$table = 'dsr_attendance_leave'; $data_leave = $attend_leave[$attend];
									$ins_leave = $this->dsr_model->insert_dsr($table, $data_leave);
									if(empty($ins_attend)){
										echo 'Attendance of staff id '.$attendee['staff_id'].' for DSR '.$old['id'].' insert failed<br>';
									}
									else{
										echo 'Attendance of staff id '.$attendee['staff_id'].' for DSR '.$old['id'].' inserted successfully<br>';
									}
									
								}
								
							}
						}
						
					}
					
					$attend++;
				}
			}			
			$i++;
		}
		?> <pre> <?php echo print_r($lane_inventory);exit;
		return $data;
	}
}	