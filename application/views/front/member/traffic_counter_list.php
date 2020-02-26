<div class="row">
  <div class="col-md-12">
    <span class="btn btn-success btn-sm pull-left"  data-toggle="modal" data-target="#counterAdd" onclick="ajax_html('<?php echo base_url()?>member/traffic_counting/add/', 'counterAdd_contents');"><i class="fa fa-plus"></i>Add New Session</span>
  </div>
</div>
<div class="table-responsive">

    <table class="table" id="dataTable3" width="100%">
      <thead class=" text-primary">
        <th>
          No
        </th>
        <th>
          Added By
        </th>
        <th>
          Toll Plaza
        </th>
        <th>
          Video Start Date/Time
        </th>
        <th>
          Video End Date/Time
        </th>
        <th>
          Session Start Date/Time
        </th>
        <th>
          Session End Date/Time
        </th>
        
        <th>
         Details
        </th>
      </thead>
      <tbody>

        <?php
          $count = 0;
          if($counter){
            foreach($counter as $row){
            $count++;

          
          
          $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['tollplaza']))->row()->name;
          ?>
        <tr>
          <td>
            <?php echo $count;?>
          </td>
          <td>
            <?php
          if($row['user_type'] == 3){
            $this->db->select('fname, lname');
            $this->db->from('tpsupervisor');
            $this->db->where('id', $row['user_id']);
            $upload_name = $this->db->get()->result_array();
            echo $upload_name[0]['fname'].' '.$upload_name[0]['lname']."&nbsp;(Supervisor)";
          }elseif($row['user_type'] == 2){
            $this->db->select('fname, lname');
            $this->db->from('member');
            $this->db->where('id', $row['user_id']);
            $upload_name = $this->db->get()->result_array();
            echo $upload_name[0]['fname'].' '.$upload_name[0]['lname']."&nbsp;(Member)";
           // print_r($upload_name);

          }
         ?>
          </td>
          <td>
            <?php 
              if($row['direction'] == "N"){
                  echo "<span class='badge badge-info'>".$toolplaza_name."&nbsp;(North Bound)</span>";
              }else{
                  echo "<span class='badge badge-info'>".$toolplaza_name."&nbsp;(South Bound)</span>";
              
              }
              ?>
          </td>
          <td>
            <?php 
              echo date("F j, Y, h:i:s A", $row['video_start_date']);
            ?>
          </td>
          <td>
            <?php 
            if($row['video_end_date']){
               echo date("F j, Y, h:i:s A", $row['video_end_date']);
            
             }else{
              echo "<span class='badge badge-danger'>Not Assigned</span>";
             }
             ?>
          </td>
          <td>
            <?php 
              echo date("F j, Y, h:i:s A", $row['session_start_date']);
            ?>
          </td>
          <td>
            <?php 
              if($row['session_end_date']){
               echo date("F j, Y, h:i:s A", $row['session_end_date']);
            
             }else{
              echo "<span class='badge badge-danger'>Not Assigned</span>";
             }
              ?>
          </td>
          
          <td>
            <a class="btn btn-success btn-sm" target="_blank" data-toggle="modal" data-target="#counterView" onclick="ajax_html('<?php echo base_url()?>member/traffic_counting/view/<?php echo $row['id']?>', 'counterView_contents');"><i class="fa fa-eye"></i>View</a>
              <?php if($row['user_type'] == 2 && $row['user_id'] == $this->session->userdata('member_id')){?>
          
           
                <span class="btn btn-danger btn-sm" style="margin-top:1%;" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"><i class="fa fa-trash" ></i>Delete</span>
            <?php } ?>
            <?php if($row['user_type'] == 2 && $row['user_id'] == $this->session->userdata('member_id') && !$row['video_end_date']){?>
          
           
                <a href="<?php echo base_url()?>member/traffic_counting/session_start/<?php echo $row['id']?>" class="btn btn-info btn-sm" style="margin-top:1%;"><i class="fa fa-trash" ></i>Restart</span>
            <?php } ?>
          </td>
        </tr>
        <?php } 
                } 
        ?>
      </tbody>
    </table>
</div>
<script>
$(document).ready(function(){
    $('#dataTable3').DataTable();

});
</script>