<?php 
class Admin_model extends CI_MODEL{
    function __construct(){
		parent::__construct();		
	}
	function admin_tool(){
		$tool = $this->db->order_by('id', 'ASC')->get_where('toolplaza', array('status' => '1'))->result_array();
		return $tool;
	}
	function omc_tool(){
		$tool = $this->db->order_by('id', 'ASC')->get_where('toolplaza', array('status' => '1','omc'=>$this->session->userdata('omcid')))->result_array();
		return $tool;
	}
	function comprehensive_report($para1){
		if($para1 == 'admin'){
			$tool = $this->admin_tool();
		}
		if($para1 == 'omc'){
			$tool = $this->omc_tool();
		}
		
	   $omc = $this->db->order_by('id', 'ASC')->get('omc')->result_array();
	   $l = 0;
	   foreach($tool as $toll){
		   $dsr = $this->dsr_model->dsr_tool($toll['id']);
		   $tpsupervisor[$l] = $this->db->order_by('id','ASC')->get_where('tpsupervisor', array('id' => $toll['incharge_id']))->result_array();
		   $lanes[$l] = $this->db->get_where('tp_lanes', array('id' => $toll['id']))->result_array();
		   $staff[$l] = $this->db->get_where('tpstaff', array('id' => $toll['id']))->result_array();
		   /*?> <pre><?php echo print_r($tpsupervisor);?> </pre> <?php*/
		   if(isset($tpsupervisor[$l][0])){$incharge[$l] = $tpsupervisor[$l][0]; $toolplaza[$l]['incharge'] = $incharge[$l]['fname'].' '.$incharge[$l]['lname'];}
		   if(!isset($tpsupervisor[$l][0])){$incharge[$l] = ''; $toolplaza[$l]['incharge'] =  '';}

		   $toolplaza[$l]['name'] = $toll['name'];
		   
		   $toolplaza[$l]['dsr'] = $dsr;
		   $i = 0;
		   foreach($dsr as $d){
			   if($d){
				   $omc_name = $this->db->select('name')->order_by('id', 'ASC')->get_where('omc', array('id' => $d[0]['omc']))->result_array();
				   $dsr_lane = $this->db->get_where('dsr_lane', array('dsr_id' =>$d[0]['id']))->result_array();
				   $dsr_attendance = $this->db->get_where('dsr_attendance', array('dsr_id' =>$d[0]['id']))->result_array();
				   $toolplaza[$l]['omc_name'] = $omc_name[0]['name'];
				   if($d[0]['ptz_north_status'] == 1){
					   $toolplaza[$l]['ptz_north_status'] = 'NPTZ';
				   }elseif($d[0]['ptz_north_status'] == 0){
					   $toolplaza[$l]['ptz_north_status'] = 'Ok';
				   }
				   if($d[0]['ptz_south_status'] == 1){
					   $toolplaza[$l]['ptz_south_status'] = 'SPTZ';
				   }elseif($d[0]['ptz_south_status'] == 0){
					   $toolplaza[$l]['ptz_south_status'] = 'Ok';
				   } 
				   $p = 1; $lane_no = 0;
				   foreach($dsr_lane as $lane){
					   /*?> <pre> <?php echo print_r($lane); ?> </pre><?php exit;*/
					   if($lane['lane_status'] == 0){ $toolplaza[$l]['lane_status'][0][$p] = 'Ok'; }
					   elseif($lane['lane_status'] == 1){ $toolplaza[$l]['lane_status'][0][$p] = $d[0]['lane'][$lane_no]['name']; }		
					   if($lane['lane_camera_status'] == 0){ $toolplaza[$l]['camera_status'][0][$p] = 'Ok'; }
					   elseif($lane['lane_camera_status'] == 1){ $toolplaza[$l]['camera_status'][0][$p] = $d[0]['lane'][$lane_no]['name']; }
					   
					   /*?> <pre><?php echo print_r($lane);exit;*/
					  /* if($lane['inventory_ohls_status'] == 1 && $lane['inventory_boom_arm_status'] == 1 && $lane['inventory_boom_mechanical_status'] == 1 && $lane['inventory_thermal_printer_status'] == 1 && $lane['inventory_tct_status'] == 1 && $lane['inventory_lanepc_status'] == 1 && $lane['inventory_traffic_light_status'] == 1 && $lane['inventory_pfd_status'] == 1){
						   $toolplaza[$l]['lane'][$p]['inventory_status'] = '1';
						   $toolplaza[$l]['lane']['inventory_description'] = 'All inventory is Ok';
					   }else{
						   $toolplaza[$l]['lane'][$p]['inventory_status'] = '';
					   }*/
						   
					   if($lane['inventory_ohls_status'] == 1){ $toolplaza[$l]['inventory_ohls_status'][0][$p] = 'Ok'; }
					   elseif($lane['inventory_ohls_status'] == 2){ $toolplaza[$l]['inventory_ohls_status'][0][$p] = $d[0]['lane'][$lane_no]['name']; }
					   if($lane['inventory_boom_arm_status'] == 1){ $toolplaza[$l]['inventory_boom_arm_status'][0][$p] = 'Ok'; }
					   elseif($lane['inventory_boom_arm_status'] == 2){ $toolplaza[$l]['inventory_boom_arm_status'][0][$p] = $d[0]['lane'][$lane_no]['name']; }
					   if($lane['inventory_boom_mechanical_status'] == 1){ $toolplaza[$l]['inventory_boom_mechanical_status'][0][$p] = 'Ok'; }
					   elseif($lane['inventory_boom_mechanical_status'] == 2){ $toolplaza[$l]['inventory_boom_mechanical_status'][0][$p] = $d[0]['lane'][$lane_no]['name']; }
					   if($lane['inventory_thermal_printer_status'] == 1){ $toolplaza[$l]['inventory_thermal_printer_status'][0][$p] = 'Ok'; }
					   elseif($lane['inventory_thermal_printer_status'] == 2){ $toolplaza[$l]['inventory_thermal_printer_status'][0][$p] = $d[0]['lane'][$lane_no]['name']; }
					   if($lane['inventory_tct_status'] == 1){ $toolplaza[$l]['inventory_tct_status'][0][$p] = 'Ok'; }
					   elseif($lane['inventory_tct_status'] == 2){ $toolplaza[$l]['inventory_tct_status'][0][$p] = $d[0]['lane'][$lane_no]['name']; }
					   if($lane['inventory_lanepc_status'] == 1){ $toolplaza[$l]['inventory_lanepc_status'][0][$p] = 'Ok'; }
					   elseif($lane['inventory_lanepc_status'] == 2){ $toolplaza[$l]['inventory_lanepc_status'][0][$p] = $d[0]['lane'][$lane_no]['name']; }
					   if($lane['inventory_traffic_light_status'] == 1){ $toolplaza[$l]['inventory_traffic_light_status'][0][$p] = 'Ok'; }
					   elseif($lane['inventory_traffic_light_status'] == 2){ $toolplaza[$l]['inventory_traffic_light_status'][0][$p] = $d[0]['lane'][$lane_no]['name']; }
					   if($lane['inventory_pfd_status'] == 1){ $toolplaza[$l]['inventory_pfd_status'][0][$p] = 'Ok'; }
					   elseif($lane['inventory_pfd_status'] == 2){ $toolplaza[$l]['inventory_pfd_status'][0][$p] = $d[0]['lane'][$lane_no]['name']; }
					   $lane_no++;
					   $p++;
				   }$s1 = 1;
				   foreach($dsr_attendance as $s){
					   
					   $s['fname'] = $this->db->where(array('id' => $s['staff_id']))->get('tpstaff')->row()->fname;
					   $s['lname'] = $this->db->where(array('id' => $s['staff_id']))->get('tpstaff')->row()->lname;
					  /* ?><pre><?php echo print_r($s);  ?></pre><?php exit;*/
					   if($s['attendance_status'] && $s['attendance_status'] != 3){
						   $toolplaza[$l]['not_present'][$s1] = $s['fname'].' '.$s['lname'];
					   }
					   else{
						   $toolplaza[$l]['not_present'][$s1] = 'present';
					   }
					   $s1++;
				   }
				   /*?> <pre> <?php echo print_r($s); ?> </pre><?php exit;*/
				   if($d[0]['status_shutdown'] == 0){
					   $toolplaza[$l]['status_shutdown'] = 'No';
				   }
				   if($d[0]['status_shutdown'] == 1){
					   $toolplaza[$l]['status_shutdown'] = 'Yes';
				   }
				   if(strtotime($d[0]['mtr_status'])){
					   $toolplaza[$l]['mtr_status'] = 'Upto '.date('F-Y', strtotime($d[0]['mtr_status']));
				   }
				   if(strtotime($d[0]['mtr_archiving_status'])){
					   $toolplaza[$l]['mtr_archiving_status'] = 'Upto '.date('F-Y', strtotime($d[0]['mtr_archiving_status']));
				   }
				   if(strtotime($d[0]['mtr_upto'])){
					   $toolplaza[$l]['mtr_upto'] = 'Upto '.date('F-Y', strtotime($d[0]['mtr_upto']));
				   }
				   if($d[0]['status_link_description']){
					   $toolplaza[$l]['status_link_description'] = $d[0]['status_link_description'];
				   }
				   elseif(!$d[0]['status_link_description']){
					   $toolplaza[$l]['status_link_description'] = 'Ok';
				   }
				   if($d[0]['asrg'] == 2){
					   $toolplaza[$l]['support_request'] = 'Yes';
				   }
				   elseif($d[0]['asrg'] == 1){
					   $toolplaza[$l]['support_request'] = 'No';
				   }
				   
				   $toolplaza[$l]['dsr'] = $d;
				    /*?> <pre><?php echo print_r($toolplaza);exit;*/
				   
			   }
			   elseif(!$d){
				   $omc_name = '';
				   $dsr_lane = '';
				   $dsr_attendance_lane = '';
				   $toolplaza[$l]['dsr'] = 'DSR Does not exist';
				   $toolplaza[$l]['dsr_lane'] = '';
				   $toolplaza[$l]['dsr_attendance'] = '';					
				   $toolplaza[$l]['omc_name'] = ''; 
				   $toolplaza[$l]['status_shutdown'] = ''; 
				   $toolplaza[$l]['mtr_status'] = ''; 
				   $toolplaza[$l]['mtr_archiving_status'] = ''; 
				   $toolplaza[$l]['mtr_upto'] = ''; 
				   $toolplaza[$l]['status_link_description'] = '';
				   $toolplaza[$l]['support_request'] = '';
				   $toolplaza[$l]['ptz_north_status'] = '';
				   $toolplaza[$l]['ptz_south_status'] = '';
				   
				   $n1 = 0;
				   foreach($lanes[$n1] as $n){
					   $toolplaza[$l]['lane_status'][0][$n1] = '';
					   $toolplaza[$l]['camera_status'][0][$n1] = '';
					   $toolplaza[$l]['inventory_ohls_status'][0][$n1] = '';
					   $toolplaza[$l]['inventory_boom_arm_status'][0][$n1] = '';
					   $toolplaza[$l]['inventory_boom_mechanical_status'][0][$n1] = '';
					   $toolplaza[$l]['inventory_thermal_printer_status'][0][$n1] = '';
					   $toolplaza[$l]['inventory_tct_status'][0][$n1] = '';
					   $toolplaza[$l]['inventory_lanepc_status'][0][$n1] = '';
					   $toolplaza[$l]['inventory_traffic_light_status'][0][$n1] = '';
					   $toolplaza[$l]['inventory_pfd_status'][0][$n1] = '';
					   $n1++;
				   }
				   $s1 = 0;
				   foreach($staff[$s1] as $s){
					   $toolplaza[$l]['not_present'][$s1] = '';
					   $s1++;
				   }
			   }
			   $i++;
		   }
		   $l++;
	   }
	   /*?> <pre> <?php echo print_r($toolplaza); ?> </pre><?php exit;*/
	   return array('toolplaza' => $toolplaza);
   	}
   	
