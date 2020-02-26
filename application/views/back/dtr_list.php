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
                <th>Uploaded By </th>
                <th>Toll Plaza</th>
                <th>Upload Date</th>
                <th>DTR Date</th>
                <th width="15%">Status</th>
                <th width="30%">Action</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if($dtr){
              //echo "<pre>";
             /// print_r($dtr); exit;
                $counter = 0;
                foreach($dtr as $row){

                      $counter++;

                        
                        $support = $this->db->get_where('dtr_supporting_document',array('dtr_id' => $row['id']))->result_array();
                          
                        $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza']))->row()->name;
                        

            ?>
             <tr>
                <td><?php echo $counter;?></td>
                <td>
                  <?php
                        if($row['upload_type'] == 1){
                          $this->db->select('fname, lname');
                          $this->db->from('tpsupervisor');
                          $this->db->where('id', $row['user_id']);
                          $upload_name = $this->db->get()->result_array();
                          echo $upload_name[0]['fname'].' '.$upload_name[0]['lname']."&nbsp;(Supervisor)";
                        }else{
                          $this->db->select('fname, lname');
                          $this->db->from('member');
                          $this->db->where('id', $row['user_id']);
                          $upload_name = $this->db->get()->result_array();
                          echo $upload_name[0]['fname'].' '.$upload_name[0]['lname']."&nbsp;(Member)";
                         // print_r($upload_name);

                        }
                       ?></td>
                <td><?php echo $toolplaza_name;?></td>
                <td><?php echo date('F j, Y, g:i a',$row['adddate']); ?></td>
                <td> <?php echo date('F j, Y',strtotime($row['for_date']));?></td>
                <td> <?php if($row['status'] == 0){?>
                         <span class="badge badge-primary">Pending</span>

                          <?php }elseif($row['status'] == 1){?>
                          <span class="badge badge-success"> Approved</span>
                          <?php }elseif($row['status'] == 2){?>
                          
                            <span class="badge badge-danger"> Rejected</span>
                              <span class="btn-info btn-xs fa fa-eye" onclick="ajax_html('<?php echo base_url().'admin/dtr/view_reason/'.$row['id'];?>','viewreason_contents');" data-toggle="modal" data-target="#viewreason"> Reason</span>
                         <?php }?>
                </td>
                <td>
                          <a href="<?php echo base_url()?>admin/daily_traffic_report/<?php echo $row['id']?>" class="btn-info btn-xs" target="__blank"><i class="fa fa-eye"></i> View</a>
                            <a href="<?php echo base_url()?>uploads/dtr/<?php echo $row['file'];?>" style="background-color: #6c757d" class="btn-info btn-xs fa fa-paperclip" target="__blank"> View Attachment</a>
                            <?php 
                                  if($row['status'] != 2){
                            ?>
<?php if($this->session->userdata('role') == 1) {?>
                            <span class="btn-warning btn-xs fa fa-thumbs-down" onclick="ajax_html('<?php echo base_url().'admin/dtr/disapprove/'.$row['id'];?>','dissaprove_contents');" data-toggle="modal" data-target="#dissaprove"> Disapprove</span>        
                            <?php  
                                  }
                                }
                            ?>
                            <?php 
                                  if($row['status'] != 1){

                                    if($this->session->userdata('role') == 1) {
                            ?>
                           
                            <span class="btn-success btn-xs fa fa-check" onclick="approve_confirm('Really want to approve this','<?php echo $row['id']; ?>')"> Approve</span>       
                            <?php  
                                  }
                                }
                            ?>
                         
                          <?php if($support){?>
                          <span class="btn-primary btn-xs fa fa-eye" style="background-color: #820484;" onclick="ajax_html('<?php echo base_url().'admin/view_dtrsupporting/'.$row['id'];?>','support_contents');" data-toggle="modal" data-target="#support"> Suppporting Files</span>
                          <?php } ?>
                          <?php if($this->session->userdata('role') == 1) {?>
                          <span class="btn-danger btn-xs fa fa-trash" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"> Delete</span>
                          <?php  } ?>
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