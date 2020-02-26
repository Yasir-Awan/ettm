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
            $plaza_name = $this->db->get_where('toolplaza',array('id' => $dtr[0]['toolplaza']))->row()->name;
            $omc_name   = $this->db->get_where('omc',array('id' => $dtr[0]['omc']))->row()->name;
             $exempt = $this->db->get_where('dtr_exempt',array('dtr_id' => $dtr[0]['id']))->result_array();
          ?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice-area">
                                    <div class="invoice-head">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table>
                                                    <tr>
                                                        <td width="30%">
                                                            <img src="<?php echo base_url()?>assets/back/images/icon/logo.png" alt="logo"/>
                                                        </td>
                                                        <td>
                                                            <span><h1 style="color: #030a10; font-size:26px; ">Daily TRFFIC REPORT (DTR) SUMMARY FOR N.H.A</h1></span><br/>
                                                            <table>
                                                                <tr style="text-align:center;">
                                                                    <td width="30%">
                                                                        <span style="font-size:18px;">PLAZA NAME</span>
                                                                    </td>
                                                                    <td>
                                                                        <span style="font-size:18px;"><?php echo $plaza_name;?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr style="text-align:center;">
                                                                    <td width="30%">
                                                                        <span style="font-size:18px;">OMC</span>
                                                                    </td>
                                                                    <td>
                                                                        <span style="font-size:18px;"><?php echo $omc_name;?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr style="text-align:center;">
                                                                    <td width="30%">
                                                                        <span style="font-size:18px;">Date</span>
                                                                    </td>
                                                                    <td>
                                                                                <span style="font-size:18px;"><?php echo date("j, F, Y",strtotime($dtr[0]['for_date']));?></span>
                                                                        
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            
                                    </div>
                                    
                                    <div class="invoice-table table-responsive mt-5">
                                        <table class="table table-bordered table-hover" border="1px solid;" text-align="center">
                                            <thead>
                                                <tr class="text-capitalize" style="text-align:center; background-color:#cccccc;">
                                                   
                                                    <th><div style="line-height:40px">Description</div></th>
                                                    <th class="text-center"><div style="line-height:40px">Notes</div></th>
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
                                                <tr style="text-align:center;">
                                                    <td><div style="line-height:30px"><?php echo $dtr[0]['description'];?></div></td>
                                                    <td><div style="line-height:30px"><?php echo $dtr[0]['notes'];?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class1']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class2']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class3']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class4']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class5']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class6']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class7']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class8']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class9']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class10']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['total']);?></div></td>
                                                </tr>
                                                 <?php 
                                                    if($exempt){
                                                ?>
                                                    <tr style="text-align:center;">
                                                    
                                                    <td><div style="line-height:30px"><?php echo $exempt[0]['description']?></div></td>
                                                    <td><div style="line-height:30px"><?php echo $exempt[0]['notes']?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class1']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class2']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class3']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class4']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class5']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class6']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class7']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class8']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class9']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class10']);?></div></td>
                            
                                                    <td><div style="line-height:30px"><?php echo number_format($exempt[0]['class1']  + $exempt[0]['class2'] + $exempt[0]['class3'] + $exempt[0]['class4'] + $exempt[0]['class5'] + $exempt[0]['class6'] + $exempt[0]['class7'] + $exempt[0]['class8']  + $exempt[0]['class9']  + $exempt[0]['class10']);?></div></td>
                                                    
                                                    
                                                     
                                                </tr>
                                                <?php    }?>
                                                <tr style="text-align:center;">
                                                    <?php 
                                                        if($terrif){
                                                    ?>
                                                     <?php 
                                                        if($exempt){
                                                   ?>
                                                   <td><div style="line-height:30px">Revenue</div></td>
                                                    <td><div style="line-height:30px"></div></td>
                                                   <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class1'] - $exempt[0]['class1']) * $terrif[0]['class_1_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class2'] - $exempt[0]['class2']) * $terrif[0]['class_2_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class3'] - $exempt[0]['class3']) * $terrif[0]['class_3_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class4'] - $exempt[0]['class4']) * $terrif[0]['class_4_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class5'] - $exempt[0]['class5']) * $terrif[0]['class_5_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class6'] - $exempt[0]['class6']) * $terrif[0]['class_6_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class7'] - $exempt[0]['class7']) * $terrif[0]['class_7_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class8'] - $exempt[0]['class8']) * $terrif[0]['class_8_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class9'] - $exempt[0]['class9']) * $terrif[0]['class_9_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class10'] - $exempt[0]['class10'])* $terrif[0]['class_10_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format((($dtr[0]['class1'] - $exempt[0]['class1']) * $terrif[0]['class_1_value']) + (($dtr[0]['class2'] - $exempt[0]['class2']) * $terrif[0]['class_2_value']) + (($dtr[0]['class3'] - $exempt[0]['class3']) * $terrif[0]['class_3_value']) + (($dtr[0]['class4'] - $exempt[0]['class4']) * $terrif[0]['class_4_value']) + (($dtr[0]['class5'] - $exempt[0]['class5']) * $terrif[0]['class_5_value']) + (($dtr[0]['class6'] - $exempt[0]['class6']) * $terrif[0]['class_6_value']) + (($dtr[0]['class7'] - $exempt[0]['class7']) * $terrif[0]['class_7_value']) + (($dtr[0]['class8'] - $exempt[0]['class8']) * $terrif[0]['class_8_value']) + (($dtr[0]['class9'] - $exempt[0]['class9']) * $terrif[0]['class_9_value']) + (($dtr[0]['class10'] - $exempt[0]['class10']) * $terrif[0]['class_10_value']));?></div></td>
                                                    
                                                   <?php }else{?>
                                                    <td><div style="line-height:30px">Revenue</div></td>
                                                    <td><div style="line-height:30px"></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class1'] * $terrif[0]['class_1_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class2'] * $terrif[0]['class_2_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class3'] * $terrif[0]['class_3_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class4'] * $terrif[0]['class_4_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class5'] * $terrif[0]['class_5_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class6'] * $terrif[0]['class_6_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class7'] * $terrif[0]['class_7_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class8'] * $terrif[0]['class_8_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class9'] * $terrif[0]['class_9_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format($dtr[0]['class10'] * $terrif[0]['class_10_value']);?></div></td>
                                                    <td><div style="line-height:30px"><?php echo number_format(($dtr[0]['class1'] * $terrif[0]['class_1_value']) + ($dtr[0]['class2'] * $terrif[0]['class_2_value']) + ($dtr[0]['class3'] * $terrif[0]['class_3_value']) + ($dtr[0]['class4'] * $terrif[0]['class_4_value']) + ($dtr[0]['class5'] * $terrif[0]['class_5_value']) + ($dtr[0]['class6'] * $terrif[0]['class_6_value']) + ($dtr[0]['class7'] * $terrif[0]['class_7_value']) + ($dtr[0]['class8'] * $terrif[0]['class_8_value']) + ($dtr[0]['class9'] * $terrif[0]['class_9_value']) + ($dtr[0]['class10'] * $terrif[0]['class_10_value']));?></div></td>
                                               <?php } }else{?>
                                                    <td colspan="13"><div style="line-height:30px; color: #e60c0c;">Tarrif for this dtr is not added yet.</div></td>
                                               <?php }?>
                                                </tr>

                                            </tbody>
                                            
                                        </table>
                                    </div>
                                    <div class="invoice-table table-responsive" style="width:30%;">
                                        <table class="table table-bordered table-hover" border="1px solid;" text-align="center" width="30%" padding="200px">
                                            <thead>
                                                <tr class="text-capitalize" style="text-align:center; background-color:#cccccc;">
                                                   
                                                    <th width="60%"><div style="line-height:40px">Vehicle Class</div></th>
                                                    <th width="40%"><div style="line-height:40px">Tariff</div></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                        if($terrif){
                                                    ?>
                                                <tr>
                                                    <td width="60%" style="padding-top:20px;"><div style="line-height:30px"><?php echo $terrif[0]['class_1_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs<?php echo $terrif[0]['class_1_value']; ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $terrif[0]['class_2_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $terrif[0]['class_2_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $terrif[0]['class_3_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $terrif[0]['class_3_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $terrif[0]['class_4_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $terrif[0]['class_4_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $terrif[0]['class_5_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $terrif[0]['class_5_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $terrif[0]['class_6_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $terrif[0]['class_6_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $terrif[0]['class_7_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $terrif[0]['class_7_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $terrif[0]['class_8_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $terrif[0]['class_8_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $terrif[0]['class_9_description'];?></div></td>
                                                    <td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $terrif[0]['class_9_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td width="60%"><div style="line-height:30px"><?php echo $terrif[0]['class_10_description'];?></div></td>
                                                    <td  width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $terrif[0]['class_10_value'] ?>&nbsp;&nbsp;&nbsp;</div></td>
                                                   
                                                </tr>
                                                <?php }else{?>
                                                <tr>
                                                    <td width="100%" colspan="2"><div style="text-align: center; line-height:30px; color: #e60c0c;">Tarrif for this dtr is not added yet.</div></td>
                                                    
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                               
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                    
                                    
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="<?php echo base_url()?>assets/back/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    
    <script src="<?php echo base_url()?>assets/back/js/bootstrap.min.js"></script>
    
</body>