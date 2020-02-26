<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/edit_tpstaff_do/".$tpstaff[0]['id'],array('id' => 'edit_tpstaff'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">First Name</label>
      <input type="text" name="first_name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter first name" value="<?php echo $tpstaff[0]['fname'];?>">
      
    </div>
      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Last Name</label>
      <input type="text" name="last_name" class="form-control required" value="<?php echo $tpstaff[0]['lname'];?>" id="exampleInputEmail1"  placeholder="Enter last name">
      
    </div>
    <div class="form-group">
        <label class="col-form-label" style="font-weight: 900;">Select Toll Plaza</label>
        <select class="form-control required" name="toolplaza">
            <option value="">Choose One</option>
            <?php 
            	if($toolplaza){
            		foreach($toolplaza as $tp){
            			?>
            			 <option value="<?php echo $tp['id']?>" <?php if($tpstaff[0]['tollplaza'] == $tp['id']){ echo "selected";}?>><?php echo $tp['name'];?></option>
            	<?php	}


            	}
            ?>
        </select>
      </div>
      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Designation</label>
      <input type="text" name="designation" class="form-control required" id="exampleInputEmail1" value="<?php echo $tpstaff[0]['designation'];?>"  placeholder="Enter designation">
      
    </div>
      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Contact</label>
      <input type="text" name="contact" class="form-control required" id="exampleInputEmail1" value="<?php echo $tpstaff[0]['contact'];?>"  placeholder="Enter contact">
      
    </div>
     <div class="form-group">
        <label class="col-form-label" style="font-weight: 900;">Select Status</label>
        <select class="form-control required" name="status">
            <option value="1" <?php if($tpstaff[0]['status'] == 1){ echo 'selected';} ?>>Active</option>
            <option value="0" <?php if($tpstaff[0]['status'] == 0){ echo 'selected';} ?>>Inactive</option>
        </select>
      </div>
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('edit_tpstaff');">Update</span>
  
<?php echo form_close();?>
</div>
</div>