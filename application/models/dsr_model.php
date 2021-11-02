<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dsr_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
		//date_default_timezone_set('Asia/Karachi');
	}
		
	public function comprehensive($date){
		$dsr_data['toolplaza'] = $this->db->query('SELECT * FROM view_dsrcr_basic')->result_array();
		$dsr = $this->db->query('SELECT * FROM view_dsr_heading WHERE dsr_date = "'.$date.'"')->result_array();
		$dsr_s_feature = $this->db->query('SELECT * FROM view_dsr_s_features')->result_array();
		$dsr_data['inventory'] = $this->db->query('SELECT * FROM dsr_inventory WHERE status = 1')->result_array();
		$tool_no = 0;
		foreach($dsr_data['toolplaza'] as $tool){
			$dsr_no = 0;
			foreach($dsr as $d){
				if($tool['toolplaza_id'] == $d['toolplaza_id']){
					$dsr_data['toolplaza'][$tool_no]['dsr'] = $d;
					$dsr_data['toolplaza'][$tool_no]['dsr']['closed_lanes'] = '';
					$dsr_lane = $this->db->query('SELECT * FROM view_dsr_lanes WHERE dsr_id = '.$d['id'])->result_array();
					$lane_no = 0;
					foreach($dsr_lane as $lane){
						if($d['id'] == $lane['dsr_id']){
							if($lane['lane_status'] == 1){
								$dsr_data['toolplaza'][$tool_no]['dsr']['closed_lanes'] .= $lane['name'].' ';
								$lane_no++;
							}
						}
					}
					$dsr_s_feature = $this->db->query('SELECT * FROM view_dsr_s_features WHERE dsr_id = '.$d['id'])->result_array();
					$s_feature = 0;
					foreach($dsr_s_feature as $s_feat){
						if($s_feat['feature_id'] == 11){
							if($s_feat['val'] == 0){
								$dsr_data['toolplaza'][$tool_no]['dsr']['link'] = $s_feat['status'];
							}
							if($s_feat['val'] == 1){
								$dsr_data['toolplaza'][$tool_no]['dsr']['link'] = $s_feat['description'];
							}
						}
						if($s_feat['feature_id'] == 14){
							$dsr_data['toolplaza'][$tool_no]['dsr']['shut_down'] = $s_feat['status'];
						}
						if($s_feat['feature_id'] == 16){
							$dsr_data['toolplaza'][$tool_no]['dsr']['support_request'] = $s_feat['status'];
						}
						$s_feature++;
					}
					$dsr_d_feature = $this->db->query('SELECT * FROM view_dsr_d_features WHERE dsr_id = '.$d['id'])->result_array();
					$d_feature = 0;
					foreach($dsr_d_feature as $d_feat){
						if($d_feat['feature_id'] == 5){
							$dsr_data['toolplaza'][$tool_no]['dsr']['mtr_status'] = 'Upto '.date( 'F Y', strtotime($d_feat['value']));
						}
						if($d_feat['feature_id'] == 6){
							$dsr_data['toolplaza'][$tool_no]['dsr']['mtr_archiving_status'] = 'Upto '.date( 'F Y', strtotime($d_feat['value']));
						}
						$d_feature++;
					}
					$dsr_b_inv = $this->db->query('SELECT * FROM view_dsr_bound_inventory WHERE dsr_id = '.$d['id'])->result_array();
					$b_inv = 0;
					foreach($dsr_b_inv as $inv){
						if($inv['inventory_id'] == 10){
							if($inv['status'] == 2){
								$dsr_data['toolplaza'][$tool_no]['dsr']['ptz_camera_status'] = $inv['bound_name'];
							}
							
						}
						$b_inv++;						
					}
					$dsr_attendance = $this->db->query('SELECT * FROM view_dsr_attendance WHERE dsr_id = '.$d['id'])->result_array();
					$dsr_data['toolplaza'][$tool_no]['dsr']['absentee'] = '';
					$attend = 0;
					foreach($dsr_attendance as $attendee){
						if($attendee['attendance_status'] == 2 || $attendee['attendance_status'] == 1){
							$dsr_data['toolplaza'][$tool_no]['dsr']['absentee'] .= $attendee['name'].' ';
						}
						$attend++;
					}
					$inv_no = 0;
					foreach($dsr_data['inventory'] as $inv){
						$dsr_data['toolplaza'][$tool_no]['dsr']['inventory'][$inv_no]['id'] = $inv['id'];
						$dsr_data['toolplaza'][$tool_no]['dsr']['inventory'][$inv_no]['name'] = $inv['name'];
						$dsr_data['toolplaza'][$tool_no]['dsr']['inventory'][$inv_no]['installed'] = $inv['installed_at'];
						if($inv['installed_at'] == 3){
							$dsr_data['toolplaza'][$tool_no]['dsr']['inventory'][$inv_no]['status'] = '';
							$dsr_lane_inventory = $this->db->query('SELECT inventory_id, lane, status, description FROM view_dsr_lane_inventory WHERE dsr_id = '.$d['id'])->result_array();
							$lane_inv = 0;
							foreach($dsr_lane_inventory as $l_inv){
								
								if($l_inv['inventory_id'] == $inv['id']){
									if($l_inv['status'] == 2){
										$dsr_data['toolplaza'][$tool_no]['dsr']['inventory'][$inv_no]['status'] .= $l_inv['lane'].' ';
									}									
								}
								$lane_inv++;
							}
						}
						if($inv['installed_at'] == 2){
							$dsr_data['toolplaza'][$tool_no]['dsr']['inventory'][$inv_no]['status'] = '';
							$dsr_bound_inventory =  $this->db->query('SELECT inventory_id, bound_name, status, description FROM view_dsr_bound_inventory WHERE dsr_id = '.$d['id'])->result_array();
							$bound_inv = 0;
							foreach($dsr_bound_inventory as $b_inv){
								
								if($b_inv['inventory_id'] == $inv['id']){
									
									if($b_inv['status'] == 2){
										$dsr_data['toolplaza'][$tool_no]['dsr']['inventory'][$inv_no]['status'] .= $b_inv['bound_name'].' ';
									}									
								}
								$bound_inv++;
							}
						}
						if($inv['installed_at'] == 1){
							$dsr_data['toolplaza'][$tool_no]['dsr']['inventory'][$inv_no]['status'] = '';
							$dsr_toll_inventory =  $this->db->query('SELECT inventory_id, status, description FROM view_dsr_inventory WHERE dsr_id = '.$d['id'])->result_array();
							$toll_inv = 0;
							foreach($dsr_toll_inventory as $t_inv){
								
								if($t_inv['inventory_id'] == $inv['id']){
									if($t_inv['status'] == 2){
										$dsr_data['toolplaza'][$tool_no]['dsr']['inventory'][$inv_no]['status'] = 'Tollplaza';
									}									
								}
								$toll_inv++;
							}
						}
						$inv_no++;
					}
				}
				$dsr_no++;
			}
			$tool_no++;
		}
		/*?><pre> <?php echo print_r($dsr_b_inv);exit;*/
		return $dsr_data;
	}

		
	public function dsr_tool($tool){
		$dsr_data = $this->db->select('*')->from('o_dsr_updated as dsr')->where(array('dsr.toolplaza_id' => $tool, 'dsr.datecreated' => date('Y-m-d',strtotime('2020-04-18'))))->join('o_dsr_status as dsr1', 'dsr.id = dsr1.id')->join('o_dsr_doc as dsr2', 'dsr.id = dsr2.id')->get()->result_array();
		/*?> <?php echo print_r($this->db->last_query());exit;*/
		foreach($dsr_data as $dsr){
			$dsr_lane= db()->get_where('view_dsr_lanes', array('dsr_id' => $dsr['id']))->result_array();
			$number = 0;
			$dsr_attendance = db()->get_where('dsr_attendance', array('dsr_id' => $dsr['id']))->result_array();
			foreach($dsr_lane as $lane){
				$dsr_data[0]['lane'][$number]['name'] = db()->get_where('tp_lanes',array('id' => $lane['lane_id']))->row()->name;
					$dsr_data[0]['lane'][$number]['lane_status'] = $lane['lane_status'];
					$dsr_data[0]['lane'][$number]['lane_closed'] = $lane['closed_by'];
					$dsr_data[0]['lane'][$number]['lane_closed_from'] = $lane['closed_from'];
					$dsr_data[0]['lane'][$number]['lane_closed_to'] = $lane['closed_to'];
					$dsr_data[0]['lane'][$number]['lane_closed_description'] = $lane['description'];
					/*$dsr_data[0]['lane'][$number]['lane_camera_status'] = $lane['lane_camera_status'];
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
					$dsr_data[0]['lane'][$number]['inventory_pfd_description'] = $lane['inventory_pfd_description'];*/
					$number++;
			}
			$number = 0;
				foreach($dsr_attendance as $attendance){
					$dsr_data[0]['attendance'][$number]['fname'] = db()->get_where('tpstaff',array('id' => $attendance['staff_id']))->row()->fname;
					$dsr_data[0]['attendance'][$number]['lname'] = db()->get_where('tpstaff',array('id' => $attendance['staff_id']))->row()->lname;
					$dsr_data[0]['attendance'][$number]['attendance_status'] = $attendance['attendance_status'];
					/*$dsr_data[0]['attendance'][$number]['leave_from'] = $attendance['leave_from'];
					$dsr_data[0]['attendance'][$number]['leave_to'] = $attendance['leave_to'];*/
					$number++;
				}
		}
		/*?> <pre><?php echo print_r($dsr_data);exit;*/
		return array($dsr_data);
	}
	//old usable functions 
	public function retrieve_last($table, $order_by){
		$data = $this->db->query('SELECT id FROM '.$table.' ORDER BY '.$order_by.' DESC LIMIT 1')->result_array();
		return $data;
	}
	public function get_where($table, $where){
		$data = $this->db->get_where($table, $where)->result_array();
		return $data;
	}
	//inserting functions 
	public function insert_dsr($table, $data){
		$this->db->limit(1);					
		$datadsr = $this->db->insert($table, $data);
		return true;
	}
	//update functions 
	public function update_dsr($where, $para2, $table, $data){
		$this->db->limit(1);
		$this->db->where($where, $para2);
		$upd = $this->db->update($table, $data);
		return $upd;
	}
	public function update_where_dsr($where, $table, $data){
		$this->db->limit(1);
		$this->db->where($where);
		$upd = $this->db->update($table, $data);
		return $upd;
	}
	public function update_where_2_dsr($where1, $where2, $table, $data){
		$this->db->limit(1);
		$this->db->where($where1);
		$this->db->where($where2);
		$upd = $this->db->update($table, $data);
		return $upd;
	}
	public function update_where_3_dsr($where1, $where2, $where3,$table, $data){
		$this->db->limit(1);
		$this->db->where($where1);
		$this->db->where($where2);
		$this->db->where($where3);
		$upd = $this->db->update($table, $data);
		return $upd;
	}
	
	//functions newly created
	//This function is created to check whether the dsr of the parameter date is already present in the database or not
	public function dsr_date_checker($date, $tool){
		$dsr_date = $this->db->query('SELECT * FROM dsr WHERE datecreated = \''.$date.'\' AND toolplaza_id = \''.$tool.'\'')->result_array();
		return $dsr_date;
	}
	//function to load the data from database especially for view and edit modules 
	public function dsr_data($id, $tool, $edit,$para2){
		// echo '<pre>';
		// echo print_r($edit); exit;
		if(isset($edit)){
			$dsr_inventory = $edit['dsr_inventory'];
			$dsr_bound = $edit['dsr_bound'];
			$dsr_bound_inventory = $edit['dsr_bound_inventory'];
			$dsr_lane = $edit['dsr_lane'];
			$dsr_data = $edit['dsr_heading'];
			$dsr_d_features = $edit['dsr_d_features'];
			$dsr_r_features = $edit['dsr_r_features'];
			$dsr_s_features = $edit['dsr_s_features'];
			$dsr_generator_log = $edit['dsr_generator_log'];
			$dsr_asrg = $edit['dsr_asrg'];
			$dsr_glog_features = $edit['dsr_glog_features'];
			$staff = $edit['dsr_attendance'];
			$all_inventory = $edit['all_inventory'];
			$all_lane_inventory = $edit['dsr_lanee_inventory'];
			$dsr_lane_inventory = $edit['dsr_lane_inventory'];
			$tp_lanes = $edit['tp_lanes'];
		}
		
		if(isset($staff)){
			$attendance_number = 0;
			foreach($staff as $attendee){
				$attendance_inc = $attendance_number + 1;
				
				$dsr_data[0]['staff'][$attendance_number]['abr'] = 'staff_'.$attendance_inc;
				$dsr_data[0]['staff'][$attendance_number]['name'] = $attendee['name'];
				$dsr_data[0]['staff'][$attendance_number]['attendance_status'] = $attendee['attendance_status'];
				if(isset($attendee['leave_from'])){
					$dsr_data[0]['staff'][$attendance_number]['leave_from'] = $attendee['leave_from'];
				}
				if(isset($attendee['leave_to'])){
					$dsr_data[0]['staff'][$attendance_number]['leave_to'] = $attendee['leave_to'];
				}
				$attendance_number++;
			}
		}
		if(isset($dsr_d_features)){
			$d_number = 0;
			foreach($dsr_d_features as $feat){
				$dsr_data[0]['d_features'][$d_number]['name'] = $feat['name'];
				if($feat['type'] == 3){
					$dsr_data[0]['d_features'][$d_number]['number'] = $d_number;
					$dsr_data[0]['d_features'][$d_number]['type'] = $feat['type'];
					$dsr_data[0]['d_features'][$d_number]['value'] = $feat['value'];
				}
				if($feat['type'] == 4){
					
					$dsr_data[0]['d_features'][$d_number]['number'] = $d_number;
					$dsr_data[0]['d_features'][$d_number]['type'] = $feat['type'];
					$dsr_data[0]['d_features'][$d_number]['value'] = date('F, Y',strtotime($feat['value']));
				}
				
				$d_number++;
			}
		}
		if(isset($dsr_r_features)){
			$r_number = 0;
			foreach($dsr_r_features as $feat){
				$dsr_data[0]['r_features'][$r_number]['name'] = $feat['name'];
				$dsr_data[0]['r_features'][$r_number]['val'] = $feat['val'];
				$dsr_data[0]['r_features'][$r_number]['rating'] = $feat['rating'];
				$r_number++;
			}
		}
		if(isset($dsr_s_features)){
			$s_number = 0;
			foreach($dsr_s_features as $feat){
				$dsr_data[0]['s_features'][$s_number]['name'] = $feat['name'];
				$dsr_data[0]['s_features'][$s_number]['detail'] = $feat['detail'];
				$dsr_data[0]['s_features'][$s_number]['val'] = $feat['val'];
				$dsr_data[0]['s_features'][$s_number]['status'] = $feat['status'];
				if($feat['val'] == 1){
					if($feat['detail'] == 1){
						$dsr_data[0]['s_features'][$s_number]['description'] = $feat['description'];
					}
					if($feat['detail'] == 2){
						$dsr_data[0]['s_features'][$s_number]['time_from'] = $feat['time_from'];
						$dsr_data[0]['s_features'][$s_number]['time_to'] = $feat['time_to'];
					}
					if($feat['detail'] == 3){
						if(isset($dsr_asrg[0])){
							$dsr_data[0]['s_features'][$s_number]['support_request'][0]['id'] = $dsr_asrg[0]['id'];
							$dsr_data[0]['s_features'][$s_number]['support_request'][0]['reference_no'] = $dsr_asrg[0]['reference_no'];
							$dsr_data[0]['s_features'][$s_number]['support_request'][0]['date'] = date('jS F Y',strtotime($dsr_asrg[0]['date']));
							$dsr_data[0]['s_features'][$s_number]['support_request'][0]['detail'] = $dsr_asrg[0]['detail'];
						}
					}
					if($feat['detail'] == 4){
						if(isset($dsr_generator_log)){
							$dsr_data[0]['s_features'][$s_number]['generator_log'][0]['time_from'] = $dsr_generator_log[0]['time_from'];
							$dsr_data[0]['s_features'][$s_number]['generator_log'][0]['time_to'] = $dsr_generator_log[0]['time_to'];
							$dsr_data[0]['s_features'][$s_number]['generator_log'][0]['total_time'] = $dsr_generator_log[0]['total_time'];
							if(isset($dsr_glog_features)){
								$glog_feature_number = 0;
								foreach($dsr_glog_features as $feature){
									$dsr_data[0]['s_features'][$s_number]['generator_log'][0]['features'][$glog_feature_number]['id'] = $feature['id'];
									$dsr_data[0]['s_features'][$s_number]['generator_log'][0]['features'][$glog_feature_number]['name'] = $feature['name'];
									$dsr_data[0]['s_features'][$s_number]['generator_log'][0]['features'][$glog_feature_number]['type'] = $feature['type'];
									
									if($feature['type'] == 2){
										$dsr_data[0]['s_features'][$s_number]['generator_log'][0]['features'][$glog_feature_number]['val'] = $feature['val'];
										$dsr_data[0]['s_features'][$s_number]['generator_log'][0]['features'][$glog_feature_number]['level'] = $feature['level'];
									}
									if($feature['type'] == 3){
										$dsr_data[0]['s_features'][$s_number]['generator_log'][0]['features'][$glog_feature_number]['value'] = $feature['value'];
									}
									$glog_feature_number++;
								}
							}
						}
					}
				}
				$s_number++;
			}
		}
		if(isset($dsr_inventory)){
			$inventory_number = 0;
			foreach($dsr_inventory as $inv){
				$dsr_data[0]['inventory'][$inventory_number]['name'] = $inv['name'];
				$dsr_data[0]['inventory'][$inventory_number]['status'] = $inv['status'];
				if($inv['status'] == 2){
					$dsr_data[0]['inventory'][$inventory_number]['description'] = $inv['description'];
				}
				$inventory_number++;
			}
		}
		if(isset($dsr_bound)){
			if(isset($tool)){
				if($tool == 9){ $bound_number = 1; } else{ $bound_number = 0; } 
			}
			
			foreach($dsr_bound as $bound){
				$dsr_data[0]['bound'][$bound_number]['name'] = $bound['name'];
				if(isset($dsr_lane)){
					$lane_number = 0;
					foreach($dsr_lane as $lane){
						if($lane['bound'] == $bound['id']){
							$dsr_data[0]['bound'][$bound_number]['lane'][$lane_number]['name'] = $lane['name'];
							$dsr_data[0]['bound'][$bound_number]['lane'][$lane_number]['status'] = $lane['lane_status'];
							if($lane['lane_status'] == 1){
								$dsr_data[0]['bound'][$bound_number]['lane'][$lane_number]['closed_by'] = $lane['closed_by'];
								$dsr_data[0]['bound'][$bound_number]['lane'][$lane_number]['closed_from'] = $lane['closed_from'];
								$dsr_data[0]['bound'][$bound_number]['lane'][$lane_number]['closed_to'] = $lane['closed_to'];
								if(isset($lane['closed_from']) && isset($lane['closed_to'])){
									$dsr_data[0]['bound'][$bound_number]['lane'][$lane_number]['duration'] = $this->time_difference($lane['closed_from'], $lane['closed_to']);
								}
								$dsr_data[0]['bound'][$bound_number]['lane'][$lane_number]['description'] = $lane['description'];
							}
						}
						$lane_number++;
					}
					
				}
				if(isset($dsr_bound_inventory)){
					$bound_inventory_no = 0;
					foreach($dsr_bound_inventory as $inv){
						$dsr_data[0]['bound'][$bound_number]['inventory'][$bound_inventory_no]['name'] = $inv['inventory_name'].' '.$bound['name'];
						$dsr_data[0]['bound'][$bound_number]['inventory'][$bound_inventory_no]['status'] = $inv['status'];
						if($inv['status'] == 2){
							$dsr_data[0]['bound'][$bound_number]['inventory'][$bound_inventory_no]['description'] = $inv['description'];
						}
						$bound_inventory_no++;
					}
				}
				if(isset($tool)){
					if($tool == 9) { } else{ $bound_number++; }
				}
			} 
		}
		if(isset($all_inventory)){
			$all_inventory_number = 0;
			foreach($all_inventory as $inv){
				if($inv['installed_at'] == 1){
					$dsr_data[0]['name_inventory']['tollplaza'][$all_inventory_number]['name'] = $inv['name'];
					if(isset($dsr_inventory)){
						$plaza_inventory_number = 0;
						foreach($dsr_inventory as $plaza_inv){
							if($plaza_inv['inventory_id'] == $inv['id']){
								$dsr_data[0]['name_inventory']['tollplaza'][$all_inventory_number]['status'] = $plaza_inv['status'];
								if($plaza_inv['status'] == 2){
									$dsr_data[0]['name_inventory']['tollplaza'][$all_inventory_number]['description'] = $plaza_inv['description'];
								}
							}
							$plaza_inventory_number++;
						}
					}
				}
				if($inv['installed_at'] == 2){
					$dsr_data[0]['name_inventory']['bound_inventory'][$all_inventory_number]['name'] = $inv['name'];
					if(isset($dsr_bound_inventory)){
						$bound_inventory_number = 0;
						foreach($dsr_bound_inventory as $bound_inv){
							if($bound_inv['inventory_id'] == $inv['id']){
								if(isset($dsr_bound)){
								$dsr_bound_no = 0;
								foreach($dsr_bound as $bound){
									if($bound['id'] == $bound_inv['bound_id']){
										$dsr_data[0]['name_inventory']['bound_inventory'][$all_inventory_number]['bound'][$dsr_bound_no]['name'] = $bound_inv['bound_name'];
										$dsr_data[0]['name_inventory']['bound_inventory'][$all_inventory_number]['bound'][$dsr_bound_no]['status'] = $bound_inv['status'];
										if($bound_inv['status'] == 2){
											$dsr_data[0]['name_inventory']['bound_inventory'][$all_inventory_number]['bound'][$dsr_bound_no]['description'] = $bound_inv['description'];
										}
									}
									$dsr_bound_no++;
								}
							}
							}
							$bound_inventory_number++;
						}
					}
				}
				if($inv['installed_at'] == 3){
					$dsr_data[0]['name_inventory']['lane'][$all_inventory_number]['name'] = $inv['name'];
					if(isset($all_lane_inventory)){
						$all_lane_inventory_number = 0;
						foreach($all_lane_inventory as $lane_inv){
							if($lane_inv['inventory_id'] == $inv['id']){
								if(isset($dsr_bound)){
									if($dsr_data[0]['toolplaza_id'] == 9){ $dsr_bound_number = 1; } else{ $dsr_bound_number = 0; }
									foreach($dsr_bound as $bound){
										if($bound['id'] == $lane_inv['bound_id']){
											$dsr_data[0]['name_inventory']['lane'][$all_inventory_number]['bound'][$dsr_bound_number]['bound_name'] = $lane_inv['bound_name'];
											if(isset($dsr_lane)){
												$lane_number = 0;
												foreach($dsr_lane as $lane){
													if($lane['lane_id'] == $lane_inv['lane_id']){
														$dsr_data[0]['name_inventory']['lane'][$all_inventory_number]['bound'][$dsr_bound_number]['lane'][$lane_number]['id'] = $lane_inv['lane_id'];
														$dsr_data[0]['name_inventory']['lane'][$all_inventory_number]['bound'][$dsr_bound_number]['lane'][$lane_number]['lane_name'] = $lane_inv['lane'];
														$dsr_data[0]['name_inventory']['lane'][$all_inventory_number]['bound'][$dsr_bound_number]['lane'][$lane_number]['status'] = $lane_inv['status'];
														if($lane_inv['status'] == 2){
															$dsr_data[0]['name_inventory']['lane'][$all_inventory_number]['bound'][$dsr_bound_number]['lane'][$lane_number]['description'] = $lane_inv['description'];
														}
													}
													$lane_number++;
												}
											}
										}
										if($dsr_data[0]['toolplaza_id'] == 9){} else{ $dsr_bound_number++; }
									}
								}
							}
							$all_lane_inventory_number++;
						}
					}
				}
				$all_inventory_number++;
			}
		}
		/*?> <pre> <?php echo print_r($dsr_data);exit;*/
		//Data is extracted in variable $dsr_data 
		return array('dsr' => $dsr_data, 'dsr_lane_inventory' => $dsr_lane_inventory, 'generator_log' => $dsr_generator_log, 'support_request' => $dsr_asrg);
	}
	//function to load the required data from database for CRUD system
	public function sitereport_data_preload($id, $tool, $page, $para1){
		if($page == 'C'){
			/*$edit['north'] = 44;*/
			$edit = $this->dsr_create_update($id, $tool,$page, $para1);
		}
		if($page == 'R'){
			$edit = $this->dsr_read($id, $tool, $page, $para1);
			/*?><pre> <?php echo print_r($edit);exit;*/
			$edit['dsr_heading'][0]['dsr_date'] =  date( 'jS F Y',strtotime($edit['dsr_heading'][0]['dsr_date']));
			if(isset($edit['dsr_attendance'])){
				$dsr_a = 0;
				foreach($edit['dsr_attendance'] as $att){
					if($att['leave_from'] != ''){
						$edit['dsr_attendance'][$dsr_a]['leave_from'] = date( 'jS F Y', strtotime($att['leave_from']));
					}
					if($att['leave_to'] != ''){
						$edit['dsr_attendance'][$dsr_a]['leave_to'] = date( 'jS F Y', strtotime($att['leave_to']));
					}
					$dsr_a++;
				}
			}
			
		}
		if($page == 'U'){
			//PU stands for data accumulation before taking to the edit page.
			$edit = $this->dsr_create_update($id, $tool, $page, $para1);
			$read = $this->dsr_read($id, $tool, $page, $para1);
			$edit['dsr'] = $this->dsr_data($id, $tool, $read, $para1); 
			if(isset($edit['dsr']['dsr'][0]['d_features'])){
				$d_feature_no = 0;
				foreach($edit['dsr']['dsr'][0]['d_features'] as $feat){
					if($feat['type'] == 4){
						$edit['dsr']['dsr'][0]['d_features'][$feat['number']]['value'] = date('Y-m',strtotime($feat['value']));
					}
					$d_feature_no++;
				}
			}
			if(isset($edit['dsr']['dsr'][0]['s_features'])){
				$s_feature_no = 0;
				foreach($edit['dsr']['dsr'][0]['s_features'] as $feat){
					if($feat['val'] == 0){

						$edit['st'][$s_feature_no]['v'] = 0;
					}
					if($feat['val'] == 1){

						$edit['st'][$s_feature_no]['v'] = 1;
						if(isset($feat['generator_log'])){
							$edit['doc'][$s_feature_no]['v'] = 1;
							if(isset($feat['generator_log'][0]['features'])){
								$gen_no = 0;
								foreach($feat['generator_log'][0]['features'] as $feats){
									if(isset($edit['glogv_feature'])){
										$glogv_no = 0;
										foreach($edit['glogv_feature'] as $glogv){
											if($glogv['id'] == $feats['id']){
												$edit['dsr']['generator_log'][0]['glogv'][$glogv_no]['id'] = $glogv['id'];
												$edit['dsr']['generator_log'][0]['glogv'][$glogv_no]['name'] = $glogv['name'];
												$edit['dsr']['generator_log'][0]['glogv'][$glogv_no]['value'] = $feats['value'];
											}
											$glogv_no++;
										}
									}
									if(isset($edit['glogr_feature'])){
										$glogr_no = 0;
										foreach($edit['glogr_feature'] as $glogr){
											if($glogr['id'] == $feats['id']){
												$edit['dsr']['generator_log'][0]['glogr'][$glogr_no]['id'] = $glogr['id'];
												$edit['dsr']['generator_log'][0]['glogr'][$glogr_no]['name'] = $glogr['name'];
												$edit['dsr']['generator_log'][0]['glogr'][$glogr_no]['level'] = $feats['val'];
											}
											$glogr_no++;
										}
									}
								}
							}
							
						}
						if(isset($feat['support_request'])){
							$edit['doc'][$s_feature_no]['v'] = 1;
							
						}
					}
					$s_feature_no++;
				}
			}			
			if(isset($edit['dsr']['dsr_lane_inventory'])){
				if($tool == 9){}else{
					$north_number = 0;
					foreach($edit['north'] as $north){
						$dsr_l_i = 0;
						foreach($edit['dsr']['dsr_lane_inventory'] as $inv){
							if($inv['lane_id'] == $north['id']){
								$edit['dsr']['dsr'][0]['lane_inventory_north'][$north_number][$dsr_l_i]['lane_id'] = $inv['lane_id'];
								$edit['dsr']['dsr'][0]['lane_inventory_north'][$north_number][$dsr_l_i]['name'] = $inv['inventory_name'];
								$edit['dsr']['dsr'][0]['lane_inventory_north'][$north_number][$dsr_l_i]['status'] = $inv['status'];
								if($inv['status'] == 2){
									$edit['dsr']['dsr'][0]['lane_inventory_north'][$north_number][$dsr_l_i]['description'] = $inv['description'];
								}
								$dsr_l_i++;
							}

						}
						$north_number++;
					}
				}
				
				$south_number = 0;
				foreach($edit['south'] as $south){
					$dsr_l_s = 0;
					foreach($edit['dsr']['dsr_lane_inventory'] as $inv){
						if($inv['lane_id'] == $south['id']){
							$edit['dsr']['dsr'][0]['lane_inventory_south'][$south_number][$dsr_l_s]['lane_id'] = $inv['lane_id'];
							$edit['dsr']['dsr'][0]['lane_inventory_south'][$south_number][$dsr_l_s]['name'] = $inv['inventory_name'];
							$edit['dsr']['dsr'][0]['lane_inventory_south'][$south_number][$dsr_l_s]['status'] = $inv['status'];
							if($inv['status'] == 2){
								$edit['dsr']['dsr'][0]['lane_inventory_south'][$south_number][$dsr_l_s]['description'] = $inv['description'];
							}
							$dsr_l_s++;
						}

					}
					$south_number++;
				}
			}
		}
		$edit['dsr_heading'][0]['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
			/*?><pre> <?php echo print_r($edit);exit;*/
		return $edit;
	}
	//sub function used to create or update data in DSR tables from tollplaza
	public function dsr_create_update($id, $tool,$page, $para1){
		$north = $this->db->query('CALL select_lanes_n_bound('.$tool.')')->result_array();
		$this->db->next_result();
		$create['dsr_bound'] = $dsr_bound = $this->db->query('SELECT * FROM dsr_bound')->result_array();
		/*?> <?php echo print_r($this->db->last_query());exit;*/
		$south = $this->db->query('CALL select_lanes_s_bound('.$tool.')')->result_array();
		$this->db->next_result();
		$create['staff'] = $staff = $this->db->query('CALL staff_toolplaza(\''.$tool.'\')')->result_array();
		$this->db->next_result();
		$lane_inventory = $this->db->select('*')->from('dsr_inventory')->where(array('installed_at' => 3,'status' => 1))->get()->result_array();
		$bound_inventory = $this->db->select('*')->from('dsr_inventory')->where(array('installed_at' => 2, 'status' => 1))->get()->result_array();
		$tool_inventory =  $this->db->select('*')->from('dsr_inventory')->where(array('installed_at' => 1, 'status' => 1))->get()->result_array();
		$status_feature =  $this->db->select('*')->from('dsr_features')->where(array('type' => 1, 'status' => 1))->get()->result_array();
		$description_feature = $this->db->select('*')->from('dsr_features')->where(array('type' => 3, 'status' => 1))->get()->result_array();
	
		$descriptions_feature = $this->db->select('*')->from('dsr_features')->where(array('type' => 4, 'status' => 1))->get()->result_array();
		$i = 0;
		$rating_feature = $this->db->select('*')->from('dsr_features')->where(array('type' => 2, 'status' => 1))->get()->result_array();
		$features_m2m_options = $this->db->select('feature_id, option_id')->from('dsr_m2m_features_options')->get()->result_array();
		$features_options = $this->db->select('id,name,type,value,status')->from('dsr_options')->where(array('status' => 1))->get()->result_array();
		$glogv_features = $this->db->select('*')->from('dsr_generator_log_features')->where(array('type' => 3,'status' => 1))->get()->result_array();
		
		$glogr_features = $this->db->select('*')->from('dsr_generator_log_features')->where(array('type' => 2,'status' => 1))->get()->result_array();
		$generator_log_m2m_feature_options = $this->db->select('feature_id, option_id')->from('dsr_m2m_generator_log_features_options')->get()->result_array();
		// echo "<pre>"; print_r($generator_log_m2m_feature_options);
		// echo date("F d Y", $generator_log_m2m_feature_options[0][created_at] );
		//  exit;
		$i = 0;
		foreach($tool_inventory as $t_inventory){
			$j = $i + 1;
			$create['t_inventory'][$i]['id'] = $t_inventory['id'];
			$create['t_inventory'][$i]['abr'] = 't_inv_'.$j;
			$create['t_inventory'][$i]['name'] = $t_inventory['name'];
			$i++;
		} 
		if($tool == 9){ $i = 1; }
		else{ $i = 0; }
		foreach($dsr_bound as $bound){
			if($tool == 9){ $j = 1; } else{ $j = 0; }

			$b = $bound['name'];
			foreach($bound_inventory as $b_inventory){
				$k = $j+1;
				$create['b_inventory'][$i][$j]['id'] = $b_inventory['id'];
				$create['b_inventory'][$i][$j]['bound_id'] = $bound['id'];
				$create['b_inventory'][$i][$j]['abr'] = 'b_inv_'.$k.'_'.$bound['abr'];
				$create['b_inventory'][$i][$j]['name'] = $b_inventory['name'].' '.$bound['abr'];
				if($tool == 9){ } else{ $j++; }
			}
			if($tool == 9){ } else{ $i++; }
		}
		$i = 0;
		foreach($north as $north_lanes){
			$k = $i + 1;
			$create['north'][$i]['id'] = $north_lanes['id'];
			$create['north'][$i]['abr'] = 'lane_n_'.$k;
			$create['north'][$i]['name'] = 'Lane '.$north_lanes['name'];
			$create['north'][$i]['inv_name'] = $north_lanes['name'];

			$j = 0; 
			foreach($lane_inventory as $l_inventory){
				$l = $j + 1;
				$create['inventory_north'][$i][$j]['lane_id'] = $north_lanes['id'];
				$create['inventory_north'][$i][$j]['id'] = $l_inventory['id'];
				$create['inventory_north'][$i][$j]['abr'] = 'inv_'.$l.'_n_'.$k;
				$create['inventory_north'][$i][$j]['name'] = $l_inventory['name'].' '.$create['north'][$i]['inv_name'];
				$j++;
			}
			$i++;
		}
		$i = 0;
		foreach($south as $south_lanes){
			$k = $i + 1;
			$create['south'][$i]['id'] = $south_lanes['id'];
			$create['south'][$i]['abr'] = 'lane_s_'.$k;
			$create['south'][$i]['name'] = 'Lane '.$south_lanes['name'];
			$create['south'][$i]['inv_name'] = $south_lanes['name'];
			$j = 0; 
			foreach($lane_inventory as $l_inventory){
				$l = $j + 1;
				$create['inventory_south'][$i][$j]['lane_id'] = $south_lanes['id'];
				$create['inventory_south'][$i][$j]['id'] = $l_inventory['id'];
				$create['inventory_south'][$i][$j]['abr'] = 'inv_'.$l.'_s_'.$k;
				$create['inventory_south'][$i][$j]['name'] = $l_inventory['name'].' '.$create['south'][$i]['inv_name'];
				$j++;
			}
			$i++;
		}
		$i = 0;
		foreach($status_feature as $feat){
			$j = $i + 1;
			$create['s_feature'][$i]['id'] = $feat['id'];
			$create['s_feature'][$i]['abr'] = 's_feature_'.$j;
			$create['s_feature'][$i]['name'] = $feat['name'];
			$create['s_feature'][$i]['detail'] = $feat['detail'];
			$n = 0;
			foreach($features_m2m_options as $option){
				if($option['feature_id'] == $feat['id']){
					/*$s_feature[$i]['options'][$m] = $option['option_id'];*/
					$m = 0;
					foreach($features_options as $opt){
						if($option['option_id'] == $opt['id']){
							$create['s_feature'][$i]['option'][$m]['abr'] = 'option'.$opt['value'];
							$create['s_feature'][$i]['option'][$m]['name'] = $opt['name'];
							$create['s_feature'][$i]['option'][$m]['value'] = $opt['value'];
						}
						$m++;
					}
				}
				$n++;
			}
			if($feat['detail'] == 4){
				$r = 0;
				foreach($glogv_features as $feature){
					$s = $r + 1;
					$create['glogv_feature'][$r]['id'] = $feature['id'];
					$create['glogv_feature'][$r]['abr'] = $create['s_feature'][$i]['abr'].'_glogv_feature_'.$s;
					$create['glogv_feature'][$r]['name'] = $feature['name'];
					$create['glogv_feature'][$r]['detail'] = $feature['detail'];
					$r++;
				}
				$r = 0;
				foreach($glogr_features as $feature){
					$s = $r + 1;
					$create['glogr_feature'][$r]['id'] = $feature['id'];
					$create['glogr_feature'][$r]['abr'] = $create['s_feature'][$i]['abr'].'_glogr_feature_'.$s;
					$create['glogr_feature'][$r]['name'] = $feature['name'];
					$create['glogr_feature'][$r]['detail'] = $feature['detail'];
					$n = 0;
					foreach($generator_log_m2m_feature_options as $optional){
						if($optional['feature_id'] == $feature['id']){
							$glogr_feature[$i]['options'][$n] = $optional['option_id'];
							$m = 0;
							foreach($features_options as $op){
								if($optional['option_id'] == $op['id']){
									$create['glogr_feature'][$r]['option'][$n]['abr'] = 'option'.$op['value'];
									$create['glogr_feature'][$r]['option'][$n]['name'] = $op['name'];
									$create['glogr_feature'][$r]['option'][$n]['value'] = $op['value'];

								}
								$m++;
							}
						}
						$n++;
					}
					$r++;
				}
			}
			$i++;
		}
		$i = 0;
		foreach($description_feature as $feat){
			$j = $i + 1;
				$create['d_feature'][$i]['id'] = $feat['id'];
				$create['d_feature'][$i]['abr'] = 'd_feature_'.$j;
				$create['d_feature'][$i]['name'] = $feat['name'];
				$create['d_feature'][$i]['detail'] = $feat['detail'];
			$i++;
		}
		foreach($descriptions_feature as $feat){
			$j = $i + 1;
			$create['d_feature'][$i]['id'] = $feat['id'];
			$create['d_feature'][$i]['abr'] = 'd_feature_'.$j;
			$create['d_feature'][$i]['name'] = $feat['name'];
			$create['d_feature'][$i]['detail'] = $feat['detail'];
			$i++;
		}
		$i = 0;
		foreach($rating_feature as $feat){
			$j = $i + 1;
			$create['r_feature'][$i]['id'] = $feat['id'];
			$create['r_feature'][$i]['abr'] = 'r_feature_'.$j;
			$create['r_feature'][$i]['name'] = $feat['name'];
			$create['r_feature'][$i]['detail'] = $feat['detail'];
			$n = 0;
			foreach($features_m2m_options as $option){
				if($option['feature_id'] == $feat['id']){
					/*$r_feature[$i]['options'][$n] = $option['option_id'];*/
					$m = 0;
					foreach($features_options as $opt){
						 $o = $m+1;
						if($option['option_id'] == $opt['id']){
							$create['r_feature'][$i]['option'][$m]['abr'] = 'option'.$opt['value'];
							$create['r_feature'][$i]['option'][$m]['name'] = $opt['name'];
							$create['r_feature'][$i]['option'][$m]['value'] = $opt['value'];

						}
						$m++;
					}
				}
				$n++;
			}
			$i++;
		}
		$i = 0;
		foreach($staff as $s){
			$j = $i + 1;
			$create['staff'][$i]['abr'] = 'staff_'.$j;
			$create['staff'][$i]['name'] = $s['fname'].' '.$s['lname'];
			$create['staff'][$i]['list_name'] = $j.'. '.$s['fname'].' '.$s['lname'];

			$i++;
		}
		$create['dsr_heading'][0]['toolplaza_id'] = $this->db->select('id')->from('toolplaza')->where(array('id' => $tool))->get()->row()->id;
		$create['dsr_heading'][0]['tollplaza_name'] = $this->db->get_where('toolplaza',array('id' => $tool))->row()->name;
		$create['phone']		= $this->db->get_where('tpsupervisor', array('id' => $id))->row()->contact;
		$create['dsr_heading'][0]['supervisor_id'] = $id;
		$create['dsr_heading'][0]['supervisor_name'] = $this->db->get_where('tpsupervisor', array('id' => $id))->row()->fname.' '.$this->db->get_where('tpsupervisor', array('id' => $id))->row()->lname;
		$create['dsr_heading'][0]['supervisor_contact'] = $this->db->get_where('tpsupervisor', array('id' => $id))->row()->contact;
		$create['dsr_heading'][0]['supervisor_designation'] = $this->db->get_where('tpstaff', array('contact' => $create['dsr_heading'][0]['supervisor_contact']))->row()->designation;
		$create['dsr_heading'][0]['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
		/*?> <?php echo print_r($descriptions_feature);exit;*/
		return $create;
	}
	//sub function used to load necessary data for reading dsr from tables
	public function dsr_read($id, $tool, $page, $para1){
		$read['dsr_bound'] = db()->get('dsr_bound')->result_array();
		$read['dsr_heading'] = db()->get_where('view_dsr_heading', array('id' => $para1))->result_array();
		// echo '<pre>';
		// echo print_r($para1); exit;
		$read['dsr_inventory'] = db()->get_where('view_dsr_inventory', array('dsr_id' => $para1))->result_array();

		$read['tp_lanes'] = db()->get('tp_lanes')->result_array();
		$read['dsr_bound_inventory'] = db()->get_where('view_dsr_bound_inventory', array('dsr_id' =>$para1))->result_array();
		$read['dsr_lane'] = db()->select('*')->from('view_dsr_lanes')->where(array('dsr_id' => $para1))->order_by('id', 'ASC')->get()->result_array();
		$read['dsr_lanee_inventory'] = db()->select('*')->from('view_dsr_lane_inventory')->where(array('dsr_id' => $para1))->order_by('inventory_id', 'ASC')->get()->result_array();
		$read['dsr_lane_inventory'] = db()->select('*')->from('view_dsr_lane_inventory')->where(array('dsr_id' => $para1))->get()->result_array();
		$read['dsr_d_features'] = db()->get_where('view_dsr_d_features', array('dsr_id' => $para1))->result_array();
		$read['dsr_r_features'] = db()->get_where('view_dsr_r_features', array('dsr_id' => $para1))->result_array();
		$read['dsr_s_features'] = db()->get_where('view_dsr_s_features', array('dsr_id' => $para1))->result_array();
		$read['dsr_generator_log'] = db()->get_where('dsr_generator_log', array('dsr_id' => $para1))->result_array();
		$read['dsr_glog_features'] = db()->get_where('view_dsr_generator_features', array('dsr_id' => $para1))->result_array();
		$read['dsr_attendance'] = db()->get_where('view_dsr_attendance', array('dsr_id' => $para1))->result_array();
		$read['all_inventory'] = db()->get_where('dsr_inventory', array('status' => 1))->result_array();
		$read['dsr_asrg'] = db()->get_where('dsr_asrg', array('dsr_id' => $para1))->result_array();
		$read['staff'] = $this->db->get_where('view_dsr_attendance', array('dsr_id' => $para1))->result_array();
		return $read;
	}
	//function used to show dsr list on main DSR page 
	public function list_dsr($id, $tool){
		$dsr = $this->db->query('CALL list_dsr(\''.$id.'\',\''.$tool.'\');')->result_array();
		$this->db->next_result();
		//echo print_r($dsr);exit;
		return $dsr; 
	}
	//function used to delete dsr single entry from database 
	public function delete_dsr($id, $para2){
		$dsr = $this->db->query('CALL delete_dsr(\''.$para2.'\');');
		return $dsr;
	}
	//function used to limit loading DSRs on admin page 
	public function list_dsr_limit($id, $tool, $limit){
		$this->db->order_by('id','DESC');
		$this->db->limit($limit);
		if($id && $tool){
			$this->db->where('toolplaza_id', $tool);
			$this->db->where('supervisor_id', $id);
		}
		if($tool){
			$this->db->where('toolplaza_id', $tool);
		}
		$dsr = $this->db->get('dsr')->result_array();
		
		return $dsr; 
	}
	public function time_difference($start, $end){
		$end_time = new DateTime($end);
		$start_time = new DateTime($start);
		$duration_object = $end_time->diff($start_time);
		if(isset($duration_object->h) && isset($duration_object->i)){
			$duration = $duration_object->h.' Hours and '.$duration_object->i.' Minutes';
		}
		if($duration_object->h == 0){
			$duration = $duration_object->i.' Minutes';
		}
		if($duration_object->i == 0){
			$duration = $duration_object->h.' Hours';
		}
		return $duration;
	}
	
}