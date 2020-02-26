<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/omc/add_do/",array('id' => 'add_omc'));?>
    <div class="form-group">
      <label style="font-weight: 900;">OMC Name</label>
      <input type="text" name="omcname" class="form-control required" id="exampleInputEmail1"  placeholder="Enter OMC name"> 
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
      </div>
    </div>
      
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('add_omc');">Add OMC</span>
  
<?php echo form_close();?>
</div>
</div>