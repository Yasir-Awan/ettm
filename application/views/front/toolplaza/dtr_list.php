<div class="table-responsive">
                  <table class="table" id="dataTable3" width="100%">
                    <thead class=" text-primary">
                      <th>No</th>
                      <th>Uploaded By</th>
                      <th>Toll Plaza</th>
                      <th>Upload Time</th>
                      <th>Upload Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                       <?php
                        $counter = 0;
                       foreach($dtr as $row){
                        $counter++; 
                        $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza']))->row()->name;
                        $support = $this->db->get_where('dtr_supporting_document',array('dtr_id' => $row['id']))->result_array();
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
                       ?>
                        </td>
                        <td>
                          <?php echo $toolplaza_name;?>
                        </td>
                        <!--td>
                          <?php /*

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
                          */?>
                        </td-->
                        <td><?php echo date('g:i a',$row['adddate']);?></td>
                        <td>
                          <?php echo date('F j, Y',strtotime($row['for_date']));?>
                        </td>
                        <td>
                          <?php if($row['status'] == 0){?>
                         <span class="badge badge-primary">Pending</span>

                          <?php }elseif($row['status'] == 1){?>
                          <span class="badge badge-success">Approved</span>
                          <?php }elseif($row['status'] == 2){?>
                          
                            <span class="badge badge-danger">Rejected</span>
                              <span class="btn btn-info" style="padding: 1px 5px;font-size: 12px;
  line-height: 1.5;border-radius: 3px;" onclick="ajax_html('<?php echo base_url().'toolplaza/dtr/view_reason/'.$row['id'];?>','viewreason_contents');" data-toggle="modal" data-target="#viewreason"><i class="fa fa-eye"></i>Reason</span>
                         <?php }?>
                        </td>
                        <td>
                          <a href="<?php echo base_url()?>toolplaza/daily_traffic_report/<?php echo $row['id']?>" class="btn btn-success btn-sm" target="__blank"><i class="fa fa-eye"></i>View</a>
                          <?php if($row['status'] != 1 && $row['upload_type'] == 1 && $row['user_id'] == $this->session->userdata('supervisor_id')){?>
                          <?php //if($row['status'] == 0){?>
                          <span class="btn btn-info btn-sm" onclick="ajax_html('<?php echo base_url().'toolplaza/dtr/edit/'.$row['id'];?>','dtrEDIT_contents');" data-toggle="modal" data-target="#dtrEDIT"><i class="fa fa-edit"></i>Edit</span>
                          <?php //} ?>
                              <span class="btn btn-danger btn-sm" style="margin-top:1%;" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"><i class="fa fa-trash" ></i>Delete</span>
                          <?php } ?>
                          <a href="<?php echo base_url()?>uploads/dtr/<?php echo $row['file'];?>" style="margin-top:1%;" class="btn btn-primary btn-sm" target="__blank"><i class="fa fa-paperclip" aria-hidden="true"></i>View Attachment</a>
                          <?php if($support){?>
                          <span class="btn btn-default btn-sm" style="margin-top:1%;" onclick="ajax_html('<?php echo base_url().'toolplaza/view_dtrsupporting/'.$row['id'];?>','support_contents');" data-toggle="modal" data-target="#support"><i class="fa fa-eye"></i>Suppporting Files</span>
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