<div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
               <!--  <h4 class="card-title"> Monthly Traffic Report</h4> -->
                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="card-title">Inventory Management System</h4>
                                    </div>
                                    <div class="col-md-4">
                                        
                                    </div>
                                </div>
              </div>
              <div class="card-body" style="padding:unset;">
                                <!-- Firts Page Start -->
<div class="container-fluid" style="padding:unset;">          
  <!-- CARD for DataTales START -->

       <div class="col-lg-12 shadow mb-1 mt-3 d-none d-lg-block">
                        <div class="horizontal-menu py-2 ">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    
                                    <li class="nav-item">
                                        <a class="tab  nav-link " id="asset" data-toggle="tab" href="#assets" role="tab" aria-controls="assets" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>supervisor_inventory/tabs/assets/','displaying_assets');">Assets</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tab  nav-link " id="asset" data-toggle="tab" href="#installed" role="tab" aria-controls="installs" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>supervisor_inventory/tabs/installed/','displaying_installed');">Installed</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tab nav-link " id="item-tab" data-toggle="tab" data-target="#item" href="#" role="tab" aria-controls="home" aria-selected="true" onclick="ajax_html('<?php echo base_url()?>supervisor_inventory/tabs/items/','displaying_items');">ITEMS</a>
                                    </li>
                                    
                                    <!-- <li class="nav-item">
                                        <a class="tab  nav-link" id="site" data-toggle="tab" href="#sites" role="tab" aria-controls="sites" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>supervisor_inventory/tabs/sites/','displaying_sites');">Sites</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tab nav-link" id="location" data-toggle="tab" href="#locations" role="tab" aria-controls="locations" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>supervisor_inventory/tabs/locations/','displaying_locations');">Locations</a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a class="tab nav-link" id="supplier" data-toggle="tab" href="#suppliers" role="tab" aria-controls="suppliers" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>supervisor_inventory/tabs/suppliers/','displaying_suppliers');">Suppliers</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tab nav-link" id="support_provider" data-toggle="tab" href="#support_providers" role="tab" aria-controls="support_providers" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>supervisor_inventory/tabs/support_providers/','displaying_support_providers');">T.S.P</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tab nav-link" id="manufacturer" data-toggle="tab" href="#manufacturers" role="tab" aria-controls="manufacturers" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>supervisor_inventory/tabs/manufacturers/','displaying_manufacturer');">Manufacturers</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="myTabContent" style="padding:unset;">
                                    <div class="tab-pane fade show active" id="assets" role="tabpanel" aria-labelledby="asset-tab">
                                    <div id='displaying_assets' class ="displaying_assets"></div>
                                    </div>

                                    <div class="tab-pane fade show active" id="installed" role="tabpanel" aria-labelledby="installed-tab">
                                    <div id='displaying_installed' class ="displaying_installed"></div>
                                    </div>
                                    
                                    <div class="tab-pane fade " id="item" role="tabpanel" aria-labelledby="item-tab">
                                    <div class='list' id='list'></div>
                                    </div>
                                    
                                    <!-- <div class="tab-pane fade " id="sites" role="tabpanel" aria-labelledby="site-tab">
                                    <div id='displaying_site'></div>
                                    </div>
                                    <div class="tab-pane fade" id="locations" role="tabpanel" aria-labelledby="location-tab">
                                    <div id='displaying_locations'></div>
                                    </div> -->
                                    <div class="tab-pane fade" id="suppliers" role="tabpanel" aria-labelledby="supplier-tab">
                                    <div id='displaying_suppliers'></div>
                                    </div>
                                    <div class="tab-pane fade" id="support_providers" role="tabpanel" aria-labelledby="support_provider-tab">
                                    <div id='displaying_support_providers'></div>
                                    </div>
                                    <div class="tab-pane fade" id="manufacturers" role="tabpanel" aria-labelledby="manufacturer-tab">
                                    <div id='displaying_manufacturer'></div>
                                    </div>
                                </div>
                            </div>
            </div> <!-- card End -->
          </div> <!-- col-md-12 End -->
        </div> <!-- row End -->
      </div> <!-- content
-->



       
<div class="modal fade" id="addassets">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New Asset</h3>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="padding:unset;">
              <div id="adding_assets">
              </div>  
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="assets_add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Assets</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="adding_assets"></div>
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
 
