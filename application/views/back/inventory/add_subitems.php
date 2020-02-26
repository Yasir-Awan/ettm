<?php echo form_open(base_url()."inventory/add_subitem_do/",array('id' => 'add_subitems_components'));?>
        <div class="form-group">
              <div class='row'>
                  <div class='col-md-4'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Category</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                  </div>
                  <div class='col-md-7' >
                    <select class="form-control required" style="margin-left:-45px;" name="item_category" id="item_category" placeholder="Select Asset Name">
                    <option value="">Select Option</option>
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
        </div>
        <div class="form-group mainitem_name" style="display:none;">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Name</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-7' >
                    <select class="form-control required" name="item_name" id="item_name" placeholder="Select Asset Name">
                    <option value=""><?php echo "Select Asset Name";?></option>
                
                    </select>
                    </div>
                   </div>
                </div>
                            
        
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Subitem Name</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-7">
              <input required="required" style="margin-left:-45px;" class="form-control" value="LCD" 
               type="text" name="subitem_name" id="subitem_name">
             </div>
          </div>
          <br>
          
          <!-- border Start div for the border -->
          <!-- <div style="border-style:solid; display:none;" class="additional-info mb-3"> -->
          <!-- border Start div for the border -->
          <!-- <span required="" style="" class="form-control btn-success mb-2 heading"  >
                   This Componet's Main Equipment is already being used, So you have to enter the following information, with this component!
                   </span>  -->
        
                <!-- <div class="form-group serialmodel_no" style="">
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Serial & Model No</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4' >
                    <input class="form-control required" type="text" name='comp_serial' placeholder="Enter Serial No" value="">
                    </div>
                    <div class='col-md-4' >
                    <input class="form-control required" type="text" name='comp_model' placeholder="Enter Model No" value="" >
                    </div>
                   </div>
              </div> -->

              <!-- <div class="form-group suppliermfg " style="">
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Mfg & Supplier</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4' >
                    <input class="form-control required" type="text" name='manufacturer' placeholder="Enter Mfg Name" value="" >
                    </div>
                    <div class='col-md-4' >
                    <input class="form-control required" type="text" name='supplier' placeholder="Supplier Name" value="">
                    </div>
                   </div>
              </div> -->

              <!-- <div class="form-group">
                  <div class='row'>
                    <div class='col-md-4'>
                    <label for="fixed_asset_price" data-original-title="" title="">Purchase Price</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <input value="0.00"  class="custom-select form-control required" maxlength="13" step="0.01" min="0" size="13" type="text" name="subasset_price" id="subasset_price">
                    </div>
                  </div>
                </div>   -->

              <!-- <div class="form-group purchasedate" style="">
                      <div class="row">
                         <div class='col-md-4'>  
                         <label for="example-date-input" class="col-form-label">Purchased on</label>
                         <span class="asterisk" data-original-title="" title="">*</span>
                         </div>
                         <div class='col-md-4'>
                         <input type="text" class="form-control required" id="cmp_purchase_date" name="cmp_purchase_date" placeholder="Select Date">
                         </div>
                         <div class='col-md-2'> -->
                         <!-- <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a> -->
                         <!-- </div>
                       </div>
                     </div> -->

            <!-- <div class="form-group wrnty_type" style="">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Warranty Type</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-4' >
                <select class="form-control required" name="warranty_type" style="width:max-content;" id="warranty_type" placeholder="Select the option" >
                <option value="">Choose Option</option>
                <option value="0" >Have No Warranty</option>
                <option value="1" >Replacement Warranty</option>
                <option value="2" >Repairing Warranty</option>
                </select>
                </div>
              </div>
            </div> -->

            <!-- <div class="form-group warranty_duration" style="display:none;">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Warranty Duration</label>
                </div>
                <div class='col-md-4' >
                <select class="form-control " name="warranty_duration" style="width:max-content;" id="warranty_duration" placeholder="Select the option" >
                <option value="">Select Duration</option>
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
            </div> -->
           <!-- border End div for Border --> 
           <!-- </div> -->
            <!-- border End div for Border -->

            <!-- <div class="form-group">
                <div class='row'>
                 <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Quantity</label>
                </div>
                <div class="col-md-7">
               <input type="number" class="form-control required" id="quantity" name="quantity" value="" placeholder="Enter Quantity" min="1"> 
               </div>
               </div>
                </div>  -->

        <div class="form-group">
            <div class="row">
              <div class='col-md-4'>
              <label for="fixed_asset_description" class="col-form-label" data-original-title="" title="">Description</label>
              <span class="asterisk" data-original-title="" title="">*</span>
              </div>
              <div class="col-md-7">
              <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="item_[description]" id="item_description"></textarea>
              </div>     
            </div>
          </div>
        </div>
           <br>
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('add_subitems_components');">Add Sub Item</button>
          <?php echo form_close();?>


          <script>
        $(document).ready(function(){
          var endYear = new Date(new Date().getFullYear(), 11, 31);
          $("#cmp_purchase_date").datepicker({
            format: "yyyy-mm-dd",
            startDate: "2010-01-01",
            autoclose: true,
            endDate: endYear
            
          })
        
        });
  </script>
          <script>
           $('#item_category').change(function (){    
            var itemType = this.value;
             $.ajax({ 
              url: "<?php echo base_url() ?>inventory/items_have_subitems/"+itemType,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                var top = '200';
                $('#item_name').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
              },
              success: function(data) {
                  // alert(data);
                  items = JSON.parse(data);
                  // console.log(items);
                  $('.mainitem_name').show('slow');
                  $('#item_name').empty().append('<option value="">Choose Option</option>');
                  items.items.forEach(item => {
                  $('#item_name').append('<option value="'+item.id+'">'+ item.name  +'</option>');
                  });                
                },
              error: function(e) {
              //  console.log(e)
              }
          });
        });
        </script>

<script>
           $('#item_name').change(function (){ 
                
            var itemId = this.value;
             $.ajax({ 
              url: "<?php echo base_url() ?>inventory/item_installed_or_not/"+itemId,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                var top = '200';
                // $('#item_name').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
              },
              success: function(data) {
                //  alert(data);
                 if(data==1){
                  $('.additional-info').show('slow');
                  // $('.heading').show('slow');
                  // $('.serialmodel_no').show('slow');
                  // $('.suppliermfg').show('slow');
                  // $('.purchasedate').show('slow');
                  // $('.wrnty_type').show('slow');
              } 
              if(data==0){
                // $('.wrnty_type').hide('slow');
                // $('.purchasedate').hide('slow');
                // $('.suppliermfg').hide('slow');
                // $('.serialmodel_no').hide('slow');
                //   $('.heading').hide('slow');
                  $('.additional-info').hide('slow');
              }             
                },
              error: function(e) {
              //  console.log(e)
              }
          });
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