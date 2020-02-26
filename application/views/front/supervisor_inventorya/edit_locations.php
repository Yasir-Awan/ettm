<!-- <?php echo form_open(base_url()."supervisor_inventory/edit_location_do/".$location[0]['id'],array('id' => 'edit_locations'));?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Location Name</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control required" placeholder="Enter location"  
               type="text" name="location-name" id="location-name" value='<?php echo $location[0]['name']?>'>
             </div>
          </div>
          <br>
        
        </div>
           <br>
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('edit_locations');">Update Location</button>
          <?php echo form_close();?> -->