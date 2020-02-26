<?php echo form_open(base_url()."supervisor_inventory/add_site_do/",array('id' => 'add_sites'));?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">SITE NAME</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control" value="Head Quarter" 
               type="text" name="site_name" id="site_name">
             </div>
          </div>
          <br>
        
           <br>
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('add_sites');">Add SITE</button>
          <?php echo form_close();?>