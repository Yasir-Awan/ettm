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
                <td><?php echo $row['weight'];?></td>
                <td><?php echo $row['exces_weight'];?></td>
                <td><?php echo $row['percent_overload'];?></td>
                <td><?php echo $row['fine'];?></td>
                <td><?php if($row['status'] == 2){echo "Overload";}else{echo "Ok";}?></td>
                
            </tr> 
            <?php    }
            }?>
           
        </tbody>
    </table>
    <script>
    $(document).ready(function(){
        $('#dataTable3').DataTable();
        $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
        $("[data-toggle='toggle']").bootstrapToggle();
    })
    </script>