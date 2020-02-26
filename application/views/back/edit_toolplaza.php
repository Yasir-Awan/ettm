<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/edit_plaza_do/".$toolplza[0]['id'],array('id' => 'edit_toolplaza'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Toll Plaza Name</label>
      <input type="text" name="toolplazaname"  value= '<?php echo $toolplza[0]['name']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter toll plaza name">
      
    </div>
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('edit_toolplaza');">Update Toll Plaza</span>
  
<?php echo form_close();?>
</div>
</div>