<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dtr_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
	//	date_default_timezone_set('Asia/Karachi');
	}
	public function month_data($date){
		$traffic_total = $this->db->query('SELECT for_date, total FROM dtr WHERE MONTH(for_date) = MONTH("'.$date.'")');
		
		/*?> <?php echo print_r($this->db->last_query());*/
		return $traffic_total->result_array();
	}
	public function toll_month_data($tool,$date){
		$traffic_total = $this->db->query('SELECT for_month, total FROM mtr WHERE for_month = "'.$date.'" AND toolplaza = '.$tool);
		return $traffic_total->result_array();
	}	
	public function toll_date_data($tool, $date){
		$traffic_total = $this->db->query('SELECT total FROM view_dtr_tool_date WHERE toolplaza = '.$tool.' AND for_date = "'.$date.'"')->result_array();
		return $traffic_total;
	}
	public function toolplaza($month, $period, $start, $end){
		$tool = $this->db->query('SELECT id, name, status FROM toolplaza WHERE status = 1')->result_array();
		$tol = 0; $days = 30;
		foreach($tool as $toll){
			
			$data['tool'][$tol]['div'] = 'chart-div-'.$toll['id'];
			$data['tool'][$tol]['id'] = $toll['id'];
			$data['tool'][$tol]['name'] = $toll['name'];
			$data['tool'][$tol]['duration'] = 'From '.date('jS F, Y', strtotime($start)).' to '.date('jS F, Y', strtotime($end));
			$data['tool'][$tol]['traffic'] = 0;
			$mdata = $this->toll_month_data($toll['id'], $month);
			if(isset($mdata[0]['total'])){
				$data['tool'][$tol]['month_total'] = $mdata[0]['total'];
				$data['tool'][$tol]['data'][0]['date'] =  date('F', strtotime($month));
				$data['tool'][$tol]['data'][0]['traffic'] = floor($data['tool'][$tol]['month_total'] / $days);
				$data['tool'][$tol]['data'][0]['percentage'] = round(($data['tool'][$tol]['data'][0]['traffic'] / $data['tool'][$tol]['data'][0]['traffic']) * 100, 2).'%';
			}
			$no = 1;
			foreach ($period as $key => $value){
				$dudate[$no] = $value->format('Y-m-d');
				
				$tmd = $this->toll_date_data($toll['id'], $dudate[$no]);
				if(isset($tmd[0])){
					$data['tool'][$tol]['data'][$no]['date'] = date('j F, Y',strtotime($dudate[$no]));
					$data['tool'][$tol]['data'][$no]['traffic'] = $tmd[0]['total'];
					$data['tool'][$tol]['traffic'] = $data['tool'][$tol]['traffic'] + $tmd[0]['total'];
					if(isset($data['tool'][$tol]['data'][0]['traffic'])){
						$data['tool'][$tol]['data'][$no]['percentage'] = round(($data['tool'][$tol]['data'][$no]['traffic'] / $data['tool'][$tol]['data'][0]['traffic']) * 100, 2).'%';
					}
					
				}
				$no++; 
			}
			if(isset($data['tool'][$tol]['data'])){
				if(isset($data['tool'][$tol]['data'][0]['traffic'])){
					$date_count = count($data['tool'][$tol]['data']) - 1;
				}
				else{
					$date_count = count($data['tool'][$tol]['data']);
				}
				
				if($data['tool'][$tol]['traffic'] != 0 && isset($date_count)){
					$data['tool'][$tol]['data'][$no]['date'] = 'Avg Per Day';
					$data['tool'][$tol]['data'][$no]['traffic'] = floor($data['tool'][$tol]['traffic'] / $date_count);
					if(isset($data['tool'][$tol]['data'][0]['traffic'])){
						$data['tool'][$tol]['data'][$no]['percentage'] = round(($data['tool'][$tol]['data'][$no]['traffic'] / $data['tool'][$tol]['data'][0]['traffic']) * 100, 2).'%';
					}
				}
			}
			
			$tol++;
		}
		return $data;
	}
	public function dtr_date_checker($date, $tool){
		$dtr_date = $this->db->query('SELECT * FROM dtr WHERE for_date = \''.$date.'\' AND toolplaza = \''.$tool.'\'')->result_array();
		return $dtr_date;
	}
}