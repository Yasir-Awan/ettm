<?php 
class Tollplaza_model extends CI_MODEL{
    function __construct()
    {
		parent::__construct();	
    }
    

    function chartdata()
    {
        $data = $this->db->select('*')->where('toolplaza',$this->session->userdata('toolplaza'))->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
        $data_min = $this->db->select('*')->where('toolplaza',$this->session->userdata('toolplaza'))->order_by('for_month','asc')->limit(1)->get('mtr')->result_array();

        if($data && $data_min)
        {
            $data1 = explode('-', $data[0]['for_month']);
            $data2 = explode('-', $data_min[0]['for_month']);
            $start_date1 = implode('/', array($data2[0], $data2[1]));
            $end_date1 = implode('/', array($data1[0], $data1[1]));
        }
        else
        {
            $start_date = '';
            $end_date = '';
            $start_date1 = '';
            $end_date1 = '';
        }
        $chart = array();
        $revenue = array();
        if($data)
        {
            $chart['tollplaza'] = $this->db->get_where('toolplaza',array('id' => $data[0]['toolplaza']))->row()->name;
            $chart['toolplaza_id'] = $data[0]['toolplaza'];
            $month_year = explode('-',$data[0]['for_month']);
            $start_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['start_date'];
            $end_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['end_date'];

            $sql = "Select * From terrif Where FIND_IN_SET (".$data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
            $tarrif =  $this->db->query($sql)->result_array();
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
            
            if($tarrif)
            {
                $revenue['special_message'] = " ";
                $revenue['month']          = $data[0]['for_month'];
                $revenue['class1']['data'] = $data[0]['class1'] * $tarrif[0]['class_1_value'];
                $revenue['class2']['data'] = $data[0]['class2'] * $tarrif[0]['class_2_value'];
                $revenue['class3']['data'] = ($data[0]['class3'] *  $tarrif[0]['class_3_value']) + ($data[0]['class5'] * $tarrif[0]['class_5_value']) + ($data[0]['class6'] * $tarrif[0]['class_6_value']);
                $revenue['class4']['data'] = $data[0]['class4'] * $tarrif[0]['class_4_value'];
                $revenue['class5']['data'] = ($data[0]['class7']  * $tarrif[0]['class_7_value']) + ($data[0]['class8'] *  $tarrif[0]['class_8_value']) + ($data[0]['class9'] * $tarrif[0]['class_9_value']) + ($data[0]['class10'] * $tarrif[0]['class_10_value']);
                $revenue['class1']['label'] = "Car, Jeep";
                $revenue['class2']['label'] = "Wagon, Hiace";
                $revenue['class3']['label'] = "Truck, Tractor & Trolly";
                $revenue['class4']['label'] = "Bus, Coaster";
                $revenue['class5']['label'] = "Articulated Truck";  
            }
            else
            {
                $revenue['special_message'] = "No Tarrif found for this mtr";
                $revenue['month']          = $data[0]['for_month'];
                $revenue['class1']['data'] = 0;
                $revenue['class2']['data'] = 0;
                $revenue['class3']['data'] = 0;
                $revenue['class4']['data'] = 0;
                $revenue['class5']['data'] = 0;
                $revenue['class1']['label'] = "Car, Jeep";
                $revenue['class2']['label'] = "Wagon, Hiace";
                $revenue['class3']['label'] = "Truck, Tractor & Trolly";
                $revenue['class4']['label'] = "Bus, Coaster";
                $revenue['class5']['label'] = "Articulated Truck";
            }
        }    
        return array('start_date'=> $start_date1,'end_date'=> $end_date1,'chart'=> $chart,'revenue'=> $revenue);
    }

