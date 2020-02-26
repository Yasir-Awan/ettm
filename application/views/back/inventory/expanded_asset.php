
            <div class="table-responsive >
            <div id="expanded_dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row hide_div">
                <div class="col-sm-12 pl-1 pr-1">
                  <!-- Add Assets & Action Button Start -->
                 
                  <!-- Add Assets & Action Button END -->
                      <table class="table table-bordered dataTable" id="expandedDataTable33" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: auto%;">
                  <thead>
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: auto;">SR #</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: auto;">Name</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: auto;">Current Status</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Current Site</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: auto;">Custody of</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                       <th rowspan="1" colspan="1">Sr #</th>
                       <th rowspan="1" colspan="1">Name</th>
                       <th rowspan="1" colspan="1">Current Status</th>
                       <th rowspan="1" colspan="1">Current Site</th>
                       <th rowspan="1" colspan="1">Custody of</th>
                    </tr>
                  </tfoot>
                  <tbody >
                  <?php
                    //  echo "<pre>"; print_r($assets);
                     $counter = 0;
                     $id=1;
                    //  $previousItem = $assets[0]['name'];
                    //  $currentItem;
                      foreach($expanded_data['expanded_data'] as $asset)
                      {
                        $items = $this->db->get_where('assets',array('name'=>$asset['name']))->result_array();
                        $assetName = $this->db->get_where('items',array('id'=>$asset['name']))->result_array();
                        // echo "<pre>"; print_r(count($items));
                        $counter++; 
                       // $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza']))->row()->name;
                       // $support = $this->db->get_where('supporting_document',array('mtr_id' => $row['id']))->result_array();
                    ?>

                   <!-- <tbody class="hidebody" style="display:none;"></tbody> -->
                                          
                  <tr role="row" class="odd" id="mainrow<?php echo $counter ?>" >
                      <td class="sorting_1">
                      <input type="checkbox" style="margin-left:15px; cursor:pointer;" onchange ="console.log(this.getAttribute('value'))" name="selection" id="ischecked" class="selection " value=<?php echo $asset['id'];?>>
                        <?php echo $counter;?>
                      </td>
                      <td>
                      <a href="#" onclick="show_asset('<?php echo base_url().'inventory/selected_asset/list/'.$asset['id'];?>','display_selected_asset');">
                      <?php 
                       $assetName = $this->db->get_where('items',array('id'=>$asset['name']))->result_array();
                       echo $assetName[0]['name'];  
                      ?>
                      </a>
                      </td>       
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
                             elseif($asset['action_status']=="9")
                             {
                               echo "Re Installed";
                             }
                             elseif($asset['action_status']=="10")
                             {
                               echo "Whole Equipment Faulty";
                             } 
                             elseif($asset['action_status']=="11")
                             {
                               echo $faulty_comp_name." Faulty";
                             }
                             elseif($asset['action_status']=="12")
                             {
                               echo $faulty_comp_name." Replaced";
                             }
                             elseif($asset['action_status']=="13")
                             {
                               echo $faulty_comp_name." Repairing Mode";
                             }
                             elseif($asset['action_status']=="14")
                             {
                               echo $faulty_comp_name." Reinstalled";
                             }
                             elseif($asset['action_status']=="15")
                             {
                               echo $faulty_comp_name." Retired";
                             }                                    
                            ?>
                      </td>
                      <td>
                      <?php
                            $site = $this->db->get_where('sites',array('id'=>$asset['site']))->result_array();
                            echo $site[0]['name'];
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
                      </tr>


                      <?php
                   $previousItem = $asset['name'];
                     } // loop Ends  ?>
                                         </tbody>
                   <!-- <tbody class="hidebody">
                   </tbody> -->
                </table>
                </div><!-- col-sm-12 END -->
             </div><!-- row END -->
             
            </div><!-- dataTable wrapper END -->
          </div>

             <div id='display_selected_asset' style="display:none;">
             </div>

             <div id='display_asset_history' style="display:none;">
             </div>


             <div id="divResult">
              </div> 

              <div id="expanded_asset">
              </div>  

             <!-- <div id='item_type_filter' class ="item_type_filter"></div> -->

            
            
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
<!-- <div class="modal fade" id="assets_retire">
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
</div> -->
<!-- Modal for Retire END -->

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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Install Equipment</h5>
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
<!-- <div class="modal fade" id="assets_repair">
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
</div> -->
<!-- Modal for start Repairing END -->