<!-- Firts Page End -->
             

<!-- Firts Page Js Start -->
    <script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'supervisor_inventory';
    var module = 'first_page';
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
     $('a.paginate_button').on('click',function(){
    //alert('here');
});
     $('body').on('change', 'input[name=toggle]', function (){
    
    var mode = $(this).prop('checked');
    var id=$( this ).val();
    $.ajax({
      type:'POST',
      url:'<?php echo base_url()?>supervisor_inventory/first_page/assets_publish_set/' + id + '/'+ mode,
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
  
  $('body').on('click', '#item-tab', function (event){
            $.ajax({ 
            url: "<?php echo base_url();?>supervisor_inventory/items/list",
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
                 $('#dataTabl').DataTable();
                  $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();
                                
            },
            error: function(e) {
                console.log(e)
            }
            });
        }); 



        $(document).ready(function(){
            $('#asset').click();
        }); 
</script>

<!-- js for assets START -->
<script>
$('body').on('click', '#asset', function (event){
    // alert(); 
   var list = event.target.id;
    var mode = $(this).prop('checked');
    var id=$( this ).val();
 
            $.ajax({ 
            url: "<?php echo base_url();?>supervisor_inventory/assets/list",
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('#displaying_assets').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('#displaying_assets').html(data);
                 $('#dataTable_7').DataTable();
                  $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();
                                
            },
            error: function(e) {
                console.log(e)
            }
            });
        });
</script>
<!-- js for assets  END -->
<!-- js for sites START -->
<script>
$('body').on('click', '#site', function (event){
   var list = event.target.id;
    var mode = $(this).prop('checked');
    var id=$( this ).val();
 
            $.ajax({ 
            url: "<?php echo base_url();?>supervisor_inventory/sites/list",
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('#displaying_site').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('#displaying_site').html(data);
                 $('#dataTable3').DataTable();
                  $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();
                                
            },
            error: function(e) {
                console.log(e)
            }
            });
        });
</script>
<!-- js for sites  END -->
<!-- js for locations START -->
<script>
$('body').on('click', '#location', function (event){
   var list = event.target.id;
    var mode = $(this).prop('checked');
    var id=$( this ).val();
 
            $.ajax({ 
            url: "<?php echo base_url();?>supervisor_inventory/locations/list",
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('#displaying_locations').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('#displaying_locations').html(data);
                //  $('#dataTable4').DataTable();
                  $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();                               
            },
            error: function(e) {
                console.log(e)
            }
            });
        });
</script>
<!-- js for locations END -->

<!-- js for suppliers START -->
<script>
$('body').on('click', '#supplier', function (event){
   var list = event.target.id;
    var mode = $(this).prop('checked');
    var id=$( this ).val();
 
            $.ajax({ 
            url: "<?php echo base_url();?>supervisor_inventory/suppliers/list",
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('#displaying_suppliers').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('#displaying_suppliers').html(data);
                 $('#dataTable_4').DataTable();
                  $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();                               
            },
            error: function(e) {
                console.log(e)
            }
            });
        });
</script>
<!-- js for suppliers END -->

<!-- js for T.S.Ps START -->
<script>
$('body').on('click', '#support_provider', function (event){
   var list = event.target.id;
    var mode = $(this).prop('checked');
    var id=$( this ).val();
 
            $.ajax({ 
            url: "<?php echo base_url();?>supervisor_inventory/tsp/list",
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('#displaying_support_providers').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('#displaying_support_providers').html(data);
                 $('#dataTable_5').DataTable();
                  $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();                               
            },
            error: function(e) {
                console.log(e)
            }
            });
        });
</script>
<!-- js for T.S.Ps END -->

<!-- js for Manufacturers START -->
<script>
$('body').on('click', '#manufacturer', function (event){
   var list = event.target.id;
    var mode = $(this).prop('checked');
    var id=$( this ).val();
 
            $.ajax({ 
            url: "<?php echo base_url();?>supervisor_inventory/manufacturers/list",
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('#displaying_manufacturer').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('#displaying_manufacturer').html(data);
                 
                  $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();                               
            },
            error: function(e) {
                console.log(e)
            }
            });
        });
</script>
<!-- Firts Page Js End -->

<!-- Js for member side Fisrt Page Start -->


<!-- Js for member side Fisrt Page End -->