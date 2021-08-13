<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class database_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->library('form_validation');
		//$this->load->helper('form');
		//date_default_timezone_set('Asia/Karachi');
	}
		
	public function get_select($select, $table, $where){
		return $this->db->select($select)->from($table)->where($where)->get();
	}
	public function select_from($select, $table){
		return $this->db->select($select)->from($table)->get();
	}
	public function get_select_orderby($select, $table, $where, $column, $para){
		return $this->db->select($select)->from($table)->where($where)->order_by($column, $para)->get();
	}
	public function get_select__orderby($select, $table, $column, $para){
		return $this->db->select($select)->from($table)->order_by($column, $para)->get();
	}
	
	public function get_where($table, $where){
		return $this->db->get_where($table, $where);
	}
	public function query($query){
		return $this->db->query($query);
	}
	public function orderby($column, $para){
		return $this->db->order_by($column, $para);
	}
	public function where($column, $where){
		return $this->db->where($column, $where);
	}
	public function get($table){
		return $this->db->get($table)->result_array();
	}
	public function only_get($table){
		return $this->db->get($table);
	}
	public function insert($table, $data){
		$this->db->limit(1);					
		$insert = $this->db->insert($table, $data);
		return true;
	}
	public function update($where, $para2, $table, $data){
		$this->db->limit(1);
		$this->db->where($where, $para2);
		$upd = $this->db->update($table, $data);
		return $upd;
	}
	public function delete($para2, $table){
		$this->db->where('id', $para2);
		$dlt1 = $this->db->delete($table);
	}
}