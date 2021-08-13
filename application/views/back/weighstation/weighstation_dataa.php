<?php include('includes/header.php'); ?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- data table start -->
                    
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                        
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="header-title">Weighstation Daily Reports</h4>
                                    </div>
                                    <!-- <div class="col-md-8">
                                        <?php echo form_open(base_url()."weighstations/weighstation_daily_report/post",array('id' => 'search_report'));?>
                                        <div class="row">
                                            
                                                <div class="col-md-4">
                                                    <select class="form-control required" name="weighstation" id="weighstation">
                                                        <option value="">Choose Weighstation</option>
                                                        <?php foreach($weighstation as $row){?>
                                                        <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="weighdate col-md-4" style="display:none;">
                                                    <input type="text" id="day" name="day" class="form-control" placeholder="Select Date" >
                                                </div>

                                                
                                            
                                        </div>
                                        </form>
                                    </div> -->
                                </div>
                                <div class='list' id='list'>
                                        <table id="dataTable3" class="text-center">
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Date</th>
                                                    <th>Total Vehicle Passed</th>
                                                    <th>Overloaded</th>
                                                    <th>Fined</th>
                                                    <th>Last Updated</th>
                                                    <th>Action</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if($record){
                                                  $counter = 0;
                                                    foreach($record as $row){
                                                        $counter ++;
                                                          

                                                ?>
                                                 <tr>
                                                    <td><?php echo $counter;?></td>
                                                    <td class="text-info" style="font-weight: 800;"><?php echo $row['name'];?></td>
                                                    <td class="text-success" ><span id="date_<?php echo $row['id']?>"><?php echo date("F j, Y",strtotime($row['date']));;?></span></td>
                                                    <td class="text-danger" style="font-size: 16px;"><i class="fa fa-caret-up"></i><span id="total_<?php echo $row['id']?>"><?php echo $row['total_vehicles'];?></span></td>
                                                    <td class="text-danger" style="font-size: 16px;"><i class="fa fa-caret-up"></i><span id="overloaded_<?php echo $row['id']?>"><?php echo $row['overloaded'];?></span></td>
                                                    <td class="text-danger" style="font-size: 16px;"><i class="fa fa-caret-up"></i><span id="fined_<?php echo $row['id']?>"><?php echo $row['fined'];?></span></td>
                                                    <td class="text-info"> <span id="update_<?php echo $row['id']?>"><?php if($row['last_updated']){echo date("F j, Y, g:i a",$row['last_updated']);}?></span></td>
                                                    <td><a href="<?php echo base_url().'weighstations/weighstation_daily_report/by_weighstation/'.$row['id'];?>" class="btn-xs btn-success fa fa-calendar">&nbsp;Daily Report</a>&nbsp; <a href="<?php echo base_url().'admin/weighstation_monthly_report/by_weighstation/'.$row['id'];?>" class="btn-xs btn-info fa fa-calendar">&nbsp; Monthly Report</a></td>
                                                </tr> 
                                                <?php    }
                                                }?>
                                               
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
    var user_type = 'weighstations';
    var module = 'weighstation_daily_report';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';

    $('body').on('change', '#weighstation', function (){
    
    var weighstation = this.value;
    if(weighstation){
        $.ajax({ 
            url: "<?php echo base_url();?>weighstations/weighstation_daily_report/by_weighstation/"+weighstation,
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
        $('#dataTable3').DataTable();
        $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
        $("[data-toggle='toggle']").bootstrapToggle();
    })


      var timer =  setInterval(function(){
    
        $.ajax({   
           url: "<?php echo base_url().'weighstations/get_weighstation_data';?>", // form action url
           type: 'POST', // form submit method get/post
           dataType: 'html',
           success: function(data) {
                var obj = JSON.parse(data);
                obj.forEach(function(element) {
                      
                     $('#date_' + element.id).text(element.date) ;
                     $('#total_' + element.id).text(element.total_vehicles) ;
                     $('#overloaded_' + element.id).text(element.overloaded);
                     $('#fined_' + element.id).text(element.fined) ;
                     $('#update_' + element.id).text(element.last_updated) ;
                });           
           },
           error: function(e) {
               console.log(e)
           }
       }); 
        
    },15000); 

    </script>

        <!-- footer area start-->
   <?php include('includes/footer.php')?>       