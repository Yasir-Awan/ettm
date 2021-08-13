<?php 
defined('BASEPATH') OR exit('NO direct script is allowed');
class Weighstations extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->page_data = array();
		$this->page_data['css'] = '';
		$this->page_data['js'] = '';
		$this->page_data['page_url'] = current_url();
		$this->page_data['custom'] = '';
		$this->load->model('Admin_model');
	}
	///////////////////////////////////////////////////////////////
	////	/** Login Logout START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function login(){
		$this->load->view('back/WeighUsers/weigh_login');
	}
	public function do_login(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Email', 'required');
		$this->form_validation->set_rules('password','Password','required');
		if($this->form_validation->run() == FALSE){
			echo json_encode(array('response' => FALSE, 'message' => validation_errors()));
		}else{
			$weigh_info  = $this->db->get_where('weigh_company', array(
					'username' => $this->input->post('username'),
					'password' => sha1($this->input->post('password')),
					'status'	   => 1			
				))->result_array();
			if($weigh_info){
				$this->session->set_userdata('weighsupr_id',$weigh_info[0]['id']);
				$this->session->set_userdata('name',$weigh_info[0]['name']);
				$this->session->set_userdata('username',$weigh_info[0]['username']);
				$this->session->set_userdata('status',$weigh_info[0]['status']);
			 	$this->session->set_userdata('company',$weigh_info[0]['weigh_company']);
                // echo "<pre>"; print_r($this->session->userdata('site')); exit;
				echo json_encode(array('response' => TRUE , 'message' => 'Successfull Login', 'is_redirect' => TRUE , 'redirect_url' => base_url().'weighstations/index'));			
			}else{
				echo json_encode(array('response' => FALSE , 'message' => 'Invalid Username or wrong Passord')); exit;
			}
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url().'weighstations','refresh');
	}
	
	///////////////////////////////////////////////////////////////
	////	/** weightstation START  *////////////////////
	///////////////////////////////////////////////////////////////
	public function index($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('weighsupr_id')){
			
			return redirect('weighstations/login');
	
		}
		
			$this->page_data['page'] = 'weighstation daily report';
			if($this->session->userdata('company')==2)
			$weigh = $this->db->select('*')->where('status', 1)->group_start()->or_where('software_type','1')->or_where('software_type','2')->group_end()->get('weighstation')->result_array();
			if($this->session->userdata('company')==1)
			$weigh = $this->db->get_where('weighstation',array('status' => 1,'software_type' => 3))->result_array();        	
			$this->page_data['weighstation'] = $weigh;//$this->db->get_where('weighstation',array('status' => 1))->result_array();
			
			$records = array();
			$counter = 0;
			foreach($weigh as $row){
				$sqli = 'SELECT weigh_id,date,
				COUNT(ticket_no) AS total_vehicles,
				sum(case when status = 2 then 1 else 0 end) overloaded,
				sum(case when status = 2 then fine else 0 end) fined
				FROM
				weighstation_data
				WHERE date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = '.$row["id"].')
				AND weigh_id = '.$row["id"];
				$datas =  $this->db->query($sqli)->result_array();
				//echo "<pre>";
				//print_r($datas); exit;
				$records[$counter]['id'] = $row['id'];
				$records[$counter]['name'] = $row['name'];
				$records[$counter]['total_vehicles'] = $datas[0]['total_vehicles'];
				if($datas[0]['overloaded']){
					$records[$counter]['overloaded'] = $datas[0]['overloaded'];
				}else{
					$records[$counter]['overloaded'] = 0;
				}
				if($datas[0]['fined']){
					$records[$counter]['fined'] = $datas[0]['fined'];
				}else{
					$records[$counter]['fined'] = 0;
				}
				if($datas[0]['date']){
					$records[$counter]['date'] = $datas[0]['date'];
				}else{
					$records[$counter]['date'] = date('Y-m-d');
				}
				//$records[$counter]['last_updated'] = $row['last_updated'];
				$records[$counter]['last_updated'] = $row['last_updated'];
				$records[$counter]['con_status'] = $row['con_status'];
				$counter++;
				
	
			}
			// echo "<pre>";
			// print_r($records); exit;
		 //    $sql = 'SELECT weighstation.id ,weighstation.con_status as con_status, weighstation.name,
		 //    weighstation_data.weigh_id,
			// weighstation.last_updated,
		 //    weighstation_data.date,
		 //    COUNT(weighstation_data.ticket_no) AS total_vehicles,
		 //    sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
		 //    sum(case when weighstation_data.status = 2 then fine else 0 end) fined
			// FROM
		 //    weighstation
		 //    LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
			// WHERE weighstation_data.date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = weighstation.id)
			// AND weighstation.status = 1
			// GROUP BY
		 //    weighstation.id';
			// $query= $this->db->query($sql);
			 $sql1 = "SELECT 
			DATE_FORMAT(weighstation_data.date, '%M, %Y') as date,
			COUNT(ticket_no) AS total_vehicles_m,
			sum(case when weighstation.loc = 1 then 1 else 0 end) total_vehicles_m_m,
			sum(case when weighstation.loc = 2 then 1 else 0 end) total_vehicles_m_h,
			sum(case when weighstation_data.status = 2 and weighstation.loc = 2 then 1 else 0 end) overloaded_m_h,
			sum(case when weighstation_data.status = 2 and weighstation.loc = 2 then percent_overload else 0 end) sum_percentage,
			sum(case when weighstation_data.status = 2 and weighstation.loc = 1 then 1 else 0 end) overloaded_m_m,
			sum(case when weighstation_data.status = 2 then fine else 0 end) fined_m,
			sum(case when weighstation_data.status = 2 AND weighstation.loc = 2 AND fine = 0 then 1 else 0 end) without_fine
			
			FROM
			weighstation_data
			LEFT OUTER JOIN weighstation ON weighstation_data.weigh_id = weighstation.id
			
			 WHERE MONTH(date) = '".date('m')."' AND YEAR(date) = '".date('Y')."'";
			$this->page_data['month_count'] = $this->db->query($sql1)->result_array(); 
			// echo "<pre>";
			// print_r($this->page_data['month_count']); exit;
			//$this->page_data['record'] = $query->result_array(); 
			$this->page_data['page_assets']['css'] 	= '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/back/css/odometer-theme-car.css"/>';
			$this->page_data['page_assets']['js'] 	= '<script src="'.base_url().'assets/back/js/odometer.js"></script>';
			
			$this->page_data['record'] = $records;
			// echo print_r($this->page_data);
			$this->load->view('back/weighstation/weighstation_data', $this->page_data);
	}

	public function weighstation_daily_report($para1 = '' , $para2 = '', $para3 =''){
		if($para1 == 'post'){
			$weighstation = $this->input->post('weighstation');
			echo $weighstation; exit;
			$date = str_replace('/','-', $this->input->post('day'));
			$first_day_of_month = strtotime(date('Y-m-01')); 
 			$last_day_of_month = strtotime(date('Y-m-t')); 
 		 
			$comp_date = strtotime($date); 
			////////  check if selected date is current month or previous month ///////
			if (($comp_date >= $first_day_of_month) && ($comp_date <= $last_day_of_month)){
				$this->page_data['weighstation'] = $this->db->select('*')->where('weigh_id',$weighstation)->where('date', $date)->order_by('id','desc')->get('weighstation_data')->result_array();
			}else{
				$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_pre_record_day($weighstation,$date);
			}
			$this->page_data['weigh'] = $weighstation;
			$this->page_data['date'] = $date;
			$this->load->view('back/weighstation/weighstation_daily_report_search', $this->page_data);
			
		}
		elseif($para1 == 'by_weighstation'){
			$weighstation = $para2;
			$this->page_data['weigh'] = $weighstation;
			$data = $this->Admin_model->get_weighstations_dates($weighstation);
			$this->page_data['dates'] = $data;
			$this->page_data['weighs'] = $this->db->get_where('weighstation',array('status' => 1))->result_array();
			$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_daily_report($weighstation);
			$this->page_data['page'] = 'weighstation daily report';
			$this->load->view('back/weighstation/weighstation_daily_report', $this->page_data);	
		}
	}

	function get_weighstation_data(){
			$weigh = $this->db->get_where('weighstation',array('status' => 1))->result_array();        	
		    //$this->page_data['weighstation'] = $weigh;//$this->db->get_where('weighstation',array('status' => 1))->result_array();
		    $records = array();
		    $counter = 0;
		    foreach($weigh as $row){
		    	$sqli = 'SELECT weigh_id,weighstation_data.date,
		    	COUNT(ticket_no) AS total_vehicles,
		    	sum(case when status = 2 then 1 else 0 end) overloaded,
			    sum(case when status = 2 then fine else 0 end) fined
				FROM
			    weighstation_data
			    WHERE weighstation_data.date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = '.$row["id"].')
			    AND weigh_id = '.$row["id"];
			    $datas =  $this->db->query($sqli)->result_array();
			    $records[$counter]['id'] = $row['id'];
			    $records[$counter]['name'] = $row['name'];
			    $records[$counter]['total_vehicles'] = $datas[0]['total_vehicles'];
			    if($datas[0]['overloaded']){
			    	$records[$counter]['overloaded'] = $datas[0]['overloaded'];
			    }else{
			    	$records[$counter]['overloaded'] = 0;
			    }
			    if($datas[0]['fined']){
			    	$records[$counter]['fined'] = $datas[0]['fined'];
			    }else{
			    	$records[$counter]['fined'] = 0;
			    }
			    if($datas[0]['date']){
			    	$records[$counter]['date'] = date('F j, Y', strtotime( $datas[0]['date']));
			    }else{
			    	$records[$counter]['date'] = date('F j, Y');
			    }

			    $records[$counter]['last_updated'] = @date('F j, Y, g:i a', $row['last_updated']);
				$records[$counter]['con_status'] = $row['con_status'];
			    $counter++;
			    

		    }

			////////////////////////


			$sql1 = "SELECT 
			DATE_FORMAT(date, '%M, %Y') as date,
		    COUNT(ticket_no) AS total_vehicles_m,
		    sum(case when weighstation.loc = 1 then 1 else 0 end) total_vehicles_m_m,
		    sum(case when weighstation.loc = 2 then 1 else 0 end) total_vehicles_m_h,
		    sum(case when weighstation_data.status = 2 and weighstation.loc = 2 then 1 else 0 end) overloaded_m_h,
		    sum(case when weighstation_data.status = 2 and weighstation.loc = 2 then percent_overload else 0 end) sum_percentage,
		    sum(case when weighstation_data.status = 2 and weighstation.loc = 1 then 1 else 0 end) overloaded_m_m,
		    sum(case when weighstation_data.status = 2 then fine else 0 end) fined_m,
			sum(case when weighstation_data.status = 2 AND weighstation.loc = 2 AND fine = 0 then 1 else 0 end) without_fine
			
			FROM
		    weighstation_data
		    LEFT OUTER JOIN weighstation ON weighstation_data.weigh_id = weighstation.id
			
		     WHERE MONTH(date) = '".date('m')."' AND YEAR(date) = '".date('Y')."'";
			$monthly = $this->db->query($sql1)->result_array(); 
			
    		    echo json_encode(array('records' => $records,'monthly' => $monthly)); 

	}
	public function daily_weighstation_pdf($para1 = '', $para2 = ''){
		//$this->page_data['weighstation'] = $this->db->select('*')->where('weigh_id',$para1)->where('date', $para2)->order_by('id','desc')->get('weighstation_data')->result_array();
		///////////////////////////
		    $weighstation = $para1;
			$date = $para2;
			$first_day_of_month = strtotime(date('Y-m-01')); 
 			$last_day_of_month = strtotime(date('Y-m-t')); 
			$comp_date = strtotime($date); 

			////////  check if selected date is current month or previous month ///////
			if (($comp_date >= $first_day_of_month) && ($comp_date <= $last_day_of_month)){
				$this->page_data['weighstation'] = $this->db->select('*')->where('weigh_id',$weighstation)->where('date', $para2)->order_by('id','desc')->get('weighstation_data')->result_array();
			}else{

				$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_pre_record_day($weighstation,$date);
			}
			
		////////////////////////////////	
		$report  = $this->load->view('back/weighstation_data_pdf', $this->page_data, TRUE);
		$this->load->library("Pdf");
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('NHA Weigh Station Report');
        $pdf->SetTitle('NHA Daily Weigh Station Report');
        $pdf->SetSubject('Weighststion Daily Report');
        $pdf->SetKeywords('Weigh Report, PDF');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(5, 0, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 12, '', true);
        $pdf->AddPage('P', 'A4');

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->writeHTMLCell(0, 0, '', '', $report, 0, 1, 0, true, '', true);
         
         $pdf->Output('Weigh Station Report.pdf','I');
	}
	public function weighstation_monthly_report($para1 = '' , $para2 = '', $para3 =''){
		if($para1 == 'post'){
			$weighstation = $this->input->post('weighstation');
			$date = $this->input->post('day');
			$this->page_data['weighstation'] = $this->Admin_model->search_weighstation_monthly_report($weighstation,$date);
			$this->page_data['weigh'] = $weighstation;
			$this->page_data['date'] = $date;
			$this->load->view('back/weighstation_monthly_report_search', $this->page_data);
		}elseif($para1 == 'by_weighstation'){
			$weighstation = $para2;
			$this->page_data['weigh'] = $weighstation;
			$data = $this->Admin_model->get_weighstations_months($weighstation);
			$this->page_data['dates'] = $data;
			$this->page_data['weighs'] = $this->db->get_where('weighstation',array('status' => 1))->result_array();
			$this->page_data['weighstation'] = $this->Admin_model->get_weighstation_monthly_report($weighstation);
			$this->page_data['page'] = 'weighstation daily report';
			$this->load->view('back/weighstation_monthly_report', $this->page_data);
		}
	}
	
	public function monthly_weighstation_pdf($para1 = '', $para2 = ''){
		$weighstation = $para1;
		$date = $para2;
		$this->page_data['weigh'] = $weighstation;
		$d = explode('-', $para2);
		$newdate = implode('/', array(@$d[1],@$d[0]));
		$this->page_data['weighstation'] = $this->Admin_model->search_weighstation_monthly_report($weighstation,$newdate);
		$report  = $this->load->view('back/weighstation_monthly_pdf', $this->page_data, TRUE);
		$this->load->library("Pdf");
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('NHA Monthly Weighstation Report');
        $pdf->SetTitle('NHA Monthly Weighstation Report');
        $pdf->SetSubject('MWR');
        $pdf->SetKeywords('MWR, PDF');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(5, 0, 5);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 12, '', true);
        $pdf->AddPage('P', 'A4');
		$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->writeHTMLCell(0, 0, '', '', $report, 0, 1, 0, true, '', true);
        $pdf->Output('Weigh Station Monthly Report.pdf','I');
	}
	public function weighstation_dashboard($para1 = '' , $para2 = '', $para3 =''){
		if(!$this->session->userdata('adminid')){
			
			return redirect('admin/login');
	
		}
		
			$this->page_data['page'] = 'weighstation daily report';
			$weigh = $this->db->get_where('weighstation',array('status' => 1))->result_array();        	
			$this->page_data['weighstation'] = $weigh;//$this->db->get_where('weighstation',array('status' => 1))->result_array();
			
			$records = array();
			$counter = 0;
			foreach($weigh as $row){
				$sqli = 'SELECT weigh_id,date,
				COUNT(ticket_no) AS total_vehicles,
				sum(case when status = 2 then 1 else 0 end) overloaded,
				sum(case when status = 2 then fine else 0 end) fined
				FROM
				weighstation_data
				WHERE date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = '.$row["id"].')
				AND weigh_id = '.$row["id"];
				$datas =  $this->db->query($sqli)->result_array();
				//echo "<pre>";
				//print_r($datas); exit;
				$records[$counter]['id'] = $row['id'];
				$records[$counter]['name'] = $row['name'];
				$records[$counter]['total_vehicles'] = $datas[0]['total_vehicles'];
				if($datas[0]['overloaded']){
					$records[$counter]['overloaded'] = $datas[0]['overloaded'];
				}else{
					$records[$counter]['overloaded'] = 0;
				}
				if($datas[0]['fined']){
					$records[$counter]['fined'] = $datas[0]['fined'];
				}else{
					$records[$counter]['fined'] = 0;
				}
				if($datas[0]['date']){
					$records[$counter]['date'] = $datas[0]['date'];
				}else{
					$records[$counter]['date'] = date('Y-m-d');
				}
				//$records[$counter]['last_updated'] = $row['last_updated'];
				$records[$counter]['last_updated'] = $row['last_updated'];
				$records[$counter]['con_status'] = $row['con_status'];
				$counter++;
				
	
			}
			// echo "<pre>";
			// print_r($records); exit;
		 //    $sql = 'SELECT weighstation.id ,weighstation.con_status as con_status, weighstation.name,
		 //    weighstation_data.weigh_id,
			// weighstation.last_updated,
		 //    weighstation_data.date,
		 //    COUNT(weighstation_data.ticket_no) AS total_vehicles,
		 //    sum(case when weighstation_data.status = 2 then 1 else 0 end) overloaded,
		 //    sum(case when weighstation_data.status = 2 then fine else 0 end) fined
			// FROM
		 //    weighstation
		 //    LEFT OUTER JOIN weighstation_data ON weighstation.id = weighstation_data.weigh_id
			// WHERE weighstation_data.date = (SELECT MAX(date) FROM weighstation_data WHERE weigh_id = weighstation.id)
			// AND weighstation.status = 1
			// GROUP BY
		 //    weighstation.id';
			// $query= $this->db->query($sql);
			 $sql1 = "SELECT 
			DATE_FORMAT(weighstation_data.date, '%M, %Y') as date,
			COUNT(ticket_no) AS total_vehicles_m,
			sum(case when weighstation.loc = 1 then 1 else 0 end) total_vehicles_m_m,
			sum(case when weighstation.loc = 2 then 1 else 0 end) total_vehicles_m_h,
			sum(case when weighstation_data.status = 2 and weighstation.loc = 2 then 1 else 0 end) overloaded_m_h,
			sum(case when weighstation_data.status = 2 and weighstation.loc = 2 then percent_overload else 0 end) sum_percentage,
			sum(case when weighstation_data.status = 2 and weighstation.loc = 1 then 1 else 0 end) overloaded_m_m,
			sum(case when weighstation_data.status = 2 then fine else 0 end) fined_m,
			sum(case when weighstation_data.status = 2 AND weighstation.loc = 2 AND fine = 0 then 1 else 0 end) without_fine
			
			FROM
			weighstation_data
			LEFT OUTER JOIN weighstation ON weighstation_data.weigh_id = weighstation.id
			
			 WHERE MONTH(date) = '".date('m')."' AND YEAR(date) = '".date('Y')."'";
			$this->page_data['month_count'] = $this->db->query($sql1)->result_array(); 
			// echo "<pre>";
			// print_r($this->page_data['month_count']); exit;
			//$this->page_data['record'] = $query->result_array(); 
			$this->page_data['page_assets']['css'] 	= '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/back/css/odometer-theme-car.css"/>';
			$this->page_data['page_assets']['js'] 	= '<script src="'.base_url().'assets/back/js/odometer.js"></script>';
			
			$this->page_data['record'] = $records;
			// echo print_r($this->page_data);
			$this->load->view('back/weighstation_data', $this->page_data);
		
	}
}
