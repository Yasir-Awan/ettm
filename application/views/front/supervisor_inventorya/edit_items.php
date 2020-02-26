<?php echo form_open(base_url()."supervisor_inventory/edit_item_do/".$item[0]['id'],array('id' => 'edit_items'));?>
               
<div class="form-group">
              <div class='row'>
                  <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Name</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                  </div>
                  <div class='col-md-8' >
                    <select class="form-control required" style="margin-left:-45px;" name="item_type" id="item_type" placeholder="Select Asset Name">
                    <?php 
                     if( $item[0]['item_type']==1)
                     { 
                         $item_type = "Electronic Equipment";
                         $value = $item[0]['item_type'];
                     }
                     if( $item[0]['item_type']==2)
                     { 
                         $item_type = "Heavy Equipment";
                         $value = $item[0]['item_type'];
                     } 
                     if( $item[0]['item_type']==3)
                     { 
                         $item_type = "Lab Equipment";
                         $value = $item[0]['item_type'];
                     }
                     if( $item[0]['item_type']==4)
                     { 
                         $item_type = "Event & Staging Equipment";
                         $value = $item[0]['item_type'];
                     } 
                     if( $item[0]['item_type']==5)
                     { 
                         $item_type = "Marketing & Promotional Material.";
                         $value = $item[0]['item_type'];
                     } 
                     if( $item[0]['item_type']==5)
                     { 
                         $item_type = "IT Assets";
                         $value = $item[0]['item_type'];
                     } 
                     if( $item[0]['item_type']==5)
                     { 
                         $item_type = "Consumables";
                         $value = $item[0]['item_type'];
                     }
                     if( $item[0]['item_type']==6)
                     { 
                         $item_type = "Tools";
                         $value = $item[0]['item_type'];
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
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Name</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control" value='<?php echo $item[0]['name']?>' 
               type="text" name="item-name" id="item-name">
             </div>
          </div>
          <br>
        <div class="form-group">
            <div class="row">
              <div class='col-md-3'>
              <label for="fixed_asset_description" class="col-form-label" data-original-title="" title="">Description</label>
              </div>
              <div class="col-md-8">
              <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="item-[description]" id="item-description"><?php echo $item[0]['description']?></textarea>
              </div>     
            </div>
          </div>
        </div>
           <br>
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('edit_items');">Update Item</button>
          <?php echo form_close();?>