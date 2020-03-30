<div class="table-responsive hide_div" style="">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12 pl-1 pr-1">
                  <!-- Add Assets & Action Button Start -->

                    <div class='row mb-1 mt-1'>
                      <div class='col-md-4'>
                      <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="btn btn-primary btn-sm" style='line-height: 0.5;' name="submit" >Action</button>
                        <div class="btn-group" role="group">
                          <button id="btnGroupDrop1" type="button" style='line-height: 0.5;' class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                          <div class="dropdown-menu" id="action_btn" aria-labelledby="btnGroupDrop1">
                          <!-- <a class="dropdown-item submit" href="#"  value="Checkout" data-toggle="modal" data-target="#assets_checkout" onclick="ajax_html_cust('<?php echo base_url()?>inventory/action_on_asset/checkout/','checkout_asset_contents');"> Checkout</a>
                           <a class="dropdown-item far fa-arrow-circle-down-alt submit"  value="Checkin" href="#" data-toggle="modal" data-target="#assets_checkin" onclick="ajax_html_cust('<?php echo base_url()?>inventory/action_on_asset/checkin/','checkin_asset_contents');">Checkin</a> -->
                           <!-- <a class="dropdown-item submit" href="#"  value="Checkout" data-toggle="modal" data-target="#assets_install" onclick="ajax_html_cust('<?php echo base_url()?>inventory/action_on_asset/install/','install_asset_contents');"> Install</a> -->
                           <a class="dropdown-item submit" href="#"  ><input placeholder="quantity" type="number" name="cl_qty" id="cl_qty" style="width:82%; margin-left:-11%; border:unset;" max="15" min="1" > <span class="btn btn-primary btn-xs clickmethen" data-toggle="modal" data-target="#clone">Clone</span></a>
                           <!-- <a class="dropdown-item submit" href="#" id="clon" value="Clone" data-toggle="modal" data-target="#c_qty" >Clone </a> -->
                           <a class="dropdown-item submit" href="#"  value="Faulty" data-toggle="modal" data-target="#assets_faulty" onclick="ajax_html_cust('<?php echo base_url()?>inventory/action_on_asset/faulty/','start_faulty_assets');">Faulty</a>
                           <a class="dropdown-item submit" href="#"  value="Repair" data-toggle="modal" data-target="#assets_repair" onclick="ajax_html_cust('<?php echo base_url()?>inventory/action_on_asset/start_repair/','start_repair_assets');">Repair</a>
                           <a class="dropdown-item submit" href="#"  value="Repair" data-toggle="modal" data-target="#assets_end_repair" onclick="ajax_html_cust('<?php echo base_url()?>inventory/action_on_asset/end_repair/','end_repair_assets');">Reinstall</a>
                           <a class="dropdown-item submit" href="#"  value="Retire" data-toggle="modal" data-target="#assets_retire" onclick="ajax_html_cust('<?php echo base_url()?>inventory/action_on_asset/retire/','retire_asset_contents');"> Retire</a>
                           </div>
                         </div>
                       </div>
                       </div><!-- col-md-4 END -->

                       <div class="col-md-2" style="padding:unset;">
                         <select class="form-control required pull-left" name="installfilter" id="installfilter" style="content: none;">
                            <option value="0">Filter By</option>
                            <!-- <option value="1">Item Type</option> -->
                            <option value="2">Site</option>
                           </select>
                         </div><!-- col-md-2 END -->
                         <div class="col-md-2 blankdiv" style="display:none;">
                         </div>
                         <div class="col-md-2 installed_by_site" style="display:none; padding: unset;">
                         <select class="form-control required" id="installedsite" >
                         <option value="">Choose Type</option>
                         <?php foreach($sites as $site) { ?>
                            <option value="<?php echo $site['id'] ?>"><?php echo $site['name']?></option>
                         <?php } ?>
                           </select>
                         </div>
                         <!-- col-md-2 END -->

                        <div class='col-md-4' style='width:auto;'>
                          <!-- <button type="button" class="btn btn-primary btn-xs pull-right" style="line-height: 0.5; " data-toggle="modal" data-target="#addassets" onclick="ajax_html('<?php echo base_url()?>inventory/add_asset/','adding_assets');">
                              Add Asset </button> -->
                         </div><!-- col-md-4 END -->
                     </div><!-- row END -->
                   <!-- Add Assets & Action Button END -->
                    <table class="table table-bordered dataTable" id="installed_items_table" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: auto%;">
                      <thead>
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: auto;">SR #</th>
                      <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: auto;">Name</th>
                      <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: auto;">Category</th>
                      <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: auto;">Serial No</th>
                      <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: auto;">Status</th>
                      <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Site</th>
                      <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: auto;">Location</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                       <th rowspan="1" colspan="1">Sr #</th>
                       <th rowspan="1" colspan="1">Name</th>
                       <th rowspan="1" colspan="1">Category</th>
                       <th rowspan="1" colspan="1">Serial No</th>
                       <th rowspan="1" colspan="1">Status</th>
                       <th rowspan="1" colspan="1">Site</th>
                       <th rowspan="1" colspan="1">location</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  <?php
                     $counter = 0;
                      foreach($installs as $install)
                      {
                      $counter++;
                    ?>
                  <tr role="row" class="odd">
                      <td class="sorting_1">
                      <input type="checkbox" onchange = "console.log(this.getAttribute('value'))" name="selection" id="ischecked" class="selection" value=<?php echo $install['id'];?>>
                        <?php echo $counter;?>
                      </td>
                      <td>
                      <a href="#" onclick="show_asset('<?php echo base_url().'inventory/selected_install/list/'.$install['id'];?>','display_selected_install');">
                      <?php
                       $item = $this->db->get_where('items',array('id'=>$install['name']))->result_array();
                       echo $item[0]['name'];
                      ?>
                      </a>
                      </td>

                      <td>  <?php
                                  if($item[0]['item_type']==1)
                                  {
                                    echo "Marketing & Promotional Type";
                                  }
                                  elseif($item[0]['item_type']==2)
                                  {
                                    echo "Event & stagging Equipment";
                                  }
                                  elseif($item[0]['item_type']==3)
                                  {
                                    echo "Electronic Equipment";
                                  }
                                  elseif($item[0]['item_type']==4)
                                  {
                                    echo "Support Room Equipment";
                                  }
                                  elseif($item[0]['item_type']==5)
                                  {
                                    echo "Cashup Room Equipment";
                                  }
                                  elseif($item[0]['item_type']==6)
                                  {
                                    echo "Control Room Equipment";
                                  }
                                  elseif($item[0]['item_type']==7)
                                  {
                                    echo "Power Supply Equipment";
                                  }
                                  elseif($item[0]['item_type']==8)
                                  {
                                    echo"Lane Equipment";
                                  }
                                  elseif($item[0]['item_type']==9)
                                  {
                                    echo"Booth Equipment";
                                  }
                                  elseif($item[0]['item_type']==10)
                                  {
                                    echo"Consumeables";
                                  }
                                  elseif($item[0]['item_type']==11)
                                  {
                                    echo"Furniture";
                                  }
                                  elseif($item[0]['item_type']==12)
                                  {
                                    echo"IT Assets";
                                  }
                                  elseif($item[0]['item_type']==13)
                                  {
                                    echo"Tools";
                                  }
                        ?></td>
                        <td><?php echo $install['serial_no'] ?></td>
                      <td>
                         <?php
                            if($install['transaction_type']=="0")
                             {
                               echo "Brand New";
                             }
                             elseif($install['transaction_type']=="1")
                             {
                               echo "Checked Out";
                             }
                             elseif($install['transaction_type']=="2")
                             {
                               echo "Checked In";
                             }
                             elseif($install['transaction_type']=="3")
                             {
                               echo "Installed";
                             }
                             elseif($install['transaction_type']=="4")
                             {
                               echo "Repairing Mode";
                             }
                             elseif($install['transaction_type']=="5")
                             {
                               echo "Repaired";
                             }
                             elseif($install['transaction_type']=="6")
                             {
                               echo "Retired";
                             }
                             elseif($install['transaction_type']=="9")
                             {
                               echo "Re Installed";
                             }
                             elseif($install['transaction_type']=="10")
                             {
                               echo "Faulty";
                             }
                             elseif($install['transaction_type']=="11")
                             {
                               echo $faulty_comp_name." Faulty";
                             }
                             elseif($install['transaction_type']=="12")
                             {
                               echo $faulty_comp_name." Replaced";
                             }
                             elseif($install['transaction_type']=="13")
                             {
                               echo $faulty_comp_name." Repairing Mode";
                             }
                             elseif($install['transaction_type']=="14")
                             {
                               echo $faulty_comp_name." Reinstalled";
                             }
                             elseif($install['transaction_type']=="15")
                             {
                               echo $faulty_comp_name." Retired";
                             }
                            ?>
                      </td>
                      <td>
                      <?php
                            $site = $this->db->get_where('sites',array('id'=>$install['site']))->result_array();
                            echo $site[0]['name'];
                          ?>
                        </td>
                      <td>
                    <?php
                        $location = $this->db->get_where('locations',array('id' => $install['location']))->result_array();
                         echo $location[0]['location'];
                        ?>
                      </td>
                      <?php } ?>
                    </tr>
                   </tbody>
                </table>
                </div><!-- col-sm-12 END -->
             </div><!-- row END -->

            </div><!-- dataTable wrapper END -->
          </div>

             <div id='display_selected_install' style="display:none;">
             </div>

             <div id='display_install_history' style="display:none;">
             </div>


             <div id="divResult">
              </div>

             <!-- <div id='item_type_filter' class ="item_type_filter"></div> -->



             <!--**********************************************************-->
  <!--******************* MODAL WINDOWS START ******************-->
  <!--**********************************************************-->

  <!-- Modal for CheckIN  START -->
