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
                <th>Username</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Added Date</th>
                <?php if($this->session->userdata('role') == 1) {?>
                <th>Actions</th>
                <?php } ?>
                
            </tr>
        </thead>
        <tbody>
            <?php if($supervisor){
                $counter = 0;
                foreach($supervisor as $row){

                      $counter++;

            ?>
             <tr>
                <td><?php echo $counter;?></td>
                <td><?php echo $row['fname'] .' '. $row['lname'];?></td>
                <td><?php echo $row['username'];?></td>
                <td><?php echo $row['contact'];?></td>
               
                <td>
                <?php if($this->session->userdata('role') == 1) {?>
                <?php if($row['status'] != '1') {

                 ?>
                 <input type="checkbox" name="toggle" id="toggle_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" data-toggle="toggle" data-off="Off" data-on="On" data-style="ios">
                <?php
            }elseif($row['status'] == '1')
            {
            //echo 'else'.$row['status'];
                ?>
                  <input type="checkbox" name="toggle" id="toggle_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" data-toggle="toggle" data-off="Off" data-on="On" data-style="ios" checked="checked">
                <?php
            }  
        }  
        else {?>
                   <?php if($row['status'] != '1') { ?>
                    <span class="badge badge-danger">InActive</span>   
<?php
                         }
                        elseif($row['status'] == '1')
                         {
                        //echo 'else'.$row['status'];
?>
                 <span class="badge badge-success">Active</span>  
<?php
                        }  
            }    
?>
                 </td>
                 <td><?php echo date('F j, Y', $row['adddate']);?></td>
                 <?php if($this->session->userdata('role') == 1) {?>
                <td>
                    <span class="btn-success btn-xs btn-labeled fa fa-edit" id="cancel_reason" name="tp_edit" onclick="ajax_html('<?php echo base_url().'admin/member_edit/'.$row['id'];?>','editmember_contents');" data-toggle="modal" data-target="#editmember">&nbsp;Edit</span>
                    <span class="btn-info btn-xs btn-labeled fa fa-wrench" id="cancel_reason" name="tp_edit" onclick="ajax_html('<?php echo base_url().'admin/member_password/'.$row['id'];?>','memberPass_contents');" data-toggle="modal" data-target="#memberPass">&nbsp;Change Password</span>
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