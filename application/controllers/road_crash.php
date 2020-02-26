<?php
defined('BASEPATH') OR exit('NO DIRECT SCRIPT ALLOWED');
class Road_crash extends CI_Controller{
    function index()
    {
       
        $this->load->view('road_crash/accessCamera');

    }
    function crash_data()
    {
        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);  
        // exit;   
        $this->load->library('form_validation');
        $this->form_validation->set_rules('address',' Address','required|trim');
        $this->form_validation->set_rules('crash_time',' Crash Time','required|trim');
        $this->form_validation->set_rules('vehicle_no[]',' No of Vehicles','required|trim');
        $this->form_validation->set_rules('vehicle_type[]',' Vehicle Type','required|trim');
        // $this->form_validation->set_rules('license',' License No','required|trim');
        // $this->form_validation->set_rules('D_gender',' Driver Gender','required|trim');
        $this->form_validation->set_rules('vehicle_registration[]',' Vehicle Registration No','required|trim');
        $this->form_validation->set_rules('victim_no[]',' No of Victims','required|trim');
        $this->form_validation->set_rules('victim_status[]',' Status of Victims','required|trim');
        $this->form_validation->set_rules('victim_tno','Total number of Victims ','required|trim');
        $this->form_validation->set_rules('victim_mno','Male number of Victims ','required|trim');
        $this->form_validation->set_rules('victim_fno','Female number of Victims ','required|trim');
        $this->form_validation->set_rules('rtc_cause',' Cause of RTC','required|trim');
        $this->form_validation->set_rules('wheather_condition',' Condition of Wheather','required|trim');
        $this->form_validation->set_rules('pavement_condition',' Condition of Pavement','required|trim');
        $this->form_validation->set_rules('light_condition',' Condition of Light','required|trim');

        if($this->form_validation->run() == TRUE)
        {
            $vehicles = array();
            $v_reg_no = array();
            foreach($this->input->post('vehicle_no') as  $key=>$value)
            {
                if(!empty($value)){
                    if(!empty($_POST['vehicle_type'][$key])){
                        $vehicles[] = $value." ".$_POST['vehicle_type'][$key];
                    }
                    
                }
                
            }
            foreach($vehicles as $key=>$val)
            {
                if(!empty($val)){
                    if(!empty($_POST['vehicle_registration'][$key])){
                        $v_reg_no[] = $val." ".$_POST['vehicle_registration'][$key];                           
                    }
                }  
            }
            $vehicle = implode("  &  ",$v_reg_no);
          


            $victims = array();
            foreach($this->input->post('victim_no') as  $key=>$value)
            {
                if(!empty($value)){
                    if(!empty($_POST['victim_status'][$key])){
                        $victims[] = $value." ".$_POST['victim_status'][$key];
    
                    }
                }
                
            }
            $victim = implode("  &  ",$victims);
           
            

            // $genders = array();
            // foreach($this->input->post('victim_gno') as  $key=>$value)
            // {
            //     if(!empty($value)){
            //         if(!empty($_POST['victim_gender'][$key])){
            //             $genders[] = $value." ".$_POST['victim_gender'][$key];
    
            //         }
            //     }
                
            // }
            // $gender = implode("  &  ",$genders);
           
            

            $data = array(
                'coords' => $this->input->post('coords'),
                'address' => $this->input->post('address'),
                'crash_time' => $this->input->post('crash_time'),
                'vehicles_qty_regno' => $vehicle,
                'victims_number_status' => $victim,
                'rtc_cause' => $this->input->post('rtc_cause'),
                'wheather_condition' => $this->input->post('wheather_condition'),
                'pavement_condition'=> $this->input->post('pavement_condition'),
                'light_condition' => $this->input->post('light_condition'),
                'total_victims_number' => $this->input->post('victim_tno'),
                'male_victims' => $this->input->post('victim_mno'),
                'female_victims' => $this->input->post('victim_fno'),
                
                );
            // echo "<pre>";
            // print_r($data); exit;
            $this->db->insert('crash_data',$data);
            $insert_id = $this->db->insert_id();
            // $config['upload_path'] = './crash_photos/temp';
            // $config['allowed_types'] = '*';
            // $config['overwrite'] = TRUE;
            // $this->load->library('upload', $config);
            // $this->upload->do_upload('pic');

            // $file_name = $_FILES['pic']['name'];
            foreach($_FILES['supporting_file']['name'] as $key => $value){
                if(!empty($value)){

                        $_FILES['images[]']['name']		= $_FILES['supporting_file']['name'][$key];
                        $_FILES['images[]']['type']		= $_FILES['supporting_file']['type'][$key];
                        $_FILES['images[]']['tmp_name']	= $_FILES['supporting_file']['tmp_name'][$key];
                        $_FILES['images[]']['error']	= $_FILES['supporting_file']['error'][$key];
                        $_FILES['images[]']['size']		= $_FILES['supporting_file']['size'][$key];
                        
                        
           
                        
                        $s_data = array();
                            $s_data['name'] = $_FILES['supporting_file']['name'][$key];
                            $s_data['crash_id'] = $insert_id; 
                            $this->db->insert('crash_images', $s_data);
                            $supporting_id = $this->db->insert_id();
                            //$supporting_data = array();
                            $s_filename = $_FILES["supporting_file"]["name"][$key];

                            $ext = @end((explode(".", $s_filename)));
                            $s_file_new_name = 'supporting_document'.$insert_id.'_'.$supporting_id.'.'.$ext;
                            $configs['upload_path'] = './crash_photos/temp';
                            $configs['allowed_types'] = 'jpeg|jpg|png|csv|pdf|xls|xlsx|xl';
                            $configs['overwrite'] = TRUE;
                            $configs['file_name']	=	$s_file_new_name;
                            $this->load->library('upload', $configs);
                             $this->upload->initialize($configs);
                            if ( ! $this->upload->do_upload('images[]'))
                            {
                               echo json_encode(array('response' => FALSE , 'message' => $this->upload->display_errors())); exit;
                            }else{
                                $s_data = array();
                                $s_data['path'] = $s_file_new_name;
                                $this->db->where('id', $supporting_id);
                                $this->db->update('crash_images', $s_data);
                            }
                }
                else
                {
                    echo json_encode(array('response' => FALSE , 'message' => "One of your supporting document name is missing")); exit;
                
                }
        } 
            
            
            
            // $img = $_POST['image'];
            
            // $folderPath = "./crash_photos/temp";
          
            // $image_parts =  $img;
            // $image_type_aux =  $image_parts;
            // $image_type = $image_type_aux; 
            
          
            // $image_base64 = base64_decode($image_parts);
            // $fileName = $img ;
          
            // $file = $folderPath . $fileName;
            // file_put_contents($file, $image_base64);
          
         
  
   
          
           echo json_encode(array('response' => true, 'message' =>'Item Added Successfully','is_redirect' => True,'redirect_url' => base_url().'')); exit;
        } 
        else
        {
           echo json_encode(array('response' => TRUE ,'message' => validation_errors())); exit;
        }
        $this->load->view('road_crash/crash_data');
    }
}
?>