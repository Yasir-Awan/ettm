<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/weighlimit/do_add",array('id' => 'add_limit'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">No Of Axles</label>
      <select class="form-control required" name="cat" id="cat">
          <option value="">Choose Category</option>
          <?php foreach($category as $row){
            ?>
            <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
          <?php } ?>
      </select>
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Weight Limit (TONS)</label>
      <input type="number" name="weighlimit" class="form-control required"  placeholder="Enter Weight Limit">
      
    </div>
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('add_limit');">Add Weight Limit</span>
  
<?php echo form_close();?>
</div>
</div>