	function summary_dashboard_dtr($dtr, $date, $href, $current, $dtr_array, $toolplaza, $dtr_count){
		
		if($dtr_array){
			
			
			
			$cl1 = 'SELECT SUM(class1) FROM DTR WHERE '.$date;
			$cl2 = 'SELECT SUM(class2) FROM DTR WHERE '.$date;
			$cl3 = 'SELECT SUM(class3) FROM DTR WHERE '.$date;
			$cl4 = 'SELECT SUM(class4) FROM DTR WHERE '.$date;
			$cl5 = 'SELECT SUM(class5) FROM DTR WHERE '.$date;
			$cl6 = 'SELECT SUM(class6) FROM DTR WHERE '.$date;
			$cl7 = 'SELECT SUM(class7) FROM DTR WHERE '.$date;
			$cl8 = 'SELECT SUM(class8) FROM DTR WHERE '.$date;
			$cl9 = 'SELECT SUM(class9) FROM DTR WHERE '.$date;
			$cl10 = 'SELECT SUM(class10) FROM DTR WHERE '.$date;
			$tot = 'SELECT SUM(total) FROM DTR WHERE '.$date;
			
			$class[1] = $this->db->query($cl1)->row_array();
			$class[2] = $this->db->query($cl2)->row_array();
			$class[3] = $this->db->query($cl3)->row_array();
			$class[4] = $this->db->query($cl4)->row_array();
			$class[5] = $this->db->query($cl5)->row_array();
			$class[6] = $this->db->query($cl6)->row_array();
			$class[7] = $this->db->query($cl7)->row_array();
			$class[8] = $this->db->query($cl8)->row_array();
			$class[9] = $this->db->query($cl9)->row_array();
			$class[10] = $this->db->query($cl10)->row_array();
			$total = $this->db->query($tot)->row_array();
		
			/*$tollplaza['name'] = $toolplaza[0]['name'];*/
			$tollplaza['tollplaza'] = $dtr_array[0]['toolplaza'];
			$tollplaza['dtr']['traffic']['dtr_id'] =  $dtr_array[0]['id'];
			$tollplaza['dtr']['traffic']['date'] =  $dtr_array[0]['for_date'];
			$tollplaza['dtr']['traffic']['class1']['label'] =  'Car';
			$tollplaza['dtr']['traffic']['class2']['label'] =  'Wagon';
			$tollplaza['dtr']['traffic']['class3']['label'] =  'Truck';
			$tollplaza['dtr']['traffic']['class4']['label'] =  'Bus';
			$tollplaza['dtr']['traffic']['class5']['label'] =  'AT Truck';
			$tollplaza['dtr']['traffic']['class1']['data'] =  $class[1]['SUM(class1)'];
			$tollplaza['dtr']['traffic']['class2']['data'] =  $class[2]['SUM(class2)'];
			$tollplaza['dtr']['traffic']['class3']['data'] = $class[3]['SUM(class3)'] + $class[5]['SUM(class5)'] + $class[6]['SUM(class6)'];
			$tollplaza['dtr']['traffic']['class4']['data'] =  $class[4]['SUM(class4)'];
			$tollplaza['dtr']['traffic']['class5']['data'] =  $class[7]['SUM(class7)'] + $class[8]['SUM(class8)']  + $class[9]['SUM(class9)'] + $class[10]['SUM(class10)'];
			$tollplaza['dtr']['traffic']['total'] = $total['SUM(total)'];
			
			$sql = "Select * From terrif Where (start_date <= '".$dtr_array[0]['for_date']."' AND end_date >= '".$dtr_array[0]['for_date']."')";
			
			$tarrif =  $this->db->query($sql)->result_array();
			

			if($tarrif){
				$tollplaza['dtr']['revenue']['special_message'] = " ";
				$tollplaza['dtr']['revenue']['class1']['label'] = 'Car';
				$tollplaza['dtr']['revenue']['class2']['label'] = 'Wagon';
				$tollplaza['dtr']['revenue']['class3']['label'] = 'Truck';
				$tollplaza['dtr']['revenue']['class4']['label'] = 'Bus';
				$tollplaza['dtr']['revenue']['class5']['label'] = 'AT Truck';
				$tollplaza['dtr']['revenue']['class1']['data'] = $class[1]['SUM(class1)'] * $tarrif[0]['class_1_value'];
				$tollplaza['dtr']['revenue']['class2']['data'] = $class[2]['SUM(class2)']* $tarrif[0]['class_2_value'];
				$tollplaza['dtr']['revenue']['class3']['data'] =	($class[3]['SUM(class3)'] *  $tarrif[0]['class_3_value']) + ($class[5]['SUM(class5)'] * $tarrif[0]['class_5_value']) + ($class[6]['SUM(class6)'] * $tarrif[0]['class_6_value']);
				$tollplaza['dtr']['revenue']['class4']['data'] = $class[4]['SUM(class4)'] * $tarrif[0]['class_4_value'];
				$tollplaza['dtr']['revenue']['class5']['data'] = ($class[7]['SUM(class7)']  * $tarrif[0]['class_7_value']) + ($class[8]['SUM(class8)'] *  $tarrif[0]['class_8_value']) + ($class[9]['SUM(class9)'] * $tarrif[0]['class_9_value']) + ($class[10]['SUM(class10)'] * $tarrif[0]['class_10_value']);
				$tollplaza['dtr']['revenue']['total'] = ($class[1]['SUM(class1)'] * $tarrif[0]['class_1_value']) + ($class[2]['SUM(class2)'] * $tarrif[0]['class_2_value']) + ($class[3]['SUM(class3)'] * $tarrif[0]['class_3_value']) + ($class[4]['SUM(class4)'] * $tarrif[0]['class_4_value']) + ($class[5]['SUM(class5)'] * $tarrif[0]['class_5_value']) + ($class[6]['SUM(class6)'] * $tarrif[0]['class_6_value']) + ($class[7]['SUM(class7)'] * $tarrif[0]['class_7_value']) + ($class[8]['SUM(class8)'] * $tarrif[0]['class_8_value']) + ($class[9]['SUM(class9)'] * $tarrif[0]['class_9_value']) + ($class[10]['SUM(class10)']* $tarrif[0]['class_10_value']);
			}
			
		}
		else{
			
			$tollplaza['dtr']['traffic']['class1']['label'] =  'Car';
			$tollplaza['dtr']['traffic']['class2']['label'] =  'Wagon';
			$tollplaza['dtr']['traffic']['class3']['label'] =  'Truck';
			$tollplaza['dtr']['traffic']['class4']['label'] =  'Bus';
			$tollplaza['dtr']['traffic']['class5']['label'] =  'AT Truck';
			$tollplaza['dtr']['traffic']['class1']['data'] = 0;
			$tollplaza['dtr']['traffic']['class2']['data'] = 0;
			$tollplaza['dtr']['traffic']['class3']['data'] = 0;
			$tollplaza['dtr']['traffic']['class4']['data'] = 0;
			$tollplaza['dtr']['traffic']['class5']['data'] = 0;
			$tollplaza['dtr']['traffic']['total'] = 0;
			$tollplaza['dtr']['revenue']['class1']['data'] = 0;
			$tollplaza['dtr']['revenue']['class2']['data'] = 0;
			$tollplaza['dtr']['revenue']['class3']['data'] = 0;
			$tollplaza['dtr']['revenue']['class4']['data'] = 0; 
			$tollplaza['dtr']['revenue']['class5']['data'] = 0;
			$tollplaza['dtr']['revenue']['total'] = 0;
				
					
						
			
		}
		return array('tollplaza' => $tollplaza);
	}
	function traffic_dashboard_dtr($dtr, $date, $href, $current, $dtr_array, $toolplaza, $dtr_count){
		
		if($dtr_array){
			 

			
			$cl1 = 'SELECT SUM(class1) FROM DTR WHERE '.$date;
			$cl2 = 'SELECT SUM(class2) FROM DTR WHERE '.$date;
			$cl3 = 'SELECT SUM(class3) FROM DTR WHERE '.$date;
			$cl4 = 'SELECT SUM(class4) FROM DTR WHERE '.$date;
			$cl5 = 'SELECT SUM(class5) FROM DTR WHERE '.$date;
			$cl6 = 'SELECT SUM(class6) FROM DTR WHERE '.$date;
			$cl7 = 'SELECT SUM(class7) FROM DTR WHERE '.$date;
			$cl8 = 'SELECT SUM(class8) FROM DTR WHERE '.$date;
			$cl9 = 'SELECT SUM(class9) FROM DTR WHERE '.$date;
			$cl10 = 'SELECT SUM(class10) FROM DTR WHERE '.$date;
			$tot = 'SELECT SUM(total) FROM DTR WHERE '.$date;
			
			$class[1] = $this->db->query($cl1)->row_array();
			$class[2] = $this->db->query($cl2)->row_array();
			$class[3] = $this->db->query($cl3)->row_array();
			$class[4] = $this->db->query($cl4)->row_array();
			$class[5] = $this->db->query($cl5)->row_array();
			$class[6] = $this->db->query($cl6)->row_array();
			$class[7] = $this->db->query($cl7)->row_array();
			$class[8] = $this->db->query($cl8)->row_array();
			$class[9] = $this->db->query($cl9)->row_array();
			$class[10] = $this->db->query($cl10)->row_array();
			$total = $this->db->query($tot)->row_array();
		
			/*$tollplaza['name'] = $toolplaza[0]['name'];*/
			$tollplaza['dtr']['traffic']['dtr_id'] =  $dtr_array[0]['id'];
			$tollplaza['dtr']['traffic']['date'] =  $dtr_array[0]['for_date'];
			$tollplaza['dtr']['traffic']['class1']['label'] =  'Car';
			$tollplaza['dtr']['traffic']['class2']['label'] =  'Wagon';
			$tollplaza['dtr']['traffic']['class3']['label'] =  'Truck';
			$tollplaza['dtr']['traffic']['class4']['label'] =  'Bus';
			$tollplaza['dtr']['traffic']['class5']['label'] =  'AT Truck';
			$tollplaza['dtr']['traffic']['class1']['data'] =  $class[1]['SUM(class1)'];
			$tollplaza['dtr']['traffic']['class2']['data'] =  $class[2]['SUM(class2)'];
			$tollplaza['dtr']['traffic']['class3']['data'] = $class[3]['SUM(class3)'] + $class[5]['SUM(class5)'] + $class[6]['SUM(class6)'];
			$tollplaza['dtr']['traffic']['class4']['data'] =  $class[4]['SUM(class4)'];
			$tollplaza['dtr']['traffic']['class5']['data'] =  $class[7]['SUM(class7)'] + $class[8]['SUM(class8)']  + $class[9]['SUM(class9)'] + $class[10]['SUM(class10)'];
			$tollplaza['dtr']['traffic']['total'] = $total['SUM(total)'];
			

			
		}
		else{
			
			$tollplaza['dtr']['traffic']['class1']['label'] =  'Car';
			$tollplaza['dtr']['traffic']['class2']['label'] =  'Wagon';
			$tollplaza['dtr']['traffic']['class3']['label'] =  'Truck';
			$tollplaza['dtr']['traffic']['class4']['label'] =  'Bus';
			$tollplaza['dtr']['traffic']['class5']['label'] =  'AT Truck';
			$tollplaza['dtr']['traffic']['class1']['data'] = 0;
			$tollplaza['dtr']['traffic']['class2']['data'] = 0;
			$tollplaza['dtr']['traffic']['class3']['data'] = 0;
			$tollplaza['dtr']['traffic']['class4']['data'] = 0;
			$tollplaza['dtr']['traffic']['class5']['data'] = 0;
			$tollplaza['dtr']['traffic']['total'] = 0;
			
		}
		return array('tollplaza' => $tollplaza);
	}
	function revenue_dashboard_dtr($dtr, $date, $href, $current, $dtr_array, $toolplaza, $dtr_count){
		
		if($dtr_array){
			 

			
			$cl1 = 'SELECT SUM(class1) FROM DTR WHERE '.$date;
			$cl2 = 'SELECT SUM(class2) FROM DTR WHERE '.$date;
			$cl3 = 'SELECT SUM(class3) FROM DTR WHERE '.$date;
			$cl4 = 'SELECT SUM(class4) FROM DTR WHERE '.$date;
			$cl5 = 'SELECT SUM(class5) FROM DTR WHERE '.$date;
			$cl6 = 'SELECT SUM(class6) FROM DTR WHERE '.$date;
			$cl7 = 'SELECT SUM(class7) FROM DTR WHERE '.$date;
			$cl8 = 'SELECT SUM(class8) FROM DTR WHERE '.$date;
			$cl9 = 'SELECT SUM(class9) FROM DTR WHERE '.$date;
			$cl10 = 'SELECT SUM(class10) FROM DTR WHERE '.$date;
			$tot = 'SELECT SUM(total) FROM DTR WHERE '.$date;
			
			$class[1] = $this->db->query($cl1)->row_array();
			$class[2] = $this->db->query($cl2)->row_array();
			$class[3] = $this->db->query($cl3)->row_array();
			$class[4] = $this->db->query($cl4)->row_array();
			$class[5] = $this->db->query($cl5)->row_array();
			$class[6] = $this->db->query($cl6)->row_array();
			$class[7] = $this->db->query($cl7)->row_array();
			$class[8] = $this->db->query($cl8)->row_array();
			$class[9] = $this->db->query($cl9)->row_array();
			$class[10] = $this->db->query($cl10)->row_array();
			$total = $this->db->query($tot)->row_array();
		
			
			$sql = "Select * From terrif Where (start_date <= '".$dtr_array[0]['for_date']."' AND end_date >= '".$dtr_array[0]['for_date']."')";
			
			$tarrif =  $this->db->query($sql)->result_array();
			

			if($tarrif){
				$tollplaza['dtr']['revenue']['special_message'] = " ";
				$tollplaza['dtr']['revenue']['class1']['label'] = 'Car';
				$tollplaza['dtr']['revenue']['class2']['label'] = 'Wagon';
				$tollplaza['dtr']['revenue']['class3']['label'] = 'Truck';
				$tollplaza['dtr']['revenue']['class4']['label'] = 'Bus';
				$tollplaza['dtr']['revenue']['class5']['label'] = 'AT Truck';
				$tollplaza['dtr']['revenue']['class1']['data'] = $class[1]['SUM(class1)'] * $tarrif[0]['class_1_value'];
				$tollplaza['dtr']['revenue']['class2']['data'] = $class[2]['SUM(class2)']* $tarrif[0]['class_2_value'];
				$tollplaza['dtr']['revenue']['class3']['data'] =	($class[3]['SUM(class3)'] *  $tarrif[0]['class_3_value']) + ($class[5]['SUM(class5)'] * $tarrif[0]['class_5_value']) + ($class[6]['SUM(class6)'] * $tarrif[0]['class_6_value']);
				$tollplaza['dtr']['revenue']['class4']['data'] = $class[4]['SUM(class4)'] * $tarrif[0]['class_4_value'];
				$tollplaza['dtr']['revenue']['class5']['data'] = ($class[7]['SUM(class7)']  * $tarrif[0]['class_7_value']) + ($class[8]['SUM(class8)'] *  $tarrif[0]['class_8_value']) + ($class[9]['SUM(class9)'] * $tarrif[0]['class_9_value']) + ($class[10]['SUM(class10)'] * $tarrif[0]['class_10_value']);
				$tollplaza['dtr']['revenue']['total'] = ($class[1]['SUM(class1)'] * $tarrif[0]['class_1_value']) + ($class[2]['SUM(class2)'] * $tarrif[0]['class_2_value']) + ($class[3]['SUM(class3)'] * $tarrif[0]['class_3_value']) + ($class[4]['SUM(class4)'] * $tarrif[0]['class_4_value']) + ($class[5]['SUM(class5)'] * $tarrif[0]['class_5_value']) + ($class[6]['SUM(class6)'] * $tarrif[0]['class_6_value']) + ($class[7]['SUM(class7)'] * $tarrif[0]['class_7_value']) + ($class[8]['SUM(class8)'] * $tarrif[0]['class_8_value']) + ($class[9]['SUM(class9)'] * $tarrif[0]['class_9_value']) + ($class[10]['SUM(class10)']* $tarrif[0]['class_10_value']);
			}
			else{
					$tollplaza['dtr']['revenue']['special_message'] = "No Tarrif found for this dtr";
					$tollplaza['dtr']['revenue']['dtr_id'] =  $dtr_array[0]['id'];
					$tollplaza['dtr']['revenue']['class1']['label'] = 'Car';
					$tollplaza['dtr']['revenue']['class2']['label'] = 'Wagon';
					$tollplaza['dtr']['revenue']['class3']['label'] = 'Truck';
					$tollplaza['dtr']['revenue']['class4']['label'] = 'Bus';
					$tollplaza['dtr']['revenue']['class5']['label'] = 'AT Truck';
					$tollplaza['dtr']['revenue']['class1']['data'] = 0;
					$tollplaza['dtr']['revenue']['class2']['data'] = 0;
					$tollplaza['dtr']['revenue']['class3']['data'] = 0;
					$tollplaza['dtr']['revenue']['class4']['data'] = 0; 
					$tollplaza['dtr']['revenue']['class5']['data'] = 0;
					$tollplaza['dtr']['revenue']['total'] = 0;
						
			}
			

		}
		else{
			
			$tollplaza['dtr']['revenue']['class1']['label'] = 'Car';
			$tollplaza['dtr']['revenue']['class2']['label'] = 'Wagon';
			$tollplaza['dtr']['revenue']['class3']['label'] = 'Truck';
			$tollplaza['dtr']['revenue']['class4']['label'] = 'Bus';
			$tollplaza['dtr']['revenue']['class5']['label'] = 'AT Truck';
			$tollplaza['dtr']['revenue']['class1']['data'] = 0;
			$tollplaza['dtr']['revenue']['class2']['data'] = 0;
			$tollplaza['dtr']['revenue']['class3']['data'] = 0;
			$tollplaza['dtr']['revenue']['class4']['data'] = 0; 
			$tollplaza['dtr']['revenue']['class5']['data'] = 0;
			$tollplaza['dtr']['revenue']['total'] = 0;
			
		}
		return array('tollplaza' => $tollplaza);
	}
	
