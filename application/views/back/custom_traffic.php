 
  <?php include('includes/header.php'); ?>
            
            <div class="main-content-inner">
                <div class="row">
                    
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h4 class="header-title">Custom Traffic Reports</h4>
                                    </div>
                                    <div class="col-md-9">
                                        <form method="post" action="<?php echo base_url().'admin/traffic_report_custom/search_data';?>" id="search_custom">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <div>
                                                        <select class="form-control required" name="toll_plaza" id="toll_plaza">
                                                            <option value="">Choose Plaza</option>
                                                            <?php foreach($tollplaza as $row){?>
                                                            <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div></div>
                                                </td>
                                                <td>
                                                    <div>
                                                         <input type="text" id="day" name="day" class="form-control required" autocomplete="off" placeholder="Select From Date" disabled>
                                                    </div>
                                                     <div></div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <input type="text" id="day_end" name="day_end" class="form-control required" autocomplete="off" placeholder="Select To Date" disabled>
                                                    </div>
                                                    <div></div>
                                                </td>
                                                <td>
                                                     <span class="btn btn-info btn-sm enterer" onclick="search_custom_report('search_custom')">Search</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                     </div>
                                </div>
                                
                                
                                <div class='list' id='list' style="margin-top: 3%;">
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dark table end -->
                </div>
            </div>
        </div>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'admin';
    var module = 'dtr';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    var approve_cnt_fun = 'approve';
    $(document).ready(function(){
        $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        $("[data-toggle='toggle']").bootstrapToggle();
    });
    $('body').on('click','a.paginate_button',function(){
    //alert();
       $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        $("[data-toggle='toggle']").bootstrapToggle();
        
    });
     $('a.paginate_button').on('click',function(){
    //alert('here');
});
    $('body').on('change', '#toll_plaza', function (){
    
        var tollplaza = this.value;
        if(tollplaza){
            $.ajax({ 
                url: "<?php echo base_url();?>admin/traffic_report_custom/get_dates/"+tollplaza,
                cache       : false,
                contentType : false,
                processData : false,
                beforeSend: function() {
                 },
                success: function(data) {

                  $('.weighdate').hide('slow');
                  $('.weighdate').show('slow');  
                  var obj = JSON.parse(data);
                  if(obj.start_date == '' || obj.end_date == ''){
                       notify("No record Found for this Tollplaza",'info','top','right');
                      $('#day').datepicker('remove');
                      $('#day').val('');
                      $('#day').prop('disabled', true);
                      $('#day_end').datepicker('remove');
                      $('#day_end').val('');
                      $('#day_end').prop('disabled', true);
                        
                    }else{
                      $('#day').prop('disabled', false);
                      $("#day").datepicker({
                        format: "yyyy/mm/dd",
                        startDate: obj.start_date,
                        autoclose: true,
                        endDate: obj.end_date
                     })
                      $('#day_end').prop('disabled', false);
                      $("#day_end").datepicker({
                        format: "yyyy/mm/dd",
                        startDate: obj.start_date,
                        autoclose: true,
                        endDate: obj.end_date
                     })
                  }
                                    
                },
                error: function(e) {
                    console.log(e)
                }
            });
        }else{
           $('.weighdate').hide('slow');  
        }
    
  });

  function search_custom_report(form_id,noty,e){

                   // alert(); return false;
                    var alerta = $('#form'); // alert div for show alert message
                    var form = $('#'+form_id);
                    //alert(form_id); return false;
                    var can = '';
                    if(!extra){
                        var extra = '';
                    }
                    form.find('.summernotes').each(function() {
                        var now = $(this);
                        now.closest('div').find('.val').val(now.code());
                    });
                    
                    //var form = $(this);
                    var formdata = false;
                    if (window.FormData){
                        formdata = new FormData(form[0]);
                    }
            
                    var a = 0;
                    var req = 'This field required';
                    var take = '';
                    form.find(".required").each(function(){
                        var txt = '*'+req;
                        a++;
                        if(a == 1){
                            take = 'scroll';
                        }
                        var here = $(this);
                        if(here.val() == ''){
                            if(!here.is('select')){
                                here.css({borderColor: 'red'});
                                if(here.attr('type') == 'number'){
                                    txt = '*This field required';
                                }
                                
                                if(here.closest('div').find('.badge-danger').length){
            
                                } else {
                                 
                                    here.closest('div').append(''
                                        +'  <span id="'+take+'" class="badge badge-danger" >'
                                        +'      '+txt
                                        +'  </span>'
                                    );
                                }
                            } else if(here.is('select')){
                                here.closest('div').find('.chosen-single').css({borderColor: 'red'});
                                if(here.closest('div').find('.require_alert').length){
            
                                } else {
                                   
                                    here.closest('div').append(''
                                        +'  <span id="'+take+'" class="badge badge-danger" >'
                                        +'      *Required'
                                        +'  </span>'
                                    );
                                }
            
                            }
                            var topp = 100;
                            if(form_id == 'product_add' || form_id == 'product_edit'){
                            } else {
                                $('html, body').animate({
                                      // scrollTop: $("#scroll").offset().top - topp
                                }, 500);
                            }
                            can = 'no';
                        }
            
                        if (here.attr('type') == 'email'){
                            if(!isValidEmailAddress(here.val())){
                                here.css({borderColor: 'red'});
                                if(here.closest('div').find('.badge-valid').length){
                
                                } else {
                                    
                                    here.closest('div').append(''
                                        +'  <span id="'+take+'" class="badge badge-danger badge-valid" >'
                                        +'      *Enter valid Email'
                                        +'  </span>'
                                    );
                                }
                                can = 'no';
                            }
                        }
            
                        take = '';
                    });
            
                    if(can !== 'no'){
                        
                        $.ajax({
                                url: form.attr('action'), // form action url
                                type: 'POST', // form submit method get/post
                                dataType: 'html', // request type html/json/xml
                                data: formdata ? formdata : form.serialize(), // serialize form data 
                                cache       : false,
                                contentType : false,
                                processData : false,
                                async: true,
                                beforeSend: function() {
                                    var buttonp = $('.enterer');
                                    buttonp.removeClass('enabled');
                                    buttonp.addClass('disabled');
                                    buttonp.html('working');
                                      var top = '200';
                                    $('#list').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
           
                                },
                                success: function(data) {
                                    $('#list').html(data);
                                    
                                },
                                error: function(e) {
                                    console.log(e)
                                }
                            });
                        
                        
                    } 
                }

    
</script>

        <!-- footer area start-->
   <?php include('includes/footer.php')?>      