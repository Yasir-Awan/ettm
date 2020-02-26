<?php echo form_open(base_url()."inventory/add_asset_do/",array('id' => 'create_assetsss'));?>
                   <!-- Form Textual inputs start -->
        <div class="col-12 mt-0">
         <div class="card">
           <div class="card-body">
                <fieldset style="margin-top: -55px;">
               <legend>Core Information<hr></legend>                        
               <div class="form-group">
              <div class='row'>
                  <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Type</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                  </div>
                  <div class='col-md-4' >
                    <select class="form-control required"  name="item_type" id="itemtype" placeholder="Select Asset Name">
                    <option value=>Choose Option</option>
                    <option value=1>Marketing/Promotional Material</option>
                    <option value=2>Event/Staging Equipment</option>
                    <option value=3>Electronic Equipment</option>
                    <option value=4>Support Room Equipment</option>
                    <option value=5>Cashup Room Equipmet</option>
                    <option value=6>Control Room Equipment</option>
                    <option value=7>Power Supply Equipment</option>
                    <option value=8>Lane Equipment</option>
                    <option value=9>Booth Equipment</option>
                    <option value=10>Consumeable Items</option>
                    <option value=11>Furniture</option>
                    <option value=12>IT Assets</option>
                    <option value=13>Tools</option> 
                    
                    </select>
                  </div>
              </div>
        
                <div class=" item_name" style="display:none;">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Name</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4' >
                    <select class="form-control required" name="asset_name" id="asset_name" placeholder="Select Asset Name">
                    <!-- <option value=""><?php echo "Select Asset Name";?></option> -->
                    </select>
                    <!-- <input type="hidden" class="form-control" name="quantity" id="quantity"  value="1" > -->
                    </div>
                   </div>
                </div>

                <div class='row'>
                 <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Quantity</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class="col-md-4">
               <input type="number" min="0" max="12" oninput="toggle_componets()" class="form-control required" id="quantity" name="quantity" placeholder="Enter Quantity" min="1"> 
               </div>
               <div class='col-md-3'>
               <span class="btn btn-primary btn-md childmodal" style="display:none;" data-toggle="modal" data-target="#margla">Have Components Click to add their Details</span>
                </div>
               </div> 
                <div class="item_serialNo" id="item_serialNo" style="display:none;">
                </div>

              <div class='row'>
                <div class='col-md-3'>
                <label class="col-form-label" data-original-title="" title="">Model Number</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-4'>
                <input type="text" name="product_model_no" style="" placeholder="Model No"  id="product_model_no" class="form-control required">
                </div>
              </div>

                  <div class='row'>
                    <div class='col-md-3'>
                    <label  class="col-form-label" data-original-title="" title="">Manufacturer</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <select class="form-control" name="equip_manufacturer" id="equip_manufacturer">
                    <option value="">Choose Option</option>
                    <?php foreach($manufacturers as $manufacturer){?>
                    <option value="<?php echo $manufacturer['id'] ?>"><?php echo $manufacturer['name'];?></option>
                    <?php } ?>
                    </select>
                    </div>
                    <div class='col-md-2 pull-left' style="">
                    <!-- <button type="button" style="background-color: transparent;margin-left: -20px; color: blue;border: none;" class="btn btn-primary" data-toggle="modal" data-target="#modal-b">Add</button>   -->
                    </div>
                  </div>

                  <div class='row'>
                    <div class='col-md-3'>
                    <label  class="col-form-label" data-original-title="" title="">Mfg Date</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <input type="text" class="form-control" id="mfg_date" name="mfg_date" placeholder="Choose Date">
                    </div>
                    <div class='col-md-2 pull-left' style="">
                    <!-- <button type="button" style="background-color: transparent;margin-left: -20px; color: blue;border: none;" class="btn btn-primary" data-toggle="modal" data-target="#modal-b">Add</button>   -->
                    </div>
                  </div>


                  <div class='row'>
                    <div class='col-md-3'>
                    <label data-original-title="" title="">Total Bill</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <input value="0.00" class="custom-select form-control required" placeholder="Purchasing Cost" maxlength="13" step="0.01" min="0" size="13" type="text" name="asset_price" id="asset_price">
                    </div>
                  </div>

        </div> <!-- form group END --> 
              
              <legend>Extended Information <hr></legend>                              
              <br>
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label  class="col-form-label" data-original-title="" title="">Supplier</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <select class="form-control required" name="supplier_id" id="supplier_id">
                    <option value="">Choose Option</option>
                    <?php foreach($suppliers as $supplier){?>
                    <option value="<?php echo $supplier['id'] ?>"><?php echo $supplier['name'];?></option>
                    <?php } ?>
                    </select>
                    </div>
                    <div class='col-md-2 pull-left' style="">
                    <!-- <button type="button" style="background-color: transparent;margin-left: -20px; color: blue;border: none;" class="btn btn-primary" data-toggle="modal" data-target="#modal-b">Add</button>   -->
                    </div>
                  </div>

  
                    <div class="row">
                       <div class='col-md-3'>
                       <label class="col-form-label" data-original-title="" title="">Site</label>
                       <span class="asterisk" data-original-title="" title="">*</span>
                       </div>
                       <div class='col-md-4'>
                       <select class="form-control required"  tabindex="-1"  name="site_id" id="site_id">
                          <option value="">Select Site</option>
                          <?php foreach($sites as $site){?>
                                    <option value="<?php echo $site['id'] ?>"><?php echo $site['name'];?></option>
                                    <?php } ?>
                      </select>
                       </div>
                       <div class='col-md-2'></div>
                     </div>
                
                      <div class="row">
                         <div class='col-md-3'>  
                         <label class="col-form-label">Purchase Date</label>
                         <span class="asterisk" data-original-title="" title="">*</span>
                         </div>
                         <div class='col-md-4'>
                         <input type="text" class="form-control required" id="purchase_date" name="purchase_date" placeholder="Choose Date">
                         </div>
                         <div class='col-md-2'>
                         <!-- <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a> -->
                         </div>
                       </div>
                     
                      <div class="row">
                         <div class='col-md-3'>  
                         <label class="col-form-label">Purchase Order No</label>
                         </div>
                         <div class='col-md-4'>
                         <input type="text" class="form-control" id="po_no" name="po_no" placeholder="Order Number">
                         </div>
                         <div class='col-md-2'>
                         <!-- <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a> -->
                         </div>
                       </div>
                     
             <div class='row'>
                <div class='col-md-3'>
                <label class="col-form-label" data-original-title="" title="">Warranty Type</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-4' >
                <select class="form-control required" name="warranty_type" id="warranty_type">
                <option value="">Choose Option</option>
                <option value="0" >Have No Warranty</option>
                <option value="1" >Replacement Warranty</option>
                <option value="2" >Repairing Warranty</option>
                </select>
                </div>
              </div>
      

            <div class="warranty_duration" style="display:none;">
             <div class='row'>
                <div class='col-md-3'>
                <label class="col-form-label">Duration</label>
                </div>
                <div class='col-md-4' >
                <select class="form-control required" name="warranty_duration" id="warranty_duration" placeholder="Select the option" >
                <option value="">Choose</option>
                <option value="3 month" >3 Months</option>
                <option value="6 month" >6 Months</option>
                <option value="9 month" >9 Months</option>
                <option value="12 month" >1 Year</option>
                <option value="24 month" >2 Years</option>
                <option value="36 month" >3 Years</option>
                <option value="48 month" >4 Years</option>
                <option value="60 month" >5 Years</option>
                </select>
                </div>
              </div>
            </div>
       </div><!-- form gorup END  -->
               </div>
               </div>
             </fieldset> <!--Form Textual inputs END -->
           <br>
           <input type="hidden" name="additional_data" id="additional_data" val=""/>
        <button type="button" class="btn btn-primary pull-left  mb-3" onclick="creatAssetform_submit('create_assetsss');">Create Asset</button>
          <?php echo form_close();?>
    <!-- Modal for Edit Asset START -->
    <div class="modal fade" id="margla" style="margin-left:2%;">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="">
            <div class="modal-header">
                <h5 class="modal-title">Components</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body" style="">
              <div id="multiple_components">
              </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Edit Asset END -->          
          <script>
          $(document).ready(function(){
          var endYear = new Date(new Date().getFullYear(), 11, 31);
          $("#purchase_date").datepicker({
            format: "yyyy-mm-dd",
            startDate: "2010-01-01",
            autoclose: true,
            endDate: endYear
           })
          });
          </script>

