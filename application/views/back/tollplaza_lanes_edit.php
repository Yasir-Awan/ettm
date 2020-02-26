<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/tollplaza_lanes/do_update/".$lane[0]['id'],array('id' => 'update_lane'));?>
    
     <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Tollplaza</label>
      <select class="form-control required" name="tollplaza" id="tollplaza">
        <option value="">Choose Tollplaza</option>
        <?php foreach($tollplaza as $row){?>
        <option value="<?php echo $row['id']?>" <?php if($lane[0]['toll_plaza'] == $row['id']){echo "selected";}?>><?php echo $row['name'];?></option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Lane Name</label>
      <input type="text" name="name" class="form-control required" id="exampleInputEmail1" value="<?php echo $lane[0]['name']; ?>"  placeholder="Enter Lane name">
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Type</label>
      <select class="form-control required" name="type" id="type">
        <option value="">Choose Type</option>
        <option value="1" <?php if($lane[0]['type'] == 1){ echo "selected";}?>>Local</option>
        <option value="2" <?php if($lane[0]['type'] == 2){ echo "selected";}?>>FTP</option>
      </select>
    </div>
    <div id="dynamicInput2">
      <?php if($lane[0]['type'] == 1){?>
      <div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">IP Address</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend">\\\\</span></div><input type="text" name="ip_address" class="form-control required" value="<?php echo $lane[0]['ipaddress'];?>" id="exampleInputEmail1"  placeholder="Enter IP Address"></div></div>
      <?php }else{?>
      <div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">FTP Address</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend">ftp://</span></div><input type="text" name="ftp_address" class="form-control required" value="<?php echo $lane[0]['ipaddress'];?>" id="exampleInputEmail1"  placeholder="Enter FTP Address"></div></div>
      <?php } ?>
    </div>
   
    
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('update_lane');">Update Lane</span>
  
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
  // $('body').on('change','#sofware_type',function(){
  //   if(this.value == 1){
  //       var ni = document.getElementById('dynamicInput3');
  //       var newdiv = document.createElement('div');
        
  //       ni.innerHTML = '';
  //       //ni.appendChild(newdiv);
  //   }else if(this.value == 2){
        
  //       var ni = document.getElementById('dynamicInput3');
  //       var newdiv = document.createElement('div');
  //       ni.innerHTML = '<div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">File file index</label><input type="text" name="file_index" class="form-control required" id="exampleInputEmail1"  placeholder="Enter first file name(File Index)"></div>';
  //   }
  // });
</script>

