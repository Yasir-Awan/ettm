
     <?php echo form_open_multipart(base_url().'toolplaza/dtr/do_add', array('id' => 'add_dtr', 'method' => 'post'));?>
                 <div class="row">
                    <div class="col-md-6 pr-1">

                      <div class="form-group">
                        <label>Toll Plaza</label>
                        <input type="text" class="form-control" disabled="" placeholder="Tollplaza" value="<?php echo $toolplaza; ?>">
                      </div>

                    </div>
                    <div class="col-md-6 pr-1">

                      <div class="form-group">
                        <label>OMC</label>
                        <Select class="form-control required" name="omc" id="omc">
                            <option value="">Choose OMC</option>
                            <?php foreach($omc as $val){?>
                              <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                            <?php } ?>
                        </select> 
                      </div>
                      
                    </div>
                    <div class="col-md-6 pr-1">

                      <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control required" id="" name="for_date" placeholder="Choose Date"> 
                      </div>
                      
                    </div>
                   
                  
                   
                   
                      <div class="col-md-6 pr-1 start_date" style="display:none;">
                      
                    </div>
                  
                    <div class="col-md-6 pr-1 end_date" style="display:none;">
                      
                       <div></div>
                   

                    </div>
                       <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control required" placeholder="Enter Description" value="TRAFFIC">
                      </div>
                      <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Notes</label>
                        <input type="text" name="notes" class="form-control required" placeholder="Enter Notes" value="No of Passages">
                      </div>
                    </div>
                  
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class1</label>
                        <input type="number" name="class1" id="class1" class="form-control classes required" placeholder="Enter class1 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class2</label>
                        <input type="number" name="class2" id="class2" class="form-control classes required" placeholder="Enter class2 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                  
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class3</label>
                        <input type="number" name="class3" id="class3" class="form-control classes required" placeholder="Enter class3 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class4</label>
                        <input type="number" name="class4" id="class4" class="form-control classes required" placeholder="Enter class4 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                 
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class5</label>
                        <input type="number" name="class5" id="class5" class="form-control classes required" placeholder="Enter class5 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class6</label>
                        <input type="number" name="class6" id="class6" class="form-control classes required" placeholder="Enter class6 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                 
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class7</label>
                        <input type="number" name="class7" id="class7" class="form-control classes required" placeholder="Enter class7 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class8</label>
                        <input type="number" name="class8" id="class8" class="form-control classes required" placeholder="Enter class8 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                  
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class9</label>
                        <input type="number" name="class9" id="class9" class="form-control classes required" placeholder="Enter class9 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class10</label>
                        <input type="number" name="class10" id="class10" class="form-control classes required" placeholder="Enter class10 passages" min="0">
                      </div>
                       <div></div>
                    </div>
                  
                    <div class="col-md-6 pr-1">

                      <div class="form-group">
                        <label>Total</label>
                        <input type="number" class="form-control" id="total" disabled="" placeholder="Total" value="">
                      </div>
                    </div>

                    <div class="col-md-4 pr-1 wrap-input-container">
                      <label>Upload Signed File<span class="text-danger">* (Only PDF and Image is allowed)</span></label>
                      <input class="file-upload form-control required" name="dtr_file" type="file"  accept="application/pdf,image/*">
                   </div>
                    <div class="col-md-2 pr-1 wrap-input-container">
                   
                       <a href="javascript:void(0);" class="btn btn-sm btn-warning pull-right" title="Add Excempt" onclick="addexempt();" data-toggle="tooltip">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add Exempt
                      </a>
             
                   </div>
                    <div></div>

                 </div>
                 <div id="dynamicexempt"></div>
                 
                 <div class="row">

                   <div class="col-md-6 pr-1">
                     <div class="form-group">
                        <label>Supporting document name <span class="text-info">(Optional)</optional></label>
                         <input type="text" name="suppporting_document_name[]" id="supporting_0" class="form-control classes" placeholder="Enter File Name" min="0">
                      </div>
                      
                    </div>
                    <div class="col-md-4 pr-1 wrap-input-container">

                        <label>Supporting  File(<span class="text-info">Optional &nbsp;Only PDF,Excel and Image is allowed</span>)</label>
                        <input class="file-upload form-control" name="supporting_file[]" type="file"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ,application/pdf,image/*">                      
                      
                    </div>
                    <div class="col-md-2 pr-1 wrap-input-container">
                   
                       <a href="javascript:void(0);" class="btn btn-sm btn-info pull-right" title="Add More File" onclick="addFormulaProcedures();" data-toggle="tooltip">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add More File
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
                      <span class="btn btn-info btn-block pull-right" onclick="form_submit('add_dtr');">Add</span>
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
            format: "yyyy/mm",
            startDate: "2015/01",
            autoclose: true,
            endDate: endYear,
            startView: "months",
            minViewMode: "months",
            maxViewMode: "years"
          })
          
      

    });
 
    $('#dtr_type').change(function(){
      var check = $('#datePicker');
      if(check.val() == ''){
        var txt = 'Please Choose Month First';
        if(check.closest('div').find('#check_month').length){

        }else{

            check.closest('div').append(''
                +'  <span id="check_month" class="badge badge-danger" >'
                +'      '+txt
                +'  </span>' );
        }
                $('#dtr_type').prop('selectedIndex',0);
                $('.start_date').hide('slow');
                $('.start_date').html('');
                $('.end_date').hide('slow');
                $('.end_date').html('');
        return false;
        
      }
      var today = new Date();
              
      var start_date = '<div class="form-group"><label>Start Date</label><input type="text" name="start_date" id="start_date" class="form-control required" placeholder="Enter Start Date"></div><div></div>';
      var end_date = '<div class="form-group"><label>End Date</label><input type="text" name="end_date" id="end_date" class="form-control required" placeholder="Enter End Date"></div>';
      if(this.value == 1){
        $('.start_date').hide('slow');
        $('.start_date').html('');
        $('.end_date').hide('slow');
        $('.end_date').html('');
      }else{
        $('.start_date').html(start_date);
        $('.start_date').show('slow');
        $('.end_date').html(end_date);
        $('.end_date').show('slow');
        $.ajax({
              type: 'POST',
              url: '<?php echo base_url()?>toolplaza/check_start_date',
              data: {formonth: $('#datePicker').val()},
              success: function(data)
              {
                if(data == 'completed'){
                    notify('You have Complete dtr for This Month','danger','top','right');
                      $('#dtr_type').prop('selectedIndex',0);
                      $('.start_date').hide('slow');
                      $('.start_date').html('');
                      $('.end_date').hide('slow');
                      $('.end_date').html('');
                }else{
                    var fields = data.split('_');
                    var datea = fields[0].split('-');
                    // var now = new Date();
                    // alert(now.getMonth()); return false;
                    var startDate = new Date(datea[0], datea[1]-1, fields[1]);
                    var endDate1   = new Date(datea[0], datea[1]-1, fields[1]);
                    var mont_last = new Date(datea[0], datea[1], 0).getDate();
                    var end_start = new Date(datea[0],datea[1]-1,fields[1]);
                    var actual = mont_last - fields[1];
                    var end_end = new Date(datea[0],datea[1]-1,mont_last);
                      $("#start_date").datepicker({
                        format: "dd/mm/yyyy",
                        //minViewMode: 1,
                        autoclose: true,
                        startDate: startDate,
                        endDate: endDate1
                      });
                      $("#end_date").datepicker({
                        format: "dd/mm/yyyy",
                        //minViewMode: 1,
                        autoclose: true,
                        startDate: end_start,
                        endDate: end_end
                      });
                }
                
                  
              }
            });
        
        
      }
    });   
    $('#datePicker').on('changeDate', function(ev){
        $('#dtr_type').prop('selectedIndex',0);
        $('.start_date').hide('slow');
        $('.start_date').html('');
        $('.end_date').hide('slow');
        $('.end_date').html('');
    });
</script> 
