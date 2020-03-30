<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tcd_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
		date_default_timezone_set('Asia/Karachi');
	}
	public $table = 'tcd';
	
	public function get_table($table){
		$select = '*';  $column = 'id'; $para = 'DESC';
		$data = $this->database_model->get_select__orderby($select, $table, $column, $para);
		
		return $data;
	}
	public function toolplaza_table($page,$table){
		if($page == 'R'){
			$tcd = $this->get_table($table)->result_array();
			$i = 0;
			$toolplaza = array();
			foreach($tcd as $row){
				$table = 'toolplaza'; $where = array('id' =>$row['toolplaza_id']);
				$toolplaza[$i] = $this->database_model->get_where($table, $where)->row()->name;
				$i++;
			}
		}
		elseif($page == 'C'){
			$toolplaza = $this->db->get('toolplaza')->row()->name;
		}
		return $toolplaza;
	}
	public function check_table($table, $where){
		return $this->db->get_where($table, $where);
	}
	public function postload($table, $where){
		$postload = $tcd = $this->database_model->get_where($table, $where)->result_array();
		$tool = $postload[0]['toolplaza_id']; $date = $postload[0]['datecreated'];
		$toll = 'toolplaza'; $where = array('id' => $tool);
		$postload[0]['plaza_name'] = $this->database_model->get_where($toll, $where)->row()->name;
		$terrif = $this->calculation_model->terrif_value($tool, $date)->result_array();
		if(isset($terrif[0][0])){
			$tarrif[0][0]['class_1_value'] = $terrif[0]['class_1_value'];
			$tarrif[0][0]['class_2_value'] = $terrif[0]['class_2_value'];
			$tarrif[0][0]['class_3_value'] = $terrif[0]['class_4_value'];
			$tarrif[0][0]['class_4_value'] = $terrif[0]['class_3_value'];
			$tarrif[0][0]['class_5_value'] = $terrif[0]['class_7_value'];
			
		}
		else{
			$tarrif[0][0]['message'] = 'Tarrif does not exist for this Tollplaza';
		}
		
		$postload[0]['terrif'] = $tarrif;
		
		
		$postload[0]['calculation'] = $this->calculation_model->revenue_tcd($tcd[0], $tarrif[0]);
		/*?><pre> <?php echo print_r(array($tarrif));exit;*/
		return $postload[0];
	}
	public function _list($para2){
		$select = array('id','name');$table = 'toolplaza'; 
		if($para2){ 
			$where = array('id' => $para2);
			$toolplaza = $this->database_model->get_select($select, $table, $where)->result_array();
		}
		else{
			$toolplaza = $this->database_model->select_from($select,$table)->result_array();
		}
		$tool = $toolplaza[0]['id'];
		$table = 'tcd';
		if($para2){
			$select = '*'; $where = array('toolplaza_id' => $para2);
			$table_data = $this->database_model->get_select($select, $table, $where);
		}
		else{
			$table_data = $this->tcd_model->get_table($table);
		}
		$i = 0;
		foreach($table_data->result_array() as $row){
			$select = 'name'; 
			$table = 'toolplaza'; 
			$where = array('id' => $row['toolplaza_id']);
			$tcd_tool_name[$i] = $this->database_model->get_select($select, $table, $where)->result_array();
			$i++;
		}
		if(isset($tcd_tool_name)){
			$tool_name = $tcd_tool_name;
		}
		$table = 'tcd';
		if($para2){
			$where = array('toolplaza_id' => $para2);
			$tcd = $table_data->result_array();
			
		}
		else{
			$tcd = $this->get_table($table)->result_array();
			
		}
		if(isset($tool_name)){
			return array('tcd' => $tcd, 'tool_name' => $tool_name);
		}
		else{
			return array('tcd' => $tcd);
		}
	}
	public function lisst(){
		$table = 'tcd';
		$table_data = $this->tcd_model->get_table($table);
				$i = 0;
				foreach($table_data->result_array() as $row){
					$select = 'name'; 
					$table = 'toolplaza'; 
					$where = array('id' => $row['toolplaza_id']);
					$tcd_tool_name[$i] = $this->database_model->get_select($select, $table, $where)->result_array();

					$i++;
				}
				if(isset($tcd_tool_name)){
					$tool_name = $tcd_tool_name;
				}
				
				$tcd = $table_data->result_array();
		return array('tool_name' => $tool_name, 'tcd' => $tcd);
	}
	public function specific_tcr($para2){
		$where = array('id' => $para2);
		return $this->db->get_where($this->table, $where)->result_array();
	}
	public function tcr_edit_data($para2, $tcd){
		$table = 'toolplaza'; $where = array('id' => $tcd['toolplaza_id']);
		$data['id'] = $para2;
		$data['toolplaza_id'] = $tcd['toolplaza_id'];
		$data['tool_name'] = $this->db->get_where($table, $where)->row()->name;
		$table = 'admin'; $where = array('id' => $tcd['admin_id']);
		$data['admin_name'] = $this->db->get_where($table, $where)->row()->fname.' '.$this->db->get_where($table, $where)->row()->lname;
		for($i = 1; $i<6; $i++){
			$data['class'.$i] = $tcd['class'.$i];
		}
		$data['total'] = $tcd['total'];
		$data['survey_month'] = $tcd['survey_month'];
		$data['datecreated'] = $tcd['datecreated'];
		
		
		return $data;
	}
}
		