<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/edit_tpsupervisor_do/".$supervisor[0]['id'],array('id' => 'edit_toolplaza_supervisor'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">First Name</label>
      <input type="text" name="first_name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter first name" value="<?php echo $supervisor[0]['fname'];?>">
      
    </div>
      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Last Name</label>
      <input type="text" name="last_name" class="form-control required" value="<?php echo $supervisor[0]['lname'];?>" id="exampleInputEmail1"  placeholder="Enter last name">
      
    </div>
    
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Username</label>
      <input type="text" name="username" class="form-control required" id="exampleInputEmail1" value="<?php echo $supervisor[0]['username'];?>"  placeholder="Enter Username">
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Role</label>
      <select class="form-control required" name="role">
      	<option value="">Select Role</option>
      	<option value="-1" <?php if($supervisor[0]['role'] == -1){ echo "selected";} ?>>Technician</option>
      	<option value="0" <?php if($supervisor[0]['role'] == 0){ echo "selected";} ?>>Supervisor</option>
      	<option value="1" <?php if($supervisor[0]['role'] == 1){ echo "selected";} ?>>Site Incharge</option>
      	<option value="2" <?php if($supervisor[0]['role'] == 2){ echo "selected";} ?>>Technical Manager</option>
      </select>
      
    </div>
    <div class="form-group">
        <label class="col-form-label">Select Toll Plaza</label>
        <select class="form-control required" name="toolplaza">
            <option value="">Choose One</option>
            <?php 
            	if($toolplaza){
            		foreach($toolplaza as $tp){
            			?>
            			 <option value="<?php echo $tp['id']?>" <?php if($supervisor[0]['tollplaza'] == $tp['id']){ echo "selected";}?>><?php echo $tp['name'];?></option>
            	<?php	}


            	}
            ?>
        </select>
      </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Contact</label>
      <input type="text" name="contact" class="form-control required" id="exampleInputEmail1" value="<?php echo $supervisor[0]['contact'];?>"  placeholder="Enter contact">
    </div>

    <div class="form-group " style=''>
             <div class='row'>
                <div class='col-md-4'>
                  <label for="example-text-input" class="col-form-label" style="font-weight:900; margin-left:30px;" data-original-title="" title="">TSP Name</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-4' >
                  <select class="form-control required" name="tsp_id" id="tsp_id" placeholder="Select Asset Name" style="margin-left:-140px;">
                        <?php $data = $this->db->get_where('tsp',array('id' => $supervisor[0]['tsp']))->result_array();?>
                        <option value="<?php echo $supervisor[0]['tsp'];?>"><?php echo $data[0]['name'];?></option>
                    <?php foreach($tsps as $tsp){?>
                    <option value="<?php echo $tsp['id'] ?>"><?php echo $tsp['name'];?></option>
                    <?php } ?> 
                  </select>
                </div>
          </div>
       </div>

       <div class="form-group " style=''>
             <div class='row'>
                <div class='col-md-4'>
                  <label for="example-text-input" class="col-form-label" style="font-weight:900; margin-left:30px;" data-original-title="" title="">Site Name</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-4' >
                  <select class="form-control required" name="site_id" id="site_id" placeholder="Select Asset Name" style="margin-left:-140px;">
                  <?php $data = $this->db->get_where('sites',array('id' => $supervisor[0]['site']))->result_array();?>
                        <option value="<?php echo $data[0]['id'];?>"><?php echo $data[0]['name'];?></option>
                    <?php foreach($sites as $site){?>
                    <option value="<?php echo $site['id'] ?>"><?php echo $site['name'];?></option>
                    <?php } ?> 
                  </select>
                </div>
          </div>
       </div>
     
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('edit_toolplaza_supervisor');">Update</span>
  
<?php echo form_close();?>
</div>
</div>