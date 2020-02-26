<!-- <div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12 pl-1 pr-1"> -->
                  <!-- Add Assets & Action Button Start -->
                    <!-- <div class='row mb-1 mt-1' >
                      <div class='col-md-4'> -->
                     
                       </div><!-- col-md-4 END -->
                       
                       <!-- <div class="col-md-4"> -->

                         </div><!-- col-md-4 END -->
                        <!-- <div class='col-md-4'>
                          <button type="button" class="btn btn-primary btn-xs pull-right" style="line-height: 0.5; " data-toggle="modal" data-target="#add_locations" onclick="ajax_html('<?php echo base_url()?>inventory/add_location/','adding_locations');">
                              Add Location </button>
                         </div> col-md-4 END -->
                     </div><!-- row END -->
                   <!-- Add Assets & Action Button END -->
  <!--**********************************************************-->
  <!--******************* MODAL WINDOWS START ******************-->
  <!--**********************************************************-->
 
  <!-- Sub Modal b START -->
  <!-- <div class="modal fade" id="add_locations" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Location</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">    
<div id="adding_locations"></div>
        </div>
        
      </div>
    </div> -->
  </div><!-- Sub Modal b END -->

  <!-- Sub Modal c START -->
  <!-- <div class="modal fade" id="location-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Location</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">    
  <div id="edit_location_contents"></div>
        </div>
        
      </div>
    </div> -->
  </div><!-- Sub Modal c END -->

  
  <!--**********************************************************-->
  <!--******************* MODAL WINDOWS END ********************-->
  <!--**********************************************************-->

                      <!-- <table class="table table-bordered dataTable" id="dataTable4" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                  <thead align='center'>
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: auto;">Sr #</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: auto;">Name</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: auto;">Action</th>
                    </tr>
                  </thead>
                  <tfoot align='center'>
                    <tr>
                       <th rowspan="1" colspan="1">Sr #</th>
                       <th rowspan="1" colspan="1">Name</th>
                       <th rowspan="1" colspan="1">Action</th>
                    </tr>
                  </tfoot>
                  <tbody align='center'> 
                  <?php
                      //   $counter = 0;
                      //  foreach($locations as $location){
                      //   $counter++; 
                    ?>

                  <tr role="row" class="odd">
                      <td class="sorting_1"><?php echo $counter;?></td>
                      <td><?php echo $location['name'];?></td>
                      <td><span class="btn btn-success btn-xs btn-labeled fas fa-edit" id="cancel_reason" name="location_edit"  data-toggle="modal" data-target="#location-edit" onclick="ajax_html('<?php echo base_url().'inventory/location_edit/'.$location['id'];?>','edit_location_contents');">&nbsp;Edit</span>
                     &nbsp
                    <span class="btn btn-danger btn-xs  fas fa-trash-alt" onclick="delete_confirm_tab('Really want to delete This','<?php echo base_url().'inventory/locations/delete/'.$location['id'];?>')" > 
                    Delete</span></td>
                      <?php // } ?>
                    </tr>
                   </tbody>
                </table> -->
                </div><!-- col-sm-12 END -->
             </div><!-- row END -->
             
            </div><!-- dataTable wrapper END -->
          </div>
          <script>
          // $(document).ready(function(){
          //   $('#dataTable4').DataTable();
          // })
          </script>

<script>
//     var base_url = '<?php echo base_url(); ?>';
//     var user_type = 'inventory';
//     var module = 'locations';
//     var list_cont_func = 'list';
//     var dlt_cont_func = 'delete';
//     $(document).ready(function(){
//         $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
//         $("[data-toggle='toggle']").bootstrapToggle();
//     });
//     $('body').on('click','a.paginate_button',function(){
//     //alert();
//        $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
//         $("[data-toggle='toggle']").bootstrapToggle();
        
//     });
//      $('a.paginate_bustton').on('click',function(){
//     //alert('here');
// });
//      $('body').on('change', 'input[name=toggle]', function (){
    
//     var mode = $(this).prop('checked');
//     var id=$( this ).val();
//     $.ajax({
//       type:'POST',
//       url:'<?php echo base_url()?>inventory/locations/sites_publish_set/' + id + '/'+ mode,
//       cache       : false,
//       contentType : false,
//       processData : false,
      
//       success:function(data)
//       { 
//                 var obj = data;
//                 console.log(data);
//                 if(obj == 'true'){
                    
//                     notify('Active Successfully','success','top','right');
//                 }else{
//                     notify('Inactive Successfully','danger','top','right');
//                 }
//                 //progress.html('');
            
//       }
//     });
//   });
 
</script>