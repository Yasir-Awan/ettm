<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Invoice - DTR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/responsive.css">
    <!-- modernizr css -->
</head>
<body>
          <?php 
            //$plaza_name = $this->db->get_where('toolplaza',array('id' => $dtr[0]['toolplaza']))->row()->name;
            //$omc_name   = $this->db->get_where('omc',array('id' => $dtr[0]['omc']))->row()->name;
             //$exempt = $this->db->get_where('dtr_exempt',array('dtr_id' => $dtr[0]['id']))->result_array();
          ?>
            <!-- page title area end -->
            <div class="main-content-inner">
               
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table>
                                                    <tr>
                                                        <td width="30%">
                                                            <img src="<?php echo base_url()?>assets/back/images/icon/logo.png" alt="logo"/>
                                                        </td>
                                                        <td>
                                                            <span><h1 style="color: #030a10; font-size:26px; ">Custom TRFFIC REPORT (DTR) SUMMARY FOR N.H.A</h1></span><br/>
                                                            <table>
                                                                <tr style="text-align:center;">
                                                                    <td width="30%">
                                                                        <span style="font-size:18px;">PLAZA NAME</span>
                                                                    </td>
                                                                    <td>
                                                                        <span style="font-size:18px;"><?php if(!empty($data[0]['records'])){ 
                                                                                     $plaza_name = $this->db->get_where('toolplaza',array('id' => $data[0]['records'][0]['toolplaza']))->row()->name;
                                                                                    echo $plaza_name;
                                                                                     }
                                                                        ?></span>
                                                                    </td>
                                                                </tr>
                                                                
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
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
                                     <table style="font-size:20px">
                                            <tr>
                                                <td>
                                                   <b> OMC: &nbsp;<?php if(!empty($row['records'])){ 
                                                              $omc_name   = $this->db->get_where('omc',array('id' => $row['records'][0]['omc']))->row()->name;
                                                              echo $omc_name;
                                                          }
                                                    ?></b>
                                                </td>
                                                <td>
                                                  <b> From: &nbsp;<?php echo date("j F, Y",strtotime($row['records'][0]['for_date']));?></b>
                                                </td>
                                                <td>
                                                    <b> To:&nbsp;<?php echo date("j F, Y",strtotime(end($row['records'])['for_date']));?></b>
                                                </td>
                                            </tr>
                                        </table><br/>
                                    <div class="invoice-table table-responsive mt-5" style="font-size:18; line-height:40px !important;">
                                        
                                       
                                        <table class="table table-bordered table-hover"  border="1px solid;" text-align="center">
                                            <thead>
                                                <tr class="text-capitalize" style="text-align:center; background-color:#cccccc;">
                                                   
                                                    <th><div style="line-height:40px">Description</div></th>
                                                    <th><div style="line-height:40px">Class-1</div></th>
                                                    <th><div style="line-height:40px">Class-2</div></th>
                                                    <th><div style="line-height:40px">Class-3</div></th>
                                                    <th><div style="line-height:40px">Class-4</div></th>
                                                    <th><div style="line-height:40px">Class-5</div></th>
                                                    <th><div style="line-height:40px">Class-6</div></th>
                                                    <th><div style="line-height:40px">Class-7</div></th>
                                                    <th><div style="line-height:40px">Class-8</div></th>
                                                    <th><div style="line-height:40px">Class-9</div></th>
                                                    <th><div style="line-height:40px">Class-10</div></th>                                                    
                                                    <th><div style="line-height:40px">total</div></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if(!empty($row['records'])){ ?>
                                              
                                               <tr style="text-align:center;">
                                                    <td><div style="line-height:30px">Traffic</div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class1_total_traffic);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class2_total_traffic);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class3_total_traffic);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class4_total_traffic);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class5_total_traffic);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class6_total_traffic);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class7_total_traffic);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class8_total_traffic);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class9_total_traffic);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class10_total_traffic);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo ($class1_total_traffic + $class2_total_traffic + $class3_total_traffic + $class4_total_traffic + $class5_total_traffic + $class6_total_traffic + $class7_total_traffic + $class8_total_traffic + $class9_total_traffic + $class10_total_traffic);?></div></td>
                                                </tr>
                                                <?php 
                                                    if($class1_total_exempt > 0 || $class2_total_exempt > 0 || $class3_total_exempt > 0 || $class4_total_exempt > 0 || $class5_total_exempt > 0 || $class6_total_exempt > 0 || $class7_total_exempt > 0 || $class8_total_exempt > 0 || $class9_total_exempt > 0 || $class10_total_exempt > 0 ){
                                                 ?>
                                                    <tr style="text-align:center;">
                                                    
                                                    <td><div style="line-height:30px">Exempt</div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class1_total_exempt);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class2_total_exempt);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class3_total_exempt);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class4_total_exempt);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class5_total_exempt);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class6_total_exempt);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class7_total_exempt);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class8_total_exempt);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class9_total_exempt);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class10_total_exempt);?></div></td>
                            
                                                    <td><div style="line-height:30px"><?php echo number_format($class1_total_exempt  + $class2_total_exempt + $class3_total_exempt + $class4_total_exempt + $class5_total_exempt + $class6_total_exempt + $class7_total_exempt + $class8_total_exempt  + $class9_total_exempt + $class10_total_exempt);?></div></td>
                                                    
                                                    
                                                     
                                                </tr>
                                                <?php    }?>
                                                <tr style="text-align:center;">
                                                     <?php 
                                                         if($class1_total_exempt > 0 || $class2_total_exempt > 0 || $class3_total_exempt > 0 || $class4_total_exempt > 0 || $class5_total_exempt > 0 || $class6_total_exempt > 0 || $class7_total_exempt > 0 || $class8_total_exempt > 0 || $class9_total_exempt > 0 || $class10_total_exempt > 0 ){
                                                
                                                    ?>
                                                   <td><div style="line-height:30px">Revenue</div></td>
                                                   <td><div style="line-height:30px"><?php
                                                                $class1_total_revenue = ($class1_total_traffic - $class1_total_exempt) * $row['terrif'][0]['class_1_value'];
                                                                 echo number_format($class1_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php
                                                                 $class2_total_revenue = ($class2_total_traffic - $class2_total_exempt) * $row['terrif'][0]['class_2_value'];
                                                                 echo number_format($class2_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class3_total_revenue = ($class3_total_traffic - $class3_total_exempt) * $row['terrif'][0]['class_3_value'];
                                                                echo number_format($class3_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class4_total_revenue = ($class4_total_traffic - $class4_total_exempt) * $row['terrif'][0]['class_4_value'];
                                                                echo number_format($class4_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class5_total_revenue = ($class5_total_traffic - $class5_total_exempt) * $row['terrif'][0]['class_5_value'];
                                                                echo number_format($class5_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class6_total_revenue = ($class6_total_traffic - $class6_total_exempt) * $row['terrif'][0]['class_6_value'];
                                                                echo number_format($class6_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class7_total_revenue = ($class7_total_traffic - $class7_total_exempt) * $row['terrif'][0]['class_7_value'];
                                                                echo number_format($class7_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class8_total_revenue = ($class8_total_traffic - $class8_total_exempt) * $row['terrif'][0]['class_8_value'];
                                                                echo number_format($class8_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class9_total_revenue = ($class9_total_traffic - $class9_total_exempt) * $row['terrif'][0]['class_9_value'];
                                                                echo number_format($class9_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class10_total_revenue = ($class10_total_traffic - $class10_total_exempt)* $row['terrif'][0]['class_10_value'];
                                                                echo number_format($class10_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class1_total_revenue + $class2_total_revenue + $class3_total_revenue + $class4_total_revenue + $class5_total_revenue + $class6_total_revenue + $class7_total_revenue + $class8_total_revenue + $class9_total_revenue + $class10_total_revenue);?></div></td>
                                                    
                                                   <?php }else{?>
                                                    <td><div style="line-height:30px">Revenue</div></td>
                                                  
                                                    <td><div style="line-height:30px"><?php
                                                                $class1_total_revenue = $class1_total_traffic  * $row['terrif'][0]['class_1_value'];
                                                                 echo number_format($class1_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php
                                                                 $class2_total_revenue = $class2_total_traffic * $row['terrif'][0]['class_2_value'];
                                                                 echo number_format($class2_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class3_total_revenue = $class3_total_traffic * $row['terrif'][0]['class_3_value'];
                                                                echo number_format($class3_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class4_total_revenue = $class4_total_traffic * $row['terrif'][0]['class_4_value'];
                                                                echo number_format($class4_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class5_total_revenue = $class5_total_traffic * $row['terrif'][0]['class_5_value'];
                                                                echo number_format($class5_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class6_total_revenue = $class6_total_traffic * $row['terrif'][0]['class_6_value'];
                                                                echo number_format($class6_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class7_total_revenue = $class7_total_traffic * $row['terrif'][0]['class_7_value'];
                                                                echo number_format($class7_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class8_total_revenue = $class8_total_traffic * $row['terrif'][0]['class_8_value'];
                                                                echo number_format($class8_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class9_total_revenue = $class9_total_traffic * $row['terrif'][0]['class_9_value'];
                                                                echo number_format($class9_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php 
                                                                $class10_total_revenue = $class10_total_traffic * $row['terrif'][0]['class_10_value'];
                                                                echo number_format($class10_total_revenue);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($class1_total_revenue + $class2_total_revenue + $class3_total_revenue + $class4_total_revenue + $class5_total_revenue + $class6_total_revenue + $class7_total_revenue + $class8_total_revenue + $class9_total_revenue + $class10_total_revenue);?></div></td>
                                               <?php }?>
                                                    
                                                </tr>
                                                <?php }else{?>
                                                        <tr class="text-capitalize" style="text-align:center;">
                                                       
                                                            <td colspan="13"><div style="line-height:30px; color: #e60c0c;">Tarrif for this dtr is not added yet.</div></td>
                                                        </tr>
                                                <?php } ?>
                                            </tbody>
                                            
                                        </table>
                                    </div><br/>
                                    <?php } ?>

                                    <table>
                                        <tr>
                                    <?php
                                    if(!empty($data[0]['records'])){
                                     foreach($data as $row){?>
                                        <td width="50%">
                                        <div class="invoice-table table-responsive" style="width:100%;">
                                        <table class="table table-bordered table-hover" border="1px solid;" text-align="center" width="100%" padding="200px">
                                            <thead>
                                                <tr class="text-capitalize" style="text-align:center; background-color:#cccccc;">
                                                   
                                                    <th width="60%"><div style="line-height:40px">Vehicle Class</div></th>
                                                    <th width="40%"><div style="line-height:40px">Tariff</div></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                                <tr>
                                                    <td width="60%" style="padding-top:20px;"><div style="line-height:30px"><?php echo $row['terrif'][0]['class_1_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs<?php echo $row['terrif'][0]['class_1_value']; ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $row['terrif'][0]['class_2_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $row['terrif'][0]['class_2_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $row['terrif'][0]['class_3_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $row['terrif'][0]['class_3_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $row['terrif'][0]['class_4_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $row['terrif'][0]['class_4_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $row['terrif'][0]['class_5_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $row['terrif'][0]['class_5_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $row['terrif'][0]['class_6_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $row['terrif'][0]['class_6_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $row['terrif'][0]['class_7_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $row['terrif'][0]['class_7_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $row['terrif'][0]['class_8_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $row['terrif'][0]['class_8_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $row['terrif'][0]['class_9_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $row['terrif'][0]['class_9_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $row['terrif'][0]['class_10_description'];?></div></td>
                                                    <td  width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $row['terrif'][0]['class_10_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:50px;font-size:20">Effective From</div></td>
                                                    <td  width="40%" style="text-align:right;"><div style="line-height:50px;font-size:20"> <?php  echo date("j F, Y",strtotime($row['terrif'][0]['start_date']));?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:50px; font-size:20">Effective To</div></td>
                                                    <td  width="40%" style="text-align:right;"><div style="line-height:50px;font-size:20"><?php echo date("j F, Y",strtotime($row['terrif'][0]['end_date']));?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                               
                                            </tfoot>
                                        </table>
                                        </div>
                                        </td>
                                    <?php } 
                                        }
                                    ?>
                                </tr>
                            </table>
                     </div>

                                    
                                    
                   
                  
        </div>
    <script src="<?php echo base_url()?>assets/back/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    
    <script src="<?php echo base_url()?>assets/back/js/bootstrap.min.js"></script>
    
</body>