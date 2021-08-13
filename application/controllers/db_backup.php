<?php
defined('BASEPATH') or exit('No direct script is allowed');
class Db_backup extends CI_Controller{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
			$this->load->dbutil();
			
			$prefs = array(     
			    'format'      => 'zip',             
			    'filename'    => 'my_db_backup.sql'
			    );


			$backup =& $this->dbutil->backup($prefs); 

			$db_name = 'backup-on-'. date("Y-m-d") .'.zip';
			$save = 'D:/nha_database_backup/'.$db_name;
			$this->load->helper('file');
			write_file($save, $backup); 


			$this->load->helper('download');
			force_download($db_name, $backup);
	}
	
}
?>
