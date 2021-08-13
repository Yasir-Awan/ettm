<?php echo form_open(base_url()."inventory/action_on_asset/component_replace_do/",array('id' => 'comp_replace'));?>
<?php

      if(!empty($comp_repair_warranty)){
         ?>
           <span required="" style="" class="form-control btn-warning mb-2"  >
           <?php         
            echo "component has repair warranty you should repair it"; exit;
           ?> 
           </span> 
           <?php              
          
       
        echo $comp_repair_warranty;
        echo $repair_compname;
        echo $warranty_ymd;
        echo $warranty_days;
        echo $working_ymd;
        echo $working_days;
      }

      if(!empty($equip_repair_warranty)){
        ?>
        <span required="" style="" class="form-control btn-warning mb-2"  >
        <?php         
         echo "Equipment has repair warranty you should repair it"; exit;
        ?> 
        </span> 
        <?php 
        echo $equip_repair_warranty;
        echo $repair_equipname;
        echo $warranty_ymd;
        echo $warranty_days;
        echo $working_ymd;
        echo $working_days;
      }
      if(!empty($equip_replace_warranty)){
        ?>
        <span required="" style="" class="form-control btn-warning mb-2"  >
        <?php         
        echo $equip_replace_warranty.",".$replace_equipname;
       
        echo $warranty_ymd.",".$warranty_days;
        
        echo $working_ymd.",".$working_days;
        ?> 
        </span> 
        
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Component Name</label>
             </div>
             <div class="col-md-8">
              <span required="" style="margin-left:-45px;" class="form-control" value="" 
               type="" name="component_id" id="component_id"><?php
                
             foreach($data as $row) 
             {  echo $row['name'].", "; } ?></span>
             </div>
          </div>

         <div class="form-group">
                <div class="row">
                <div class='col-md-1'>  
                  <label for="example-date-input" class="col-form-label">At</label>
                 
                </div>
                <div class='col-md-3'>
                <input type="hidden" class="form-control required" name="replace_type" id="replace_type" placeholder="Select Asset Name" value="1" >
                    <?php foreach($sites as $site) {?>
                      <input type="text" class="form-control required" name="site_name" id="site_name" placeholder="Select Asset Name" value="<?php echo $site['name'];?>" readonly >
                      <input type="hidden" class="form-control required" name="site" id="site" placeholder="Select Asset Name" value="<?php echo $site['id'];?>" >
                      <input type="hidden" class="form-control required" name="equip_warranty" id="equip_warranty"  value="1" >
                  
                    <?php } ?>
                </div>
                
                <div class='col-md-4' style="margin-left:-22px;">
                    <?php foreach($locations as $location) {?>
                      <input type="text" class="form-control required" name="location_name" id="location_name" placeholder="Select  Name" value="<?php echo $location['location'];?>" readonly >
                      <input type="hidden" class="form-control required" name="location" id="location"  value="<?php echo $location['id'];?>" >
                    <?php } ?>
                </div>

                <div class='col-md-4' style="margin-left:-22px;">
                    <!-- <?php foreach($data1 as $row) {?> -->
                      <input type="text" class="form-control required" name="comp_name" id="equip_name" placeholder="Select  Name" value="<?php echo 'inside '.$equipment_name;?>" readonly >
                      <input type="hidden" class="form-control required" name="comp_id" id="equip_id"  value="<?php echo $equipment_id;?>" >
                    <!-- <?php } ?> -->
                </div>
                </div>
              </div>

              <div class="form-group">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Serial No</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <input type="text" class="form-control required" name="serial_no" id="serial_no"  value=""  >
                </div>
              </div>
            </div> 

              <div class="form-group">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Model No</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <input type="text" class="form-control required" name="model_no" id="model_no"  value=""  >
                </div>
              </div>
            </div> 

            <div class="form-group">
                <div class="row">
                <div class='col-md-4'>  
                  <label for="example-date-input" class="col-form-label">Manufacturer</label>
                  <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7'>
                <input type="text" class="form-control required" id="mfg"
                 name="mfg" placeholder="Enter Manufacturer Name" value="<?php echo $equip_mfg_name; ?>">
                </div>
               
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                <div class='col-md-4'>  
                  <label for="example-date-input" class="col-form-label">Supplier</label>
                  <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7'>
                <input type="text" class="form-control required" id="supplier"
                 name="supplier" placeholder="Enter Supplier Name" value="<?php echo $equip_supplier_name; ?>" >
                </div>
                </div>
              </div>   

        <?php
      }
      if(!empty($comp_replace_warranty)){
        echo $comp_replace_warranty;
        echo $replace_compname;
        echo $warranty_ymd;
        echo $warranty_days;
        echo $working_ymd;
        echo $working_days;
        ?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Component Name</label>
             </div>
             <div class="col-md-8">
              <span required="" style="margin-left:-45px;" class="form-control" value="" 
               type="" name="component_id" id="component_id"><?php
                
             foreach($data as $row) 
             {  echo $row['name'].", "; } ?></span>
             </div>
          </div>

         <div class="form-group">
                <div class="row">
                <div class='col-md-1'>  
                  <label for="example-date-input" class="col-form-label">At</label>
                 
                </div>
                <div class='col-md-3'>
                <input type="hidden" class="form-control required" name="replace_type" id="replace_type" placeholder="Select Asset Name" value="1" >
                    <?php foreach($sites as $site) {?>
                      <input type="text" class="form-control required" name="site_name" id="site_name" placeholder="Select Asset Name" value="<?php echo $site['name'];?>" readonly >
                      <input type="hidden" class="form-control required" name="site" id="site" placeholder="Select Asset Name" value="<?php echo $site['id'];?>" >
                      <input type="hidden" class="form-control required" name="comp_warranty" id="comp_warranty"  value="1" >
                    <?php } ?>
              
                </div>
                
                <div class='col-md-4' style="margin-left:-22px;">
                    <?php foreach($locations as $location) {?>
                      <input type="text" class="form-control required" name="location_name" id="location_name" placeholder="Select  Name" value="<?php echo $location['location'];?>" readonly >
                      <input type="hidden" class="form-control required" name="location" id="location"  value="<?php echo $location['id'];?>" >
                    <?php } ?>
                </div>

                <div class='col-md-4' style="margin-left:-22px;">
                    <!-- <?php foreach($data1 as $row) {?> -->
                      <input type="text" class="form-control required" name="comp_name" id="equip_name" placeholder="Select  Name" value="<?php echo 'inside '.$equipment_name;?>" readonly >
                      <input type="hidden" class="form-control required" name="comp_id" id="equip_id"  value="<?php echo $equipment_id;?>" >
                    <!-- <?php } ?> -->
                </div>
                </div>
              </div>

              <div class="form-group">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Serial No</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <input type="text" class="form-control required" name="serial_no" id="serial_no"  value=""  >
                </div>
              </div>
            </div> 

              <div class="form-group">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Model No</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <input type="text" class="form-control required" name="model_no" id="model_no"  value=""  >
                </div>
              </div>
            </div> 

            <div class="form-group">
                <div class="row">
                <div class='col-md-4'>  
                  <label for="example-date-input" class="col-form-label">Manufacturer</label>
                  <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7'>
                <input type="text" class="form-control required" id="mfg"
                 name="mfg" placeholder="Enter Manufacturer Name" value="<?php echo $comp_mfg; ?>">
                </div>
               
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                <div class='col-md-4'>  
                  <label for="example-date-input" class="col-form-label">Supplier</label>
                  <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7'>
                <input type="text" class="form-control required" id="supplier"
                 name="supplier" placeholder="Enter Supplier Name" value="<?php echo $comp_supplier; ?>" >
                </div>
                </div>
              </div>   

        <?php
      }
      if(!empty($noWarranty)||!empty($repair_warranty_finished)||!empty($replace_warranty_finished)){
        // echo $noWarranty;
        ?>
        <!-- <div class="form-group">
        <div class='row'>
           <div class='col-md-4'>
           <label for="example-text-input" class="col-form-label" data-original-title="" title="">Replace Type</label>
           <span class="asterisk" data-original-title="" title="">*</span>
           </div>
           <div class='col-md-7' >
           <select class="form-control required" name="repair_type" id="repair_type" placeholder="Select Asset Name" >
               <option value=""><?php echo "Select Option";?></option>
               <option value="1"><?php echo "Standard";?></option>
               <option value="2"><?php echo "Warranty";?></option>
           </select>
           </div>
         </div>
       </div> -->

       <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Component Name</label>
             </div>
             <div class="col-md-8">
              <span required="" style="margin-left:-45px;" class="form-control" value="" 
               type="" name="component_id" id="component_id"><?php
                
             foreach($data as $row) 
             {  echo $row['name'].", "; } ?></span>
             </div>
          </div>

         <div class="form-group">
                <div class="row">
                <div class='col-md-1'>  
                  <label for="example-date-input" class="col-form-label">At</label>
                 
                </div>
                <div class='col-md-3'>
                <input type="hidden" class="form-control required" name="replace_type" id="replace_type" placeholder="Select Asset Name" value="1" >
                    <?php foreach($sites as $site) {?>
                      <input type="text" class="form-control required" name="site_name" id="site_name" placeholder="Select Asset Name" value="<?php echo $site['name'];?>" readonly >
                      <input type="hidden" class="form-control required" name="site" id="site" placeholder="Select Asset Name" value="<?php echo $site['id'];?>" >
                  
                    <?php } ?>
              
                </div>
                
                <div class='col-md-4' style="margin-left:-22px;">
                    <?php foreach($locations as $location) {?>
                      <input type="text" class="form-control required" name="location_name" id="location_name" placeholder="Select  Name" value="<?php echo $location['location'];?>" readonly >
                      <input type="hidden" class="form-control required" name="location" id="location"  value="<?php echo $location['id'];?>" >
                    <?php } ?>
                </div>

                <div class='col-md-4' style="margin-left:-22px;">
                    <!-- <?php foreach($data1 as $row) {?> -->
                      <input type="text" class="form-control required" name="comp_name" id="equip_name" placeholder="Select  Name" value="<?php echo 'inside '.$equipment_name;?>" readonly >
                      <input type="hidden" class="form-control required" name="comp_id" id="equip_id"  value="<?php echo $equipment_id;?>" >
                    <!-- <?php } ?> -->
                </div>
                </div>
              </div>

              <div class="form-group">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Serial No</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <input type="text" class="form-control required" name="serial_no" id="serial_no"  value=""  >
                </div>
              </div>
            </div> 

              <div class="form-group">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Model No</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <input type="text" class="form-control required" name="model_no" id="model_no"  value=""  >
                </div>
              </div>
            </div> 

            <div class="form-group">
                <div class="row">
                <div class='col-md-4'>  
                  <label for="example-date-input" class="col-form-label">Manufacturer</label>
                  <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7'>
                <input type="text" class="form-control required" id="mfg"
                 name="mfg" placeholder="Enter Manufacturer Name">
                </div>
               
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                <div class='col-md-4'>  
                  <label for="example-date-input" class="col-form-label">Supplier</label>
                  <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7'>
                <input type="text" class="form-control required" id="supplier"
                 name="supplier" placeholder="Enter Supplier Name">
                </div>
                </div>
              </div>   

              <div class="form-group">
                  <div class='row'>
                    <div class='col-md-4'>
                    <label for="fixed_asset_price" data-original-title="" title="">Replace Cost</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-7'>
                    <input value="0.00"  class="custom-select form-control " maxlength="13" step="0.01" min="0" size="13" type="text" name="replace_cost" id="replace_cost">
                    </div>
                  </div>
                </div>  

                <div class="form-group">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Warranty Type</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
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
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Warranty Duration</label>
                </div>
                <div class='col-md-7' >
                <select class="form-control" name="warranty_duration" id="warranty_duration" placeholder="Select the option" >
                <option value="">Select Warranty Duration</option>
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

            <div class="form-group repair_cmpny" style="">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Replacing Company</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <select class="form-control " name="replacing_company" id="replacing_company" placeholder="" >
                  <option value="">Select Replacing Company</option>
                  <option value="1" >TSP</option>
                  <option value="2" >Outsider/Other</option>
                </select>
                </div>
              </div>
            </div>   
     <?php } ?>
        
   
            <div class="form-group repairing_tsp" style='display:none;'>
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Replacing TSP</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <select class="form-control " name="replacing_tsp" id="replacing_tsp" placeholder="Select Asset Name" >
                        <option value=""><?php echo "Select Option";?></option>
                <?php foreach($tsps as $tsp){?>
                    <option value="<?php echo $tsp['id'] ?>"><?php echo $tsp['name'];?></option>
                    <?php } ?> 
                </select>
                </div>
              </div>
            </div>

            <div class="form-group person_type" style='display:none;'>
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Person Type</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <select class="form-control " name="tsp_person_type" id="tsp_person_type" placeholder="Select Asset Name" >
                        <option value=""><?php echo "Select Option";?></option>
                    <option value="1"><?php echo "Admin";?></option>
                    <option value="2"><?php echo "Member";?></option>
                    <option value="3"><?php echo "Tollplaza Supervisor";?></option>
                </select>
                </div>
              </div>
            </div>


              <div class="form-group tsp_person" style="display:none;">
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Person</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-7' >
                    <select class="form-control " name="tsp_person" id="tsp_person" placeholder="Select Asset Name" >
                        
                    </select>
                    
                    </div>
                   </div>
              </div>

              <div class="form-group tsp_person_contact" style="display:none;">
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Person Contact</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-7' >
                    <?php //$current_asset = $this->db->get_where('items',array('id' => $asset[0]['name']))->result_array(); ?>
                    
                    <input type="text"  class="form-control" style="" name="tsp_person_contact" id="tsp_person_contact">
                    <!-- <option value="<?php// echo $current_asset[0]['id'];?>"><?php// echo $current_asset[0]['name'];?></option>
                    <?php// foreach($items as $item){?>
                    <option value="<?php // echo $item['id'] ?>"><?php// echo $item['name'];?></option>
                    <?php //} ?> -->
                    </select>
                    </div>
                   </div>
              </div>


              <div class="form-group tsp_address" style="display:none;">
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Address</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-7' >
                    <?php //$current_asset = $this->db->get_where('items',array('id' => $asset[0]['name']))->result_array(); ?>
                    
                    <textarea rows="5"  class="form-control" style="" name="tsp_address" id="tsp_address"></textarea>
                    <!-- <option value="<?php// echo $current_asset[0]['id'];?>"><?php// echo $current_asset[0]['name'];?></option>
                    <?php// foreach($items as $item){?>
                    <option value="<?php // echo $item['id'] ?>"><?php// echo $item['name'];?></option>
                    <?php //} ?> -->
                    </select>
                    </div>
                   </div>
              </div>



              <div class="form-group outer_company_name" style="display:none;">
          <div class='row'>
             <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Company Name</label>
                <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-7">
                <input class="form-control" type="text" name='outer_company_name' id='outer_company_name'>  
             </div>
          </div>
          </div>
           


         <div class="form-group outer_company_address" style="display:none;">
          <div class='row'>
             <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Company Address</label>
                <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-7">
                <textarea rows="5"  class="form-control" style="" name="outer_company_address" id="outer_company_name"></textarea>
             </div>
          </div>
          </div>


            <div class="form-group outsider_name" style="display:none;">
                      <div class="row">
                         <div class='col-md-4'>  
                            <label for="example-date-input" class="col-form-label">Person Name</label>
                            <span class="asterisk" data-original-title="" title="">*</span>
                         </div>
                         <div class='col-md-7'>
                            <input class="form-control " type="text" name='outsider_name'>  
                         </div>
                         <!-- <div class='col-md-3'>
                         <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                         </div> -->
                       </div>
              </div>


            <div class="form-group outsider_contact" style="display:none;">
                      <div class="row">
                         <div class='col-md-4'>  
                            <label for="example-date-input" class="col-form-label">Person Contact</label>
                            <span class="asterisk" data-original-title="" title="">*</span>
                         </div>
                         <div class='col-md-7'>
                            <input class="form-control" type="text" name='outsider_contact'>  
                         </div>
                         <!-- <div class='col-md-3'>
                         <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                         </div> -->
                       </div>
              </div>

 

          <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Reason</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-7">
             <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="replace_reason" id="replace_comments"></textarea>
             </div>
          </div> 
           

        <div class="form-group">
          <div class='row'>
            <input class="form-control" value="<?php echo implode(",",$repairs);?>" 
               type="hidden" name="asset_id" id="asset_id">
          </div>
       </div>
          
