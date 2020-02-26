<?php echo form_open_multipart(base_url().'toolplaza/faulty_equipment_list/do_add', array('id' => 'add_faulty', 'method' => 'post'));?>
                 <div class="row">
                    <div class="col-md-12 pr-1">

                      <div class="form-group">
                        <label>Toll Plaza</label>
                        <input type="text" class="form-control" disabled="" placeholder="Tollplaza" value="<?php echo $toolplaza; ?>">
                      </div>

                    </div>
                  
                    <div class="col-md-6 pr-1">

                      <div class="form-group">
                        <label>Location</label>
                        <select class="form-control required" name="location_0" id="location">
                            <option value="">Choose Location</option>
                            <?php foreach($location as $row){?>
                              <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
                            <?php } ?>
                        </select>
                      </div>
                      
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Equipment Name</label>
                        <input type="text" name="equip_name_0" id="equip_name_0" class="form-control required" placeholder="Equipment Name">
                      </div>
                       <div></div>
                    </div>
                  
                    
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity_0" id="quantity_0" class="form-control classes required" placeholder="Enter Quantity" min="1">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price_0" id="price_0" class="form-control classes required" placeholder="Enter Price" min="0">
                      </div>
                       <div></div>
                    </div>
                      
                  
                    
                    <div class="col-md-6 pr-1 wrap-input-container">
                       <input type="hidden" id="question_no"  value="0" class="question_no" name="questions[]"> 
                    </div>
                   
                   <div class="col-md-6 pr-1 wrap-input-container">
                   
                       <a href="javascript:void(0);" class="btn btn-sm btn-primary pull-right" title="Add More Materials" onclick="addFormulaProcedures();" data-toggle="tooltip">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add Another Faulty
                      </a>
             
                   </div>
                 </div>
                 <hr>
                 <div id="dynamicInput2"></div>
                    <div class="clearfix"></div>
                 <input type="hidden" name="theValue" id="theValue" value="0"/>
                 <input type="hidden" name="theValue2" id="theValue2" value="0"/>
                <input type="hidden" name="theValue11" id="theValue11" value="0"/>
                <input type="hidden" name="theValue222" id="theValue222" value="0"/>
                  <div class="row">
                     <div class="col-md-6 pr-1 wrap-input-container">
                      <label>Upload File<span class="text-danger">* (Only Excel, PDF and Image is allowed)</span></label>
                      <input class="file-upload form-control required" name="faulty_file" type="file"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ,application/pdf,image/*">

                   </div>
                   <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>OMC</label>
                        <input type="text" name="omc" id="omc" class="form-control required" placeholder="Enter OMC">
                      </div>
                       <div></div>
                    </div>
                  </div>
                <div class="row">
                   

                    <div class="col-md-12 pr-1 wrap-input-container">
                      <span class="btn btn-info btn-block pull-right" onclick="form_submit('add_faulty');">Add</span>
                  </div>
                
                <?php echo form_close();?>
