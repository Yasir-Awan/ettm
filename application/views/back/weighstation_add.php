<div class="row">
  <div class="col-md-12">
  <?php echo form_open(base_url()."admin/weighstation/do_add",array('id' => 'add_weigh'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Weighstation Name</label>
      <input type="text" name="name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Weighstation name">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Route</label>
      <select class="form-control required" name="route" id="route">
        <option value="">Select Route</option>
        <?php foreach($routes as $route){?>
          <option value="<?php echo $route['id']?>"><?php echo $route['name'];?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Located On</label>
      <select class="form-control required" name="loc" id="loc">
        <option value="">Choose Type</option>
        <option value="1">Motorway</option>
        <option value="2">National Highway</option>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Software Type</label>
      <select class="form-control required" name="sofware_type" id="sofware_type">
        <option value="">Choose Software Type</option>
        <option value="0">Manual</option>
        <option value="1">DAW</option>
        <option value="2">JOD</option>
        <option value="3">Toll Link</option>
      </select>
    </div>
    <div id="dynamic_type">
       
    </div>
    
    <div id="dynamicInput2"></div>
    
    
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('add_weigh');">Add Weighstation</span>
  
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

