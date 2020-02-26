
<div class="table-responsive hide_div" style="">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 mt-4">
              <div class="row">
                <div class="col-sm-12 pl-1 pr-1">
                 
                  <table class="table table-bordered dataTable" id="accidenttable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: auto%;">
                  <thead>
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: auto;">SR #</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: auto;">Accident Date</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: auto;">Accident Address</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                       <th rowspan="1" colspan="1">Sr #</th>
                       <th rowspan="1" colspan="1">Accident Date</th>
                       <th rowspan="1" colspan="1">Accident Address</th>
                       <th rowspan="1" colspan="1">Action</th>
                    </tr>
                  </tfoot>
                  <tbody> 
                  <?php
                     $counter = 0;
                      foreach($cd as $row)
                       {
                      $counter++; 
                       // $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza']))->row()->name;
                       // $support = $this->db->get_where('supporting_document',array('mtr_id' => $row['id']))->result_array();
                    ?>                   
                  <tr role="row" class="odd">
                      <td class="sorting_1">

                        <?php echo $counter;?>
                      </td>
                      <td>

                      <?php 
                       echo $row['crash_time'];  
                      ?>
                      </td>
                     
                      <td>
                         <?php  echo $row['address']; ?>
                      </td>
                      <td>
                      <a href="<?php echo base_url()?>admin_crash/accident_detail/<?php echo $row['id']?>" class="btn-info btn-xs" target="__blank"><i class="fa fa-eye"></i> View</a>
                            <!-- <a href="<?php echo base_url()?>uploads/mtr/<?php // echo $row['file'];?>" style="background-color: #6c757d" class="btn-info btn-xs fa fa-paperclip" target="__blank"> View Attachment</a> -->
                            <?php // if($support){?>
                          <span class="btn-primary btn-xs fa fa-eye" style="background-color: #820484;" onclick="ajax_html('<?php echo base_url().'admin_crash/view_attachment/'.$row['id'];?>','crash_photos');" data-toggle="modal" data-target="#crash_attachment"> Suppporting Files</span>
                          <?php // } ?>
                          <?php // if($this->session->userdata('role') == 1) {?>
                          <span class="btn-danger btn-xs fa fa-trash" onclick=""> Delete</span>
                          <?php // } ?>
                        </td>
                      <script>
                        $(document).ready(function(){
                          delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')
                
                        });
                        </script>
                      <?php  } ?>
                    </tr>
                   </tbody>
                </table>
                </div><!-- col-sm-12 END -->
             </div><!-- row END -->
             
            </div><!-- dataTable wrapper END -->
          </div>

            
            
            
 


<script>
var base_url = '<?php echo base_url(); ?>';
    var user_type = 'admin_crash';
    var module = 'crash_data';
    var list_cont_func = 'list';
    var list_dlt_func = 'delete';
    $(document).ready(function(){
        $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        $("[data-toggle='toggle']").bootstrapToggle();
    });
    $('body').on('click','a.paginate_button',function(){
    //alert();
       $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        $("[data-toggle='toggle']").bootstrapToggle();
        
    });
     $('a.paginate_button').on('click',function(){
    //alert('here');
})
</script>
