<?php
defined('BASEPATH') OR EXIT('NO DIRECT SCRIPT ALLOWED');
class Member extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('member_id'))
		{
			redirect(base_url().'home');
		}
		$this->page_data = array();
		$this->load->model("General");
		$this->load->model('Member_model');
		$this->page_data['key'] = $this->db->get_where('settings',array('type' => 'google_map_api_key'))->row()->value;
	
	}

	public function index()
	{
		$data = $this->Member_model->chartdata();
		$previous_year = date("Y-m-d",strtotime(@$data['chart']['month'].' -1 year'));
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
		$pre_year_data = $this->Member_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_year);
		$pre_month_data = $this->Member_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_monthDate);
		
		$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
		$this->page_data['chart'] = $data['chart'];
        $this->page_data['revenue'] = $data['revenue'];
        $this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_year_chart'] = $pre_year_data['chart'];
        $this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];
		$this->page_data['page_name'] = 'dashboard';
		
		$this->load->view('front/member/dashboard', $this->page_data);
	}

	public function check_tollplaza_dates($tollplaza = '')
	{
		$data = $this->Member_model->get_tollplaza_dates($tollplaza);
		echo json_encode($data);
	}

	public function searchforchart($para1 = '')
	{
		$tollplaza = $this->input->post('tollplaza');
		$month  = $this->input->post('formonth');
		$data = $this->Member_model->get_chartdata($tollplaza, $month);
		
		$previous_year = date("Y-m-d",strtotime(@$data['chart']['month'].' -1 year'));
		$previous_monthDate = date("Y-m-d", strtotime( date( "Y-m-d", strtotime( @$data['chart']['month'] ) ) . "-1 month" ) );
		$pre_year_data = $this->Member_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_year);
		$pre_month_data = $this->Member_model->get_chart_by( @$data['chart']['toolplaza_id'], $previous_monthDate);
		
		$this->page_data['chart'] = $data['chart'];
		$this->page_data['revenue'] = $data['revenue'];

		$this->page_data['pre_month_chart'] = $pre_month_data['chart'];
        $this->page_data['pre_month_revenue'] = $pre_month_data['revenue'];
        $this->page_data['pre_year_chart'] = $pre_year_data['chart'];
		$this->page_data['pre_year_revenue'] = $pre_year_data['revenue'];
		
		$this->load->view('front/member/customize_chart_search', $this->page_data);	
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'home','refresh');
	}

	
	public function mtr($para1 = '', $para2 = '', $para3 = '')
	{
		if($para1 == 'list')
		{
			$this->db->order_by('id','DESC');
			$this->page_data['mtr']  = $this->db->get('mtr')->result_array();
			$this->load->view('front/member/mtr_list', $this->page_data);
		}
		elseif($para1 == 'by_tollplaza')
		{
			if($para2 != '')
			{
				$this->db->where('toolplaza', $para2);
			}
				$this->db->order_by('id','DESC');
				$this->page_data['mtr']  = $this->db->get('mtr')->result_array();
				$this->load->view('front/member/mtr_list', $this->page_data);

		}
		elseif($para1 == 'do_add')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('for_month','Valid Month And Year','required|trim');
			$this->form_validation->set_rules('tollplaza','Tollplaza','required|trim');
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
			if($this->input->post('add_exempt') == 1)
			{
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
			if($this->form_validation->run() == FALSE)
			{
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			}
			else
			{
				foreach($_FILES['supporting_file']['name'] as $key => $value){
							
							if(!empty($value))
							{
								if(!empty($_POST['suppporting_document_name'][$key]))
								{
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
								else
								{
									echo json_encode(array('response' => FALSE , 'message' => "One of your supporting document name is missing")); exit;
								}
							}
					}

						$tollplaza = $this->input->post('tollplaza');
						if($this->input->post('mtr_type') == 1)
						{
							$for_month		= 	$this->input->post('for_month');
							$format = str_replace('/','-', $for_month)."-01";
							$check_month = $this->db->get_where('mtr',array('for_month' => $format, 'toolplaza' => $tollplaza))->result_array();
							if($check_month){
								echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;			
							}
						}else{
							$user_id 		= 	$this->session->userdata('member_id');
							$toolplaza  	= 	$tollplaza;
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


				$data['user_id'] 		= 	$this->session->userdata('member_id');
				$data['toolplaza']  	= 	$tollplaza;
				$data['upload_type']  	= 	2;
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

		         	echo json_encode(array('response' => TRUE , 'message' => 'Added Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'member/mtr'));
		        }

			}
		}elseif($para1 == 'add'){
			$this->page_data['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('front/member/mtr_add' , $this->page_data);
		}elseif($para1 == 'edit'){
			$this->page_data['omc'] = $this->db->get_where('omc',array('status' => 1))->result_array();
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para2))->result_array();
			if($this->page_data['mtr']){
				if($this->page_data['mtr'][0]['status'] == 1 || $this->page_data['mtr'][0]['upload_type'] != 2 || $this->page_data['mtr'][0]['user_id'] != $this->session->userdata('member_id')){
					echo "<span class='text-danger'>Invalid Request</span>"; exit;
				}	
			}else{
				echo "<span class='text-danger'>Invalid Request</span>"; exit;
			}
			
			$this->load->view('front/member/mtr_edit', $this->page_data);
		}elseif($para1 == 'do_update'){
			//$check = $this->db->get_where('mtr',array('id' => $para2 , 'user_id' => $this->session->userdata('supervisor_id')))->result_array();
			$this->db->where('id',$para2);
			$this->db->where('upload_type',2);
			$this->db->where('user_id',$this->session->userdata('member_id'));
			$this->db->where('status !=', 1);
			$check = $this->db->get('mtr')->result_array();
			if($check){
					$this->load->library('form_validation');
					$this->form_validation->set_rules('tollplaza','Tollplaza','required|trim');
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
							$this->db->where('for_month',$format);
							$this->db->where('toolplaza',$this->input->post('tollplaza'));
							$this->db->where('id !=',$para2);
							$check_month = $this->db->get('mtr')->result_array();
							//echo $this->db->last_query(); exit;
							//$check_month = $this->db->get_where('mtr',array('for_month' => $format, 'toolplaza' => $this->input->post('tollplaza')))->result_array();
							if($check_month){
								echo json_encode(array('response' => FALSE , 'message' => 'You have already added MTR for this month please delete previous one')); exit;			
							}
						}else{
							$user_id 		= 	$this->session->userdata('member_id');
							$toolplaza  	= 	$this->input->post('tollplaza');
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

						$data['user_id'] 		= 	$this->session->userdata('member_id');
						$data['toolplaza']  	= 	$this->input->post('tollplaza');
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
				    echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'member/mtr'));
				}


			}else{
				echo json_encode(array('response' => FALSE , 'message' => "Invalid Request")); exit;
			}
			
		}elseif($para1 == 'approve'){
			$data['status'] = 1;
			$this->db->where('id',$para2);
			$this->db->update('mtr',$data);
		}elseif($para1 == 'view_reason'){
			$reason = $this->db->get_where('mtr',array('id' => $para2))->result_array();
			if($reason[0]['status'] == 2){
				echo "<span class='text-info'>".$reason[0]['reason']."</span>";
			}else{
				echo "<span class='text-danger'>Invalid Request</span>";
			}
			
		}else{
			$this->page_data['page_name'] = 'mtr';
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('front/member/mtr', $this->page_data);
		}
	}

	public function monthly_traffic_report($para1 = ''){
		$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para1 ))->result_array();
		$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];

		$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		$this->load->view('front/member/invoice', $this->page_data);
	}

	public function generate_pdf($para1 = ''){
		$this->page_data['mtr'] = $this->db->get_where('mtr',array('id' => $para1 ))->result_array();
		$month_year = explode('-',$this->page_data['mtr'][0]['for_month']);
		$start_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['start_date'];
		$end_date = $month_year[0].'-'.$month_year[1].'-'.$this->page_data['mtr'][0]['end_date'];

		//$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza)";
		$sql = "Select * From terrif Where FIND_IN_SET (".$this->page_data['mtr'][0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
		$this->page_data['terrif'] =  $this->db->query($sql)->result_array();
		$pdfdata = $this->load->view('front/member/invoice_pdf', $this->page_data, TRUE);

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
				$this->db->where('id', $this->session->userdata('member_id'));
				$this->db->update('member', $data);
				echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'member/settings'));
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
				  		$check_old = $this->db->get_where('member',array('id' => $this->session->userdata('member_id'), 'password' => sha1($this->input->post('oldpwd'))))->result_array();
				  		if(empty($check_old)){
				  			echo json_encode(array('response' => FALSE , 'message' => 'You have enter incorrect old password')); exit;
				  		}else{
				  			$data = array();
				  			$data['password'] = sha1($this->input->post('newpwd'));
				  			$this->db->where('id', $this->session->userdata('member_id'));
							$this->db->update('member', $data);
							echo json_encode(array('response' => TRUE , 'message' => 'Updated Successfully', 'is_redirect' => TRUE , 'redirect_url' => base_url().'member/settings'));
				  		}
				  }
		}else{
			$this->page_data['user'] = $this->db->get_where('member',array('id' => $this->session->userdata('member_id')))->result_array();
			$this->page_data['page_name'] = 'settings';
			$this->load->view('front/member/settings',$this->page_data);
		}
		
	}

	public function view_supporting($para1 = ''){
		$this->page_data['support'] = $this->db->get_where('supporting_document',array('mtr_id' => $para1))->result_array();
		$this->load->view('front/member/suppporting_list', $this->page_data);

	}

		function check_start_date(){

		$toolplaza  	= 	$this->input->post('tollplaza');
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
	/////////////////MAP SECTION STARTS HERE////////
	public function map($para1 = ''){
		
		$this->page_data['page_name'] = 'map';
		$this->page_data['roads'] = $this->db->get_where('google_locations',array('status' => 1))->result_array();
		$this->page_data['locations'] = $this->db->get_where('google_locations',array('status' => 1))->result_array();
		$this->page_data['roads'] = $this->db->get_where('roads',array('status' => 1))->result_array();
		$this->load->view('front/member/mapview', $this->page_data);
	}

	public function getcontents($para1 = ''){
		$this->page_data['location'] = $this->db->get_where('google_locations',array('id' => $para1))->result_array();
		$this->page_data['info_data'] = array();
		if($this->page_data['location'])
		{
			if($this->page_data['location'][0]['type'] == 1){
				$data = $this->db->select('*')->where('toolplaza', $this->page_data['location'][0]['location_id'])->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
				if($data){
					$tp_data = $this->Member_model->getinfodetails_tp($data);
				}else{
					$tp_data = '';
				}
				$this->page_data['info_data'] = $tp_data;
			}elseif($this->page_data['location'][0]['type'] == 2){
				$this->page_data['info_data'] = array();
			}
		}
		$this->load->view('front/member/infodata', $this->page_data);
	}

	function searchforgoogledata(){
		// echo '<pre>';
		// print_r($this->input->post());exit;
		$locations = array();
		if($this->input->post('alltollplaza')){
			$locations[] = 1;
		}

		if($this->input->post('allweighstation')){
			$locations[] = 2;
		}
		if($this->input->post('cameras')){
			$locations[] = 3;
		}
		if($this->input->post('wis')){
			$locations[] = 4;
		}
		if($this->input->post('erst')){
			$locations[] = 7;
		}
		if($this->input->post('microwavevd')){
			$locations[] = 8;
		}
		if($this->input->post('vms')){
			$locations[] = 5;
		}
		if($this->input->post('efine')){
			$locations[] = 10;
		}
		if($this->input->post('ofc')){
			$locations[] = 11;
			
		}
		if($this->input->post('speedes')){
			$locations[] = 9;
			
		}
		if($this->input->post('specific_road')){
			if($this->input->post('specific_road') == 'all'){
				$this->page_data['roads'] = $this->db->get_where('roads',array('status' => 1))->result_array();
				if($locations){
					$this->db->where('status',1);
					$this->db->where_in('type', $locations);
					$this->page_data['locations'] = $this->db->get('google_locations')->result_array();
		
				}else{
					$this->page_data['locations'] = '';
		
				}
			}else{
				$this->page_data['roads'] = $this->db->get_where('roads',array('status' => 1,'id' => $this->input->post('specific_road')))->result_array();
				if($locations){
					$this->db->where('status',1);
					$this->db->where('road_id', $this->input->post('specific_road'));
					$this->db->where_in('type', $locations);
					$this->page_data['locations'] = $this->db->get('google_locations')->result_array();
		
				}else{
					$this->page_data['locations'] = '';
				}
				
			}  
		}else{
			$this->page_data['roads'] = '';
			if($locations){
				$this->db->where('status',1);
				$this->db->where_in('type', $locations);
				$this->page_data['locations'] = $this->db->get('google_locations')->result_array();
		
			}else{
				$this->page_data['locations'] = '';
		
			}
		}
		
		if(empty($this->input->post())){
				$this->page_data['roads'] = $this->db->get_where('roads',array('status' => 1))->result_array();
				$this->page_data['locations'] = '';
		}
		
		$this->load->view('front/member/searchforgoogledata', $this->page_data);
	

	}

	public function traffic_counting($para1 = '', $para2 =''){
		if($para1 == 'list')
		{
			$this->db->order_by('id','DESC');
			$this->page_data['counter']  = $this->db->get('traffic_counter')->result_array();
			$this->load->view('front/member/traffic_counter_list', $this->page_data);
		}
		elseif($para1 == 'session_start')
		{
			$check = $this->db->get_where('traffic_counter', array('id' => $para2))->result_array();
			$this->page_data['error'] = '';
			if($check[0]['video_end_date']){
				$this->page_data['error'] = "You can't reopen a completed session";
			}
			$this->page_data['session_data'] = $this->db->get_where('traffic_counter',array('id' => $para2))->result_array();
			$this->page_data['insert_id'] = $para2;
			$this->page_data['page_name'] = 'traffic_counting';
			$useragent=$_SERVER['HTTP_USER_AGENT'];

			if(preg_match('#\b(ipad|tablet|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] ) || preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
			{
				$this->load->view('front/member/traffic_counter_session_mobile', $this->page_data); 

			}else{
				$this->load->view('front/member/traffic_counter_session', $this->page_data); 

			}
			

			
		}elseif($para1 == 'view'){
			$this->page_data['session'] = $this->db->get_where('traffic_counter', array('id' => $para2))->result_array();
			$this->load->view('front/member/traffic_counter_details', $this->page_data);
		}
		elseif($para1 == 'do_add')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tollplaza',"Toll Plaza",'required');
			$this->form_validation->set_rules('direction',"Direction",'required');
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
				$insert_data['user_id'] = $this->session->userdata('member_id');
				$insert_data['user_type'] = 2;
				$insert_data['video_start_date'] = $datetime;
				$insert_data['session_start_date'] = time();
				$this->db->insert('traffic_counter', $insert_data);
				$insert_id = $this->db->insert_id();

				echo json_encode(array('response' => TRUE, 'message' => "Session started", 'is_redirect' => TRUE, 'redirect_url' => base_url().'member/traffic_counting/session_start/'.$insert_id)); exit;
			}
		}else if($para1 == 'traffic_add'){

			$values = json_decode($this->input->post('result'));
			$session_id = $this->input->post('session');
			$data[$values[0]->key] = $values[0]->value;
			$this->db->where('id', $session_id);
			$this->db->update('traffic_counter', $data);
		}elseif($para1 == 'add'){
			$this->page_data['toolplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('front/member/counter_add' , $this->page_data);
		}elseif($para1 == 'update'){
			$this->page_data['session_id'] = $para2;
			$this->load->view('front/member/counter_update' , $this->page_data);
		}elseif($para1 == 'do_update'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('end_date',"Video end date",'required');
			$this->form_validation->set_rules('end_time',"video end time",'required');
			if($this->form_validation->run() == FALSE){
				echo json_encode(array('response' => FALSE , 'message' => validation_errors())); exit;
			
			}else{
				$update_data = array();
				$session_id = $this->input->post('session_id');
				$update_data['comment']= $this->input->post('comment');
				$video_start_date = $this->db->get_where('traffic_counter' , array('id' => $session_id))->row()->video_start_date;
				$datetime = strtotime(str_replace('/', '-', $this->input->post('end_date')).' '.$this->input->post('end_time'));
				if($datetime <= $video_start_date){
					echo json_encode(array('response' => FALSE, 'message' => 'Invalid date time')); exit;
				}
				$update_data['video_end_date'] = $datetime;
				$update_data['session_end_date'] = time();
				$this->db->where('id', $session_id);
				$this->db->update('traffic_counter', $update_data);

				echo json_encode(array('response' => TRUE, 'message' => "Session updated successfully", 'is_redirect' => TRUE, 'redirect_url' => base_url().'member/traffic_counting/')); exit;
			}
		}elseif($para1 == 'delete'){
			$this->db->where('id', $para2);
			$this->db->delete('traffic_counter');	
		}else{
			$this->page_data['page_name'] = 'traffic_counting';
			$this->page_data['tollplaza'] = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
			$this->load->view('front/member/traffic_counter', $this->page_data);
		}
	}


	
}