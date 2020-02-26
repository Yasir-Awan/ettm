<?php echo form_open(base_url()."supervisor_inventory/add_tsps_do/",array('id' => 'add_tsps'));?>
         <!-- Form Textual inputs start -->
       <div class="col-12 mt-0">
         <div class="card">
           <div class="card-body">
                <fieldset style="margin-top: -35px;">
              <legend>Core Information<hr></legend>                        
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Name</label>
                    <span  data-original-title="" title="">*</span>
                    </div>
                    <div class="col-md-4">
                    <input class="form-control required" 
                     placeholder="Enter TSP Name"
                    type="text" name="name" id="name">
                    </div>
                   </div>
                </div>
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-4'>
                    <label for="example-search-input"  class="col-form-label" data-original-title="" title="">Contract Name</label>
                    <span  data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <input type="text"  style="margin-left: -61px !important;" 
                    placeholder="Enter Contract Name" id="contract_name" name="contract_name" 
                    class="form-control required">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-4'>
                    <label for="example-search-input"  class="col-form-label" data-original-title="" title="">Employee Name</label>
                    <span  data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <input type="text" style="margin-left: -61px !important;" 
                     placeholder="Enter employee Name" id="employee_name" 
                     name="employee_name" class="form-control required">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-4'>
                    <label for="example-search-input"  class="col-form-label" data-original-title="" title="">Employee Contact</label>
                    <span  data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <input type="number"  style="margin-left: -61px !important;" 
                    placeholder="Enter employee contact" id="employee_contact" name="employee_contact" 
                    class="form-control required">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class='row'>
                    <div class='col-md-4'>
                    <label for="example-search-input"  class="col-form-label" data-original-title="" title="">TSP HQ Address</label>
                    <span  data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <input type="text"  style="margin-left: -61px !important;" 
                    placeholder="Enter address of TSP" id="tsp_address" name="tsp_address" 
                    class="form-control required">
                    </div>
                  </div>
                </div>
                  &nbsp
                  &nbsp
              <legend>Extended Information <hr></legend>                              
              <br>
                   <div class="form-group">
                  <div class='row'>
                    <div class='col-md-5'>
                    <label for="example-search-input"  class="col-form-label" data-original-title="" title="">Employee Designation</label>
                    </div>
                    <div class='col-md-4'>
                    <input type="text" style="margin-left: -61px !important;" 
                     placeholder="Enter employee Designation" id="employee_designation" 
                     name="employee_designation" class="form-control ">
                    </div>
                    <div class='col-md-2'>

                    </div>
                  </div>
                </div>
                  <div class="form-group">
                      <div class="row">
                         <div class='col-md-4'>  
                         <label for="example-date-input" class="col-form-label">Contract Commencement Date</label>
                         </div>
                         <div class='col-md-4'>
                         <input class="form-control" type="date" name='commencement_date' value="2018-03-05" id="example-date-input">
                         </div>
                         <div class='col-md-2'>
                         <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                         </div>
                       </div>
                     </div>
                     <div class="form-group">
                      <div class="row">
                         <div class='col-md-4'>  
                         <label for="example-date-input" class="col-form-label">Contract Expiry Date</label>
                         </div>
                         <div class='col-md-4'>
                         <input class="form-control" type="date" name="expiry_date" value="2018-03-05" id="example-date-input">
                         </div>
                         <div class='col-md-2'>
                         <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                         </div>
                       </div>
                     </div>
                                       
              <legend>Custom Fields <hr></legend> 
                <div class="form-group has-primary">
                  <div> No custom fields exist for this group. <a data-remote="true" 
                    href="/custom_attributes/new?asset=new&amp;group_id=117563&amp;type=FixedAsset"
                    data-original-title="" title="">Click here</a> to add custom fields. </div>
                  </div>
                 </div>
               </div>
               </div>
             </fieldset> <!--Form Textual inputs END -->
            </div><!-- Card body End -->
        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('add_tsps');">Add TSP</button>
          <?php echo form_close();?>