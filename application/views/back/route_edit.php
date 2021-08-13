<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/routes/do_update/".$route[0]['id'],array('id' => 'update_route'));?>
    
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Route Name</label>
      <input type="text" name="title" class="form-control required" id="exampleInputEmail1" value="<?php echo $route[0]['name']?>"  placeholder="Enter Route Name"/>
    </div>   
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('update_route');">Update Route</span>
  
<?php echo form_close();?>
</div>
</div>

