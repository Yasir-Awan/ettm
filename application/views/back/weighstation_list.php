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
                <th>IP Address</th>
                <th>Software Type</th>
                <th>Status</th>
                <th>Google Map Status</th>
                <th>Action</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if($weigh){
                $counter = 0;
                foreach($weigh as $row){

                      $counter++;

            ?>
             <tr>
                <td><?php echo $counter;?></td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['address'];?></td>
                <td><?php if($row['software_type'] == 1){
                    echo '<span class="badge badge-info">DAW</span>';

                }else if($row['software_type'] == 0){
                    echo '<span class="badge badge-success">Manual</span>';


                }else{
                    echo '<span class="badge badge-warning">JOD</span>';
                };?></td>
                <td><?php if($row['status'] != '1') {

                 ?>
                 <input type="checkbox" name="toggle" id="toggle_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" data-toggle="toggle" data-off="Off" data-on="On" data-style="ios">
                <?php
            }elseif($row['status'] == '1')
            {
            //echo 'else'.$row['status'];
                ?>
                  <input type="checkbox" name="toggle" id="toggle_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" data-toggle="toggle" data-off="Off" data-on="On" data-style="ios" checked="checked">
                <?php
            }?>
                 </td>
                 <td><?php if($row['gm_status'] != '1') {

                 ?>
                 <input type="checkbox" name="toggle1" id="toggle_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" data-toggle="toggle" data-off="Off" data-on="On" data-style="ios">
                <?php
            }elseif($row['gm_status'] == '1')
            {
            //echo 'else'.$row['status'];
                ?>
                  <input type="checkbox" name="toggle1" id="toggle_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" data-toggle="toggle" data-off="Off" data-on="On" data-style="ios" checked="checked">
                <?php
            }?>
                 </td>
                <td>
                    <span class="btn btn-success btn-sm btn-labeled fa fa-edit" id="cancel_reason" name="tp_edit" onclick="ajax_html('<?php echo base_url().'admin/weighstation/edit/'.$row['id'];?>','edit_weigh_contents');" data-toggle="modal" data-target="#weigh_edit">&nbsp;Edit</span>

                    <span class="btn btn-danger btn-xs  fa fa-trash" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')">Delete</span>

                </td>
                
            </tr> 
            <?php    }
            }?>
           
        </tbody>
    </table>
    <script>
    $(document).ready(function(){
        $('#dataTable3').DataTable();
        $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
        $("[data-toggle='toggle']").bootstrapToggle();
    })
    </script>