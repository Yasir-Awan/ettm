<?php echo form_open(base_url()."inventory/add_manufacturer_do/",array('id' => 'add_manufacturers'));?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Name</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control required" placeholder="Manufacturer" 
               type="text" name="manufacturer_name" id="manufacturer_name">
             </div>
          </div>
          <div class="form-group">
            <div class="row mt-2">
              <div class='col-md-4'>
              <label for="fixed_asset_description" class="col-form-label" data-original-title="" title="">Description</label>
              </div>
              <div class="col-md-8">
              <textarea rows="3"  class="form-control required" style="margin-left:-45px;" name="manufacturer_[description]" id="manufacturer_description" placeholder="write here some description of manufacturer"></textarea>
              </div>     
            </div>
          </div>
           <br>
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('add_manufacturers');">Add Manufacturer</button>
          <?php echo form_close();?>