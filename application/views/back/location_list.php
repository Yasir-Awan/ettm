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
                <th>Action</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if($location){
                $counter = 0;
                foreach($location as $row){

                      $counter++;

            ?>
             <tr>
                <td><?php echo $counter;?></td>
                <td><?php echo $row['name'];?></td>
               
                <td>
                    <span class="btn btn-success btn-sm btn-labeled fa fa-edit"  name="loc_edit" onclick="ajax_html('<?php echo base_url().'admin/location/edit/'.$row['id'];?>','edit_location_contents');" data-toggle="modal" data-target="#loc_edit">&nbsp;Edit</span>

                    <span class="btn btn-danger btn-xs " onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"><i class='fas fa-trash-alt'></i> Delete</span>

                </td>
                
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