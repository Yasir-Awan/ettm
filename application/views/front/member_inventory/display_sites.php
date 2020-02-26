<div class="table-responsive">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12 pl-1 pr-1">
                  <!-- Add Assets & Action Button Start -->
                    <div class='row mb-1 mt-1' >
                      <div class='col-md-4'>
                       </div><!-- col-md-4 END -->
                       
                       <div class="col-md-4">

                         </div><!-- col-md-4 END -->
                        <div class='col-md-4'>
                          <button type="button" class="btn btn-primary btn-xs pull-right" style="line-height: 0.5; " data-toggle="modal" data-target="#site-modal" onclick="ajax_html('<?php echo base_url()?>member_inventory/add_site/','adding_sites');">
                              Add Sites </button>
                         </div> <!-- col-md-4 END -->
                     </div><!-- row END -->
                   <!-- Add Assets & Action Button END -->


                      <table class="table table-bordered dataTable" id="dataTable_3" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                  <thead align="center">
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: auto;">SR #</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: auto;">SITE NAME</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: auto;">ACTION</th>
                    </tr>
                  </thead>
                  <tfoot align="center">
                    <tr>
                       <th rowspan="1" colspan="1">SR #</th>
                       <th rowspan="1" colspan="1">SITE NAME</th>
                       <th rowspan="1" colspan="1">ACTION</th>
                    </tr>
                  </tfoot>
                  <tbody align="center" >
                  <?php
                        $counter = 0;
                       foreach($sites as $site){
                        $counter++; 
                       // $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza']))->row()->name;
                       // $support = $this->db->get_where('supporting_document',array('mtr_id' => $row['id']))->result_array();
                        ?>                       
                  <tr role="row" class="odd">
                      <td class="sorting_1"><?php echo $counter;?></td>
                      <td><?php echo $site['name'];?></td>
                      <td> <span class="btn btn-success btn-xs btn-labeled fas fa-edit" id="cancel_reason" name="site_edit" onclick="ajax_html('<?php echo base_url().'member_inventory/site_edit/'.$site['id'];?>','edit_site_contents');" data-toggle="modal" data-target="#site-edit">&nbsp;Edit</span>
                     &nbsp
                    <span class="btn btn-danger btn-xs  fas fa-trash-alt" onclick="delete_confirm_tab('Really want to delete This','<?php echo base_url().'member_inventory/sites/delete/'.$site['id'];?>')" > 
                    Delete</span></td>
                       <?php } ?>
                    </tr>
                    
                   </tbody>
                </table>
                </div><!-- col-sm-12 END -->
             </div><!-- row END -->
             
            </div><!-- dataTable wrapper END -->
          </div>


         

          
  <!--**********************************************************-->
  <!--******************* MODAL WINDOWS START ******************-->
  <!--**********************************************************-->
  
  <!-- SITE Modal START -->
  <div class="modal fade" id="site-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">NEW SITE</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">    
  <div id="adding_sites"></div>
        </div>
        <!--div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Add OMC</button>
        </div-->
      </div>
    </div>
  </div><!-- SITES Modal END -->

    <!-- Sub Modal for Add Item's Name START -->
    <div class="modal fade" id="site-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Item </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div id="edit_site_contents">
              </div> 
        </div>
        <!--div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div-->
      </div>
    </div>
  </div><!-- Sub Modal for Add Item's Name END -->

  
  
  <!--**********************************************************-->
  <!--******************* MODAL WINDOWS END ********************-->
  <!--**********************************************************-->
  <script>
          $(document).ready(function(){
            $('#dataTable_3').DataTable();
          })
          </script>





<script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'inventory';
    var module = 'sites';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    $(document).ready(function(){
        $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        $("[data-toggle='toggle']").bootstrapToggle();
    });
    $('body').on('click','a.paginate_button',function(){
    //alert();
       $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        $("[data-toggle='toggle']").bootstrapToggle();
        
    });
     $('a.paginate_bustton').on('click',function(){
    //alert('here');
});
     $('body').on('change', 'input[name=toggle]', function (){
    
    var mode = $(this).prop('checked');
    var id=$( this ).val();
    $.ajax({
      type:'POST',
      url:'<?php echo base_url()?>inventory/sites/sites_publish_set/' + id + '/'+ mode,
      cache       : false,
      contentType : false,
      processData : false,
      
      success:function(data)
      { 
                var obj = data;
                console.log(data);
                if(obj == 'true'){
                    
                    notify('Active Successfully','success','top','right');
                }else{
                    notify('Inactive Successfully','danger','top','right');
                }
                //progress.html('');
            
      }
    });
  });
 
</script>