<span class="btn btn-primary pull-right" onclick="form_submit('comp_replace');">Replace</span>
          <?php echo form_close();?>
<script>
        $(document).ready(function(){
          var endYear = new Date(new Date().getFullYear(), 11, 31);
          $("#faulty_date").datepicker({
            format: "yyyy-mm-dd",
            startDate: "2010-01-01",
            autoclose: true,
            endDate: endYear            
          })
        });
</script>


<script>
$('body').on('change', "#repair_type", function (){
  let repair_type = this.value;
  if(repair_type == 2)
  {
    $('.repair_cmpny').hide('slow');
  }
  if(repair_type == 1)
  {
    $('.repair_cmpny').show('slow');
  }
});
$('body').on('change', "#replace_company", function (){
  let repair_type = this.value;
  if(repair_type == 2)
  {
    $('.repair_cmpny').hide('slow');
  }
  if(repair_type == 1)
  {
    $('.repairing_tsp').show('slow');
  }
});
</script>
<script>
      $('body').on('change', "#repairing_company", function (){    
        var repair_company = this.value;
        //  console.log(issuance_type);
        if( repair_company == 1)
        {
          $('.outsider_contact').hide('slow');
          $('.outsider_name').hide('slow');
          $('.outer_company_address').hide('slow');
          $('.outer_company_name').hide('slow');
          $('.repairing_tsp').show('slow');
        }
        else
        {
          $('.tsp_address').hide('slow');
          $('.tsp_person_contact').hide('slow');
          $('.tsp_person').hide('slow');
          $('.person_type').hide('slow');
          $('.repairing_tsp').hide('slow');
          $('.outer_company_name').show('slow');
          $('.outer_company_address').show('slow');
          $('.outsider_name').show('slow');
          $('.outsider_contact').show('slow');
        }     
      });