<!-- <div class="modal fade" id="assets_checkin">
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
</div> -->
<!-- Modal for CheckIn END -->

<!-- Modal for CheckOut  START -->
<!-- <div class="modal fade" id="assets_checkout">
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
</div> -->
<!-- Modal for CheckOut END -->

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
</div>
<!-- Modal for Edit Asset END -->

    <!-- Modal for Clone Quantity START -->
    <!-- <div class="modal fade" id="c_qty">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Clone Quantity</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
            <div class="form-group">
          <div class='row'>

             <div class="col-md-8">
             <form onsubmit="myFunction()">
             <input class="form-control" type="number" name='cl_qty' id='cl_qty' value="" max='15'>
             <button type="submit" class="btn btn-primary pull-right"  >Confirm</button>
              </form>
             </div>
          </div>
              </div>
            </div>

        </div>
    </div>
</div> -->
<!-- Modal for Clone Quantity END -->

    <!-- Modal for Edit Asset START -->
    <div class="modal fade" id="clone" style="margin-left:2%;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="">
            <div class="modal-header">
                <h5 class="modal-title">Clone</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="">
              <div id="clone_contents">
  
              </div>
            </div>

        </div>
    </div>
</div>
<!-- Modal for Edit Asset END -->

<div id="result"></div>


