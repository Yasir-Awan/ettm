<?php include('includes/header.php'); ?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- data table start -->
                    <?php 
                        $weigh_name = $this->db->get_where('weighstation',array('id' => $weigh))->row()->name;
                    ?>
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="header-title text-center">Weighstation Summary Report</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="header-title"><?php echo $weigh_name; ?></h4>
                                    </div>
                                    <div class="col-md-6">
                                                  <?php if($weighstation){?>
                                                      <button href="<?php echo base_url()?>admin/monthly_weighstation_pdf/<?php echo $weigh;?>/<?php echo $weighstation[0]['date'];?>" class="btn btn-success btn-sm pull-right" target="__blank" disabled="disabled"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp;Summary PDF</button>
                                                  <?php } ?>
                                              </div>

                                </div>
                                <div class='list' id='list'>

                                        <table class="text-center table table-bordered table-responsive"> <span class="pull-right">Dated:<?php echo date('d-m-Y');?></span>
                                            <thead class="text-capitalize">
                                                <tr>
                                                    <th rowspan="2" style="width: 15% !important;">Date</th>
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
                                                <?php if($weighstation){
                                                        $entries = 0;
                                                        $total = 0;
                                                        $two_ax_inload_total = 0;
                                                        $three_ax_inload_total = 0;
                                                        $ffs_ax_inload_total = 0;
                                                        $inload_total = 0;
                                                        $two_ax_overload_total = 0;
                                                        $three_ax_overload_total = 0;
                                                        $ffs_ax_overload_total = 0;
                                                        $overload_total = 0;
                                                        $total_fine = 0;
                                                        foreach($weighstation as $row){
                                                          
                                                          $entries++;
                                                          $total = $total + $row['total_vehicles'];
                                                          $two_ax_inload_total = $two_ax_inload_total + $row['2ax_wl'];
                                                          $three_ax_inload_total = $three_ax_inload_total + $row['3ax_wl'];
                                                          $ffs_ax_inload_total = $ffs_ax_inload_total + $row['456ax_wl'];
                                                          $inload_total = $inload_total + $row['total_wl'];
                                                          $two_ax_overload_total = $two_ax_overload_total + $row['2ax_ol'];
                                                          $three_ax_overload_total = $three_ax_overload_total + $row['3ax_ol'];
                                                          $ffs_ax_overload_total = $ffs_ax_overload_total + $row['456ax_ol'];
                                                          $overload_total = $overload_total + $row['total_ol'];
                                                          $total_fine = $total_fine + $row['total_fine'];
                                                  ?>
                                                <tr>
                                                    <td style="width:90px !important;"><?php echo date("F, Y",strtotime($row['month']));?></td>
                                                    <td><?php echo $row['total_vehicles']?></td>
                                                    <td> <?php echo $row['2ax_wl'];?> </td>
                                                    <td> <?php echo $row['3ax_wl'];?> </td>
                                                    <td><?php echo $row['456ax_wl'];?> </td>
                                                    <td> <?php echo $row['total_wl'];?></td>
                                                    <td> <?php echo $row['2ax_ol'];?> </td>
                                                    <td> <?php echo $row['3ax_ol'];?> </td>
                                                    <td> <?php echo $row['456ax_ol'];?> </td>
                                                    <td> <?php echo $row['total_ol'];?> </td>
                                                    <td> <?php echo $row['total_fine']?> </td> 
                                                </tr>
                                                <?php } 
                                                ?>
                                                <tr>
                                                    <td style="font-weight: 900;font-size: 14px;">Total</td>
                                                    <td style="font-weight: 900;font-size: 14px;"><?php echo array_sum(array_column($weighstation, 'total_vehicles'));//echo $total; ?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '2ax_wl'));//$two_ax_inload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '3ax_wl'));//$three_ax_inload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '456ax_wl'));//$ffs_ax_inload_total ;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, 'total_wl'));//$inload_total;?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '2ax_ol'));//$two_ax_overload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '3ax_ol'));//$three_ax_overload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '456ax_ol'));//$ffs_ax_overload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, 'total_ol'));//$overload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, 'total_fine'));//echo $total_fine;?> </td>   
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 900;font-size: 14px;">Average</td>
                                                    <td style="font-weight: 900;font-size: 14px;"><?php echo round($total / $entries,2); ?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo round($two_ax_inload_total / $entries,2);?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo round($three_ax_inload_total / $entries,2);?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo round($ffs_ax_inload_total / $entries,2) ;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo round($inload_total / $entries,2);?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo round($two_ax_overload_total / $entries,2);?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo round($three_ax_overload_total/ $entries,2);?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo round($ffs_ax_overload_total/ $entries,2);?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo round($overload_total/ $entries,2);?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo round($total_fine/ $entries,2);?> </td> 
                                                </tr>
                                               <tr>
                                                    <td style="font-weight: 900;font-size: 14px;">Maximum</td>
                                                    <td style="font-weight: 900;font-size: 14px;"><?php  echo max(array_map(function($a) { return $a['total_vehicles']; }, $weighstation));?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['2ax_wl']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['3ax_wl']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['456ax_wl']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['total_wl']; }, $weighstation));?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['2ax_ol']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['3ax_ol']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['456ax_ol']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['total_ol']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['total_fine']; }, $weighstation));?> </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 900;font-size: 14px;">Minimum</td>
                                                    <td style="font-weight: 900;font-size: 14px;"><?php  echo min(array_map(function($a) { return $a['total_vehicles']; }, $weighstation));?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['2ax_wl']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['3ax_wl']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['456ax_wl']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['total_wl']; }, $weighstation));?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['2ax_ol']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['3ax_ol']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['456ax_ol']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['total_ol']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['total_fine']; }, $weighstation));?> </td>
                                                </tr>
                                                <?php 
                                                }else{
                                                ?>
                                                <tr>
                                                  <td colspan=11>
                                                    No record Found
                                                  </td>
                                                </tr>
                                                <?php 
                                                } 
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
            startDate: "<?php echo $dates['start_date']?>",
            autoclose: true,
            endDate: "<?php echo $dates['end_date']?>"
         });
  });
    </script>
        <!-- footer area start-->
   <?php include('includes/footer.php')?>      