</script>


<script>
           $('body').on('change', "#repairing_tsp", function (){ 
            // var tsp = this.value;
            $('.person_type').show('slow');             
           });
        $('body').on('change', "#tsp_person_type", function (){ 
          var tsp = $('#repairing_tsp').val();
          
              var person_type = this.value;
             $.ajax({ 
              url: "<?php echo base_url() ?>inventory/action_on_asset/repairing_tsp/"+tsp+"/"+person_type,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                var top = '200';
               
              },
              success: function(data) {
                // alert(data);
                tsps = JSON.parse(data);
                console.log(tsps);
                  $('.tsp_address').show('slow');
                  $('#tsp_address').html(tsps.address);
                  $('.tsp_person').show('slow');
                  $('#tsp_person').empty().append('<option value="">Choose Option</option>');
                  tsps.person_names.forEach(user => {
                  $('#tsp_person').append('<option value="'+user.id+'">'+ user.fname + ' ' + user.lname +'</option>');
                  });  
                 
                 
                  // $('.tsp_person').show('slow');
                  // $('#tsp_person').val(tsps.person_name);
                  // $('.tsp_person_contact').show('slow');
                  // $('#tsp_person_contact').val(tsps.person_contact);
                              
                },
              error: function(e) {
              //  console.log(e)
              }
            });
          });
</script>

<script>
        $('body').on('change', "#tsp_person_type", function (){ 
               var tsp = this.value;
             // $('.person_type').show('slow');   
          });
        $('body').on('change', "#tsp_person", function (){ 
          var tsp_person = this.value;
          var tsp = $('#tsp_person_type').val();
          
            //var person_type = this.value;
             $.ajax({ 
              url: "<?php echo base_url() ?>inventory/action_on_asset/person_contact/"+tsp+"/"+tsp_person,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                var top = '200';
               
              },
              success: function(data) {
                // alert(data);
                person_contact = JSON.parse(data);
                console.log(person_contact);
                 
                  $('.tsp_person_contact').show('slow'); 
                  $('#tsp_person_contact').val(person_contact.contact);
                            
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