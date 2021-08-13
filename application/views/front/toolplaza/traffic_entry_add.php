
     <?php echo form_open_multipart(base_url().'toolplaza/Traffic_Entry/do_add', array('id' => 'add_traffic_entry', 'method' => 'post'));?>
                 <div class="row">
                    <div class="col-md-6 pr-1">

                      <div class="form-group">
                        <label>Toll Plaza</label>
                        <input type="text" class="form-control" disabled="" placeholder="Tollplaza" value="<?php echo $toolplaza[0]['name']; ?>">
                      </div>

                    </div>
                    <div class="col-md-6 pr-1">

                      <div class="form-group">
                        <label>Bound</label>
                        <Select class="form-control required" name="bound" id="bound">
                            <option value="">Choose Bound</option>
                            <option value="1">North</option>
                            <option value="2">South</option>
                        </select> 
                      </div>
                      
                    </div>
                    <div class="col-md-12 pr-1">
                      <div class="form-group">
                        <label>Date</label>
                        <input type="text" class="form-control required" id="datePicker" name="date" placeholder="Choose Date"> 
                      </div>
                    </div>

                    <div class="col-md-6 pr-1" >
                      <div class="form-group">
                        <label>Hour 1 Start</label>
                        <input type="time" class="form-control required" id="starth1" name="h1start" >
                      </div>
                    </div>

                    <div class="col-md-6 pr-1" >
                      <div class="form-group">
                      <label>Hour 1 End</label>
                        <input type="time" class="form-control required" id="endh1" name="h1end" >
                      </div>
                    </div>
                  
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class1</label>
                        <input type="number" name="t1class1" id="class1" class="form-control classes required" placeholder="Enter class1 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class2</label>
                        <input type="number" name="t1class2" id="class2" class="form-control classes required" placeholder="Enter class2 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                  
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class3</label>
                        <input type="number" name="t1class3" id="class3" class="form-control classes required" placeholder="Enter class3 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class4</label>
                        <input type="number" name="t1class4" id="class4" class="form-control classes required" placeholder="Enter class4 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                 
                    <div class="col-md-12 pr-1">
                      <div class="form-group">
                        <label>Class5</label>
                        <input type="number" name="t1class5" id="class5" class="form-control classes required" placeholder="Enter class5 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                  
                    <!-- <div class="col-md-6 pr-1">

                      <div class="form-group">
                        <label>Total</label>
                        <input type="number" class="form-control" id="total" disabled="" placeholder="Total" value="">
                      </div>
                    </div> -->
                 </div>

                 <div id="dynamicexempt"></div>
                 
                 <div class="row">
                    <div class="col-md-12 pr-1 wrap-input-container">
                       <a href="javascript:void(0);" class="btn btn-sm btn-info pull-right" onclick="addHourProcedures();" data-toggle="tooltip">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add More Hour
                      </a>
                   </div>
                 </div>
                 <div id="dynamicInput2"></div>
                <div class="clearfix"></div>
                 <input type="hidden" name="theValue" id="theValue" value="0"/>
                 <input type="hidden" name="theValue2" id="theValue2" value="0"/>
                <!-- <input type="hidden" name="theValue11" id="theValue11" value="0"/>
                <input type="hidden" name="theValue222" id="theValue222" value="0"/> -->
                 <div class="row">
                    <input type="hidden" name="add_exempt" id="add_exempt" value="0">
                    <div class="col-md-12 pr-1 wrap-input-container">
                      <span class="btn btn-info btn-block pull-right" onclick="form_submit('add_traffic_entry');">Add</span>
                  </div>
                  </div>
                <?php echo form_close();?> 
    
    <script>
    $('input.classes').on('keyup keydown change',function() {   
        var total = 0;
        $('input.classes').each(function(){
            if (this.value == ''){
                total += parseInt(0);
            }else{
                total += parseInt(this.value);
            }
        });
        $('#total').val(total);


    });
    $(document).ready(function(){
          var endYear = new Date(new Date().getFullYear(), 11, 31);
          $("#datePicker").datepicker({
            format: "yyyy/mm/dd",
            startDate: "2010/01/01",
            autoclose: true,
            endDate: endYear,
            startView: "days",
            minViewMode: "days",
            maxViewMode: "years"
          })
    });

</script> 