<script>
          $(document).ready(function(){
          var endYear = new Date(new Date().getFullYear(), 11, 31);
          $("#mfg_date").datepicker({
            format: "yyyy-mm-dd",
            startDate: "1990-01-01",
            autoclose: true,
            endDate: endYear
           })
          });
          </script>

       <script>
           $('body').on('change', "#warranty_type", function (){    
             var warranty_type = this.value;
            //  console.log(issuance_type);
            if( warranty_type == 1 || warranty_type == 2)
            {
              $('.warranty_duration').show('slow');
            }
            else
            {
               $('.warranty_duration').hide('slow');
            }     
          });
        </script>
        <script>
           $('#itemtype').change(function (){    
            var itemType = this.value;
             $.ajax({ 
              url: "<?php echo base_url() ?>inventory/asset_type/"+itemType,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                // var top = '200';
                // $('#asset_name').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
              },
              success: function(data) {
                  items = JSON.parse(data);
                  console.log(items);
                  $('.item_name').show('slow');
                  $('#asset_name').empty().append('<option value="">Choose Option</option>');
                  items.items.forEach(item => {
                  $('#asset_name').append('<option value="'+item.id+'">'+ item.name  +'</option>');
                  });                
                },
              error: function(e) {
              //  console.log(e)
              }
          });
        });
        </script>