<!-- Modal for Retire  START -->
<div class="modal fade" id="assets_retire">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Retire </h5>
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

<!-- Modal for Repair START -->
<div class="modal fade" id="assets_repair">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Start Repairing</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="start_repair_assets">
              </div>
            </div>
        </div>
    </div>
</div><!-- Modal for start Repairing END -->

<!-- Modal for Faulty START -->
<div class="modal fade" id="assets_faulty">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Equipment Faulty</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="start_faulty_assets">
                             
              </div>
            </div>
        </div>
    </div>
</div><!-- Modal for Faulty END -->

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

<script>
        $(document).ready(function(){
        $('#installed_items_table').DataTable();
        })
</script>
<script>
function myFunction(){
  var qty = $('#cl_qty').val();
  // alert(qty);
  var url = "<?php echo base_url() ?>inventory/action_on_asset/clone/"+qty;
  var id ='clone_contents';
  // console.log(url);

  var a = document.createElement('a');
    a.setAttribute("id","rclone");
    a.setAttribute("data-toggle","modal");
    a.setAttribute("href","#clone_contents");
    a.setAttribute("onclick",ajax_html_cust(url,id));

    $('#clone').modal();
    // a.innerHTML = '<a id="rclone" data-toggle="modal" href="#clone" onclick="ajax_html_cust(url,id)" ></a>';
    // $('#action_btn').appendChild(a);

  $(document).ready(function(){
  $('#rclone').click();
  });

}
</script>

<script>

function ajax_html_cust(url,id){
  // alert(url);
  var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
  var list = $('#'+id);
  var assets = [];

        var result = $('#installed_items_table').find('input[type="checkbox"]:checked');

        if( result.length == 0)
        {
          // alert("No Item is Selected. Please Select the item first.");
          notify('No Item is Selected. Please Select the item first.','danger','top','center');
          return;
        }
        else
        {
          $('#installed_items_table').find('input[type="checkbox"]:checked').each(function(){
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
      $('#display_selected_install').html(data).show('slow');
    },
    error: function(e) {
      //notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
    }
  });
}
  </script>

<script>
         $(document).ready(function(){
            $('#installfilter').change();
        });
$('body').on('change', "#installfilter", function (){
var filter_by = this.value;
//  console.log(issuance_type);
if( filter_by == 0)
{
  $('.installed_by_site').hide();
  // $('.by_item_type').hide();
  $('.blankdiv').show();
}
// if( filter_by == 1)
// {
//   $('.installed_by_site').hide();
//   $('.blankdiv').hide();
//   $('.by_item_type').show();
// }
if( filter_by == 2)
{
  $('.blankdiv').hide();
  $('.by_item_type').hide();
  $('.installed_by_site').show();
}
});
        </script>


<script>$('body').on('change', '#installedsite', function (){

    var site = this.value;
    //if(tollplaza){
        $.ajax({
            url: "<?php echo base_url();?>inventory/installed_filterby_site/"+site,
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
                $('#installed_items_table').DataTable();

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
  $('body').on('click','.clickmethen',function(){
    var qty = $('#cl_qty').val();
  // alert(qty);

  var url = "<?php echo base_url() ?>inventory/action_on_asset/clone/"+qty;
  var id ='clone_contents';
  // console.log(url);

    ajax_html_cust(url,id);

  });


  
  </script>
