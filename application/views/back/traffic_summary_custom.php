
          <?php 
            // echo "<pre>";
            // print_r(count($data)); exit;
            //if(count($data) > 1){}
            //$plaza_name = $this->db->get_where('toolplaza',array('id' => $dtr[0][0]['toolplaza']))->row()->name;
            //$omc_name   = $this->db->get_where('omc',array('id' => $dtr[0][0]['omc']))->row()->name;
            //$exempt = $this->db->get_where('dtr_exempt',array('dtr_id' => $dtr[0][0]['id']))->result_array();
          ?>
            <!-- page title area end -->
            
                <div class="row">
                    <div class="col-lg-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice-area">
                                    <div class="invoice-head">
                                        <div class="row">
                                            <div class="iv-left col-3">
                                            <div class="logo">
                                                <a href="invoice.php"><img src="<?php echo base_url()?>assets/back/images/icon/logo.png" alt="logo"></a>
                                             </div>
                                            </div>
                                            <div class="iv-right col-9 text-md-center">
                                                <div class"row">
                                                    <div class="col-md-12">
                                                        <span><h5 style="color: #030a10; ">DAILY TRAFFIC REPORT (DTR) SUMMARY FOR N.H.A</h5></span><br/>
                                                        <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">PLAZA NAME</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 40%;">
                                                         <?php if(!empty($data[0]['records'])){ 
                                                                 $plaza_name = $this->db->get_where('toolplaza',array('id' => $data[0]['records'][0]['toolplaza']))->row()->name;
                                                                echo $plaza_name;
                                                                 }
                                                    ?>
                                                        </span><br/>
                                                        
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <?php foreach($data as $row){
                                            
                                            $class1_total_traffic = $class2_total_traffic = $class3_total_traffic = $class4_total_traffic = $class5_total_traffic = $class6_total_traffic = $class7_total_traffic = $class8_total_traffic = $class9_total_traffic = $class10_total_traffic = 0;
                                            $class1_total_exempt = $class2_total_exempt = $class3_total_exempt = $class4_total_exempt = $class5_total_exempt = $class6_total_exempt = $class7_total_exempt = $class8_total_exempt = $class9_total_exempt = $class10_total_exempt = 0;
                                            $class1_total_revenue = $class2_total_revenue = $class3_total_revenue = $class4_total_revenue = $class5_total_revenue = $class6_total_revenue = $class7_total_revenue = $class8_total_revenue = $class9_total_revenue = $class10_total_revenue = 0;
                                            foreach($row['records'] as $sub_row){
                                               
                                                $class1_total_traffic +=  $sub_row['class1'];
                                                $class2_total_traffic +=  $sub_row['class2'];
                                                $class3_total_traffic +=  $sub_row['class3'];
                                                $class4_total_traffic +=  $sub_row['class4'];
                                                $class5_total_traffic +=  $sub_row['class5'];
                                                $class6_total_traffic +=  $sub_row['class6'];
                                                $class7_total_traffic +=  $sub_row['class7'];
                                                $class8_total_traffic +=  $sub_row['class8'];
                                                $class9_total_traffic +=  $sub_row['class9'];
                                                $class10_total_traffic +=  $sub_row['class10'];
                                                $class1_total_exempt += $sub_row['class1_exempt'];
                                                $class2_total_exempt += $sub_row['class2_exempt'];
                                                $class3_total_exempt += $sub_row['class3_exempt'];
                                                $class4_total_exempt += $sub_row['class4_exempt'];
                                                $class5_total_exempt += $sub_row['class5_exempt'];
                                                $class6_total_exempt += $sub_row['class6_exempt'];
                                                $class7_total_exempt += $sub_row['class7_exempt'];
                                                $class8_total_exempt += $sub_row['class8_exempt'];
                                                $class9_total_exempt += $sub_row['class9_exempt']; 
                                                $class10_total_exempt += $sub_row['class10_exempt'];
                                                
                                            }
                                            //exit;

                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                    <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 40%;">OMC:</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 40%; float:right;">
                                                    
                                                    
                                                    <?php if(!empty($row['records'])){ 
                                                              $omc_name   = $this->db->get_where('omc',array('id' => $row['records'][0]['omc']))->row()->name;
                                                              echo $omc_name;
                                                          }
                                                    ?>
                                                    

                                                    </span><br/>
                                                   <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 40%;">From:</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 40%; float:right;"><?php echo date("j F, Y",strtotime($row['records'][0]['for_date']));?></span><br/>
                                                    <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 40%;">To:</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 40%; float:right;"><?php echo date("j F, Y",strtotime(end($row['records'])['for_date']));?></span>
                                                             
                                            </div>
                                        </div>
                                        <div class="invoice-table table-responsive mt-5">
                                            <table class="table table-bordered table-hover text-right">
                                                <thead>
                                                    <tr class="text-capitalize">
                                                       
                                                        <th class="text-left" style="width: ; min-width: px;">Description</th>
                                                    
                                                        <th>Class-1</th>
                                                        <th>Class-2</th>
                                                        <th>Class-3</th>
                                                        <th>Class-4</th>
                                                        <th>Class-5</th>
                                                        <th>Class-6</th>
                                                        <th>Class-7</th>
                                                        <th>Class-8</th>
                                                        <th>Class-9</th>
                                                        <th>Class-10</th>                                                    
                                                        <th>total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(!empty($row['records'])){ ?>

                                                    
                                                            <tr>
                                                                <td class="text-center">Traffic</td>
                                                            
                                                                <td><?php echo number_format($class1_total_traffic);?></td>
                                                                <td><?php echo number_format($class2_total_traffic);?></td>
                                                                <td><?php echo number_format($class3_total_traffic);?></td>
                                                                <td><?php echo number_format($class4_total_traffic);?></td>
                                                                <td><?php echo number_format($class5_total_traffic);?></td>
                                                                <td><?php echo number_format($class6_total_traffic);?></td>
                                                                <td><?php echo number_format($class7_total_traffic);?></td>
                                                                <td><?php echo number_format($class8_total_traffic);?></td>
                                                                <td><?php echo number_format($class9_total_traffic);?></td>
                                                                <td><?php echo number_format($class10_total_traffic);?></td>
                                                                
                                                                <td><?php echo ($class1_total_traffic + $class2_total_traffic + $class3_total_traffic + $class4_total_traffic + $class5_total_traffic + $class6_total_traffic + $class7_total_traffic + $class8_total_traffic + $class9_total_traffic + $class10_total_traffic);?></td>
                                                            </tr>
                                                            <?php 
                                                                if($class1_total_exempt > 0 || $class2_total_exempt > 0 || $class3_total_exempt > 0 || $class4_total_exempt > 0 || $class5_total_exempt > 0 || $class6_total_exempt > 0 || $class7_total_exempt > 0 || $class8_total_exempt > 0 || $class9_total_exempt > 0 || $class10_total_exempt > 0 ){
                                                
                                                            ?>
                                                                <tr>
                                                                
                                                                <td class="text-center">Exempt</td>
                                                               
                                                                <td><?php echo number_format($class1_total_exempt);?></td>
                                                                <td><?php echo number_format($class2_total_exempt);?></td>
                                                                <td><?php echo number_format($class3_total_exempt);?></td>
                                                                <td><?php echo number_format($class4_total_exempt);?></td>
                                                                <td><?php echo number_format($class5_total_exempt);?></td>
                                                                <td><?php echo number_format($class6_total_exempt);?></td>
                                                                <td><?php echo number_format($class7_total_exempt);?></td>
                                                                <td><?php echo number_format($class8_total_exempt);?></td>
                                                                <td><?php echo number_format($class9_total_exempt);?></td>
                                                                <td><?php echo number_format($class10_total_exempt);?></td>
                                        
                                                                <td><?php echo number_format($class1_total_exempt  + $class2_total_exempt + $class3_total_exempt + $class4_total_exempt + $class5_total_exempt + $class6_total_exempt + $class7_total_exempt + $class8_total_exempt  + $class9_total_exempt + $class10_total_exempt);?></td>
                                                                
                                                                
                                                                 
                                                            </tr>
                                                            <?php    }?>
                                                            <tr>
                                                                
                                                                <td class="text-center">Revenue</td>
                                                               
                                                               <?php 
                                                                    if($class1_total_exempt > 0 || $class2_total_exempt > 0 || $class3_total_exempt > 0 || $class4_total_exempt > 0 || $class5_total_exempt > 0 || $class6_total_exempt > 0 || $class7_total_exempt > 0 || $class8_total_exempt > 0 || $class9_total_exempt > 0 || $class10_total_exempt > 0 ){
                                                
                                                               ?>
                                                                <td><?php
                                                                $class1_total_revenue = ($class1_total_traffic - $class1_total_exempt) * $row['terrif'][0]['class_1_value'];
                                                                 echo number_format($class1_total_revenue);?></td>
                                                                <td><?php
                                                                 $class2_total_revenue = ($class2_total_traffic - $class2_total_exempt) * $row['terrif'][0]['class_2_value'];
                                                                 echo number_format($class2_total_revenue);?></td>
                                                                <td><?php 
                                                                $class3_total_revenue = ($class3_total_traffic - $class3_total_exempt) * $row['terrif'][0]['class_3_value'];
                                                                echo number_format($class3_total_revenue);?></td>
                                                                <td><?php 
                                                                $class4_total_revenue = ($class4_total_traffic - $class4_total_exempt) * $row['terrif'][0]['class_4_value'];
                                                                echo number_format($class4_total_revenue);?></td>
                                                                <td><?php 
                                                                $class5_total_revenue = ($class5_total_traffic - $class5_total_exempt) * $row['terrif'][0]['class_5_value'];
                                                                echo number_format($class5_total_revenue);?></td>
                                                                <td><?php 
                                                                $class6_total_revenue = ($class6_total_traffic - $class6_total_exempt) * $row['terrif'][0]['class_6_value'];
                                                                echo number_format($class6_total_revenue);?></td>
                                                                <td><?php 
                                                                $class7_total_revenue = ($class7_total_traffic - $class7_total_exempt) * $row['terrif'][0]['class_7_value'];
                                                                echo number_format($class7_total_revenue);?></td>
                                                                <td><?php 
                                                                $class8_total_revenue = ($class8_total_traffic - $class8_total_exempt) * $row['terrif'][0]['class_8_value'];
                                                                echo number_format($class8_total_revenue);?></td>
                                                                <td><?php 
                                                                $class9_total_revenue = ($class9_total_traffic - $class9_total_exempt) * $row['terrif'][0]['class_9_value'];
                                                                echo number_format($class9_total_revenue);?></td>
                                                                <td><?php 
                                                                $class10_total_revenue = ($class10_total_traffic - $class10_total_exempt)* $row['terrif'][0]['class_10_value'];
                                                                echo number_format($class10_total_revenue);?></td>
                                                                <td><?php 
                                                                
                                                                echo number_format($class1_total_revenue + $class2_total_revenue + $class3_total_revenue + $class4_total_revenue + $class5_total_revenue + $class6_total_revenue + $class7_total_revenue + $class8_total_revenue + $class9_total_revenue + $class10_total_revenue);?></td>
                                                                
                                                               <?php }else{?>
                                                                    <td><?php
                                                                $class1_total_revenue = $class1_total_traffic  * $row['terrif'][0]['class_1_value'];
                                                                 echo number_format($class1_total_revenue);?></td>
                                                                <td><?php
                                                                 $class2_total_revenue = $class2_total_traffic * $row['terrif'][0]['class_2_value'];
                                                                 echo number_format($class2_total_revenue);?></td>
                                                                <td><?php 
                                                                $class3_total_revenue = $class3_total_traffic * $row['terrif'][0]['class_3_value'];
                                                                echo number_format($class3_total_revenue);?></td>
                                                                <td><?php 
                                                                $class4_total_revenue = $class4_total_traffic * $row['terrif'][0]['class_4_value'];
                                                                echo number_format($class4_total_revenue);?></td>
                                                                <td><?php 
                                                                $class5_total_revenue = $class5_total_traffic * $row['terrif'][0]['class_5_value'];
                                                                echo number_format($class5_total_revenue);?></td>
                                                                <td><?php 
                                                                $class6_total_revenue = $class6_total_traffic * $row['terrif'][0]['class_6_value'];
                                                                echo number_format($class6_total_revenue);?></td>
                                                                <td><?php 
                                                                $class7_total_revenue = $class7_total_traffic * $row['terrif'][0]['class_7_value'];
                                                                echo number_format($class7_total_revenue);?></td>
                                                                <td><?php 
                                                                $class8_total_revenue = $class8_total_traffic * $row['terrif'][0]['class_8_value'];
                                                                echo number_format($class8_total_revenue);?></td>
                                                                <td><?php 
                                                                $class9_total_revenue = $class9_total_traffic * $row['terrif'][0]['class_9_value'];
                                                                echo number_format($class9_total_revenue);?></td>
                                                                <td><?php 
                                                                $class10_total_revenue = $class10_total_traffic * $row['terrif'][0]['class_10_value'];
                                                                echo number_format($class10_total_revenue);?></td>
                                                                <td><?php 
                                                                
                                                                echo number_format($class1_total_revenue + $class2_total_revenue + $class3_total_revenue + $class4_total_revenue + $class5_total_revenue + $class6_total_revenue + $class7_total_revenue + $class8_total_revenue + $class9_total_revenue + $class10_total_revenue);?></td>
                                                               <?php } ?>
                                                                
                                                            </tr>
                                                    <?php }else{?>
                                                        <tr class="text-capitalize">
                                                       
                                                        <td colspan="12" style="text-align: center;"><h3 class="text-danger">No records found </h3></td>
                                                    
                                                        
                                                    </tr>

                                                    <?php } ?>
                                                </tbody>
                                                
                                            </table>


                                        </div>
                                    <?php } ?>

                                </div>
                                
                               
                                </div>
                                <?php if(!empty($data[0]['records'])){

                                 ?>
                                                          
                                    <a href="<?php echo base_url()?>admin/traffic_summary_custom_pdf/<?php echo $data[0]['records'][0]['toolplaza'];?>/<?php echo $data[0]['start_date'];?>/<?php echo $data[0]['end_date'];?>" class="btn btn-info pull-right"><i class="fa fa-file-pdf-o"></i> &nbsp;Generate PDF</a>
                                <?php } ?> 
                            </div>
                        </div>
                    </div>
                </div>
 