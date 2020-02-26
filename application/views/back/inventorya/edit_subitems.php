<?php echo form_open(base_url()."inventory/edit_subitem_do/".$subitems[0]['id'],array('id' => 'edit_subitems'));?>
               
<div class="form-group">
              <div class='row'>
                  <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Category</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                  </div>
                  <div class='col-md-8' >
                  <?php $itemName = $this->db->get_where('items',array('id' => $subitems[0]['item_id']))->result_array(); ?>
                  <?php  $itype;
                     if($subitems[0]['item_type']==1)
                     {
                      $itype = "Marketing & Promotional Type";
                     } 
                     elseif($subitems[0]['item_type']==2)
                     {
                        $itype = "Event & stagging Equipment";
                     } 
                     elseif($subitems[0]['item_type']==3)
                     {
                        $itype = "Electronic Equipment";
                     } 
                     elseif($subitems[0]['item_type']==4)
                     {
                        $itype = "Support Room Equipment";
                     } 
                     elseif($subitems[0]['item_type']==5)
                     {
                        $itype = "Cashup Room Equipment";
                     } 
                     elseif($subitems[0]['item_type']==6)
                     {
                        $itype = "Control Room Equipment";
                     } 
                     elseif($subitems[0]['item_type']==7)
                     {
                        $itype = "Power Supply Equipment";
                     } 
                     elseif($subitems[0]['item_type']==8)
                     {
                        $itype = "Lane Equipment";
                     } 
                     elseif($subitems[0]['item_type']==9)
                     {
                        $itype = "Booth Equipment";
                     } 
                     elseif($subitems[0]['item_type']==10)
                     {
                        $itype = "Consumeables";
                     } 
                     elseif($subitems[0]['item_type']==11)
                     {
                        $itype = "Furniture";
                     }
                     elseif($subitems[0]['item_type']==12)
                     {
                        $itype = "IT Assets";
                     } 
                     elseif($subitems[0]['item_type']==13)
                     {
                        $itype = "Tools";
                     } 
                     ?>
                  <input type="text" class="form-control required" name="i_type" id="i_type" placeholder="Select  Name" value="<?php echo $itype;?>" readonly >
                      <input type="hidden" class="form-control required" name="item_category" id="item_category"  value="<?php echo $itemName[0]['item_type'] ?>" >
                    
                  </div>
              </div>
        </div>
        <div class="form-group mainitem_name">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Name</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-8' >
                    
                    <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Select  Name" value="<?php echo $itemName[0]['name'];?>" readonly >
                      <input type="hidden" class="form-control" name="item_name" id="item_name"  value="<?php echo $itemName[0]['id'] ?>" >
                   
                    
                    </div>
                   </div>
                </div>

        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Sub Item Name</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control" value='<?php echo $subitems[0]['name']?>' 
               type="text" name="subitem_name" id="subitem_name">
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
              <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="subitem_[description]" id="subitem-description"><?php echo $subitems[0]['description']?></textarea>
              </div>     
            </div>
          </div>
        </div>
           <br>
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('edit_subitems');">Update Subitem</button>
          <?php echo form_close();?>