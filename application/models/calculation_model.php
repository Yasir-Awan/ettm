<?php 
class calculation_model extends CI_MODEL{
    function __construct()
    {
		parent::__construct();	
    }
    public function terrif($tool, $date){
		$query_tarrif = "Select * From terrif Where FIND_IN_SET (".$tool." ,toolplaza) AND (start_date <= '".$date."' AND end_date >= '".$date."')";
		return $this->db->query($query_tarrif);
	}
	public function revenue_tcd($table,$terrif){
		
		$class = array(); $total = 0;
		for($i = 1; $i<6; $i++){
			$class[$i] = $table['class'.$i];
			if($i == 5){
				$tarrif[$i] = $terrif['class_'.($i+2).'_value'];
			}
			else{
				$tarrif[$i] = $terrif['class_'.$i.'_value'];
			}
			$revenue[$i] = $class[$i] * $tarrif[$i];
			$total = $total + $revenue[$i];
		}
		$description[1] = 'Class-1 (Car/Jeep)';
		$description[2] = 'Class-2 (Wagon/Hiace)';
		$description[3] = 'Class-3 (2,3 Axle Trucks/Tractor/Trolley)';
		$description[4] = 'Class-4 (Buses/Coaster)';
		$description[5] = 'Class-5 (Above 3 Axle Articulated Truck)';
		
		return array('description' => $description,'class' => $class, 'terrif' => $tarrif,'revenue' => $revenue, 'total' => $total);
	}
}