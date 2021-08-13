<div class="row">
  <!-- <div class="col-md-12">
    <span class="btn btn-success btn-sm pull-left"  data-toggle="modal" data-target="#trafficAdd" onclick="ajax_html('<?php echo base_url()?>toolplaza/Traffic_Entry/add/', 'trafficAdd_contents');"><i class="fa fa-plus"></i> Add New Entry</span>
  </div> -->
</div>
<div class="table-responsive">

    <table class="table" id="adminEntryTable" width="100%">
      <thead class=" text-primary">
        <th>No</th>
        <th>Added By</th>
        <th>Toll Plaza</th>
        <th>Hours Date</th>
        <th>Action</th>
      </thead>
      <tbody>

        <?php
          $count = 0;
          if($counter){
            foreach($counter as $row){
            $count++;
          $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['site_id']))->row()->name;
          ?>
        <tr>
          <td>
            <?php echo $count;?>
          </td>
          <td>
            <?php
            $this->db->select('fname, lname');
            $this->db->from('tpsupervisor');
            $this->db->where('id', $row['user_id']);
            $this->db->where('role', 1);
            $name = $this->db->get()->result_array();
            echo $name[0]['fname'].' '.$name[0]['lname']."&nbsp;(Site Incharge)";
         ?>
          </td>
          <td>
            <?php 
              if($row['bound'] == 1){
                echo "<span class='badge badge-info'>".$toolplaza_name."&nbsp;(North Bound)</span>";
              }else{
                  echo "<span class='badge badge-info'>".$toolplaza_name."&nbsp;(South Bound)</span>";
              }
              ?>
          </td>
          <td>
          <?php 
              echo date("F j, Y",strtotime($row['date']));
            ?>
          </td>
          <td>
            <a class="btn btn-success btn-sm" target="_blank" data-toggle="modal" data-target="#entryView" onclick="ajax_html('<?php echo base_url()?>admin/Traffic_View/view/<?php echo $row['id']?>', 'entryView_contents');"><i class="fa fa-eye"></i>View</a>
            <a href="<?php echo base_url()?>admin/Traffic_View/print_view/<?php echo $row['id']?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-eye"></i>Print View</a>
              <?php if($row['user_type'] == 2 && $row['user_id'] == $this->session->userdata('supervisor_id')){?>
                <span class="btn btn-danger btn-sm" style="margin-top:1%;" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"><i class="fa fa-trash" ></i>Delete</span>
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
    $('#adminEntryTable').DataTable();
});
</script>