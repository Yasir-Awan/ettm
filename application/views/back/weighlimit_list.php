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
                <th>Category</th>
                <th>Category Code</th>
                <th>Allowed Weight Limit</th>
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
                <td><?php 
                    $cat = $this->db->get_where('weigh_category',array('id' => $row['cat_id']))->row()->name;
                echo $cat;?></td>
                <td><?php echo $row['category_code'];?></td>
                <td><?php echo $row['weigh_limit'];?></td>
                <td>
                    <span class="btn btn-success btn-sm btn-labeled fa fa-edit"  onclick="ajax_html('<?php echo base_url().'admin/weighlimit/edit/'.$row['id'];?>','edit_limit_contents');" data-toggle="modal" data-target="#limit_edit">&nbsp;Edit</span>

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