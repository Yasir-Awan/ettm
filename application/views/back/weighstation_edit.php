<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/weighstation/update/".$weigh[0]['id'],array('id' => 'update_weigh'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Weighstation Name</label>
      <input type="text" name="name" class="form-control required" value="<?php echo $weigh[0]['name']?>" id="exampleInputEmail1"  placeholder="Enter Weighstation name">
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Route</label>
      <select class="form-control required" name="route" id="route">
        <option value="">Select Route</option>
        <?php foreach($routes as $route){?>
          <option value="<?php echo $route['id']?>" <?php if($weigh[0]['route'] == $route['id']){ echo "selected";}?>><?php echo $route['name'];?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Located On</label>
      <select class="form-control required" name="loc" id="loc">
        <option value="">Choose Type</option>
        <option value="1" <?php if($weigh[0]['loc'] == 1){echo "selected";}?>>Motorway</option>
        <option value="2" <?php if($weigh[0]['loc'] == 2){echo "selected";}?>>National Highway</option>
      </select>
    </div>
   
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Software Type</label>
      <select class="form-control required" name="sofware_type" id="sofware_type">
        <option value="">Choose Software Type</option>
        <option value="0" <?php if($weigh[0]['software_type'] == 0){echo "selected";}?>>Manual</option>
        <option value="1" <?php if($weigh[0]['software_type'] == 1){echo "selected";}?>>DAW</option>
        <option value="2" <?php if($weigh[0]['software_type'] == 2){echo "selected";}?>>JOD</option>
        <option value="3" <?php if($weigh[0]['software_type'] == 3){echo "selected";}?>>Toll Link</option>
      </select>
    </div>
    <div id="dynamic_type">
       <?php if($weigh[0]['software_type'] == 1 || $weigh[0]['software_type'] == 2){ ?>
      
        <div class="form-group">
            <label for="exampleInputEmail1" style="font-weight: 900;">Type</label>
            <select class="form-control required" name="type" id="type">
              <option value="">Choose Type</option>
              <option value="1" <?php if($weigh[0]['type'] == 1){echo "selected";}?>>Local</option>
              <option value="2" <?php if($weigh[0]['type'] == 2){echo "selected";}?>>FTP</option>
            </select>
        </div>
      <?php } elseif($weigh[0]['software_type'] == 3){ ?>
        <div class="form-group">
          <label for="exampleInputEmail1" style="font-weight: 900;">Ip Address</label>
          <input type="text" name="ip" class="form-control required" id="exampleInputEmail1"  placeholder="Enter server IP address" value="<?php echo $weigh[0]['address']?>">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1" style="font-weight: 900;">Database Name</label>
          <input type="text" name="dbname" class="form-control required" id="exampleInputEmail1"  placeholder="Enter database name" value="<?php echo $weigh[0]['db_name']?>">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1" style="font-weight: 900;">Username</label>
          <input type="text" name="user_name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter username of database" value="<?php echo $weigh[0]['username']?>">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1" style="font-weight: 900;">Password</label>
          <input type="password" name="pwd" class="form-control required" id="exampleInputEmail1"  placeholder="Enter password of database" value="<?php echo $weigh[0]['password']?>">
        </div>
      <?php }?>
    </div>
    <div id="dynamicInput2">
      <?php if($weigh[0]['software_type'] == 1 || $weigh[0]['software_type'] == 2){ 
       if($weigh[0]['type'] == 1){?>
        <div class="form-group">
          <label for="exampleInputEmail1" style="font-weight: 900;">IP Address</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupPrepend">\\\\</span>
            </div>
            <input type="text" name="ip_address" class="form-control required" value="<?php echo $weigh[0]['address']?>" id="exampleInputEmail1"  placeholder="Enter IP Address">
          </div>
        </div>
      <?php }elseif($weigh[0]['type'] == 2){?>
        <div class="form-group">
          <label for="exampleInputEmail1" style="font-weight: 900;">FTP Address</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupPrepend">ftp://</span>
            </div>
            <input type="text" name="ftp_address" class="form-control required" id="exampleInputEmail1"  value="<?php echo $weigh[0]['address']?>" placeholder="Enter FTP Address">
          </div>
        </div>
      <?php } }?>
    </div>
    
   
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('update_weigh');">Update Weighstation</span>
  
<?php echo form_close();?>
</div>
</div>

<script>
  $('body').on('change','#type',function(){
    if(this.value == 1){
        var ni = document.getElementById('dynamicInput2');
        var newdiv = document.createElement('div');
        
        ni.innerHTML = '<div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">IP Address</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend">\\\\</span></div><input type="text" name="ip_address" class="form-control required" id="exampleInputEmail1"  placeholder="Enter IP Address"></div></div>';
        //ni.appendChild(newdiv);
    }else if(this.value == 2){
        
        var ni = document.getElementById('dynamicInput2');
        var newdiv = document.createElement('div');
        ni.innerHTML = '<div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">FTP Address</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend">ftp://</span></div><input type="text" name="ftp_address" class="form-control required" id="exampleInputEmail1"  placeholder="Enter FTP Address"></div></div>';
    }
  });

 $('#sofware_type').change(function(){
    $('#dynamicInput2').html('');
    if(this.value == 1 || this.value == 2){
        var ni = document.getElementById('dynamic_type');
        var newdiv = document.createElement('div');
        ni.innerHTML = '<div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">Type</label><select class="form-control required" name="type" id="type"><option value="">Choose Type</option><option value="1">Local</option><option value="2">FTP</option></select></div>';
        
    }else if(this.value == 3){
        
        var ni = document.getElementById('dynamic_type');
        var newdiv = document.createElement('div');
        ni.innerHTML = '<div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">Ip Address</label><input type="text" name="ip" class="form-control required" id="exampleInputEmail1"  placeholder="Enter server IP address"></div><div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">Database Name</label><input type="text" name="dbname" class="form-control required" id="exampleInputEmail1"  placeholder="Enter database name"></div><div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">Username</label><input type="text" name="user_name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter username of database"></div><div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">Password</label><input type="password" name="pwd" class="form-control required" id="exampleInputEmail1"  placeholder="Enter password of database"></div>';
    }else{
        
        var ni = document.getElementById('dynamic_type');
        var newdiv = document.createElement('div');
        ni.innerHTML = '';
    }
  });
</script>