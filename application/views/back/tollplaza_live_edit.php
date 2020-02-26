<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/tollplaza_live/do_update/".$tollplaza_live[0]['id'],array('id' => 'update_live'));?>
    
     <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Tollplaza</label>
      <select class="form-control required" name="tollplaza" id="tollplaza">
        <option value="">Choose Tollplaza</option>
        <?php foreach($tollplaza as $row){?>
        <option value="<?php echo $row['id']?>" <?php if($tollplaza_live[0]['tollplaza_id'] == $row['id']){echo "selected";}?>><?php echo $row['name'];?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Type</label>
      <select class="form-control required" name="type" id="type">
        <option value="">Choose Type</option>
        <option value="1" <?php if($tollplaza_live[0]['type'] == 1){ echo "selected";}?>>Local</option>
        <option value="2" <?php if($tollplaza_live[0]['type'] == 2){ echo "selected";}?>>FTP</option>
      </select>
    </div>
    <div id="dynamicInput2">
      <?php if($tollplaza_live[0]['type'] == 1){?>
      <div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">IP Address</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend">\\\\</span></div><input type="text" name="ip_address" class="form-control required" value="<?php echo $tollplaza_live[0]['server_ip'];?>" id="exampleInputEmail1"  placeholder="Enter IP Address"></div></div>
      <?php }else{?>
      <div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">FTP Address</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend">ftp://</span></div><input type="text" name="ftp_address" class="form-control required" value="<?php echo $tollplaza_live[0]['server_ip'];?>" id="exampleInputEmail1"  placeholder="Enter FTP Address"></div></div>
      <?php } ?>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Server Database</label>
      <select class="form-control required" name="server_type" id="server type">
          <option value="" >Choose Server Database</option>
          <option value="1" <?php if($tollplaza_live[0]['server_type'] == 1){echo "selected";};?>>Oracle</option>
          <option value="2" <?php if($tollplaza_live[0]['server_type'] == 2){echo "selected";};?>>IBM Informix</option>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Services</label>
      <input type="text" name="services" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Services" value="<?php echo $tollplaza_live[0]['services'];?>"/>
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Port</label>
      <input type="number" name="port" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Port Number" value="<?php echo $tollplaza_live[0]['port'];?>"/>
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Username</label>
      <input type="text" name="username" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Username" value="<?php echo $tollplaza_live[0]['username'];?>"/>
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Password</label>
      <input type="text" name="pwd" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Username" value="<?php echo $tollplaza_live[0]['password'];?>"/>
      
    </div>
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('update_live');">Update Tollplaza</span>
  
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
  
</script>