<script>
function ajax_html_for_comp_assets(url,id){
  var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
  var list = $('#'+id);
  // alert('in function');
  $.ajax({
    url: url,
    // method:"post",
    // data:,
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
          var itemName;
          $('#asset_name').change(function (){    
             itemName = this.value;
          });
           function toggle_componets(){
            var x = document.getElementById("quantity").value;
            // alert(x);
            // alert(itemName);
             $.ajax({ 
              url: "<?php echo base_url() ?>inventory/equip_has_comp_or_not/"+itemName+"/"+x,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                // var top = '200';
                // $('#asset_name').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); 
              },
              success: function(data) {
                data = JSON.parse(data);
                // alert(data);
                if(data!=0){
                       $('.item_serialNo').hide('slow');
                       $('.childmodal').show('slow');
                  } 
              if(data == ''){
                  $('.childmodal').hide('slow');
                  $('.item_serialNo').show('slow');
                  // $('#asset_name').empty();
                  $('.item_serialNo').html('');
                  for(var i=0; i<x; i++) {
                    var div = '<div class="row"><div class="col-md-3"><label class="col-form-label" data-original-title="" title="">Equipment Serial No</label></div><div class="col-md-4"><input type="text" name="equip_serial_no[]" style="" placeholder="Serial No"  class="form-control required itemSerial"></div></div>';  
                  $('.item_serialNo').append(div);
            //       let divId = document.getElementById(Id);
            //  itemSerial = divId.getElementsByClassName("equipSerial");
            //  itemSerial = itemSerial[0].value;
                  };                
              }  
                  // console.log(items);
                  // $('.item_name').show('slow');
                  // $('#asset_name').empty();
                  // items.items.forEach(item => {
                  // $('#asset_name').append('<option value="'+item.id+'">'+ item.name  +'</option>');
                  // });                
                },
              error: function(e) {
              //  console.log(e)
              }
          });
        }

        $('body').on('click','.childmodal',function(){
          // alert('yasir');
          var qty = $('#quantity').val();
          var url = "<?php echo base_url() ?>inventory/add_asset_components/"+itemName+"/"+qty;
          var id = 'multiple_components';
            ajax_html_for_comp_assets(url,id);
        });
    </script>

<script>
     var sendToServer = [];
  function asset_component_form_submit()
  {
      var w = document.getElementsByClassName('single');
      var x = document.getElementsByClassName('first');
      var y = document.getElementsByClassName('middle');
      var z = document.getElementsByClassName('last');
      var tabsId = [];
      if(w.length>0){
        for (let i = 0; i < w.length; i++) {
          tabsId.push(w[i].id);
        }
      }
      if(x.length>0){
          for (let i = 0; i < x.length; i++) {
            tabsId.push(x[i].id);
          }
      }
      if(y.length){
          for (let i=0; i < y.length; i++) {
            tabsId.push(y[i].id);
            }
       }
      if(z.length){
          for (let i = 0; i < z.length; i++) {
            tabsId.push(z[i].id);
          }
      }
  var equipSerial;
  var Id=1;
  var selectedComps=[];
  var compVal=[];
  for(var navCounter = 0; navCounter < tabsId.length; navCounter++)
  {
          $('#'+Id+'_div').find('input[type="checkbox"]:checked').each(function(index){ 
              selectedComps.push($(this)[0].id);
             });
             let divId = document.getElementById(Id+"_div");
             itemSerial = divId.getElementsByClassName("equipSerial");
             eSerial = itemSerial[0].value;
             componentsId = divId.getElementsByClassName("componentId");
             compSerial = divId.getElementsByClassName("compSerial");
            //  console.log(compSerial);
             compModel = divId.getElementsByClassName("compModel");
             compManufacturer = divId.getElementsByClassName("compManufacturer");
             compMfg = divId.getElementsByClassName("compMfg");
             compWT = divId.getElementsByClassName("compWarrantyType");
             compWD = divId.getElementsByClassName("compWarrantyDuration");
             compCost = divId.getElementsByClassName("compCost");
             
             if(compSerial.length>0){

              for (var cmpSerialIndex = 0; cmpSerialIndex < compSerial.length; cmpSerialIndex++) {
                compId = $("#"+compSerial[cmpSerialIndex].id).data('compId');
                console.log($("#"+compSerial[cmpSerialIndex].id).val());
                if($.inArray(compId, selectedComps) !== -1){
                 cmpObj = { 
                          tabNumber: Id,
                        componentId: $("#"+componentsId[cmpSerialIndex].id).val() , 
                        equipmentSerial: eSerial,
                        componentSerial: $("#"+compSerial[cmpSerialIndex].id).val() ,
                        componentModel: $("#"+compModel[cmpSerialIndex].id).val() ,
                        componentManufacturer: $("#"+compManufacturer[cmpSerialIndex].id).val() ,
                        componentMfg: $("#"+compMfg[cmpSerialIndex].id).val() ,
                        componentWT: $("#"+compWT[cmpSerialIndex].id).val() ,
                        componentWD: $("#"+compWD[cmpSerialIndex].id).val() ,
                        componentCost: $("#"+compCost[cmpSerialIndex].id).val() ,
                          };
                 sendToServer.push(cmpObj);
                }
               }
              }
              console.log(Id++);
  }
  console.log('ready to send to server', sendToServer);
  $("#margla").modal("hide");
}

function creatAssetform_submit(form_id,noty,e){
var alerta = $('#form'); // alert div for show alert message
var form = $('#'+form_id);
var can = '';
if(!extra){
  var extra = '';
}
form.find('.summernotes').each(function() {
  var now = $(this);
  now.closest('div').find('.val').val(now.code());
});
$('#additional_data').val(JSON.stringify(sendToServer));
var formdata = false;
if (window.FormData){
  formdata = new FormData(form[0]);
}
// console.log(formdata);
var a = 0;
var req = 'This field required';
var take = '';
form.find(".required").each(function(){
  var txt = '*'+req;
  a++;
  if(a == 1){
    take = 'scroll';
  }
  var here = $(this);
  if(here.val() == ''){
    if(!here.is('select')){
      here.css({borderColor: 'red'});
      if(here.attr('type') == 'number'){
        txt = '*This field required';
      }     
      if(here.closest('div').find('.badge-danger').length){
      } 
      else 
      { 
        here.closest('div').append(''
          +'  <span id="'+take+'" class="badge badge-danger" >'
          +'      '+txt
          +'  </span>'
        );
      }
    } else if(here.is('select')){
      here.closest('div').find('.chosen-single').css({borderColor: 'red'});
      if(here.closest('div').find('.require_alert').length){
      } else {
        here.closest('div').append(''
          +'  <span id="'+take+'" class="badge badge-danger" >'
          +'      *Required'
          +'  </span>'
        );
      }
    }
    var topp = 100;
    if(form_id == 'product_add' || form_id == 'product_edit'){
    } else {
      $('html, body').animate({
      }, 500);
    }
    can = 'no';
  }
  if (here.attr('type') == 'email'){
    if(!isValidEmailAddress(here.val())){
      here.css({borderColor: 'red'});
      if(here.closest('div').find('.badge-valid').length){
      } else {
        here.closest('div').append(''
          +'  <span id="'+take+'" class="badge badge-danger badge-valid" >'
          +'      *Enter valid Email'
          +'  </span>'
        );
      }
      can = 'no';
    }
  }
  take = '';
});
if(can != 'no' || can =='no'){
  //console.log(formdata);   
//  alert( $('#additional_data').val());
  var test = JSON.stringify(sendToServer);
  //alert(test);
  $.ajax({
    url: form.attr('action'), // form action url
    type: 'POST', // form submit method get/post
    dataType: 'html', // request type html/json/xml
    data: formdata, // serialize form data 
    cache       : false,
    contentType : false,
    processData : false,
    async: true,  
      beforeSend: function() {
        var buttonp = $('.enterer');
        buttonp.removeClass('enabled');
        buttonp.addClass('disabled');
        buttonp.html('working');
      },
      success: function(data) {
      var obj = JSON.parse(data);
    if(!obj.response){
      var buttonp = $('.enterer');
      buttonp.removeClass('disabled');
      buttonp.addClass('enabled');
      buttonp.html('Search');
      notify(obj.message,'danger','top','right');
    }else{
      var buttonp = $('.enterer');
      buttonp.removeClass('disabled');
      buttonp.addClass('enabled');
      buttonp.html('Search');
      notify(obj.message,'success','top','right');
      if(obj.is_redirect){
        setTimeout(function () { top.location.href = obj.redirect_url; }, 800);
        return false;
      }
    }
      },
      error: function(e) {
        console.log(e)
      }
    });
} else {
  if(form_id == 'product_add' || form_id == 'product_edit'){
    var ih = $('.require_alert').last().closest('.tab-pane').attr('id');
    $("[href=#"+ih+"]").click();
  }
  return false;
}
}
    </script>