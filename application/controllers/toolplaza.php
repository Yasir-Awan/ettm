<?php
defined('BASEPATH') OR exit('NO DIRECT SCRIPT ALLOWED');
class Toolplaza extends CI_Controller{

	public function __construct(){
		parent ::__construct();
		if(!$this->session->userdata('supervisor_id'))
		{
			redirect(base_url().'home');
		}
		$this->load->model('Tollplaza_model');
		$this->load->model('General');
		$this->load->model('s_model');
		$this->load->model('t_model');
		$this->load->model('lane_model');
		$this->load->model('dsr_model');
		$this->page_data = array();
		$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('id' => $this->session->userdata('toolplaza')))->result_array();
	}

	///////////////////////////////////////////////////////////////
	////	/** Dashboard START  *////////////////////
	///////////////////////////////////////////////////////////////

	public function index(){
		$data = $this->Tollplaza_model->chartdata();

		$previous_year = date("Y-m-d",strtotime(@$data['chart']['month'].' -1 year'));
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
		$pre_year_data = $this->Tollplaza_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_year);
		$pre_month_data = $this->Tollplaza_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_monthDate);
		
		$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('id' => $this->session->userdata('toolplaza')))->result_array();
		$this->page_data['start_date'] = $data['start_date'];
		$this->page_data['end_date'] = $data['end_date'];
		
		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_year_chart'] = $pre_year_data['chart'];
		$this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];
		
        $this->page_data['chart'] = $data['chart'];
        $this->page_data['revenue'] = $data['revenue'];
		$this->page_data['page_name'] = 'dashboard';
		$this->load->view('front/toolplaza/dashboard', $this->page_data);
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url().'home','refresh');
	}
	public function settings($para1 = ''){
		$this->load->library('form_validation');
		if($para1 == 'update_basic_info'){
			$this->form_validation->set_rules('fname','First Name','required|trim');
			$this->form_validation->set_rules('lname','Last Name','required|trim');
			//$this->form_validation->set_rules('username','First Name','required|trim');
			$this->form_validation->set_rules('contact','Contact','required|trim');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			}else{
				$data = array();
				$data['fname'] = $this->input->post('fname');
				$data['lname'] = $this->input->post('lname');
				$data['contact'] = $this->input->post('contact');
				$this->db->where('id', $this->session->userdata('supervisor_id'));
				$this->db->update('tpsupervisor', $data);
				echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/settings'));
            }		
		}elseif($para1 == 'update_pwd'){ 
				 $config=array(
				     array(
				          'field' => 'newpwd',
				          'label' => 'New Password',
				          'rules' => 'trim|required'
				     ),
				     array(
				          'field' => 'repwd',
				          'label' => 'Confirm Password',
				          'rules' => 'trim|required|matches[newpwd]'
				     )
				 );
				  $this->form_validation->set_rules('oldpwd','Old Password','required|trim');
				  $this->form_validation->set_rules($config);
				  if($this->form_validation->run() == FALSE){
				  		echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			
				  }else{
				  		$check_old = $this->db->get_where('tpsupervisor',array('id' => $this->session->userdata('supervisor_id'), 'password' => sha1($this->input->post('oldpwd'))))->result_array();
				  		if(empty($check_old)){
				  			echo json_encode(array('response' => FALSE , 'message' => 'You have enter incorrect old password')); exit;
				  		}else{
				  			$data = array();
				  			$data['password'] = sha1($this->input->post('newpwd'));
				  			$this->db->where('id', $this->session->userdata('supervisor_id'));
							$this->db->update('tpsupervisor', $data);
							echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/settings'));
				  		}
				  }
		}else{
			$this->page_data['user'] = $this->db->get_where('tpsupervisor',array('id' => $this->session->userdata('supervisor_id')))->result_array();
			$this->page_data['page_name'] = 'settings';
			$this->load->view('front/toolplaza/settings',$this->page_data);
		}
		
	}
	
	///////////////////////////////////////////////////////////////
	////	/** Charts START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function check_tollplaza_dates($tollplaza = ''){
		$data = $this->Member_model->get_tollplaza_dates($tollplaza);
		echo json_encode($data);
	}
	public function searchforchart($para1 = ''){
		$month  = $this->input->post('formonth');
		$data = $this->Tollplaza_model->get_chartdata($month);
		
		$previous_year = date("Y-m-d",strtotime(@$data['chart']['month'].' -1 year'));
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
		$pre_year_data = $this->Tollplaza_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_year);
		$pre_month_data = $this->Tollplaza_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_monthDate);
		

		$this->page_data['chart'] = $data['chart'];
		$this->page_data['revenue'] = $data['revenue'];

		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_year_chart'] = $pre_year_data['chart'];
		$this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];

		$this->load->view('front/toolplaza/customize_chart_search', $this->page_data);	
	}
	public function chart(){

	//$sql = "select count(id) from `mtr` GROUP BY MONTH(for_month)";

	$sql1 = 'SELECT
    count(*) as month_count,
    MONTHNAME(for_month),
    YEAR(for_month)
	FROM
		mtr
	GROUP BY
		MONTH(for_month),YEAR(for_month)';

	$data =  $this->db->query($sql1)->result_array();
	echo $this->db->last_query(); exit;
	echo "<pre>";
	print_r($data); exit;


	}
	public function testchart($para1 = ''){
		$data = $this->db->select('*')->where('toolplaza',$this->session->userdata('toolplaza'))->order_by('id','desc')->limit(1)->get('mtr')->result_array();
		//echo "<pre>";
		//print_r($data); exit;
		$chart = array();
		$chart['tollplaza'] = $this->db->get_where('toolplaza',array('id' => $data[0]['toolplaza']))->row()->name;
		$chart['month'] = $data[0]['for_month'];
		$chart['class1']['data'] = $data[0]['class1'];
		$chart['class2']['data'] = $data[0]['class2'];
		$chart['class3']['data'] = $data[0]['class3'] + $data[0]['class5'] + $data[0]['class6'];
		$chart['class4']['data'] = $data[0]['class4'];
		$chart['class5']['data'] = $data[0]['class7'] + $data[0]['class8'] + $data[0]['class9'] + $data[0]['class10'];
		$chart['class1']['label'] = "Car, Jeep";
		$chart['class2']['label'] = "Wagon, Hiace";
		$chart['class3']['label'] = "Truck, Tractor & Trolly";
		$chart['class4']['label'] = "Bus, Coaster";
		$chart['class5']['label'] = "Articulated Truck";
		//echo "<pre>";
		//print_r($chart); exit;
		$this->page_data['chart'] = $chart;
		$this->load->view('front/test_map', $this->page_data);
	}
	
	///////////////////////////////////////////////////////////////
	////	/** MTR START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function specific_mtr($para1 = '', $para2 = '' ){
		if($para1 == 'list')
		{
			$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para2))->result_array();
		    // $this->db->where('alert_type',2);
			// $this->db->where('ref_id',$para2);
			// $this->db->update('notifications',array('is_read' => 1))->result_array();	
			$this->load->view('front/toolplaza/mtr_list', $this->page_data);
		}
		else
		{
			
			$this->page_data['page_name'] = 'specific_mtr';
			$this->page_data['mtr_id'] = $para1;			
			$this->load->view('front/toolplaza/specific_mtr', $this->page_data);	
		}
	}
	public function mtr($para1 = '' , $para2 = '', $para3 = ''){
		if($para1 == 'list'){
			$this->db->order_by('id','DESC');
			$this->db->where('toolplaza', $this->session->userdata('toolplaza'));
			//$this->db->where('user_id', $this->session->userdata('supervisor_id'));
			
			$this->page_data['mtr'] = $this->db->get('mtr')->result_array();
			$this->load->view('front/toolplaza/mtr_list', $this->page_data);
		}
		elseif($para1 == 'delete'){
				$this->db->where('id',$para2);
				$this->db->where('user_id',$this->session->userdata('supervisor_id'));
				$this->db->where('status !=', 1, FALSE);
				$record = $this->db->get('mtr');
				if($record->result_array()){
					$support = $this->db->get_where('supporting_document',array('mtr_id' => $para2))->result_array();
					if($support){
						foreach($support as $val){
							unlink('./uploads/supporting/'.$val['path']);
						}
						$this->db->where('mtr_id', $para2);
						$this->db->delete('supporting_document');
					}
					$file = $this->db->get_where('mtr',array('id' => $para2))->row()->file;
					unlink('./uploads/mtr/'.$file);
					$this->db->where('id', $para2);
					$this->db->delete('mtr');
				}

		}
		elseif($para1 == 'add'){
				$this->page_data['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
				$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('id' => $this->session->userdata('toolplaza')))->row()->name;
				$this->load->view('front/toolplaza/mtr_add' , $this->page_data);
		}
		elseif($para1 == 'edit'){
			$this->page_data['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('id' => $this->session->userdata('toolplaza')))->row()->name;
			$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para2))->result_array();
			if($this->page_data['mtr']){
				if($this->page_data['mtr'][0]['status'] == 1 || $this->page_data['mtr'][0]['upload_type'] != 1  || $this->page_data['mtr'][0]['user_id'] != $this->session->userdata('supervisor_id')){
					echo "<span class='text-danger'>Invalid Request</span>"; exit;
				}	
			}else{
					echo "<span class='text-danger'>Invalid Request</span>"; exit;
			}
			
			$this->load->view('front/toolplaza/mtr_edit', $this->page_data);
		}
		elseif($para1 == 'do_add'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('for_month','Valid Month And Year','required|trim');
			$this->form_validation->set_rules('omc','OMC','required|trim');
			$this->form_validation->set_rules('description','Description','required|trim');
			$this->form_validation->set_rules('notes','Notes','required|trim');
			$this->form_validation->set_rules('class1','Class 1 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class2','Class 2 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class3','Class 3 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class4','Class 4 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class5','Class 5 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class6','Class 6 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class7','Class 7 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class8','Class 8 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class9','Class 9 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class10','Class 10 Passess','required|trim|is_natural');
			if($this->input->post('add_exempt') == 1){
				$class1 = $this->input->post('class1');
						$class2 = $this->input->post('class2');
						$class3 = $this->input->post('class3');
						$class4 = $this->input->post('class4');
						$class5 = $this->input->post('class5');
						$class6 = $this->input->post('class6');
						$class7 = $this->input->post('class7');
						$class8 = $this->input->post('class8');
						$class9 = $this->input->post('class9');
						$class10 = $this->input->post('class10');
						//$this->form_validation->set_message('less_than_equal_to', '%s One of your exempt is exceeding total traffic for this class');
						$this->form_validation->set_rules("exempt1","Class 1 Exempt","required|trim|is_natural|less_than_equal_to[$class1]");
						$this->form_validation->set_rules('exempt2','Class 2 Exempt',"required|trim|is_natural|less_than_equal_to[$class2]");
						$this->form_validation->set_rules('exempt3','Class 3 Exempt',"required|trim|is_natural|less_than_equal_to[$class3]");
						$this->form_validation->set_rules('exempt4','Class 4 Exempt',"required|trim|is_natural|less_than_equal_to[$class4]");
						$this->form_validation->set_rules('exempt5','Class 5 Exempt',"required|trim|is_natural|less_than_equal_to[$class5]");
						$this->form_validation->set_rules('exempt6','Class 6 Exempt',"required|trim|is_natural|less_than_equal_to[$class6]");
						$this->form_validation->set_rules('exempt7','Class 7 Exempt',"required|trim|is_natural|less_than_equal_to[$class7]");
						$this->form_validation->set_rules('exempt8','Class 8 Exempt',"required|trim|is_natural|less_than_equal_to[$class8]");
						$this->form_validation->set_rules('exempt9','Class 9 Exempt',"required|trim|is_natural|less_than_equal_to[$class9]");
						$this->form_validation->set_rules('exempt10','Class 10 Exempt',"required|trim|is_natural|less_than_equal_to[$class10]");
			}
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			}else{
				foreach($_FILES['supporting_file']['name'] as $key => $value){
							
							if(!empty($value)){
								if(!empty($_POST['suppporting_document_name'][$key])){
									$_FILES['images[]']['name']		= $_FILES['supporting_file']['name'][$key];
            						$_FILES['images[]']['type']		= $_FILES['supporting_file']['type'][$key];
            						$_FILES['images[]']['tmp_name']	= $_FILES['supporting_file']['tmp_name'][$key];
            						$_FILES['images[]']['error']	= $_FILES['supporting_file']['error'][$key];
            						$_FILES['images[]']['size']		= $_FILES['supporting_file']['size'][$key];

									$config['upload_path'] = './uploads/temp';
									$config['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
									$config['overwrite'] = TRUE;
									$this->load->library('upload', $config);
									if ( ! $this->upload->do_upload('images[]')){
										echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
									}
									

								}else{
									echo json_encode(array('response' => FALSE , 'message' => "One of your supporting document name is missing")); exit;
								
								}
							}
					}


						if($this->input->post('mtr_type') == 1){
							$for_month		= 	$this->input->post('for_month');
							$format = str_replace('/','-', $for_month)."-01";
							$check_month = $this->db->get_where('mtr',array('for_month' => $format, 'toolplaza' => $this->session->userdata('toolplaza')))->result_array();
							if($check_month){
								echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;			
							}
						}else{
							$user_id 		= 	$this->session->userdata('supervisor_id');
							$toolplaza  	= 	$this->session->userdata('toolplaza');
							$for_month		= 	$this->input->post('for_month');
							$format = str_replace('/','-', $for_month)."-01";
							//$mtr = $this->db->get_where('mtr',array('toolplaza' => $toolplaza ,'user_id' => $user_id, 'for_month' => $format, 'type' => 2))->result_array();
							$this->db->where('toolplaza',$toolplaza);
							$this->db->where('for_month',$format);
							$this->db->where('type',2);
							$this->db->order_by("id", "desc");
							$this->db->limit(1);
							$mtr = $this->db->get('mtr')->result_array();
							if($mtr){
								$pass_date = strtotime($mtr[0]['for_month']);
								$total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));
								if($mtr[0]['end_date'] >= $total_days){
									echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;
								}	
							}
						}
				if (empty($_FILES['mtr_file']['name'])) {
					echo json_encode(array('response' => FALSE , 'message' => 'Please upload a valid file')); exit;	
				}

				$config['upload_path'] = './uploads/temp';
				$config['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
				$config['overwrite'] = TRUE;
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('mtr_file')){
					echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
				}


				$data['user_id'] 		= 	$this->session->userdata('supervisor_id');
				$data['toolplaza']  	= 	$this->session->userdata('toolplaza');
				$data['omc']  			= 	$this->input->post('omc');
				$data['description'] 	= 	$this->input->post('description');
				$data['notes'] 			= 	$this->input->post('notes');
				$data['class1'] 		= 	$this->input->post('class1');
				$data['class2'] 		= 	$this->input->post('class2');
				$data['class3'] 		= 	$this->input->post('class3');
				$data['class4'] 		= 	$this->input->post('class4');
				$data['class5'] 		= 	$this->input->post('class5');
				$data['class6'] 		= 	$this->input->post('class6');
				$data['class7'] 		= 	$this->input->post('class7');
				$data['class8'] 		= 	$this->input->post('class8');
				$data['class9'] 		= 	$this->input->post('class9');
				$data['class10'] 		= 	$this->input->post('class10');
				$data['upload_type']  	= 	1;
				$data['type'] 			= 	$this->input->post('mtr_type');
				if($this->input->post('mtr_type') == 2){
					$data['start_date'] 	= 	explode('/', $this->input->post('start_date'))[0];
					$data['end_date'] 		= 	explode('/', $this->input->post('end_date'))[0];
					
				}else{
					$pass_date 				= 	str_replace('/','-',$this->input->post('for_month').'-01');					
					$data['start_date'] 	= 	01;
		
					$data['end_date'] 		=  cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($pass_date)), date('Y', strtotime($pass_date)));;
					
					

				}
				$data['for_month']  	=   str_replace('/','-',$this->input->post('for_month').'-01');
				$data['total']      	= 	$this->input->post('class1') + $this->input->post('class2') + $this->input->post('class3') + $this->input->post('class4') + $this->input->post('class5') + $this->input->post('class6') + $this->input->post('class7') + $this->input->post('class8') + $this->input->post('class9') + $this->input->post('class10');
				$data['adddate']		=	time();
				if (empty($data['start_date']) || empty($data['end_date'])) {
   					echo json_encode(array('response' => FALSE , 'message' => "An Error Occoured Please Refresh Your Page And try Again")); exit;
				}
				$this->db->insert('mtr', $data);
				$insert_id = $this->db->insert_id();
				if($this->input->post('add_exempt') == 1){
						$post_exempt = array();
						$post_exempt['description'] = $this->input->post('excempt_desc');
						$post_exempt['notes'] = $this->input->post('exempt_notes');
						for($i = 1; $i<=10; $i++){
							$post_exempt[$i] = $this->input->post('exempt'.$i);
						}
						$this->General->add_exempt($insert_id, $post_exempt);
				}
				$filename = $_FILES["mtr_file"]["name"];

				$ext = @end((explode(".", $filename)));
				$file_new_name = 'mtr'.$insert_id.'_'.str_replace('/', '-',$this->input->post('for_month')).'.'.$ext;
				$config1['upload_path'] = './uploads/mtr';
				$config1['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
				$config1['overwrite'] = TRUE;
				$config1['file_name']	=	$file_new_name;
				//$this->load->library('upload', $config);
				 $this->upload->initialize($config1);
				if ( ! $this->upload->do_upload('mtr_file'))
		        {
		           echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
		        }
		        else
		        {

		        	$update['file'] = $file_new_name;
		        	$this->db->where('id', $insert_id);
		        	$this->db->update('mtr',$update);
		        	foreach($_FILES['supporting_file']['name'] as $key => $value){
							if(!empty($value)){
								if(!empty($_POST['suppporting_document_name'][$key])){
									$_FILES['images[]']['name']		= $_FILES['supporting_file']['name'][$key];
            						$_FILES['images[]']['type']		= $_FILES['supporting_file']['type'][$key];
            						$_FILES['images[]']['tmp_name']	= $_FILES['supporting_file']['tmp_name'][$key];
            						$_FILES['images[]']['error']	= $_FILES['supporting_file']['error'][$key];
            						$_FILES['images[]']['size']		= $_FILES['supporting_file']['size'][$key];
										$s_data = array();
										$s_data['name'] = $_POST['suppporting_document_name'][$key];
										$s_data['mtr_id'] = $insert_id; 
										$this->db->insert('supporting_document', $s_data);
										$supporting_id = $this->db->insert_id();
										//$supporting_data = array();
										$s_filename = $_FILES["supporting_file"]["name"][$key];

										$ext = @end((explode(".", $s_filename)));
										$s_file_new_name = 'supporting_document'.$insert_id.'_'.$supporting_id.'.'.$ext;
										$configs['upload_path'] = './uploads/supporting';
										$configs['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
										$configs['overwrite'] = TRUE;
										$configs['file_name']	=	$s_file_new_name;
										//$this->load->library('upload', $config);
										 $this->upload->initialize($configs);
										if ( ! $this->upload->do_upload('images[]'))
								        {
								           echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
								        }else{
								        	$s_data = array();
								        	$s_data['path'] = $s_file_new_name;
								        	$this->db->where('id', $supporting_id);
								        	$this->db->update('supporting_document', $s_data);
								        }
									

								}else{
									echo json_encode(array('response' => FALSE , 'message' => "One of your supporting document name is missing")); exit;
								
								}
							}
					} 
		         	$this->load->helper('file');
		         	delete_files('./uploads/temp');

		         	echo json_encode(array('response' => TRUE , 'message' => 'Added Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/mtr'));
		        }

			}
		}
		elseif($para1 == 'do_update'){
			//$check = $this->db->get_where('mtr',array('id' => $para2 , 'user_id' => $this->session->userdata('supervisor_id')))->result_array();
			$this->db->where('id',$para2);
			$this->db->where('user_id',$this->session->userdata('supervisor_id'));
			$this->db->where('upload_type', 1);
			$this->db->where('status !=', 1);
			$check = $this->db->get('mtr')->result_array();
			if($check){
					$this->load->library('form_validation');
					$this->form_validation->set_rules('for_month','Valid Month And Year','required|trim');
					$this->form_validation->set_rules('description','Description','required|trim');
					$this->form_validation->set_rules('notes','Notes','required|trim');
					$this->form_validation->set_rules('omc','OMC','required|trim');
					$this->form_validation->set_rules('class1','Class 1 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class2','Class 2 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class3','Class 3 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class4','Class 4 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class5','Class 5 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class6','Class 6 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class7','Class 7 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class8','Class 8 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class9','Class 9 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class10','Class 10 Passess','required|trim|is_natural');
					if($this->input->post('add_exempt') == 1){
						$class1 = $this->input->post('class1');
						$class2 = $this->input->post('class2');
						$class3 = $this->input->post('class3');
						$class4 = $this->input->post('class4');
						$class5 = $this->input->post('class5');
						$class6 = $this->input->post('class6');
						$class7 = $this->input->post('class7');
						$class8 = $this->input->post('class8');
						$class9 = $this->input->post('class9');
						$class10 = $this->input->post('class10');
						//$this->form_validation->set_message('less_than_equal_to', '%s One of your exempt is exceeding total traffic for this class');
						$this->form_validation->set_rules("exempt1","Class 1 Exempt","required|trim|is_natural|less_than_equal_to[$class1]");
						$this->form_validation->set_rules('exempt2','Class 2 Exempt',"required|trim|is_natural|less_than_equal_to[$class2]");
						$this->form_validation->set_rules('exempt3','Class 3 Exempt',"required|trim|is_natural|less_than_equal_to[$class3]");
						$this->form_validation->set_rules('exempt4','Class 4 Exempt',"required|trim|is_natural|less_than_equal_to[$class4]");
						$this->form_validation->set_rules('exempt5','Class 5 Exempt',"required|trim|is_natural|less_than_equal_to[$class5]");
						$this->form_validation->set_rules('exempt6','Class 6 Exempt',"required|trim|is_natural|less_than_equal_to[$class6]");
						$this->form_validation->set_rules('exempt7','Class 7 Exempt',"required|trim|is_natural|less_than_equal_to[$class7]");
						$this->form_validation->set_rules('exempt8','Class 8 Exempt',"required|trim|is_natural|less_than_equal_to[$class8]");
						$this->form_validation->set_rules('exempt9','Class 9 Exempt',"required|trim|is_natural|less_than_equal_to[$class9]");
						$this->form_validation->set_rules('exempt10','Class 10 Exempt',"required|trim|is_natural|less_than_equal_to[$class10]");
			}
					if($this->form_validation->run() == FALSE){
						echo json_encode(array('response' => FALSE , 'message' => validation_errors()));
					}
					else{

						foreach($_FILES['supporting_file']['name'] as $key => $value){
							
							if(!empty($value)){
								if(!empty($_POST['suppporting_document_name'][$key])){
									$_FILES['images[]']['name']		= $_FILES['supporting_file']['name'][$key];
            						$_FILES['images[]']['type']		= $_FILES['supporting_file']['type'][$key];
            						$_FILES['images[]']['tmp_name']	= $_FILES['supporting_file']['tmp_name'][$key];
            						$_FILES['images[]']['error']	= $_FILES['supporting_file']['error'][$key];
            						$_FILES['images[]']['size']		= $_FILES['supporting_file']['size'][$key];

									$config['upload_path'] = './uploads/temp';
									$config['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
									$config['overwrite'] = TRUE;
									$this->load->library('upload', $config);
									if ( ! $this->upload->do_upload('images[]')){
										echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
									}
									

								}else{
									echo json_encode(array('response' => FALSE , 'message' => "One of your supporting document name is missing")); exit;
								
								}
							}
					}
						if($this->input->post('mtr_type') == 1){
							$for_month		= 	$this->input->post('for_month');
							$format = str_replace('/','-', $for_month)."-01";
							$this->db->where('for_month',$format);
							$this->db->where('toolplaza',$this->session->userdata('toolplaza'));
							$this->db->where('id !=',$para2);
							$check_month = $this->db->get('mtr')->result_array();
							//echo $this->db->last_query(); exit;
							//$check_month = $this->db->get_where('mtr',array('for_month' => $format, 'toolplaza' => $this->session->userdata('toolplaza')))->result_array();
							if($check_month){
								echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;			
							}
						}else{
							$user_id 		= 	$this->session->userdata('supervisor_id');
							$toolplaza  	= 	$this->session->userdata('toolplaza');
							$for_month		= 	$this->input->post('for_month');
							$format = str_replace('/','-', $for_month)."-01";
							//$mtr = $this->db->get_where('mtr',array('toolplaza' => $toolplaza ,'user_id' => $user_id, 'for_month' => $format, 'type' => 2))->result_array();
							$this->db->where('toolplaza',$toolplaza);
							$this->db->where('for_month',$format);
							$this->db->where('type',2);
							$this->db->where('id !=',$para2);
							$this->db->order_by("id", "desc");
							$this->db->limit(1);
							$mtr = $this->db->get('mtr')->result_array();
							if($mtr){
								$pass_date = strtotime($mtr[0]['for_month']);
								$total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));
								if($mtr[0]['end_date'] >= $total_days){
									echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;
								}	
							}
						}
						
						if (!empty($_FILES['mtr_file']['name'])) {
								$config['upload_path'] = './uploads/temp';
								$config['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
								$config['overwrite'] = TRUE;
								$this->load->library('upload', $config);
								if ( ! $this->upload->do_upload('mtr_file')){
									echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
								}
						}

						$data['user_id'] 		= 	$this->session->userdata('supervisor_id');
						$data['toolplaza']  	= 	$this->session->userdata('toolplaza');
						$data['omc']  			= 	$this->input->post('omc');
						$data['description'] 	= 	$this->input->post('description');
						$data['notes'] 			= 	$this->input->post('notes');
						$data['class1'] 		= 	$this->input->post('class1');
						$data['class2'] 		= 	$this->input->post('class2');
						$data['class3'] 		= 	$this->input->post('class3');
						$data['class4'] 		= 	$this->input->post('class4');
						$data['class5'] 		= 	$this->input->post('class5');
						$data['class6'] 		= 	$this->input->post('class6');
						$data['class7'] 		= 	$this->input->post('class7');
						$data['class8'] 		= 	$this->input->post('class8');
						$data['class9'] 		= 	$this->input->post('class9');
						$data['class10'] 		= 	$this->input->post('class10');
						$data['type'] 			= 	$this->input->post('mtr_type');
						if($this->input->post('mtr_type') == 2){
								$data['start_date'] 	= 	explode('/', $this->input->post('start_date'))[0];
								$data['end_date'] 		= 	explode('/', $this->input->post('end_date'))[0];
						}else{
							$pass_date 				= 	str_replace('/','-',$this->input->post('for_month').'-01');					
							$data['start_date'] 	= 	01;
							$data['end_date'] 		=  cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($pass_date)), date('Y', strtotime($pass_date)));;
						}
						$data['for_month']  	= 	str_replace('/','-',$this->input->post('for_month').'-01');
						$data['total']      	= 	$this->input->post('class1') + $this->input->post('class2') + $this->input->post('class3') + $this->input->post('class4') + $this->input->post('class5') + $this->input->post('class6') + $this->input->post('class7') + $this->input->post('class8') + $this->input->post('class9') + $this->input->post('class10');
						$data['adddate']		=	time();
						$data['status']			=   0;
						if (empty($data['start_date']) || empty($data['end_date'])) {
   								echo json_encode(array('response' => FALSE , 'message' => "An Error Occoured Please Refresh Your Page And try Again")); exit;
						}
						/** some changes by yasir for notifications START*/
						$this->db->where('id',$this->session->userdata('supervisor_id'));
						$supervisor = $this->db->get('tpsupervisor')->result_array();
						$tollplaza =$this->db->get_where('toolplaza',array('id'=>$supervisor[0]['tollplaza'],'status'=>1))->result_array();
						$notificatoin_msg =  $tollplaza[0]['name']." ". date("F, Y",strtotime($check[0]['for_month'])) .' mtr Updated.';
							$data11 = array(
							'user_id' => $this->session->userdata('supervisor_id'),
							'user_type' => 1,
							'for_user_id' =>  1,
							'for_user_type' => 3,
							'ref_id' 	=> $para2,
							'alert_type'  => 2,
							'date' => date("Y-m-d H:i:s"),
							'is_read' => 0,
							'notification_msg' => $notificatoin_msg                
							 );

							$this->db->insert('notifications', $data11); 
					/** some changes by yasir for notifications END*/
						$this->db->where('id', $para2);
						$this->db->update('mtr', $data);
						

						if($this->input->post('add_exempt') == 1){
							$post_exempt = array();
							$post_exempt['description'] = $this->input->post('excempt_desc');
							$post_exempt['notes'] = $this->input->post('exempt_notes');
							for($i = 1; $i<=10; $i++){
								$post_exempt[$i] = $this->input->post('exempt'.$i);
							}
							$this->General->add_exempt($para2, $post_exempt);
						}else{
							$this->General->checkexempt_exist_delete($para2);
						}
						foreach($_FILES['supporting_file']['name'] as $key => $value){
							if(!empty($value)){
								if(!empty($_POST['suppporting_document_name'][$key])){
									$_FILES['images[]']['name']		= $_FILES['supporting_file']['name'][$key];
            						$_FILES['images[]']['type']		= $_FILES['supporting_file']['type'][$key];
            						$_FILES['images[]']['tmp_name']	= $_FILES['supporting_file']['tmp_name'][$key];
            						$_FILES['images[]']['error']	= $_FILES['supporting_file']['error'][$key];
            						$_FILES['images[]']['size']		= $_FILES['supporting_file']['size'][$key];
										$s_data = array();
										$s_data['name'] = $_POST['suppporting_document_name'][$key];
										$s_data['mtr_id'] = $para2; 
										$this->db->insert('supporting_document', $s_data);
										$supporting_id = $this->db->insert_id();
										//$supporting_data = array();
										$s_filename = $_FILES["supporting_file"]["name"][$key];

										$ext = @end((explode(".", $s_filename)));
										$s_file_new_name = 'supporting_document'.$para2.'_'.$supporting_id.'.'.$ext;
										$configs['upload_path'] = './uploads/supporting';
										$configs['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
										$configs['overwrite'] = TRUE;
										$configs['file_name']	=	$s_file_new_name;
										//$this->load->library('upload', $config);
										 $this->upload->initialize($configs);
										if ( ! $this->upload->do_upload('images[]'))
								        {
								           echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
								        }else{
								        	$s_data = array();
								        	$s_data['path'] = $s_file_new_name;
								        	$this->db->where('id', $supporting_id);
								        	$this->db->update('supporting_document', $s_data);
								        	$this->load->helper('file');
				         					delete_files('./uploads/temp');
								        }
									

								}else{
									echo json_encode(array('response' => FALSE , 'message' => "One of your supporting document name is missing")); exit;
								
								}
							}
					}
						if (!empty($_FILES['mtr_file']['name'])) {
						$filename = $_FILES["mtr_file"]["name"];

						$ext = @end((explode(".", $filename)));
						$file_new_name = 'mtr'.$para2.'_'.str_replace('/', '-',$this->input->post('for_month')).'.'.$ext;
						$config1['upload_path'] = './uploads/mtr';
						$config1['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
						$config1['overwrite'] = TRUE;
						$config1['file_name']	=	$file_new_name;
						//$this->load->library('upload', $config);
						 $this->upload->initialize($config1);
						if ( ! $this->upload->do_upload('mtr_file'))
				        {
				           echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
				        }
				        else
				        {
				        	$update['file'] = $file_new_name;
				        	$this->db->where('id', $para2);
				        	$this->db->update('mtr',$update);

				         	$this->load->helper('file');
				         	delete_files('./uploads/temp');
				         	//echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/mtr'));
				        }
				    }
				    echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/mtr'));
				} // else end


			}else{
				echo json_encode(array('response' => FALSE , 'message' => "Invalid Request")); exit;
			}
			
		}
		elseif($para1 == 'view'){
			$this->load->view('front/toolplaza/invoice', $this->page_data);

		}
		elseif($para1 == 'view_reason'){
			$reason = $this->db->get_where('mtr',array('id' => $para2))->result_array();
			if($reason[0]['status'] == 2){
				echo "<span class='text-info'>".$reason[0]['reason']."</span>";
			}else{
				echo "<span class='text-danger'>Invalid Request</span>";
			}
			
		}
		else{
			
			$this->page_data['page_name'] = 'mtr';
			$this->load->view('front/toolplaza/mtr', $this->page_data);	
		}
		
	}
	public function monthly_traffic_report($para1 = ''){
		$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para1 ))->result_array();
		$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];

		$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		$this->load->view('front/toolplaza/invoice', $this->page_data);
}
	public function generate_pdf($para1 = ''){
		$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para1 ))->result_array();
		$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];

		//$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza)";
		$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		$pdfdata = $this->load->view('front/toolplaza/invoice_pdf', $this->page_data, TRUE);

		$this->load->library("Pdf");
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('NHA MTR');
        $pdf->SetTitle('NHA Monthly Traffic Report');
        $pdf->SetSubject('MTR');
        $pdf->SetKeywords('MTR, PDF');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 16, '', true);
        $pdf->AddPage('L', 'A2');

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->writeHTMLCell(0, 0, '', '', $pdfdata, 0, 1, 0, true, '', true);
         $pdf->Output('mtr.pdf','I');
        //$pdf->Output(SERVER_RELATIVE_PATH . '/uploads/invoices/invoice' . $invoice_name . '.pdf', 'F');

	}		
	public function view_supporting($para1 = ''){
		$this->page_data['support'] = $this->db->get_where('supporting_document',array('mtr_id' => $para1))->result_array();
		$this->load->view('front/toolplaza/suppporting_list', $this->page_data);

	}
	public function delete_suppporting($para1 = '', $para2 = ''){
			$this->db->where('id',$para2);
			$this->db->where('mtr_id',$para1);
			$record = $this->db->get('supporting_document')->result_array();
			if($record){
				$file = $record[0]['path'];
				unlink('./uploads/supporting/'.$file);
				$this->db->where('id', $para2);
				$this->db->delete('supporting_document');
			}
			$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para1))->result_array();
			$this->page_data['support'] = $this->db->get_where('supporting_document',array('mtr_id' => $para1))->result_array();
			 $this->load->view('front/toolplaza/supporting_document', $this->page_data);

	}
	public function check_start_date(){
		
		$toolplaza  	= 	$this->session->userdata('toolplaza');
		$for_month		= 	$this->input->post('formonth');
		$format = str_replace('/','-', $for_month)."-01";
		$mtr_id = $this->input->post('mtr_id');
		//$mtr = $this->db->get_where('mtr',array('toolplaza' => $toolplaza ,'user_id' => $user_id, 'for_month' => $format, 'type' => 2))->result_array();
		$this->db->where('toolplaza',$toolplaza);
		if($mtr_id){
			$this->db->where('id !=',$mtr_id);	
		}
		
		$this->db->where('for_month',$format);
		//$this->db->where('type',2);
		$this->db->order_by("id", "desc");
		$this->db->limit(1);
		$mtr = $this->db->get('mtr')->result_array();
		if($mtr){
			$pass_date = strtotime($mtr[0]['for_month']);
			$total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));
			if($mtr[0]['end_date'] < $total_days){
				echo $mtr[0]['for_month']."_".($mtr[0]['end_date']+1);
			}else{
				echo "completed"; exit;
			}	
		}else{
			echo $format.'_01';
		}
		
	}
	
	// public function check_edited_start_date(){

	// 	$toolplaza  	= 	$this->session->userdata('toolplaza');
	// 	$for_month		= 	$this->input->post('formonth');
	// 	$format = str_replace('/','-', $for_month)."-01";
	// 	$mtr_id = $this->input->post('mtr_id');
	// 	//$mtr = $this->db->get_where('mtr',array('toolplaza' => $toolplaza ,'user_id' => $user_id, 'for_month' => $format, 'type' => 2))->result_array();
	// 	$this->db->where('toolplaza',$toolplaza);
	// 	//$this->db->where('user_id',$user_id);
	// 	$this->db->where('for_month',$format);
	// 	$this->db->where('id !=',$mtr_id);
	// 	$this->db->order_by("id", "desc");
	// 	$this->db->limit(1);
	// 	$mtr = $this->db->get('mtr')->result_array();
	// 	if($mtr){
	// 		$pass_date = strtotime($mtr[0]['for_month']);
	// 		$total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));
	// 		if($mtr[0]['end_date'] < $total_days){
	// 			echo $mtr[0]['for_month']."_".($mtr[0]['end_date']+1);
	// 		}else{
	// 			echo "completed"; exit;
	// 		}	
	// 	}else{
	// 		echo $format.'_01';
	// 	}

	// }

	///////////////////////////////////////////////////////////////
	////	/** DTR START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function dtr($para1 = '' , $para2 = '', $para3 = ''){
		
		if($para1 == 'list'){
			$this->db->order_by('id','DESC');
			$this->db->where('toolplaza', $this->session->userdata('toolplaza'));
			//$this->db->where('user_id', $this->session->userdata('supervisor_id'));
			
			$this->page_data['dtr'] = $this->db->get('dtr')->result_array();
			$this->load->view('front/toolplaza/dtr_list', $this->page_data);
		}
		elseif($para1 == 'delete'){
			$this->db->where('id',$para2);
			$this->db->where('user_id',$this->session->userdata('supervisor_id'));
			$this->db->where('status !=', 1, FALSE);
			$record = $this->db->get('dtr');
			if($record->result_array()){
				$support = $this->db->get_where('dtr_supporting_document',array('dtr_id' => $para2))->result_array();
				if($support){
					foreach($support as $val){
						unlink('./uploads/supporting/'.$val['path']);
					}
					$this->db->where('dtr_id', $para2);
					$this->db->delete('dtr_supporting_document');
				}
				$file = $this->db->get_where('dtr',array('id' => $para2))->row()->file;
				unlink('./uploads/dtr/'.$file);
				$this->db->where('id', $para2);
				$this->db->delete('dtr');
			}
			
		}
		elseif($para1 == 'add'){
			$this->page_data['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('id' => $this->session->userdata('toolplaza')))->row()->name;
			$this->load->view('front/toolplaza/dtr_add' , $this->page_data);
		}
		elseif($para1 == 'edit'){
			$this->page_data['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('id' => $this->session->userdata('toolplaza')))->row()->name;
			$this->page_data['dtr'] = $this->db->get_where('dtr',array('id' => $para2))->result_array();
			if($this->page_data['dtr']){
				if($this->page_data['dtr'][0]['status'] == 1 || $this->page_data['dtr'][0]['user_id'] != $this->session->userdata('supervisor_id')){
					echo "<span class='text-danger'>Invalid Request</span>"; exit;
				}	
			}else{
					echo "<span class='text-danger'>Invalid Request</span>"; exit;
			}
			
			$this->load->view('front/toolplaza/dtr_edit', $this->page_data);
		}
		elseif($para1 == 'do_add'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('for_date','Valid Date','required|trim');
			$this->form_validation->set_rules('omc','OMC','required|trim');
			$this->form_validation->set_rules('description','Description','required|trim');
			$this->form_validation->set_rules('notes','Notes','required|trim');
			$this->form_validation->set_rules('class1','Class 1 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class2','Class 2 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class3','Class 3 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class4','Class 4 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class5','Class 5 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class6','Class 6 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class7','Class 7 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class8','Class 8 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class9','Class 9 Passess','required|trim|is_natural');
			$this->form_validation->set_rules('class10','Class 10 Passess','required|trim|is_natural');
			if($this->input->post('add_exempt') == 1){
						$class1 = $this->input->post('class1');
						$class2 = $this->input->post('class2');
						$class3 = $this->input->post('class3');
						$class4 = $this->input->post('class4');
						$class5 = $this->input->post('class5');
						$class6 = $this->input->post('class6');
						$class7 = $this->input->post('class7');
						$class8 = $this->input->post('class8');
						$class9 = $this->input->post('class9');
						$class10 = $this->input->post('class10');
						//$this->form_validation->set_message('less_than_equal_to', '%s One of your exempt is exceeding total traffic for this class');
						$this->form_validation->set_rules("exempt1","Class 1 Exempt","required|trim|is_natural|less_than_equal_to[$class1]");
						$this->form_validation->set_rules('exempt2','Class 2 Exempt',"required|trim|is_natural|less_than_equal_to[$class2]");
						$this->form_validation->set_rules('exempt3','Class 3 Exempt',"required|trim|is_natural|less_than_equal_to[$class3]");
						$this->form_validation->set_rules('exempt4','Class 4 Exempt',"required|trim|is_natural|less_than_equal_to[$class4]");
						$this->form_validation->set_rules('exempt5','Class 5 Exempt',"required|trim|is_natural|less_than_equal_to[$class5]");
						$this->form_validation->set_rules('exempt6','Class 6 Exempt',"required|trim|is_natural|less_than_equal_to[$class6]");
						$this->form_validation->set_rules('exempt7','Class 7 Exempt',"required|trim|is_natural|less_than_equal_to[$class7]");
						$this->form_validation->set_rules('exempt8','Class 8 Exempt',"required|trim|is_natural|less_than_equal_to[$class8]");
						$this->form_validation->set_rules('exempt9','Class 9 Exempt',"required|trim|is_natural|less_than_equal_to[$class9]");
						$this->form_validation->set_rules('exempt10','Class 10 Exempt',"required|trim|is_natural|less_than_equal_to[$class10]");
			}
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			}
			else{
				foreach($_FILES['supporting_file']['name'] as $key => $value){
							
							if(!empty($value)){
								if(!empty($_POST['suppporting_document_name'][$key])){
									$_FILES['images[]']['name']		= $_FILES['supporting_file']['name'][$key];
            						$_FILES['images[]']['type']		= $_FILES['supporting_file']['type'][$key];
            						$_FILES['images[]']['tmp_name']	= $_FILES['supporting_file']['tmp_name'][$key];
            						$_FILES['images[]']['error']	= $_FILES['supporting_file']['error'][$key];
            						$_FILES['images[]']['size']		= $_FILES['supporting_file']['size'][$key];

									$config['upload_path'] = './uploads/temp';
									$config['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
									$config['overwrite'] = TRUE;
									$this->load->library('upload', $config);
									if ( ! $this->upload->do_upload('images[]')){
											echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
										}
									

								}else{
									echo json_encode(array('response' => FALSE , 'message' => "One of your supporting document name is missing")); exit;
								
								}
							}
					}


						/*if($this->input->post('mtr_type') == 1){
							$for_month		= 	$this->input->post('for_month');
							$format = str_replace('/','-', $for_month)."-01";
							$check_month = $this->db->get_where('mtr',array('for_month' => $format, 'toolplaza' => $this->session->userdata('toolplaza')))->result_array();
							if($check_month){
								echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;			
							}
						}else{
							$user_id 		= 	$this->session->userdata('supervisor_id');
							$toolplaza  	= 	$this->session->userdata('toolplaza');
							$for_month		= 	$this->input->post('for_month');
							$format = str_replace('/','-', $for_month)."-01";
							//$mtr = $this->db->get_where('mtr',array('toolplaza' => $toolplaza ,'user_id' => $user_id, 'for_month' => $format, 'type' => 2))->result_array();
							$this->db->where('toolplaza',$toolplaza);
							$this->db->where('for_month',$format);
							$this->db->where('type',2);
							$this->db->order_by("id", "desc");
							$this->db->limit(1);
							$mtr = $this->db->get('mtr')->result_array();
							if($mtr){
								$pass_date = strtotime($mtr[0]['for_month']);
								$total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));
								if($mtr[0]['end_date'] >= $total_days)
								{
									echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;
								}	
							}
						}*/
				if (empty($_FILES['dtr_file']['name'])) {
					echo json_encode(array('response' => FALSE , 'message' => 'Please upload a valid file')); exit;	
				}

				$config['upload_path'] = './uploads/temp';
				$config['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
				$config['overwrite'] = TRUE;
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('dtr_file')){
					echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
				}


				$data['user_id'] 		= 	$this->session->userdata('supervisor_id');
				$data['toolplaza']  	= 	$this->session->userdata('toolplaza');
				$data['omc']  			= 	$this->input->post('omc');
				$data['description'] 	= 	$this->input->post('description');
				$data['notes'] 			= 	$this->input->post('notes');
				$data['class1'] 		= 	$this->input->post('class1');
				$data['class2'] 		= 	$this->input->post('class2');
				$data['class3'] 		= 	$this->input->post('class3');
				$data['class4'] 		= 	$this->input->post('class4');
				$data['class5'] 		= 	$this->input->post('class5');
				$data['class6'] 		= 	$this->input->post('class6');
				$data['class7'] 		= 	$this->input->post('class7');
				$data['class8'] 		= 	$this->input->post('class8');
				$data['class9'] 		= 	$this->input->post('class9');
				$data['class10'] 		= 	$this->input->post('class10');
				/*if($this->input->post('mtr_type') == 2){
					$data['start_date'] 	= 	explode('/', $this->input->post('start_date'))[0];
					$data['end_date'] 		= 	explode('/', $this->input->post('end_date'))[0];
					
				}else{
					$pass_date 				= 	str_replace('/','-',$this->input->post('for_month').'-01');					
					$data['start_date'] 	= 	01;
		
					$data['end_date'] 		=  cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($pass_date)), date('Y', strtotime($pass_date)));;
					
					

				}*/
				$data['for_date']  	=   date('Y-m-d',strtotime($this->input->post('for_date')));
				$data['total']      	= 	$this->input->post('class1') + $this->input->post('class2') + $this->input->post('class3') + $this->input->post('class4') + $this->input->post('class5') + $this->input->post('class6') + $this->input->post('class7') + $this->input->post('class8') + $this->input->post('class9') + $this->input->post('class10');
				$data['adddate']		=	time();
				/*if (empty($data['start_date']) || empty($data['end_date'])) {
   					echo json_encode(array('response' => FALSE , 'message' => "An Error Occoured Please Refresh Your Page And try Again")); exit;
				}*/
				$this->db->insert('dtr', $data);
				$insert_id = $this->db->insert_id();
				if($this->input->post('add_exempt') == 1){
						$post_exempt = array();
						$post_exempt['description'] = $this->input->post('excempt_desc');
						$post_exempt['notes'] = $this->input->post('exempt_notes');
						for($i = 1; $i<=10; $i++){
							$post_exempt[$i] = $this->input->post('exempt'.$i);
						}
						$this->General->add_dtr_exempt($insert_id, $post_exempt);
				}
				$filename = $_FILES["dtr_file"]["name"];

				$ext = @end((explode(".", $filename)));
				$file_new_name = 'dtr'.$insert_id.'_'.str_replace('/', '-',$this->input->post('for_date')).'.'.$ext;
				$config1['upload_path'] = './uploads/dtr';
				$config1['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
				$config1['overwrite'] = TRUE;
				$config1['file_name']	=	$file_new_name;
				//$this->load->library('upload', $config);
				 $this->upload->initialize($config1);
				if ( ! $this->upload->do_upload('dtr_file')){
		           echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
		        }
		        else{

		        	$update['file'] = $file_new_name;
		        	$this->db->where('id', $insert_id);
		        	$this->db->update('dtr',$update);
		        	foreach($_FILES['supporting_file']['name'] as $key => $value){
							if(!empty($value)){
								if(!empty($_POST['suppporting_document_name'][$key])){
									$_FILES['images[]']['name']		= $_FILES['supporting_file']['name'][$key];
            						$_FILES['images[]']['type']		= $_FILES['supporting_file']['type'][$key];
            						$_FILES['images[]']['tmp_name']	= $_FILES['supporting_file']['tmp_name'][$key];
            						$_FILES['images[]']['error']	= $_FILES['supporting_file']['error'][$key];
            						$_FILES['images[]']['size']		= $_FILES['supporting_file']['size'][$key];
										$s_data = array();
										$s_data['name'] = $_POST['suppporting_document_name'][$key];
										$s_data['dtr_id'] = $insert_id; 
										$this->db->insert('dtr_supporting_document', $s_data);
										$supporting_id = $this->db->insert_id();
										//$supporting_data = array();
										$s_filename = $_FILES["supporting_file"]["name"][$key];

										$ext = @end((explode(".", $s_filename)));
										$s_file_new_name = 'dtr_supporting_document'.$insert_id.'_'.$supporting_id.'.'.$ext;
										$configs['upload_path'] = './uploads/supporting';
										$configs['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
										$configs['overwrite'] = TRUE;
										$configs['file_name']	=	$s_file_new_name;
										//$this->load->library('upload', $config);
										 $this->upload->initialize($configs);
										if ( ! $this->upload->do_upload('images[]'))
								        {
								           echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
								        }else{
								        	$s_data = array();
								        	$s_data['path'] = $s_file_new_name;
								        	$this->db->where('id', $supporting_id);
								        	$this->db->update('dtr_supporting_document', $s_data);
								        }
									

								}else{
									echo json_encode(array('response' => FALSE , 'message' => "One of your supporting document name is missing")); exit;
								
								}
							}
					} 
		         	$this->load->helper('file');
		         	delete_files('./uploads/temp');

		         	echo json_encode(array('response' => TRUE , 'message' => 'Added Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/dtr'));
		        }

			}
		}
		elseif($para1 == 'do_update'){
			//$check = $this->db->get_where('mtr',array('id' => $para2 , 'user_id' => $this->session->userdata('supervisor_id')))->result_array();
			$this->db->where('id',$para2);
			$this->db->where('user_id',$this->session->userdata('supervisor_id'));
			$this->db->where('status !=', 1);
			$check = $this->db->get('dtr')->result_array();
			if($check){
					$this->load->library('form_validation');
					$this->form_validation->set_rules('for_date','Valid Date','required|trim');
					$this->form_validation->set_rules('description','Description','required|trim');
					$this->form_validation->set_rules('notes','Notes','required|trim');
					$this->form_validation->set_rules('omc','OMC','required|trim');
					$this->form_validation->set_rules('class1','Class 1 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class2','Class 2 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class3','Class 3 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class4','Class 4 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class5','Class 5 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class6','Class 6 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class7','Class 7 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class8','Class 8 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class9','Class 9 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class10','Class 10 Passess','required|trim|is_natural');
					if($this->input->post('add_exempt') == 1){
						$class1 = $this->input->post('class1');
						$class2 = $this->input->post('class2');
						$class3 = $this->input->post('class3');
						$class4 = $this->input->post('class4');
						$class5 = $this->input->post('class5');
						$class6 = $this->input->post('class6');
						$class7 = $this->input->post('class7');
						$class8 = $this->input->post('class8');
						$class9 = $this->input->post('class9');
						$class10 = $this->input->post('class10');
						//$this->form_validation->set_message('less_than_equal_to', '%s One of your exempt is exceeding total traffic for this class');
						$this->form_validation->set_rules("exempt1","Class 1 Exempt","required|trim|is_natural|less_than_equal_to[$class1]");
						$this->form_validation->set_rules('exempt2','Class 2 Exempt',"required|trim|is_natural|less_than_equal_to[$class2]");
						$this->form_validation->set_rules('exempt3','Class 3 Exempt',"required|trim|is_natural|less_than_equal_to[$class3]");
						$this->form_validation->set_rules('exempt4','Class 4 Exempt',"required|trim|is_natural|less_than_equal_to[$class4]");
						$this->form_validation->set_rules('exempt5','Class 5 Exempt',"required|trim|is_natural|less_than_equal_to[$class5]");
						$this->form_validation->set_rules('exempt6','Class 6 Exempt',"required|trim|is_natural|less_than_equal_to[$class6]");
						$this->form_validation->set_rules('exempt7','Class 7 Exempt',"required|trim|is_natural|less_than_equal_to[$class7]");
						$this->form_validation->set_rules('exempt8','Class 8 Exempt',"required|trim|is_natural|less_than_equal_to[$class8]");
						$this->form_validation->set_rules('exempt9','Class 9 Exempt',"required|trim|is_natural|less_than_equal_to[$class9]");
						$this->form_validation->set_rules('exempt10','Class 10 Exempt',"required|trim|is_natural|less_than_equal_to[$class10]");
			}
					if($this->form_validation->run() == FALSE){
						echo json_encode(array('response' => FALSE , 'message' => validation_errors()));
					}
					else{

						foreach($_FILES['supporting_file']['name'] as $key => $value){
							
							if(!empty($value)){
								if(!empty($_POST['suppporting_document_name'][$key])){
									$_FILES['images[]']['name']		= $_FILES['supporting_file']['name'][$key];
            						$_FILES['images[]']['type']		= $_FILES['supporting_file']['type'][$key];
            						$_FILES['images[]']['tmp_name']	= $_FILES['supporting_file']['tmp_name'][$key];
            						$_FILES['images[]']['error']	= $_FILES['supporting_file']['error'][$key];
            						$_FILES['images[]']['size']		= $_FILES['supporting_file']['size'][$key];

									$config['upload_path'] = './uploads/temp';
									$config['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
									$config['overwrite'] = TRUE;
									$this->load->library('upload', $config);
									if ( ! $this->upload->do_upload('images[]')){
										echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
									}
									

								}
								else{
									echo json_encode(array('response' => FALSE , 'message' => "One of your supporting document name is missing")); exit;
								
								}
							}
					}
						/*if($this->input->post('dtr_type') == 1){
							$for_month		= 	$this->input->post('for_month');
							$format = str_replace('/','-', $for_month)."-01";
							$this->db->where('for_month',$format);
							$this->db->where('toolplaza',$this->session->userdata('toolplaza'));
							$this->db->where('id !=',$para2);
							$check_month = $this->db->get('mtr')->result_array();
							//echo $this->db->last_query(); exit;
							//$check_month = $this->db->get_where('mtr',array('for_month' => $format, 'toolplaza' => $this->session->userdata('toolplaza')))->result_array();
							if($check_month){
								echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;			
							}
						}else{
							$user_id 		= 	$this->session->userdata('supervisor_id');
							$toolplaza  	= 	$this->session->userdata('toolplaza');
							$for_month		= 	$this->input->post('for_month');
							$format = str_replace('/','-', $for_month)."-01";
							//$mtr = $this->db->get_where('mtr',array('toolplaza' => $toolplaza ,'user_id' => $user_id, 'for_month' => $format, 'type' => 2))->result_array();
							$this->db->where('toolplaza',$toolplaza);
							$this->db->where('for_month',$format);
							$this->db->where('type',2);
							$this->db->where('id !=',$para2);
							$this->db->order_by("id", "desc");
							$this->db->limit(1);
							$mtr = $this->db->get('mtr')->result_array();
							if($mtr){
								$pass_date = strtotime($mtr[0]['for_month']);
								$total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));
								if($mtr[0]['end_date'] >= $total_days){
									echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;
								}	
							}
						}*/
						
						if (!empty($_FILES['dtr_file']['name'])) {
								$config['upload_path'] = './uploads/temp';
								$config['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
								$config['overwrite'] = TRUE;
								$this->load->library('upload', $config);
								if ( ! $this->upload->do_upload('dtr_file')){
									echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
								}
						}

						$data['user_id'] 		= 	$this->session->userdata('supervisor_id');
						$data['toolplaza']  	= 	$this->session->userdata('toolplaza');
						$data['omc']  			= 	$this->input->post('omc');
						$data['description'] 	= 	$this->input->post('description');
						$data['notes'] 			= 	$this->input->post('notes');
						$data['class1'] 		= 	$this->input->post('class1');
						$data['class2'] 		= 	$this->input->post('class2');
						$data['class3'] 		= 	$this->input->post('class3');
						$data['class4'] 		= 	$this->input->post('class4');
						$data['class5'] 		= 	$this->input->post('class5');
						$data['class6'] 		= 	$this->input->post('class6');
						$data['class7'] 		= 	$this->input->post('class7');
						$data['class8'] 		= 	$this->input->post('class8');
						$data['class9'] 		= 	$this->input->post('class9');
						$data['class10'] 		= 	$this->input->post('class10');
						$data['for_date']		=	date('Y-m-d', strtotime($this->input->post('for_date')));
						$data['total']      	= 	$this->input->post('class1') + $this->input->post('class2') + $this->input->post('class3') + $this->input->post('class4') + $this->input->post('class5') + $this->input->post('class6') + $this->input->post('class7') + $this->input->post('class8') + $this->input->post('class9') + $this->input->post('class10');
						$data['adddate']		=	time();
						$data['status']			=   0;
						/** some changes by yasir for notifications START
						$this->db->where('id',$this->session->userdata('supervisor_id'));
						$supervisor = $this->db->get('tpsupervisor')->result_array();
						$tollplaza =$this->db->get_where('toolplaza',array('id'=>$supervisor[0]['tollplaza'],'status'=>1))->result_array();
						$notificatoin_msg =  $tollplaza[0]['name']." ". date("F, Y",strtotime($check[0]['for_month'])) .' mtr Updated.';
							$data11 = array(
							'user_id' => $this->session->userdata('supervisor_id'),
							'user_type' => 1,
							'for_user_id' =>  1,
							'for_user_type' => 3,
							'ref_id' 	=> $para2,
							'alert_type'  => 2,
							'date' => date("Y-m-d H:i:s"),
							'is_read' => 0,
							'notification_msg' => $notificatoin_msg                
							 );

							$this->db->insert('notifications', $data11); 
					/** some changes by yasir for notifications END*/
						$this->db->where('id', $para2);
						$this->db->update('dtr', $data);
						

						if($this->input->post('add_exempt') == 1){
							$post_exempt = array();
							$post_exempt['description'] = $this->input->post('excempt_desc');
							$post_exempt['notes'] = $this->input->post('exempt_notes');
							for($i = 1; $i<=10; $i++){
								$post_exempt[$i] = $this->input->post('exempt'.$i);
							}
							$this->General->add_dtr_exempt($para2, $post_exempt);
						}else{
							$this->General->checkexempt_dtr_exist_delete($para2);
						}
						foreach($_FILES['supporting_file']['name'] as $key => $value){
							if(!empty($value)){
								if(!empty($_POST['suppporting_document_name'][$key])){
									$_FILES['images[]']['name']		= $_FILES['supporting_file']['name'][$key];
            						$_FILES['images[]']['type']		= $_FILES['supporting_file']['type'][$key];
            						$_FILES['images[]']['tmp_name']	= $_FILES['supporting_file']['tmp_name'][$key];
            						$_FILES['images[]']['error']	= $_FILES['supporting_file']['error'][$key];
            						$_FILES['images[]']['size']		= $_FILES['supporting_file']['size'][$key];
										$s_data = array();
										$s_data['name'] = $_POST['suppporting_document_name'][$key];
										$s_data['dtr_id'] = $para2; 
										$this->db->insert('dtr_supporting_document', $s_data);
										$supporting_id = $this->db->insert_id();
										//$supporting_data = array();
										$s_filename = $_FILES["supporting_file"]["name"][$key];

										$ext = @end((explode(".", $s_filename)));
										$s_file_new_name = 'supporting_document'.$para2.'_'.$supporting_id.'.'.$ext;
										$configs['upload_path'] = './uploads/supporting';
										$configs['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
										$configs['overwrite'] = TRUE;
										$configs['file_name']	=	$s_file_new_name;
										//$this->load->library('upload', $config);
										 $this->upload->initialize($configs);
										if ( ! $this->upload->do_upload('images[]'))
								        {
								           echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
								        }else{
								        	$s_data = array();
								        	$s_data['path'] = $s_file_new_name;
								        	$this->db->where('id', $supporting_id);
								        	$this->db->update('dtr_supporting_document', $s_data);
								        	$this->load->helper('file');
				         					delete_files('./uploads/temp');
								        }
									

								}else{
									echo json_encode(array('response' => FALSE , 'message' => "One of your supporting document name is missing")); exit;
								
								}
							}
					}
						if (!empty($_FILES['dtr_file']['name'])) {
						$filename = $_FILES["dtr_file"]["name"];

						$ext = @end((explode(".", $filename)));
						$file_new_name = 'dtr'.$para2.'_'.str_replace('/', '-',$this->input->post('for_date')).'.'.$ext;
						$config1['upload_path'] = './uploads/dtr';
						$config1['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
						$config1['overwrite'] = TRUE;
						$config1['file_name']	=	$file_new_name;
						//$this->load->library('upload', $config);
						 $this->upload->initialize($config1);
						if ( ! $this->upload->do_upload('dtr_file'))
				        {
				           echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
				        }
				        else
				        {
				        	$update['file'] = $file_new_name;
				        	$this->db->where('id', $para2);
				        	$this->db->update('dtr',$update);

				         	$this->load->helper('file');
				         	delete_files('./uploads/temp');
				         	//echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/mtr'));
				        }
				    }
				    echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/dtr'));
				} // else end


					}
			else{
				echo json_encode(array('response' => FALSE , 'message' => "Invalid Request")); exit;
			}
			
		}
		elseif($para1 == 'view'){
			$this->load->view('front/toolplaza/dtr_invoice', $this->page_data);

		}
		elseif($para1 == 'view_reason'){
			$reason = $this->db->get_where('dtr',array('id' => $para2))->result_array();
			if($reason[0]['status'] == 2){
				echo "<span class='text-info'>".$reason[0]['reason']."</span>";
			}else{
				echo "<span class='text-danger'>Invalid Request</span>";
			}
			
		}
		else{
			
			$this->page_data['page_name'] = 'dtr';
			$this->load->view('front/toolplaza/dtr', $this->page_data);	
		}
		
	}
	public function daily_traffic_report($para1 = ''){
		$this->page_data['dtr'] = $this->db->get_where('dtr',array('id' => $para1 ))->result_array();
		$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['dtr'][0]['toolplaza']." ,toolplaza)  AND (start_date <= '".$this->page_data['dtr'][0]['for_date']."' AND end_date >= '".$this->page_data['dtr'][0]['for_date']."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();

		$this->load->view('front/toolplaza/dtr_invoice', $this->page_data);
	}
	public function dtr_generate_pdf($para1 = ''){
		$this->page_data['dtr'] = $this->db->get_where('dtr',array('id' => $para1 ))->result_array();
		/*$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];*/

		//$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza)";
		$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['dtr'][0]['toolplaza']." ,toolplaza)  AND (start_date <= '".$this->page_data['dtr'][0]['for_date']."' AND end_date >= '".$this->page_data['dtr'][0]['for_date']."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		$pdfdata = $this->load->view('front/toolplaza/dtr_invoice_pdf', $this->page_data, TRUE);

		$this->load->library("Pdf");
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('NHA DTR');
        $pdf->SetTitle('NHA Daily Traffic Report');
        $pdf->SetSubject('DTR');
        $pdf->SetKeywords('DTR, PDF');

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 16, '', true);
        $pdf->AddPage('L', 'A2');

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $pdf->writeHTMLCell(0, 0, '', '', $pdfdata, 0, 1, 0, true, '', true);
         $pdf->Output('dtr.pdf','I');
        //$pdf->Output(SERVER_RELATIVE_PATH . '/uploads/invoices/invoice' . $invoice_name . '.pdf', 'F');

	}
	public function view_dtrsupporting($para1 = ''){
		$this->page_data['support'] = $this->db->get_where('dtr_supporting_document',array('dtr_id' => $para1))->result_array();
		$this->load->view('front/toolplaza/suppporting_list', $this->page_data);

	}
	public function delete_dtrsuppporting($para1 = '', $para2 = ''){
			$this->db->where('id',$para2);
			$this->db->where('dtr_id',$para1);
			$record = $this->db->get('dtr_supporting_document')->result_array();
			if($record){
				$file = $record[0]['path'];
				unlink('./uploads/supporting/'.$file);
				$this->db->where('id', $para2);
				$this->db->delete('dtr_supporting_document');
			}
			$this->page_data['dtr'] = $this->db->get_where('dtr',array('id' => $para1))->result_array();
			$this->page_data['support'] = $this->db->get_where('dtr_supporting_document',array('dtr_id' => $para1))->result_array();
			 $this->load->view('front/toolplaza/supporting_document', $this->page_data);

	}

	///////////////////////////////////////////////////////////////
	////	/** Support Request START  *////////////////////
	///////////////////////////////////////////////////////////////
	public function supportrequest($para1 = '', $para2 = '', $para3 = ''){	
		if($para1 == 'list'){
			$this->db->order_by('id','DESC');
			$this->db->where('toolplaza_id', $this->session->userdata('toolplaza'));
			$this->db->where('supervisor_id', $this->session->userdata('supervisor_id'));
			$this->page_data['dsr'] = $this->db->get('dsr')->result_array();
			$this->load->view('front/toolplaza/supportrequest_list', $this->page_data);
		}elseif($para1 == 'delete'){
			$idd = $this->db->where('id',$para2);

			$this->db->where('supervisor_id',$this->session->userdata('supervisor_id'));
			$this->db->where('status !=', 1, FALSE);
			/*$support = $this->db->get_where('supporting_document',array('mtr_id' => $para2))->result_array();
			if($support){
				foreach($support as $val){
					unlink('./uploads/supporting/'.$val['path']);
				}
				$this->db->where('mtr_id', $para2);
				$this->db->delete('supporting_document');
			}
			$file = $this->db->get_where('mtr',array('id' => $para2))->row()->file;
			unlink('./uploads/mtr/'.$file);*/
			$this->db->where('id',$para2);
			$dlt = $this->db->delete('dsr');
			if(empty($dlt))
			{
				echo json_encode(array('response' => FALSE, 'message' => 'Delete Error'));exit;
			}
			else
			{
				echo json_encode(array('response' => TRUE , 'message' => 'Deleted Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/dsr'));
			}
			
		}
		elseif($para1 == 'add'){
			
			$this->page_data['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('id' => $this->session->userdata('toolplaza')))->row()->name;
			//added code Numan
			$this->page_data['supervisor_id'] = $this->session->userdata['supervisor_id'];
			$this->page_data['supervisor_first'] = $this->db->get_where('tpsupervisor',array('id' => $this->session->userdata('supervisor_id')))->row()->fname;
			$this->page_data['supervisor_last'] = $this->db->get_where('tpsupervisor',array('id' => $this->session->userdata('supervisor_id')))->row()->lname;
			$this->page_data['supervisor_contact'] = $this->db->get_where('tpsupervisor',array('id' => $this->session->userdata('supervisor_id')))->row()->contact;
			//$this->page_data['supervisor_profile'] = $this->s_model->find($id);
			$tid = $this->session->userdata['toolplaza'];
			$this->page_data['north'] = $this->db->get_where('tp_lanes', array('bound' => 'N', 'tollplaza' => $this->session->userdata('toolplaza')) )->result_array();
			$this->page_data['south'] = $this->db->get_where('tp_lanes', array('bound' => 'S', 'tollplaza' => $this->session->userdata('toolplaza')) )->result_array();
			$this->page_data['staff'] = $this->db->get_where('tpstaff', array('tollplaza' => $this->session->userdata('toolplaza')) )->result_array();
			$this->page_data['supervisor_plaza'] = $this->t_model->find($tid);
			$this->page_data['lane_plaza'] = $this->db->get_where('tp_lanes', array('tollplaza' => $this->session->userdata('toolplaza')) )->result_array();
			//$this->page_data['north_lanes'] = array_intersect($this->page_data['N'], $this->page_data['lane_plaza'] );
			$this->load->view('front/toolplaza/supportrequest_add' , $this->page_data);
			//added code finished numan
		}elseif($para1 == 'edit'){
			
			$this->page_data['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('id' => $this->session->userdata('toolplaza')))->row()->name; 
			$this->page_data['dsr'] = $this->db->get_where('dsr',array('id' => $para2, 'supervisor_id' => $this->session->userdata('supervisor_id')))->result_array();
			if($this->page_data['dsr']){
				if($this->page_data['dsr'][0]['status'] == 1 /*|| $this->page_data['dsr'][0]['upload_type'] != 1 */ || $this->page_data['dsr'][0]['supervisor_id'] != $this->session->userdata('supervisor_id')){
					echo "<span class='text-danger'>Invalid Request</span>"; exit;
				}	
			}else{
					echo "<span class='text-danger'>Invalid Request</span>"; exit;

			}
			$id = $this->page_data['supervisor_id'] = $this->session->userdata['supervisor_id'];
			$this->page_data['supervisor_first'] = $this->db->get_where('tpsupervisor',array('id' => $this->session->userdata('supervisor_id')))->row()->fname;
			$this->page_data['supervisor_last'] = $this->db->get_where('tpsupervisor',array('id' => $this->session->userdata('supervisor_id')))->row()->lname;
			$this->page_data['supervisor_contact'] = $this->db->get_where('tpsupervisor',array('id' => $this->session->userdata('supervisor_id')))->row()->contact;
			$tid = $this->session->userdata['toolplaza'];
			$this->page_data['supervisor_plaza'] = $this->t_model->find($tid);
			$this->page_data['north'] = $this->db->get_where('tp_lanes', array('bound' => 'N','tollplaza' => $this->session->userdata('toolplaza')))->result_array();
			$this->page_data['south'] = $this->db->get_where('tp_lanes', array('bound' => 'S','tollplaza' => $this->session->userdata('toolplaza')))->result_array();
			$this->page_data['staff'] = $this->db->get_where('tpstaff', array('tollplaza' => $this->session->userdata('toolplaza')))->result_array();
			$this->load->view('front/toolplaza/dsr_edit', $this->page_data);
		}elseif($para1 == 'do_add')
		{
		
			$this->page_data['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
			$tid = $this->session->userdata['toolplaza'];
			$this->page_data['supervisor_plaza'] = $this->t_model->find($tid);
			$this->page_data['lane_plaza'] = $this->lane_model->find_multiple($tid);
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('refno', 'Reference No.','trim|required');
			$this->form_validation->set_rules('datecreated', 'Date','trim|required');
			$this->form_validation->set_rules('omc', 'OMC','trim|required');
			$this->form_validation->set_rules('reportto', 'Report to','trim|required');
			$this->form_validation->set_rules('location', 'Location','trim|required');
			$this->form_validation->set_rules('dateoccur', 'Occurring Date','trim|required');
			$this->form_validation->set_rules('timeoccur', 'Occurring Time','trim|required');
			$this->form_validation->set_rules('dateoccurbefore', ' Before Occurring Date','trim|required');
			$this->form_validation->set_rules('adend', 'Affected/Damaged Equipment Name/Detail','trim|required');
			$this->form_validation->set_rules('remarks', 'Remarks','trim|required');
			
			if($this->form_validation->run() == FALSE)
			{
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			}
			else
			{ 				
				$srdata = array();
				
				$srdata['refno'] = $this->input->post('refno');
				date_default_timezone_set('Asia/Karachi');
				$srdata['datecreated'] = date('Y-m-d',strtotime($this->input->post('datecreated')));
				
				
				$srdata['toolplaza_id'] = $this->session->userdata('toolplaza');
				$srdata['supervisor_id'] = $this->session->userdata('supervisor_id');
				
				$srdata['omc'] = $this->input->post('omc');
				$srdata['reportto'] = $this->input->post('reportto');
				$srdata['location'] = $this->input->post('location');
				$srdata['dateoccur'] = $this->input->post('dateoccur');	
				$srdata['timeoccur'] = $this->input->post('timeoccur');	
				$srdata['dateoccurbefore'] = $this->input->post('dateoccurbefore');	
				$srdata['adend'] = $this->input->post('adend');	
				$srdata['remarks'] = $this->input->post('remarks');	
				
			
					// data not exist insert you information
					$this->db->limit(1);					 
					$datasr = $this->db->insert("supportrequest", $srdata);
					if(!empty($datasr))
					{

						//echo json_encode(array('response' => TRUE , 'message' => 'Added Successfully'));
						echo json_encode(array('response' => TRUE , 'message' => 'Added Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/supportrequest'));
						//$datadsr = $this->db->insert('dsr', $dsrdata);
					}
					else
					{
						echo json_encode(array('response' => FALSE, 'message' => 'Input Error'));
					}
				}
				
				
			
		}
		elseif($para1 == 'do_update'){	
			$this->page_data['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
			$tid = $this->session->userdata['toolplaza'];
			$this->page_data['supervisor_plaza'] = $this->t_model->find($tid);
			$this->page_data['lane_plaza'] = $this->lane_model->find_multiple($tid);
			$this->load->library('form_validation');
			$this->page_data['north'] = $this->db->get_where('tp_lanes', array('bound' => 'N', 'tollplaza' => $this->session->userdata('toolplaza')) )->result_array();
			$this->page_data['south'] = $this->db->get_where('tp_lanes', array('bound' => 'S', 'tollplaza' => $this->session->userdata('toolplaza')) )->result_array();
			$check = $this->db->get_where('dsr', array('id' => $para2,'supervisor_id' => $this->session->userdata['supervisor_id']))->result_array();
			
			if ($check)
			{
				$counter = 0;
				foreach($this->page_data['north'] as $n)
					{	
						$counter++; $section = $counter; 

						$this->form_validation->set_rules('nlane'.$section, 'North Lane '.$n['name'],'trim|required');
						$this->form_validation->set_rules('nlanestatus'.$section, 'North Lane Status'.$section, 'trim|required');
						$this->form_validation->set_rules('ncamera'.$section, 'North Camera '.$n['name'], 'trim|required');
					}
				$counter = 0;
				foreach($this->page_data['south'] as $s)
					{	
						$counter++; $section = $counter; 

						$this->form_validation->set_rules('slane'.$section, 'Lane '.$s['name'],'trim|required');
						$this->form_validation->set_rules('slanestatus'.$section, 'South Lane Status'.$section, 'trim|required');
						$this->form_validation->set_rules('scamera'.$section, 'South Camera '.$s['name'], 'trim|required');
					}
				$this->form_validation->set_rules('datecreated', 'Date', 'trim|required');
				$this->form_validation->set_rules('omc', 'OMC','trim|required');
				$this->form_validation->set_rules('site_lsdu', 'LSDU Status','trim|required');
				$this->form_validation->set_rules('site_dt', 'Daily Traffic ','trim|required');
				$this->form_validation->set_rules('site_dr', 'Daily Revenue','trim|required');
				$this->form_validation->set_rules('frame', 'Frame Grabber Status','trim|required');
				$this->form_validation->set_rules('image', 'Image Status','trim|required');
				$this->form_validation->set_rules('shutdown', 'ShutDown Status','trim|required');
				$this->form_validation->set_rules('mtrstatus', 'MTR Status','trim|required');
				$this->form_validation->set_rules('apmtr', 'Pending MTR','trim|required');
				$this->form_validation->set_rules('asmtr', 'Archiving Status','trim|required');
				$this->form_validation->set_rules('mtrupto', 'MTR UPTO ','trim|required');
				$this->form_validation->set_rules('serverstatus', 'Server Status','trim|required');
				$this->form_validation->set_rules('linkissue', 'Link Issue','trim|required');	
				$this->form_validation->set_rules('pcelectricity', 'Electricity Condition','trim|required');
				$this->form_validation->set_rules('pcbuilding', 'Building Condition','trim|required');
				$this->form_validation->set_rules('pccleaning', 'Cleanliness Condition','trim|required');
				$this->form_validation->set_rules('pcreceipts', 'Receipts Condition','trim|required');
				$this->form_validation->set_rules('pcwater', 'Water Condition','trim|required');
				$this->form_validation->set_rules('pcmeal', 'Meal Condition','trim|required');
				$this->form_validation->set_rules('pcqueuing', 'Queuing Condition','trim|required');
				$this->form_validation->set_rules('asrg', 'Support Request','trim|required');

				if($this->form_validation->run() == FALSE)
				{
					echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
				}
				else
				{ 				
					$dsrdata = array();
					$dsrdata['id']	= $check[0]['id'];
					$dsrdata['toolplaza_id'] = $this->session->userdata('toolplaza');
					$dsrdata['supervisor_id'] = $this->session->userdata('supervisor_id');
					date_default_timezone_set('Asia/Karachi');
					$dsrdata['datecreated'] = date('Y-m-d',strtotime($this->input->post('datecreated')));

					
					$dsrdata['omc'] = $this->input->post('omc');	

					$section = 0;
					foreach($this->page_data['north'] as $n)
						{		
							$section++;

							$dsrdata['nlane'.$section] = $this->input->post('nlane'.$section);

							$dsrdata['nlanestatus'.$section] = $this->input->post('nlanestatus'.$section);
							$dsrdata['nlclosed'.$section] = $this->input->post('nlclosed'.$section);
							$dsrdata['nlclosed_from'.$section] = $this->input->post('nlclosed_from'.$section);
							$dsrdata['nlclosed_to'.$section] = $this->input->post('nlclosed_to'.$section);
							$dsrdata['nlclosed_description'.$section] = $this->input->post('nlclosed_description'.$section);
							$dsrdata['ncamera'.$section] = $this->input->post('ncamera'.$section);
							$dsrdata['ncstatus'.$section] = $this->input->post('ncstatus'.$section);
							$dsrdata['nfc_desc'.$section] = $this->input->post('nfc_desc'.$section);

						}
					$section = 0;
					foreach($this->page_data['south'] as $s)
						{		
							$section++;

							$dsrdata['slane'.$section] = $this->input->post('slane'.$section);
							$dsrdata['slanestatus'.$section] = $this->input->post('slanestatus'.$section);
							$dsrdata['slclosed'.$section] = $this->input->post('slclosed'.$section);
							$dsrdata['slclosed_from'.$section] = $this->input->post('slclosed_from'.$section);
							$dsrdata['slclosed_to'.$section] = $this->input->post('slclosed_to'.$section);
							$dsrdata['slclosed_description'.$section] = $this->input->post('slclosed_description'.$section);
							$dsrdata['scamera'.$section] = $this->input->post('scamera'.$section);
							$dsrdata['scstatus'.$section] = $this->input->post('scstatus'.$section);
							$dsrdata['sfc_desc'.$section] = $this->input->post('sfc_desc'.$section);
						}
					for($ptz=1; $ptz<3; $ptz++)
					{
						$dsrdata['cameraptz'.$ptz]	=	$this->input->post('cameraptz'.$ptz);
						$dsrdata['ptzstatus'.$ptz]	=	$this->input->post('ptzstatus'.$ptz);
						$dsrdata['ptzfc_desc'.$ptz]	=	$this->input->post('ptzfc_desc'.$ptz);
					}

					$dsrdata['site_lsdu'] = $this->input->post('site_lsdu');
					$dsrdata['shutdown'] = $this->input->post('shutdown');
					$dsrdata['shut_from'] = $this->input->post('shut_from');
					$dsrdata['shut_to'] = $this->input->post('shut_to');
					$dsrdata['site_dt'] = $this->input->post('site_dt');
					$dsrdata['site_dr'] = $this->input->post('site_dr');
					$dsrdata['frame'] = $this->input->post('frame');
					$dsrdata['image'] = $this->input->post('image');				
					$dsrdata['mtrstatus'] = $this->input->post('mtrstatus');
					$dsrdata['apmtr'] = $this->input->post('apmtr');
					$dsrdata['asmtr'] = $this->input->post('asmtr');
					$dsrdata['mtrstatus'] = $this->input->post('mtrstatus');
					$dsrdata['mtrupto'] = $this->input->post('mtrupto');
					$dsrdata['serverstatus'] = $this->input->post('serverstatus');								
					$dsrdata['linkissue'] = $this->input->post('linkissue');
					$dsrdata['lissue_desc'] = $this->input->post('lissue_desc');
					for($as = '1'; $as < '9'; $as++)
					{ 
						$dsrdata['as'.$as] = $this->input->post('as'.$as);
						$dsrdata['as'.$as.'status'] = $this->input->post('as'.$as.'status');
						$dsrdata['as'.$as.'holidayfrom'] = $this->input->post('as'.$as.'holidayfrom');
						$dsrdata['as'.$as.'holidayto'] = $this->input->post('as'.$as.'holidayto');
					}
					$dsrdata['pcbuilding'] = $this->input->post('pcbuilding');
					$dsrdata['pccleaning'] = $this->input->post('pccleaning');
					$dsrdata['pcreceipts'] = $this->input->post('pcreceipts');
					$dsrdata['pcwater'] = $this->input->post('pcwater');
					$dsrdata['pcmeal'] = $this->input->post('pcmeal');
					$dsrdata['pcqueuing'] = $this->input->post('pcqueuing');
					$dsrdata['pcelectricity'] = $this->input->post('pcelectricity');
					$dsrdata['ecause'] = $this->input->post('pcelectricity');
					$dsrdata['ereason'] = $this->input->post('ereason');
					$dsrdata['asrg'] = $this->input->post('asrg');
					$dsrdata['refno'] = $this->input->post('refno');
					$dsrdata['refduration'] = $this->input->post('refduration');
					$dsrdata['status'] = $check[0]['status'];
					$dsrdata['disapprove_reason'] = $check[0]['disapprove_reason'];

					$this->db->where('id', $para2);
					$upd = $this->db->update('dsr', $dsrdata); 

					if(empty($upd))
					{
						echo json_encode(array('response' => FALSE, 'message' => 'Input Error'));exit;
					}
					else
					{
						echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/dsr'));	
					}

				}
			}else{
				echo json_encode(array('response' => FALSE , 'message' => "Invalid Request")); exit;
			}
		}elseif($para1 == 'view'){
			$this->load->view('front/toolplaza/sitereport', $this->page_data);

		}elseif($para1 == 'view_reason'){
			$reason = $this->db->get_where('dsr',array('id' => $para2))->result_array();
			if($reason[0]['status'] == 2){
				echo "<span class='text-info'>".$reason[0]['disapprove_reason']."</span>";
			}else{
				echo "<span class='text-danger'>Invalid Request</span>";
			}	
		}else{

			$this->page_data['page_name'] = 'supportrequest';
			$this->load->view('front/toolplaza/supportrequest', $this->page_data);	
		}
	}
	
	///////////////////////////////////////////////////////////////
	////	/** DSR START  *////////////////////
	///////////////////////////////////////////////////////////////
	
	public function dsr($para1 = '', $para2 = '', $para3 = ''){	
		$id = $this->session->userdata['supervisor_id'];
		$tool = $this->session->userdata('toolplaza');
		if($para1 == 'list'){
			$list['dsr'] = $this->dsr_model->list_dsr($id, $tool);
			$this->load->view('front/toolplaza/dsr_list', $list);
		}
		elseif($para1 == 'delete'){
			$this->dsr_model->delete_dsr($id, $para2);			
		}
		elseif($para1 == 'add'){
			$page = 'C'; //CRUD Create
			
			//Some data is loaded to run data into dsr variable like Staff, north, south from dsr_lane, and dsr staff tables
			$data = $this->dsr_model->sitereport_data_preload($id, $tool, $page, $para2);
			$edit = $data;
			
			//$this->page_data['north_lanes'] = array_intersect($this->page_data['N'], $this->page_data['lane_plaza'] );
			$this->load->view('front/toolplaza/dsr_add' , $edit);
		}
		elseif($para1 == 'edit'){
			$page = 'R'; //CRUD Read
			//Some data is loaded to run data into dsr variable like Staff, north, south from dsr_lane, and dsr staff tables
			$preload_data =$this->dsr_model->sitereport_data_preload($id, $tool, $page, $para2);
			$edit = $preload_data;
			
			//data is loaded into dsr variable where new layout data is converted to old layout data so that it can be merged easily with older work
			$data = $this->dsr_model->dsr_data($id, $tool, $edit,$para2);
			/*?> <pre><?php echo print_r($data) ?> </pre><?php exit;*/
			$edit['dsr'] = $data['dsr'];
			$edit['dsr_staff'] = $data['dsr_staff'];
			if($edit['dsr']){
				if($edit['dsr'][0]['status'] == 1 || $edit['dsr'][0]['supervisor_id'] != $id){
					echo "<span class='text-danger'>Invalid Request</span>"; exit;
				}	
			}
			else{
				echo "<span class='text-danger'>Invalid Request</span>"; exit;
			}
			/*?><pre> <?php echo print_r($edit); exit;*/
			$this->load->view('front/toolplaza/dsr_edit', $edit);
		}
		elseif($para1 == 'do_add'){
			/*?><pre> <?php echo print_r($_POST);exit;*/
			$page = 'C'; //CRUD Create
			$this->load->library('form_validation');
			/*?> <pre> <?php echo print_r($_POST); ?></pre><?php exit;*/
			$data = $this->dsr_model->sitereport_data_preload($id, $tool, $page, $para1);
			$edit = $data;
			
			$counter = 0;
			foreach($edit['north'] as $n){	
				$counter++; $section = $counter; 

				$this->form_validation->set_rules('nlane'.$section, 'North Lane '.$n['name'],'trim|required');
				$this->form_validation->set_rules('nlanestatus'.$section, 'North Lane Status'.$section, 'trim|required');
				$this->form_validation->set_rules('ncamera'.$section, 'North Camera '.$n['name'], 'trim|required');
				$this->form_validation->set_rules('nohlsstatus'.$section, 'North OHLS '.$n['name'], 'trim|required');
				$this->form_validation->set_rules('nboomarmstatus'.$section, 'North Boom ARM '.$n['name'], 'trim|required');
				$this->form_validation->set_rules('nboommechstatus'.$section, 'North Boom Mech '.$n['name'], 'trim|required');
				$this->form_validation->set_rules('ntprinterstatus'.$section, 'North Thermal Printer '.$n['name'], 'trim|required');
				$this->form_validation->set_rules('ntctstatus'.$section, 'North TCT '.$n['name'], 'trim|required');
				$this->form_validation->set_rules('nlanepcstatus'.$section, 'North Lane PC '.$n['name'], 'trim|required');
				$this->form_validation->set_rules('ntlightstatus'.$section, 'North Traffic Light '.$n['name'], 'trim|required');
				$this->form_validation->set_rules('npfdstatus'.$section, 'North PFD '.$n['name'], 'trim|required');
			}
			$counter = 0;
			foreach($edit['south'] as $s){	
				$counter++; $section = $counter; 

				$this->form_validation->set_rules('slane'.$section, 'Lane '.$s['name'],'trim|required');
				$this->form_validation->set_rules('slanestatus'.$section, 'South Lane Status'.$section, 'trim|required');
				$this->form_validation->set_rules('scamera'.$section, 'South Camera '.$s['name'], 'trim|required');
				$this->form_validation->set_rules('sohlsstatus'.$section, 'South OHLS '.$s['name'], 'trim|required');
				$this->form_validation->set_rules('sboomarmstatus'.$section, 'South Boom ARM '.$s['name'], 'trim|required');
				$this->form_validation->set_rules('sboommechstatus'.$section, 'South Boom Mech '.$s['name'], 'trim|required');
				$this->form_validation->set_rules('stprinterstatus'.$section, 'South Thermal Printer '.$s['name'], 'trim|required');
				$this->form_validation->set_rules('stctstatus'.$section, 'South TCT '.$s['name'], 'trim|required');
				$this->form_validation->set_rules('slanepcstatus'.$section, 'South Lane PC '.$s['name'], 'trim|required');
				$this->form_validation->set_rules('stlightstatus'.$section, 'South Traffic Light '.$s['name'], 'trim|required');
				$this->form_validation->set_rules('spfdstatus'.$section, 'South PFD '.$s['name'], 'trim|required');
			}
			$this->form_validation->set_rules('datecreated', 'Date','trim|required');
			$this->form_validation->set_rules('omc', 'OMC','trim|required');
			$this->form_validation->set_rules('site_lsdu', 'LSDU Status','trim|required');
			$this->form_validation->set_rules('site_dt', 'Daily Traffic ','trim|required');
			$this->form_validation->set_rules('site_dr', 'Daily Revenue','trim|required');
			$this->form_validation->set_rules('frame', 'Frame Grabber Status','trim|required');
			$this->form_validation->set_rules('image', 'Image Status','trim|required');
			$this->form_validation->set_rules('shutdown', 'ShutDown Status','trim|required');
			$this->form_validation->set_rules('mtrstatus', 'MTR Status','trim|required');
			$this->form_validation->set_rules('apmtr', 'Pending MTR','trim|required');
			$this->form_validation->set_rules('asmtr', 'Archiving Status','trim|required');
			$this->form_validation->set_rules('mtrupto', 'MTR UPTO ','trim|required');
			$this->form_validation->set_rules('serverstatus', 'Server Status','trim|required');
			$this->form_validation->set_rules('linkissue', 'Link Issue','trim|required');	
			$this->form_validation->set_rules('pcelectricity', 'Electricity Condition','trim|required');
			$this->form_validation->set_rules('pcbuilding', 'Building Condition','trim|required');
			$this->form_validation->set_rules('pccleaning', 'Cleanliness Condition','trim|required');
			$this->form_validation->set_rules('pcreceipts', 'Receipts Condition','trim|required');
			$this->form_validation->set_rules('pcwater', 'Water Condition','trim|required');
			$this->form_validation->set_rules('pcmeal', 'Meal Condition','trim|required');
			$this->form_validation->set_rules('pcqueuing', 'Queuing Condition','trim|required');
			$this->form_validation->set_rules('asrg', 'Support Request','trim|required');
			
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			}
			else{
				$dsr_datee = date('Y-m-d',strtotime($this->input->post('datecreated')));
				
				$dsr_updated_data = array();
				date_default_timezone_set('Asia/Karachi');
				$dsr_updated_data['datecreated'] = $dsr_datee;
				$dsr_date = $this->dsr_model->dsr_date_checker($dsr_datee, $tool);
				if($dsr_date){
					echo json_encode(array('response' => FALSE , 'message' => 'DSR of this date already exists')); exit;
				}
				else{
					$dsr_updated_data['toolplaza_id'] = $tool;
					$dsr_updated_data['supervisor_id'] = $id;
					$dsr_updated_data['created_at'] = time();				
					$dsr_updated_data['omc'] = $this->input->post('omc');
					$dsr_updated_data['daily_traffic'] = $this->input->post('site_dt');
					$dsr_updated_data['daily_revenue'] = $this->input->post('site_dr');

					$dsr_updated_data['ptz_north_status']	=	$this->input->post('ptzstatus1');
					$dsr_updated_data['ptz_north_description']	=	$this->input->post('ptzfc_desc1');
					$dsr_updated_data['ptz_south_status']	=	$this->input->post('ptzstatus2');
					$dsr_updated_data['ptz_south_description']	=	$this->input->post('ptzfc_desc2');

					$table = 'dsr_updated';	$data = $dsr_updated_data; $order_by = 'id';
					$data_dsr_updated = $this->dsr_model->insert_dsr($table, $data);				
					$dsr_update_data = $this->dsr_model->retrieve_last($table, $order_by);
					
					$dsr_status_data = array();
					$dsr_status_data['id'] = $dsr_update_data[0]['id'];
					$dsr_status_data['status_lsdu'] = $this->input->post('site_lsdu');
					$dsr_status_data['status_framegrabber'] = $this->input->post('frame');
					$dsr_status_data['status_server'] = $this->input->post('serverstatus');
					$dsr_status_data['status_shutdown'] = $this->input->post('shutdown');
					$dsr_status_data['time_shut_from'] = $this->input->post('shut_from');
					$dsr_status_data['time_shut_to'] = $this->input->post('shut_to');
					$dsr_status_data['status_link'] = $this->input->post('linkissue');
					$dsr_status_data['status_link_description'] = $this->input->post('lissue_desc');
					$dsr_status_data['status_building'] = $this->input->post('pcbuilding');
					$dsr_status_data['status_cleaning'] = $this->input->post('pccleaning');
					$dsr_status_data['status_reciepts'] = $this->input->post('pcreceipts');
					$dsr_status_data['status_water'] = $this->input->post('pcwater');
					$dsr_status_data['status_meal'] = $this->input->post('pcmeal');

					$dsr_status_data['status_electricity'] = $this->input->post('pcelectricity');
					$dsr_status_data['faulty_electricity_cause'] = $this->input->post('pcelectricity');
					$dsr_status_data['faulty_electricity_reason'] = $this->input->post('ereason');
					$dsr_status_data['status_queuing'] = $this->input->post('pcqueuing');

					$table = 'dsr_status';	$data = $dsr_status_data;
					$data_dsr_status = $this->dsr_model->insert_dsr($table, $data);


					$dsr_doc_data['id'] = $dsr_update_data[0]['id'];
					$dsr_doc_data['image_status'] = $this->input->post('image');
					$dsr_doc_data['mtr_status'] = $this->input->post('mtrstatus');
					$dsr_doc_data['mtr_pending'] = $this->input->post('apmtr');
					$dsr_doc_data['mtr_archiving_status'] = $this->input->post('asmtr');
					$dsr_doc_data['mtr_upto'] = $this->input->post('mtrupto');
					$dsr_doc_data['asrg'] = $this->input->post('asrg');
					$dsr_doc_data['asrg_reference_no'] = $this->input->post('refno');
					$dsr_doc_data['asrg_date'] = $this->input->post('refduration');
					$dsr_doc_data['asrg_detail'] = $this->input->post('request_detail');

					$table = 'dsr_doc';	$data = $dsr_doc_data;
					$data_dsr_doc = $this->dsr_model->insert_dsr($table, $data);

					$dsr_generator_data = array(
						'load_from' => $this->input->post('load-from'), 'load_to' => $this->input->post('load-to'), 'load_time' => $this->input->post('load-time'), 'generator_from' => $this->input->post('generator-from'), 'generator_to' => $this->input->post('generator-to'), 'generator_time' => $this->input->post('generator-time'), 'diesel_per_hour' => $this->input->post('diesel-per-hour'), 'diesel_consumed' => $this->input->post('diesel-consumed'), 'output_voltage' => $this->input->post('output-voltage'), 'fuel_level' => $this->input->post('fuel-level'), 'oil_level' => $this->input->post('oil-level'), 'oil_change' => $this->input->post('oil-change'), 'radiator_water_level' => $this->input->post('radiator-water-level'), 'battery_water_level' => $this->input->post('battery-water-level'), 'battery_terminal_condition' => $this->input->post('battery-terminal-condition')
					);
					if(array_filter($dsr_generator_data)){
						$dsr_generator_data['id'] = $dsr_update_data[0]['id'];
						$table = 'dsr_generator_log';	$data = $dsr_generator_data;
						$data_dsr_doc = $this->dsr_model->insert_dsr($table, $data);
					}
					

					$section = 0;
					foreach($edit['north'] as $north){
						$section++;
						$dsr_lane_data['dsr_id'] = $dsr_update_data[0]['id'];
						$dsr_lane_data['toolplaza_id'] = $tool;
						$dsr_lane_data['lane_id'] = $north['id'];
						$dsr_lane_data['bound'] = 'N';
						$dsr_lane_data['lane_status'] = $this->input->post('nlanestatus'.$section);
						$dsr_lane_data['lane_closed'] = $this->input->post('nlclosed'.$section);
						$dsr_lane_data['lane_closed_from'] = $this->input->post('nlclosed_from'.$section);
						$dsr_lane_data['lane_closed_to'] = $this->input->post('nlclosed_to'.$section);
						$dsr_lane_data['lane_closed_description'] = $this->input->post('nlclosed_description'.$section);
						$dsr_lane_data['lane_camera_status'] = $this->input->post('ncstatus'.$section);
						$dsr_lane_data['lane_camera_faulty_description'] = $this->input->post('nfc_desc'.$section);
						$dsr_lane_data['inventory_ohls_status'] = $this->input->post('nohlsstatus'.$section);
						$dsr_lane_data['inventory_boom_arm_status'] = $this->input->post('nboomarmstatus'.$section);
						$dsr_lane_data['inventory_boom_mechanical_status'] = $this->input->post('nboommechstatus'.$section);
						$dsr_lane_data['inventory_thermal_printer_status'] = $this->input->post('ntprinterstatus'.$section);
						$dsr_lane_data['inventory_tct_status'] = $this->input->post('ntctstatus'.$section);
						$dsr_lane_data['inventory_lanepc_status'] = $this->input->post('nlanepcstatus'.$section);
						$dsr_lane_data['inventory_traffic_light_status'] = $this->input->post('ntlightstatus'.$section);
						$dsr_lane_data['inventory_pfd_status'] = $this->input->post('npfdstatus'.$section);
						$dsr_lane_data['inventory_ohls_description'] = $this->input->post('nohlsdesc'.$section);
						$dsr_lane_data['inventory_boom_arm_description'] = $this->input->post('nboomarmdesc'.$section);
						$dsr_lane_data['inventory_boom_mechanical_description'] = $this->input->post('nboommechdesc'.$section);
						$dsr_lane_data['inventory_thermal_printer_description'] = $this->input->post('ntprinterdesc'.$section);
						$dsr_lane_data['inventory_tct_description'] = $this->input->post('ntctdesc'.$section);
						$dsr_lane_data['inventory_lanepc_description'] = $this->input->post('nlanepcdesc'.$section);
						$dsr_lane_data['inventory_traffic_light_description'] = $this->input->post('ntlightdesc'.$section);
						$dsr_lane_data['inventory_pfd_description'] = $this->input->post('npfddesc'.$section);
						$table = 'dsr_lane';	$data = $dsr_lane_data;
						$data_dsr_lane = $this->dsr_model->insert_dsr($table, $data);
					}
					$section = 0;
					foreach($edit['south'] as $south){
						$section++;
						$dsr_lane_data['dsr_id'] = $dsr_update_data[0]['id'];

						$dsr_lane_data['lane_id'] = $south['id'];
						$dsr_lane_data['toolplaza_id'] = $tool;
						$dsr_lane_data['bound'] = 'S';
						$dsr_lane_data['lane_status'] = $this->input->post('slanestatus'.$section);
						$dsr_lane_data['lane_closed'] = $this->input->post('slclosed'.$section);
						$dsr_lane_data['lane_closed_from'] = $this->input->post('slclosed_from'.$section);
						$dsr_lane_data['lane_closed_to'] = $this->input->post('slclosed_to'.$section);
						$dsr_lane_data['lane_closed_description'] = $this->input->post('slclosed_description'.$section);
						$dsr_lane_data['lane_camera_status'] = $this->input->post('scstatus'.$section);
						$dsr_lane_data['lane_camera_faulty_description'] = $this->input->post('sfc_desc'.$section);
						$dsr_lane_data['inventory_ohls_status'] = $this->input->post('sohlsstatus'.$section);
						$dsr_lane_data['inventory_boom_arm_status'] = $this->input->post('sboomarmstatus'.$section);
						$dsr_lane_data['inventory_boom_mechanical_status'] = $this->input->post('sboommechstatus'.$section);
						$dsr_lane_data['inventory_thermal_printer_status'] = $this->input->post('stprinterstatus'.$section);
						$dsr_lane_data['inventory_tct_status'] = $this->input->post('stctstatus'.$section);
						$dsr_lane_data['inventory_lanepc_status'] = $this->input->post('slanepcstatus'.$section);
						$dsr_lane_data['inventory_traffic_light_status'] = $this->input->post('stlightstatus'.$section);
						$dsr_lane_data['inventory_pfd_status'] = $this->input->post('spfdstatus'.$section);
						$dsr_lane_data['inventory_ohls_description'] = $this->input->post('sohlsdesc'.$section);
						$dsr_lane_data['inventory_boom_arm_description'] = $this->input->post('sboomarmdesc'.$section);
						$dsr_lane_data['inventory_boom_mechanical_description'] = $this->input->post('sboommechdesc'.$section);
						$dsr_lane_data['inventory_thermal_printer_description'] = $this->input->post('stprinterdesc'.$section);
						$dsr_lane_data['inventory_tct_description'] = $this->input->post('stctdesc'.$section);
						$dsr_lane_data['inventory_lanepc_description'] = $this->input->post('slanepcdesc'.$section);
						$dsr_lane_data['inventory_traffic_light_description'] = $this->input->post('stlightdesc'.$section);
						$dsr_lane_data['inventory_pfd_description'] = $this->input->post('spfddesc'.$section);
						$table = 'dsr_lane';	$data = $dsr_lane_data;
						$data_dsr_lane = $this->dsr_model->insert_dsr($table, $data);
					}
					$as = 0;
					foreach($edit['staff'] as $staff){
						$as++;
						$dsr_attendance_data['dsr_id'] = $dsr_update_data[0]['id'];
						$dsr_attendance_data['staff_id'] = $staff['id'];
						$dsr_attendance_data['attendance_status'] = $this->input->post('as'.$as.'status');
						$dsr_attendance_data['leave_from'] = $this->input->post('as'.$as.'holidayfrom');
						$dsr_attendance_data['leave_to'] = $this->input->post('as'.$as.'holidayto');

						$table = 'dsr_attendance';	$data = $dsr_attendance_data;
						$data_dsr_attendance = $this->dsr_model->insert_dsr($table, $data);
					}
					if(!empty($dsr_updated_data) && !empty($dsr_status_data) && !empty($dsr_doc_data)  && !empty($dsr_lane_data)   && !empty($dsr_attendance_data)){	
						//echo json_encode(array('response' => TRUE , 'message' => 'Added Successfully'));
						echo json_encode(array('response' => TRUE , 'message' => 'Added Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/dsr'));
						//$datadsr = $this->db->insert('dsr', $dsrdata);
					}
					else{
						echo json_encode(array('response' => FALSE, 'message' => 'Input Error'));
					}
				}
			}
		}
		elseif($para1 == 'do_update'){	
			/*?> <pre><?php echo print_r($_POST); exit; */
			$page = 'U';
			$this->load->library('form_validation');
			$data = $this->dsr_model->sitereport_data_preload($id, $tool, $page, $para2);
			$edit = $data;			
			if ($edit['dsr_updated_check']){
				$counter = 0;
				foreach($edit['north'] as $n){	
					$counter++; $section = $counter; 

					$this->form_validation->set_rules('nlane'.$section, 'North Lane '.$n['name'],'trim|required');
					$this->form_validation->set_rules('nlanestatus'.$section, 'North Lane Status'.$section, 'trim|required');
					$this->form_validation->set_rules('ncamera'.$section, 'North Camera '.$n['name'], 'trim|required');
					$this->form_validation->set_rules('nohlsstatus'.$section, 'North OHLS '.$n['name'], 'trim|required');
					$this->form_validation->set_rules('nboomarmstatus'.$section, 'North Boom ARM '.$n['name'], 'trim|required');
					$this->form_validation->set_rules('nboommechstatus'.$section, 'North Boom Mech '.$n['name'], 'trim|required');
					$this->form_validation->set_rules('ntprinterstatus'.$section, 'North Thermal Printer '.$n['name'], 'trim|required');
					$this->form_validation->set_rules('ntctstatus'.$section, 'North TCT '.$n['name'], 'trim|required');
					$this->form_validation->set_rules('nlanepcstatus'.$section, 'North Lane PC '.$n['name'], 'trim|required');
					$this->form_validation->set_rules('ntlightstatus'.$section, 'North Traffic Light '.$n['name'], 'trim|required');
					$this->form_validation->set_rules('npfdstatus'.$section, 'North PFD '.$n['name'], 'trim|required');
				}
				$counter = 0;
				foreach($edit['south'] as $s){	
				$counter++; $section = $counter; 

					$this->form_validation->set_rules('slane'.$section, 'Lane '.$s['name'],'trim|required');
					$this->form_validation->set_rules('slanestatus'.$section, 'South Lane Status'.$section, 'trim|required');
					$this->form_validation->set_rules('scamera'.$section, 'South Camera '.$s['name'], 'trim|required');
					$this->form_validation->set_rules('sohlsstatus'.$section, 'South OHLS '.$s['name'], 'trim|required');
					$this->form_validation->set_rules('sboomarmstatus'.$section, 'South Boom ARM '.$s['name'], 'trim|required');
					$this->form_validation->set_rules('sboommechstatus'.$section, 'South Boom Mech '.$s['name'], 'trim|required');
					$this->form_validation->set_rules('stprinterstatus'.$section, 'South Thermal Printer '.$s['name'], 'trim|required');
					$this->form_validation->set_rules('stctstatus'.$section, 'South TCT '.$s['name'], 'trim|required');
					$this->form_validation->set_rules('slanepcstatus'.$section, 'South Lane PC '.$s['name'], 'trim|required');
					$this->form_validation->set_rules('stlightstatus'.$section, 'South Traffic Light '.$s['name'], 'trim|required');
					$this->form_validation->set_rules('spfdstatus'.$section, 'South PFD '.$s['name'], 'trim|required');
				}
				$this->form_validation->set_rules('datecreated', 'Date', 'trim|required');
				$this->form_validation->set_rules('omc', 'OMC','trim|required');
				$this->form_validation->set_rules('site_lsdu', 'LSDU Status','trim|required');
				$this->form_validation->set_rules('site_dt', 'Daily Traffic ','trim|required');
				$this->form_validation->set_rules('site_dr', 'Daily Revenue','trim|required');
				$this->form_validation->set_rules('frame', 'Frame Grabber Status','trim|required');
				$this->form_validation->set_rules('image', 'Image Status','trim|required');
				$this->form_validation->set_rules('shutdown', 'ShutDown Status','trim|required');
				$this->form_validation->set_rules('mtrstatus', 'MTR Status','trim|required');
				$this->form_validation->set_rules('apmtr', 'Pending MTR','trim|required');
				$this->form_validation->set_rules('asmtr', 'Archiving Status','trim|required');
				$this->form_validation->set_rules('mtrupto', 'MTR UPTO ','trim|required');
				$this->form_validation->set_rules('serverstatus', 'Server Status','trim|required');
				$this->form_validation->set_rules('linkissue', 'Link Issue','trim|required');	
				$this->form_validation->set_rules('pcelectricity', 'Electricity Condition','trim|required');
				$this->form_validation->set_rules('pcbuilding', 'Building Condition','trim|required');
				$this->form_validation->set_rules('pccleaning', 'Cleanliness Condition','trim|required');
				$this->form_validation->set_rules('pcreceipts', 'Receipts Condition','trim|required');
				$this->form_validation->set_rules('pcwater', 'Water Condition','trim|required');
				$this->form_validation->set_rules('pcmeal', 'Meal Condition','trim|required');
				$this->form_validation->set_rules('pcqueuing', 'Queuing Condition','trim|required');
				$this->form_validation->set_rules('asrg', 'Support Request','trim|required');

				if($this->form_validation->run() == FALSE)
				{
					echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
				}
				else
				{					
					$dsr_updated_data = array();
					
					$dsr_updated_data['toolplaza_id'] = $tool;
					$dsr_updated_data['supervisor_id'] = $id;
					date_default_timezone_set('Asia/Karachi');
					$dsr_updated_data['datecreated'] =  date('Y-m-d',strtotime($this->input->post('datecreated')));
					$dsr_updated_data['updated_at'] = time();				
					$dsr_updated_data['omc'] = $this->input->post('omc');
					$dsr_updated_data['daily_traffic'] = $this->input->post('site_dt');
					$dsr_updated_data['daily_revenue'] = $this->input->post('site_dr');

					$dsr_updated_data['ptz_north_status']	=	$this->input->post('ptzstatus1');
					$dsr_updated_data['ptz_north_description']	=	$this->input->post('ptzfc_desc1');
					$dsr_updated_data['ptz_south_status']	=	$this->input->post('ptzstatus2');
					$dsr_updated_data['ptz_south_description']	=	$this->input->post('ptzfc_desc2');
					
					$where = 'id'; $table = 'dsr_updated'; $data = $dsr_updated_data;
					$upd_updated = $this->dsr_model->update_dsr($where, $para2, $table, $data);
					
					$dsr_status_data = array();
					
					$dsr_status_data['status_lsdu'] = $this->input->post('site_lsdu');
					$dsr_status_data['status_framegrabber'] = $this->input->post('frame');
					$dsr_status_data['status_server'] = $this->input->post('serverstatus');
					$dsr_status_data['status_shutdown'] = $this->input->post('shutdown');
					$dsr_status_data['time_shut_from'] = $this->input->post('shut_from');
					$dsr_status_data['time_shut_to'] = $this->input->post('shut_to');
					$dsr_status_data['status_link'] = $this->input->post('linkissue');
					$dsr_status_data['status_link_description'] = $this->input->post('lissue_desc');
					$dsr_status_data['status_building'] = $this->input->post('pcbuilding');
					$dsr_status_data['status_cleaning'] = $this->input->post('pccleaning');
					$dsr_status_data['status_reciepts'] = $this->input->post('pcreceipts');
					$dsr_status_data['status_water'] = $this->input->post('pcwater');
					$dsr_status_data['status_meal'] = $this->input->post('pcmeal');

					$dsr_status_data['status_electricity'] = $this->input->post('pcelectricity');
					$dsr_status_data['faulty_electricity_cause'] = $this->input->post('pcelectricity');
					$dsr_status_data['faulty_electricity_reason'] = $this->input->post('ereason');
					$dsr_status_data['status_queuing'] = $this->input->post('pcqueuing');
					
					$where = 'id'; $table = 'dsr_status'; $data = $dsr_status_data;
					$upd_status = $this->dsr_model->update_dsr($where, $para2, $table, $data);
					
					$dsr_doc_data['image_status'] = $this->input->post('image');
					$dsr_doc_data['mtr_status'] = $this->input->post('mtrstatus');

					$dsr_doc_data['mtr_pending'] = $this->input->post('apmtr');
					$dsr_doc_data['mtr_archiving_status'] = $this->input->post('asmtr');

					$dsr_doc_data['mtr_upto'] = $this->input->post('mtrupto');
					$dsr_doc_data['asrg'] = $this->input->post('asrg');
					$dsr_doc_data['asrg_reference_no'] = $this->input->post('refno');
					$dsr_doc_data['asrg_date'] = $this->input->post('refduration');
					$dsr_doc_data['asrg_detail'] = $this->input->post('request_detail');

					$where = 'id'; $table = 'dsr_doc'; $data = $dsr_doc_data;
					$upd_doc = $this->dsr_model->update_dsr($where, $para2, $table, $data);
					
					$dsr_generator_data = array(
						'load_from' => $this->input->post('load-from'), 'load_to' => $this->input->post('load-to'), 'load_time' => $this->input->post('load-time'), 'generator_from' => $this->input->post('generator-from'), 'generator_to' => $this->input->post('generator-to'), 'generator_time' => $this->input->post('generator-time'), 'diesel_per_hour' => $this->input->post('diesel-per-hour'), 'diesel_consumed' => $this->input->post('diesel-consumed'), 'output_voltage' => $this->input->post('output-voltage'), 'fuel_level' => $this->input->post('fuel-level'), 'oil_level' => $this->input->post('oil-level'), 'oil_change' => $this->input->post('oil-change'), 'radiator_water_level' => $this->input->post('radiator-water-level'), 'battery_water_level' => $this->input->post('battery-water-level'), 'battery_terminal_condition' => $this->input->post('battery-terminal-condition')
					);
					$where = 'id'; $table = 'dsr_generator_log'; $data = $dsr_generator_data;
					$upd_doc = $this->dsr_model->update_dsr($where, $para2, $table, $data);
					
					$table = 'dsr_updated'; $order_by = 'updated_at';
					$dsr_update_data = $this->dsr_model->retrieve_last($table, $order_by);
					
					$section = 0;
					foreach($edit['north'] as $north){
						$section++;
						$dsr_lane_data['lane_status'] = $this->input->post('nlanestatus'.$section);
						$dsr_lane_data['lane_closed'] = $this->input->post('nlclosed'.$section);
						$dsr_lane_data['lane_closed_from'] = $this->input->post('nlclosed_from'.$section);
						$dsr_lane_data['lane_closed_to'] = $this->input->post('nlclosed_to'.$section);
						$dsr_lane_data['lane_closed_description'] = $this->input->post('nlclosed_description'.$section);
						$dsr_lane_data['lane_camera_status'] = $this->input->post('ncstatus'.$section);
						$dsr_lane_data['lane_camera_faulty_description'] = $this->input->post('nfc_desc'.$section);
						$dsr_lane_data['inventory_ohls_status'] = $this->input->post('nohlsstatus'.$section);
						$dsr_lane_data['inventory_boom_arm_status'] = $this->input->post('nboomarmstatus'.$section);
						$dsr_lane_data['inventory_boom_mechanical_status'] = $this->input->post('nboommechstatus'.$section);
						$dsr_lane_data['inventory_thermal_printer_status'] = $this->input->post('ntprinterstatus'.$section);
						$dsr_lane_data['inventory_tct_status'] = $this->input->post('ntctstatus'.$section);
						$dsr_lane_data['inventory_lanepc_status'] = $this->input->post('nlanepcstatus'.$section);
						$dsr_lane_data['inventory_traffic_light_status'] = $this->input->post('ntlightstatus'.$section);
						$dsr_lane_data['inventory_pfd_status'] = $this->input->post('npfdstatus'.$section);
						$dsr_lane_data['inventory_ohls_description'] = $this->input->post('nohlsdesc'.$section);
						$dsr_lane_data['inventory_boom_arm_description'] = $this->input->post('nboomarmdesc'.$section);
						$dsr_lane_data['inventory_boom_mechanical_description'] = $this->input->post('nboommechdesc'.$section);
						$dsr_lane_data['inventory_thermal_printer_description'] = $this->input->post('ntprinterdesc'.$section);
						$dsr_lane_data['inventory_tct_description'] = $this->input->post('ntctdesc'.$section);
						$dsr_lane_data['inventory_lanepc_description'] = $this->input->post('nlanepcdesc'.$section);
						$dsr_lane_data['inventory_traffic_light_description'] = $this->input->post('ntlightdesc'.$section);
						$dsr_lane_data['inventory_pfd_description'] = $this->input->post('npfddesc'.$section);
						$where = array('dsr_id' => $para2, 'lane_id' => $north['id']); 
						$table = 'dsr_lane'; $data = $dsr_lane_data;
						$upd_lane['N'] = $this->dsr_model->loop_update_dsr($where, $table, $data);
					}
					$section = 0;
					foreach($edit['south'] as $south){
						$section++;
						
						$dsr_lane_data['lane_status'] = $this->input->post('slanestatus'.$section);
						$dsr_lane_data['lane_closed'] = $this->input->post('slclosed'.$section);
						$dsr_lane_data['lane_closed_from'] = $this->input->post('slclosed_from'.$section);
						$dsr_lane_data['lane_closed_to'] = $this->input->post('slclosed_to'.$section);
						$dsr_lane_data['lane_closed_description'] = $this->input->post('slclosed_description'.$section);
						$dsr_lane_data['lane_camera_status'] = $this->input->post('scstatus'.$section);
						$dsr_lane_data['lane_camera_faulty_description'] = $this->input->post('sfc_desc'.$section);
						$dsr_lane_data['inventory_ohls_status'] = $this->input->post('sohlsstatus'.$section);
						$dsr_lane_data['inventory_boom_arm_status'] = $this->input->post('sboomarmstatus'.$section);
						$dsr_lane_data['inventory_boom_mechanical_status'] = $this->input->post('sboommechstatus'.$section);
						$dsr_lane_data['inventory_thermal_printer_status'] = $this->input->post('stprinterstatus'.$section);
						$dsr_lane_data['inventory_tct_status'] = $this->input->post('stctstatus'.$section);
						$dsr_lane_data['inventory_lanepc_status'] = $this->input->post('slanepcstatus'.$section);
						$dsr_lane_data['inventory_traffic_light_status'] = $this->input->post('stlightstatus'.$section);
						$dsr_lane_data['inventory_pfd_status'] = $this->input->post('spfdstatus'.$section);
						$dsr_lane_data['inventory_ohls_description'] = $this->input->post('sohlsdesc'.$section);
						$dsr_lane_data['inventory_boom_arm_description'] = $this->input->post('sboomarmdesc'.$section);
						$dsr_lane_data['inventory_boom_mechanical_description'] = $this->input->post('sboommechdesc'.$section);
						$dsr_lane_data['inventory_thermal_printer_description'] = $this->input->post('stprinterdesc'.$section);
						$dsr_lane_data['inventory_tct_description'] = $this->input->post('stctdesc'.$section);
						$dsr_lane_data['inventory_lanepc_description'] = $this->input->post('slanepcdesc'.$section);
						$dsr_lane_data['inventory_traffic_light_description'] = $this->input->post('stlightdesc'.$section);
						$dsr_lane_data['inventory_pfd_description'] = $this->input->post('spfddesc'.$section);
						
						$where = array('dsr_id' => $para2, 'lane_id' => $south['id']); 
						$table = 'dsr_lane'; $data = $dsr_lane_data;
						$upd_lane['N'] = $this->dsr_model->loop_update_dsr($where, $table, $data);
						
					}
					$as = 0;
					foreach($edit['staff'] as $staff){
						$as++;
						$dsr_attendance_data['attendance_status'] = $this->input->post('as'.$as.'status');
						$dsr_attendance_data['leave_from'] = $this->input->post('as'.$as.'holidayfrom');
						$dsr_attendance_data['leave_to'] = $this->input->post('as'.$as.'holidayto');
						
						$where = array('dsr_id' => $para2, 'staff_id' => $staff['staff_id']); 
						$table = 'dsr_attendance'; $data = $dsr_attendance_data;
						$upd_attendance = $this->dsr_model->loop_update_dsr($where, $table, $data);
					}
					if(empty($upd_updated) && empty($upd_status) && empty($upd_doc) && empty($upd_lane['N']) && empty($upd_lane['S']) && empty($upd_attendance)){
						echo json_encode(array('response' => FALSE, 'message' => 'Input Error'));exit;
					}
					else{
						echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/dsr'));	
					}

				}
			}else{
				echo json_encode(array('response' => FALSE , 'message' =>  "Invalid Request")); exit;
			}
		}
		elseif($para1 == 'view'){
			$this->load->view('front/toolplaza/sitereport', $this->page_data);

		}
		elseif($para1 == 'view_reason'){
			$reason = $this->db->get_where('dsr_updated',array('id' => $para2))->result_array();
			if($reason[0]['status'] == 2){
				echo "<span class='text-info'>".$reason[0]['disapprove_reason']."</span>";
			}
			else{
				echo "<span class='text-danger'>Invalid Request</span>";
			}	
		}
		else{

			$this->page_data['page_name'] = 'dsr';
			$this->load->view('front/toolplaza/dsr', $this->page_data);	
		}
	}
	public function daily_site_report($para1 = ''){
		$id = $this->session->userdata['supervisor_id'];
		$tool =  $this->session->userdata('toolplaza');
		$page = 'R'; //CRUD Read
		//Some data is loaded to run data into dsr variable like Staff, north, south from dsr_lane, and dsr staff tables
		$preload_data =$this->dsr_model->sitereport_data_preload($id, $tool, $page, $para1);
		$edit = $preload_data;		
		//data is loaded into dsr variable where new layout data is converted to old layout data so that it can be merged easily with older work 
		$data = $this->dsr_model->dsr_data($id, $tool, $edit,$para1);
		$edit['dsr'] = $data['dsr'];
		$edit['dsr_staff'] = $data['dsr_staff'];
		//Some data is loaded from dsr variable
		$data = $this->dsr_model->sitereport_data_post($edit);	
		$edit = $data; $edit['toolplaza_id'] = $tool; 
		/*?> <pre><?php echo print_r($edit); exit;*/
		
		$this->load->view('front/toolplaza/sitereport', $edit);
	}
	
	
////////////////////////////////////////////////////////////////
///////////////faulty equipment list///////////////////////////
//////////////////////////////////////////////////////////////
	public function faulty_equipment_list($para1 = '' , $para2 = '', $para3 = ''){
		if($para1 == 'list'){
			$this->db->order_by('id','DESC');
			$this->db->where('user', $this->session->userdata('supervisor_id'));
			$this->page_data['faulty'] = $this->db->get('faulty_equip')->result_array();
			$this->load->view('front/toolplaza/faulty_list', $this->page_data);
		}elseif($para1 == 'delete'){
			$this->db->where('id',$para2);
			$this->db->where('user',$this->session->userdata('supervisor_id'));
			$this->db->where('status !=', 1, FALSE);
			$record = $this->db->get('faulty_equip');
			if($record->result_array()){
				$file = $this->db->get_where('faulty_equip',array('id' => $para2))->row()->file;
				unlink('./uploads/faulty/'.$file);
				$this->db->where('id', $para2);
				$this->db->delete('faulty_equip');
			}
			
		}elseif($para1 == 'add'){
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('id' => $this->session->userdata('toolplaza')))->row()->name;
			$this->page_data['location'] = $this->db->get('location')->result_array();
			//echo "<pre>";
			//print_r($this->page_data); exit;
			$this->load->view('front/toolplaza/faulty_add' , $this->page_data);

		}elseif($para1 == 'edit'){
			$this->page_data['location'] = $this->db->get('location')->result_array();
			$this->page_data['faulty'] = $this->db->get_where('faulty_equip',array('id' => $para2, 'user' => $this->session->userdata('supervisor_id')))->result_array();
			if($this->page_data['faulty']){
				if($this->page_data['mtr'][0]['status'] == 1 || $this->page_data['mtr'][0]['user'] != $this->session->userdata('supervisor_id')){
					echo "<span class='text-danger'>Invalid Request</span>"; exit;
				}	
			}else{
				echo "<span class='text-danger'>Invalid Request</span>"; exit;
			}
			
			$this->load->view('front/toolplaza/faulty_edit', $this->page_data);
		}elseif($para1 == 'do_add'){
			//echo "<pre>";
			//print_r($_POST);
			$questions = $this->input->post('questions');
			$contents = array();
			foreach($questions as $key1 => $value){
				$contents[$key1]['location'] = $this->input->post('location_'.$value);
				$contents[$key1]['equip_name'] = $this->input->post('equip_name_'.$value);
				if($this->input->post('quantity_'.$value) < 0 || $this->input->post('price_'.$value) < 0 ){
					echo json_encode(array('response'=>FALSE, 'message'=>'Negative Values Not Allowed')); exit;
				}
				$contents[$key1]['quantity'] = $this->input->post('quantity_'.$value);
				$contents[$key1]['price'] = $this->input->post('price_'.$value);
			
			
			}
			

			if (empty($_FILES['faulty_file']['name'])) {
				echo json_encode(array('response' => FALSE , 'message' => 'Please upload a valid file')); exit;	
			}

				$config['upload_path'] = './uploads/temp';
				$config['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
				$config['overwrite'] = TRUE;
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('faulty_file')){
					echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
				}


				$data = array();
				$data['tollplaza'] 	= 	$this->session->userdata('toolplaza');
				$data['user'] 			= 	$this->session->userdata('supervisor_id');
				$data['contents'] 		= 	json_encode($contents);
				$data['omc'] 			= 	$this->input->post('omc');
				$data['date'] 			= 	time();

				$this->db->insert('faulty_equip', $data);
				$insert_id = $this->db->insert_id();
				//echo  $insert_id; exit;
				$filename = $_FILES["faulty_file"]["name"];

				$ext = @end((explode(".", $filename)));
				$file_new_name = 'faulty'.$insert_id.'_'.$this->session->userdata('toolplaza').'_'.$this->session->userdata('supervisor_id').'.'.$ext;
				$config1['upload_path'] = './uploads/faulty';
				$config1['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
				$config1['overwrite'] = TRUE;
				$config1['file_name']	=	$file_new_name;
				//$this->load->library('upload', $config);
				 $this->upload->initialize($config1);
				if ( ! $this->upload->do_upload('faulty_file'))
		        {
		           echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
		        }
		        else
		        {
		        	$update['file'] = $file_new_name;
		        	$this->db->where('id', $insert_id);
		        	$this->db->update('faulty_equip',$update);
		         	$this->load->helper('file');
		         	delete_files('./uploads/temp');
		         	echo json_encode(array('response' => TRUE , 'message' => 'Added Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/faulty_equipment_list'));
		        }

			
		}elseif($para1 == 'do_update'){
			$check = $this->db->get_where('mtr',array('id' => $para2 , 'user_id' => $this->session->userdata('supervisor_id'), 'status' => 0))->result_array();
			if($check){
					$this->load->library('form_validation');
					$this->form_validation->set_rules('for_month','Valid Month And Year','required|trim');
					$this->form_validation->set_rules('description','Description','required|trim');
					$this->form_validation->set_rules('notes','Notes','required|trim');
					$this->form_validation->set_rules('class1','Class 1 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class2','Class 2 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class3','Class 3 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class4','Class 4 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class5','Class 5 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class6','Class 6 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class7','Class 7 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class8','Class 8 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class9','Class 9 Passess','required|trim|is_natural');
					$this->form_validation->set_rules('class10','Class 10 Passess','required|trim|is_natural');
					if($this->form_validation->run() == FALSE){
						echo json_encode(array('response' => FALSE , 'message' => validation_errors()));exit;
					}else{
						$check_month = $this->db->get_where('mtr',array('for_month' => $this->input->post('for_month'), 'toolplaza' => $this->session->userdata('toolplaza')))->result_array();
						if($check_month){
							echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;			
						}
						if (!empty($_FILES['mtr_file']['name'])) {
								$config['upload_path'] = './uploads/temp';
								$config['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
								$config['overwrite'] = TRUE;
								$this->load->library('upload', $config);
								if ( ! $this->upload->do_upload('mtr_file')){
									echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
								}
						}

						$data['user_id'] 		= 	$this->session->userdata('supervisor_id');
						$data['toolplaza']  	= 	$this->session->userdata('toolplaza');
						$data['description'] 	= 	$this->input->post('description');
						$data['notes'] 			= 	$this->input->post('notes');
						$data['class1'] 		= 	$this->input->post('class1');
						$data['class2'] 		= 	$this->input->post('class2');
						$data['class3'] 		= 	$this->input->post('class3');
						$data['class4'] 		= 	$this->input->post('class4');
						$data['class5'] 		= 	$this->input->post('class5');
						$data['class6'] 		= 	$this->input->post('class6');
						$data['class7'] 		= 	$this->input->post('class7');
						$data['class8'] 		= 	$this->input->post('class8');
						$data['class9'] 		= 	$this->input->post('class9');
						$data['class10'] 		= 	$this->input->post('class10');
						$data['for_month']  	= 	$this->input->post('for_month');
						$data['total']      	= 	$this->input->post('class1') + $this->input->post('class2') + $this->input->post('class3') + $this->input->post('class4') + $this->input->post('class5') + $this->input->post('class6') + $this->input->post('class7') + $this->input->post('class8') + $this->input->post('class9') + $this->input->post('class10');
						$data['adddate']		=	time();
						$this->db->where('id', $para2);
						$this->db->update('mtr', $data);
						
						if (!empty($_FILES['mtr_file']['name'])) {
						$filename = $_FILES["mtr_file"]["name"];

						$ext = @end((explode(".", $filename)));
						$file_new_name = 'mtr'.$para2.'_'.str_replace('/', '-',$this->input->post('for_month')).'.'.$ext;
						$config1['upload_path'] = './uploads/mtr';
						$config1['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
						$config1['overwrite'] = TRUE;
						$config1['file_name']	=	$file_new_name;
						//$this->load->library('upload', $config);
						 $this->upload->initialize($config1);
						if ( ! $this->upload->do_upload('mtr_file'))
				        {
				           echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
				        }
				        else
				        {
				        	$update['file'] = $file_new_name;
				        	$this->db->where('id', $para2);
				        	$this->db->update('mtr',$update);
				         	$this->load->helper('file');
				         	delete_files('./uploads/temp');
				         	echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'toolplaza/mtr'));
				        }
				    }
				}


			}else{
				echo json_encode(array('response' => FALSE , 'message' => "Invalid Request")); exit;
			}
			
		}elseif($para1 == 'view'){
			$this->load->view('front/toolplaza/invoice', $this->page_data);

		}else{
			$this->page_data['location'] = $this->db->get('location')->result_array();
			$this->page_data['page_name'] = 'faulty';
			$this->load->view('front/toolplaza/faulty', $this->page_data);	
		}
		
	}

	///////////////////////////////////////////////////////////////
	////	/** Notification START  *////////////////////
	///////////////////////////////////////////////////////////////

	public function notify_counter($para1 = ''){	
		$this->db->where('for_user_type',1);
		$this->db->where('for_user_id',$this->session->userdata('supervisor_id'));
		$this->db->where('user_type',3);
		$this->db->where('is_read',0);
		$this->db->order_by("id", "desc");
		$this->db->limit(4);
		$disapprovedMtrs = $this->db->get('notifications')->result_array();
		//echo $this->db->last_query(); exit;
               
                  if(!empty($disapprovedMtrs))
                  {
                    $notifyCounter = 0;
                    foreach($disapprovedMtrs as $row)
                    {
                      
                      $notifyCounter++;
					}
				}
				if(!empty($disapprovedMtrs))
                    { 
                      if($notifyCounter>3)
                      {
                       echo "3+"; 
                      }
                      else
                      {
                        echo $notifyCounter ;
                      }
                    }
	}
	public function notify_msg($para1 = ''){
		// $firstname = 'a';
        // $lastname = 'b';
        // $customer_mobile = 'd';
        // $this->db->select('*')->from('users')
        // ->group_start()
        //           ->where('a', $firstname)
        //           ->where('b', $lastname)
        //           ->where('c', '1')
        //           ->or_group_start()
        //                   ->where('d', $customer_mobile)
        //                   ->where('e', '1')
        //           ->group_end()
        //   ->group_end()
        // ->get();
	//    echo $this->db->last_query();
	    $this->db->where('for_user_type',1);
		$this->db->where('for_user_id',$this->session->userdata('supervisor_id'));
		$this->db->where('user_type',3);
		$this->db->order_by("id", "desc");
		$this->db->limit(3);
		$this->page_data['notifications'] = $this->db->get('notifications')->result();
		
		
		//echo "<pre>";
		//print_r($this->page_data['notifications']); exit;
		//echo $this->db->last_query(); exit;
		$this->load->view('front/toolplaza/notify_msg', $this->page_data);		
	}
	public function delete_notification($para1 = '' ){
		$this->db->where('id', $this->input->post('id'));
		$this->db->delete('notifications');
		return redirect('toolplaza/notify_msg/');	
	}


	public function traffic_counting($para1 = '', $para2 =''){
		if($para1 == 'list')
		{
			$this->db->order_by('id','DESC');
			$this->page_data['counter']  = $this->db->get('traffic_counter')->result_array();
			$this->load->view('front/toolplaza/traffic_counter_list', $this->page_data);
		}
		elseif($para1 == 'session_start')
		{
			$check = $this->db->get_where('traffic_counter', array('id' => $para2))->result_array();
			$this->page_data['error'] = '';
			if($check[0]['video_end_date']){
				$this->page_data['error'] = "You can't reopen a completed session";
			}
			$update_data['comment']= $this->input->post('comment');
			$this->page_data['session_data'] = $this->db->get_where('traffic_counter',array('id' => $para2))->result_array();
			$this->page_data['insert_id'] = $para2;
			$this->page_data['page_name'] = 'traffic_counting';
			$useragent=$_SERVER['HTTP_USER_AGENT'];

			if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)|| preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)) || preg_match('#\b(ipad|tablet|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] ))
			{
				$this->load->view('front/toolplaza/traffic_counter_session_mobile', $this->page_data); 

			}else{
				$this->load->view('front/toolplaza/traffic_counter_session', $this->page_data); 

			}
			

			
		}elseif($para1 == 'view'){
			$this->page_data['session'] = $this->db->get_where('traffic_counter', array('id' => $para2))->result_array();
			$this->load->view('front/toolplaza/traffic_counter_details', $this->page_data);
		}
		elseif($para1 == 'do_add')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tollplaza',"Toll Plaza",'required');
			$this->form_validation->set_rules('for_month',"Date",'required');
			
			$this->form_validation->set_rules('timey',"Time",'required');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			
			}else{
				$datetime = strtotime(str_replace('/', '-', $this->input->post('for_month')).' '.$this->input->post('timey'));
				//$sql = "SELECT * FROM `traffic_counter` WHERE tollplaza = ".$this->input->post('tollplaza')." AND ".$datetime." between video_start_date and video_end_date";
				$sql = "SELECT * FROM `traffic_counter` WHERE tollplaza = ".$this->input->post('tollplaza')." AND direction = '".$this->input->post('direction')."' AND ".$datetime." between video_start_date and video_end_date";
				
				$result = $this->db->query($sql)->result_array();
				
				if($result){
					echo json_encode(array('response' => FALSE,'message' => 'Session of this date time already exists')); exit;
				}
				$insert_data = array();
				$insert_data['tollplaza'] = $this->input->post('tollplaza');
				$insert_data['direction'] = $this->input->post('direction');
				$insert_data['user_id'] = $this->session->userdata('supervisor_id');
				$insert_data['user_type'] = 3;
				$insert_data['video_start_date'] = $datetime;
				$insert_data['session_start_date'] = time();
				$this->db->insert('traffic_counter', $insert_data);
				$insert_id = $this->db->insert_id();

				echo json_encode(array('response' => TRUE, 'message' => "Session started", 'is_redirect' => TRUE, 'redirect_url' => base_url().'toolplaza/traffic_counting/session_start/'.$insert_id)); exit;
			}
		}else if($para1 == 'traffic_add'){

			$values = json_decode($this->input->post('result'));
			$session_id = $this->input->post('session');
			$data[$values[0]->key] = $values[0]->value;
			$this->db->where('id', $session_id);
			$this->db->update('traffic_counter', $data);
		}elseif($para1 == 'add'){
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('front/toolplaza/counter_add' , $this->page_data);
		}elseif($para1 == 'update'){
			$this->page_data['session_id'] = $para2;
			$this->load->view('front/toolplaza/counter_update' , $this->page_data);
		}elseif($para1 == 'do_update'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('end_date',"Video end date",'required');
			$this->form_validation->set_rules('end_time',"video end time",'required');
			
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			
			}else{
				$update_data = array();
				$session_id = $this->input->post('session_id');
				$video_start_date = $this->db->get_where('traffic_counter' , array('id' => $session_id))->row()->video_start_date;
				$datetime = strtotime(str_replace('/', '-', $this->input->post('end_date')).' '.$this->input->post('end_time'));
				if($datetime <= $video_start_date){
					echo json_encode(array('response' => FALSE, 'message' => 'Invalid date time')); exit;
				}
				$update_data['video_end_date'] = $datetime;
				$update_data['session_end_date'] = time();
				$this->db->where('id', $session_id);
				$this->db->update('traffic_counter', $update_data);

				echo json_encode(array('response' => TRUE, 'message' => "Session updated successfully", 'is_redirect' => TRUE, 'redirect_url' => base_url().'toolplaza/traffic_counting/')); exit;
			}
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('traffic_counter');	
		}else{
			$this->page_data['page_name'] = 'traffic_counting';
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('front/toolplaza/traffic_counter', $this->page_data);
		}
	}
	//This function is used to change the dd-mm-yyyy format of time and update dsr.created_at table 
	/*public function change_date_dsr(){
		$dsr = $this->db->order_by('id', 'ASC')->get('dsr')->result_array();
		$i = 0;
		foreach($dsr as $d){
			if($d){
				$date[$i]['datecreated'] = date('Y-m-d',$d['created_at']);
				$this->db->where('id', $d['id']);
				$this->db->update('dsr', $date[$i]);

			}

			$i++;
		}




		?><pre> <?php echo print_r($dsr); ?></pre> <?php
	}*/
	// public function data_transfer(){
	// 	$dsr = $this->db->order_by('id', 'ASC')->get('dsr')->result_array();
		
		
	// 	$i= 0;
		
	// 	foreach($dsr as $d){
			
	// 		$north = $this->db->get_where('tp_lanes', array('bound' => 'N', 'tollplaza' => $d['toolplaza_id']))->result_array();; 
	// 		$south = $this->db->get_where('tp_lanes', array('bound' => 'S', 'tollplaza' => $d['toolplaza_id']))->result_array();
	// 		$this->page_data['staff'] = $this->db->get_where('tpstaff', array('tollplaza' => $d['toolplaza_id']))->result_array();
	// 		//data array for dsr_updated table
			
	// 		$dsr_updated_data[$i]['created_at'] =$d['created_at'];
	// 		$dsr_updated_data[$i]['datecreated'] = $d['datecreated'];
	// 		$dsr_updated_data[$i]['toolplaza_id'] = $d['toolplaza_id'];
	// 		$dsr_updated_data[$i]['supervisor_id'] = $d['supervisor_id'];
	// 		$dsr_updated_data[$i]['omc'] = $d['omc'];
	// 		$dsr_updated_data[$i]['daily_traffic'] = $d['site_dt'];
	// 		$dsr_updated_data[$i]['daily_revenue'] = $d['site_dr'];
	// 		$dsr_updated_data[$i]['ptz_north_status'] = $d['ptzstatus1'];
	// 		$dsr_updated_data[$i]['ptz_north_description'] = $d['ptzfc_desc1'];
	// 		$dsr_updated_data[$i]['ptz_south_status'] = $d['ptzstatus2'];
	// 		$dsr_updated_data[$i]['ptz_south_description'] = $d['ptzfc_desc2'];
	// 		$dsr_updated_data[$i]['status'] = $d['status'];
	// 		$dsr_updated_data[$i]['disapprove_reason'] = $d['disapprove_reason'];
			
	// 		$this->db->limit(1);
	// 		$data_dsr_updated = $this->db->insert('dsr_updated',$dsr_updated_data[$i]);
	// 		$dsr_update_data = $this->db->limit(1)->order_by('id', 'DESC')->get('dsr_updated')->result_array();
			
	// 		//data array for dsr_status table
			
			
	// 		$dsr_status_data[$i]['status_lsdu'] = $d['site_lsdu'];
	// 		$dsr_status_data[$i]['status_framegrabber'] = $d['frame'];
	// 		$dsr_status_data[$i]['status_server'] = $d['serverstatus'];
	// 		$dsr_status_data[$i]['status_shutdown'] = $d['shutdown'];
	// 		$dsr_status_data[$i]['time_shut_from'] = $d['shut_from'];
	// 		$dsr_status_data[$i]['time_shut_to'] = $d['shut_to'];
	// 		$dsr_status_data[$i]['status_link'] = $d['linkissue'];
	// 		$dsr_status_data[$i]['status_link_description'] = $d['lissue_desc'];
	// 		$dsr_status_data[$i]['status_building'] = $d['pcbuilding'];
	// 		$dsr_status_data[$i]['status_cleaning'] = $d['pccleaning'];
	// 		$dsr_status_data[$i]['status_reciepts'] = $d['pcreceipts'];
	// 		$dsr_status_data[$i]['status_water'] = $d['pcwater'];
	// 		$dsr_status_data[$i]['status_meal'] = $d['pcmeal'];

	// 		$dsr_status_data[$i]['status_electricity'] = $d['pcelectricity'];
	// 		$dsr_status_data[$i]['faulty_electricity_cause'] = $d['pcelectricity'];
	// 		$dsr_status_data[$i]['faulty_electricity_reason'] = $d['ereason'];
	// 		$dsr_status_data[$i]['status_queuing'] = $d['pcqueuing'];
			
	// 		$this->db->limit(1);
	// 		$data_dsr_status = $this->db->insert('dsr_status',$dsr_status_data[$i]);
			
	// 		//data array for dsr_doc table
			
	// 		$dsr_doc_data[$i]['image_status'] = $d['image'];
	// 		$dsr_doc_data[$i]['mtr_status'] = $d['mtrstatus'];

	// 		$dsr_doc_data[$i]['mtr_pending'] = $d['apmtr'];
	// 		$dsr_doc_data[$i]['mtr_archiving_status'] = $d['asmtr'];

	// 		$dsr_doc_data[$i]['mtr_upto'] = $d['mtrupto'];
	// 		$dsr_doc_data[$i]['asrg'] = $d['asrg'];
	// 		$dsr_doc_data[$i]['asrg_reference_no'] = $d['refno'];
	// 		$dsr_doc_data[$i]['asrg_date'] = $d['refduration'];
			
	// 		$this->db->limit(1);
	// 		$data_dsr_doc = $this->db->insert('dsr_doc',$dsr_doc_data[$i]);
	// 		//data array for dsr_lane
	// 		$section = 0;
	// 		$l = 0;
	// 		foreach($north as $nort){
	// 			$section++;
	// 			$dsr_lane_data[$l]['dsr_id'] = $dsr_update_data[0]['id'];
	// 			$dsr_lane_data[$l]['lane_id'] = $nort['id'];
	// 			$dsr_lane_data[$l]['bound'] = $nort['bound'];
	// 			$dsr_lane_data[$l]['lane_status'] = $d['nlanestatus'.$section];
	// 			$dsr_lane_data[$l]['lane_closed'] = $d['nlclosed'.$section];
	// 			$dsr_lane_data[$l]['lane_closed_from'] = $d['nlclosed_from'.$section];
	// 			$dsr_lane_data[$l]['lane_closed_to'] = $d['nlclosed_to'.$section];
	// 			$dsr_lane_data[$l]['lane_closed_description'] = $d['nlclosed_description'.$section];
	// 			$dsr_lane_data[$l]['lane_camera_status'] = $d['ncstatus'.$section];
	// 			$dsr_lane_data[$l]['lane_camera_faulty_description'] = $d['nfc_desc'.$section];
				
	// 			$this->db->limit(1);
	// 			$data_dsr_lane = $this->db->insert('dsr_lane',$dsr_lane_data[$l]);
	// 			$l++;
				
	// 		}
	// 		$l = 0;
	// 		$section = 0;
	// 		foreach($south as $sout){
	// 			$section++;
	// 			$dsr_lane_data[$l]['dsr_id'] = $dsr_update_data[0]['id'];
	// 			$dsr_lane_data[$l]['lane_id'] = $sout['id'];
	// 			$dsr_lane_data[$l]['bound'] = $sout['bound'];
	// 			$dsr_lane_data[$l]['lane_status'] = $d['slanestatus'.$section];
	// 			$dsr_lane_data[$l]['lane_closed'] = $d['slclosed'.$section];
	// 			$dsr_lane_data[$l]['lane_closed_from'] = $d['slclosed_from'.$section];
	// 			$dsr_lane_data[$l]['lane_closed_to'] = $d['slclosed_to'.$section];
	// 			$dsr_lane_data[$l]['lane_closed_description'] = $d['slclosed_description'.$section];
	// 			$dsr_lane_data[$l]['lane_camera_status'] = $d['scstatus'.$section];
	// 			$dsr_lane_data[$l]['lane_camera_faulty_description'] = $d['sfc_desc'.$section];
	// 			$this->db->limit(1);
	// 			$data_dsr_lane = $this->db->insert('dsr_lane',$dsr_lane_data[$l]);
	// 			$l++;
				
	// 		}
	// 		//data array for dsr_attendance
	// 		$a= 0;
	// 		$as = 0;
	// 		foreach($this->page_data['staff'] as $staff){
	// 			$as++;
	// 			$dsr_attendance_data[$a]['dsr_id'] = $dsr_update_data[0]['id'];
	// 			$dsr_attendance_data[$a]['staff_id'] = $staff['id'];
	// 			$dsr_attendance_data[$a]['attendance_status'] = $d['as'.$as.'status'];
	// 			$dsr_attendance_data[$a]['leave_from'] = $d['as'.$as.'holidayfrom'];
	// 			$dsr_attendance_data[$a]['leave_to'] = $d['as'.$as.'holidayto'];

	// 			$this->db->limit(1);
	// 			$data_dsr_lane = $this->db->insert('dsr_attendance',$dsr_attendance_data[$a]);
	// 			$a++;
	// 		}
	// 		$i++;
	// 	}
	// 		
	// }
	
	// public function date_changer(){
		
	// 	$count_dsr = 0;
		
	// 	$dsr_updated = $this->db->order_by('id', 'ASC')->get('dsr_updated')->result_array();
		
	// 	/*foreach($lanes as $lane){
	// 		echo $lane['tollplaza'];echo '<br>';
	// 	}
	// 	*/
	// 	$i = 0;
	// 	foreach($dsr_updated as $d){
	// 		$tool_id[$i]['id'] = $d['toolplaza_id'];
	// 		$dsr_id = $d['id'];
	// 		$count_dsr++;
	// 		echo $count_dsr; echo ' ';
	// 		$lanes[$i] = $this->db->order_by('id', 'ASC')->get_where('dsr_lane', array('dsr_id' => $d['id'] ))->result_array();
	// 		$j = 0; $count_lane = 0;
	// 		foreach($lanes[$i] as $lane){
	// 			$count_lane++;
	// 			echo $count_lane; echo ' ';
	// 			$data['toolplaza_id'] = $tool_id[$i]['id'];
				
	// 			$this->db->where('dsr_id', $lane['dsr_id']);
	// 			$this->db->update('dsr_lane', $data);
	// 			$j++;
	// 		}
	// 		echo '<br>';
	// 		$i++;
	// 	}
	// }
	

}