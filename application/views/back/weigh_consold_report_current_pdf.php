<style>
.sfp{
    font-size:10px;
    font-weight: 400;
    line-height: 18px;
}
</style>
  <div class="row">
      <div class="col-md-12">
          <h5 class="text-center">Summary of Truck Traffic of Weigh Stations for the month of <?php echo $record[0]['datemade'];?></h5>
              
        
      </div>
  </div>
  <table border="1px" class="sfp">
      <thead class="text-capitalize">
          <tr>
              <th rowspan="2">Date:<?php echo $record[0]['datemade'];?></th>
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
              <td width="100%"style="font-size: 14px;font-weight: 900;float:left;" colspan="11" ><?php echo $row['name'];?></td>

          </tr>
          <tr>
              <td>Total</td>
              <td><?php echo $row['total_vehicles']?></td>
              <td> <?php echo $row['2ax_inload'];?> </td>
              <td> <?php echo $row['3ax_inload'];?> </td>
              <td><?php echo ($row['4ax_inload'] + $row['5ax_inload'] + $row['6ax_inload']);?> </td>
              <td> <?php echo $row['total_vehicles_inload'];?></td>
              <td> <?php echo $row['2ax_overloaded'];?> </td>
              <td> <?php echo $row['3ax_overloaded'];?> </td>
              <td> <?php echo ($row['4ax_overloaded'] + $row['5ax_overloaded'] + $row['6ax_overloaded']);?> </td>
              <td> <?php echo $row['total_vehicles_overloaded'];?> </td>
              <td > <?php echo $row['fined']?> </td>
              
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