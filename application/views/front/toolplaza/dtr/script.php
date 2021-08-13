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