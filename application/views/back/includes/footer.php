<!-- footer area start-->
        <footer>
            <div class="footer-area">
            <?php if($this->session->userdata('adminid')!=22){ ?>
                <p>© Copyright 2019. All right reserved.</p>
            <?php } ?>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
    <div class="offset-area">
        <div class="offset-close"><i class="ti-close"></i></div>
        <ul class="nav offset-menu-tab">
            <li><a class="active" data-toggle="tab" href="#activity">Activity</a></li>
            <li><a data-toggle="tab" href="#settings">Settings</a></li>
        </ul>
        <div class="offset-content tab-content">
            <div id="activity" class="tab-pane fade in show active">
                <div class="recent-activity">
                    <div class="timeline-task">
                        <div class="icon bg1">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Added</h4>
                            <span class="time"><i class="ti-time"></i>7 Minutes Ago</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="tm-title">
                            <h4>You missed you Password!</h4>
                            <span class="time"><i class="ti-time"></i>09:20 Am</span>
                        </div>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="fa fa-bomb"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Member waiting for you Attention</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="ti-signal"></i>
                        </div>
                        <div class="tm-title">
                            <h4>You Added Kaji Patha few minutes ago</h4>
                            <span class="time"><i class="ti-time"></i>01 minutes ago</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg1">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Ratul Hamba sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Hello sir , where are you, i am egerly waiting for you.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="fa fa-bomb"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                    <div class="timeline-task">
                        <div class="icon bg3">
                            <i class="ti-signal"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Rashed sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse distinctio itaque at.
                        </p>
                    </div>
                </div>
            </div>
            <div id="settings" class="tab-pane fade">
                <div class="offset-settings">
                    <h4>General Settings</h4>
                    <div class="settings-list">
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Notifications</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch1" />
                                    <label for="switch1">Toggle</label>
                                </div>
                            </div>
                            <p>Keep it 'On' When you want to get all the notification.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Show recent activity</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch2" />
                                    <label for="switch2">Toggle</label>
                                </div>
                            </div>
                            <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Show your emails</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch3" />
                                    <label for="switch3">Toggle</label>
                                </div>
                            </div>
                            <p>Show email so that easily find you.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Show Task statistics</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch4" />
                                    <label for="switch4">Toggle</label>
                                </div>
                            </div>
                            <p>The for attribute is necessary to bind our custom checkbox with the input.</p>
                        </div>
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>Notifications</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch5" />
                                    <label for="switch5">Toggle</label>
                                </div>
                            </div>
                            <p>Use checkboxes when looking for yes or no answers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- offset area end -->
    <!-- jquery latest version -->
<script>

