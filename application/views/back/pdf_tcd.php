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
													<span><h1 style="color: #030a10; font-size:26px; ">Traffic Counter Report (TCR) for NHA</h1></span><br/>
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
																<span style="font-size:18px;">Date</span>
															</td>
															<td>
																<span style="font-size:18px;"><?php echo $datecreated;?></span>

															</td>
														</tr>
													</table>
												</td>
												<td>
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
												<th><div style="line-height:40px">Total</div></th>
											</tr>
										</thead>
										<tbody>
											<tr style="text-align:center;">
												<td><div style="line-height:30px"><?php echo 'Traffic';?></div></td>
												<td><div style="line-height:30px"><?php echo 'No of Passages';?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($class1);?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($class2);?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($class3);?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($class4);?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($class5);?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($total);?></div></td>
											</tr>
											<tr style="text-align:center;">
												<?php if($terrif){ ?>
												<td><div style="line-height:30px">Revenue</div></td>
												<td><div style="line-height:30px">Rupees</div></td>
												<td><div style="line-height:30px"><?php echo number_format($calculation['revenue']['1']);?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($calculation['revenue']['2']);?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($calculation['revenue']['3']);?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($calculation['revenue']['4']);?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($calculation['revenue']['5']);?></div></td>
												<td><div style="line-height:30px"><?php echo number_format($calculation['total']);?></div></td>
										   <?php  }else{?>
												<td colspan="13"><div style="line-height:30px; color: #e60c0c;">Tarrif for this TCR is not added yet.</div></td>
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
												<td width="60%" style="padding-top:20px;"><div style="line-height:30px"><?php echo $calculation['description']['1'];?></div></td>
												<td width="40%" style="text-align:right;"><div style="line-height:30px">Rs<?php echo $calculation['terrif']['1']; ?>&nbsp;&nbsp;&nbsp;</div></td>

											</tr>
											<tr>
												<td width="60%"><div style="line-height:30px"><?php echo $calculation['description']['2'];?></div></td>
												<td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $calculation['terrif']['2']; ?>&nbsp;&nbsp;&nbsp;</div></td>

											</tr>
											<tr>
												<td width="60%"><div style="line-height:30px"><?php echo $calculation['description']['3'];?></div></td>
												<td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $calculation['terrif']['3']; ?>&nbsp;&nbsp;&nbsp;</div></td>

											</tr>
											<tr>
												<td width="60%"><div style="line-height:30px"><?php echo $calculation['description']['4'];?></div></td>
												<td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $calculation['terrif']['4']; ?>&nbsp;&nbsp;&nbsp;</div></td>

											</tr>
											<tr>
												<td width="60%"><div style="line-height:30px"><?php echo $calculation['description']['5'];?></div></td>
												<td width="40%" style="text-align:right;"><div style="line-height:30px">Rs <?php echo $calculation['terrif']['5'] ?>&nbsp;&nbsp;&nbsp;</div></td>

											</tr>

											<?php }else{?>
											<tr>
												<td width="100%" colspan="2"><div style="text-align: center; line-height:30px; color: #e60c0c;">Tarrif for this MTR is not added yet.</div></td>

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