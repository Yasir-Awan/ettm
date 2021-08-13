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
                                    <div class="col-md-8">
                                        <?php echo form_open(base_url()."admin/weighstation_daily_report/post",array('id' => 'search_report'));?>
                                        <div class="row">
                                            <input type="hidden" name="weighstation" id="weighstation" value="<?php echo $weigh;?>">
                                            <!-- 
                                                <div class="col-md-4">
                                                    <select class="form-control required" name="weighstation" id="weighstation">
                                                        <option value="">Choose Weighstation</option>
                                                        <?php foreach($weighs as $row){?>
                                                        <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div> -->
                                                <div class="weighdate col-md-4">
                                                    <input type="text" id="day" name="day" class="form-control" placeholder="Select Date" >
                                                </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class='list' id='list'>
                                    <div class="data-tables datatable-dark">
                                        <div class="row" style="margin-bottom:1%;">
                                            <div class="col-md-12">
                                                <?php if($weighstation){?>
                                                    <a href="<?php echo base_url()?>admin/daily_weighstation_pdf/<?php echo $weigh;?>/<?php echo $weighstation[0]['date'];?>" class="btn btn-success btn-sm pull-right" target="__blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp;Generate PDF</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <table id="dataTable3" class="text-center">
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th width="10% !important;">Date</th>
                                                    <th>Time</th>
                                                    <th>Ticket No</th>
                                                    <th>Vehicle No</th>
                                                    <th>Haulier Name</th>
                                                    <th>Gross weight Ton</th>
                                                    <th>Excess Weight Ton</th>
                                                    <th>Perventage Overload</th>
                                                    <th>Fine Rs</th>
                                                    <th>Status</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if($weighstation){
                                                    foreach($weighstation as $row){
                                                ?>
                                                 <tr>
                                                    <td><?php echo date('d-m-Y',strtotime($row['date']));?></td>
                                                    <td><?php echo $row['time'];?></td>
                                                    <td><?php echo $row['ticket_no'];?></td>
                                                    <td><?php echo $row['vehicle_no'];?></td>
                                                    <td><?php echo $row['haulier'];?></td>
                                                    <td><?php echo round($row['weight'],2);?></td>
                                                    <td><?php echo round($row['exces_weight'],2);?></td>
                                                    <td><?php echo $row['percent_overload'];?>&nbsp; %</td>
                                                    <td><?php echo $row['fine'];?></td>
                                                    <td><?php if($row['status'] == 2){echo "Overload";}else{echo "Ok";}?></td>      
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
  $(document).ready(function(){
        $("#day").datepicker({
            format: "yyyy/mm/dd",
            startDate: "<?php echo $dates['start_date']?>",
            autoclose: true,
            endDate: "<?php echo $dates['end_date']?>"
         });

  });
    
</script>
<?php include('includes/footer.php')?>      
    