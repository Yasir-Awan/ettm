<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/WeighCompany/update/".$weigh_company[0]['id'],array('id' => 'edit_weighuser'));?>
        <div class="form-group">
      <label style="font-weight: 900;">Name</label>
      <input type="text" name="sur_name" class="form-control required" value="<?php echo $weigh_company[0]['name']?>"  placeholder="Enter OMC name"> 
    </div>
    <div class="form-group">
      <label style="font-weight: 900;">Username</label>
      <input type="text" name="username" class="form-control required" value="<?php echo $weigh_company[0]['username']?>"  placeholder="Enter Username">
    </div>
    <div class="form-group">
      <label style="font-weight: 900;">Password</label>
      <input type="text" name="Password" class="form-control required" value="<?php echo $weigh_company[0]['password']?>"  placeholder="Enter password">
    </div>
    <div class="form-group">
        <label class="col-form-label">Weigh Company</label>
        <select class="form-control required" name="company">
            <?php if($weigh_company[0]['weigh_company']==1){ ?>
            <option value="1">Toll Link</option>
            <option value="2">National Engineers</option>
            <?php } ?>
            <?php if($weigh_company[0]['weigh_company']==2){ ?>
                <option value="2">National Engineers</option>
            <option value="1">Toll Link</option>
            <?php } ?>
        </select>
      </div>
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('edit_weighuser');">Update Weigh User</span>
  
<?php echo form_close();?>
</div>
</div>