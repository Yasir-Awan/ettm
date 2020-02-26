<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model 


{
	public function __construct()
  	{
    parent::__construct();
	}
	//The Database Table
	public $table_name = '';
	
	//Primary Key Field
	public $primary_key = '';
	
	//Filter for Primary Key
	public $primaryFilter = 'intval';
	
	
	//Order by Field, Default Order for this model
	public $order_by = '';
	
	public function find($ids= FALSE)
	{
		//return "UMAR";
		//if we are passing a single id then we should get a single record.
		$single = $ids == FALSE || is_array($ids) ? FALSE : TRUE;
		
		//Tinkering with the code
		/*if($ids == FALSE || is_array($ids))
		 {
			$single = FALSE;
		 }
		else
		{
			$single = TRUE; 
		 }*/
		
		
		
		if($ids !== FALSE)
		{
			//check if the ID is an array
			is_array($ids) || $ids = array($ids);
			
			//sanitize ID
			$filter = $this->primaryFilter;
			$ids = array_map($filter, $ids);
			
			//using active method as we are dealing with array
			$this->db->where_in($this->primary_key, $ids);
		}
			//check order by if it was already set
			if(!empty($this->db->order_by)) 
			{
				$this->db->order_by($this->order_by);
			}
				
			//Return Results
			$single == FALSE || $this->db->limit(1);
			$method = $single ? 'row_array' : 'result_array';
			return $this->db->get($this->table_name)->$method();
	}
	
	public function find_by($key, $val = FALSE, $orwhere = FALSE, $single = FALSE)
	{	
		if(!is_array($key))
		{
			$this->db->where(htmlentities($key), htmlentities($val));
		}
		else
		{
			$key = array_map('htmlentities', $key);
			$where_method = $orwhere == TRUE ? 'or_where' : 'where';
			$this->db->$where_method($key);
		}
		
		//Return Results
			$single == FALSE || $this->db->limit(1);
			$method = $single ? 'row_array' : 'result_array';
			return $this->db->get($this->table_name)->$method();
	}
	
	public function get_assoc($ids = FALSE)
	{
		$result = $this->find($ids);
		if ($ids != FALSE && !is_array($ids))
		{
			$result = array($result);
		}
		
		$data = $this->to_assoc($result);
		
		return $data;
	}
	
	public function to_assoc($result = array())
	{
		$data = array();
		
		if(count($result) > 0)
		{
			foreach($result as $row)
			{
				$tmp = array_values(array_slice($row, 0, 1));
				$data[$tmp[0]] = $row;
			}
		}
		return $data;
	}
	
	public function save($data, $id = FALSE)
	{
		if($id == FALSE)
		{
			//insert data
			$this->db->set($data)->insert($this->table_name);
		}
		else
		{
			//update
			$filter = $this->primaryFilter;
			$this->db->set($data)->where($this->primary_key, $filter($id))->update($this->table_name);
		}
		
		//return id
			return $id == FALSE? $this->db->insert_id() : $id;
	}
	
	public function delete($ids)
	{
		$filter = $this->primaryFilter;
		$ids = !is_array($ids) ? array($ids) : $ids;
		
		foreach($ids as $id)
		{
			$id = $filter($id);
			if($id)
			{
				$this->db->where($this->primary_key, $id)->limit(1)->delete($this->table_name);
				
			}
		}
			
	}
	public function delete_by($key, $val)
	{
		if(empty($key))
		{
			return FALSE;
		}
		$this->db->where(htmlentities($key), htmlentities($val))->delete($this->table_name);
	}
	
	public function find_multiple($ids)
	{
		{
		//return "UMAR";
		//if we are passing a single id then we should get a single record.
		$single = $ids == TRUE || is_array($ids) ? TRUE : FALSE;
		
		//Tinkering with the code
		/*if($ids == FALSE || is_array($ids))
		 {
			$single = FALSE;
		 }
		else
		{
			$single = TRUE; 
		 }*/
		
		
		
		if($ids !== TRUE)
		{
			//check if the ID is an array
			is_array($ids) || $ids = array($ids);
			
			//sanitize ID
			$filter = $this->primaryFilter;
			$ids = array_map($filter, $ids);
			
			//using active method as we are dealing with array
			$this->db->where_in($this->primary_key, $ids);
		}
			//check order by if it was already set
			if(!empty($this->db->order_by)) 
			{
				$this->db->order_by($this->order_by);
			}
				
			//Return Results
			//$single == FALSE || $this->db->limit(1);
			//$method = $single ? 'row_array' : 'result_array';
			return $this->db->get($this->table_name)->result_array();
	}
	}
}

