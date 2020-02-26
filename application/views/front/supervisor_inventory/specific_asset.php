<div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Notifications </h4>

              </div>
              <div class="card-body">
              <div class="table-responsive hide_div" style="">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12 pl-1 pr-1">
                  
                  <!-- Add Assets & Action Button Start -->

                   <!-- Add Assets & Action Button END -->
                   
                      <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: auto%;">
                  <thead>
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: auto;">SR #</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: auto;">Name</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Description</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: auto;">Current Status</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: auto;">Custody of</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                       <th rowspan="1" colspan="1">Sr #</th>
                       <th rowspan="1" colspan="1">Name</th>
                       <th rowspan="1" colspan="1">Description</th>
                       <th rowspan="1" colspan="1">Current Status</th>
                       <th rowspan="1" colspan="1">Custody of</th>
                    </tr>
                  </tfoot>
                  <tbody> 
                  <?php
                     $counter = 0;
                      foreach($assets as $asset)
                      {
                      $counter++; 
                       // $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza']))->row()->name;
                       // $support = $this->db->get_where('supporting_document',array('mtr_id' => $row['id']))->result_array();
                    ?>                   
                  <tr role="row" class="odd">
                      <td class="sorting_1">
                      <input type="checkbox" onchange = "console.log(this.getAttribute('value'))" name="selection" id="ischecked" class="selection" value=<?php echo $asset['id'];?>>
                        <?php echo $counter;?>
                      </td>
                      <td>
                      <a href="#" onclick="show_asset('<?php echo base_url().'supervisor_inventory/selected_asset/list/'.$asset['id'];?>','display_selected_asset');">
                      <?php 
                       $assetName = $this->db->get_where('items',array('id'=>$asset['name']))->result_array();
                       echo $assetName[0]['name'];  
                      ?>
                      </a>
                      </td>
                      <td>
                      <?php $assetDescription = $this->db->get_where('items',array('id'=>$asset['name']))->result_array(); ?>               
                      <?php echo $assetDescription[0]['description'];?></td>
                      <td>
                         <?php 
                            if($asset['action_status']=="0")
                             {
                               echo "Brand New";
                             }
                             elseif($asset['action_status']=="1")
                             {
                               echo "Checked Out";
                             }
                             elseif($asset['action_status']=="2")
                             {
                               echo "Checked In";
                             }
                             elseif($asset['action_status']=="3")
                             {
                               echo "Installed";
                             } 
                             elseif($asset['action_status']=="4")
                             {
                               echo "Repairing Mode";
                             }
                             elseif($asset['action_status']=="5")
                             {
                               echo "Repaired";
                             } 
                             elseif($asset['action_status']=="6")
                             {
                               echo "Retired";
                             }                                
                            ?>
                      </td>
                      <td>
                      <?php if($asset['action_status']==1){?>
                         <?php if($asset['checkout_user_type']=="1"){ 
                               $checkout_to = $this->db->get_where('admin',array('id' => $asset['checkout_to']))->result_array(); 
                               echo $checkout_to[0]['fname']." ".$checkout_to[0]['lname']; 
                              } ?>

                         <?php if($asset['checkout_user_type']=="2"){ 
                               $checkout_to = $this->db->get_where('member',array('id' => $asset['checkout_to']))->result_array();
                               echo $checkout_to[0]['fname']." ".$checkout_to[0]['lname']; 
                               } ?>

                         <?php if($asset['checkout_user_type']=="3"){ 
                               $checkout_to = $this->db->get_where('tpsupervisor',array('id' => $asset['checkout_to']))->result_array(); 
                               //echo "<pre>"; print_r($checkout_to);// exit;
                                 echo $checkout_to[0]['fname']." ".$checkout_to[0]['lname'];
                               } ?>

                               
                       <?php } ?>
                      </td>
                      <?php } ?>
                    </tr>
                   </tbody>
                </table>
                </div><!-- col-sm-12 END -->
             </div><!-- row END -->
             
            </div><!-- dataTable wrapper END -->
          </div>
        <div id='display_selected_asset' style="display:none;">
        </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>




             <div id="divResult">
              </div> 

             <div id='item_type_filter' class ="item_type_filter"></div>

             <div id='site_filter' class ="site_filter"></div>
            
             <!--**********************************************************-->
  <!--******************* MODAL WINDOWS START ******************-->
  <!--**********************************************************-->

    <!-- Modal for Edit Asset START -->
    <div class="modal fade" id="assets-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Asset</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="edit_asset_contents">
              </div>  
            </div>
            
        </div>
    </div>
</div><!-- Modal for Edit Asset END -->

