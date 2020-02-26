<footer class="footer">
        <div class="container">
         <!--  <nav>
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="http://presentation.creative-tim.com">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
            </ul>
          </nav> -->
          <div class="copyright" id="copyright">
            &copy;
            <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Designed an Developed by
            <a href="#" target="_blank">ETTM</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  
  <script src="<?php echo base_url()?>assets/front/member/js/core/popper.min.js"></script>
  <script src="<?php echo base_url()?>assets/front/member/js/core/bootstrap.min.js"></script>
  <script src="<?php echo base_url()?>assets/front/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script> 
  <script src="<?php echo base_url()?>assets/front/member/js/plugins/perfect-scrollbar.jquery.min.js"></script>
 <!-- <script src="<?php echo base_url()?>assets/front/js/vendor/jquery-1.11.2.min.js"></script>-->
  <!--  Google Maps Plugin    -->
  <!-- Chart JS -->
  <script src="<?php echo base_url()?>assets/front/member/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url()?>assets/front/member/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url()?>assets/front/member/js/now-ui-dashboard.min.js?v=1.2.0" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  

  <script>
    /** js for notify counter Timer START */
    var timer =  setInterval(function()
    {
     $.ajax({   
           url: "<?php echo base_url();?>toolplaza/notify_counter/", // form action url
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
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
		if(typeof demo === 'function'){
			 demo.initDashboardPageCharts();
		   }
		if(typeof demo === 'undefined'){
			/* demo.initDashboardPageCharts();*/
		   };
		
		
     

    });
    <?php if($page_name == "dashboard"){?>
    $(document).ready(function(){
         
          
          $("#formonth").datepicker({
            <?php if(empty(@$start_date) || empty(@$end_date)){?>
                  beforeShowDay:function(date){
                     return false;

                  }
          <?php }else{?>
            format: "yyyy/mm",
            startDate: "<?php echo $start_date?>",
            autoclose: true,
            endDate: "<?php echo $end_date?>",
            startView: "months",
            minViewMode: "months",
            maxViewMode: "years"
            <?php } ?>
          })
          
      

    });
   $('#formonth').change(function(  ){
      var date = $(this).val();
      $.ajax({ 
            type: 'POST',
            url: "<?php echo base_url();?>toolplaza/searchforchart/",
            data: {formonth: date},
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
  $('#notify_msg').click(function(  ){
      // var date = $(this).val();
      $.ajax({   
           url: "<?php echo base_url();?>toolplaza/notify_msg/", // form action url
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
   <script src="<?php echo base_url()?>assets/front/member/datatables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url()?>assets/front/member/datatables/dataTables.bootstrap4.js"></script>
    <script src="<?php echo base_url();?>assets/ajax_method.js"></script>
       <script src="<?php echo base_url()?>assets/back/bootbox/bootbox.min.js"></script> 
</body>

</html>
