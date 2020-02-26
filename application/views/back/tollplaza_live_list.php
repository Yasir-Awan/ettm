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
                <th>Tollplaza</th>
                <th>IP Address</th>
                <th>Type</th>
                <th>Services</th>
                <th>Port</th>
                <th>Username</th>
                <th>Password</th>
                <th>Status</th>
                <?php if($this->session->userdata('role') == 1) {?>
                <th>Action</th>
                <?php  } ?>
                
            </tr>
        </thead>
        <tbody>
            <?php if($tollplaza_live){
                $counter = 0;
                foreach($tollplaza_live as $row){
                    $tollplaza = $this->db->get_where('toolplaza',array('id' => $row['tollplaza_id']))->row()->name;
                      $counter++;

            ?>
             <tr>
                <td><?php echo $counter;?></td>
                <td><?php echo $tollplaza;?></td>
                
                <td><?php echo $row['server_ip'];?></td>
                <td><?php if($row['server_type'] == 1){ ?>
                    <span class="badge badge-info">Oracle</span>
                <?php }else{ ?>
                    <span class="badge badge-warning">Informix</span>
                <?php }?></td>
                <td><?php echo $row['services'];?></td>
                <td><?php echo $row['port'];?></td>
                <td><?php echo $row['username'];?></td>
                <td><?php echo $row['password'];?></td>
                <td>
                            <?php if($this->session->userdata('role') == 1) {?>    
                                    <?php if($row['status'] != '1') { ?>
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
                            else
                            {?>
                                  <?php if($row['status'] != '1') { ?>
                                    <span class="badge badge-danger">InActive</span> 
                                    <?php
                                }elseif($row['status'] == '1')
                                {
                                //echo 'else'.$row['status'];
                                    ?>
                                     <span class="badge badge-success">Active</span> 
                                    <?php
                                } 
                      } ?>
                 </td>
                 <?php if($this->session->userdata('role') == 1) {?>
                <td>
                    <span class="btn btn-success btn-sm btn-labeled fa fa-edit" id="cancel_reason" name="tp_edit" onclick="ajax_html('<?php echo base_url().'admin/tollplaza_live/edit/'.$row['id'];?>','edit_toolplazalanes_contents');" data-toggle="modal" data-target="#edit_toolplazalanes">&nbsp;Edit</span>

                    <span class="btn btn-danger btn-xs  fas fa-trash-alt" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"> 
                    Delete</span>
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