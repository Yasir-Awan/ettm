<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Invoice - TCR</title>
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
                                            <div class="iv-left col-3">
                                            <div class="logo">
                                                <a href="invoice.php"><img src="<?php echo base_url()?>assets/back/images/icon/logo.png" alt="logo"></a>
                                             </div>
                                            </div>
                                            <div class="iv-right col-5 text-md-right">
                                                <div class"row">
													
                                                    <div class="col-md-10">
                                                        <span><h5 style="color: #030a10; ">Traffic Counter Report (TCR)</h5></span>
                                                    </div>
                                                </row>
                                                <div class"row">
                                                    <div class="col-md-12">
                                                        <span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">PLAZA NAME</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 10%;"><?php echo $plaza_name;?></span><br/>
														<span class="text-left" style="font-size: 0.80rem;color: #030a10;float: left;margin-left: 20%;">Date</span><span style="font-size: 0.80rem;color: #030a10;margin-right: 10%;"><?php echo date("F j, Y",strtotime($datecreated));?></span> 
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
													<th>total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
													<td class="text-center"><?php echo 'Traffic'; ?></td>
													<td class="text-left"><?php echo 'No of Passages'; ?></td>
													<td><?php echo number_format($class1); ?></td>
                                                    <td><?php echo number_format($class2); ?></td>
                                                    <td><?php echo number_format($class3); ?></td>
                                                    <td><?php echo number_format($class4); ?></td>
                                                    <td><?php echo number_format($class5); ?></td>
													<td><?php echo number_format($total);?></td>
                                                </tr>
                                                <tr>
													<?php if($terrif){ ?>
													<td class="text-center">Revenue</td>
													<td class="text-left"> Rupees </td>
													<td><?php echo number_format($calculation['revenue']['1']);?></td>
                                                    <td><?php echo number_format($calculation['revenue']['2']);?></td>
                                                    <td><?php echo number_format($calculation['revenue']['3']);?></td>
                                                    <td><?php echo number_format($calculation['revenue']['4']);?></td>
                                                    <td><?php echo number_format($calculation['revenue']['5']);?></td>
													<td><?php echo number_format($calculation['total']);?></td>
                                                    <?php }else{ ?>
                                                    <td class="text-center" colspan="11"><span class="text-danger">Tarrif for this TCR is not added yet.</span></td>
													<?php } ?>
                                                </tr>
                                            </tbody>
                                            
                                        </table>
                                    </div>
                                  
                                </div>
                                    
                                </div>
                                <a href="<?php echo base_url()?>admin/generate_tcrpdf/<?php echo $id;?>" class="btn btn-info pull-right"><i class="fa fa-file-pdf-o"></i> &nbsp;Generate PDF</a>
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