	function dashboard_dtr($date,$href, $current){
		
		if($date && $current[1] == 'traffic'){

			$query = 'SELECT * FROM DTR WHERE '.$date.' ORDER BY ID ASC';

			$dtr = $this->db->query($query);


			$toolplaza = $this->db->select('*')->order_by('id', 'ASC')->get('toolplaza')->result_array();		
			$dtr_array = $dtr->result_array();
			$dtr_count =  $dtr->num_rows();
			/*if($date == "for_date BETWEEN CURDATE()-INTERVAL 1 WEEK AND CURDATE()"){
				?> <pre><?php	echo print_r($dtr_array); exit;
				}*/



			$tollplaza = $this->traffic_dashboard_dtr($dtr, $date, $href, $current, $dtr_array, $toolplaza, $dtr_count);	


			return array('date' => $date,'dtr' => $dtr_array,'dtr_count' => $dtr_count, 'toolplaza' => $toolplaza,'tollplaza' => $tollplaza['tollplaza']);
		}
		elseif($date && $current[1] == 'revenue'){				
		
			$query = 'SELECT * FROM DTR WHERE '.$date.' ORDER BY ID ASC';

			$dtr = $this->db->query($query);
			$toolplaza = $this->db->select('*')->order_by('id', 'ASC')->get('toolplaza')->result_array();		
			$dtr_array = $dtr->result_array();
			$dtr_count =  $dtr->num_rows();



			$tollplaza = $this->revenue_dashboard_dtr($dtr, $date, $href, $current, $dtr_array, $toolplaza, $dtr_count);





			return array('date' => $date,'dtr' => $dtr_array,'dtr_count' => $dtr_count, 'toolplaza' => $toolplaza,'tollplaza' => $tollplaza['tollplaza']);
		}
		elseif($date && $current[1] == 'summary'){
			$query = 'SELECT * FROM DTR WHERE '.$date.' ORDER BY ID ASC';

			$dtr = $this->db->query($query);
			$toolplaza = $this->db->select('*')->order_by('id', 'ASC')->get('toolplaza')->result_array();		
			$dtr_array = $dtr->result_array();
			$dtr_count =  $dtr->num_rows();




			$tollplaza = $this->summary_dashboard_dtr($dtr, $date, $href, $current, $dtr_array, $toolplaza, $dtr_count);





			return array('date' => $date,'dtr' => $dtr_array,'dtr_count' => $dtr_count, 'toolplaza' => $toolplaza,'tollplaza' => $tollplaza['tollplaza']);
		}
	}
	
	
    function chartdata(){
        $data = $this->db->select('*')->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
        $data_min = $this->db->select('*')->order_by('for_month','asc')->limit(1)->get('mtr')->result_array();

        if($data && $data_min){
            $data1 = explode('-', $data[0]['for_month']);
            $data2 = explode('-', $data_min[0]['for_month']);
            $start_date1 = implode('/', array($data2[0], $data2[1]));
            $end_date1 = implode('/', array($data1[0], $data1[1]));
        }
        else{
            $start_date = '';
            $end_date = '';
        }
        $chart = array();
        $revenue = array();
        if($data){
            $chart['tollplaza'] = $this->db->get_where('toolplaza',array('id' => $data[0]['toolplaza']))->row()->name;
            $chart['toolplaza_id'] = $data[0]['toolplaza'];
            $month_year = explode('-',$data[0]['for_month']);
            $start_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['start_date'];
            $end_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['end_date'];
            
           $mtr_id =  $data[0]['id'];
           
           $sql = "Select * From terrif Where FIND_IN_SET (".$data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
            $tarrif =  $this->db->query($sql)->result_array();
            $chart['month'] = $data[0]['for_month'];
            $chart['class1']['data'] = $data[0]['class1'];
            $chart['class2']['data'] = $data[0]['class2'];
            $chart['class3']['data'] = $data[0]['class3'] + $data[0]['class5'] + $data[0]['class6'];
            $chart['class4']['data'] = $data[0]['class4'];
            $chart['class5']['data'] = $data[0]['class7'] + $data[0]['class8'] + $data[0]['class9'] + $data[0]['class10'];
            $chart['total']['traffic']=$data[0]['total'];
            $chart['class1']['label'] = "Car";
            $chart['class2']['label'] = "Wagon";
            $chart['class3']['label'] = "Truck";
            $chart['class4']['label'] = "Bus";
            $chart['class5']['label'] = "AT Truck";
            
            if($tarrif){
                $revenue['special_message'] = " ";
                $revenue['month']          = $data[0]['for_month'];
                $revenue['class1']['data'] = $data[0]['class1'] * $tarrif[0]['class_1_value'];
                $revenue['class2']['data'] = $data[0]['class2'] * $tarrif[0]['class_2_value'];
                $revenue['class3']['data'] = ($data[0]['class3'] *  $tarrif[0]['class_3_value']) + ($data[0]['class5'] * $tarrif[0]['class_5_value']) + ($data[0]['class6'] * $tarrif[0]['class_6_value']);
                $revenue['class4']['data'] = $data[0]['class4'] * $tarrif[0]['class_4_value'];
                $revenue['class5']['data'] = ($data[0]['class7']  * $tarrif[0]['class_7_value']) + ($data[0]['class8'] *  $tarrif[0]['class_8_value']) + ($data[0]['class9'] * $tarrif[0]['class_9_value']) + ($data[0]['class10'] * $tarrif[0]['class_10_value']);
                $revenue['total']['revenue'] = ($data[0]['class1'] * $tarrif[0]['class_1_value'])+($data[0]['class2'] * $tarrif[0]['class_2_value'])+
                                               ($data[0]['class3'] *  $tarrif[0]['class_3_value'])+($data[0]['class4'] * $tarrif[0]['class_4_value'])+
                                               ($data[0]['class5'] * $tarrif[0]['class_5_value'])+($data[0]['class6'] * $tarrif[0]['class_6_value']) +
                                               ($data[0]['class7']  * $tarrif[0]['class_7_value']) + ($data[0]['class8'] *  $tarrif[0]['class_8_value'])+
                                               ($data[0]['class9'] * $tarrif[0]['class_9_value']) + ($data[0]['class10'] * $tarrif[0]['class_10_value']);
                $revenue['class1']['label'] = "Car";
                $revenue['class2']['label'] = "Wagon";
                $revenue['class3']['label'] = "Truck";
                $revenue['class4']['label'] = "Bus";
                $revenue['class5']['label'] = "AT Truck";  
            }
            else{
                $revenue['special_message'] = "No Tarrif found for this mtr";
                $revenue['month']          = $data[0]['for_month'];
                $revenue['class1']['data'] = 0;
                $revenue['class2']['data'] = 0;
                $revenue['class3']['data'] = 0;
                $revenue['class4']['data'] = 0;
                $revenue['class5']['data'] = 0;
                $revenue['class1']['label'] = "Car";
                $revenue['class2']['label'] = "Wagon";
                $revenue['class3']['label'] = "Truck";
                $revenue['class4']['label'] = "Bus";
                $revenue['class5']['label'] = "AT Truck";
            }
        }
        return array('mtr_id'=>$mtr_id,'start_date'=> $start_date1,'end_date'=> $end_date1,'chart'=> $chart,'revenue'=> $revenue);
    }

    function timer_chartdata($plaza = '' , $month = ''){
        $data = $this->db->select('*')->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
        $data_min = $this->db->select('*')->order_by('for_month','asc')->limit(1)->get('mtr')->result_array();
        $highest_id = $this->db->select_max('id')->where('status', 1)->get('toolplaza')->result_array();
        if($highest_id[0]['id'] > $plaza){
            $plaza = $plaza + 1;
            $timer_data = $this->db->select('*')->where('toolplaza', $plaza)->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
             if(!$timer_data){
                $plaza = $plaza + 1;
                
                return $this->timer_chartdata($plaza, $month);
                //echo "Not Found exit"; exit;
            }
        }
		else{
            $lowest_id = $this->db->select_min('id')->where('status', 1)->get('toolplaza')->result_array();
            $plaza = $lowest_id[0]['id'];
            $timer_data = $this->db->select('*')->where('toolplaza', $plaza)->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
            if(!$timer_data){
                $plaza = $plaza + 1;
               // echo "Not Found exit else"; exit;
                return $this->timer_chartdata($plaza, $month);
            }
        }
        if($data && $data_min){
            $data1 = explode('-', $data[0]['for_month']);
            $data2 = explode('-', $data_min[0]['for_month']);
            $start_date1 = implode('/', array($data2[0], $data2[1]));
            $end_date1 = implode('/', array($data1[0], $data1[1]));
        }
        else{
            $start_date = '';
            $end_date = '';
        }
        $chart = array();
        $revenue = array();
        if($timer_data){
            $chart['tollplaza'] = $this->db->get_where('toolplaza',array('id' => $timer_data[0]['toolplaza']))->row()->name;
            $chart['toolplaza_id'] = $timer_data[0]['toolplaza'];
            $month_year = explode('-',$timer_data[0]['for_month']);
            $start_date = $month_year[0].'-'.$month_year[1].'-'.$timer_data[0]['start_date'];
            $end_date = $month_year[0].'-'.$month_year[1].'-'.$timer_data[0]['end_date'];
            
            $mtr_id =  $timer_data[0]['id'];
           
            $sql = "Select * From terrif Where FIND_IN_SET (".$timer_data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
            $tarrif =  $this->db->query($sql)->result_array();
            $chart['month'] = $timer_data[0]['for_month'];
            $chart['class1']['data'] = $timer_data[0]['class1'];
            $chart['class2']['data'] = $timer_data[0]['class2'];
            $chart['class3']['data'] = $timer_data[0]['class3'] + $timer_data[0]['class5'] + $timer_data[0]['class6'];
            $chart['class4']['data'] = $data[0]['class4'];
            $chart['class5']['data'] = $timer_data[0]['class7'] + $timer_data[0]['class8'] + $timer_data[0]['class9'] + $timer_data[0]['class10'];
            $chart['total']['traffic']=$timer_data[0]['total'];
            $chart['class1']['label'] = "Car";
            $chart['class2']['label'] = "Wagon";
            $chart['class3']['label'] = "Truck";
            $chart['class4']['label'] = "Bus";
            $chart['class5']['label'] = "AT Truck";
            
            if($tarrif){
                $revenue['special_message'] = " ";
                $revenue['month']          = $timer_data[0]['for_month'];
                $revenue['class1']['data'] = $timer_data[0]['class1'] * $tarrif[0]['class_1_value'];
                $revenue['class2']['data'] = $timer_data[0]['class2'] * $tarrif[0]['class_2_value'];
                $revenue['class3']['data'] = ($timer_data[0]['class3'] *  $tarrif[0]['class_3_value']) + ($timer_data[0]['class5'] * $tarrif[0]['class_5_value']) + ($timer_data[0]['class6'] * $tarrif[0]['class_6_value']);
                $revenue['class4']['data'] = $timer_data[0]['class4'] * $tarrif[0]['class_4_value'];
                $revenue['class5']['data'] = ($timer_data[0]['class7']  * $tarrif[0]['class_7_value']) + ($timer_data[0]['class8'] *  $tarrif[0]['class_8_value']) + ($timer_data[0]['class9'] * $tarrif[0]['class_9_value']) + ($timer_data[0]['class10'] * $tarrif[0]['class_10_value']);
                $revenue['total']['revenue'] = ($timer_data[0]['class1'] * $tarrif[0]['class_1_value'])+($timer_data[0]['class2'] * $tarrif[0]['class_2_value'])+
                                               ($timer_data[0]['class3'] *  $tarrif[0]['class_3_value'])+($timer_data[0]['class4'] * $tarrif[0]['class_4_value'])+
                                               ($timer_data[0]['class5'] * $tarrif[0]['class_5_value'])+($timer_data[0]['class6'] * $tarrif[0]['class_6_value']) +
                                               ($timer_data[0]['class7']  * $tarrif[0]['class_7_value']) + ($timer_data[0]['class8'] *  $tarrif[0]['class_8_value'])+
                                               ($timer_data[0]['class9'] * $tarrif[0]['class_9_value']) + ($timer_data[0]['class10'] * $tarrif[0]['class_10_value']);
                $revenue['class1']['label'] = "Car";
                $revenue['class2']['label'] = "Wagon";
                $revenue['class3']['label'] = "Truck";
                $revenue['class4']['label'] = "Bus";
                $revenue['class5']['label'] = "AT Truck";  
            }
            else{
                $revenue['special_message'] = "No Tarrif found for this mtr";
                $revenue['month']          = $data[0]['for_month'];
                $revenue['class1']['data'] = 0;
                $revenue['class2']['data'] = 0;
                $revenue['class3']['data'] = 0;
                $revenue['class4']['data'] = 0;
                $revenue['class5']['data'] = 0;
                $revenue['class1']['label'] = "Car";
                $revenue['class2']['label'] = "Wagon";
                $revenue['class3']['label'] = "Truck";
                $revenue['class4']['label'] = "Bus";
                $revenue['class5']['label'] = "AT Truck";
            }
        }
        return array('mtr_id'=>$mtr_id,'start_date'=> $start_date1,'end_date'=> $end_date1,'chart'=> $chart,'revenue'=> $revenue);
	}
	
