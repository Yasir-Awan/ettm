<?php echo form_open(base_url()."inventory/action_on_asset/retire_do/",array('id' => 'retire'));?>
          
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
                    <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Retire Type</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4' >
                    <select class="form-control required" name="retire_type" id="retire_type" placeholder="">
                    <option value="1">Damaged</option>
                    <option value="2">Lost</option>
                    <option value="3">Gifted</option>
                    <option value="4">Expired</option>
                    <option value="5">Consumed</option>
                    </select>
                    </div>
                   </div>
            </div>
           <br>
           <div class="form-group">
                <div class="row">
                <div class='col-md-4'>  
                  <label for="example-date-input" class="col-form-label">Retire Date</label>
                </div>
                <div class='col-md-4'>
                <input type="text" class="form-control required" id="retire_date" name="retire_date" placeholder="retire Date">
                </div>
                <div class='col-md-3'>
                  <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                </div>
                </div>
              </div>

          <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Reason</label>
             </div>
             <div class="col-md-8">
             <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="retire_reason" id="retire_reason"></textarea>
             </div>
          </div>       

          <div class="form-group">
          <div class='row'>
            <input class="form-control" value="<?php echo implode(",",$retiring_assets);?>" 
               type="hidden" name="asset_id" id="asset_id">
          </div>
       </div>
           <br>
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('retire')">Retire</button>
          <?php echo form_close();?>

<script>
        $(document).ready(function(){
          var endYear = new Date(new Date().getFullYear(), 11, 31);
          $("#retire_date").datepicker({
            format: "yyyy-mm-dd",
            startDate: "2010-01-01",
            autoclose: true,
            endDate: endYear            
          })
        });
</script>