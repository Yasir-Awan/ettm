<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class nha extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
		//date_default_timezone_set('Asia/Karachi');
	}
	public function mtr_per_year($year){
		$querymtr = 'SELECT * FROM mtr WHERE YEAR(for_month) = YEAR(NOW() -  INTERVAL '.$year.' YEAR) AND status = 1 ORDER BY ID DESC';
		return $this->database_model->query($querymtr);
	}
	public function mtr_toll_per_year($year, $toll){
		$querymtr = 'SELECT * FROM mtr WHERE YEAR(for_month) = YEAR(NOW() -  INTERVAL '.$year.' YEAR) AND toolplaza = '.$toll.' AND status = 1 ORDER BY ID DESC';
		return $this->database_model->query($querymtr);
	}
	public function mtr_traffic_revenue_exempt($data, $year){
		$traffic['tollplaza'] = $this->database_model->get_select('id, name', 'toolplaza', ['status' => 1])->result_array();
		$traffic['year'] = date('Y') - $year;
		$count = 0; $traffic['total_traffic'] = 0; $traffic['total_revenue'] = 0; $total_class = 0; $traffic['total_not_exempt'] = 0; $traffic['total_exempt'] = 0; for($i = 1; $i < 11; $i++){ $class[$i] = 0;  $exempt_class[$i] = 0; }
		if(isset($data)){
		foreach($data as $mtr){
			$traffic['total_traffic'] = $traffic['total_traffic'] + $mtr['total'];
			
			$terrif = $this->calculation_model->terrif($mtr['toolplaza'], $mtr['for_month'])->result_array();
			$exempt[$count] = $this->db->get_where('exempt', array('mtr_id' => $mtr['id']))->result_array();
			$toolplaza = $this->db->get_where('toolplaza', array('status' => 1))->result_array();
			for($i = 1; $i < 11;  $i++){
				
				$mtr_class[$i] = $mtr['class'.$i];
				$class[$i] = ($class[$i] + $mtr['class'.$i]);
				if(isset($exempt[$count][0])){
					$exempt_class[$i] = $exempt_class[$i] + $exempt[$count][0]['class'.$i];
				}
				
			}
			for($i = 1; $i < 11; $i++){
				$not_exempt[$i] = $class[$i] - $exempt_class[$i];
				
				$revenue[$i] = $terrif[0]['class_'.$i.'_value'] * $not_exempt[$i];
			}
			$traffic['traffic'][1] = $class[1]; 
			$traffic['traffic'][2] = $class[2];
			$traffic['traffic'][3] = $class[3] + $class[5] + $class[6];
			$traffic['traffic'][4] = $class[4];
			$traffic['traffic'][5] = $class[7] + $class[8] + $class[9] + $class[10];
			$traffic['not_exempt'][1] = $not_exempt[1]; 
			$traffic['not_exempt'][2] = $not_exempt[2];
			$traffic['not_exempt'][3] = $not_exempt[3] + $not_exempt[5] + $not_exempt[6];
			$traffic['not_exempt'][4] = $not_exempt[4];
			$traffic['not_exempt'][5] = $not_exempt[7] + $not_exempt[8] + $not_exempt[9] + $not_exempt[10];
			$traffic['exempt'][1] = $exempt_class[1]; 
			$traffic['exempt'][2] = $exempt_class[2];
			$traffic['exempt'][3] = $exempt_class[3] + $exempt_class[5] + $exempt_class[6];
			$traffic['exempt'][4] = $exempt_class[4];
			$traffic['exempt'][5] = $exempt_class[7] + $exempt_class[8] + $exempt_class[9] + $exempt_class[10];
			$traffic['revenue'][1] = $revenue[1]; 
			$traffic['revenue'][2] = $revenue[2];
			$traffic['revenue'][3] = $revenue[3] + $revenue[5] + $revenue[6];
			$traffic['revenue'][4] = $revenue[4];
			$traffic['revenue'][5] = $revenue[7] + $revenue[8] + $revenue[9] + $revenue[10];
			
			$traffic['total_not_exempt'] = $traffic['not_exempt'][1] + $traffic['not_exempt'][2] + $traffic['not_exempt'][3] + $traffic['not_exempt'][4] + $traffic['not_exempt'][5];
			$traffic['total_exempt'] = $traffic['exempt'][1] + $traffic['exempt'][2] + $traffic['exempt'][3] + $traffic['exempt'][4] + $traffic['exempt'][5];
			$traffic['total_revenue'] = $traffic['revenue'][1] + $traffic['revenue'][2] + $traffic['revenue'][3] + $traffic['revenue'][4] + $traffic['revenue'][5];
			
			
			
			$count++;
		}
		}
		else{
			$traffic['message'] = 'MTRs are not present';
			$traffic['traffic'][1] = '';
			$traffic['traffic'][2] = '';
			$traffic['traffic'][3] = '';
			$traffic['traffic'][4] = '';
			$traffic['traffic'][5] = '';
			$traffic['not_exempt'][1] = ''; 
			$traffic['not_exempt'][2] = '';
			$traffic['not_exempt'][3] = '';
			$traffic['not_exempt'][4] = '';
			$traffic['not_exempt'][5] = '';
			$traffic['exempt'][1] = ''; 
			$traffic['exempt'][2] = '';
			$traffic['exempt'][3] ='';
			$traffic['exempt'][4] = '';
			$traffic['exempt'][5] = '';
			$traffic['revenue'][1] = ''; 
			$traffic['revenue'][2] = '';
			$traffic['revenue'][3] = '';
			$traffic['revenue'][4] = '';
			$traffic['revenue'][5] = '';
			
			$traffic['total_not_exempt'] = '';
			$traffic['total_exempt'] = '';
			$traffic['total_revenue'] = '';
		}
		/*?><pre> <?php echo print_r($class);*/
		/*?><pre> <?php echo print_r($traffic); exit; */
		/*?><pre> <?php echo print_r($traffic['exempt']); exit;*/
		return $traffic;
	}
}