	function omcchartdata(){
        $plaja = $this->db->get_where('toolplaza',array('status' => 1,'omc' => $this->session->userdata('omcid')))->result_array();
		// echo "<pre>"; print_r($plaja); exit;
		$data = $this->db->select('*')->where('toolplaza', $plaja[0]['id'])->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
        $data_min = $this->db->select('*')->where('toolplaza', $plaja[0]['id'])->order_by('for_month','asc')->limit(1)->get('mtr')->result_array();

        if($data && $data_min)
        {
            $data1 = explode('-', $data[0]['for_month']);
            $data2 = explode('-', $data_min[0]['for_month']);
            $start_date1 = implode('/', array($data2[0], $data2[1]));
            $end_date1 = implode('/', array($data1[0], $data1[1]));
        }
        else
        {
            $start_date = '';
            $end_date = '';
        }
        $chart = array();
        $revenue = array();
        if($data)
        {
            $chart['tollplaza'] = $this->db->get_where('toolplaza',array('id' => $data[0]['toolplaza'],'omc' => $this->session->userdata('omcid')))->row()->name;
            $chart['toolplaza_id'] = $data[0]['toolplaza'];
             
            // echo "<pre>"; print_r($chart['toolplaza_id']); exit;
            $month_year = explode('-',$data[0]['for_month']);
            $start_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['start_date'];
            $end_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['end_date'];
            
           $mtr_id =  $data[0]['id'];
           
           $sql = "Select * From terrif Where FIND_IN_SET (".$data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
            $tarrif =  $this->db->query($sql)->result_array();
            $chart['month'] = $data[0]['for_month'];
            $chart['class1']['data'] = $data[0]['class1'];
            $chart['class2']['data'] = $data[0]['class2'];
            $chart['class3']['data'] = $data[0]['class3'] + $data[0]['class5'] + $data[0]['class6'];
            $chart['class4']['data'] = $data[0]['class4'];
            $chart['class5']['data'] = $data[0]['class7'] + $data[0]['class8'] + $data[0]['class9'] + $data[0]['class10'];
            $chart['total']['traffic']=$data[0]['total'];
            $chart['class1']['label'] = "Car";
            $chart['class2']['label'] = "Wagon";
            $chart['class3']['label'] = "Truck";
            $chart['class4']['label'] = "Bus";
            $chart['class5']['label'] = "AT Truck";
            
            if($tarrif)
            {
                $revenue['special_message'] = " ";
                $revenue['month']          = $data[0]['for_month'];
                $revenue['class1']['data'] = $data[0]['class1'] * $tarrif[0]['class_1_value'];
                $revenue['class2']['data'] = $data[0]['class2'] * $tarrif[0]['class_2_value'];
                $revenue['class3']['data'] = ($data[0]['class3'] *  $tarrif[0]['class_3_value']) + ($data[0]['class5'] * $tarrif[0]['class_5_value']) + ($data[0]['class6'] * $tarrif[0]['class_6_value']);
                $revenue['class4']['data'] = $data[0]['class4'] * $tarrif[0]['class_4_value'];
                $revenue['class5']['data'] = ($data[0]['class7']  * $tarrif[0]['class_7_value']) + ($data[0]['class8'] *  $tarrif[0]['class_8_value']) + ($data[0]['class9'] * $tarrif[0]['class_9_value']) + ($data[0]['class10'] * $tarrif[0]['class_10_value']);
                $revenue['total']['revenue'] = ($data[0]['class1'] * $tarrif[0]['class_1_value'])+($data[0]['class2'] * $tarrif[0]['class_2_value'])+
                                               ($data[0]['class3'] *  $tarrif[0]['class_3_value'])+($data[0]['class4'] * $tarrif[0]['class_4_value'])+
                                               ($data[0]['class5'] * $tarrif[0]['class_5_value'])+($data[0]['class6'] * $tarrif[0]['class_6_value']) +
                                               ($data[0]['class7']  * $tarrif[0]['class_7_value']) + ($data[0]['class8'] *  $tarrif[0]['class_8_value'])+
                                               ($data[0]['class9'] * $tarrif[0]['class_9_value']) + ($data[0]['class10'] * $tarrif[0]['class_10_value']);
                $revenue['class1']['label'] = "Car";
                $revenue['class2']['label'] = "Wagon";
                $revenue['class3']['label'] = "Truck";
                $revenue['class4']['label'] = "Bus";
                $revenue['class5']['label'] = "AT Truck";  
            }
            else
            {
                $revenue['special_message'] = "No Tarrif found for this mtr";
                $revenue['month']          = $data[0]['for_month'];
                $revenue['class1']['data'] = 0;
                $revenue['class2']['data'] = 0;
                $revenue['class3']['data'] = 0;
                $revenue['class4']['data'] = 0;
                $revenue['class5']['data'] = 0;
                $revenue['class1']['label'] = "Car";
                $revenue['class2']['label'] = "Wagon";
                $revenue['class3']['label'] = "Truck";
                $revenue['class4']['label'] = "Bus";
                $revenue['class5']['label'] = "AT Truck";
            }
        }
        return array('mtr_id'=>$mtr_id,'start_date'=> $start_date1,'end_date'=> $end_date1,'chart'=> $chart,'revenue'=> $revenue);
	}
	
	function omctimer_chartdata($plaza = '' , $month = ''){
        
        $omc = $this->db->select('toolplaza.id as tollplaza')->join('mtr', 'toolplaza.id = mtr.toolplaza')->where('toolplaza.omc', $this->session->userdata('omcid'))->group_by('tollplaza')->get('toolplaza')->result_array();
        
        $omcdata = @array_column($omc,'tollplaza');
        
            $indexes =  @end(array_keys($omcdata));
        //     echo "<pre>";
        // print_r($indexes);
            $keyy = array_search($plaza,$omcdata,true);
            
            if($keyy === false){
                $plaza = $omcdata[0];
            }
            if($indexes > $keyy){
               
                $keyy = $keyy + 1;
                $plaza = $omcdata[$keyy];
            }else{
                
                $plaza = $omcdata[0];
            }
       
            
      
        // echo "<pre>";
        // print_r($omcdata);
        
        $data = $this->db->select('*')->where('toolplaza', $plaza)->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
        $data_min = $this->db->select('*')->where('toolplaza', $plaza)->order_by('for_month','asc')->limit(1)->get('mtr')->result_array();
        $highest_id = $this->db->select_max('id')->where('status', 1)->where('id', $plaza)->get('toolplaza')->result_array();
        $timer_data = $this->db->select('*')->where('toolplaza', $plaza)->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
        if($data && $data_min)
        {
            $data1 = explode('-', $data[0]['for_month']);
            $data2 = explode('-', $data_min[0]['for_month']);
            $start_date1 = implode('/', array($data2[0], $data2[1]));
            $end_date1 = implode('/', array($data1[0], $data1[1]));
        }
        else
        {
            $start_date = '';
            $end_date = '';
        }
        $chart = array();
        $revenue = array();
        if($timer_data)
        {
            
            $chart['tollplaza'] = $this->db->get_where('toolplaza',array('id' => $timer_data[0]['toolplaza']))->row()->name;
            $chart['toolplaza_id'] = $timer_data[0]['toolplaza'];
            $month_year = explode('-',$timer_data[0]['for_month']);
            $start_date = $month_year[0].'-'.$month_year[1].'-'.$timer_data[0]['start_date'];
            $end_date = $month_year[0].'-'.$month_year[1].'-'.$timer_data[0]['end_date'];
            
            $mtr_id =  $timer_data[0]['id'];
           
            $sql = "Select * From terrif Where FIND_IN_SET (".$timer_data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
            $tarrif =  $this->db->query($sql)->result_array();
            $chart['month'] = $timer_data[0]['for_month'];
            $chart['class1']['data'] = $timer_data[0]['class1'];
            $chart['class2']['data'] = $timer_data[0]['class2'];
            $chart['class3']['data'] = $timer_data[0]['class3'] + $timer_data[0]['class5'] + $timer_data[0]['class6'];
            $chart['class4']['data'] = $timer_data[0]['class4'];
            $chart['class5']['data'] = $timer_data[0]['class7'] + $timer_data[0]['class8'] + $timer_data[0]['class9'] + $timer_data[0]['class10'];
            $chart['total']['traffic']=$timer_data[0]['total'];
            $chart['class1']['label'] = "Car";
            $chart['class2']['label'] = "Wagon";
            $chart['class3']['label'] = "Truck";
            $chart['class4']['label'] = "Bus";
            $chart['class5']['label'] = "AT Truck";
            
            if($tarrif)
            {
                $revenue['special_message'] = " ";
                $revenue['month']          = $timer_data[0]['for_month'];
                $revenue['class1']['data'] = $timer_data[0]['class1'] * $tarrif[0]['class_1_value'];
                $revenue['class2']['data'] = $timer_data[0]['class2'] * $tarrif[0]['class_2_value'];
                $revenue['class3']['data'] = ($timer_data[0]['class3'] *  $tarrif[0]['class_3_value']) + ($timer_data[0]['class5'] * $tarrif[0]['class_5_value']) + ($timer_data[0]['class6'] * $tarrif[0]['class_6_value']);
                $revenue['class4']['data'] = $timer_data[0]['class4'] * $tarrif[0]['class_4_value'];
                $revenue['class5']['data'] = ($timer_data[0]['class7']  * $tarrif[0]['class_7_value']) + ($timer_data[0]['class8'] *  $tarrif[0]['class_8_value']) + ($timer_data[0]['class9'] * $tarrif[0]['class_9_value']) + ($timer_data[0]['class10'] * $tarrif[0]['class_10_value']);
                $revenue['total']['revenue'] = ($timer_data[0]['class1'] * $tarrif[0]['class_1_value'])+($timer_data[0]['class2'] * $tarrif[0]['class_2_value'])+
                                               ($timer_data[0]['class3'] *  $tarrif[0]['class_3_value'])+($timer_data[0]['class4'] * $tarrif[0]['class_4_value'])+
                                               ($timer_data[0]['class5'] * $tarrif[0]['class_5_value'])+($timer_data[0]['class6'] * $tarrif[0]['class_6_value']) +
                                               ($timer_data[0]['class7']  * $tarrif[0]['class_7_value']) + ($timer_data[0]['class8'] *  $tarrif[0]['class_8_value'])+
                                               ($timer_data[0]['class9'] * $tarrif[0]['class_9_value']) + ($timer_data[0]['class10'] * $tarrif[0]['class_10_value']);
                $revenue['class1']['label'] = "Car";
                $revenue['class2']['label'] = "Wagon";
                $revenue['class3']['label'] = "Truck";
                $revenue['class4']['label'] = "Bus";
                $revenue['class5']['label'] = "AT Truck";  
            }
            else
            {
                $revenue['special_message'] = "No Tarrif found for this mtr";
                $revenue['month']          = $data[0]['for_month'];
                $revenue['class1']['data'] = 0;
                $revenue['class2']['data'] = 0;
                $revenue['class3']['data'] = 0;
                $revenue['class4']['data'] = 0;
                $revenue['class5']['data'] = 0;
                $revenue['class1']['label'] = "Car";
                $revenue['class2']['label'] = "Wagon";
                $revenue['class3']['label'] = "Truck";
                $revenue['class4']['label'] = "Bus";
                $revenue['class5']['label'] = "AT Truck";
            }
        }
        
        return array('mtr_id'=>$mtr_id,'start_date'=> $start_date1,'end_date'=> $end_date1,'chart'=> $chart,'revenue'=> $revenue);
    
	}

    function get_chart_by($tollplaza = '', $month = '') /*this method is used to get previous month & year data for pie charts*/{   
       /* echo"<pre>";
        print_r($tollplaza); exit;*/
       
        $chart = array();
        $revenue = array();
        $chart['class1']['data'] = 0;
        $chart['class2']['data'] = 0;
        $chart['class3']['data'] = 0;
        $chart['class4']['data'] = 0;
        $chart['class5']['data'] = 0;
        $revenue['class1']['data'] = 0;
        $revenue['class2']['data'] = 0;
        $revenue['class3']['data'] = 0;
        $revenue['class4']['data'] = 0;
        $revenue['class5']['data'] = 0;
        
        
        $data = $this->db->get_where('mtr',array('for_month' => $month, 'toolplaza' => $tollplaza))->result_array();
   
        if($data){
            foreach($data as $key => $value){ /*loop to get traffic of previous month & year*/ 
                $month_year = explode('-',$data[0]['for_month']);
                $start_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['start_date'];
                $end_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['end_date'];
                $sql = "Select * From terrif Where FIND_IN_SET (".$data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
                $tarrif =  $this->db->query($sql)->result_array();

                $chart['class1']['data'] = $chart['class1']['data'] + $value['class1'];
                $chart['class2']['data'] = $chart['class2']['data'] + $value['class2'];
                $chart['class3']['data'] = $chart['class3']['data'] + $value['class3'] + $value['class5'] + $value['class6'];
                $chart['class4']['data'] = $chart['class4']['data'] + $value['class4'];
                $chart['class5']['data'] = $chart['class5']['data'] + $value['class7'] + $value['class8'] + $value['class9'] + $value['class10'];
                
                if($tarrif){     // check for calculating revenue of previous year or month
                    $revenue['special_message'] = " ";
                    $revenue['month']          = $value['for_month'];
                    $revenue['class1']['data'] = $revenue['class1']['data'] + $value['class1'] * $tarrif[0]['class_1_value'];
                    $revenue['class2']['data'] = $revenue['class2']['data'] + $value['class2'] * $tarrif[0]['class_2_value'];
                    $revenue['class3']['data'] = $revenue['class3']['data'] + ($value['class3'] *  $tarrif[0]['class_3_value']) + ($value['class5'] * $tarrif[0]['class_5_value']) + ($value['class6'] * $tarrif[0]['class_6_value']);
                    $revenue['class4']['data'] = $revenue['class4']['data'] + $data[0]['class4'] * $tarrif[0]['class_4_value'];
                    $revenue['class5']['data'] = $revenue['class5']['data'] + ($value['class7']  * $tarrif[0]['class_7_value']) + ($value['class8'] *  $tarrif[0]['class_8_value']) + ($value['class9'] * $tarrif[0]['class_9_value']) + ($value['class10'] * $tarrif[0]['class_10_value']);    
                }
            }
        }

       $chart['month']           = @$data[0]['for_month'];
      /*  $chart['class1']['label'] = "Car, Jeep";
        $chart['class2']['label'] = "Wagon, Hiace";
        $chart['class3']['label'] = "Truck, Tractor & Trolly";
        $chart['class4']['label'] = "Bus, Coaster";
        $chart['class5']['label'] = "Articulated Truck";
        $revenue['month']          = @$data[0]['for_month'];
        $revenue['class1']['label'] = "Car, Jeep";
        $revenue['class2']['label'] = "Wagon, Hiace";
        $revenue['class3']['label'] = "Truck, Tractor & Trolly";
        $revenue['class4']['label'] = "Bus, Coaster";
        $revenue['class5']['label'] = "Articulated Truck";*/
        $chart['tollplaza'] = @$this->db->get_where('toolplaza',array('id' => @$data[0]['toolplaza']))->row()->name;
        return array('chart' => $chart, 'revenue' => $revenue);
    }


