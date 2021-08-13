<!doctype html>
<html>
<head>
<meta charset="utf-8">
     <meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Time Report</title>
    
    
   <link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/styles.css">
</head>

<body>
	<div class="main-content-inner">
		<div class="row">
			<div class="col-md-12">
				<?php if(isset($tool)){ $tool_no = 0; foreach($tool as $toll){ ?> 
				<div class="card">
					<div class="card-title text-center my-5"><h5><?php echo $toll['detail']['toolplaza']; ?></h5></div>
					<div class="card-body">
						<div class="text-center"><strong><?php if(isset($toggle_dtr)){ if($toggle_dtr == 0){ ?> DSR <?php }else{ ?> DTR <?php }  } ?></strong></div>
						<div class="text-center">
							<div class="row">
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-4 text-center my-2">
											<table class="table" style="margin: auto">
														<thead>
															<tr>
																<th>Not Uploaded</th>
															</tr>
														</thead>
														<tbody>
														<?php if(isset($toll['dates']['missing'])){ $miss = 0; foreach($toll['dates']['missing'] as $missing){ ?>
															<tr>
																<td><?php echo $missing ?></td>
															</tr>
														<?php $miss++; } } ?>
														</tbody>
													</table>
										</div>
										<div class="col-md-4 text-center my-2">
											<table class="table" style="margin: auto">
														<thead>
															<tr>
																<th>Pending</th>
															</tr>
														</thead>
														<tbody>
														<?php if(isset($toll['dates']['pending'])){ $pend = 0; foreach($toll['dates']['pending'] as $pending){ ?>
															<tr>
																<td><?php echo $pending ?></td>
															</tr>
														<?php $pend++; } } ?>
														</tbody>
													</table>
										</div>
										<div class="col-md-4 text-center my-2">
											<table class="table" style="margin: auto">
														<thead>
															<tr>
																<th>Rejected</th>
															</tr>
														</thead>
														<tbody>
														<?php if(isset($toll['dates']['rejected'])){ $reject = 0; foreach($toll['dates']['rejected'] as $rejected){ ?>
															<tr>
																<td><?php echo $rejected ?></td>
															</tr>
														<?php $reject++; } } ?>
														</tbody>
													</table>
										</div>
									</div>
								</div>
								<div class="col-md-8">
									<div class="row">
										<table class="table">
											<thead>
												<tr>
													<th>Date</th>
													<th>Upload Delay</th>
													<th>Reason for Delay</th>
													<th>Supervise Delay</th>
												</tr>
											</thead>
											<tbody>
												<?php if(isset($toll['dsr'])){ $dsr_no = 0; foreach($toll['dsr'] as $dsr){
														
														if(isset($dsr['upload_diff']) || isset($dsr['supervise_diff'])){ ?>
															<tr>
																<td><?php echo $dsr['dsr_date'] ?></td>
																<td><?php if(isset($dsr['upload_diff'])){ echo $dsr['upload_diff']; } ?></td>
																<td><?php if(isset($dsr['toll_delay'])){ echo $dsr['toll_delay'];} ?></td>
                                                                <td><?php if(isset($dsr['supervise_diff'])){ echo $dsr['supervise_diff']; } ?></td>
															</tr>
														<?php $dsr_no++; } } }  ?>
											</tbody>
										</table>
									</div>
									
								</div>
									
							</div>
						</div>
						
					</div>
				</div>
				<?php $tool_no++; } } ?>
			</div>
		</div>
	</div>
</body>
</html>