<?php if($page == "Dashboard"){?>
$(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
     // demo.initDashboardPageCharts();
    });

    $('body').on('change','#tollplaza',function()
    {        
         var tollplaza = $(this).val();
          if(tollplaza){
          $.ajax({ 
            type: 'POST',
            url: "<?php echo base_url();?>admin/check_tollplaza_dates/"+tollplaza,
            beforeSend: function(){
                //var top = '200';
                $('.date').hide('normal'); // change submit button text
            },
            success: function(data) {
               $('.date').show('normal');
              var obj = JSON.parse(data);
              if(obj.start_date == '' || obj.end_date == ''){
                   notify("No record Found for this Tollplaza",'info','top','right');
                  $('#formonth').datepicker('remove');
                  $('#formonth').val('');
                   $('#formonth').prop('disabled', true);
            
                }else{
                  $('#formonth').prop('disabled', false);
                  $("#formonth").datepicker({

                    format: "yyyy/mm",

                    startDate: obj.start_date,
                    autoclose: true,
                    endDate: obj.end_date,
                    startView: "months",
                    minViewMode: "months",
                    maxViewMode: "years",

                  })
              }                  
            },
            error: function(e) {
                console.log(e)
            }
        });
          
          
      } else{
        $('#formonth').val('');
        $('.date').hide('slow');
      }   
      

    });

    /** js for dashboard Timer START */
    var timer =  setInterval(function(){
    if($('#timer').length > 0){
    var form = $('#timer');
     
     $.ajax({   
           url: form.attr('action'), // form action url
           type: 'POST', // form submit method get/post
           dataType: 'html', // request type html/json/xml
           data: form.serialize(),
           beforeSend: function() {
               var top = '200';
               $('.chart_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
           },
           success: function(data) {
               //console.log(data);
               $('.chart_div').html(data);
                //clearInterval(timer);               
           },
           error: function(e) {
               console.log(e)
           }
       }); 
       }  
    },15000); 
    /** js for dashboard Timer END */
  
    $('body').on('change','#formonth',function(){
     var form = $('#searchforchart');
     
      $.ajax({   
            url: form.attr('action'), // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: form.serialize(),
            beforeSend: function() {
                var top = '200';
                $('.chart_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('.chart_div').html(data);
                                
            },
            error: function(e) {
                console.log(e)
            }
        });
    })
    <?php } ?>
  </script>
  <script>

<?php if($page == "Desired Chart"){?>
$(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
     // demo.initDashboardPageCharts();
    });

    $('body').on('change','#tollplaza',function()
    {        
         var tollplaza = $(this).val();
          if(tollplaza){
          $.ajax({ 
            type: 'POST',
            url: "<?php echo base_url();?>admin/check_tollplaza_dates/"+tollplaza,
            beforeSend: function(){
                //var top = '200';
                $('.date').hide('normal'); // change submit button text
            },
            success: function(data) {
               $('.date').show('normal');
              var obj = JSON.parse(data);
              if(obj.start_date == '' || obj.end_date == ''){
                   notify("No record Found for this Tollplaza",'info','top','right');
                  $('#formonth').datepicker('remove');
                  $('#formonth').val('');
                   $('#formonth').prop('disabled', true);
                }else{
                  $('#formonth').prop('disabled', false);
                  $("#formonth").datepicker({
                    format: "yyyy/mm",
                    startDate: obj.start_date,
                    autoclose: true,
                    endDate: obj.end_date,
                    startView: "months",
                    minViewMode: "months",
                    maxViewMode: "years",
                  })
              }                  
            },
            error: function(e) {
                console.log(e)
            }
        });
          
      } else{
        $('#formonth').val('');
        $('.date').hide('slow');
      }   
    });

   
    /** js for dashboard Timer END */
 
	  
    $('body').on('change','#formonth',function(){
     var form = $('#searchfordchart');
     
      $.ajax({   
            url: form.attr('action'), // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: form.serialize(),
            beforeSend: function() {
                var top = '200';
                $('.chart_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('.chart_div').html(data);
                                
            },
            error: function(e) {
                console.log(e)
            }
        });
    })
    <?php } ?>

    <?php if($page == "omcDesired Chart"){?>
$(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
     // demo.initDashboardPageCharts();
    });

    $('body').on('change','#tollplaza',function()
    {        
         var tollplaza = $(this).val();
          if(tollplaza){
          $.ajax({ 
            type: 'POST',
            url: "<?php echo base_url();?>omc/check_tollplaza_dates/"+tollplaza,
            beforeSend: function(){
                //var top = '200';
                $('.date').hide('normal'); // change submit button text
            },
            success: function(data) {
               $('.date').show('normal');
              var obj = JSON.parse(data);
              if(obj.start_date == '' || obj.end_date == ''){
                   notify("No record Found for this Tollplaza",'info','top','right');
                  $('#formonth').datepicker('remove');
                  $('#formonth').val('');
                   $('#formonth').prop('disabled', true);
                }else{
                  $('#formonth').prop('disabled', false);
                  $("#formonth").datepicker({
                    format: "yyyy/mm",
                    startDate: obj.start_date,
                    autoclose: true,
                    endDate: obj.end_date,
                    startView: "months",
                    minViewMode: "months",
                    maxViewMode: "years",
                  })
              }                  
            },
            error: function(e) {
                console.log(e)
            }
        });
          
      } else{
        $('#formonth').val('');
        $('.date').hide('slow');
      }   
    });

   
    /** js for dashboard Timer END */
 
	  
    $('body').on('change','#formonth',function(){
     var form = $('#searchfordchart');
     
      $.ajax({   
            url: form.attr('action'), // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: form.serialize(),
            beforeSend: function() {
                var top = '200';
                $('.chart_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('.chart_div').html(data);
                                
            },
            error: function(e) {
                console.log(e)
            }
        });
    })
    <?php } ?>



	<?php if($page == "Monthly DTR Chart"){?>
$(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
     // demo.initDashboardPageCharts();
    });

    $('body').on('change','#tollplaza',function()
    {        
         var tollplaza = $(this).val();
          if(tollplaza){
          $.ajax({ 
            type: 'POST',
            url: "<?php echo base_url();?>admin/check_dtrtollplaza_dates/"+tollplaza,
            beforeSend: function(){
                var top = '200';
                $('.date').hide('normal'); // change submit button text
            },
            success: function(data) {
               $('.date').show('normal');
              var obj = JSON.parse(data);
              if(obj.start_date == '' || obj.end_date == ''){
                   notify("No record Found for this Tollplaza",'info','top','right');
                  $('#formonth').datepicker('remove');
                  $('#formonth').val('');
                   $('#formonth').prop('disabled', true);
            
                }else{
                  $('#formonth').prop('disabled', false);
                  $("#formonth").datepicker({

                    format: "yyyy-mm",

                    startDate: obj.start_date,
                    autoclose: true,
                    endDate: obj.end_date,
                    startView: "months",
                    minViewMode: "months",
                    maxViewMode: "years",

                  })
              }                  
            },
            error: function(e) {
                console.log(e)
            }
        });
          
          
      } else{
        $('#formonth').val('');
        $('.date').hide('slow');
      }   
      

    });

   
    /** js for dashboard Timer END */
 
	  
    $('body').on('change','#formonth',function(){
     var form = $('#searchfordtrchart');
     
      $.ajax({   
            url: form.attr('action'), // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: form.serialize(),
            beforeSend: function() {
                var top = '300';
                $('.chart_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
				$('#dtr_month').hide();
                $('.chart_div1').html(data);
                                
            },
            error: function(e) {
                console.log(e)
            }
        });
    })
    <?php } ?>
	<?php if($page == "M Traffic Chart"){?>
$(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
     // demo.initDashboardPageCharts();
    });
	  <?php $asc = $this->db->select('*')->order_by('for_date','ASC')->get('dtr')->result_array();
						 $desc = $this->db->select('*')->order_by('for_date','DESC')->get('dtr')->result_array();?>
                  var start_date = "<?php echo date('Y-m',strtotime($asc[0]['for_date'])) ?>";
				 var end_date = "<?php echo date('Y-m',strtotime($desc[0]['for_date'])) ?>";
	  $("#formonth").on('click', function(){
		  
			
		  if(start_date == '' || end_date == ''){
                  $('#formonth').datepicker('remove');
                  $('#formonth').val('');
                   $('#formonth').prop('disabled', true);
            
                }else{
                  $('#formonth').prop('disabled', false);
                  $("#formonth").datepicker({

                    format: "yyyy-mm",

                    startDate: start_date,
                    autoclose: true,
                    endDate: end_date,
                    startView: "months",
                    minViewMode: "months",
                    maxViewMode: "years",

                  })
              }            
	  })
			/*);
    /*$('body').on('change','#tollplaza',function()
    {        
         var tollplaza = $(this).val();
          if(tollplaza){
          $.ajax({ 
            type: 'POST',
            url: "<?php echo base_url();?>admin/check_dtrtollplaza_dates/"+tollplaza,
            beforeSend: function(){
                var top = '200';
                $('.date').hide('normal'); // change submit button text
            },
            success: function(data) {
               $('.date').show('normal');
              var obj = JSON.parse(data);
              if(obj.start_date == '' || obj.end_date == ''){
                   notify("No record Found for this Tollplaza",'info','top','right');
                  $('#formonth').datepicker('remove');
                  $('#formonth').val('');
                   $('#formonth').prop('disabled', true);
            
                }else{
                  $('#formonth').prop('disabled', false);
                  $("#formonth").datepicker({

                    format: "yyyy-mm",

                    startDate: obj.start_date,
                    autoclose: true,
                    endDate: obj.end_date,
                    startView: "months",
                    minViewMode: "months",
                    maxViewMode: "years",

                  })
              }                  
            },
            error: function(e) {
                console.log(e)
            }
        });
          
          
      } else{
        $('#formonth').val('');
        $('.date').hide('slow');
      }   
      

    });*/

   
    /** js for dashboard Timer END */
 
	  
    $('body').on('change','#formonth',function(){
     var form = $('#searchfordtrmchart');
     
      $.ajax({   
            url: form.attr('action'), // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: form.serialize(),
            beforeSend: function() {
                var top = '300';
                $('.chart_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
				
                $('.chart_div').html(data);
				$('#chart').hide();
				$('#dtr_month').hide();
                                
            },
            error: function(e) {
                console.log(e)
            }
        });
    });
    <?php } ?>
  </script>
      <script>
    /** js for notify counter Timer START */
    var timer =  setInterval(function()
    {
     $.ajax({   
           url: "<?php echo base_url();?>admin/notify_counter/", // form action url
           type: 'POST', // form submit method get/post
           dataType: 'html', // request type html/json/xml
           data: false,
           beforeSend: function() {
               var top = '200';
              //  $('.chart_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
           },
           success: function(data) {
               //console.log(data);
               $('#notify_counter').html(data);
                //clearInterval(timer);               
           },
           error: function(e) {
               console.log(e)
           }
       }); 
    },4000); 
    /** js for notify-conter Timer END */
    </script>
   <script>
  $('#notify_msg').click(function(  ){
      // var date = $(this).val();
      $.ajax({   
           url: "<?php echo base_url();?>admin/notify_msg/", // form action url
           type: 'POST', // form submit method get/post
           dataType: 'html', // request type html/json/xml
           data: false,
           beforeSend: function() {
               var top = '200';
              //  $('.chart_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
           },
           success: function(data) {
               //console.log(data);
               $('#show_notify_msg').html(data);
                //clearInterval(timer);               
           },
           error: function(e) {
               console.log(e)
           }
       }); 
    })
  </script>

    
    <script src="<?php echo base_url();?>assets/back/js/vendor/bootstrap-notify.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo base_url();?>assets/back/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/jquery.slicknav.min.js"></script>
     <script src="<?php echo base_url()?>assets/front/member/js/plugins/chartjs.min.js"></script>
    <!-- start chart js -->

    <!-- start highcharts js -->
    <!-- start zingchart js -->
    <!-- script for sending ajax requests to get road crash data START -->



<!-- script for sending ajax requests to get road crash data END -->
  
   
     <!-- Start datatable js -->
     
    <script src="<?php echo base_url();?>assets/datatables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url();?>assets/datatables/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url();?>assets/datatables/responsive.bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/scripts.js"></script>
    <script src="<?php echo base_url();?>assets/ajax_method.js"></script>
    <script src="<?php echo base_url();?>assets/back/summernote/summernote.min.js"></script>
    <script src="<?php echo base_url()?>assets/back/bootbox/bootbox.min.js"></script>
    <script src="<?php echo base_url()?>assets/back/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>
    <script src="<?php echo base_url()?>assets/front/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script> 
    <script src="<?php echo base_url();?>assets/datatables/datetime-luxon.js"></script>
    <script src="<?php echo base_url(); ?>assets/back/js/jquery.timepicker.min.js"></script>
    <?php if(isset($page_assets['js'])) echo $page_assets['js'];?>

</body>

</html>

