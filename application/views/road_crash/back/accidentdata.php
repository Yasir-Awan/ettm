<?php include('includes/header.php'); ?>
<div class="main-content-inner mt-5">
<div class="card">
<div class="card-body">
<div class="row">
                                    <div class="col-md-4">
                                        <h4 class="header-title">Accidents List</h4>
                                    </div>
                                </div>
<div class="table-responsive hide_div" style="">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4 mt-4">
              <div class="row">
                <div class="col-sm-12 pl-1 pr-1">
                 
                      <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: auto%;">
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
                          <span class="btn-danger btn-xs fa fa-trash" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"> Delete</span>
                          <?php // } ?>
                        </td>
                      
                      <?php  } ?>
                    </tr>
                   </tbody>
                </table>
                </div><!-- col-sm-12 END -->
             </div><!-- row END -->
             
            </div><!-- dataTable wrapper END -->
          </div>
          </div> <!-- card body END -->
          </div> <!-- card END -->
          </div> <!-- main content inner END -->
            
            
            
             <!--**********************************************************-->
  <!--******************* MODAL WINDOWS START ******************-->
  <!--**********************************************************-->

  
    <!-- Modal for Edit Asset START -->
    
<!-- Modal for Edit Asset END -->



<!-- Modal for CheckIN  START -->
<!-- Modal for CheckIn END -->

<!-- Modal for CheckOut  START -->
<!-- Modal for CheckOut END -->

<!-- Modal for Retire  START -->
<!-- Modal for Retire END -->

<!-- Modal for Extend Checkout  START -->
<!-- Modal for Extend Checkout END -->

<!-- Modal for Install START -->
<!-- Modal for Install END -->

<!-- Modal for Repair START -->
<!-- Modal for start Repairing END -->

<!-- Modal for End Repair START -->
<!-- Modal for End Repairing END -->

  
  
  <!--**********************************************************-->
  <!--******************* MODAL WINDOWS END ********************-->
  <!--**********************************************************-->
 <!-- <script>
 $(document).ready(function(){
   $('.submin').click(function(){
     $('input[type="checkbox"]:unchecked').
   })

 });
 </script> -->
 

<script>
         $(document).ready(function(){
            $('#filter').change();
        });
$('body').on('change', "#filter", function (){    
var filter_by = this.value;
//  console.log(issuance_type);
if( filter_by == 0)
{
  $('.by_item_type').hide();
  $('.emptydiv').show();
}
if( filter_by == 1)
{
  $('.emptydiv').hide();
  $('.by_item_type').show('slow');
}     
});
</script>



        


<div class="modal fade" id="crash_attachment">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Accident Images</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="crash_photos">
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<?php include('includes/footer.php'); ?>