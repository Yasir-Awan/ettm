
     <?php echo form_open_multipart(base_url().'toolplaza/mtr/do_update/'.$mtr[0]['id'], array('id' => 'edit_mtr', 'method' => 'post'));?>

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
                              <option value="<?php echo $val['id'];?>" <?php if($mtr[0]['omc']  == $val['id']){ echo "selected"; }?>><?php echo $val['name'];?></option>
                            <?php } ?>
                        </select> 
                      </div>
                      
                    </div>
                    <div class="col-md-6 pr-1">
                        <?php 
                          $date = explode('-', $mtr[0]['for_month']);
                          //$date = substr( $mtr[0]['for_month'], 0, strrpos( $mtr[0]['for_month'], '-' ) );
                          
                                    $month = $date[0].'/'.$date[1];
                        ?>
                      <div class="form-group">
                        <label>Month</label>
                        <input type="text" class="form-control required" id="datePicker" name="for_month" placeholder="Choose Month and Year" value="<?php echo $month;?>"> 
                      </div>
                      
                    </div>
                    <div class="col-md-6 pr-1" id="demo">

                      <div class="form-group">
                        <label>Mtr Type</label>
                        <Select class="form-control required" name="mtr_type" id="mtr_type">
                            <option value="">Choose Type</option>
                            <option value="1" <?php if($mtr[0]['type'] == 1){echo "selected";}?>>Standard(Complete Month)</option>
                            <option value="2" <?php if($mtr[0]['type'] == 2){echo "selected";}?>>Custom(For Specific Dates)</option>
                        </select> 
                      </div>
                      
                    </div>
                  <?php if($mtr[0]['type'] == 2){?>
                        <div class="col-md-6 pr-1 start_date">
                              <div class="form-group">
                                  <label>Start Date</label>
                                  <?php 
                                       
                                    $date = explode('-', $mtr[0]['for_month']);
                                    $start_date = $mtr[0]['start_date'].'/'.$date[1].'/'.$date[0];
                                    $end_date = $mtr[0]['end_date'].'/'.$date[1].'/'.$date[0];
                       
                                  ?>
                                  <input type="text" name="start_date" id="start_date" class="form-control required" placeholder="Enter Start Date" value="<?php echo $start_date;?>">
                              </div>
                          <div></div>
                        </div>
                  
                         <div class="col-md-6 pr-1 end_date">
                              <div class="form-group">
                                  <label>End Date</label>
                                  <input type="text" name="end_date" id="end_date" class="form-control required" placeholder="Enter End Date" value="<?php echo $end_date;?>">
                              </div>

                           <div></div>
                   

                        </div>
                        <script>
                        $(document).ready(function(){
                            var id = <?php echo $mtr[0]['id']?>;
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url()?>toolplaza/check_start_date',
                                data: {formonth: $('#datePicker').val(),tollplaza:$('#tollplaza').val(),mtr_id:<?php echo $mtr[0]['id']?>},
                                success: function(data)
                                {
                                  if(data == 'completed'){
                                      // notify('You have Complete Mtr for This Month','danger','top','right');
                                      //   $('#mtr_type').prop('selectedIndex',0);
                                      //   $('.start_date').hide('slow');
                                      //   $('.start_date').html('');
                                      //   $('.end_date').hide('slow');
                                      //   $('.end_date').html('');
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
                          });
                        </script>
                   <?php }else{?>
                    <div class="col-md-6 pr-1 start_date" style="display:none;">
                      
                    </div>
                  
                    <div class="col-md-6 pr-1 end_date" style="display:none;">
                      
                       <div></div>
                   

                    </div>
                    <?php } ?>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control required" value="<?php echo $mtr[0]['description'];?>" placeholder="Enter Description">
                      </div>
                      <div></div>
                    </div>
                   
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Notes</label>
                        <input type="text" name="notes" value="<?php echo $mtr[0]['notes'];?>" class="form-control required" placeholder="Enter Notes" value="No of Passages">
                      </div>
                    </div>
                  
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class1</label>
                        <input type="number" name="class1" id="class1" class="form-control classes required" placeholder="Enter class1 passages" min="0" value="<?php echo $mtr[0]['class1'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class2</label>
                        <input type="number" name="class2" id="class2" class="form-control classes required" placeholder="Enter class2 passages" min="0" value="<?php echo $mtr[0]['class2'];?>" >
                      </div>
                       <div></div>
                    </div>
                  
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class3</label>
                        <input type="number" name="class3" id="class3" class="form-control classes required" placeholder="Enter class3 passages" min="0" value="<?php echo $mtr[0]['class3'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class4</label>
                        <input type="number" name="class4" id="class4" class="form-control classes required" placeholder="Enter class4 passages" min="0" value="<?php echo $mtr[0]['class4'];?>">
                      </div>
                       <div></div>
                    </div>
                 
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class5</label>
                        <input type="number" name="class5" id="class5" class="form-control classes required" placeholder="Enter class5 passages" min="0" value="<?php echo $mtr[0]['class5'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class6</label>
                        <input type="number" name="class6" id="class6" class="form-control classes required" placeholder="Enter class6 passages" min="0" value="<?php echo $mtr[0]['class6'];?>">
                      </div>
                       <div></div>
                    </div>
                 
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class7</label>
                        <input type="number" name="class7" id="class7" class="form-control classes required" placeholder="Enter class7 passages" min="0" value="<?php echo $mtr[0]['class7'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class8</label>
                        <input type="number" name="class8" id="class8" class="form-control classes required" placeholder="Enter class8 passages" min="0" value="<?php echo $mtr[0]['class8'];?>">
                      </div>
                       <div></div>
                    </div>
                  
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class9</label>
                        <input type="number" name="class9" id="class9" class="form-control classes required" placeholder="Enter class9 passages" min="0" value="<?php echo $mtr[0]['class9'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class10</label>
                        <input type="number" name="class10" id="class10" class="form-control classes required" placeholder="Enter class10 passages" min="0" value="<?php echo $mtr[0]['class10'];?>">
                      </div>
                       <div></div>
                    </div>
                  
                    <div class="col-md-6 pr-1">

                      <div class="form-group">
                        <label>Total</label>
                        <input type="number" class="form-control" id="total" disabled="" placeholder="Total" value="<?php echo $mtr[0]['total'];?>">
                      </div>
                    </div>

                    <div class="col-md-4 pr-1 wrap-input-container">
                      <a href="<?php echo base_url()?>uploads/mtr/<?php echo $mtr[0]['file'];?>" class="btn btn-warning pull-right" target="__blank" style="padding: 1px 5px;font-size: 12px;
line-height: 1.5;border-radius: 3px;" id="viewfilebtn"><i class="fa fa-eye"></i>View File</a>
                      <label>Upload Signed File<span class="text-danger">* (Only Excel, PDF and Image is allowed)</span></label>
                      <input class="file-upload form-control" name="mtr_file" type="file"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ,application/pdf,image/*">
                   </div>
                    <div class="col-md-2 pr-1 wrap-input-container">
                   
                       <a href="javascript:void(0);" class="btn btn-sm btn-warning pull-right" title="Add Excempt" onclick="addexempt();" data-toggle="tooltip">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add Exempt
                      </a>
             
                   </div>
                    <div></div>
                  </div>

                  <div id="dynamicexempt">
                    <?php
                      $exempt = $this->db->get_where('exempt',array('mtr_id' => $mtr[0]['id']))->result_array();
                      if($exempt){
                    ?>
                  <div class="row dynamic_input_exempt">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Exempt Description</label>
                        <input type="text" name="excempt_desc" id="exempt_desc" class="form-control classes required" placeholder="Enter exempt Description" value="<?php echo $exempt[0]['description'];?>" >
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Exempt Notes</label>
                        <input type="text" name="exempt_notes" id="exempt_notes" class="form-control classes required" value="<?php echo $exempt[0]['notes'];?>" placeholder="Enter exempt notes">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class1 Exempt</label>
                        <input type="number" name="exempt1" id="exempt1" class="form-control classes required" placeholder="Enter class1 exempt" min="0" value="<?php echo $exempt[0]['class1'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class2 Exempt</label>
                        <input type="number" name="exempt2" id="exempt2" class="form-control classes required" placeholder="Enter class2 exempt" min="0" value="<?php echo $exempt[0]['class2'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class3 Exempt</label>
                        <input type="number" name="exempt3" id="exempt3" class="form-control classes required" placeholder="Enter class3 exempt" min="0" value="<?php echo $exempt[0]['class3'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class4 Exempt</label>
                        <input type="number" name="exempt4" id="exempt4" class="form-control classes required" placeholder="Enter class4 exempt" min="0" value="<?php echo $exempt[0]['class4'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class5 Exempt</label>
                        <input type="number" name="exempt5" id="exempt5" class="form-control classes required" placeholder="Enter class5 exempt" min="0" value="<?php echo $exempt[0]['class5'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class6 Exempt</label>
                        <input type="number" name="exempt6" id="exempt6" class="form-control classes required" placeholder="Enter class6 exempt" min="0" value="<?php echo $exempt[0]['class6'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class7 Exempt</label>
                        <input type="number" name="exempt7" id="exempt7" class="form-control classes required" placeholder="Enter class7 exempt" min="0" value="<?php echo $exempt[0]['class7'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class8 Exempt</label>
                        <input type="number" name="exempt8" id="exempt8" class="form-control classes required" placeholder="Enter class8 exempt" min="0" value="<?php echo $exempt[0]['class8'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class9 Exempt</label>
                        <input type="number" name="exempt9" id="exempt9" class="form-control classes required" placeholder="Enter class9 exempt" min="0" value="<?php echo $exempt[0]['class9'];?>">
                      </div>
                       <div></div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Class10 Exempt</label>
                        <input type="number" name="exempt10" id="exempt10" class="form-control classes required" placeholder="Enter class10 exempt" min="0" value="<?php echo $exempt[0]['class10'];?>">
                      </div>
                       <div></div>

                    </div>
                    <div class="col-md-12 pr-1 wrap-input-container"><a href="javascript:void(0);" class="btn btn-sm btn-danger pull-right" title="Remove Exempt" onclick="remove_exempt();" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i> Remove Exempt</a></div>
                 </div>
                    <?php } ?>
                  </div>
                  <?php 
                        $support = $this->db->get_where('supporting_document',array('mtr_id' => $mtr[0]['id']))->result_array();
                        if($support){
                  ?>
                  <div class="row" id="supporting_file_list">
                      <div class="col-md-12">
                          <table class="table">
                            <tbody>
                              <?php 
                                foreach ($support as  $sprt) {
                                
                                
                              ?>
                              <tr>
                                <td>
                                  <a href="<?php echo base_url()?>uploads/supporting/<?php echo $sprt['path'];?>" target="_blank"><?php echo $sprt['name']?></a>
                                </td>
                                <td>
                                  <a href="#" class="btn btn-danger btn-xs" onclick="delete_con('<?php echo base_url(); ?>toolplaza/delete_suppporting/<?php echo $mtr[0]['id']; ?>/<?php echo $sprt['id']; ?>/')"><i class="fa fa-trash" ></i></a>
                                </td>
                              </tr>
                              <?php 
                                }
                              ?>
                            </tbody>
                          </table>
                      </div>
                  </div>
                  <?php } ?>
                  <div class="row">
                   <div class="col-md-6 pr-1">
                     <div class="form-group">
                        <label>Supporting document name <span class="text-info">(Optional)</optional</label>
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
                  <input type="hidden" name="theValue11" id="theValue11" value="0"/>
                  <input type="hidden" name="theValue222" id="theValue222" value="0"/>
                  <div class="row">
                   
                      <input type="hidden" name="add_exempt" id="add_exempt" value="<?php if($exempt){echo "1";}else{echo "0";}?>">
                    <div class="col-md-12 pr-1 wrap-input-container">
                      <span class="btn btn-info btn-block pull-right" onclick="form_submit('edit_mtr');">Update</span>
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
            startDate: "2010/01",
            autoclose: true,
            endDate: endYear,
            startView: "months",
            minViewMode: "months",
            maxViewMode: "years"
          })

          
      

    });
 
    $('#mtr_type').change(function(){
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
                $('#mtr_type').prop('selectedIndex',0);
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
              data: {formonth: $('#datePicker').val(), mtr_id:<?php echo $mtr[0]['id']?>},
              success: function(data)
              {
                if(data == 'completed'){
                    notify('You have Complete Mtr for This Month','danger','top','right');
                      $('#mtr_type').prop('selectedIndex',0);
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
        $('#mtr_type').prop('selectedIndex',0);
        $('.start_date').hide('slow');
        $('.start_date').html('');
        $('.end_date').hide('slow');
        $('.end_date').html('');
    });
</script> 
