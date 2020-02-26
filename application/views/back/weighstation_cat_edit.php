<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/weighstation_categories/update/".$weigh[0]['id'],array('id' => 'update_weigh'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Category Name</label>
      <input type="text" name="name" class="form-control required" id="exampleInputEmail1" value="<?php echo $weigh[0]['name'];?>"  placeholder="Enter Weighstation category name">
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Type</label>
      <select class="form-control required" name="axle" id="axle">
        <option value="">Choose Axle</option>
        <?php for($i = 2; $i<=6; $i++){?>
        <option value="<?php echo $i;?>" <?php if($i == $weigh[0]['axle']){echo "selected";}?> ><?php echo $i;?> Axle</option>
        <?php } ?>
      </select>
    </div>
   <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Category Code</label>
      <input type="text" name="code" class="form-control required" id="exampleInputEmail1" value = "<?php echo $weigh[0]['code'];?>"  placeholder="Enter Weighstation category code">
      
    </div>
    
    
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('update_weigh');">Update Category</span>
  
<?php echo form_close();?>
</div>
</div>
