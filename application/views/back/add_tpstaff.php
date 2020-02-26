<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/tpstaff_add_do/",array('id' => 'add_tpstaff'));?>
    <div class="form-group">
        <label class="col-form-label">Select Toll Plaza</label>
        <select class="form-control required" name="toolplaza">
            <option value="">Choose One</option>
            <?php 
            	if($toolplaza){
            		foreach($toolplaza as $tp){
            			?>
            			 <option value="<?php echo $tp['id']?>"><?php echo $tp['name'];?></option>
            	<?php	}


            	}
            ?>
		</select>
      <label for="exampleInputEmail1" style="font-weight: 900;">First Name</label>
      <input type="text" name="first_name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter first name">
      
    </div>
      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Last Name</label>
      <input type="text" name="last_name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter last name">
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Designation</label>
      <input type="text" name="designation" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Designation">
      
    </div>

      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Contact</label>
      <input type="text" name="contact" class="form-control required" id="exampleInputEmail1"  placeholder="Enter contact">
      
    </div>
     
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('add_tpstaff');">Add</span>
  
<?php echo form_close();?>
</div>
</div>