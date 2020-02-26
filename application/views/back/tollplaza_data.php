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
                                        <h4 class="header-title">Tollplaza Daily Report</h4>
                                    </div>
                                    <!-- <div class="col-md-8">
                                        <?php echo form_open(base_url()."admin/weighstation_daily_report/post",array('id' => 'search_report'));?>
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
                                                    <th>Class1</th>
                                                    <th>Class2</th>
                                                    <th>Class3</th>
                                                    <th>Class4</th>
                                                    <th>Class5</th>
                                                    <th>Total</th>
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
                                                    
                                                    <td class="text-danger" style="font-size: 16px;">
                                                          <table class="table">
                                                            <tr>
                                                              <td>
                                                                Paid:
                                                              </td>

                                                              <td>
                                                                <span id="class1_paid_<?php echo $row['id']?>"><?php echo $row['class1_paid']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <td>
                                                                Voilation:
                                                              </td>

                                                              <td>
                                                                <span id="class1_voilate_<?php echo $row['id']?>"><?php echo $row['class1_voilate']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <td>
                                                                Exempt:
                                                              </td>

                                                              <td>
                                                                <span id="class1_exempt_<?php echo $row['id']?>"><?php echo $row['class1_exempt']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <td>
                                                                Total:
                                                              </td>

                                                              <td>
                                                                <span id="class1_total_<?php echo $row['id']?>"><?php echo $row['class1_total']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                          </table>
                                                      </td>
                                                      <td class="text-danger" style="font-size: 16px;">
                                                          <table class="table">
                                                            <tr>
                                                              <!-- <td>
                                                                Paid:
                                                              </td> -->

                                                              <td>
                                                                <span id="class2_paid_<?php echo $row['id']?>"><?php echo $row['class2_paid']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <!-- <td>
                                                                Voilation:
                                                              </td> -->

                                                              <td>
                                                                <span id="class2_voilate_<?php echo $row['id']?>"><?php echo $row['class2_voilate']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                             <!--  <td>
                                                                Exempt:
                                                              </td> -->

                                                              <td>
                                                                <span id="class2_exempt_<?php echo $row['id']?>"><?php echo $row['class2_exempt']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <!-- <td>
                                                                Total:
                                                              </td> -->

                                                              <td>
                                                                <span id="class2_total_<?php echo $row['id']?>"><?php echo $row['class2_total']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                          </table>
                                                      </td>
                                                      <td class="text-danger" style="font-size: 16px;">
                                                          <table class="table">
                                                            <tr>
                                                              <!-- <td>
                                                                Paid:
                                                              </td> -->

                                                              <td>
                                                                <span id="class3_paid_<?php echo $row['id']?>"><?php echo $row['class3_paid']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                             <!--  <td>
                                                                Voilation:
                                                              </td> -->

                                                              <td>
                                                                <span id="class1_voilate_<?php echo $row['id']?>"><?php echo $row['class3_voilate']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <!-- <td>
                                                                Exempt:
                                                              </td> -->

                                                              <td>
                                                                <span id="class3_exempt_<?php echo $row['id']?>"><?php echo $row['class3_exempt']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <!-- <td>
                                                                Total:
                                                              </td> -->

                                                              <td>
                                                                <span id="class3_total_<?php echo $row['id']?>"><?php echo $row['class3_total']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                          </table>
                                                      </td>
                                                      <td class="text-danger" style="font-size: 16px;">
                                                          <table class="table">
                                                            <tr>
                                                              <!-- <td>
                                                                Paid:
                                                              </td> -->

                                                              <td>
                                                                <span id="class4_paid_<?php echo $row['id']?>"><?php echo $row['class4_paid']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <!-- <td>
                                                                Voilation:
                                                              </td> -->

                                                              <td>
                                                                <span id="class4_voilate_<?php echo $row['id']?>"><?php echo $row['class4_voilate']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                             <!--  <td>
                                                                Exempt:
                                                              </td> -->

                                                              <td>
                                                                <span id="class4_exempt_<?php echo $row['id']?>"><?php echo $row['class4_exempt']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <!-- <td>
                                                                Total:
                                                              </td> -->

                                                              <td>
                                                                <span id="class4_total_<?php echo $row['id']?>"><?php echo $row['class4_total']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                          </table>
                                                      </td>
                                                      <td class="text-danger" style="font-size: 16px;">
                                                          <table class="table">
                                                            <tr>
                                                              <!-- <td>
                                                                Paid:
                                                              </td> -->

                                                              <td>
                                                                <span id="class5_paid_<?php echo $row['id']?>"><?php echo $row['class5_paid']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <!-- <td>
                                                                Voilation:
                                                              </td> -->

                                                              <td>
                                                                <span id="class5_voilate_<?php echo $row['id']?>"><?php echo $row['class5_voilate']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <!-- <td>
                                                                Exempt:
                                                              </td> -->

                                                              <td>
                                                                <span id="class5_exempt_<?php echo $row['id']?>"><?php echo $row['class5_exempt']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                            <tr>
                                                              <!-- <td>
                                                                Total:
                                                              </td> -->

                                                              <td>
                                                                <span id="class5_total_<?php echo $row['id']?>"><?php echo $row['class5_total']?></span><i class="fa fa-caret-up"></i>
                                                              </td>
                                                            </tr>
                                                          </table>
                                                      </td>
                                                      <td class="text-danger" style="font-weight: 800;"><span id="total_vehicles_<?php echo $row['id']?>"><?php echo $row['total_vehicles'];?></span><i class="fa fa-caret-up"></i></td>
                                                    
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
        $('#dataTable3').DataTable();
        $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
        $("[data-toggle='toggle']").bootstrapToggle();
    })


      var timer =  setInterval(function(){
        $.ajax({   
           url: "<?php echo base_url().'admin/get_tollplaza_data';?>", // form action url
           type: 'POST', // form submit method get/post
           dataType: 'html',
           success: function(data) {
                var obj = JSON.parse(data);
                obj.forEach(function(element) {
                      
                     $('#date_' + element.id).text(element.date) ;
                     $('#class1_paid_' + element.id).text(element.class1_paid) ;
                     $('#class1_voilate_' + element.id).text(element.class1_voilate);
                     $('#class1_exempt_' + element.id).text(element.class1_exempt) ;
                     $('#class1_total_' + element.id).text(element.class1_total) ;
                     $('#class2_paid_' + element.id).text(element.class2_paid) ;
                     $('#class2_voilate_' + element.id).text(element.class2_voilate);
                     $('#class2_exempt_' + element.id).text(element.class2_exempt) ;
                     $('#class2_total_' + element.id).text(element.class2_total) ;
                     $('#class3_paid_' + element.id).text(element.class3_paid) ;
                     $('#class3_voilate_' + element.id).text(element.class3_voilate);
                     $('#class3_exempt_' + element.id).text(element.class3_exempt) ;
                     $('#class3_total_' + element.id).text(element.class3_total) ;
                     $('#class4_paid_' + element.id).text(element.class4_paid) ;
                     $('#class4_voilate_' + element.id).text(element.class4_voilate);
                     $('#class4_exempt_' + element.id).text(element.class4_exempt) ;
                     $('#class4_total_' + element.id).text(element.class4_total) ;
                     $('#class5_paid_' + element.id).text(element.class5_paid) ;
                     $('#class5_voilate_' + element.id).text(element.class5_voilate);
                     $('#class5_exempt_' + element.id).text(element.class5_exempt) ;
                     $('#class5_total_' + element.id).text(element.class5_total) ;
                     $('#total_vehicles_' + element.id).text(element.total_vehicles) ;
                     
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