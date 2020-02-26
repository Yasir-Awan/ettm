<div class="row">
  <div class="col-md-12">
     <?php echo form_open(base_url()."admin/add_plaza_do/",array('id' => 'add_toolplaza'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Toll Plaza Name</label>
      <input type="text" name="toolplazaname" class="form-control required" id="exampleInputEmail1"  placeholder="Enter toll plaza name">
      
    </div>
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('add_toolplaza');"> Add Toll Plaza</span>
  
<?php echo form_close();?>
</div>
</div>