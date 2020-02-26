<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/update_tpsupervisor_password/".$supervisor_id,array('id' => 'update_supervisor_pass'));?>

      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">New Password</label>
      <input type="text" name="password" class="form-control required"  id="exampleInputEmail1"  placeholder="Enter New Password">
      
    </div>
      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Confirm Password</label>
      <input type="text" name="password_confirm" class="form-control required" id="exampleInputEmail1"   placeholder="Confirm Password">
      
    </div>
    
    
     
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('update_supervisor_pass');">Update</span>
  
<?php echo form_close();?>
</div>
</div>