    function get_chartdata($tollplaza = '', $month = ''){
       
        $chart = array();
        $revenue = array();
        $chart['class1']['data'] = 0;
        $chart['class2']['data'] = 0;
        $chart['class3']['data'] = 0;
        $chart['class4']['data'] = 0;
        $chart['class5']['data'] = 0;
        $revenue['class1']['data'] = 0;
        $revenue['class2']['data'] = 0;
        $revenue['class3']['data'] = 0;
        $revenue['class4']['data'] = 0;
        $revenue['class5']['data'] = 0;

       
        $month = str_replace('/', '-', $month);
        $month = $month."-01";
        $data = $this->db->get_where('mtr',array('for_month' => $month, 'toolplaza' => $tollplaza))->result_array();
        
        if(empty($data)){
            $data = $this->db->select('*')->where('toolplaza',$tollplaza)->order_by('id','desc')->limit(1)->get('mtr')->result_array();
        }
        if(empty($data)){
            $data = $this->db->select('*')->order_by('id','desc')->limit(1)->get('mtr')->result_array();
        }
        foreach($data as $key => $value){
            $month_year = explode('-',$data[0]['for_month']);
            $start_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['start_date'];
            $end_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['end_date'];
            $sql = "Select * From terrif Where FIND_IN_SET (".$data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
            $tarrif =  $this->db->query($sql)->result_array();
            
            $mtr_id =  $data[0]['id'];
            $chart['class1']['data'] = $chart['class1']['data'] + $value['class1'];
            $chart['class2']['data'] = $chart['class2']['data'] + $value['class2'];
            $chart['class3']['data'] = $chart['class3']['data'] + $value['class3'] + $value['class5'] + $value['class6'];
            $chart['class4']['data'] = $chart['class4']['data'] + $value['class4'];
            $chart['class5']['data'] = $chart['class5']['data'] + $value['class7'] + $value['class8'] + $value['class9'] + $value['class10'];
            $chart['total']['traffic'] = $value['class1']+ $value['class2']+ $value['class3']+ $value['class4']+ $value['class5'] + $value['class6']+ $value['class7'] + $value['class8'] + $value['class9'] + $value['class10'];
            if($tarrif){
                $revenue['special_message'] = " ";
                $revenue['month']          = $value['for_month'];
                $revenue['class1']['data'] = $revenue['class1']['data'] + $value['class1'] * $tarrif[0]['class_1_value'];
                $revenue['class2']['data'] = $revenue['class2']['data'] + $value['class2'] * $tarrif[0]['class_2_value'];
                $revenue['class3']['data'] = $revenue['class3']['data'] + ($value['class3'] *  $tarrif[0]['class_3_value']) + ($value['class5'] * $tarrif[0]['class_5_value']) + ($value['class6'] * $tarrif[0]['class_6_value']);
                $revenue['class4']['data'] = $revenue['class4']['data'] + $data[0]['class4'] * $tarrif[0]['class_4_value'];
                $revenue['class5']['data'] = $revenue['class5']['data'] + ($value['class7']  * $tarrif[0]['class_7_value']) + ($value['class8'] *  $tarrif[0]['class_8_value']) + ($value['class9'] * $tarrif[0]['class_9_value']) + ($value['class10'] * $tarrif[0]['class_10_value']);
                $revenue['total']['revenue'] = ($value['class1'] * $tarrif[0]['class_1_value'])+($value['class2'] * $tarrif[0]['class_2_value'])+
                                               ($value['class3'] * $tarrif[0]['class_3_value'])+($value['class4'] * $tarrif[0]['class_4_value'])+
                                               ($value['class5'] * $tarrif[0]['class_5_value'])+($value['class6'] * $tarrif[0]['class_6_value']) +
                                               ($value['class7'] * $tarrif[0]['class_7_value'])+($value['class8'] *  $tarrif[0]['class_8_value'])+
                                               ($value['class9'] * $tarrif[0]['class_9_value'])+($value['class10'] * $tarrif[0]['class_10_value']);
            }
        }

        $chart['month']           = $data[0]['for_month'];
        $chart['class1']['label'] = "Car";
        $chart['class2']['label'] = "Wagon";
        $chart['class3']['label'] = "Truck";
        $chart['class4']['label'] = "Bus";
        $chart['class5']['label'] = "AT Truck";

        $revenue['month']          = $data[0]['for_month'];
        $revenue['class1']['label'] = "Car";
        $revenue['class2']['label'] = "Wagon";
        $revenue['class3']['label'] = "Truck";
        $revenue['class4']['label'] = "Bus";
        $revenue['class5']['label'] = "AT Truck";
        $chart['tollplaza'] = $this->db->get_where('toolplaza',array('id' => $data[0]['toolplaza']))->row()->name;
        $chart['toolplaza_id'] = $data[0]['toolplaza'];
        return array('mtr_id'=>$mtr_id, 'chart' => $chart, 'revenue' => $revenue);
    }

    function get_tollplaza_dates($tollplaza = ''){
        $data = $this->db->select('*')->where('toolplaza',$tollplaza)->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
        $data_min = $this->db->select('*')->where('toolplaza',$tollplaza)->order_by('for_month','asc')->limit(1)->get('mtr')->result_array();
        
        if($data && $data_min){
            $data1 = explode('-', $data[0]['for_month']);
            $data2 = explode('-', $data_min[0]['for_month']);
            $start_date = implode('/', array($data2[0], $data2[1]));
            $end_date = implode('/', array($data1[0], $data1[1]));

        }
		else{
            $start_date = '';
            $end_date = '';
        }
        
        
        return array('start_date'=> $start_date,'end_date'=> $end_date);

    }
   
    //////////////////////////////////////////////////////////////
	////	/** DTR Charts START  *////////////////////
	///////////////////////////////////////////////////////////////
	function get_dtrtollplaza_dates($tollplaza = ''){
        $data = $this->db->select('*')->where('toolplaza',$tollplaza)->order_by('for_date','desc')->limit(1)->get('dtr')->result_array();
        $data_min = $this->db->select('*')->where('toolplaza',$tollplaza)->order_by('for_date','asc')->limit(1)->get('dtr')->result_array();
        

        if($data && $data_min){
            $data1 = explode('-', $data[0]['for_date']);
            $data2 = explode('-', $data_min[0]['for_date']);
            $start_date = implode('/', array($data2[0], $data2[1]));
            $end_date = implode('/', array($data1[0], $data1[1]));

        }
		else{
            $start_date = '';
            $end_date = '';
        }
        
        
        return array('start_date'=> $start_date,'end_date'=> $end_date);

    }
   	function get_dtrchartdata($tolllplaza = '', $month = ''){
        
        $month = str_replace('/', '-', $month);
        $toolplaza = $this->db->select('*')->where('5')->get('toolplaza')->result_array();
		$dtr_tool = $this->db->select('*')->where('YEAR(for_date)-MONTH(for_date)', '2019'-'7')->where('toolplaza',5)->order_by('for_date', 'desc')->get('dtr')->result_array();
		$dtr_tool_min = $this->db->select('*')->where('YEAR(for_date)-MONTH(for_date)', '2019'-'7')->where('toolplaza',5)->order_by('for_date', 'asc')->get('dtr')->result_array();
		$start_date = $dtr_tool_min[0]['for_date'];
				$end_date = $dtr_tool[0]['for_date'];
		/*?><pre><?php echo print_r($dtr_tool); ?></pre> <?php exit;*/
		//Loop for repeating graphs for Tollplaza
		
		

		$i = 1; $k = 0;
		$tollplaza = array();
		
			
						
			
			
			
			$tollplaza['name'] = $this->db->get_where('toolplaza',array('id' => $i))->row()->name;
				$tollplaza['id'] = $dtr_tool_min[0]['toolplaza'];
				$tollplaza['status'] = $dtr_tool_min[0]['status'];
				
				
			   $sql = "Select * From terrif Where FIND_IN_SET (5 ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
				
				$tarrif =  $this->db->query($sql)->result_array();
				//$chart['date'] = $data[0]['for_date'];
				$u = 0;
				foreach($dtr_tool_min[$i] as $dtr){
					$u++;
					$tollplaza['dtr']['chart'][$u]['dtr_id'] =  $dtr['id'];
					$tollplaza['dtr']['chart'][$u]['label'] = date("j",strtotime($dtr['for_date']));
					$tollplaza['dtr']['chart'][$u]['total'] = $dtr['total'];
					
				}
				
				if($tarrif){
					$tollplaza[$i]['dtr']['revenue'][$u]['special_message'] = " ";
					$u = 0;
					foreach($dtr_tool_min[$i] as $dtr){
						$u++;
						$tollplaza[$i]['dtr']['revenue'][$u]['label'] = date("j",strtotime($dtr['for_date']));
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['label'] = 'Car';
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['label'] = 'Wagon';
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['label'] = 'Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['label'] = 'Bus';
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['label'] = 'AT Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['data'] = $dtr['class1'] * $tarrif[0]['class_1_value'];
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['data'] = $dtr['class2'] * $tarrif[0]['class_2_value'];
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['data'] =	($dtr['class3'] *  $tarrif[0]['class_3_value']) + ($dtr['class5'] * $tarrif[0]['class_5_value']) + ($dtr['class6'] * $tarrif[0]['class_6_value']);
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['data'] = $dtr['class4'] * $tarrif[0]['class_4_value'];
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['data'] = ($dtr['class7']  * $tarrif[0]['class_7_value']) + ($dtr['class8'] *  $tarrif[0]['class_8_value']) + ($dtr['class9'] * $tarrif[0]['class_9_value']) + ($dtr['class10'] * $tarrif[0]['class_10_value']);
						$tollplaza[$i]['dtr']['revenue'][$u]['total'] = ($dtr['class1'] * $tarrif[0]['class_1_value']) + ($dtr['class2'] * $tarrif[0]['class_2_value']) + ($dtr['class3'] * $tarrif[0]['class_3_value']) + ($dtr['class4'] * $tarrif[0]['class_4_value']) + ($dtr['class5'] * $tarrif[0]['class_5_value']) + ($dtr['class6'] * $tarrif[0]['class_6_value']) + ($dtr['class7'] * $tarrif[0]['class_7_value']) + ($dtr['class8'] * $tarrif[0]['class_8_value']) + ($dtr['class9'] * $tarrif[0]['class_9_value']) + ($dtr['class10'] * $tarrif[0]['class_10_value']);
						
					}
					
				}
				else{
					$tollplaza[$i]['dtr']['revenue'][$u]['special_message'] = "No Tarrif found for this dtr";
					$u = 0;
					foreach($dtr_tool_min[$i] as $dtr){
						$u++;
						$tollplaza[$i]['dtr']['revenue'][$u]['label'] = date("j",strtotime($dtr['for_date']));
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['label'] = 'Car';
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['label'] = 'Wagon';
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['label'] = 'Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['label'] = 'Bus';
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['label'] = 'AT Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['data'] = 0; 
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['data'] = 0;
						
					}
					
				
			
			
				}
			
		
		
		return array('start_date'=> $start_date, 'end_date'=> $end_date, 'tollplaza' => $tollplaza);
    }
	function get_dtrchart_by($tollplaza = '', $month = '') /*this method is used to get previous month & year data for pie charts*/{   
       /* echo"<pre>";
        print_r($tollplaza); exit;*/
       
        $chart = array();
        $revenue = array();
        $chart['class1']['data'] = 0;
        $chart['class2']['data'] = 0;
        $chart['class3']['data'] = 0;
        $chart['class4']['data'] = 0;
        $chart['class5']['data'] = 0;
        $revenue['class1']['data'] = 0;
        $revenue['class2']['data'] = 0;
        $revenue['class3']['data'] = 0;
        $revenue['class4']['data'] = 0;
        $revenue['class5']['data'] = 0;
        
        
        $data = $this->db->get_where('mtr',array('for_month' => $month, 'toolplaza' => $tollplaza))->result_array();
   
        if($data){
            foreach($data as $key => $value){ //loop to get traffic of previous month & year
            
                $month_year = explode('-',$data[0]['for_month']);
                $start_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['start_date'];
                $end_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['end_date'];
                $sql = "Select * From terrif Where FIND_IN_SET (".$data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
                $tarrif =  $this->db->query($sql)->result_array();

                $chart['class1']['data'] = $chart['class1']['data'] + $value['class1'];
                $chart['class2']['data'] = $chart['class2']['data'] + $value['class2'];
                $chart['class3']['data'] = $chart['class3']['data'] + $value['class3'] + $value['class5'] + $value['class6'];
                $chart['class4']['data'] = $chart['class4']['data'] + $value['class4'];
                $chart['class5']['data'] = $chart['class5']['data'] + $value['class7'] + $value['class8'] + $value['class9'] + $value['class10'];
                
                if($tarrif){     // check for calculating revenue of previous year or month
                
                    $revenue['special_message'] = " ";
                    $revenue['month']          = $value['for_month'];
                    $revenue['class1']['data'] = $revenue['class1']['data'] + $value['class1'] * $tarrif[0]['class_1_value'];
                    $revenue['class2']['data'] = $revenue['class2']['data'] + $value['class2'] * $tarrif[0]['class_2_value'];
                    $revenue['class3']['data'] = $revenue['class3']['data'] + ($value['class3'] *  $tarrif[0]['class_3_value']) + ($value['class5'] * $tarrif[0]['class_5_value']) + ($value['class6'] * $tarrif[0]['class_6_value']);
                    $revenue['class4']['data'] = $revenue['class4']['data'] + $data[0]['class4'] * $tarrif[0]['class_4_value'];
                    $revenue['class5']['data'] = $revenue['class5']['data'] + ($value['class7']  * $tarrif[0]['class_7_value']) + ($value['class8'] *  $tarrif[0]['class_8_value']) + ($value['class9'] * $tarrif[0]['class_9_value']) + ($value['class10'] * $tarrif[0]['class_10_value']);    
                }
            }
        }

       $chart['month']           = @$data[0]['for_month'];
      /*  $chart['class1']['label'] = "Car, Jeep";
        $chart['class2']['label'] = "Wagon, Hiace";
        $chart['class3']['label'] = "Truck, Tractor & Trolly";
        $chart['class4']['label'] = "Bus, Coaster";
        $chart['class5']['label'] = "Articulated Truck";
        $revenue['month']          = @$data[0]['for_month'];
        $revenue['class1']['label'] = "Car, Jeep";
        $revenue['class2']['label'] = "Wagon, Hiace";
        $revenue['class3']['label'] = "Truck, Tractor & Trolly";
        $revenue['class4']['label'] = "Bus, Coaster";
        $revenue['class5']['label'] = "Articulated Truck";*/
        $chart['tollplaza'] = @$this->db->get_where('toolplaza',array('id' => @$data[0]['toolplaza']))->row()->name;
        return array('chart' => $chart, 'revenue' => $revenue);
    }
	

