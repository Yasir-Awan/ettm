<?php echo form_open(base_url()."supervisor_inventory/add_supplier_do/",array('id' => 'add_suppliers'));?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Supplier Name</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control required" placeholder="Supplier" 
               type="text" name="supplier_name" id="supplier_name">
             </div>
          </div>
          
          <div class="form-group">
          <div class='row mt-2'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Focal Person</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control required" placeholder="Enter focal person Name" 
               type="text" name="focal_name" id="focal_name">
             </div>
          </div>

          <div class="form-group">
          <div class='row  mt-2'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Contact</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control required" placeholder="Enter focal person's contact" 
               type="number" name="contact" id="contact">
             </div>
          </div>

          <div class="form-group">
            <div class="row mt-2">
              <div class='col-md-4'>
              <label for="fixed_asset_description" class="col-form-label" data-original-title="" title="">Address</label>
              </div>
              <div class="col-md-8">
              <textarea rows="3"  class="form-control required" style="margin-left:-45px;" name="address_[description]" id="address_description" placeholder="write here complete address of supplier"></textarea>
              </div>     
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class='col-md-4'>
              <label for="fixed_asset_description" class="col-form-label" data-original-title="" title="">Description</label>
              </div>
              <div class="col-md-8">
              <textarea rows="4"  class="form-control required" style="margin-left:-45px;" name="supplier_[description]" id="supplier_description" placeholder="write about supplier what type of supplier what it does whether it is a single person or company"></textarea>
              </div>     
            </div>
          </div>
           <br>

        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('add_suppliers');">Add Supplier</button>
          <?php echo form_close();?>