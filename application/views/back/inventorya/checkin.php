<?php echo form_open(base_url()."inventory/action_on_asset/checkin_do/",array('id' => 'checkin'));?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Asset Name</label>
             </div>
             <div class="col-md-8">
              <span required="" style="margin-left:-45px;" class="form-control" value="" 
               type="" name="asset_name" id="asset_name"><?php 
             foreach($data as $row) 
             {  echo $row[0]['name'].", "; } ?></span>
             </div>
          </div>
          <br>
          <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Custody Of</label>
             </div>
             <div class="col-md-8">
              <span required="required" style="margin-left:-45px;" class="form-control" value="" 
               type="text" name="custdy_of" id="custody_of">
               <?php 
             foreach($data1 as $row) 
             {  echo $row[0]['checkout_to'].", "; } ?>
               </span>
             </div>
          </div>
          <br>
          <div class="form-group">
             <div class='row'>
                <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Site</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-5' >
                <select class="form-control required" name="site_id" id="site_id" placeholder="Select Asset Name" >
                <?php foreach($sites as $site){?>
                    <option value="<?php echo $site['id'] ?>"><?php echo $site['name'];?></option>
                    <?php } ?> 
                </select>
                </div>
              </div>
            </div>
          <br>
          <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Comments</label>
             </div>
             <div class="col-md-8">
             <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="checkin_comments" id="checkin_comments"></textarea>
             </div>
          </div>
           <br>
           <div class="form-group">
          <div class='row'>
          <input class="form-control" value="<?php echo implode(",",$checkins);?>" 
               type="hidden" name="asset_id" id="asset_id">
         
          </div>

        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('checkin');">Check In</button>
          <?php echo form_close();?>