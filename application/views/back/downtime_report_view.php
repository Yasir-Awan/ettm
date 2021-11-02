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
                                    <div class="col-md-5">
                                        <h4 class="header-title">Weighstations Down Time Report</h4>
                                    </div>

                                    <div class="col-md-7">
                                        <?php echo form_open(base_url()."down_time_report/system_status/post",array('id' => 'system_status'));?>
                                        <div class="row">
                                        <div class="col-md-6">
                                            
                                            <select class="form-control" id="weigh" name="weigh">
                                            <option value="">Choose Weigh Station</option>
                                            <?php foreach($weighs as $row){ ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['name'];?></option>
                                            <?php } ?>
                                            </select>
                                            
                                        </div>
                                            <!-- <input type="hidden" name="date" id="date" value="<?php echo $weighstation[0]['date'];?>"> -->
                                            <!-- <div class="col-md-4">
                                                    <select class="form-control required" name="weighstation" id="weighstation">
                                                        <option value="">Choose Weighstation</option>
                                                        <?php foreach($weighs as $row){?>
                                                        <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div> -->
                                                <div class="weighdate col-md-6">
                                                    <input type="text" id="day" name="day" class="form-control" autocomplete="off" placeholder="Select Date" <?php if(empty($dates['start_date']) || empty($dates['end_date'])){echo "disabled";}?> >
                                                </div>
                                        </div>
                                        </form>
                                    </div>
                                    <!-- <div class="col-md-4"><div class="px-4" style="border: 1px solid #007bff;"><label class="col-form-label col-form-label-lg" for="inputLarge">Analyze Time Gap for :</label></div></div>
                                    <div class="col-md-2">
                                            <div class="form-group" style="border:1px solid #007bff;">
                                                <input class="form-control form-control-lg" type="number" id="minutes" onChange="Number_of_Minutes_Gap();" placeholder="Enter Minutes" id="inputLarge">
                                            </div>
                                    </div>
                                            <div class="col-md-1"><button type="button" class="btn btn-primary"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp;Report</button></div> -->
                                </div>
                                <div class='list' id='list'>
                                    <div class="data-tables datatable-dark">
                                        <div class="row mt-2" style="margin-bottom:1%;">

                                            
                                        </div>
                                        <table id="dataTable3" class="text-center">
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th width="10% !important;">Date</th>
                                                    <th>Time</th>
                                                    <th>Ticket No</th>
                                                    <th>Vehicle No</th>
                                                    <th>Vehicle Type</th>
                                                    <th>Gross weight Ton</th>
                                                    <th>Excess Weight Ton</th>
                                                    <th>Perventage Overload</th>
                                                    <th>Fine Rs</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                   <td></td>
                                                </tr> 
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
     var form = $('#system_status');
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
                $('.list').html(data);
            },
            error: function(e) {
                console.log(e)
            }
        });
    })
//   $(document).ready(function(){
//         $("#day").datepicker({
//             format: "yyyy/mm/dd",
//             startDate: "<?php // echo $dates['start_date']?>",
//             autoclose: true,
//             endDate: "<?php // echo $dates['end_date']?>"
//          });
//   });

function time_gap(weigh,date = null){
    let mins = document.getElementById("min").value;
    if(mins < 1 || mins > 60){
        alert("Please Select Minutes From 1 To 60.");
        return false;
    }
    let a= document.createElement('a');
            a.target= '_blank';
            a.href= "<?php echo base_url();?>admin/timeslice_weighstation_pdf/"+weigh+"/"+date+"/"+mins ;
            a.click();	
}

$('#weigh').change(function(){
    let weigh = document.getElementById("weigh").value;
    //  var form = $('#search_report');
      $.ajax({ 
            url: "<?php echo base_url();?>down_time_report/weighstation_dates/"+weigh,
            cache       : false,
              contentType : false,
              processData : false,
            beforeSend: function() {
                var top = '200';
            },
            success: function(data) {
                dates = JSON.parse(data);

                $('#day').prop('disabled', false);
                  $("#day").datepicker({
                    format: "yyyy/mm/dd",
                    viewMode: "days", 
                    minViewMode: "days"  ,
                    startDate: dates.start_date,
                    autoclose: true,
                    endDate: dates.end_date
                 });
            },
            error: function(e) {
                console.log(e)
            }
        });
    });
</script>
<?php include('includes/footer.php')?>      
    