<?php echo form_open(base_url() . "inventory/edit_item_do/" . $item[0]['id'], array('id' => 'edit_items')); ?>

<div class="form-group">
  <div class='row'>
    <div class='col-md-4'>
      <label for="example-text-input" class="col-form-label" data-original-title="" title="">Category</label>
      <span class="asterisk" data-original-title="" title="">*</span>
    </div>
    <div class='col-md-8'>
      <select class="form-control required" style="margin-left:-45px;" name="item_type" id="item_type" placeholder="Select Asset Name">
        <?php
        if ($item[0]['item_type'] == 1) {
          echo "Marketing & Promotional Type";
        } elseif ($item[0]['item_type'] == 2) {
          echo "Event & stagging Equipment";
        } elseif ($item[0]['item_type'] == 3) {
          echo "Electronic Equipment";
        } elseif ($item[0]['item_type'] == 4) {
          echo "Support Room Equipment";
        } elseif ($item[0]['item_type'] == 5) {
          echo "Cashup Room Equipment";
        } elseif ($item[0]['item_type'] == 6) {
          echo "Control Room Equipment";
        } elseif ($item[0]['item_type'] == 7) {
          echo "Power Supply Equipment";
        } elseif ($item[0]['item_type'] == 8) {
          echo "Lane Equipment";
        } elseif ($item[0]['item_type'] == 9) {
          echo "Booth Equipment";
        } elseif ($item[0]['item_type'] == 10) {
          echo "Consumeables";
        } elseif ($item[0]['item_type'] == 11) {
          echo "Furniture";
        } elseif ($item[0]['item_type'] == 12) {
          echo "IT Assets";
        } elseif ($item[0]['item_type'] == 13) {
          echo "Tools";
        }
        ?>
        <option value="<?php echo $item[0]['item_type'] ?>"><?php
                                                            if ($item[0]['item_type'] == 1) {
                                                              echo "Marketing & Promotional Type";
                                                            } elseif ($item[0]['item_type'] == 2) {
                                                              echo "Event & stagging Equipment";
                                                            } elseif ($item[0]['item_type'] == 3) {
                                                              echo "Electronic Equipment";
                                                            } elseif ($item[0]['item_type'] == 4) {
                                                              echo "Support Room Equipment";
                                                            } elseif ($item[0]['item_type'] == 5) {
                                                              echo "Cashup Room Equipment";
                                                            } elseif ($item[0]['item_type'] == 6) {
                                                              echo "Control Room Equipment";
                                                            } elseif ($item[0]['item_type'] == 7) {
                                                              echo "Power Supply Equipment";
                                                            } elseif ($item[0]['item_type'] == 8) {
                                                              echo "Lane Equipment";
                                                            } elseif ($item[0]['item_type'] == 9) {
                                                              echo "Booth Equipment";
                                                            } elseif ($item[0]['item_type'] == 10) {
                                                              echo "Consumeables";
                                                            } elseif ($item[0]['item_type'] == 11) {
                                                              echo "Furniture";
                                                            } elseif ($item[0]['item_type'] == 12) {
                                                              echo "IT Assets";
                                                            } elseif ($item[0]['item_type'] == 13) {
                                                              echo "Tools";
                                                            }
                                                            ?></option>
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
    </div>
    <div class="col-md-8">
      <input required="required" style="margin-left:-45px;" class="form-control" value='<?php echo $item[0]['name'] ?>' type="text" name="item-name" id="item-name">
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
        <input type="radio" name="subitems" value="<?php echo $item[0]['have_sub_items'] ?>"> Yes<br>
      </div>
      <div class="col-md-4">
        <input type="radio" name="subitems" value="<?php echo $item[0]['have_sub_items'] ?>"> No<br>
      </div>
    </div>
    <br>
    <div class="form-group">
      <div class="row">
        <div class='col-md-4'>
          <label for="fixed_asset_description" class="col-form-label" data-original-title="" title="">Description</label>
        </div>
        <div class="col-md-8">
          <textarea rows="5" class="form-control" style="margin-left:-45px;" name="item-[description]" id="item-description"><?php echo $item[0]['description'] ?></textarea>
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
  <button type="button" class="btn btn-primary pull-right" onclick="form_submit('edit_items');">Update Item</button>
  <?php echo form_close(); ?>