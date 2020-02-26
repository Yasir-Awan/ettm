<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Accident - Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/responsive.css">
    <!-- modernizr css -->
</head>
<body>
          <!-- <?php 
            $plaza_name = $this->db->get_where('toolplaza',array('id' => $mtr[0]['toolplaza']))->row()->name;
            $omc_name   = $this->db->get_where('omc',array('id' => $mtr[0]['omc']))->row()->name;
            $exempt = $this->db->get_where('exempt',array('mtr_id' => $mtr[0]['id']))->result_array();
          ?> -->
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
                                                <a href="#"><img src="<?php echo base_url()?>assets/back/images/icon/logo.png" alt="logo"></a>
                                             </div>
                                            </div>
                                            <div class="iv-right col-6 text-md-right">
                                                <div class"row">
                                                    <div class="col-md-12">
                                                        <span><h5 style="color: #030a10; ">Accident Details REPORT (CRASH) SUMMARY FOR N.H.A</h5></span>
                                                    </div>
                                                </row>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="invoice-table table-responsive mt-5">
                                        <table class="table table-bordered table-hover text-right">
                                            <thead>
                                                <tr class="text-capitalize">
                                                   
                                                    <th class="text-left" style="width:fit-content; min-width: px;">Coords</th>
                                                    <th class="text-left">Vehicles</th>
                                                    <th>Time</th>
                                                    <th class="text-center" style="width:;">Address</th>
                                                    <th class="text-center">Cause</th>
                                                    <th>Weather</th>
                                                    <th>Pavement Condition</th>
                                                    <th>Lighting Condition</th>
                                                    <th>Total Victims</th>
                                                    <th>Male</th>
                                                    <th>Female</th>
                                                    <th class="text-center">Victims Status</th>                                                        
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($detail as $row) { ?>
                                                <tr>
                                                    <td class="text-left"><?php  echo $row['coords'];?></td>
                                                    <td><?php  echo $row['vehicles_qty_regno'];?></td>
                                                    <td><?php  echo $row['crash_time'];?></td>
                                                   <td ><?php  echo $row['address'];?></td>
                                                    <td class="text-center"><?php  echo $row['rtc_cause'];?></td>
                                                    <td><?php  echo $row['wheather_condition'];?></td>
                                                    <td><?php  echo $row['pavement_condition'];?></td>
                                                    <td><?php  echo $row['light_condition'];?></td>
                                                    <td><?php  echo $row['total_victims_number'];?></td>
                                                    <td><?php  echo $row['male_victims'];?></td>
                                                    <td><?php  echo $row['female_victims'];?></td>
                                                    <td><?php  echo $row['victims_number_status'];?></td>
                                                </tr>  
                                            <?php } ?>
                                            </tbody>
                                            
                                        </table>
                                    </div>
                                  
                                </div>
  
                                    
                                </div>
                                <!-- <a href="<?php //echo base_url()?>admin/generate_pdf/<?php //echo $mtr[0]['id'];?>" class="btn btn-info pull-right"><i class="fa fa-file-pdf-o"></i> &nbsp;Gemerate PDF</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="<?php //echo base_url()?>assets/back/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    
    <script src="<?php //echo base_url()?>assets/back/js/bootstrap.min.js"></script>
    
</body>