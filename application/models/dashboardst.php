<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboardst extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
		date_default_timezone_set('Asia/Karachi');
	}
	public function main($id){
		$dashboard[0] = $this->db->query('CALL dashboard_count(\''.$id.'\');')->result_array();
		$this->db->next_result();
		$tool = NULL;
		$dashboard[1] = $this->db->query('CALL dashboard_data(\''.$id.'\');')->result_array();
		$this->db->next_result();
		return $dashboard; 
	}
	public function data($id, $tool){
		$dashboard = $this->db->query('CALL dashboard_dsr_data(\''.$id.'\',\''.$tool.'\');')->result_array();
		$this->db->next_result();
		return $dashboard;
	}
	public function lane_cameras($id, $tool){
		$dashboard = $this->db->query('CALL dashboard_dsr_lane_cameras(\''.$id.'\',\''.$tool.'\');')->result_array();
		$this->db->next_result();
		return $dashboard;
	}
	public function dsr_extended($id, $tool, $post){
        if(isset($post['from_date']) && isset($post['to_date'])){
            $dashboard = $this->db->query('CALL dashboard_extended(\''.$id.'\',\''.$tool.'\',\''.$post['from_date'].'\',\''.$post['to_date'].'\');')->result_array();
		    $this->db->next_result();
        }
        else{
            $dashboard = $this->db->query('CALL dashboard_extended(\''.$id.'\',\''.$tool.'\',\'\',\'\');')->result_array();
		    $this->db->next_result();
        }
		
		/* ?><pre> <?php echo print_r($dashboard);exit; */
		return $dashboard;
	}
	public function repeating_dates($tool){
		$dashboard['dsr'] = $this->db->query('CALL repeating_dates_dsr(\''.$tool.'\');')->result_array();
		$this->db->next_result();
		$dashboard['dtr'] = $this->db->query('CALL repeating_dates_dtr(\''.$tool.'\');')->result_array();
		$this->db->next_result();
		return $dashboard;
	}
	public function total_traffic(){
		$dashboard[0] = $this->db->query('CALL dashboard_total_traffic();')->result_array();
		$this->db->next_result();
		return $dashboard[0];
	}
}