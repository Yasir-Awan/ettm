  <?php include('includes/header.php'); ?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                   
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <?php echo form_open(base_url()."admin/weighstation_consolidated_report_search/post",array('id' => 'search_report'));?>
                                        <div class="row">
                                            
                                                <div class="weighdate col-md-6">
                                                    <input type="text" id="day" name="day" class="form-control" autocomplete="off" placeholder="Select Date">
                                                </div>

                                                
                                            
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class='list' id='list'>
                                      
                                         <div class="row" style="margin-bottom:1%;">
                                              <div class="col-md-12">
                                                  <?php if($record){?>
                                                      <a href="<?php echo base_url()?>admin/weighstation_consolidated_report_pdf/<?php echo date("m-Y", strtotime($record[0]['datemade']));?>/" class="btn btn-success btn-sm pull-right" target="__blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp;Generate PDF</a>
                                                  <?php } ?>
                                              </div>
                                          </div>
                                           <div class="row">
                                                <div class="col-md-12">
                                                    <h4 class="header-title text-center">Summary of Truck Traffic of Weigh Stations for the month of <?php echo $record[0]['datemade'];?></h4>
                                                </div>
                                            </div>
                                        <table class="text-center table table-bordered table-responsive"> </span>
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th rowspan="2" style="width: 15% !important;">Date:<?php echo $record[0]['datemade'];?></th>
                                                    <th rowspan="2">Total Trucks Weighed</th>
                                                    <th colspan="4"> Within Load Limit </th>
                                                    <th colspan="4"> Overloaded </th>
                                                    <th rowspan="2"> Fine Amount(RS) </th>
                                                </tr>
                                                <tr>
                                                          <th>2 Axle</th>
                                                          <th>3 Axle</th>
                                                          <th>4,5,6 Axle</th>
                                                          <th>Total</th>
                                                          <th>2 Axle</th>
                                                          <th>3 Axle</th>
                                                          <th>4,5,6 Axle</th>
                                                          <th>Total</th>
                                                </tr>
                                               
                                            </thead>
                                            <tbody>
                                                <?php if($record){
                                                        
                                                        foreach($record as $row){
                                                          
                                                          
                                                  ?>
                                                  <tr>
                                                    <td style="font-size: 14px;font-weight: 900;float:left;" colspan="10"><?php echo $row['name'];?></td>
              
                                                </tr>
                                                <tr>
                                                    <td>Total Truck</td>
                                                    <td><?php echo $row['total_vehicles']?></td>
                                                    <td> <?php echo $row['2ax_inload'];?> </td>
                                                    <td> <?php echo $row['3ax_inload'];?> </td>
                                                    <td><?php echo ($row['4ax_inload'] + $row['5ax_inload'] + $row['6ax_inload']);?> </td>
                                                    <td> <?php echo $row['total_vehicles_inload'];?></td>
                                                    <td> <?php echo $row['2ax_overloaded'];?> </td>
                                                    <td> <?php echo $row['3ax_overloaded'];?> </td>
                                                    <td> <?php echo ($row['4ax_overloaded'] + $row['5ax_overloaded'] + $row['6ax_overloaded']);?> </td>
                                                    <td> <?php echo $row['total_vehicles_overloaded'];?> </td>
                                                    <td> <?php echo $row['fined']?> </td>
                                                    
                                                </tr>
                                                <?php } 
                                                ?>
                                                
                                                <?php          }else{
                                                ?>
                                                <tr>
                                                  <td colspan=11>
                                                    No record Found
                                                  </td>
                                                </tr>
                                                <?php } 

                                                ?>
                                            </tbody>
                                        </table>
   
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
    var module = 'weighstation_daily_report';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';

    $('body').on('change', '#weighstation', function (){
    
    var weighstation = this.value;
    if(weighstation){
        $.ajax({ 
            url: "<?php echo base_url();?>admin/weighstation_daily_report/by_weighstation/"+weighstation,
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
            
                }else{
                  $('#day').prop('disabled', false);
                  $("#day").datepicker({
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
  $('#day').change(function(){
     var form = $('#search_report');
     
      $.ajax({ 
            url: form.attr('action'), // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: form.serialize(),
            beforeSend: function() {
                var top = '200';
                $('.list').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('.list').html(data);
                                
            },
            error: function(e) {
                console.log(e)
            }
        });
    })
    
</script>
 <script>
      $(document).ready(function(){
      
        $("#day").datepicker({
            format: "mm/yyyy",
            viewMode: "months", 
            minViewMode: "months"  ,
            autoclose: true,
           
         });
        
  });


      

    </script>

        <!-- footer area start-->
   <?php include('includes/footer.php')?>      