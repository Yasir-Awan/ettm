<?php echo form_open(base_url()."inventory/edit_asset_do/".$asset[0]['id'],array('id' => 'edit_asset'));?>
        
<!-- Form Textual inputs start -->
<div class="col-12 mt-0">
         <div class="card">
           <div class="card-body">
                <fieldset style="margin-top: -35px;">
               <legend>Core Information<hr></legend>                        
                
               <div class="form-group">
              <div class='row'>
                  <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Name</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                  </div>
                  <div class='col-md-8' >
                    <select class="form-control required" style="margin-left:-45px;" name="item_type" id="item_type_edit" placeholder="Select Asset Name">
                    <?php 
                     if( $asset[0]['item_type']==1)
                     { 
                         $item_type = "Electronic Equipment";
                         $value = $asset[0]['item_type'];
                     }
                     if( $asset[0]['item_type']==2)
                     { 
                         $item_type = "Heavy Equipment";
                         $value = $asset[0]['item_type'];
                     } 
                     if( $asset[0]['item_type']==3)
                     { 
                         $item_type = "Lab Equipment";
                         $value = $asset[0]['item_type'];
                     }
                     if( $asset[0]['item_type']==4)
                     { 
                         $item_type = "Event & Staging Equipment";
                         $value = $asset[0]['item_type'];
                     } 
                     if( $asset[0]['item_type']==5)
                     { 
                         $item_type = "Marketing & Promotional Material.";
                         $value = $asset[0]['item_type'];
                     } 
                     if( $asset[0]['item_type']==5)
                     { 
                         $item_type = "IT Assets";
                         $value = $asset[0]['item_type'];
                     } 
                     if( $asset[0]['item_type']==5)
                     { 
                         $item_type = "Consumables";
                         $value = $asset[0]['item_type'];
                     }
                     if( $asset[0]['item_type']==6)
                     { 
                         $item_type = "Tools";
                         $value = $asset[0]['item_type'];
                     } 
                     ?>
                     <option value="<?php echo $value ?>"><?php echo $item_type ?></option>
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
                
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Name</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4' >
                   <?php $current_asset = $this->db->get_where('items',array('id' => $asset[0]['name']))->result_array(); ?>
                    <select class="form-control required" name="asset_name" id="asset_name" placeholder="Select Asset Name">
                    <option value="<?php echo $current_asset[0]['id'];?>"><?php echo $current_asset[0]['name'];?></option>
                    <!-- <?php foreach($items as $item){?>
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
                    <input type="text" name="product_model_no" style="margin-left: -61px !important;" value='<?php echo $asset[0]['product_model_no']?>'
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
                    <?php $asset_manufacturer = $this->db->get_where('manufacturers',array('id' => $asset[0]['manufacturer']))->result_array(); ?>
                    <select class="form-control required" name="manufacturer_id" id="manufacturer_id">
                    <option value="<?php echo $asset_manufacturer[0]['id'];?>"><?php echo $asset_manufacturer[0]['name'];?></option>
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
                    <label for="fixed_asset_price" data-original-title="" title="">Cost Price</label>
                    </div>
                    <div class='col-md-4'>
                    <input value='<?php echo $asset[0]['cost_price']?>'  class="custom-select form-control " maxlength="13" step="0.01" min="0" size="13" type="number" name="asset_price" id="asset_price">
                    </div>
                  </div>
                </div>  

                  &nbsp
                  &nbsp
              <legend>Extended Information <hr></legend>                              
              <br>
              <div class="form-group">
                <input value='<?php echo $asset[0]['identification_no']?>' class="form-control" type="hidden" name="id_no" id="id_no">
              </div> 
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label  class="col-form-label" data-original-title="" title="">Supplier</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <?php $asset_supplier = $this->db->get_where('suppliers',array('id' => $asset[0]['supplier']))->result_array(); ?>
                    <select class="form-control required" name="supplier_id" id="supplier_id">
                    <option value="<?php echo $asset_supplier[0]['id'];?>"><?php echo $asset_supplier[0]['name'];?></option>
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
                       <?php $asset_site = $this->db->get_where('sites',array('id' => $asset[0]['site']))->result_array(); ?>
                       <select class="form-control required" name="site_id" id="site_id" placeholder="Select the Site " data-original-title="" title="" >
                       <option value="<?php echo $asset_site[0]['id'];?>"><?php echo $asset_site[0]['name'];?></option>
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
                         <input type="text" class="form-control required" id="purchase_on" name="purchase_on" placeholder="Choose Purchasing Date" value="<?php echo $asset[0]['purchased_on']; ?>">
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
                <?php if($asset[0]['warranty_type']==0){?>
                <option value="<?php echo $asset[0]['warranty_type'];?>"><?php echo "Have No Warranty";?></option>
                <?php } ?>
                <?php if($asset[0]['warranty_type']==1){?>
                <option value="<?php echo $asset[0]['warranty_type'];?>"><?php echo "Replacement Warranty";?></option>
                <?php } ?>
                <?php if($asset[0]['warranty_type']==2){?>
                <option value="<?php echo $asset[0]['warranty_type'];?>"><?php echo "Repairing Warranty";?></option>
                <?php } ?>
                <option value="0" >Have No Warranty</option>
                <option value="1" >Replacement Warranty</option>
                <option value="2" >Repairing Warranty</option>
                </select>
                </div>
              </div>
            </div>


            <div class="form-group warranty_duration" style="">
             <div class='row'>
                <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Warranty Duration</label>
                </div>
                <div class='col-md-4'>
                <select class="form-control" name="warranty_duration" id="warranty_duration" placeholder="Select the option" >
                <?php if($asset[0]['warranty_duration']=="3 Months"){?>
                <option value="<?php echo $asset[0]['warranty_duration'];?>"><?php echo "3 Months";?></option>
                <?php } ?>
                <?php if($asset[0]['warranty_duration']=="6 Months"){?>
                <option value="<?php echo $asset[0]['warranty_duration'];?>"><?php echo "6 Months";?></option>
                <?php } ?>
                <?php if($asset[0]['warranty_duration']=="9 Months"){?>
                <option value="<?php echo $asset[0]['warranty_duration'];?>"><?php echo "9 Months";?></option>
                <?php } ?>
                <?php if($asset[0]['warranty_duration']=="1 Year"){?>
                <option value="<?php echo $asset[0]['warranty_duration'];?>"><?php echo "1 Year";?></option>
                <?php } ?>
                <?php if($asset[0]['warranty_duration']=="2 Years"){?>
                <option value="<?php echo $asset[0]['warranty_duration'];?>"><?php echo "2 Years";?></option>
                <?php } ?>
                <?php if($asset[0]['warranty_duration']=="3 Years"){?>
                <option value="<?php echo $asset[0]['warranty_duration'];?>"><?php echo "3 Years";?></option>
                <?php } ?>
                <?php if($asset[0]['warranty_duration']=="4 Years"){?>
                <option value="<?php echo $asset[0]['warranty_duration'];?>"><?php echo "4 Years";?></option>
                <?php } ?>
                <?php if($asset[0]['warranty_duration']=="5 Years"){?>
                <option value="<?php echo $asset[0]['warranty_duration'];?>"><?php echo "5 Years";?></option>
                <?php } ?>
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
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('edit_asset');">Update Asset</button>
          <?php echo form_close();?>
          <script>
        $(document).ready(function(){
          var endYear = new Date(new Date().getFullYear(), 11, 31);
          $("#purchase_on").datepicker({
            format: "dd/mm/yyyy",
            startDate: "01/01/2010",
            autoclose: true,
            endDate: endYear
            
          })
        
        });
  </script>
          <script>
           $('#item_type_edit').change(function (){    
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