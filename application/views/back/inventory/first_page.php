<div class="container-fluid">          
  <!-- CARD for DataTales START -->
    <div class="card shadow mb-1 mt-3">
       <div class="card-header py-2 ">
       <div class="col-lg-12  d-lg-block">
                        <div class="horizontal-menu " style="line-height:2;">
                        <ul class="nav nav-tabs" id="myTab" role="tablist" >
                                    
                                    <li class="nav-item">
                                        <a class="tab  nav-link " id="asset" data-toggle="tab" href="#assets" role="tab" aria-controls="assets" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>inventory/tabs/assets/','displaying_assets');">Assets</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tab nav-link" id="installed_items" data-toggle="tab" href="#installed" role="tab" aria-controls="installs" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>inventory/tabs/installed/','displaying_installed');">Installed Equipment</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tab nav-link" id="installed_subitem" data-toggle="tab" href="#installed_subitems" role="tab" aria-controls="subitem_installs" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>inventory/tabs/installed_subitems/','displaying_installed_subitems');">Installed Component</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="tab nav-link " id="item-tab" data-toggle="tab" data-target="#item" href="#" role="tab" aria-controls="home" aria-selected="true" onclick="ajax_html('<?php echo base_url()?>inventory/tabs/items/','displaying_items');">Equipment</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="tab nav-link " id="subitem-tab" data-toggle="tab" data-target="#subitem" href="#" role="tab" aria-controls="subitems" aria-selected="true" onclick="ajax_html('<?php echo base_url()?>inventory/tabs/subitems/','displaying_subitems');">Component</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="tab  nav-link" id="site" data-toggle="tab" href="#sites" role="tab" aria-controls="sites" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>inventory/tabs/sites/','displaying_sites');">Sites</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tab nav-link" id="supplier" data-toggle="tab" href="#suppliers" role="tab" aria-controls="suppliers" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>inventory/tabs/suppliers/','displaying_suppliers');">Suppliers</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tab nav-link" id="support_provider" data-toggle="tab" href="#support_providers" role="tab" aria-controls="support_providers" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>inventory/tabs/support_providers/','displaying_support_providers');">T.S.P</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tab nav-link" id="manufacturer" data-toggle="tab" href="#manufacturers" role="tab" aria-controls="manufacturers" aria-selected="false" onclick="ajax_html('<?php echo base_url()?>inventory/tabs/manufacturers/','displaying_manufacturer');">Manufacturers</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="myTabContent" style="padding:unset;">
                                    <div class="tab-pane fade show " id="assets" role="tabpanel" aria-labelledby="asset-tab">
                                    <div id='displaying_assets' class ="displaying_assets"></div>
                                    </div>

                                    <div class="tab-pane fade" id="installed" role="tabpanel" aria-labelledby="installed-tab">
                                    <div id='displaying_installed'></div>
                                    </div>

                                    <div class="tab-pane fade" id="installed_subitems" role="tabpanel" aria-labelledby="installedsubitem-tab">
                                    <div id='displaying_installed_subitems'></div>
                                    </div>
                                
                                    <div class="tab-pane fade " id="item" role="tabpanel" aria-labelledby="item-tab">
                                    <div class='list' id='list'></div>
                                    </div>

                                    <div class="tab-pane fade" id="subitem" role="tabpanel" aria-labelledby="subitem-tab">
                                    <div id='displaying_subitems'></div>
                                    </div>
                                    
                                    <div class="tab-pane fade " id="sites" role="tabpanel" aria-labelledby="site-tab">
                                    <div id='displaying_site'></div>
                                    </div>
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
       </div><!-- CARD HEADER END -->
       
<div class="modal" id="addassets" style="overflow: auto !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Asset</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="padding:unset;">
              <div  id="adding_assets" style="width:auto;padding:unset;">
              </div>  
            </div>
            
        </div>
    </div>
</div>

    <script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'inventory';
    var module = 'assets';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    $(document).ready(function(){
        $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        $("[data-toggle='toggle']").bootstrapToggle();
    });
    $('body').on('click','a.paginate_button',function(){
       $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        $("[data-toggle='toggle']").bootstrapToggle();
    });
     $('a.paginate_bustton').on('click',function(){
});
     $('body').on('change', 'input[name=toggle]', function (){
    var mode = $(this).prop('checked');
    var id=$( this ).val();
    $.ajax({
      type:'POST',
      url:'<?php echo base_url()?>inventory/assets/assets_publish_set/' + id + '/'+ mode,
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
      }
    });
  });
  $('body').on('click', '#item-tab', function (event){
            $.ajax({ 
            url: "<?php echo base_url();?>inventory/items/list",
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

<!-- js for sites START -->
<script>
$('body').on('click', '#site', function (event){
   var list = event.target.id;
    var mode = $(this).prop('checked');
    var id=$( this ).val();
            $.ajax({ 
            url: "<?php echo base_url();?>inventory/sites/list",
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('#displaying_site').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
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
