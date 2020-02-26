<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
  .toggle.ios { width: 60.0781px !important;
    height: 30px !important;}
    .btn{
        padding: 0.375rem 0.95rem !important;
        font-size: 1rem !important;
        line-height: 1 !important;
    }
    .toggle-off{
        background-color: #e31515 !important;
        color: white !important;
    }
    .toggle-on{
        background-color: #0f9b0f !important;
        color: white !important;
    }
</style>                     
<div class="data-tables datatable-dark">
    <table id="dataTable3" class="text-center">
        <thead class="text-capitalize">
            <tr>
                <th>No</th>
                
                <th>Name</th>
                <th>Designation</th>
                <th>Contact</th>
				<th>Tool Plaza</th>
                <?php if($this->session->userdata('role') == 1) {?>
                <th> 
                Actions
                </th>
                <?php } ?>
                
            </tr>
        </thead>
        <tbody>
            <?php if($tpstaff){
                $counter = 0;
                foreach($tpstaff as $row){

                      $counter++;

            ?>
             <tr>
                <td><?php echo $counter;?></td>
                <td><?php echo $row['fname'] .' '. $row['lname'];?></td>
                <td><?php echo $row['designation'];?></td>
                <td><?php echo $row['contact'];?></td>
                <td width="auto">
                    
                    <?php 
                    $tool_plaza = $this->db->get_where('toolplaza',array('id' => $row['tollplaza']))->result_array();?>
                    <span class="badge badge-info" style="padding: 5%;font-size: 12px;"><?php echo @$tool_plaza[0]['name'];?></span>
                </td>
                 <?php if($this->session->userdata('role') == 1) {?>
                <td width="25%">
                    <span class="btn-success btn-xs btn-labeled fa fa-edit" id="cancel_reason" name="tp_edit" onclick="ajax_html('<?php echo base_url().'admin/tpstaff_edit/'.$row['id'];?>','edit_toolplazas_contents');" data-toggle="modal" data-target="#tps_edit">&nbsp;Edit</span>
                    <span class="btn-danger btn-xs  fa fa-trash" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')">Delete</span>
                </td>
                <?php  } ?>
                

            </tr> 
            <?php    }
            }?>
           
        </tbody>
    </table>
    <script>
    $(document).ready(function(){

        $('#dataTable3').DataTable();
    })
    </script>