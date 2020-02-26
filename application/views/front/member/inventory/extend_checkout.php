<?php echo form_open(base_url()."inventory/extendcheckout_do/",array('id' => 'extend_checkout'));?>
         <div class="form-group">
                      <div class="row">
                         <div class='col-md-3'>  
                         <label for="example-date-input" class="col-form-label">Return Date</label>
                         </div>
                         <div class='col-md-5'>
                         <span class="form-control" type="date" name='extend_return_date' value="2018-03-05" id="example-date-input"></span>
                         </div>
                        
                       </div>
                     </div>

                     <div class="form-group">
                      <div class="row">
                         <div class='col-md-3'>  
                         <label for="example-date-input" class="col-form-label">Extend Date</label>
                         </div>
                         <div class='col-md-5'>
                         <input class="form-control" type="date" name='extend_return_date' value="2018-03-05" id="example-date-input">
                         </div>
                         <div class='col-md-3'>
                         <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                         </div>
                       </div>
                     </div>

           <br>
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('extend_checkout');">Extend Checkout</button>
          <?php echo form_close();?>