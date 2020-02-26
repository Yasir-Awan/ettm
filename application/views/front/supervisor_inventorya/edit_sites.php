<?php echo form_open(base_url()."supervisor_inventory/edit_site_do/".$site[0]['id'],array('id' => 'edit_sites'));?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Name</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control" value='<?php echo $site[0]['name']?>' 
               type="text" name="site-name" id="site-name">
             </div>
          </div>
          <br>
        
        </div>
           <br>
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('edit_sites');">Update Site</button>
          <?php echo form_close();?>