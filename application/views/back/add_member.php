<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/add_member_do/",array('id' => 'add_member'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">First Name</label>
      <input type="text" name="first_name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter first name">
      
    </div>
      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Last Name</label>
      <input type="text" name="last_name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter last name">
      
    </div>
      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Username</label>
      <input type="text" name="username" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Username">
      
    </div>
      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Password</label>
      <input type="text" name="Password" class="form-control required" id="exampleInputEmail1"  placeholder="Enter password">
      
    </div>
      <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Contact</label>
      <input type="text" name="contact" class="form-control required" id="exampleInputEmail1"  placeholder="Enter contact">
    </div>

    <div class="form-group " style=''>
             <div class='row'>
                <div class='col-md-4'>
                  <label for="example-text-input" class="col-form-label" style="font-weight:900; margin-left:30px;" data-original-title="" title="">TSP Name</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-4' >
                  <select class="form-control required" name="tsp_id" id="tsp_id" placeholder="Select Asset Name" style="margin-left:-140px;">
                        <option value=""><?php echo "Select Option";?></option>
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
                        <option value=""><?php echo "Select Option";?></option>
                    <?php foreach($sites as $site){?>
                    <option value="<?php echo $site['id'] ?>"><?php echo $site['name'];?></option>
                    <?php } ?> 
                  </select>
                </div>
          </div>
       </div>
     
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('add_member');">Add</span>
  
<?php echo form_close();?>
</div>
</div>