    function get_chart_by($tollplaza = '', $month = '') //this method is used to get previous month & year data for pie charts
    {   
       /* echo"<pre>";
        print_r($tollplaza); exit;*/
       
        $chart = array();
        $revenue = array();
        $chart['class1']['data'] = 0;
        $chart['class2']['data'] = 0;
        $chart['class3']['data'] = 0;
        $chart['class4']['data'] = 0;
        $chart['class5']['data'] = 0;
        $revenue['class1']['data'] = 0;
        $revenue['class2']['data'] = 0;
        $revenue['class3']['data'] = 0;
        $revenue['class4']['data'] = 0;
        $revenue['class5']['data'] = 0;
        
        
        $data = $this->db->get_where('mtr',array('for_month' => $month, 'toolplaza' => $tollplaza))->result_array();
   
        if($data)
        {
            foreach($data as $key => $value) //loop to get traffic of previous month & year
            {
                $month_year = explode('-',$data[0]['for_month']);
                $start_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['start_date'];
                $end_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['end_date'];
                $sql = "Select * From terrif Where FIND_IN_SET (".$data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
                $tarrif =  $this->db->query($sql)->result_array();

                $chart['class1']['data'] = $chart['class1']['data'] + $value['class1'];
                $chart['class2']['data'] = $chart['class2']['data'] + $value['class2'];
                $chart['class3']['data'] = $chart['class3']['data'] + $value['class3'] + $value['class5'] + $value['class6'];
                $chart['class4']['data'] = $chart['class4']['data'] + $value['class4'];
                $chart['class5']['data'] = $chart['class5']['data'] + $value['class7'] + $value['class8'] + $value['class9'] + $value['class10'];
                
                if($tarrif)     // check for calculating revenue of previous year or month
                {
                    $revenue['special_message'] = " ";
                    $revenue['month']          = $value['for_month'];
                    $revenue['class1']['data'] = $revenue['class1']['data'] + $value['class1'] * $tarrif[0]['class_1_value'];
                    $revenue['class2']['data'] = $revenue['class2']['data'] + $value['class2'] * $tarrif[0]['class_2_value'];
                    $revenue['class3']['data'] = $revenue['class3']['data'] + ($value['class3'] *  $tarrif[0]['class_3_value']) + ($value['class5'] * $tarrif[0]['class_5_value']) + ($value['class6'] * $tarrif[0]['class_6_value']);
                    $revenue['class4']['data'] = $revenue['class4']['data'] + $data[0]['class4'] * $tarrif[0]['class_4_value'];
                    $revenue['class5']['data'] = $revenue['class5']['data'] + ($value['class7']  * $tarrif[0]['class_7_value']) + ($value['class8'] *  $tarrif[0]['class_8_value']) + ($value['class9'] * $tarrif[0]['class_9_value']) + ($value['class10'] * $tarrif[0]['class_10_value']);    
                }
            }
        }

       $chart['month']           = @$data[0]['for_month'];
        $chart['tollplaza'] = @$this->db->get_where('toolplaza',array('id' => @$data[0]['toolplaza']))->row()->name;
        return array('chart' => $chart, 'revenue' => $revenue);
    }

    function get_tollplaza_dates($tollplaza = '')
    {
        $data = $this->db->select('*')->where('toolplaza',$tollplaza)->order_by('for_month','desc')->limit(1)->get('mtr')->result_array();
        $data_min = $this->db->select('*')->where('toolplaza',$tollplaza)->order_by('for_month','asc')->limit(1)->get('mtr')->result_array();
        
        if($data && $data_min)
        {
            $data1 = explode('-', $data[0]['for_month']);
            $data2 = explode('-', $data_min[0]['for_month']);
            $start_date = implode('/', array($data2[0], $data2[1]));
            $end_date = implode('/', array($data1[0], $data1[1]));
        }
        else
        {
            $start_date = '';
            $end_date = '';
        }
        return array('start_date'=> $start_date,'end_date'=> $end_date);
    }

