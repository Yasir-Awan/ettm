<style>
.sfp{
    font-size:12 px;
    font-weight: 800;
    line-height: 20 px;
}
</style>
         <?php 
                        $weigh_name = $this->db->get_where('weighstation',array('id' => $weigh))->row()->name;


                    ?>
            <!-- page title area end -->
            
                         <table>
                                                    <tr>
                                                        <td width="20%">
                                                            <br/>
                                                           <img src="<?php echo base_url()?>assets/back/images/icon/logo.png" alt="logo"/>
                                                        </td>
                                                        <td width="60%"><div style="text-align:center;">
                                                            <br><br>
                                                            <span><h1 style="color: #030a10; font-size:16px;">Monthly Activity Report</h1></span><br/>
                                                            <table>
                                                                <tr style="text-align:center;">
                                                                    <td width="40%">
                                                                        <span style="font-size:14px;">Weigh Station&nbsp;&nbsp;:</span>
                                                                    </td>
                                                                    <td text-align="left">
                                                                        <span style="font-size:14px;text-align:left"><?php echo $weigh_name;?></span>
                                                                    </td>
                                                                </tr>
                                                                 <tr style="text-align:center;">
                                                                    <td width="40%">
                                                                        <span style="font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date &nbsp;:</span>
                                                                    </td>
                                                                    <td width="60%" text-align="left">
                                                                        <span style="font-size:14px;text-align:left"><?php echo date("F j, Y", strtotime($weighstation[0]['date']));?></span>
                                                                    </td>
                                                                </tr>
                    
                                                                
                                                            </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                             
                                    
                                      <table border="0.5px solid" class="sfp" style="width:96%" > <!-- <span class="pull-right">Dated:<?php echo date('d-m-Y');?></span> -->
                                           
                                            <thead class="text-capitalize" >
                                                <tr>
                                                    <th rowspan="2" style="width: 14.1% !important;">Date</th>
                                                    <th rowspan="2">Total Trucks Weighed</th>
                                                    <th colspan="4" style="text-align:center"> Within Load Limit  </th>
                                                    <th colspan="4" style="text-align:center"> Overloaded </th>
                                                    <th rowspan="2"> Fine Amount (RS) </th>
                                                </tr>
                                                <tr>
                                                          <th style="font-size:12px;">2 Axle</th>
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
                                                    <td style="width:95px !important;"><?php echo date('d-m-Y',strtotime($row['date']));?></td>
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
                                    
                                    
                       
        
   
