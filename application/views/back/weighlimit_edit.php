<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/weighlimit/update/".$limit[0]['id'],array('id' => 'update_limit'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">No Of Axles</label>
     <select class="form-control required" name="cat" id="cat">
          <option value="">Choose Category</option>
          <?php foreach($category as $row){

            ?>
            <option value="<?php echo $row['id']?>" <?php if($limit[0]['cat_id'] == $row['id']){ echo 'selected';}?>><?php echo $row['name'];?></option>
          <?php } ?>
      </select>
      
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Weight Limit (TONS)</label>
      <input type="number" name="weighlimit" class="form-control required"  placeholder="Enter Weight Limit" value="<?php echo $limit[0]['weigh_limit']?>">
      
    </div>
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('update_limit');">Update Weight Limit</span>
  
<?php echo form_close();?>
</div>
</div>