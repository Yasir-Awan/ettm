<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Invoice - MTR</title>
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
            $plaza_name = $this->db->get_where('toolplaza',array('id' => $mtr[0]['toolplaza']))->row()->name;
            $omc_name   = $this->db->get_where('omc',array('id' => $mtr[0]['omc']))->row()->name;
            $exempt = $this->db->get_where('exempt',array('mtr_id' => $mtr[0]['id']))->result_array();
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
                                            <div class="iv-left col-3">
                                            <div class="logo">
                                                <a href="invoice.php"><img src="<?php echo base_url()?>assets/back/images/icon/logo.png" alt="logo"></a>
                                             </div>
                                            </div>
                                            <div class="iv-right col-6 text-md-right">
                                                <div class"row">
                                                    <div class="col-md-12">
                                                        <span><h5 style="color: #030a10; ">MONTHLY TRAFFIC REPORT (MTR) SUMMARY FOR N.H.A</h5></span>
                                                    </div>
                                                </row>
                                                <div class"row">
                                                    <div class="col-md-12">
                                                        <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">PLAZA NAME</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 10%;"><?php echo $plaza_name;?></span><br/>
                                                        <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">OMC</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 10%;"><?php echo $omc_name;?></span><br/>
                                                        <!-- <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">Date</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 10%;"><?php echo date("F, Y",strtotime($mtr[0]['for_month']));?></span> -->
                                                        <?php if($mtr[0]['type'] == 2){
                                                                $month_year = explode('-',$mtr[0]['for_month']);
                                                                $start_date = $month_year[0].'-'.$month_year[1].'-'.$mtr[0]['start_date'];
                                                                $end_date = $month_year[0].'-'.$month_year[1].'-'.$mtr[0]['end_date'];
                                                        ?>
                                                            <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">Date</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 10%;">(<?php echo date("F j, Y",strtotime($start_date));?>) TO (<?php echo date("F j, Y",strtotime($end_date));?>)</span>
                                                        <?php }else{ ?>
                                                            <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">Date</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 10%;"><?php echo date("F, Y",strtotime($mtr[0]['for_month']));?></span>
                                                        <?php } ?>
                                                    </div>
                                                </row>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="invoice-table table-responsive mt-5">
                                        <table class="table table-bordered table-hover text-right">
                                            <thead>
                                                <tr class="text-capitalize">
                                                   
                                                    <th class="text-left" style="width: ; min-width: px;">Description</th>
                                                    <th class="text-center" style="width:;">Notes</th>
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
                                                <tr>
                                                    <td class="text-center"><?php echo $mtr[0]['description'];?></td>
                                                   <td class="text-left"><?php echo $mtr[0]['notes'];?></td>
                                                   <td><?php echo number_format($mtr[0]['class1']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class2']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class3']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class4']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class5']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class6']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class7']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class8']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class9']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class10']);?></td>
                                                    
                                                    <td><?php echo number_format($mtr[0]['total']);?></td>
                                                </tr>
                                                <?php 
                                                    if($exempt){
                                                ?>
                                                    <tr>
                                                    
                                                    <td class="text-center"><?php echo $exempt[0]['description']?></td>
                                                    <td class="text-left"><?php echo $exempt[0]['notes']?></td>
                                                    <td><?php echo number_format($exempt[0]['class1']);?></td>
                                                    <td><?php echo number_format($exempt[0]['class2']);?></td>
                                                    <td><?php echo number_format($exempt[0]['class3']);?></td>
                                                    <td><?php echo number_format($exempt[0]['class4']);?></td>
                                                    <td><?php echo number_format($exempt[0]['class5']);?></td>
                                                    <td><?php echo number_format($exempt[0]['class6']);?></td>
                                                    <td><?php echo number_format($exempt[0]['class7']);?></td>
                                                    <td><?php echo number_format($exempt[0]['class8']);?></td>
                                                    <td><?php echo number_format($exempt[0]['class9']);?></td>
                                                    <td><?php echo number_format($exempt[0]['class10']);?></td>
                            
                                                    <td><?php echo number_format($exempt[0]['class1']  + $exempt[0]['class2'] + $exempt[0]['class3'] + $exempt[0]['class4'] + $exempt[0]['class5'] + $exempt[0]['class6'] + $exempt[0]['class7'] + $exempt[0]['class8']  + $exempt[0]['class9']  + $exempt[0]['class10']);?></td>
                                                    
                                                    
                                                     
                                                </tr>
                                                <?php    }?>
                                                <tr>
                                                    <?php 
                                                        if($terrif){
                                                    ?>
                                                    <td class="text-center">Revenue</td>
                                                   <td class="text-left"></td>
                                                   <?php 
                                                        if($exempt){
                                                   ?>
                                                   <td><?php echo number_format(($mtr[0]['class1'] - $exempt[0]['class1']) * $terrif[0]['class_1_value']);?></td>
                                                    <td><?php echo number_format(($mtr[0]['class2'] - $exempt[0]['class2']) * $terrif[0]['class_2_value']);?></td>
                                                    <td><?php echo number_format(($mtr[0]['class3'] - $exempt[0]['class3']) * $terrif[0]['class_3_value']);?></td>
                                                    <td><?php echo number_format(($mtr[0]['class4'] - $exempt[0]['class4']) * $terrif[0]['class_4_value']);?></td>
                                                    <td><?php echo number_format(($mtr[0]['class5'] - $exempt[0]['class5']) * $terrif[0]['class_5_value']);?></td>
                                                    <td><?php echo number_format(($mtr[0]['class6'] - $exempt[0]['class6']) * $terrif[0]['class_6_value']);?></td>
                                                    <td><?php echo number_format(($mtr[0]['class7'] - $exempt[0]['class7']) * $terrif[0]['class_7_value']);?></td>
                                                    <td><?php echo number_format(($mtr[0]['class8'] - $exempt[0]['class8']) * $terrif[0]['class_8_value']);?></td>
                                                    <td><?php echo number_format(($mtr[0]['class9'] - $exempt[0]['class9']) * $terrif[0]['class_9_value']);?></td>
                                                    <td><?php echo number_format(($mtr[0]['class10'] - $exempt[0]['class10'])* $terrif[0]['class_10_value']);?></td>
                                                    <td><?php echo number_format((($mtr[0]['class1'] - $exempt[0]['class1']) * $terrif[0]['class_1_value']) + (($mtr[0]['class2'] - $exempt[0]['class2']) * $terrif[0]['class_2_value']) + (($mtr[0]['class3'] - $exempt[0]['class3']) * $terrif[0]['class_3_value']) + (($mtr[0]['class4'] - $exempt[0]['class4']) * $terrif[0]['class_4_value']) + (($mtr[0]['class5'] - $exempt[0]['class5']) * $terrif[0]['class_5_value']) + (($mtr[0]['class6'] - $exempt[0]['class6']) * $terrif[0]['class_6_value']) + (($mtr[0]['class7'] - $exempt[0]['class7']) * $terrif[0]['class_7_value']) + (($mtr[0]['class8'] - $exempt[0]['class8']) * $terrif[0]['class_8_value']) + (($mtr[0]['class9'] - $exempt[0]['class9']) * $terrif[0]['class_9_value']) + (($mtr[0]['class10'] - $exempt[0]['class10']) * $terrif[0]['class_10_value']));?></td>
                                                    
                                                   <?php }else{?>
                                                    <td><?php echo number_format($mtr[0]['class1'] * $terrif[0]['class_1_value']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class2'] * $terrif[0]['class_2_value']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class3'] * $terrif[0]['class_3_value']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class4'] * $terrif[0]['class_4_value']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class5'] * $terrif[0]['class_5_value']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class6'] * $terrif[0]['class_6_value']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class7'] * $terrif[0]['class_7_value']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class8'] * $terrif[0]['class_8_value']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class9'] * $terrif[0]['class_9_value']);?></td>
                                                    <td><?php echo number_format($mtr[0]['class10'] * $terrif[0]['class_10_value']);?></td>
                                                    <td><?php echo number_format(($mtr[0]['class1'] * $terrif[0]['class_1_value']) + ($mtr[0]['class2'] * $terrif[0]['class_2_value']) + ($mtr[0]['class3'] * $terrif[0]['class_3_value']) + ($mtr[0]['class4'] * $terrif[0]['class_4_value']) + ($mtr[0]['class5'] * $terrif[0]['class_5_value']) + ($mtr[0]['class6'] * $terrif[0]['class_6_value']) + ($mtr[0]['class7'] * $terrif[0]['class_7_value']) + ($mtr[0]['class8'] * $terrif[0]['class_8_value']) + ($mtr[0]['class9'] * $terrif[0]['class_9_value']) + ($mtr[0]['class10'] * $terrif[0]['class_10_value']));?></td>
                                                    <?php } }else{ ?>
                                                    <td class="text-center" colspan="11"><span class="text-danger">Tarrif for this MTR is not added yet.</span></td>
                                                     <?php    }?>
                                                </tr>
                                            </tbody>
                                            
                                        </table>
                                    </div>
                                  
                                </div>
                                 <!--  <div class="row">
                                        <div class="col-md-5">
                                            <table class="table table-bordered table-hover" border="1px solid;" text-align="center">
                                            <thead>
                                                <tr class="text-capitalize" style="text-align:center; background-color:#cccccc;">
                                                   
                                                    <th width="60%"><div style="line-height:40px">Vehicle Class</div></th>
                                                    <th width="40%"><div style="line-height:40px">Tariff</div></th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                            </tbody>
                                            <tfoot>
                                               
                                            </tfoot>
                                        </table>
                                        </div>
                                    </div>
                                     -->
                                    
                                </div>
                                <a href="<?php echo base_url()?>admin/generate_pdf/<?php echo $mtr[0]['id'];?>" class="btn btn-info pull-right"><i class="fa fa-file-pdf-o"></i> &nbsp;Gemerate PDF</a>
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