<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Report - DSR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/responsive.css">
    <!-- modernizr css -->
	<style> 
		body{
			font-size: 0.9rem;
		}
	</style>
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
                                            <div class="iv-left col-2">
                                            <div class="logo">
                                                <img height="50%" width="100%" src="<?php echo base_url()?>assets/back/images/icon/logo.png" alt="logo">
                                             </div>
                                            </div>
                                            <div class="iv-right col-9 text-md-right">
                                                <div class"row">
                                                    <div class="col-md-12">
                                                        <span><h4 class="text-md-center" style="color: #030a10;">DAILY SITE REPORT (DSR) Comprehensive Report FOR N.H.A</h4></span>
                                                    </div>
                                                </div>
                                                <div class"row">
                                                    <div class="col-md-6" style="float:right">
                                                       	<span class="text-left" style="font-size: 0.95rem;color: #030a10;float: left;margin-left: 20%;">DATE</span>
                                                        <span style="font-size: 0.95rem;color: #030a10;margin-right: 10%;"><?php echo $today;?></span><br/>
                                                     </div>
                                                    
                                                </div><!--row-->
                                        </div>
                                    </div>
									<div class="col-md-3"></div>
                                    <div class="col-md-12 invoice-table table-responsive mt-5">
                                       	<div><h5>Summary</h5></div>
                                      <div class="row">
										  <div class="col-md-12">
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize">
														<th class="text-center">Sr</th>
														<th class="text-center">Toll Plaza</th>
														
														<th class="text-center">Site Incharge</th>
														
														<th class="text-center">Contractor</th>
														<th class="text-center">Closed Lanes</th>
														<th class="text-center">Shutdown</th>
														<th class="text-center">MTR Status</th>
														<th class="text-center">Archiving Status</th>
														<th class="text-center">Faulty CCTV</th>
														<th class="text-center">Link</th>
														<th class="text-center">Staff Absent/Leave</th>
														<th class="text-center">Support Request</th>
														
													</tr>
												</thead>
												<tbody>
													
													<?php $i=0; $j = $i+1; foreach($toolplaza as $toll){ ?> 
													<tr>
														<td><?php echo $j; ?></td>
														<td><?php echo $toll['name']; ?></td>								
														<td><?php echo $toll['incharge']; ?></td>
														<?php if(isset($toll['dsr'])){ ?>
															<td><?php if(isset($toll['dsr']['omc_name'])) echo $toll['dsr']['omc_name']; ?></td>
														<?php if(isset($toll['dsr']['closed_lanes'])){ ?>
															<td><?php  echo $toll['dsr']['closed_lanes'];}else{ echo 'OK';}  ?></td>
															<td><?php echo $toll['dsr']['shut_down']; ?></td>
															<td><?php echo $toll['dsr']['mtr_status']; ?></td>
															<td><?php echo $toll['dsr']['mtr_archiving_status']; ?></td>
															<td><?php if($toll['dsr']['inventory'][9]['status'] != ''){ echo $toll['dsr']['inventory'][9]['status'];}else{ echo 'OK';}?></td>
															<td><?php echo $toll['dsr']['link']; ?></td>
															<td><?php echo $toll['dsr']['absentee']; ?></td>
															<td><?php echo $toll['dsr']['support_request'] ?></td>
														<?php }else{ ?>
														<td colspan ="9" class="text-center"><?php echo 'DSR Does Not Exist'; ?></td>
														<?php } ?>
													</tr>
													<?php  $i++; $j++; } ?>

												</tbody>
											</table>
										</div>
                                    
									</div>
									<div class="row"><div class="mx-auto"><h5>Faulty Inventory Report</h5></div></div>
									<div class="row">
										<div class="col-md-12">
											<table class="table table-bordered table-hover text-right">
												<thead>
													
													<tr> <th>Tollplaza</th><?php $i=0; $j = $i+1; foreach($inventory as $inv){ ?>
														<th><?php echo $inv['name']; ?></th>
														<?php  $i++; $j++;  } ?></tr>
													
												</thead>
												<tbody>
													<?php $k = 0; foreach($toolplaza as $toll){ ?>
													<tr>
														
														<th><?php echo $toll['name'] ?></th>
														<?php if(isset($toll['dsr'])){$l = 0; foreach($toll['dsr']['inventory'] as $inv){ ?>
														<td><?php if($inv['status'] != '') echo $inv['status']; else echo 'OK'; ?></td>
														<?php }$l++;}else{ 
															?><td class="text-center" colspan = '<?php echo $j?>'> <?php echo 'DSR Does Not Exist'; ?> </td> <?php } ?>
													</tr>
													<?php $k++;} ?>
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
	</div>
</div>
    <script src="<?php echo base_url()?>assets/back/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    
    <script src="<?php echo base_url()?>assets/back/js/bootstrap.min.js"></script>
    
</body>