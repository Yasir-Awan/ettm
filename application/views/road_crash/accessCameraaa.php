<?php include('includes/header.php');?>
<?php echo form_open(base_url()."road_crash/crash_data/",array('id' => 'crashdata_form'));?>
                   <!-- Form Textual inputs start -->

                   <form class="md-form" action="#">
  <div class="file-field">
    <div class="btn btn-primary btn-sm float-left">
      <span>Choose files</span>
      <input type="file" multiple accept="image/*" capture="camera">
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload one or more files">
    </div>
  </div>
</form>
           
        <button type="button" class="btn btn-primary pull-right  mb-3" onclick="form_submit('crashdata_form');">Create Asset</button>
          <?php echo form_close();?>
          <?php include('includes/footer.php');?>



       