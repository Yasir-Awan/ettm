<?php echo form_open_multipart(base_url() . "inventory/add_item_do/", array('id' => 'add_items')); ?>
<div class="form-group">
  <div class='row'>
    <div class='col-md-4'>
      <label for="example-text-input" class="col-form-label" data-original-title="" title="">Category</label>
      <span class="asterisk" data-original-title="" title="">*</span>
    </div>
    <div class='col-md-8'>
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
    <div class='col-md-4'>
      <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Name</label>
      <span class="asterisk" data-original-title="" title="">*</span>
    </div>
    <div class="col-md-8">
      <input required="required" style="margin-left:-45px;" class="form-control" value="LCD" type="text" name="item_name" id="item_name">
    </div>
  </div>
  <br>

  <div class="form-group">
    <div class='row'>
      <div class='col-md-4'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">Have Sub items</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class="col-md-4">
        <input type="radio" name="subitems" value="1"> Yes<br>
      </div>
      <div class="col-md-4">
        <input type="radio" name="subitems" value="0"> No<br>
      </div>
    </div>
    <br>

    <div class="form-group">
      <div class="row">
        <div class='col-md-4'>
          <label for="fixed_asset_description" class="col-form-label" data-original-title="" title="">Description</label>
          <span class="asterisk" data-original-title="" title="">*</span>
        </div>
        <div class="col-md-8">
          <textarea rows="5" class="form-control" style="margin-left:-45px;" name="item_[description]" id="item_description"></textarea>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="row">

        <div class='col-md-4'>
          <label for="fixed_asset_description" class="col-form-label" data-original-title="" title="">Choose File</label>
          <span class="asterisk" data-original-title="" title="">*</span>
        </div>

        <div class="col-md-4 pr-1 wrap-input-container">
          <label>Upload Signed File<span class="text-danger">* (Only PDF and Image is allowed)</span></label>
          <input class="file-upload form-control required" name="item_img" type="file" accept="application/pdf,image/*">
        </div>

      </div>
    </div>

  </div>
  <br>
  <button type="button" class="btn btn-primary pull-right" onclick="form_submit('add_items');">Add Item</button>
  <?php echo form_close(); ?>