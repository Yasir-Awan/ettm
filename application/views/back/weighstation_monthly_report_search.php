<div class="row" style="margin-bottom:1%;">
                                              <div class="col-md-12">
                                                  <?php if($weighstation){?>
                                                      <a href="<?php echo base_url()?>admin/monthly_weighstation_pdf/<?php echo $weigh;?>/<?php echo $weighstation[0]['date'];?>" class="btn btn-success btn-sm pull-right" target="__blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp;Generate PDF</a>
                                                  <?php } ?>
                                              </div>
                                          </div>
                                        <table  class="text-center table table-bordered"> <span class="pull-right">Dated:<?php echo date('d-m-Y');?></span>
                                           
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
                                                          $two_ax_inload_total = $two_ax_inload_total + $row['2ax_inload'];
                                                          $three_ax_inload_total = $three_ax_inload_total + $row['3ax_inload'];
                                                          $ffs_ax_inload_total = $ffs_ax_inload_total + $row['456ax_inload'];
                                                          $inload_total = $inload_total + $row['total_vehicles_inload'];
                                                          $two_ax_overload_total = $two_ax_overload_total + $row['2ax_overloaded'];
                                                          $three_ax_overload_total = $three_ax_overload_total + $row['3ax_overloaded'];
                                                          $ffs_ax_overload_total = $ffs_ax_overload_total + $row['456ax_overloaded'];
                                                          $overload_total = $overload_total + $row['total_vehicles_overloaded'];
                                                          $total_fine = $total_fine + $row['total_fine'];
                                                  ?>
                                                <tr>
                                                    <td style="width:90px !important;"><?php echo date('d-m-Y',strtotime($row['date']));?></td>
                                                    <td><?php echo $row['total_vehicles']?></td>
                                                    <td> <?php echo $row['2ax_inload'];?> </td>
                                                    <td> <?php echo $row['3ax_inload'];?> </td>
                                                    <td><?php echo $row['456ax_inload'];?> </td>
                                                    <td> <?php echo $row['total_vehicles_inload'];?></td>
                                                    <td> <?php echo $row['2ax_overloaded'];?> </td>
                                                    <td> <?php echo $row['3ax_overloaded'];?> </td>
                                                    <td> <?php echo $row['456ax_overloaded'];?> </td>
                                                    <td> <?php echo $row['total_vehicles_overloaded'];?> </td>
                                                    
                                                    <td> <?php echo $row['total_fine']?> </td>
                                                </tr>
                                                <?php } 

                                                ?>
                                                <tr>
                                                    <td style="font-weight: 900;font-size: 14px;">Total</td>
                                                    <td style="font-weight: 900;font-size: 14px;"><?php echo array_sum(array_column($weighstation, 'total_vehicles'));//echo $total; ?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '2ax_inload'));//$two_ax_inload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '3ax_inload'));//$three_ax_inload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '456ax_inload'));//$ffs_ax_inload_total ;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, 'total_vehicles_inload'));//$inload_total;?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '2ax_overloaded'));//$two_ax_overload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '3ax_overloaded'));//$three_ax_overload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, '456ax_overloaded'));//$ffs_ax_overload_total;?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo array_sum(array_column($weighstation, 'total_vehicles_overloaded'));//$overload_total;?> </td>
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
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['2ax_inload']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['3ax_inload']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['456ax_inload']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['total_vehicles_inload']; }, $weighstation));?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['2ax_overloaded']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['3ax_overloaded']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['456ax_overloaded']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['total_vehicles_overloaded']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo max(array_map(function($a) { return $a['total_fine']; }, $weighstation));?> </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 900;font-size: 14px;">Minimum</td>
                                                    <td style="font-weight: 900;font-size: 14px;"><?php  echo min(array_map(function($a) { return $a['total_vehicles']; }, $weighstation));?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['2ax_inload']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['3ax_inload']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['456ax_inload']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['total_vehicles_inload']; }, $weighstation));?></td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['2ax_overloaded']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['3ax_overloaded']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['456ax_overloaded']; }, $weighstation));?> </td>
                                                    <td style="font-weight: 900;font-size: 14px;"> <?php echo min(array_map(function($a) { return $a['total_vehicles_overloaded']; }, $weighstation));?> </td>
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
                                                <?php } 

                                                ?>
                                            </tbody>
                                        </table>
    <script>
    $(document).ready(function(){
        $('#dataTable3').DataTable();
       
    });
    </script>