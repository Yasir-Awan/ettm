<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/omc/update/".$omc[0]['id'],array('id' => 'edit_omc'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">OMC Name</label>
      <input type="text" name="omcname" class="form-control required" id="exampleInputEmail1" value="<?php echo $omc[0]['name']?>"  placeholder="Enter OMC name">
      
    </div>
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('edit_omc');">Update OMC</span>
  
<?php echo form_close();?>
</div>
</div>