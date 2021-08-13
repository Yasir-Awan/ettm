                    
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
            <?php if($routes){
                $counter = 0;
                foreach($routes as $row){

                      $counter++;

            ?>
             <tr>
                <td><?php echo $counter;?></td>
                <td><?php echo $row['name'];?></td>
                
                <td>
                    <span class="btn btn-success btn-sm btn-labeled fa fa-edit" id="cancel_reason" name="route_edit" onclick="ajax_html('<?php echo base_url().'admin/routes/edit/'.$row['id'];?>','edit_route_contents');" data-toggle="modal" data-target="#route_edit">&nbsp;Edit</span>

                    <span class="btn btn-danger btn-sm  fa fa-trash"  onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')">Delete</span>

                </td>
                
            </tr> 
            <?php    }
            }?>
           
        </tbody>
    </table>
   