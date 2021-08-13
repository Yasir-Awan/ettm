<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Print View - Traffic Counting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/responsive.css">
    <!-- modernizr css -->
</head>
<body>

            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice-area">
                                    <div class="invoice-head">
                                        <div class="row">
                                            <div class="div-left col-3">
                                            <div class="logo">
                                                <a href="invoice.php"><img src="<?php echo base_url()?>assets/back/images/icon/logo.png" alt="logo"></a>
                                             </div>
                                            </div>
                                            <div class="div-right col-6 text-md-right">
                                                <div class"row">
                                                    <div class="col-md-12">
                                                        <span><h5 style="color: #030a10; text-align:center;padding-left:3.5rem;">MANUAL TRAFFIC COUNT REPORT FOR N.H.A</h5></span>
                                                    </div>
                                                </row>
                                                <div class"row">
                                                    <div class="col-md-12">
                                                        <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">PLAZA NAME</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 10%;"><?php echo $plaza_name;?></span><br/>
                                                        <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">Bound</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 10%;"><?php echo $bound;?></span><br/>    
                                                        <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">Date</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 10%;"><?php echo date("F j, Y",strtotime($counting[0]['date']));?></span>       
                                                    </div>
                                                </row>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="invoice-table table-responsive mt-5">
                                        <table class="table table-bordered table-hover text-right">
                                            <thead>
                                                <tr class="text-capitalize">
                                                    <th class="text-left">Hour No</th>
                                                    <th class="text-center" style="width:;">Time</th>
                                                    <th>Class-1</th>
                                                    <th>Class-2</th>
                                                    <th>Class-3</th>
                                                    <th>Class-4</th>
                                                    <th>Class-5</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-left">Hour-1</td>
                                                    <td class="text-center"><?php echo $counting[0]['hour1start']." To ".$counting[0]['hour1end'] ;?></td>
                                                    <td><?php echo number_format($counting[0]['h1class1']);?></td>
                                                    <td><?php echo number_format($counting[0]['h1class2']);?></td>
                                                    <td><?php echo number_format($counting[0]['h1class3']);?></td>
                                                    <td><?php echo number_format($counting[0]['h1class4']);?></td>
                                                    <td><?php echo number_format($counting[0]['h1class5']);?></td>
                                                </tr>
                                                <?php 
                                                    if(!empty($counting[0]['hour2start'])){
                                                ?>
                                                    <tr>
                                                    <td class="text-left">Hour-2</td>
                                                    <td class="text-center"><?php echo $counting[0]['hour2start']." To ".$counting[0]['hour2end'] ;?></td>
                                                    <td><?php echo number_format($counting[0]['h2class1']);?></td>
                                                    <td><?php echo number_format($counting[0]['h2class2']);?></td>
                                                    <td><?php echo number_format($counting[0]['h2class3']);?></td>
                                                    <td><?php echo number_format($counting[0]['h2class4']);?></td>
                                                    <td><?php echo number_format($counting[0]['h2class5']);?></td>
                                                                                                        
                                                </tr>
                                                <?php    }?>
                                                <tr>
                                                    <?php 
                                                        if(!empty($counting[0]['hour3start'])){
                                                    ?>
                                                    <td class="text-left">Hour-3</td>
                                                    <td class="text-center"><?php echo $counting[0]['hour3start']." To ".$counting[0]['hour3end'] ;?></td>
                                                    <td><?php echo number_format($counting[0]['h3class1']);?></td>
                                                    <td><?php echo number_format($counting[0]['h3class2']);?></td>
                                                    <td><?php echo number_format($counting[0]['h3class3']);?></td>
                                                    <td><?php echo number_format($counting[0]['h3class4']);?></td>
                                                    <td><?php echo number_format($counting[0]['h3class5']);?></td>
                                                    <?php  }
                                                    else{ ?>
                                                    <td class="text-center" colspan="11"><span class="text-danger">Hour2 & Hour3 not added for this Traffic Count.</span></td>
                                                     <?php } ?>
                                                </tr>
                                            </tbody>
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