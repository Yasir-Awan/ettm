<footer class="footer">
        <div class="container">
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
  
  <!--  Google Maps Plugin    -->
  
  <!-- Chart JS -->
   <script src="<?php echo base_url()?>assets/front/member/js/plugins/chartjs.min.js"></script>
  
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url()?>assets/front/member/js/plugins/bootstrap-notify.js"></script>
  
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url()?>assets/front/member/js/now-ui-dashboard.min.js?v=1.2.0" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  
  <script>
    $(document).ready(function() 
    {
      // Javascript method's body can be found in assets/js/demos.js
      //demo.initDashboardPageCharts();
    });

    <?php if($page_name == "dashboard")
    {?>
     $('#tollplaza').change(function()
       {
         var tollplaza = $(this).val();
          if(tollplaza){
          $.ajax({ 
            type: 'POST',
            url: "<?php echo base_url();?>member/check_tollplaza_dates/"+tollplaza,
            beforeSend: function() 
            {
                //var top = '200';
                $('.date').hide('slow'); // change submit button text
            },
            success: function(data) 
            {
               $('.date').show('slow');
              var obj = JSON.parse(data);
              if(obj.start_date == '' || obj.end_date == '')
              {
                  notify("No record Found for this Tollplaza",'info','top','right'); 
                  $('#formonth').datepicker('remove');
                  $('#formonth').val('');
                   $('#formonth').prop('disabled', true);
            
                }
                else
                {
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
            error: function(e) 
            {
                console.log(e)
            }
        });
          
          
      } 
      else
      {
        $('#formonth').val('');
        $('.date').hide('slow');
      }   
    });
   $('#formonth').change(function(  )
   {
     var form = $('#searchforchart');  
      $.ajax(
        { 
            url: form.attr('action'), // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: form.serialize(),
            beforeSend: function() 
            {
                var top = '200';
                $('.chart_div').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) 
            {
                //console.log(data);
                $('.chart_div').html(data);                    
            },
            error: function(e) 
            {
                console.log(e)
            }
        });
    })
    <?php } ?>
  </script>
  <script src="<?php echo base_url()?>assets/front/member/datatables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url()?>assets/front/member/datatables/dataTables.bootstrap4.js"></script>
    <script src="<?php echo base_url();?>assets/ajax_method.js"></script>
       <script src="<?php echo base_url()?>assets/back/bootbox/bootbox.min.js"></script> 
</body>

</html>