	function get_dtr_tollplaza_dates($tollplaza = ''){
        $data = $this->db->select('*')->where('toolplaza',$tollplaza)->order_by('for_date','desc')->limit(1)->get('dtr')->result_array();
        $data_min = $this->db->select('*')->where('toolplaza',$tollplaza)->order_by('for_date','asc')->limit(1)->get('dtr')->result_array();
        
        if($data && $data_min){
            $data1 = explode('-', $data[0]['for_date']);
            $data2 = explode('-', $data_min[0]['for_date']);
            $start_date = implode('/', array($data2[0], $data2[1]));
            $end_date = implode('/', array($data1[0], $data1[1]));

        }
		else{
            $start_date = '';
            $end_date = '';
        }
        
        
        return array('start_date'=> $start_date,'end_date'=> $end_date);

    }
    function dtr_chartdata(){
		
		$data = $this->db->select('*')->order_by('id','desc')->limit(1)->get('dtr')->result_array();
        $data_min = $this->db->select('*')->order_by('id','asc')->limit(1)->get('dtr')->result_array();
		$datedata = date('n' ,strtotime($data[0]['for_date']));
		$datedatamin = date('n' ,strtotime($data_min[0]['for_date']));
		$dtr_month = $this->db->select('*')->where('MONTH(for_date)', $datedata)->where('toolplaza',$data[0]['toolplaza'])->order_by('for_date', 'desc')->get('dtr')->result_array();
		$dtr_month_min=$this->db->select('*')->where('MONTH(for_date)', $datedata)->where('toolplaza',$data[0]['toolplaza'])->order_by('for_date', 'asc')->get('dtr')->result_array();
		$dtr_monthh = $this->db->select('*')->where('MONTH(for_date)', $datedata)->where('toolplaza',$data[0]['toolplaza'])->order_by('for_date', 'asc')->get('dtr')->result_array();

		$dtr_id = $data[0]['id'];
        
        if($dtr_month && $dtr_month_min){
            $data1 = explode('-', $dtr_month[0]['for_date']);
            $data2 = explode('-', $dtr_month_min[0]['for_date']);
            $start_date1 = implode('/', array($data2[0], $data2[1]));
            $end_date1 = implode('/', array($data1[0], $data1[1]));

        }
        else{
            $start_date = '';
            $end_date = '';
        }
        $chart = array();
        $revenue = array();
        if($dtr_month_min){
            $chart['tollplaza'] = $this->db->get_where('toolplaza',array('id' => $data[0]['toolplaza']))->row()->name;
            $chart['toolplaza_id'] = $dtr_monthh[0]['toolplaza'];
			$chart['month']	= date("Y-m",strtotime($dtr_monthh[0]['for_date']));
            $month_year = explode('-',$dtr_month[0]['for_date']);
            $start_date = $dtr_monthh[0]['for_date'];
            $end_date = $dtr_monthh[0]['for_date'];
            
           
           
           $sql = "Select * From terrif Where FIND_IN_SET (".$dtr_monthh[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
            $tarrif =  $this->db->query($sql)->result_array();
            //$chart['date'] = $data[0]['for_date'];
			$i = 0;
			foreach($dtr_monthh as $dtr){
				$i++;
				$chart['traffic'][$i]['dtr_id'] =  $dtr['id'];
				$chart['traffic'][$i]['label'] = date("j",strtotime($dtr['for_date']));
				$chart['traffic'][$i]['data'] = $dtr['total'];			
			}
			$i = 0;
			foreach($dtr_month as $dtr){
				$chart['ltraffic'][$i]['date'] = date("Y-m-d",strtotime($dtr['for_date']));
				$chart['ltraffic'][$i]['total'] = $dtr['total'];	
				$i++;		
			}
			
            if($tarrif){
				$revenue['special_message'] = " ";
				$revenue['month']	= date("Y-m",strtotime($dtr_month[0]['for_date']));
				$i = 0;
				foreach($dtr_monthh as $dtr){
					$i++;
					$revenue['revenue'][$i]['dtr_id'] = $dtr['id'];
					$revenue['revenue'][$i]['label'] = date("j",strtotime($dtr['for_date']));
					$revenue['revenue'][$i]['data'] = ($dtr['class1'] * $tarrif[0]['class_1_value']) + ($dtr['class2'] * $tarrif[0]['class_2_value']) + ($dtr['class3'] * $tarrif[0]['class_3_value']) + ($dtr['class4'] * $tarrif[0]['class_4_value']) + ($dtr['class5'] * $tarrif[0]['class_5_value']) + ($dtr['class6'] * $tarrif[0]['class_6_value']) + ($dtr['class7'] * $tarrif[0]['class_7_value']) + ($dtr['class8'] * $tarrif[0]['class_8_value']) + ($dtr['class9'] * $tarrif[0]['class_9_value']) + ($dtr['class10'] * $tarrif[0]['class_10_value']);
				}
				
				$i = 0;
				foreach($dtr_month as $dtr){
					$revenue['lrevenue'][$i]['total'] = ($dtr['class1'] * $tarrif[0]['class_1_value']) + ($dtr['class2'] * $tarrif[0]['class_2_value']) + ($dtr['class3'] * $tarrif[0]['class_3_value']) + ($dtr['class4'] * $tarrif[0]['class_4_value']) + ($dtr['class5'] * $tarrif[0]['class_5_value']) + ($dtr['class6'] * $tarrif[0]['class_6_value']) + ($dtr['class7'] * $tarrif[0]['class_7_value']) + ($dtr['class8'] * $tarrif[0]['class_8_value']) + ($dtr['class9'] * $tarrif[0]['class_9_value']) + ($dtr['class10'] * $tarrif[0]['class_10_value']);
					$i++;
				}
				
			}
            else{
                $revenue['special_message'] = "No Tarrif found for this dtr";
                $revenue['month']	= date("Y-m",strtotime($dtr_month[0]['for_date']));
				$i = 0;
				foreach($dtr_monthh as $dtr){
					$i++;
					$revenue['revenue'][$i]['label'] = date("j",strtotime($dtr['for_date']));
					$revenue['revenue'][$i]['data'] = 0;
				}
            }
        }
        return array('dtr_id'=> $dtr_id, 'start_date'=> $start_date1,'end_date'=> $end_date1,'chart'=> $chart,'revenue'=> $revenue);
    }
    function dtr_chart_tooldata(){
        $toolplaza = $this->db->get('toolplaza')->result_array();
        $data = $this->db->select('*')->order_by('id','desc')->limit(1)->get('dtr')->result_array();
        $data_min = $this->db->select('*')->order_by('id','asc')->limit(1)->get('dtr')->result_array();
		$datedata = date('n' ,strtotime($data[0]['for_date']));
		$datedatamin = date('n' ,strtotime($data_min[0]['for_date']));
		//Loop for repeating graphs for Tollplaza
		$i = 1; $k = 0;
		$dtr_tool = array();
		foreach($toolplaza as $tool){
			$dtr_tool[$i] = $this->db->select('*')->where('MONTH(for_date)', $datedata)->where('toolplaza',$i)->order_by('for_date', 'desc')->get('dtr')->result_array();
			$dtr_tool_min[$i] = $this->db->select('*')->where('MONTH(for_date)', $datedata)->where('toolplaza',$i)->order_by('for_date', 'asc')->get('dtr')->result_array();
			
			

			if($dtr_tool[$i] && $dtr_tool_min[$i]){
				$data1 = explode('-', $dtr_tool[$i][0]['for_date']);
				
				$data2 = explode('-', $dtr_tool_min[$i][0]['for_date']);
				
				$start_date1 = implode('/', array($data2[0], $data2[1]));
				
				$end_date1 = implode('/', array($data1[0], $data1[1]));
				
			}
			elseif($dtr_tool[$i] == false && $dtr_tool_min[$i] == false){
				
			}
			$chart_tool[$i] = array();
			$revenue_tool[$i] = array();
			if($dtr_tool_min[$i]){
				$chart_tool[$i]['tollplaza'] = $this->db->get_where('toolplaza',array('id' => $i))->row()->name;
				$chart_tool[$i]['toolplaza_id'] = $dtr_tool_min[$i][0]['toolplaza'];
				

				$chart_tool[$i]['month']	= date("Y-m",strtotime($dtr_tool_min[$i][0]['for_date']));
				$month_year = explode('-',$dtr_tool[$i][0]['for_date']);
				$start_date = $dtr_tool_min[$i][0]['for_date'];
				$end_date = $dtr_tool[$i][0]['for_date'];
			   $sql = "Select * From terrif Where FIND_IN_SET (".$i." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
				
				$tarrif =  $this->db->query($sql)->result_array();
				//$chart['date'] = $data[0]['for_date'];
				$u = 0;
				foreach($dtr_tool_min[$i] as $dtr){
					$u++;
					$chart_tool[$i]['dtr'][$u]['dtr_id'] =  $dtr['id'];
					$chart_tool[$i]['dtr'][$u]['label'] = date("j",strtotime($dtr['for_date']));
					$chart_tool[$i]['dtr'][$u]['class1']['label'] =  'Car';
					$chart_tool[$i]['dtr'][$u]['class2']['label'] =  'Wagon';
					$chart_tool[$i]['dtr'][$u]['class3']['label'] =  'Truck';
					$chart_tool[$i]['dtr'][$u]['class4']['label'] =  'Bus';
					$chart_tool[$i]['dtr'][$u]['class5']['label'] =  'AT Truck';
					$chart_tool[$i]['dtr'][$u]['class1']['data'] =  $dtr['class1'];
					$chart_tool[$i]['dtr'][$u]['class2']['data'] =  $dtr['class2'];
					$chart_tool[$i]['dtr'][$u]['class3']['data'] =  $dtr['class3'] + $dtr['class5'] + $dtr['class6'];
					$chart_tool[$i]['dtr'][$u]['class4']['data'] =  $dtr['class4'];
					$chart_tool[$i]['dtr'][$u]['class5']['data'] =  $dtr['class7'] + $dtr['class8'] + $dtr['class9'] + $dtr['class10'];
					$chart_tool[$i]['dtr'][$u]['total'] = $dtr['total'];	
					
				}
				
				if($tarrif){
					$revenue_tool[$i]['special_message'] = " ";
					$revenue_tool[$i]['month']	= date("Y-m",strtotime($dtr_tool[$i][0]['for_date']));
					
					$u = 0;
					foreach($dtr_tool_min[$i] as $dtr){
						$u++;
						$revenue_tool[$i]['dtr'.$u]['dtr_id'] = $dtr['id'];
						$revenue_tool[$i]['dtr'.$u]['label'] = date("j",strtotime($dtr['for_date']));
						$revenue_tool[$i]['dtr'.$u]['class1']['label'] = 'Car';
						$revenue_tool[$i]['dtr'.$u]['class2']['label'] = 'Wagon';
						$revenue_tool[$i]['dtr'.$u]['class3']['label'] = 'Truck';
						$revenue_tool[$i]['dtr'.$u]['class4']['label'] = 'Bus';
						$revenue_tool[$i]['dtr'.$u]['class5']['label'] = 'AT Truck';
						$revenue_tool[$i]['dtr'.$u]['class1']['data'] = $dtr['class1'] * $tarrif[0]['class_1_value'];
						$revenue_tool[$i]['dtr'.$u]['class2']['data'] = $dtr['class2'] * $tarrif[0]['class_2_value'];
						$revenue_tool[$i]['dtr'.$u]['class3']['data'] =	($dtr['class3'] *  $tarrif[0]['class_3_value']) + ($dtr['class5'] * $tarrif[0]['class_5_value']) + ($dtr['class6'] * $tarrif[0]['class_6_value']);
						$revenue_tool[$i]['dtr'.$u]['class4']['data'] = $dtr['class4'] * $tarrif[0]['class_4_value'];
						$revenue_tool[$i]['dtr'.$u]['class5']['data'] = ($dtr['class7']  * $tarrif[0]['class_7_value']) + ($dtr['class8'] *  $tarrif[0]['class_8_value']) + ($dtr['class9'] * $tarrif[0]['class_9_value']) + ($dtr['class10'] * $tarrif[0]['class_10_value']);
						$revenue_tool[$i]['dtr'.$u]['data'] = ($dtr['class1'] * $tarrif[0]['class_1_value']) + ($dtr['class2'] * $tarrif[0]['class_2_value']) + ($dtr['class3'] * $tarrif[0]['class_3_value']) + ($dtr['class4'] * $tarrif[0]['class_4_value']) + ($dtr['class5'] * $tarrif[0]['class_5_value']) + ($dtr['class6'] * $tarrif[0]['class_6_value']) + ($dtr['class7'] * $tarrif[0]['class_7_value']) + ($dtr['class8'] * $tarrif[0]['class_8_value']) + ($dtr['class9'] * $tarrif[0]['class_9_value']) + ($dtr['class10'] * $tarrif[0]['class_10_value']);
						
					}
					
				}
				else{
					$revenue_tool[$i]['special_message'] = "No Tarrif found for this dtr";
					$revenue_tool[$i]['month']	= date("Y-m",strtotime($dtr_month[0]['for_date']));
					$j = 0;
					foreach($dtr_tool_min[$i] as $dtr){
						$j++;
						$revenue_tool[$i]['revenue'.$j]['label'] = date("j",strtotime($dtr['for_date']));
						$revenue_tool[$i]['revenue'.$j]['data'] = 0;
					}
					
				}
			}
			$i++; $k++;
		}
		
		return array('start_date'=> $start_date1,'end_date'=> $end_date1,'chart'=> $chart_tool,'revenue'=> $revenue_tool);
        
	}
    function dtr_chart_tooldata_asc(){
		$toolplaza = $this->db->get('toolplaza')->result_array();
		
		$dtr_latest = $this->db->select('*')->order_by('id', 'desc')->limit(1)->get('dtr')->result_array();
		
		$dtr_first = $this->db->select('*')->order_by('id', 'asc')->limit(1)->get('dtr')->result_array();
		
		$date_latest = date('n' ,strtotime($dtr_latest[0]['for_date']));
		
		/*?><pre><?php echo print_r($date_latest); ?></pre> <?php exit;*/
		//Loop for repeating graphs for Tollplaza
		
		
		$i = 1; $k = 0;
		$dtr_tool = array();
		foreach($toolplaza as $tool){
			
						
			
			$dtr_tool[$i] = $this->db->select('*')->where('MONTH(for_date)', $date_latest)->where('toolplaza',$i)->order_by('for_date', 'desc')->get('dtr')->result_array();
			$dtr_tool_min[$i] = $this->db->select('*')->where('MONTH(for_date)', $date_latest)->where('toolplaza',$i)->order_by('for_date', 'asc')->get('dtr')->result_array();
			
			/*?><pre><?php echo print_r($dtr_latest[$k]); ?></pre> <?php exit; */

			if($dtr_tool[$i] && $dtr_tool_min[$i]){
				$data1 = explode('-', $dtr_tool[$i][0]['for_date']);
				
				$data2 = explode('-', $dtr_tool_min[$i][0]['for_date']);
				
				$start_date1 = implode('/', array($data2[0], $data2[1]));
				
				$end_date1 = implode('/', array($data1[0], $data1[1]));
				
			}
			elseif($dtr_tool[$i] == false && $dtr_tool_min[$i] == false){
				
			}
			
			$tollplaza[$i] = array();
			
			if($dtr_tool_min[$i]){
				$month = date("Y-m",strtotime($dtr_tool_min[$i][0]['for_date']));				
										   
				$tollplaza[$i]['name'] = $this->db->get_where('toolplaza',array('id' => $i))->row()->name;
				$tollplaza[$i]['id'] = $dtr_tool_min[$i][0]['toolplaza'];
				$tollplaza[$i]['status'] = $dtr_tool_min[$i][0]['status'];
				$month_year = explode('-',$dtr_tool[$i][0]['for_date']);
				$start_date = $dtr_tool_min[$i][0]['for_date'];
				$end_date = $dtr_tool[$i][0]['for_date'];
			   $sql = "Select * From terrif Where FIND_IN_SET (".$i." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
				
				$tarrif =  $this->db->query($sql)->result_array();
				//$chart['date'] = $data[0]['for_date'];
				$u = 0;
				foreach($dtr_tool_min[$i] as $dtr){
					$u++;
					$tollplaza[$i]['dtr']['chart'][$u]['dtr_id'] =  $dtr['id'];
					$tollplaza[$i]['dtr']['chart'][$u]['label'] = date("j",strtotime($dtr['for_date']));
					$tollplaza[$i]['dtr']['chart'][$u]['class1']['label'] =  'Car';
					$tollplaza[$i]['dtr']['chart'][$u]['class2']['label'] =  'Wagon';
					$tollplaza[$i]['dtr']['chart'][$u]['class3']['label'] =  'Truck';
					$tollplaza[$i]['dtr']['chart'][$u]['class4']['label'] =  'Bus';
					$tollplaza[$i]['dtr']['chart'][$u]['class5']['label'] =  'AT Truck';
					$tollplaza[$i]['dtr']['chart'][$u]['class1']['data'] =  $dtr['class1'];
					$tollplaza[$i]['dtr']['chart'][$u]['class2']['data'] =  $dtr['class2'];
					$tollplaza[$i]['dtr']['chart'][$u]['class3']['data'] =  $dtr['class3'] + $dtr['class5'] + $dtr['class6'];
					$tollplaza[$i]['dtr']['chart'][$u]['class4']['data'] =  $dtr['class4'];
					$tollplaza[$i]['dtr']['chart'][$u]['class5']['data'] =  $dtr['class7'] + $dtr['class8'] + $dtr['class9'] + $dtr['class10'];
					$tollplaza[$i]['dtr']['chart'][$u]['total'] = $dtr['total'];
					
				}
				
				if($tarrif){
					
					$u = 0;
					foreach($dtr_tool_min[$i] as $dtr){
						$u++;
						$tollplaza[$i]['dtr']['revenue'][$u]['special_message'] = " ";
						$tollplaza[$i]['dtr']['revenue'][$u]['dtr_id'] =  $dtr['id'];
						$tollplaza[$i]['dtr']['revenue'][$u]['label'] = date("j",strtotime($dtr['for_date']));
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['label'] = 'Car';
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['label'] = 'Wagon';
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['label'] = 'Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['label'] = 'Bus';
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['label'] = 'AT Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['data'] = $dtr['class1'] * $tarrif[0]['class_1_value'];
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['data'] = $dtr['class2'] * $tarrif[0]['class_2_value'];
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['data'] =	($dtr['class3'] *  $tarrif[0]['class_3_value']) + ($dtr['class5'] * $tarrif[0]['class_5_value']) + ($dtr['class6'] * $tarrif[0]['class_6_value']);
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['data'] = $dtr['class4'] * $tarrif[0]['class_4_value'];
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['data'] = ($dtr['class7']  * $tarrif[0]['class_7_value']) + ($dtr['class8'] *  $tarrif[0]['class_8_value']) + ($dtr['class9'] * $tarrif[0]['class_9_value']) + ($dtr['class10'] * $tarrif[0]['class_10_value']);
						$tollplaza[$i]['dtr']['revenue'][$u]['total'] = ($dtr['class1'] * $tarrif[0]['class_1_value']) + ($dtr['class2'] * $tarrif[0]['class_2_value']) + ($dtr['class3'] * $tarrif[0]['class_3_value']) + ($dtr['class4'] * $tarrif[0]['class_4_value']) + ($dtr['class5'] * $tarrif[0]['class_5_value']) + ($dtr['class6'] * $tarrif[0]['class_6_value']) + ($dtr['class7'] * $tarrif[0]['class_7_value']) + ($dtr['class8'] * $tarrif[0]['class_8_value']) + ($dtr['class9'] * $tarrif[0]['class_9_value']) + ($dtr['class10'] * $tarrif[0]['class_10_value']);
						
					}
					
				}
				else{
					$tollplaza[$i]['dtr']['revenue'][$u]['special_message'] = "No Tarrif found for this dtr";
					$u = 0;
					foreach($dtr_tool_min[$i] as $dtr){
						$u++;
						$tollplaza[$i]['dtr']['revenue'][$u]['label'] = date("j",strtotime($dtr['for_date']));
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['label'] = 'Car';
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['label'] = 'Wagon';
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['label'] = 'Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['label'] = 'Bus';
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['label'] = 'AT Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['data'] = 0; 
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['data'] = 0;
						
					}
					
				}
			}
			$i++; $k++;
		}
		
		
		return array('start_date'=> $start_date1, 'end_date'=> $end_date1, 'month' => $month, 'toolplaza' => $toolplaza,'tollplaza' => $tollplaza);
        
	}
	function dtr_chart_tooldata_month($tooldata,$m){
		$toolplaza = $this->db->select('*')->where('id', $tooldata)->get('toolplaza')->result_array();
		$month = date('n' ,strtotime($m));
		$year = date('Y', strtotime($m));
		$dtr_latest = $this->db->select('*')->where(array('YEAR(for_date)-MONTH(for_date)' => $year-$month))->where('toolplaza', $tooldata)->order_by('for_date', 'desc')->get('dtr')->result_array();
		
		$dtr_first = $this->db->select('*')->where(array('YEAR(for_date)-MONTH(for_date)' => $year-$month))->where('toolplaza', $tooldata)->order_by('for_date', 'asc')->get('dtr')->result_array();
		

		$start_date = $dtr_first[0]['for_date'];
		$end_date = $dtr_latest[0]['for_date'];
		
		/*?><pre><?php echo print_r($dtr_first[1]['for_date']); ?></pre> <?php exit;*/
		//Tollplaza
		
		$tool['name'] = $toolplaza[0]['name'];
		$tool['start_date'] = $dtr_first[0]['for_date'];
		$tool['end_date'] = $dtr_latest[0]['for_date'];
		if($dtr_first){
			$sql = "Select * From terrif Where FIND_IN_SET (".$tooldata." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
				
			$tarrif =  $this->db->query($sql)->result_array();
			$u = 1;
			foreach($dtr_first as $dtr_asc){
				$tool['chart'][$u]['dtr_id'] =  $dtr_asc['id'];
				$tool['chart'][$u]['label'] = date("j",strtotime($dtr_asc['for_date']));
				$tool['chart'][$u]['class1']['label'] =  'Car';
				$tool['chart'][$u]['class2']['label'] =  'Wagon';
				$tool['chart'][$u]['class3']['label'] =  'Truck';
				$tool['chart'][$u]['class4']['label'] =  'Bus';
				$tool['chart'][$u]['class5']['label'] =  'AT Truck';
				$tool['chart'][$u]['class1']['data'] =  $dtr_asc['class1'];
				$tool['chart'][$u]['class2']['data'] =  $dtr_asc['class2'];
				$tool['chart'][$u]['class3']['data'] =  $dtr_asc['class3'] + $dtr_asc['class5'] + $dtr_asc['class6'];
				$tool['chart'][$u]['class4']['data'] =  $dtr_asc['class4'];
				$tool['chart'][$u]['class5']['data'] =  $dtr_asc['class7'] + $dtr_asc['class8'] + $dtr_asc['class9'] + $dtr_asc['class10'];
				$tool['chart'][$u]['total'] = $dtr_asc['total'];
				$u++;

			}
			if($tarrif){
				$tool['revenue'][$u]['special_message'] = " ";
					$u = 0;
					foreach($dtr_first as $dtr_asc){
						$u++;
						$tool['revenue'][$u]['label'] = date("j",strtotime($dtr_asc['for_date']));
						$tool['revenue'][$u]['class1']['label'] = 'Car';
						$tool['revenue'][$u]['class2']['label'] = 'Wagon';
						$tool['revenue'][$u]['class3']['label'] = 'Truck';
						$tool['revenue'][$u]['class4']['label'] = 'Bus';
						$tool['revenue'][$u]['class5']['label'] = 'AT Truck';
						$tool['revenue'][$u]['class1']['data'] = $dtr_asc['class1'] * $tarrif[0]['class_1_value'];
						$tool['revenue'][$u]['class2']['data'] = $dtr_asc['class2'] * $tarrif[0]['class_2_value'];
						$tool['revenue'][$u]['class3']['data'] =	($dtr_asc['class3'] *  $tarrif[0]['class_3_value']) + ($dtr_asc['class5'] * $tarrif[0]['class_5_value']) + ($dtr_asc['class6'] * $tarrif[0]['class_6_value']);
						$tool['revenue'][$u]['class4']['data'] = $dtr_asc['class4'] * $tarrif[0]['class_4_value'];
						$tool['revenue'][$u]['class5']['data'] = ($dtr_asc['class7']  * $tarrif[0]['class_7_value']) + ($dtr_asc['class8'] *  $tarrif[0]['class_8_value']) + ($dtr_asc['class9'] * $tarrif[0]['class_9_value']) + ($dtr_asc['class10'] * $tarrif[0]['class_10_value']);
						$tool['revenue'][$u]['total'] = ($dtr_asc['class1'] * $tarrif[0]['class_1_value']) + ($dtr_asc['class2'] * $tarrif[0]['class_2_value']) + ($dtr_asc['class3'] * $tarrif[0]['class_3_value']) + ($dtr_asc['class4'] * $tarrif[0]['class_4_value']) + ($dtr_asc['class5'] * $tarrif[0]['class_5_value']) + ($dtr_asc['class6'] * $tarrif[0]['class_6_value']) + ($dtr_asc['class7'] * $tarrif[0]['class_7_value']) + ($dtr_asc['class8'] * $tarrif[0]['class_8_value']) + ($dtr_asc['class9'] * $tarrif[0]['class_9_value']) + ($dtr_asc['class10'] * $tarrif[0]['class_10_value']);
				}
			
		}
			else{
					$tool['revenue'][$u]['special_message'] = "No Tarrif found for this dtr";
						$u = 0;
						foreach($dtr_first as $dtr_asc){
							$u++;
							$tool['revenue'][$u]['label'] = date("j",strtotime($dtr_asc['for_date']));
							$tool['revenue'][$u]['class1']['label'] = 'Car';
							$tool['revenue'][$u]['class2']['label'] = 'Wagon';
							$tool['revenue'][$u]['class3']['label'] = 'Truck';
							$tool['revenue'][$u]['class4']['label'] = 'Bus';
							$tool['revenue'][$u]['class5']['label'] = 'AT Truck';
							$tool['revenue'][$u]['class1']['data'] = 0;
							$tool['revenue'][$u]['class2']['data'] = 0;
							$tool['revenue'][$u]['class3']['data'] = 0;
							$tool['revenue'][$u]['class4']['data'] = 0; 
							$tool['revenue'][$u]['class5']['data'] = 0;
							$tool['revenue'][$u]['data'] = 0;

						}
				}

			}
        return array('toolplaza'=> $toolplaza, 'month'=> $month, 'year' => $year, 'dtr_latest' => $dtr_latest, 'dtr_first' => $dtr_first, 'tollplaza' => $tool);
		
	}
	function dtrmchart_tooldata_month($m){
		$toolplaza = $this->db->select('*')->get('toolplaza')->result_array();
		$month = date('n' ,strtotime($m));
		$year = date('Y', strtotime($m));
		$dtr_last = $this->db->select('*')->where(array('YEAR(for_date)-MONTH(for_date)' => $year-$month))->order_by('for_date', 'desc')->get('dtr')->result_array();
		
		$dtr_old = $this->db->select('*')->where(array('YEAR(for_date)-MONTH(for_date)' => $year-$month))->order_by('for_date', 'asc')->get('dtr')->result_array();
		
		$i = 1; $k = 0;
		$dtr_tool = array();
		foreach($toolplaza as $tool){
			
						
			
			$dtr_tool[$i] = $this->db->select('*')->where('YEAR(for_date)-MONTH(for_date)', date('Y', strtotime($m))-date('n' ,strtotime($m)))->where('toolplaza',$tool['id'])->order_by('for_date', 'desc')->get('dtr')->result_array();
			$dtr_tool_min[$i] = $this->db->select('*')->where('YEAR(for_date)-MONTH(for_date)', date('Y', strtotime($m))-date('n' ,strtotime($m)))->where('toolplaza',$tool['id'])->order_by('for_date', 'asc')->get('dtr')->result_array();
			
			/*?><pre><?php echo print_r($dtr_tool_min); ?></pre> <?php exit;*/ 

			if($dtr_tool[$i] && $dtr_tool_min[$i]){
				$data1 = explode('-', $dtr_tool[$i][0]['for_date']);
				
				$data2 = explode('-', $dtr_tool_min[$i][0]['for_date']);
				
				$start_date1 = implode('/', array($data2[0], $data2[1]));
				
				$end_date1 = implode('/', array($data1[0], $data1[1]));
				
			}
			elseif($dtr_tool[$i] == false && $dtr_tool_min[$i] == false){
				
			}
			
			$tollplaza[$i] = array();
			
			if($dtr_tool_min[$i]){
				$month = date("Y-m",strtotime($dtr_tool_min[$i][0]['for_date']));				
										   
				$tollplaza[$i]['name'] = $this->db->get_where('toolplaza',array('id' => $i))->row()->name;
				$tollplaza[$i]['id'] = $dtr_tool_min[$i][0]['toolplaza'];
				$tollplaza[$i]['status'] = $dtr_tool_min[$i][0]['status'];
				$month_year = explode('-',$dtr_tool[$i][0]['for_date']);
				$start_date = $dtr_tool_min[$i][0]['for_date'];
				$end_date = $dtr_tool[$i][0]['for_date'];
			   $sql = "Select * From terrif Where FIND_IN_SET (".$i." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
				
				$tarrif =  $this->db->query($sql)->result_array();
				//$chart['date'] = $data[0]['for_date'];
				$u = 0;
				foreach($dtr_tool_min[$i] as $dtr){
					$u++;
					$tollplaza[$i]['dtr']['chart'][$u]['dtr_id'] =  $dtr['id'];
					$tollplaza[$i]['dtr']['chart'][$u]['label'] = date("j",strtotime($dtr['for_date']));
					$tollplaza[$i]['dtr']['chart'][$u]['class1']['label'] =  'Car';
					$tollplaza[$i]['dtr']['chart'][$u]['class2']['label'] =  'Wagon';
					$tollplaza[$i]['dtr']['chart'][$u]['class3']['label'] =  'Truck';
					$tollplaza[$i]['dtr']['chart'][$u]['class4']['label'] =  'Bus';
					$tollplaza[$i]['dtr']['chart'][$u]['class5']['label'] =  'AT Truck';
					$tollplaza[$i]['dtr']['chart'][$u]['class1']['data'] =  $dtr['class1'];
					$tollplaza[$i]['dtr']['chart'][$u]['class2']['data'] =  $dtr['class2'];
					$tollplaza[$i]['dtr']['chart'][$u]['class3']['data'] =  $dtr['class3'] + $dtr['class5'] + $dtr['class6'];
					$tollplaza[$i]['dtr']['chart'][$u]['class4']['data'] =  $dtr['class4'];
					$tollplaza[$i]['dtr']['chart'][$u]['class5']['data'] =  $dtr['class7'] + $dtr['class8'] + $dtr['class9'] + $dtr['class10'];
					$tollplaza[$i]['dtr']['chart'][$u]['total'] = $dtr['total'];
					
				}
				
				if($tarrif){
					
					$u = 0;
					foreach($dtr_tool_min[$i] as $dtr){
						$u++;
						$tollplaza[$i]['dtr']['revenue'][$u]['special_message'] = " ";
						$tollplaza[$i]['dtr']['revenue'][$u]['dtr_id'] =  $dtr['id'];
						$tollplaza[$i]['dtr']['revenue'][$u]['label'] = date("j",strtotime($dtr['for_date']));
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['label'] = 'Car';
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['label'] = 'Wagon';
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['label'] = 'Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['label'] = 'Bus';
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['label'] = 'AT Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['data'] = $dtr['class1'] * $tarrif[0]['class_1_value'];
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['data'] = $dtr['class2'] * $tarrif[0]['class_2_value'];
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['data'] =	($dtr['class3'] *  $tarrif[0]['class_3_value']) + ($dtr['class5'] * $tarrif[0]['class_5_value']) + ($dtr['class6'] * $tarrif[0]['class_6_value']);
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['data'] = $dtr['class4'] * $tarrif[0]['class_4_value'];
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['data'] = ($dtr['class7']  * $tarrif[0]['class_7_value']) + ($dtr['class8'] *  $tarrif[0]['class_8_value']) + ($dtr['class9'] * $tarrif[0]['class_9_value']) + ($dtr['class10'] * $tarrif[0]['class_10_value']);
						$tollplaza[$i]['dtr']['revenue'][$u]['total'] = ($dtr['class1'] * $tarrif[0]['class_1_value']) + ($dtr['class2'] * $tarrif[0]['class_2_value']) + ($dtr['class3'] * $tarrif[0]['class_3_value']) + ($dtr['class4'] * $tarrif[0]['class_4_value']) + ($dtr['class5'] * $tarrif[0]['class_5_value']) + ($dtr['class6'] * $tarrif[0]['class_6_value']) + ($dtr['class7'] * $tarrif[0]['class_7_value']) + ($dtr['class8'] * $tarrif[0]['class_8_value']) + ($dtr['class9'] * $tarrif[0]['class_9_value']) + ($dtr['class10'] * $tarrif[0]['class_10_value']);
						
					}
					
				}
				else{
					$tollplaza[$i]['dtr']['revenue'][$u]['special_message'] = "No Tarrif found for this dtr";
					$u = 0;
					foreach($dtr_tool_min[$i] as $dtr){
						$u++;
						$tollplaza[$i]['dtr']['revenue'][$u]['label'] = date("j",strtotime($dtr['for_date']));
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['label'] = 'Car';
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['label'] = 'Wagon';
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['label'] = 'Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['label'] = 'Bus';
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['label'] = 'AT Truck';
						$tollplaza[$i]['dtr']['revenue'][$u]['class1']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['class2']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['class3']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['class4']['data'] = 0; 
						$tollplaza[$i]['dtr']['revenue'][$u]['class5']['data'] = 0;
						$tollplaza[$i]['dtr']['revenue'][$u]['data'] = 0;
						
					}
					
				}
			}
			$i++; $k++;
		}
		
		
		return array('start_date'=> $start_date1, 'end_date'=> $end_date1, 'month' => $month, 'year' => $year, 'dtr_tool_min' => $dtr_tool_min, 'toolplaza' => $toolplaza,'tollplaza' => $tollplaza);
        
	}
	//////////////////////////////////////////////////////////////
	////	/** DTR Charts END  *////////////////////
	///////////////////////////////////////////////////////////////

    function add_weighstation($post = ''){
        $data = array();
        $data['name'] = $post['name'];
        $data['type'] = $post['type'];
        if($post['type'] == 1){
            $data['address'] = $post['ip_address'];
        }
		elseif($post['type'] == 2){
            $data['address'] = $post['ftp_address'];
        }
        $data['adddate'] = date("Y-m-d");
        $data['status'] = 0;
        $this->db->insert('weighstation', $data);
        return TRUE;
    }
    function update_weighstation($weigh_id = '' , $post = ''){
        if(!empty($weigh_id)){
            $data = array();
            $data['name'] = $post['name'];
            if($post['type'] == 1){
                $data['address'] = $post['ip_address'];
            }
			elseif($post['type'] == 2){
                $data['address'] = $post['ftp_address'];
            }
            $this->db->where('id',$weigh_id);
            $this->db->update('weighstation', $data);
            return TRUE;
        }
		else{
            return FALSE;
        }
        
    }
    function add_weighlimit($post = ''){
        //echo "<pre>";
        //print_r($post); exit;
        $data = array();
        $code = $this->db->get_where('weigh_category',array('id'=>$post['cat']))->row()->code;
        $data['cat_id'] = $post['cat'];
        $data['category_code'] = $code;
        $data['weigh_limit'] = $post['weighlimit'];
        $this->db->insert('weigh_limit', $data);
        return TRUE;
    }

    function update_limit($id = '' , $post = ''){
        if(!empty($id)){
            $data = array();
            $code = $this->db->get_where('weigh_category',array('id'=>$post['cat']))->row()->code;
            $data['cat_id'] = $post['cat'];
            $data['category_code'] = $code;
            $data['weigh_limit'] = $post['weighlimit'];
            $this->db->where('id',$id);
            $this->db->update('weigh_limit', $data);
            return TRUE;
        }
		else{
            return FALSE;
        }
        
    }
	
	
	function get_weighstations_dates($weighstation = ''){
        $data = $this->db->select('*')->where('weigh_id',$weighstation)->order_by('date','desc')->limit(1)->get('weighstation_data')->result_array();
        $data_min = $this->db->select('*')->where('weigh_id',$weighstation)->order_by('date','asc')->limit(1)->get('weighstation_data')->result_array();
        
        if($data && $data_min){
            $start_date = str_replace("-", "/", $data_min[0]['date']);// implode('/', array($data2[0], $data2[1]));
            $end_date = str_replace("-", "/", $data[0]['date']);

        }else{
            $start_date = '';
            $end_date = '';
        }
        
        
        return array('start_date'=> $start_date,'end_date'=> $end_date);

    }
    function get_weighstations_months($weighstation = ''){
        $data = $this->db->select('*')->where('weigh_id',$weighstation)->order_by('date','desc')->limit(1)->get('weighstation_data')->result_array();
        $data_min = $this->db->select('*')->where('weigh_id',$weighstation)->order_by('date','asc')->limit(1)->get('weighstation_data')->result_array();
        $max = explode('-', $data[0]['date']);
        $min = explode('-', $data_min[0]['date']);
        
        if($data && $data_min){
            $start_date =  implode('/', array($min[1], $min[0]));
            $end_date = implode('/', array($max[1], $min[0]));

        }else{
            $start_date = '';
            $end_date = '';
        }
        
        
        return array('start_date'=> $start_date,'end_date'=> $end_date);

    }

    function get_weighstation_daily_report($weighstation = ''){
        $sql = "SELECT * FROM weighstation_data WHERE weigh_id =  ".$weighstation." AND date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = ".$weighstation.") ORDER BY time DESC ";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }



    function get_weighstation_monthly_report($weighstation = ''){
        $sql = "SELECT MAX(date) as date FROM weighstation_data WHERE weigh_id = ".$weighstation;
        $result = $this->db->query($sql)->result();
        $d = date_parse_from_format("Y-m-d", $result[0]->date);
       // echo '<pre>';print_r( $d); exit;
        $sql_categories = "SELECT GROUP_CONCAT(code) as code FROM weigh_category GROUP BY axle";
        
        $result_category = $this->db->query($sql_categories)->result_array();
        //echo "<pre>";
        //print_r($result_category); exit;
        $new_sql = "SELECT date,COUNT(ticket_no) AS total_vehicles, sum(fine) total_fine, 
                    sum(case when status = 2 AND vehicle_code IN (".$result_category[0]['code'] .") then 1 else 0 end) 2ax_overloaded,
                    sum(case when status = 2 AND vehicle_code IN (".$result_category[1]['code'] .") then 1 else 0 end) 3ax_overloaded,
                    sum(case when status = 2 AND vehicle_code IN (".$result_category[2]['code'] .",".$result_category[3]['code'].",".$result_category[4]['code'].") then 1 else 0 end) 456ax_overloaded,
                    sum(case when status = 2 then 1 else 0 end) total_vehicles_overloaded,
                    sum(case when status = 1 AND vehicle_code IN (".$result_category[0]['code'] .") then 1 else 0 end) 2ax_inload,
                    sum(case when status = 1 AND vehicle_code IN (".$result_category[1]['code'] .") then 1 else 0 end) 3ax_inload,
                    sum(case when status = 1 AND vehicle_code IN (".$result_category[2]['code'] .",".$result_category[3]['code'].",".$result_category[4]['code'].") then 1 else 0 end) 456ax_inload,
                    sum(case when status = 1 then 1 else 0 end) total_vehicles_inload
          FROM weighstation_data WHERE weigh_id = ".$weighstation." AND MONTH(date) = ".$d['month'] ." AND YEAR(date) = ".$d['year']." GROUP BY date";
        $new_result = $this->db->query($new_sql)->result_array();
        //echo $this->db->last_query(); exit;
        //echo "<pre>";
        //print_r($new_result); exit;
       return $new_result;
    }

    ///////search weighstation monthly report//////

    function search_weighstation_monthly_report($weighstation = '', $date = ''){
        
        $date = explode('/', $date);

        $sql_categories = "SELECT GROUP_CONCAT(code) as code FROM weigh_category GROUP BY axle";
        
        $result_category = $this->db->query($sql_categories)->result_array();
        
        $new_sql = "SELECT date,COUNT(ticket_no) AS total_vehicles, sum(fine) total_fine, 
            sum(case when status = 2 AND vehicle_code IN (".$result_category[0]['code'] .") then 1 else 0 end) 2ax_overloaded,
            sum(case when status = 2 AND vehicle_code IN (".$result_category[1]['code'] .") then 1 else 0 end) 3ax_overloaded,
            sum(case when status = 2 AND vehicle_code IN (".$result_category[2]['code'] .",".$result_category[3]['code'].",".$result_category[4]['code'].") then 1 else 0 end) 456ax_overloaded,
            sum(case when status = 2 then 1 else 0 end) total_vehicles_overloaded,
            sum(case when status = 1 AND vehicle_code IN (".$result_category[0]['code'] .") then 1 else 0 end) 2ax_inload,
            sum(case when status = 1 AND vehicle_code IN (".$result_category[1]['code'] .") then 1 else 0 end) 3ax_inload,
            sum(case when status = 1 AND vehicle_code IN (".$result_category[2]['code'] .",".$result_category[3]['code'].",".$result_category[4]['code'].") then 1 else 0 end) 456ax_inload,
            sum(case when status = 1 then 1 else 0 end) total_vehicles_inload
            FROM weighstation_data WHERE weigh_id = ".$weighstation." AND MONTH(date) = ".$date[0] ." AND YEAR(date) = ".$date[1]." GROUP BY date";
        $new_result = $this->db->query($new_sql)->result_array();
        //echo $this->db->last_query(); exit;
        //echo "<pre>";
        //print_r($new_result); exit;
       return $new_result;  
    }
////////////////// dashboard timer START ////////
    public function dashboard_timer(){
        $data = $this->db->select('*')->order_by('id','desc')->limit(1)->get('toolplaza')->result_array();
        $data_min = $this->db->select('*')->order_by('id','asc')->limit(1)->get('toolplaza')->result_array();
        //echo "<pre>";
        //print_r($data_min); exit;
        if($data && $data_min){
            $min_value = $data_min[0]['id']; 
            $max_value = $data[0]['id'];
        }
        else{

        }
        return array('min_value'=> $min_value);

        
    }
////////////////// dashboard timer END ////////
    function add_weighstation_cat($post = ''){
        $data = array();
        $data['name'] = $post['name'];
        $data['axle'] = $post['axle'];
        $data['code'] = $post['code'];
        $data['date'] = date("Y-m-d");
        $this->db->insert('weigh_category', $data);
        return TRUE;
    }
    function update_weighstation_cat($cat_id = '' , $post = ''){
        if(!empty($cat_id)){
            $data = array();
            $data['name'] = $post['name'];
            $data['axle'] = $post['axle'];
            $data['code'] = $post['code'];
            $this->db->where('id',$cat_id);
            $this->db->update('weigh_category', $data);
            return TRUE;
        }
		else{
            return FALSE;
        }
        
    }
    function add_googlelocations($post = ''){
        $data = array();
        $data['name'] = $post['name'];
        $data['type'] = $post['type'];
        $data['road_id'] = $post['road'];
        $data['location_id'] = $post['loc_id'];
        $data['address'] = $post['address'];
        $data['state'] = $post['state'];
        $data['lat'] = $post['lat'];
        $data['lang'] = $post['lang'];
        $data['chainage'] = $post['chainage'];
        $data['status'] = 0;
        $this->db->insert('google_locations', $data);
        return TRUE;
    }
    function update_googlelocations($id = '' , $post = ''){
        $data = array();
        $data['name'] = $post['name'];
        $data['type'] = $post['type'];
        $data['road_id'] = $post['road'];
        $data['location_id'] = $post['loc_id'];
        $data['address'] = $post['address'];
        $data['state'] = $post['state'];
        $data['lat'] = $post['lat'];
        $data['lang'] = $post['lang'];
        $data['chainage'] = $post['chainage'];
        $this->db->where('id',$id);
        $this->db->update('google_locations', $data);
        return TRUE;
    }


    
    function add_googleroads($post = ''){
        $data = array();
        $data['name'] = $post['name'];
        $data['data'] = $post['road_data'];
        $data['address'] = $post['address'];
        if (!preg_match('([+-]?\d+(?:\.\d+)?)', $post['lat']) || !preg_match('([+-]?\d+(?:\.\d+)?)', $post['lat'])){
            $temp = json_decode($post['road_data']);
            $middleElem = ceil(count($temp)/2);
            $keys = array_keys($temp);
            $middleKey = $keys[$middleElem];
            $lat = $temp[$middleKey]->lat;
            $lang = $temp[$middleKey]->lng;
            $data['lat'] = $lat;
            $data['lang'] = $lang;
        }
		else{

            $data['lat'] = $post['lat'];
            $data['lang'] = $post['lang'];

        }
        $data['route'] = $post['route'];
        $data['status'] = 0;
        $this->db->insert('roads', $data);
        return TRUE;
    }
    function update_googleroads($id = '',$post = ''){
        $data = array();
        $data['name'] = $post['name'];
        $data['data'] = $post['road_data'];
        $data['address'] = $post['address'];
        $data['route'] = $post['route'];
        if (!preg_match('([+-]?\d+(?:\.\d+)?)', $post['lat']) || !preg_match('([+-]?\d+(?:\.\d+)?)', $post['lat'])){
                $temp = json_decode($post['road_data']);
                $middleElem = ceil(count($temp)/2);
                $keys = array_keys($temp);
                $middleKey = $keys[$middleElem];
                $lat = $temp[$middleKey]->lat;
                $lang = $temp[$middleKey]->lng;
                $data['lat'] = $lat;
                $data['lang'] = $lang;
            }
		else{

                $data['lat'] = $post['lat'];
                $data['lang'] = $post['lang'];

            }
        $this->db->where('id',$id);
        $this->db->update('roads', $data);
        return TRUE;
    }


    function getinfodetails_tp($data = ''){
        
        $month_year = explode('-',$data[0]['for_month']);
        $start_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['start_date'];
        $end_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['end_date'];
        $sql = "Select * From terrif Where FIND_IN_SET (".$data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
        $tarrif =  $this->db->query($sql)->result_array();
        
        $total_traffic = $data[0]['class1'] + $data[0]['class2'] + $data[0]['class3'] +$data[0]['class4'] +$data[0]['class5'] +$data[0]['class6'] +$data[0]['class7'] +$data[0]['class8'] + $data[0]['class9'] +$data[0]['class10'];
        if($tarrif){
           $total_revenue = ($data[0]['class1'] * $tarrif[0]['class_1_value'])+($data[0]['class2'] * $tarrif[0]['class_2_value']) +
                                               ($data[0]['class3'] *  $tarrif[0]['class_3_value'])+($data[0]['class4'] * $tarrif[0]['class_4_value']) + 
                                               ($data[0]['class5'] * $tarrif[0]['class_5_value'])+($data[0]['class6'] * $tarrif[0]['class_6_value']) +
                                               ($data[0]['class7']  * $tarrif[0]['class_7_value']) + ($data[0]['class8'] *  $tarrif[0]['class_8_value'])+
                                               ($data[0]['class9'] * $tarrif[0]['class_9_value']) + ($data[0]['class10'] * $tarrif[0]['class_10_value']);
          
       }
		else{
            $total_revenue = 0;
       }
               
        return array('traffic'=> $total_traffic,'revenue'=> $total_revenue,'date' => $data[0]['for_month']);
	}
	function getSites(){  
        $sites = $this->db->get('toolplaza')->result_array();
           
        return $sites;
    }
}