<div class="row">
  <div class="col-md-12">
    <span class="btn btn-success btn-sm pull-left"  data-toggle="modal" data-target="#mtrAdd" onclick="ajax_html('<?php echo base_url()?>member/mtr/add/', 'mtrAdd_contents');"><i class="fa fa-plus"></i>Add New Report</span>
  </div>
</div>
<div class="table-responsive">

                  <table class="table" id="dataTable3" width="100%">
                    <thead class=" text-primary">
                      <th>
                        No
                      </th>
                      <th>
                        Uploaded By
                      </th>
                      <th>
                        Toll Plaza
                      </th>
                      <th>
                        MTR Type
                      </th>
                      <th>
                        Month
                      </th>
                      <th>
                        Upload Date
                      </th>
                      <th>
                        Status
                      </th>
                      <th>
                        Action
                      </th>
                    </thead>
                    <tbody>

                      <?php
                        $counter = 0;
                       foreach($mtr as $row){
                        $counter++;

                        
                        
                        $support = $this->db->get_where('supporting_document',array('mtr_id' => $row['id']))->result_array();  
                        $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza']))->row()->name;
                        ?>
                      <tr>
                        <td>
                          <?php echo $counter;?>
                        </td>
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
                       ?>
                        </td>
                        <td>
                          <?php echo $toolplaza_name;?>
                        </td>
                        <td>
                          <?php 

                            if($row['type'] == 1){
                                echo '<span class="badge badge-info">Standard (Complete Month)</span>';
                            }else{
                                $c_d = explode('-',$row['for_month']);
                                $start_date = $c_d[0].'-'.$c_d[1].'-'.$row['start_date'];
                                $end_date = $c_d[0].'-'.$c_d[1].'-'.$row['end_date'];
                            
                                echo '<span class="badge badge-info">Custom (Specific Dates)</span><br>';
                                echo '<span class="badge badge-success" style="margin-top: 1.5%;">From: &nbsp;'.date("F j, Y", strtotime($start_date)).'</span><br>';
                                echo '<span class="badge badge-warning" style="margin-top: 1.5%;">To:'.date("F j, Y", strtotime($end_date)).'</span>';
                            }
                          ?>
                        </td>
                        <td>
                         <?php echo date("F, Y",strtotime($row['for_month'])); ?>
                        </td>
                        <td>
                          <?php echo date('F j, Y, g:i a',$row['adddate']);?>
                        </td>
                        <td>
                          <?php if($row['status'] == 0){?>
                         <span class="badge badge-primary">Pending</span>

                          <?php }elseif($row['status'] == 1){?>
                          <span class="badge badge-success">Approved</span>
                          <?php }elseif($row['status'] == 2){?>
                          
                            <span class="badge badge-danger">Rejected</span>
                              <span class="btn btn-info" style="padding: 1px 5px;font-size: 12px;
line-height: 1.5;border-radius: 3px;" onclick="ajax_html('<?php echo base_url().'member/mtr/view_reason/'.$row['id'];?>','viewreason_contents');" data-toggle="modal" data-target="#viewreason"><i class="fa fa-eye"></i>Reason</span>
                         <?php }?>
                        </td>
                        <td>
                          <a href="<?php echo base_url()?>member/monthly_traffic_report/<?php echo $row['id']?>" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-eye"></i>View</a>
                            <?php if($row['status'] != 1 && $row['upload_type'] == 2 && $row['user_id'] == $this->session->userdata('member_id')){?>
                        
                          <span class="btn btn-info btn-sm" onclick="ajax_html('<?php echo base_url().'member/mtr/edit/'.$row['id'];?>','mtrEDIT_contents');" data-toggle="modal" data-target="#mtrEDIT"><i class="fa fa-edit"></i>Edit</span>
                          <?php //} ?>
                              <span class="btn btn-danger btn-sm" style="margin-top:1%;" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"><i class="fa fa-trash" ></i>Delete</span>
                          <?php } ?>
                            <a href="<?php echo base_url()?>uploads/mtr/<?php echo $row['file'];?>" class="btn btn-warning btn-sm" target="__blank"><i class="fa fa-paperclip" aria-hidden="true"></i>View Attachment</a>
                           <?php if($support){?>
                          <span class="btn btn-primary btn-sm" style="margin-top:1%;" onclick="ajax_html('<?php echo base_url().'member/view_supporting/'.$row['id'];?>','support_contents');" data-toggle="modal" data-target="#support"><i class="fa fa-eye"></i>Suppporting Files</span>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <script>
                $(document).ready(function(){
                    $('#dataTable3').DataTable();

                });
                </script>