<!-- Modal for End Repair START -->
<!-- <div class="modal fade" id="assets_end_repair">
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
</div> -->
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
  
            var result = $('#expandedDataTable33').find('input[type="checkbox"]:checked');
           
        if( result.length == 0)
        {
          // alert("No Item is Selected. Please Select the item first.");
          notify('No Item is Selected. Please Select the item first.','danger','top','center');
          return;
        }
        else
        {
          $('#expandedDataTable33').find('input[type="checkbox"]:checked').each(function(){    
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
  $('.by_item_type').hide();
  $('.by_site').hide();
  $('.emptydiv').show();
}
if( filter_by == 1)
{
  $('.emptydiv').hide();
  $('.by_site').hide();
  $('.by_item_type').show('slow');
}
if( filter_by == 2)
{
  $('.emptydiv').hide();
  $('.by_item_type').hide();
  $('.by_site').show('slow');
}     
});
        </script>

        <script>$('body').on('change', '#astType', function (){
    
    var itm_type = this.value;
    //if(tollplaza){
        $.ajax({ 
            url: "<?php echo base_url();?>inventory/filterby_item_type/"+itm_type,
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('.hide_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);                
                  $('.hide_div').html(data);
                  $('#dataTable').DataTable();
                  $('.emptydiv').show();
                  $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                  $("[data-toggle='toggle']").bootstrapToggle();                               
            },
            error: function(e) {
                console.log(e)
            }
        });
   // }
  });</script>

<script>$('body').on('change', '#site', function (){
    var site = this.value;
    //if(tollplaza){
        $.ajax({ 
            url: "<?php echo base_url();?>inventory/filterby_site/"+site,
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('.hide_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('.hide_div').html(data); 
                 $('#dataTable').DataTable();
                 $('.emptydiv').show();
                 $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                 $("[data-toggle='toggle']").bootstrapToggle();
            },
            error: function(e) {
                console.log(e)
            }
        });
   // }
  });
  
  // function expandCollapse(assetName,id){
  //   var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
  //   var list = $('#'+id);
  //    console.log(id);
  //   assetName.classList.remove("fa-caret-square-down");
  //   assetName.classList.add("fa-caret-square-up");
  //   var tr = assetName.closest('tr');
  //   tr.classList.add("bg-light");
  //   var parent = assetName.closest('td');
  //   var tb = assetName.closest('tbody');
  //   console.log(tr.id.length);
  //   var inputValue = $(parent).find('input[type=hidden]').val();
  //   // console.log(document.getElementsByClassName('test'));
  //   var dynamic_rows = document.getElementById('trow'+tr.id)
  //   // console.log(dynamic_rows);
  //   if(dynamic_rows!== null){
  //     assetName.classList.remove("fa-caret-square-up");
  //     // tr.classList.remove("bg-light");
  //   assetName.classList.add("fa-caret-square-down");
  //     $('.trow'+tr.id).toggle();
  //   }
  //   else{
  //     // console.log("yasir") ;
  //            $.ajax({ 
  //             url: "<?php echo base_url() ?>inventory/expand/"+inputValue,
  //             cache       : false,
  //             contentType : false,
  //             processData : false,
  //             beforeSend: function() {
  //             list.html(loading_set);
  //             },
  //             success: function(data) {
                
  //               data = JSON.parse(data);
  //               // console.log(document.getElementById('tbody2'));
  //               let tbdy = 1;
  //               let sitecounter=0;
  //                 data.expanded_data.forEach(asset => {
  //                   // console.log(asset.id);
  //                   var row = '<tr role="row" class="trow'+tr.id+'" id="trow'+tr.id+'" class="collapse out" ><td><input style="margin-left:15px; cursor:pointer;" name="selection" id="ischecked" class="selection " value='+asset.id+' type="checkbox"></td><td> <a href="#" onclick=show_asset("<?php echo base_url().'inventory/selected_asset/list/'?>'+asset.id+'","display_selected_asset")>'+data.naam+'</a></td><td>'+data.action_status[sitecounter]+'</td><td>'+data.sites[sitecounter++]+'</td><td></td></tr>'
  //                    $('#'+tr.id).after(row);
                     
  //                     if(assetName.className==='fa-caret-square-up'){
  //                     $('.fa-caret-square-up').slideToggle();
  //                   //   // console.log(assetName.className);
  //                   //   assetName.className.addEventListener('click',collapse());
  //                    }
  //                    tbdy++;
  //                 });  
  //               },
  //             error: function(e) {
  //             //  console.log(e)
  //             }
  //         });
  //       }
  //       }

  </script>
