
<ul class="nav nav-tabs uts" id="myTab" role="tablist">
<?php 
for($i=0; $i<$quantity; $i++)
{
?>
  <li class="nav-item">
    <a class="nav-link <?php if($i == 0){ echo "active";} ?>" id="<?php echo $i."-tab"; ?>" data-toggle="tab" href="#<?php echo $i+1; ?>" role="tab" aria-controls="home" aria-selected="true">STEP <?php echo $i+1; ?></a>
  </li>
  <?php } ?>
</ul>
<?php echo validation_errors(); ?>
<?php echo form_open(base_url()."inventory/action_on_asset/clone_do/",array('id' => 'clone_admin'));?>
<div class="tab-content" id="myTabContent">
 <?php
 for($i=0; $i<$quantity; $i++)
 {
  if($i == 0 && $quantity == 1){ ?>
  <div class="tab-pane fade active show" id="1" role="tabpanel" aria-labelledby="<?php echo $i+1 ?>-tab">
    <p><?php echo "Step 1 "; ?>.</p>
    <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Equipment Name</label>
             </div>
             <div class="col-md-8">
              <span required="" style="margin-left:-45px;" class="form-control" value="" 
               type="" name="equip_name[]" id="equip_name"><?php echo $equip_name.", ";  ?></span>
               <input class="form-control" type="hidden" name='company_type' value="<?php echo $company_type ?>" >
               <input class="form-control" type="hidden" name='company_name' value="<?php echo $company_name ?>" >
               <input class="form-control" type="hidden" name='company_address' value="<?php echo $company_address ?>" >
               <input class="form-control" type="hidden" name='company_person_type' value="<?php echo $company_person_type ?>" >
               <input class="form-control" type="hidden" name='person_name' value="<?php echo $person_name ?>" >
               <input class="form-control" type="hidden" name='person_contact' value="<?php echo $person_contact ?>" >
               <input class="form-control" type="hidden" name='site' value="<?php echo $site ?>" >
               <input class="form-control" type="hidden" name='have_comp' value="<?php echo $have_component ?>" >
               <input class="form-control" type="hidden" name='asset_id' value="<?php echo $asset_id ?>" >
               <input class="form-control" type="hidden" name='item_type' value="<?php echo $item_type ?>" >
               <input class="form-control" type="hidden" name='equip_id[]' value="<?php echo set_value('equip_id[]',$equip_id) ?>" >
             </div>
          </div>
          </div>
          

    <div class="form-group" >
                  <div class='row'>
                    <div class='col-md-3' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Equipment Serial #</label>
                    </div>
                    <div class='col-md-8' >
                    <input class="form-control" type="text" name='equip_serial[]' style="margin-left:-45px;" placeholder="Enter Serial No" value="<?php echo set_value('equip_serial[]') ?>">
                    <!-- <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo $row['id']; ?>"> -->
                    </div>
                   </div>
              </div>
              <?php if($have_component==1){ ?>
              <?php
                  $compData = $this->db->get_where('sub_items',array('item_id' => $equip_id))->result_array();
                  foreach($compData as $c_data)
                  { 
                ?>
          <div class="form-group" >
             <div class='row'>
                 <div class='col-md-3' >
                 <label for="example-text-input" class="col-form-label" data-original-title="" title=""><?php echo $c_data['name']; ?></label>
                 <span class="asterisk" data-original-title="" title="">*</span>
                 </div>
                 <div class='col-md-4' >
                 <input class="form-control" type="text" name='comp_serial[]' placeholder="Enter Serial No" value="<?php echo set_value('comp_serial[]') ?>" >
                 <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo set_value('subitem_id[]',$c_data['id']) ?>" >
                 </div>
                 <div class='col-md-4' >
                 <input class="form-control" type="text" name='comp_model[]' placeholder="Enter Model No" value="<?php echo set_value('comp_model[]') ?>" >
                 </div>
              </div>
           </div>
              <?php } ?>
           <?php } ?>

              <div class="form-group">
             <div class='row'>
                <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Location</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-8' >
                <select class="form-control required" name="locations[]" style="margin-left:-45px;"  placeholder="Select Asset Name" >
                <?php foreach($locations as $loc){?>
                    <option value="<?php echo set_value('locations[]',$loc['id']) ?>"><?php echo $loc['location'];?></option>
                    <?php } ?> 
                </select>
                </div>
              </div>
            </div>
            <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Installing Cost</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <input class="form-control" type="text" name='cost[]' value="<?php echo set_value('cost[]') ?>" style="margin-left:-45px;" >
             </div>
          </div>
          <br>
          <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Comments</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="clone_comments[]" id="clone_comments" style="margin-left:-45px;" >
             <?php echo set_value('clone_comments[]') ?>
             </textarea>
             </div>
          </div>
          </div>

    <?php } ?>
  
<?php
  if($i == 0 && $quantity > 1){ ?>
  <div class="tab-pane fade active show" id="1" role="tabpanel" aria-labelledby="<?php echo $i+1 ?>-tab">
    <p><?php echo "Step 1 "; ?>.</p>
    <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Equipment Name</label>
             </div>
             <div class="col-md-8">
              <span required="" style="margin-left:-45px;" class="form-control" value="" 
               type="" name="equip_name[]" id="equip_name"><?php echo $equip_name.", ";  ?></span>
               <input class="form-control" type="hidden" name='company_type' value="<?php echo $company_type ?>" >
               <input class="form-control" type="hidden" name='company_name' value="<?php echo $company_name ?>" >
               <input class="form-control" type="hidden" name='company_address' value="<?php echo $company_address ?>" >
               <input class="form-control" type="hidden" name='company_person_type' value="<?php echo $company_person_type ?>" >
               <input class="form-control" type="hidden" name='person_name' value="<?php echo $person_name ?>" >
               <input class="form-control" type="hidden" name='person_contact' value="<?php echo $person_contact ?>" >
               <input class="form-control" type="hidden" name='site' value="<?php echo $site ?>" >
               <input class="form-control" type="hidden" name='have_comp' value="<?php echo $have_component ?>" >
               <input class="form-control" type="hidden" name='asset_id' value="<?php echo $asset_id ?>" >
               <input class="form-control" type="hidden" name='item_type' value="<?php echo $item_type ?>" >
               <input class="form-control" type="hidden" name='equip_id[]' value="<?php echo set_value('equip_id[]',$equip_id) ?>" >
             </div>
          </div>
          </div>
          

    <div class="form-group" >
                  <div class='row'>
                    <div class='col-md-3' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Equipment Serial #</label>
                    </div>
                    <div class='col-md-8' >
                    <input class="form-control" type="text" name='equip_serial[]' style="margin-left:-45px;" placeholder="Enter Serial No" value="<?php echo set_value('equip_serial[]') ?>">
                    <!-- <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo $row['id']; ?>"> -->
                    </div>
                   </div>
              </div>

              <?php if($have_component==1){ ?>
              <?php
                 $compData = $this->db->get_where('sub_items',array('item_id' => $equip_id))->result_array();
                 foreach($compData as $c_data){ 
                   ?>
               <div class="form-group" >
               <div class='row'>
                 <div class='col-md-3' >
                 <label for="example-text-input" class="col-form-label" data-original-title="" title=""><?php echo $c_data['name']; ?></label>
                 <span class="asterisk" data-original-title="" title="">*</span>
                 </div>
                 <div class='col-md-4' >
                 <input class="form-control" type="text" name='comp_serial[]' placeholder="Enter Serial No" value="<?php echo set_value('comp_serial[]') ?>" >
                 <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo set_value('subitem_id[]',$c_data['id']) ?>" >
                 </div>
                 <div class='col-md-4' >
                 <input class="form-control" type="text" name='comp_model[]' placeholder="Enter Model No" value="<?php echo set_value('comp_model[]') ?>" >
                 </div>
                </div>
           </div>
              <?php } ?>
           <?php } ?>

              <div class="form-group">
             <div class='row'>
                <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Location</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-8' >
                <select class="form-control required" name="locations[]" style="margin-left:-45px;"  placeholder="Select Asset Name" >
                <?php foreach($locations as $loc){?>
                    <option value="<?php echo set_value('locations[]',$loc['id']) ?>"><?php echo $loc['location'];?></option>
                    <?php } ?> 
                </select>
                </div>
              </div>
            </div>
            <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Installing Cost</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <input class="form-control" type="text" name='cost[]' value="<?php echo set_value('cost[]') ?>" style="margin-left:-45px;" >
             </div>
          </div>
          </div>
          <br>
          <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Comments</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="clone_comments[]" id="clone_comments" style="margin-left:-45px;" >
             <?php echo set_value('clone_comments[]') ?>
             </textarea>
             </div>
          </div>
          </div>

    <div class="input-group mb-3 group-end">
      <a class="btn btn-success btnNext btn-md">Next</a>
    </div>

  </div>
        <!--/. form element wrap -->
    <?php } ?>



  <?php 
  if($i>=1 && $i<$quantity-1){
  ?>
  <div class="tab-pane fade" id="<?php echo $i+1; ?>" role="tabpanel" aria-labelledby="<?php echo $i+1 ?>-tab">
    <p>STEP <?php echo $i+1; ?>.</p>

    <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Equipment Name</label>
             </div>
             <div class="col-md-8">
              <span required="" style="margin-left:-45px;" class="form-control" value="" 
               type="" name="equip_name[]" id="equip_name"><?php echo $equip_name.", ";  ?></span>
               <input class="form-control" type="hidden" name='equip_id[]' value="<?php echo set_value('equip_id[]',$equip_id) ?>" >
             </div>
          </div>
          </div>
          

    <div class="form-group" >
                  <div class='row'>
                    <div class='col-md-3' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Equipment Serial #</label>
                    </div>
                    <div class='col-md-8' >
                    <input class="form-control" type="text" name='equip_serial[]' style="margin-left:-45px;" placeholder="Enter Serial No" value="<?php echo set_value('equip_serial[]') ?>">
                    <!-- <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo $row['id']; ?>"> -->
                    </div>
                   </div>
              </div>

              <?php if($have_component==1){ ?>
              <?php
                  $compData = $this->db->get_where('sub_items',array('item_id' => $equip_id))->result_array();
                  foreach($compData as $c_data)
                  { 
                ?>
          <div class="form-group" >
             <div class='row'>
                 <div class='col-md-3' >
                 <label for="example-text-input" class="col-form-label" data-original-title="" title=""><?php echo $c_data['name']; ?></label>
                 <span class="asterisk" data-original-title="" title="">*</span>
                 </div>
                 <div class='col-md-4' >
                 <input class="form-control" type="text" name='comp_serial[]' placeholder="Enter Serial No" value="<?php echo set_value('comp_serial[]') ?>" >
                 <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo set_value('subitem_id[]',$c_data['id']) ?>" >
                 </div>
                 <div class='col-md-4' >
                 <input class="form-control" type="text" name='comp_model[]' placeholder="Enter Model No" value="<?php echo set_value('comp_model[]') ?>" >
                 </div>
              </div>
           </div>
              <?php } ?>
           <?php } ?>

              <div class="form-group">
             <div class='row'>
                <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Location</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-8' >
                <select class="form-control required" name="locations[]" style="margin-left:-45px;"  placeholder="Select Asset Name" >
                <?php foreach($locations as $loc){?>
                    <option value="<?php echo set_value('locations[]',$loc['id']) ?>"><?php echo $loc['location'];?></option>
                    <?php } ?> 
                </select>
                </div>
              </div>
            </div>

            <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Installing Cost</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <input class="form-control" type="text" name='cost[]' value="<?php echo set_value('cost[]') ?>" style="margin-left:-45px;" >
             </div>
          </div>
          </div>
          
          <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Comments</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="clone_comments[]" id="clone_comments" style="margin-left:-45px;" >
             <?php echo set_value('clone_comments[]') ?>
             </textarea>
             </div>
          </div>
          </div>

    <div class="input-group mb-3 group-end">
      <a class="btn btn-danger btnPrevious btn-md">Previous</a>
      <a class="btn btn-success btnNext btn-md">Next</a>
    </div>
  </div>

    <!--/. form element wrap -->
    <?php }?>
    
  

  <?php if($i==$quantity-1 && $quantity > 1){ ?>
  <div class="tab-pane fade" id="<?php echo $quantity; ?>" role="tabpanel" aria-labelledby="<?php echo $i+1 ?>-tab">
    <p><?php echo "STEP".$quantity; ?>.</p>

      <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Equipment Name</label>
             </div>
             <div class="col-md-8">
              <span required="" style="margin-left:-45px;" class="form-control" value="" 
               type="" name="equip_name[]" id="equip_name"><?php echo $equip_name.", ";  ?></span>
               <input class="form-control" type="hidden" name='equip_id[]' value="<?php echo set_value('equip_id[]',$equip_id) ?>" >
             </div>
          </div>
          <br>

    <div class="form-group" >
                  <div class='row'>
                    <div class='col-md-3' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Equipment Serial #</label>
                    </div>
                    <div class='col-md-8' >
                    <input class="form-control" type="text" name='equip_serial[]' style="margin-left:-45px;" placeholder="Enter Serial No" value="<?php echo set_value('equip_serial[]') ?>">
                    <!-- <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo $row['id']; ?>"> -->
                    </div>
                   </div>
              </div>

              <?php if($have_component==1){ ?>
              <?php
                  $compData = $this->db->get_where('sub_items',array('item_id' => $equip_id))->result_array();
                  foreach($compData as $c_data)
                  { 
                ?>
          <div class="form-group" >
             <div class='row'>
                 <div class='col-md-3' >
                 <label for="example-text-input" class="col-form-label" data-original-title="" title=""><?php echo $c_data['name']; ?></label>
                 <span class="asterisk" data-original-title="" title="">*</span>
                 </div>
                 <div class='col-md-4' >
                 <input class="form-control" type="text" name='comp_serial[]' placeholder="Enter Serial No" value="<?php echo set_value('comp_serial[]') ?>" >
                 <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo set_value('subitem_id[]',$c_data['id']) ?>" >
                 </div>
                 <div class='col-md-4' >
                 <input class="form-control" type="text" name='comp_model[]' placeholder="Enter Model No" value="<?php echo set_value('comp_model[]') ?>" >
                 </div>
              </div>
           </div>
              <?php } ?>
           <?php } ?>

              <div class="form-group">
             <div class='row'>
                <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Location</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-8' >
                <select class="form-control required" name="locations[]" style="margin-left:-45px;" id="locations" placeholder="Select Asset Name" >
                <?php foreach($locations as $loc){?>
                    <option value="<?php echo set_value('locations[]',$loc['id']) ?>"><?php echo $loc['location'];?></option>
                    <?php } ?> 
                </select>
                </div>
              </div>
            </div>
            <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Installing Cost</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <input class="form-control" type="text" name='cost[]' value="<?php echo set_value('cost[]') ?>" style="margin-left:-45px;" >
             </div>
          </div>
          <br>

          <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Comments</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="clone_comments[]" id="clone_comments" style="margin-left:-45px;" >
             <?php echo set_value('clone_comments[]') ?>
             </textarea>
             </div>
          </div>

    <div class="input-group mb-3 group-end">
      <a class="btn btn-danger btnPrevious btn-md">Previous</a>

    </div>
  <?php } ?>
    <!--/. form element wrap -->
    <?php
      }
     ?>
</div>
<button type="button" class="btn btn-primary pull-right" onclick="form_submit('clone_admin');">Install</button>
<?php echo form_close();?>


<script>
  $(document).ready(function() {
  $('.btnNext').click(function() {
    $('.uts .active').parent().next('li').find('a').trigger('click');
  });

  $('.btnPrevious').click(function() {
    $('.uts .active').parent().prev('li').find('a').trigger('click');
  });
});

</script>