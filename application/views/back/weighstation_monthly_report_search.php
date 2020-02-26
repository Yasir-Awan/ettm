<div class="row" style="margin-bottom:1%;">
                                              <div class="col-md-12">
                                                  <?php if($weighstation){?>
                                                      <a href="<?php echo base_url()?>admin/monthly_weighstation_pdf/<?php echo $weigh;?>/<?php echo $weighstation[0]['date'];?>" class="btn btn-success btn-sm pull-right" target="__blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp;Generate PDF</a>
                                                  <?php } ?>
                                              </div>
                                          </div>
                                        <table id="dataTable3" class="text-center table table-bordered"> <span class="pull-right">Dated:<?php echo date('d-m-Y');?></span>
                                           
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
                                                        foreach($weighstation as $row){

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
                                                          }
                                                ?>
                                            </tbody>
                                        </table>
    <script>
    $(document).ready(function(){
        $('#dataTable3').DataTable();
       
    });
    </script>