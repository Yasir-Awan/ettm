
     <?php echo form_open_multipart(base_url().'toolplaza/traffic_counting/do_add', array('id' => 'traffic_counter', 'method' => 'post'));?>
                 <div class="row">
                    <div class="col-md-12 pr-1">

                      <div class="form-group" id="tp_check">
                        <label>Toll Plaza</label>
                       <Select class="form-control required" name="tollplaza" id="tollplaza">
                            <option value="">Choose Tollplaza</option>
                            <?php foreach($toolplaza as $tp){?>
                              <option value="<?php echo $tp['id']?>"><?php echo $tp['name']?></option>
                            <?php } ?>
                        </select> 
                      </div>

                    </div>
                    <div class="col-md-12 pr-1">

                      <div class="form-group" id="tp_check">
                        <label>Directions</label>
                        <Select class="form-control required" name="direction" id="direction">
                            <option value="">Choose directions</option>
                              <option value="N">North Bound</option>
                              <option value="S">South Bound</option>
                        </select> 
                      </div>

                    </div>
                    <div class="col-md-12 pr-1">

                      <div class="form-group">
                        <label>Video Date</label>
                        <input type="text" class="form-control required" id="datePicker" name="for_month" placeholder="Choose Month and Year" autocomplete="off"> 
                      </div>
                      
                    </div>
                    <div class="col-md-12 pr-1">

                      <div class="form-group">
                        <label>Video Time</label>
                        <input type="time" class="form-control required" id="timey" name="timey" placeholder="Choose Time" autocomplete="off" value="00:00:00" step="1"/> 
                      </div>
                      
                    </div>
                    <div class="col-md-12 pr-1">

                   <span class="btn btn-success btn-sm pull-right" onclick="form_submit('traffic_counter')">Start Session</span>
                      
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
            format: "dd/mm/yyyy",
            startDate: "01/01/2010",
              endDate: endYear,
            autoclose: true
         
          })
          
      

    });
 
    $('#mtr_type').change(function(){
      var tollplaza = $('#tollplaza').val();
      var errormsg = 'Please Choose Tollplaza First';
      
      if(tollplaza == ''){
          if($('#tp_check').find('.badge-danger').length){

      } else {
              $('#tp_check').append(''
                +'  <span id="check_month" class="badge badge-danger" >'
                +'      '+errormsg
                +'  </span>' );
      }
           $('#mtr_type').prop('selectedIndex',0);
      }else{
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
              
      var start_date = '<div class="form-group"><label>Start Date</label><input type="text" autocomplete="off" name="start_date" id="start_date" class="form-control required" placeholder="Enter Start Date"></div><div></div>';
      var end_date = '<div class="form-group"><label>End Date</label><input type="text" autocomplete="off" name="end_date" id="end_date" class="form-control required" placeholder="Enter End Date"></div>';
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
              data: {formonth: $('#datePicker').val(),tollplaza:$('#tollplaza').val()},
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