    function get_chartdata($month = '')
    {  
        $chart = array();
        $revenue = array();
        $chart['class1']['data'] = 0;
        $chart['class2']['data'] = 0;
        $chart['class3']['data'] = 0;
        $chart['class4']['data'] = 0;
        $chart['class5']['data'] = 0;
        $revenue['class1']['data'] = 0;
        $revenue['class2']['data'] = 0;
        $revenue['class3']['data'] = 0;
        $revenue['class4']['data'] = 0;
        $revenue['class5']['data'] = 0;
   
        $month = str_replace('/', '-', $month);
        $month = $month."-01";
        $data = $this->db->get_where('mtr',array('for_month' => $month, 'toolplaza' => $this->session->userdata('toolplaza')))->result_array();
        
        if(empty($data))
        {
            $data = $this->db->select('*')->where('toolplaza',$this->session->userdata('toolplaza'))->order_by('id','desc')->limit(1)->get('mtr')->result_array();
        }
        foreach($data as $key => $value)
        {
            $month_year = explode('-',$data[0]['for_month']);
            $start_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['start_date'];
            $end_date = $month_year[0].'-'.$month_year[1].'-'.$data[0]['end_date'];
            $sql = "Select * From terrif Where FIND_IN_SET (".$data[0]['toolplaza']." ,toolplaza) AND (start_date <= '".$start_date."' AND end_date >= '".$end_date."')";
            $tarrif =  $this->db->query($sql)->result_array();

            $chart['class1']['data'] = $chart['class1']['data'] + $value['class1'];
            $chart['class2']['data'] = $chart['class2']['data'] + $value['class2'];
            $chart['class3']['data'] = $chart['class3']['data'] + $value['class3'] + $value['class5'] + $value['class6'];
            $chart['class4']['data'] = $chart['class4']['data'] + $value['class4'];
            $chart['class5']['data'] = $chart['class5']['data'] + $value['class7'] + $value['class8'] + $value['class9'] + $value['class10'];

            if($tarrif)
            {
                $revenue['special_message'] = " ";
                $revenue['month']          = $value['for_month'];
                $revenue['class1']['data'] = $revenue['class1']['data'] + $value['class1'] * $tarrif[0]['class_1_value'];
                $revenue['class2']['data'] = $revenue['class2']['data'] + $value['class2'] * $tarrif[0]['class_2_value'];
                $revenue['class3']['data'] = $revenue['class3']['data'] + ($value['class3'] *  $tarrif[0]['class_3_value']) + ($value['class5'] * $tarrif[0]['class_5_value']) + ($value['class6'] * $tarrif[0]['class_6_value']);
                $revenue['class4']['data'] = $revenue['class4']['data'] + $data[0]['class4'] * $tarrif[0]['class_4_value'];
                $revenue['class5']['data'] = $revenue['class5']['data'] + ($value['class7']  * $tarrif[0]['class_7_value']) + ($value['class8'] *  $tarrif[0]['class_8_value']) + ($value['class9'] * $tarrif[0]['class_9_value']) + ($value['class10'] * $tarrif[0]['class_10_value']);    
            }
        }

        $chart['month']           = $data[0]['for_month'];
        $chart['class1']['label'] = "Car, Jeep";
        $chart['class2']['label'] = "Wagon, Hiace";
        $chart['class3']['label'] = "Truck, Tractor & Trolly";
        $chart['class4']['label'] = "Bus, Coaster";
        $chart['class5']['label'] = "Articulated Truck";

        $revenue['month']          = $data[0]['for_month'];
        $revenue['class1']['label'] = "Car, Jeep";
        $revenue['class2']['label'] = "Wagon, Hiace";
        $revenue['class3']['label'] = "Truck, Tractor & Trolly";
        $revenue['class4']['label'] = "Bus, Coaster";
        $revenue['class5']['label'] = "Articulated Truck";
        $chart['tollplaza'] = $this->db->get_where('toolplaza',array('id' => $data[0]['toolplaza']))->row()->name;
        $chart['toolplaza_id'] = $data[0]['toolplaza'];
        return array('chart' => $chart, 'revenue' => $revenue);
    }	
}