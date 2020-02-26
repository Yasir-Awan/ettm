<?php echo form_open(base_url()."inventory/add_location_do/",array('id' => 'add_locationsss'));?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">LOCATION NAME</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control required" placeholder="Enter location" 
               type="text" name="location_name" id="location_name">
             </div>
          </div>
          <br>
        
           <br>
        <span class="btn btn-primary pull-right" onclick="form_submit('add_locationsss');">Add Location</span>
          <?php echo form_close();?>