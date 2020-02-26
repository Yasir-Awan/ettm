<?php echo form_open(base_url()."supervisor_inventory/action_on_asset/faulty_do/",array('id' => 'faulty'));?>
         
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Asset Name</label>
             </div>
             <div class="col-md-8">
              <span required="" style="margin-left:-45px;" class="form-control" value="" 
               type="" name="asset_name" id="asset_name"><?php
                
             foreach($data as $row) 
             {  echo $row[0]['name'].", "; } ?></span>
             </div>
          </div>
         <br>
         <div class="form-group">
                <div class="row">
                <div class='col-md-3'>  
                  <label for="example-date-input" class="col-form-label">Item site</label>
                 
                </div>
                <div class='col-md-4'>

                    <?php foreach($sites as $site) {?>
                      <input type="text" class="form-control required" name="site_name" id="site_name" placeholder="Select Asset Name" value="<?php echo $site['name'];?>" readonly >
                      <input type="hidden" class="form-control required" name="item_site" id="item_site" placeholder="Select Asset Name" value="<?php echo $site['id'];?>" >
                  
                    <?php } ?>
              
                </div>
                
                <div class='col-md-4' style="margin-left:-8px;">
                    <?php foreach($locations as $location) {?>
                      <input type="text" class="form-control required" name="location_name" id="location_name" placeholder="Select  Name" value="<?php echo $location['location'];?>" readonly >
                      <input type="hidden" class="form-control required" name="item_location" id="item_location"  value="<?php echo $location['id'];?>" >
                    <?php } ?>
                </div>
                
                </div>
              </div>
              

         <div class="form-group">
             <div class='row'>
                <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">OMC Name</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-8' >
                <input type="text" class="form-control required" name="omc_name" id="omc_name"  value=""  >
                </div>
              </div>
            </div>        

          <div class="form-group">
                <div class="row">
                <div class='col-md-3'>  
                  <label for="example-date-input" class="col-form-label">Faulty Date</label>
                  <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-4'>
                <input type="text" class="form-control required" id="faulty_date"
                 name="faulty_date" placeholder="Enter Faulty Date">
                </div>
                <div class='col-md-3'>
                  <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                </div>
                </div>
              </div>

              <div class="form-group">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label for="fixed_asset_price" data-original-title="" title="">Estimate Cost</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <input value="0.00"  class="custom-select form-control " maxlength="13" step="0.01" min="0" size="13" type="text" name="estimated_cost" id="estimated_cost">
                    </div>
                  </div>
                </div>  


          <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Comments</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="faulty_reason" id="faulty_comments"></textarea>
             </div>
          </div> 
           

        <div class="form-group">
          <div class='row'>
            <input class="form-control" value="<?php echo implode(",",$repairs);?>" 
               type="hidden" name="asset_id" id="asset_id">
          </div>
       </div>
          
<span class="btn btn-primary pull-right" onclick="form_submit('faulty');">Faulty</span>
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
