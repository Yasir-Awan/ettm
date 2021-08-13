<?php include('includes/header.php'); ?>
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
<div class="data-tables datatable-dark" style="margin-top:1rem;">
    <table id="dataTable_cameras" class="text-center" style="padding:auto;">
        <thead class="text-capitalize">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>IP Address</th>
                <th>Software Type</th>
                <th>Camera Status</th>
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
                <td><?php if($row['cam_status'] != '1') {
                       echo '<span class="badge badge-danger">Off</span>';
                    }elseif($row['cam_status'] == '1')
                    {
                       echo '<span class="badge badge-success">On</span>';
                    }?>
                    </td>                
            </tr> 
            <?php 
             }
            }?>
        </tbody>
    </table>
</div>
    <script>
    $(document).ready(function(){
        $('#dataTable_cameras').DataTable();
        $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
        $("[data-toggle='toggle']").bootstrapToggle();
    })
    </script>
    <?php include('includes/footer.php')?>