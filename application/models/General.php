<?php 
class General extends CI_MODEL
{
    function __construct()
    {
		parent::__construct();
		
	}
	function add_dtr_exempt($dtr_id = '', $post = ''){
        $data = array();
        $data['dtr_id'] = $dtr_id;
        $data['description'] = $post['description'];
        $data['notes'] = $post['notes'];
        $data['class1'] = $post[1];
        $data['class2'] = $post[2];
        $data['class3'] = $post[3];
        $data['class4'] = $post[4];
        $data['class5'] = $post[5];
        $data['class6'] = $post[6];
        $data['class7'] = $post[7];
        $data['class8'] = $post[8];
        $data['class9'] = $post[9];
        $data['class10'] = $post[10];
        $check = $this->db->get_where('dtr_exempt',array('dtr_id' => $dtr_id))->result_array();
        if($check)
        {
            $this->db->where('dtr_id', $dtr_id);
            $this->db->update('dtr_exempt',$data);
        }
        else
        {
            $this->db->insert('dtr_exempt', $data);
        }
        return TRUE;
}
function checkexempt_dtr_exist_delete($dtr_id = ''){
    $exempt = $this->db->get_where('dtr_exempt',array('dtr_id' => $dtr_id))->result_array();
    if($exempt)
    {
        $this->db->where('dtr_id', $dtr_id);
        $this->db->delete('dtr_exempt');
    }
    return TRUE;
}
    function add_exempt($mtr_id = '', $post = '')
    {
            $data = array();
            $data['mtr_id'] = $mtr_id;
            $data['description'] = $post['description'];
            $data['notes'] = $post['notes'];
            $data['class1'] = $post[1];
            $data['class2'] = $post[2];
            $data['class3'] = $post[3];
            $data['class4'] = $post[4];
            $data['class5'] = $post[5];
            $data['class6'] = $post[6];
            $data['class7'] = $post[7];
            $data['class8'] = $post[8];
            $data['class9'] = $post[9];
            $data['class10'] = $post[10];
            $check = $this->db->get_where('exempt',array('mtr_id' => $mtr_id))->result_array();
            if($check)
            {
                $this->db->where('mtr_id', $mtr_id);
                $this->db->update('exempt',$data);
            }
            else
            {
                $this->db->insert('exempt', $data);
            }
            return TRUE;
    }

    function checkexempt_exist_delete($mtr_id = '')
    {
        $exempt = $this->db->get_where('exempt',array('mtr_id' => $mtr_id))->result_array();
        if($exempt)
        {
            $this->db->where('mtr_id', $mtr_id);
            $this->db->delete('exempt');
        }
        return TRUE;
    }
    /**Notifications Start */
    public function notifications()
    {
        $notifications = $this->db->get('notifications')->result_array();
        if(empty($notifications))
        {
            $disapprovedMtrs = $this->db->get_where('mtr',array('status' => 2))->result_array();
            if($disapprovedMtrs)
            {
               foreach($disapprovedMtrs as $row)
               {        
                      $mtrMonth = explode('-', $row['for_month']);
                      $mtr_month = $mtrMonth[0].'-'.$mtrMonth[1].'-'.$mtrMonth[2];
            
                      $data =  array(
                        'user_id' => $row['user_id'],
                        'user_type' => $row['upload_type'],
                        'alert_type'  => 2,
                        'ref_id' 	=> $row['id'],
                        'date' => date("Y-m-d H:i:s"),
                        'is_read' => 0,               
                         );
                     $this->db->insert('notifications', $data);             
                }            
            }
        }
        elseif(!empty($notifications))
        {
            $disapprovedMtrs = $this->db->get_where('mtr',array('status' => 2))->result_array();
            if($disapprovedMtrs)
            {
               foreach($disapprovedMtrs as $row)
               {        
                      $mtrMonth = explode('-', $row['for_month']);
                      $mtr_month = $mtrMonth[0].'-'.$mtrMonth[1].'-'.$mtrMonth[2];
            
                      $data =  array(
                        'user_id' => $row['user_id'],
                        'user_type' => $row['upload_type'],
                        'alert_type'  => 2,
                        'ref_id' 	=> $row['id'],
                        'date' => date("Y-m-d H:i:s"),
                        'is_read' => 0,               
                         );
                     $this->db->replace('notifications', $data);             
                }            
            }        
        }
        
        return TRUE;
    }
}
/**Notifications END */
