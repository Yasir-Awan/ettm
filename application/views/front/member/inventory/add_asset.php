<?php echo form_open(base_url()."inventory/add_asset_do/",array('id' => 'add_assets'));?>
                   <!-- Form Textual inputs start -->
        <div class="col-12 mt-0">
         <div class="card">
           <div class="card-body">
                <fieldset style="margin-top: -35px;">
               <legend>Core Information<hr></legend>                        
               <div class="form-group">
              <div class='row'>
                  <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Type</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                  </div>
                  <div class='col-md-5' >
                    <select class="form-control required" style="margin-left:-45px;" name="item_type" id="itemtype" placeholder="Select Asset Name">
                   
                    <option value=1>Electronic Equipment</option>
                    <option value=2>Heavy Equipment</option>
                    <option value=3>Lab Equipment</option>
                    <option value=4>Event & Staging Equipment</option>
                    <option value=5>Marketing & Promotional Material</option>
                    <option value=6>IT Assets</option>
                    <option value=7>Consumables</option>
                    <option value=8>Tools</option>
                    
                    </select>
                  </div>
              </div>
        </div>

                <div class="form-group item_name" style="display:none;">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Name</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4' >
                    <select class="form-control required" name="asset_name" id="asset_name" placeholder="Select Asset Name">
                    <!-- <option value=""><?php echo "Select Asset Name";?></option>
                    <?php foreach($items as $item){?>
                    <option value="<?php echo $item['id'] ?>"><?php echo $item['name'];?></option>
                    <?php } ?> -->
                    </select>
                    </div>
                   </div>
                </div>
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-4'>
                    <label for="example-search-input"  class="col-form-label" data-original-title="" title="">Product model number</label>
                    </div>
                    <div class='col-md-4'>
                    <input type="text" name="product_model_no" style="margin-left: -61px !important;" 
                     placeholder="Product model No"  id="product_model_no" class="form-control required">
                    </div>
                  </div>
                </div>
                
               

                  <div class="form-group">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label  class="col-form-label" data-original-title="" title="">Manufacturer</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <select class="form-control required" name="manufacturer_id" id="manufacturer_id">
                    <?php foreach($manufacturers as $manufacturer){?>
                    <option value="<?php echo $manufacturer['id'] ?>"><?php echo $manufacturer['name'];?></option>
                    <?php } ?>
                    </select>
                    </div>
                    <div class='col-md-2 pull-left' style="">
                    <button type="button" style="background-color: transparent;margin-left: -20px; color: blue;border: none;" class="btn btn-primary" data-toggle="modal" data-target="#modal-b">Add</button>  
                    </div>
                  </div>
                </div>

                <div class="form-group">
                <div class='row'>
                 <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Quantity</label>
                </div>
                <div class="col-md-4">
               <input type="number" class="form-control required" id="quantity" name="quantity" placeholder="Enter Quantity" min="1"> 
               </div>
               </div>
                </div> 

                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label for="fixed_asset_price" data-original-title="" title="">Total Price</label>
                    </div>
                    <div class='col-md-4'>
                    <input value="0.00"  class="custom-select form-control " maxlength="13" step="0.01" min="0" size="13" type="number" name="asset_price" id="asset_price">
                    </div>
                  </div>
                </div>  

                

                
                  
                  &nbsp
                  &nbsp
              <legend>Extended Information <hr></legend>                              
              <br>


              <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                      <label for="example-url-input" class="col-form-label" data-original-title="" title="">Identification Number</label>
                      </div>
                      <div class="col-md-4">
                      <input type="text" class="form-control required" name="id_no" id="id_no" placeholder="Identification Number">
                      </div>
                      <div class="col-md-3">
                      <a style="line-height:45px;" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Use this field to record barcodes or enter your own serial numbers."><i class="barcode-icon fa fa-lg fa-barcode"></i></a>
                      &nbsp
                      <a style="line-height:45px;" target="_blank" href="" data-original-title="" title="">Learn More</a>
                      </div>
                    </div>
                  </div>

                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label  class="col-form-label" data-original-title="" title="">Supplier</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <select class="form-control required" name="supplier_id" id="supplier_id">
                    <?php foreach($suppliers as $supplier){?>
                    <option value="<?php echo $supplier['id'] ?>"><?php echo $supplier['name'];?></option>
                    <?php } ?>
                    </select>
                    </div>
                    <div class='col-md-2 pull-left' style="">
                    <button type="button" style="background-color: transparent;margin-left: -20px; color: blue;border: none;" class="btn btn-primary" data-toggle="modal" data-target="#modal-b">Add</button>  
                    </div>
                  </div>
                </div>   
  
                 <div class="form-group">
                    <div class="row">
                       <div class='col-md-3'>
                       <label for="location_id" class="col-form-label" data-original-title="" title="">Site</label>
                       </div>
                       <div class='col-md-4'>
                       <select class="form-control required" name="site_id" id="site_id" placeholder="Select the Site " data-original-title="" title="" >
                       <option value="">Please Select the Site</option>
                       <?php foreach($sites as $site){?>
                    <option value="<?php echo $site['id'] ?>"><?php echo $site['name'];?></option>
                    <?php } ?>
                       </select>
                       </div>
                       <div class='col-md-2'>
                       <button type="button" class="btn btn-primary" style="background-color: transparent;margin-left: -20px; color: blue;border: none;" data-toggle="modal" data-target="#modal-d">Add</button>
                       </div>
                     </div>
                   </div>                       
                
                  <div class="form-group">
                      <div class="row">
                         <div class='col-md-3'>  
                         <label for="example-date-input" class="col-form-label">Purchased on</label>
                         </div>
                         <div class='col-md-4'>
                         <input type="text" class="form-control required" id="purchase_date" name="purchase_date" placeholder="Choose Purchasing Date">
                         </div>
                         <div class='col-md-2'>
                         <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                         </div>
                       </div>
                     </div>

            <div class="form-group">
             <div class='row'>
                <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Warranty Type</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-4' >
                <select class="form-control required" name="warranty_type" id="warranty_type" placeholder="Select the option" >
                <option value="">Select Warranty type</option>
                <option value="0" >Have No Warranty</option>
                <option value="1" >Replacement Warranty</option>
                <option value="2" >Repairing Warranty</option>
                </select>
                </div>
              </div>
            </div>


            <div class="form-group warranty_duration" style="display:none;">
             <div class='row'>
                <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Warranty Duration</label>
                </div>
                <div class='col-md-4' >
                <select class="form-control" name="warranty_duration" id="warranty_duration" placeholder="Select the option" >
                <option value="">Select Warranty Duration</option>
                <option value="3 Months" >3 Months</option>
                <option value="6 Months" >6 Months</option>
                <option value="9 Months" >9 Months</option>
                <option value="1 Year" >1 Year</option>
                <option value="2 Years" >2 Years</option>
                <option value="3 Years" >3 Years</option>
                <option value="4 Years" >4 Years</option>
                <option value="5 Years" >5 Years</option>
                </select>
                </div>
              </div>
            </div>
                                       
              <legend>Custom Fields <hr></legend> 
                <div class="form-group has-primary">
                  <div> No custom fields exist for this group. <a data-remote="true" 
                    href=""
                    data-original-title="" title="">Click here</a> to add custom fields. </div>
                  </div>
                 </div>
               </div>
               </div>
             </fieldset> <!--Form Textual inputs END -->
           <br>
        <button type="button" class="btn btn-primary pull-right  mb-3" onclick="form_submit('add_assets');">Create Asset</button>
          <?php echo form_close();?>
<script>
$('body').on('change','#site_id',function(){
  var id = this.value;
  $.ajax({ 
            url: "<?php echo base_url();?>inventory/site_related_locations/"+id,
            cache       : false,
            contentType : false,
            processData : false,
            success: function(data) {
                
                $('#location_id').html(data);
                              
            },
            error: function(e) {
                console.log(e)
            }
            });
});
</script>
          
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
                var top = '200';
                $('#asset_name').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
              },
              success: function(data) {
                // alert(data);
                  items = JSON.parse(data);
                  console.log(items);
                  $('.item_name').show('slow');
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