<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/WeighCompany/add_do/",array('id' => 'add_weighuser'));?>
    <div class="form-group">
      <label style="font-weight: 900;">Name</label>
      <input type="text" name="sur_name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter OMC name"> 
    </div>
    <div class="form-group">
      <label style="font-weight: 900;">Username</label>
      <input type="text" name="username" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Username">
    </div>
    <div class="form-group">
      <label style="font-weight: 900;">Password</label>
      <input type="text" name="Password" class="form-control required" id="exampleInputEmail1"  placeholder="Enter password">
    </div>
    <div class="form-group">
        <label class="col-form-label">Weigh Company</label>
        <select class="form-control required" name="company">
            <option value="">Choose One</option>
            <option value="1">Toll Link</option>
            <option value="2">National Engineers</option>
        </select>
      </div>
    </div>
      <br>
      <br>
    <span class="btn btn-primary btn-sm" style="margin-left:auto;" onclick="form_submit('add_weighuser');">Add Weigh User</span>
  
<?php echo form_close();?>
</div>
</div>