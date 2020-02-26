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
                       foreach($faulty as $row){
                        $counter++;

                        $this->db->select('fname, lname');
                        $this->db->from('tpsupervisor');
                        $this->db->where('id', $row['user']);
            
                        $upload_name = $this->db->get()->result_array();
                        
                          
                        $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['tollplaza']))->row()->name;
                        ?>
                      <tr>
                        <td>
                          <?php echo $counter;?>
                        </td>
                        <td>
                          <?php echo $upload_name[0]['fname'].' '.$upload_name[0]['lname'];?>
                        </td>
                        <td>
                          <?php echo $toolplaza_name;?>
                        </td>
                       
                        <td>
                          <?php echo date('F j, Y, g:i a',$row['date']);?>
                        </td>
                        <td>
                          <?php if($row['status'] == 0){?>
                         <span class="badge badge-primary">Pending</span>

                          <?php }elseif($row['status'] == 1){?>
                          <span class="badge badge-success">Approved</span>
                          <?php }elseif($row['status'] == 2){?>
                          
                            <span class="badge badge-danger">Rejected</span>
                              <span class="btn btn-info" style="padding: 1px 5px;font-size: 12px;
line-height: 1.5;border-radius: 3px;"><i class="fa fa-eye"></i>Reason</span>
                         <?php }?>
                        </td>
                        <td>
                          <a href="<?php echo base_url()?>toolplaza/monthly_traffic_report/<?php echo $row['id']?>" class="btn btn-success btn-sm" target="__blank"><i class="fa fa-eye"></i>View</a>
                          <?php if($row['status'] != 1){?>
                          <?php if($row['status'] == 0){?>
                          <span class="btn btn-info btn-sm" onclick="ajax_html('<?php echo base_url().'toolplaza/faulty_equipment_list/edit/'.$row['id'];?>','faultyEDIT_contents');" data-toggle="modal" data-target="#faultyEDIT"><i class="fa fa-edit"></i>Edit</span>
                          <?php } ?>
                          <span class="btn btn-danger btn-sm" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"><i class="fa fa-trash" ></i>Delete</span>
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