<?php echo form_open(base_url()."supervisor_inventory/add_item_do/",array('id' => 'add_items'));?>
        <div class="form-group">
              <div class='row'>
                  <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Type</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                  </div>
                  <div class='col-md-8' >
                    <select class="form-control required" style="margin-left:-45px;" name="item_type" id="item_type" placeholder="Select Asset Name">
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
        <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Name</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control" value="LCD" 
               type="text" name="item_name" id="item_name">
             </div>
          </div>
          <br>
        <div class="form-group">
            <div class="row">
              <div class='col-md-3'>
              <label for="fixed_asset_description" class="col-form-label" data-original-title="" title="">Description</label>
              </div>
              <div class="col-md-8">
              <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="item_[description]" id="item_description"></textarea>
              </div>     
            </div>
          </div>
        </div>
           <br>
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('add_items');">Add Item</button>
          <?php echo form_close();?>