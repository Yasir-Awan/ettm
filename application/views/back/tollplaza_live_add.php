<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/tollplaza_live/do_add",array('id' => 'add_live'));?>
    
     <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Tollplaza</label>
      <select class="form-control required" name="tollplaza" id="tollplaza">
        <option value="">Choose Tollplaza</option>
        <?php foreach($tollplaza as $row){?>
        <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
        <?php } ?>
      </select>
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
      <label for="exampleInputEmail1" style="font-weight: 900;">Server Database</label>
      <select class="form-control required" name="server_type" id="server type">
          <option value="">Choose Server Database</option>
          <option value="1">Oracle</option>
          <option value="2">IBM Informix</option>
      </select>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Services</label>
      <input type="text" name="services" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Services"/>
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Port</label>
      <input type="number" name="port" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Port Number"/>
      
    </div>
     <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Username</label>
      <input type="text" name="username" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Username"/>
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Password</label>
      <input type="text" name="pwd" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Username"/>
      
    </div>
    
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('add_live');">Add Tollplaza</span>
  
<?php echo form_close();?>
</div>
</div>
<script>
  $('body').on('change','#type',function(){
    if(this.value == 1){
        var ni = document.getElementById('dynamicInput2');
        var newdiv = document.createElement('div');
        
        ni.innerHTML = '<div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">Server IP Address</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend">\\\\</span></div><input type="text" name="ip_address" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Server IP Address"></div></div>';
        //ni.appendChild(newdiv);
    }else if(this.value == 2){
        
        var ni = document.getElementById('dynamicInput2');
        var newdiv = document.createElement('div');
        ni.innerHTML = '<div class="form-group"><label for="exampleInputEmail1" style="font-weight: 900;">Server FTP Address</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend">ftp://</span></div><input type="text" name="ftp_address" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Server FTP Address"></div></div>';
    }
  });
  
</script>

