
          <?php 
            $weighstation_name = $this->db->get_where('weighstation',array('id' => $weighstation[0]['weigh_id']))->row()->name;
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
                                                            <span><h1 style="color: #030a10; font-size:16px;">Daily Activity Report</h1></span><br/>
                                                            <table>
                                                                <tr style="text-align:center;">
                                                                    <td width="40%">
                                                                        <span style="font-size:14px;">Weigh Station&nbsp;&nbsp;:</span>
                                                                    </td>
                                                                    <td text-align="left">
                                                                        <span style="font-size:14px;text-align:left"><?php echo $weighstation_name;?></span>
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
                                             
                                    
                                       <table border="1px solid;" text-align="center">
                                            <thead>
                                                <tr class="text-capitalize" style="text-align:center; background-color:#cccccc;">
                                                   <th width="10%"><div style="line-height:20px;font-size:14px;">Date</div></th>
                                                    <th class="text-center"><div style="line-height:20px;font-size:14px;">Time</div></th>
                                                    <th><div style="line-height:20px;font-size:14px;">Ticket No</div></th>
                                                    <th><div style="line-height:20px;font-size:14px;">Vehicle No</div></th>
                                                    <th><div style="line-height:20px;font-size:14px;">Haulier Name</div></th>
                                                    <th><div style="line-height:20px;font-size:14px;">Gross Weight Ton</div></th>
                                                    <th><div style="line-height:20px;font-size:14px;">Excess Weight Ton</div></th>
                                                    <th><div style="line-height:20px;font-size:14px;">% Overload</div></th>
                                                    <th><div style="line-height:20px;font-size:14px;">Fine</div></th>
                                                    <th><div style="line-height:20px;font-size:14px;">Status</div></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if($weighstation){
              
                                                        foreach($weighstation as $row){
                                                ?>
                                                <tr style="text-align:center;">
                                                    <td ><div style="width:10%;line-height:20px; font-size:11px;"><?php echo date('d-m-Y',strtotime($row['date']));?></div></td>
                                                    <td><div style="line-height:20px; font-size:11px;"><?php echo $row['time'];?></div></td>
                                                    <td><div style="line-height:20px; font-size:11px;"><?php echo $row['ticket_no'];?></div></td>
                                                    <td><div style="line-height:20px; font-size:11px;"><?php echo $row['vehicle_no'];?></div></td>
                                                    <td><div style="line-height:20px; font-size:11px;"><?php echo $row['haulier'];?></div></td>
                                                    <td><div style="line-height:20px; font-size:11px;"><?php echo $row['weight'];?></div></td>
                                                    <td><div style="line-height:20px; font-size:11px;"><?php echo $row['exces_weight'];?></div></td>
                                                    <td><div style="line-height:20px; font-size:11px;"><?php echo $row['percent_overload'];?></div></td>
                                                    <td><div style="line-height:20px; font-size:11px;"><?php echo $row['fine'];?></div></td>
                                                    <td><div style="line-height:20px; font-size:11px;"><?php if($row['status'] == 2){echo "Overload";}else{echo "Ok";}?></div></td>
                
                                                </tr>
                                                 <?php 
                                             }
                                               }     
                                                ?>
                                                

                                            </tbody>
                                            
                                        </table>
                                    
                                    
                       
        
   