<div id="result"></div>

<!-- Modal for CheckIN  START -->
<div class="modal fade" id="assets_checkin">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Check In Site</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="checkin_asset_contents">
              </div> 
            </div>
        </div>
    </div>
</div><!-- Modal for CheckIn END -->

<!-- Modal for CheckOut  START -->
<div class="modal fade" id="assets_checkout">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Checkout</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="checkout_asset_contents">
              </div> 
            </div>
        </div>
    </div>
</div><!-- Modal for CheckOut END -->

<!-- Modal for Retire  START -->
<div class="modal fade" id="assets_retire">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Retire Asset</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="retire_asset_contents">
              </div>  
            </div>
        </div>
    </div>
</div><!-- Modal for Retire END -->

<!-- Modal for Extend Checkout  START -->
<div class="modal fade" id="assets_extend_checkout">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Extend Checkout</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="extendcheckout_asset_contents">
              </div>  
            </div>
        </div>
    </div>
</div><!-- Modal for Extend Checkout END -->

<!-- Modal for Install START -->
<div class="modal fade" id="assets_install">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Install Items</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="install_asset_contents">
              </div>  
            </div>
        </div>
    </div>
</div><!-- Modal for Install END -->

<!-- Modal for Repair START -->
<div class="modal fade" id="assets_repair">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Repair Start</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="start_repair_assets">
              </div>  
            </div>
        </div>
    </div>
</div><!-- Modal for start Repairing END -->

<!-- Modal for End Repair START -->
<div class="modal fade" id="assets_end_repair">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Repair Complete</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="end_repair_assets">
              </div>  
            </div>
        </div>
    </div>
</div><!-- Modal for End Repairing END -->

  
  
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
  function show_asset(url,id)
{
	var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';	
	var list = $('#'+id);
	$.ajax({
		url: url,
		beforeSend: function() {
			list.html(loading_set);
		},
		success: function(data){
      $('.hide_div').toggle();
			$('#display_selected_asset').html(data).show('slow');
		},
		error: function(e) {		
			//notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
		}
	});
}
  </script>
  <script>

function ajax_html_cust(url,id){
	var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
  var list = $('#'+id);
  var assets = [];
  
            var result = $('#dataTable').find('input[type="checkbox"]:checked');
           
        if( result.length == 0)
        {
          // alert("No Item is Selected. Please Select the item first.");
          notify('No Item is Selected. Please Select the item first.','danger','top','center');
          return;
        }
        else
        {
          $('#dataTable').find('input[type="checkbox"]:checked').each(function(){    
         assets.push($(this).val());
         //alert($(this).val())
        });
        }
     
     
     
    var data1 = assets.join(",");
	$.ajax({
    url: url,
    method:"post",
    data:{asset:data1},
		beforeSend: function() {
			list.html(loading_set);
		},
		success: function(data) {
			list.html('');
			list.html(data).fadeIn();
		
		},
		error: function(e) {
			
			//notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
		}
	});
}
</script>

<script>
         $(document).ready(function(){
            $('#filter').change();
        });
$('body').on('change', "#filter", function (){    
var filter_by = this.value;
//  console.log(issuance_type);
if( filter_by == 0)
{
  $('.by_site').hide();
  $('.by_item_type').hide();
  $('.emptydiv').show();
}
if( filter_by == 1)
{
  $('.emptydiv').hide();
  $('.by_item_type').hide();
  $('.by_site').show('slow');
}
if( filter_by == 2)
{
  $('.emptydiv').hide();
  $('.by_site').hide();
  $('.by_item_type').show('slow');
}     
});
        </script>
          <script>
          $(document).ready(function(){
            $('#dataTable').DataTable();
          })
          </script>
                <script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'supervisor_inventory';
    var module = 'specific_asset';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    $(document).ready(function(){
        //$("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        //$("[data-toggle='toggle']").bootstrapToggle();
    });
    $('body').on('click','a.paginate_button',function(){
    //alert();
       //$("[data-toggle='toggle']").bootstrapToggle('destroy'); 
       // $("[data-toggle='toggle']").bootstrapToggle();
        
    });
     $('a.paginate_button').on('click',function(){
    //alert('here');
});

$(document).ready(function(){
    
            $.ajax({ 
            url: "<?php echo base_url();?>supervisor_inventory/specific_asset/list/<?php echo $asset_id ?>",
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('#list').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                  $('#list').html(data);
                  $('#dataTable3').DataTable();
                  ////$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                  //$("[data-toggle='toggle']").bootstrapToggle();
                                
            },
            error: function(e) {
                console.log(e)
            }
            });
        
        
        });
    
</script>
