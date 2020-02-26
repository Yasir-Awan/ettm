<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/weighstation/do_add",array('id' => 'add_weigh'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Weighstation Name</label>
      <input type="text" name="name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Weighstation name">
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Type</label>
      <select class="form-control required" name="type" id="type">
        <option value="">Choose Type</option>
        <option value="1">Local</option>
        <option value="2">FTP</option>
      </select>
    </div>
    <div id="dynamicInput2"></div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Software Type</label>
      <select class="form-control required" name="sofware_type" id="sofware_type">
        <option value="">Choose Software Type</option>
        <option value="0">Manual</option>
        <option value="1">DAW</option>
        <option value="2">JOD</option>
      </select>
    </div>
    
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

