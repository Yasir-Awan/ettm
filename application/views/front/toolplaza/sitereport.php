<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Report - DSR</title><link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/font-awesome.min.css"><link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/default-css.css"><link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/styles.css"><link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/responsive.css"><!-- modernizr css -->
</head>
<body><!-- page title area end -->
	<div class="main-content-inner">
		<div class="row">
			<div class="col-lg-12 mt-5">
				<div class="card">
					<div class="card-body">
						<div class="invoice-area">
							<div class="invoice-head">
								<div class="row">
									<div class="iv-left col-2">
										<div class="logo"> <img src="<?php echo base_url() ?>assets/back/images/icon/logo.png" height="50%" width="100%" alt="logo"></div>
									</div>
									<div class="iv-right col-9 text-md-right">
										<div class"row"><div class="col-md-12 bg-warning"><span><h4 class="text-md-right" style="color: #030a10;">DAILY SITE REPORT (DSR) SUMMARY FOR N.H.A</h4></span></div></div>
										<div class"row"><div class="col-md-6" style="float:left"><span class="text-left" style="font-size: 0.95rem;color: #030a10;float: left;margin-left: 20%;">DATE</span><span style="font-size: 0.95rem;color: #030a10;margin-right: 10%;"><?php echo date('d-m-Y',strtotime($date));?></span><br/><span class="text-left" style="font-size: 0.95rem;color: #030a10;float: left;margin-left: 20%;">PLAZA NAME</span><span style="font-size: 0.95rem;color: #030a10;margin-right: 10%;"><?php echo $plaza_name;?></span><br/><span class="text-left" style="font-size: 0.95rem;color: #030a10;float: left;margin-left: 20%;">PREPARED BY</span><span style="font-size: 0.95rem;color: #030a10;margin-right: 10%;"><?php echo $supervisor_name;?></span><br/></div><div class="col-md-6 form_group" style="float:right"><span class="text-left" style="font-size: 0.95rem;color: #030a10;float: left;margin-left: 20%;">DESIGNATION</span><span style="font-size: 0.95rem;color: #030a10;margin-right: 10%;"><?php if($supervisor_id == 12 || $supervisor_id == 13 || $supervisor_id == 15){ echo "Technical Manager"; } elseif($supervisor_id == 20){ echo "Technician"; } elseif($supervisor_id == 14 || $supervisor_id == 16 || $supervisor_id == 17 || $supervisor_id == 18 || $supervisor_id == 19 || $supervisor_id == 22 || $supervisor_id == 23) { echo 'Site Incharge';} else { echo "Supervisor";};?></span><br/><span class="text-left" style="font-size: 0.95rem;color: #030a10;float: left;margin-left: 20%;">PHONE</span><span style="font-size: 0.95rem;color: #030a10;margin-right: 10%;"><?php echo $phone ;?></span><br/><span class="text-left" style="font-size: 0.95rem;color: #030a10;float: left;margin-left: 20%;">OMC</span><span style="font-size: 0.95rem;color: #030a10;margin-right: 10%;"><?php echo $omc_name;?></span><br/></div></div><!--row-->
									</div>
								</div>
								<div class="col-md-3"></div>
								<div class="col-md-12 invoice-table table-responsive mt-5">
									<div><h5>Summary</h5></div>
									<div><h6>Lane Status</h6></div>
									<div class="row">
										<?php if($toolplaza_id == 9){}else{?>
										<div class="col-md-6">
											<div class='text-center'><h6>North</h6></div>
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize"><th class="text-left" width="5%">Lane</th><th class="text-center" style="width:10%;">Status</th><th class="text-center" style="width:10%">Closed</th><th style="width:10%">From</th><th style="width:10%">To</th><th>Description</th></tr>
												</thead>
												<tbody>
													<?php $a = 0; foreach($north as $n){ $a++; ?>
													<tr><td class="text-right" width=""><?php echo $n['bound'].$a;?></td><td class="text-right"><?php if($dsr[0]['nlanestatus'.$a] == 1)echo 'Closed';if($dsr[0]['nlanestatus'.$a] == 0) echo 'Open';?></td><td class="text-right"><?php if($dsr[0]['nlclosed'.$a] == 1) echo 'By OMC';if($dsr[0]['nlclosed'.$a] == 2) echo 'Due to Technical Issue'?></td><td class="text-right"><?php echo $dsr[0]['nlclosed_from'.$a];?></td><td class="text-right"><?php echo $dsr[0]['nlclosed_to'.$a];?></td><td width="30%" class="text-right"><?php echo $dsr[0]['nlclosed_description'.$a];?></td></tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
										<?php } ?>
										<div class="col-md-6">
											<div class='text-center'><h6>South</h6></div>
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize"><th class="text-left" style="width:5% ; min-width: px;">Lane</th><th class="text-center" style="width:10%;">Status</th><th class="text-center">Closed</th><th style="width:10%">From</th><th  style="width:10%">To</th><th>Description</th></tr>
												</thead>
												<tbody>
													<?php $a = 0; foreach($south as $s){ $a++; ?>
													<tr><td class="text-right"><?php echo $s['bound'].$a;?></td><td class="text-right"><?php if($dsr[0]['slanestatus'.$a] == 1) {echo 'Closed';} if($dsr[0]['slanestatus'.$a] == 0){ echo 'Open';} ?></td><td class="text-right"><?php if($dsr[0]['slclosed'.$a] == 1) echo 'By OMC';if($dsr[0]['slclosed'.$a] == 2) echo 'Due to Technical Issue'?></td><td class="text-right"><?php echo $dsr[0]['slclosed_from'.$a];?></td><td class="text-right"><?php echo $dsr[0]['slclosed_to'.$a];?></td><td class="text-right" width="30%"><?php echo $dsr[0]['slclosed_description'.$a];?></td></tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize"><th class="text-left" width="px" "; min-width: px;">Site LSDU</th><th class="text-center" style="width:;">Shutdown Reported</th><?php if($dsr[0]['shutdown'] == 0){ }elseif($dsr[0]['shutdown'] == 1){ echo '<th>Duration</th>';} ?><th>Traffic</th><th>Revenue</th><th>Frame Grabber</th><th>Image</th><th>Server</th></tr>
												</thead>
												<tbody>
													<tr><td class="text-center" width="10%"><?php if($dsr[0]['site_lsdu'] == 0) echo 'Working';if($dsr[0]['site_lsdu'] == 1) echo 'Not Working'?></td><td class="text-right" width="10%"><?php if($dsr[0]['shutdown'] == 0) echo 'No';if($dsr[0]['shutdown'] == 1) echo 'Yes';?></td><?php if($dsr[0]['shutdown'] == 0){};if($dsr[0]['shutdown'] == 1) echo '<td class="text-right" width="10%">From '.$dsr[0]['shut_from'].' to '.$dsr[0]['shut_to'].'</td>';?><td class="text-right" width="10%"><?php echo $dsr[0]['site_dt']?></td><td class="text-right" width="10%"><?php echo $dsr[0]['site_dr'];?></td><td class="text-right" width="10%"><?php if($dsr[0]['frame'] == 0) echo 'Working';if($dsr[0]['frame'] == 1) echo 'Not Working'?></td><td class="text-right" width="10%"><?php if($dsr[0]['image'] == 0) echo 'Available';if($dsr[0]['image'] == 1) echo 'Not Available'?></td><td class="text-right" width="10%"><?php if($dsr[0]['serverstatus'] == 0) echo 'Online';if($dsr[0]['serverstatus'] == 1) echo 'Offline';?></td></tr>
												</tbody>
											</table>
										</div>
									</div>
									<h6>CCTV Camera Status</h6>
									<div class="row">
										<div class="col-md-4">
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize"><th class="text-left" style="width: ; min-width: px;">PTZ</th><th>Status</th><th>Description</th></tr>
												</thead>
												<tbody>
													<?php for($a=1; $a<3; $a++){ if($toolplaza_id == 9){ $a = 2; ?>
													<tr class="text-center"><td><?php  if($a == 1){ echo 'Camera PTZ N';} elseif($a == 2){ echo 'Camera PTZ S';} } ?></td><td><?php if($dsr[0]['ptzstatus'.$a]){echo 'Faulty';}else{echo 'OK';}?></td><td><?php echo $dsr[0]['ptzfc_desc'.$a]; ?></td></tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
										<?php if($toolplaza_id == 9){}else{?>
										<div class="col-md-4">
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize"><th class="text-left" style="width: ; min-width: px;">North</th><th>Status</th><th>Description</th></tr>
												</thead>
												<tbody>
													<?php $a = 0; foreach($north as $n){ $a++ ?>
													<tr><td><?php echo 'Camera '.$n['bound'].$a; ?></td><td><?php if($dsr[0]['ncstatus'.$a]){ echo 'Faulty';}else{ echo 'OK';} ?></td><td><?php echo $dsr[0]['nfc_desc'.$a]; ?></td></tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
										<?php } ?>
										<div class="col-md-4">
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize"><th class="text-left" style="width: ; min-width: px;">South</th><th>Status</th><th>Description</th></tr>
												</thead>
												<tbody>
													<?php $a = 0; foreach($south as $s){ $a++ ?>
													<tr><td><?php echo 'Camera '.$s['bound'].$a; ?></td><td><?php if($dsr[0]['scstatus'.$a]){echo 'Faulty';}else{echo 'OK';} ?></td><td><?php echo $dsr[0]['sfc_desc'.$a]; ?></td></tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<h6>Link Status</h6>
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr><th class="text-left" style="width: ; min-width: px;">Issue</th><th class="text-left" style="width: ; min-width: px;">Description</th></tr>
												</thead>
												<tbody>
													<tr><td width="30%"><?php if(empty($dsr[0]['linkissue'])){echo 'No';}else{echo 'Yes';} ?></td><td width="70%"><?php echo $dsr[0]['lissue_desc']; ?></td></tr>
												</tbody>
											</table>
										</div>
										<div class="col-md-8">
											<h6>MTR Status</h6>
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize"><th class="text-center" style="width: ; min-width: px;">MTR Prepared</th><th class="text-center" style="width:;">Pending MTR</th><th class="text-center">Archiving Status</th><th class="text-center">Uploaded in App</th></tr>
												</thead>
												<tbody>
													<tr><td class="text-center"><?php echo 'Upto '.date('F-Y', strtotime($dsr[0]['mtrstatus']));?></td><td class="text-center"><?php echo $dsr[0]['apmtr'];?></td><td class="text-center"><?php echo 'Upto '.date('F-Y', strtotime($dsr[0]['asmtr']));?></td><td class="text-center"><?php echo 'Upto '.date('F-Y', strtotime($dsr[0]['mtrupto']));;?></td></tr>
												</tbody>
											</table>
										</div>
									</div> 
									<div class="row">
										<div class="col-md-5">
											<h6>Attendance</h6>
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize"><th class="text-left" style="width: ; min-width: px;">Employee</th><th class="text-center" style="width:;">Attendance</th><th>Planned Holiday</th></tr>
												</thead>
												<tbody>
													<?php $a=0; if(isset($dsr_staff)){ foreach($dsr_staff as $s){ if(!empty($s)){	?>
													
													<tr><td><?php echo $s['name'];?></td><td><?php if($s['as_status'] == 2) echo 'Absent'; elseif($s['as_status'] == 1) echo 'Leave'; elseif($s['as_status'] == 3) echo 'Present'; ?></td><td><?php if (!empty($s['as_holidayfrom'])) { echo 'From '.$s['as_holidayfrom'].' To '.$s['as_holidayto']; };?></td></tr>
													<?php $a++; } } } ?>
												</tbody>
											</table>
										</div>
										<div class="col-md-3">
											<h6>Plaza Condition</h6>
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize"><th class="text-left" style="width: ; min-width: px;">Utilities</th><th class="text-center" style="width:;">Status</th></tr>
												</thead>
												<tbody>
													<tr><td>Electricity</td><td><?php if($dsr[0]['pcelectricity'] == 1) echo 'Stable'; elseif($dsr[0]['pcelectricity'] == 2) echo 'Unstable'; ?></td></tr>
													<tr><td>Building</td><td><?php if($dsr[0]['pcbuilding'] == 1) echo 'Worse'; elseif($dsr[0]['pcbuilding'] == 2) echo 'Bad'; elseif($dsr[0]['pcbuilding'] == 3) echo 'Average'; elseif($dsr[0]['pcbuilding'] == 4) echo 'Good'; elseif($dsr[0]['pcbuilding'] == 5) echo 'Excellent';?></td></tr>
													<tr><td>Cleaning</td><td><?php if($dsr[0]['pccleaning'] == 1) echo 'Worse'; elseif($dsr[0]['pccleaning'] == 2) echo 'Bad'; elseif($dsr[0]['pccleaning'] == 3) echo 'Average'; elseif($dsr[0]['pccleaning'] == 4) echo 'Good'; elseif($dsr[0]['pccleaning'] == 5) echo 'Excellent';?></td></tr>
													<tr><td>Meal</td><td><?php if($dsr[0]['pcmeal'] == 1) echo 'Worse'; elseif($dsr[0]['pcmeal'] == 2) echo 'Bad'; elseif($dsr[0]['pcmeal'] == 3) echo 'Average'; elseif($dsr[0]['pcmeal'] == 4) echo 'Good'; elseif($dsr[0]['pcmeal'] == 5) echo 'Excellent';?></td></tr>
													<tr><td>Water</td> <td><?php if($dsr[0]['pcwater'] == 1) echo 'Worse'; elseif($dsr[0]['pcwater'] == 2) echo 'Bad'; elseif($dsr[0]['pcwater'] == 3) echo 'Average'; elseif($dsr[0]['pcwater'] == 4) echo 'Good'; elseif($dsr[0]['pcwater'] == 5) echo 'Excellent';?> </td></tr>
													<tr><td>Receipts</td> <td><?php if($dsr[0]['pcreceipts'] == 2) echo 'Manual'; elseif($dsr[0]['pcreceipts'] == 1) echo 'Automatic';?></td> </tr>
													<tr><td>Queuing</td> <td><?php echo $dsr[0]['pcqueuing']?></td></tr>
												</tbody>
											</table>
										</div>
										<div class="col-md-4">
											<?php if($dsr[0]['pcelectricity'] != 1){ ?>
											<h6>Electricity</h6>
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr><th class="text-left">Source</th><th class="text-left">Reason</th></tr>
												</thead>
												<tbody>
													<tr><td><?php if($dsr[0]['ecause'] == 2) echo "Generator"; elseif($dsr[0]['ecause'] == 3) echo "UPS"; ?></td><td><?php echo $dsr[0]['ereason'] ?></td></tr>
												</tbody>
											</table>
											<?php } ?>
											
											<h6>Support Request</h6>
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-capitalize"><th class="text-left" style="width: ; min-width: px;">Reference No.</th><th class="text-center">Date Created </th></tr>
												</thead>
												<tbody>
													<?php if($dsr[0]['asrg'] == 2){?>
													<tr><td class="text-right"><?php echo $dsr[0]['refno']; ?></td><td class="text-right"><?php echo $dsr[0]['refduration']; ?></td></tr>
													<tr>
														<td class="text-right" colspan="2"><?php if(isset($dsr[0]['asrg_detail'])) echo $dsr[0]['asrg_detail']; ?></td>
													</tr>
													<?php } elseif($dsr[0]['asrg'] == 1){ ?>
													<tr><td class="text-center">No Request Generated</td></tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
									<?php if(!isset($dsr[0]['nohlsstatus1']) && !isset($dsr[0]['sohlsstatus1'])){} if(isset($dsr[0]['nohlsstatus1']) || isset($dsr[0]['sohlsstatus1'])){ ?>
									<div class="row"><div class="mx-auto"><h5>Inventory Report</h5></div></div>
									<div class="row">
										<div class="col-md-12">
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr> <th>Lane</th> <th>Boom Arm</th> <th>Boom Mechanical</th> <th>OHLS</th> <th>Thermal Printer</th> <th>TCT</th> <th>Lane PC</th> <th>Traffic Light</th> <th>PFD</th></tr>
												</thead>
												<tbody>
													<?php $a = 0; foreach($north as $n){ $a++ ?>
													<tr>
														<td><?php echo $n['bound'].$a; ?></td> <td><?php if($n['inventory_boom_arm_status'] == 1){ echo 'OK';} if($n['inventory_boom_arm_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $n['inventory_boom_arm_description'];} ?></td> <td><?php if($n['inventory_boom_mechanical_status'] == 1){ echo 'OK';} if($n['inventory_boom_mechanical_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $n['inventory_boom_mechanical_description'];} ?></td> <td><?php if($n['inventory_ohls_status'] == 1){ echo 'OK';} if($n['inventory_ohls_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $n['inventory_ohls_description'];} ?></td> <td><?php if($n['inventory_thermal_printer_status'] == 1){ echo 'OK';} if($n['inventory_thermal_printer_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $n['inventory_thermal_printer_description'];} ?></td> <td><?php if($n['inventory_tct_status'] == 1){ echo 'OK';} if($n['inventory_tct_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $n['inventory_tct_description'];} ?></td> <td><?php if($n['inventory_lanepc_status'] == 1){ echo 'OK';} if($n['inventory_lanepc_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $n['inventory_lanepc_description'];} ?></td> <td><?php if($n['inventory_traffic_light_status'] == 1){ echo 'OK';} if($n['inventory_traffic_light_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $n['inventory_traffic_light_description'];} ?></td> <td><?php if($n['inventory_pfd_status'] == 1){ echo 'OK';} if($n['inventory_pfd_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $n['inventory_pfd_description'];} ?></td>
													</tr>
													<?php } $a = 0; foreach($south as $s){ $a++ ?>
													<tr>
														<td><?php echo $s['bound'].$a; ?></td> <td><?php if($s['inventory_boom_arm_status'] == 1){ echo 'OK';} if($s['inventory_boom_arm_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $s['inventory_boom_arm_description'];} ?></td> <td><?php if($s['inventory_boom_mechanical_status'] == 1){ echo 'OK';} if($s['inventory_boom_mechanical_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $s['inventory_boom_mechanical_description'];} ?></td> <td><?php if($s['inventory_ohls_status'] == 1){ echo 'OK';} if($s['inventory_ohls_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $s['inventory_ohls_description'];} ?></td> <td><?php if($s['inventory_thermal_printer_status'] == 1){ echo 'OK';} if($s['inventory_thermal_printer_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $s['inventory_thermal_printer_description'];} ?></td> <td><?php if($s['inventory_tct_status'] == 1){ echo 'OK';} if($s['inventory_tct_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $s['inventory_tct_description'];} ?></td> <td><?php if($s['inventory_lanepc_status'] == 1){ echo 'OK';} if($s['inventory_lanepc_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $s['inventory_lanepc_description'];} ?></td> <td><?php if($s['inventory_traffic_light_status'] == 1){ echo 'OK';} if($s['inventory_traffic_light_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $s['inventory_traffic_light_description'];} ?></td> <td><?php if($s['inventory_pfd_status'] == 1){ echo 'OK';} if($s['inventory_pfd_status'] == 2){ echo 'Faulty'; echo '<br>'; echo $s['inventory_pfd_description'];} ?></td>
													</tr>
													<?php } ?>
												</tbody>
											</table>
											
										</div>
									</div>
									<?php }  if($dsr[0]['pcelectricity'] == 2 && $dsr[0]['dsr_generator_log']){ ?>
									<div class="row"><div class="mx-auto"><h5>Generator-Log</h5></div></div>
									<div class="row">
										<div class="col-md-12">
											<table class="table table-bordered table-hover text-right">
												<thead>
													<tr class="text-center"><td colspan="3">Loadshedding</td><td colspan="12">Generator</td></tr>
													<tr>
														<td>From</td>
														<td>To</td>
														<td>Total TIme</td>
														<td>Ran From</td>
														<td>Ran Till</td>
														<td>Total Time</td>
														<td>Diesel Per Hour</td>
														<td>Diesel Consumed</td>
														<td>Output Voltage</td>
														<td>Fuel Level</td>
														<td>Oil Level</td>
														<td>Oil Change</td>
														<td>Radiator Water Level</td>
														<td>Battery Water Level</td>
														<td>Battery Terminal Condition</td>
													</tr>
												</thead>
												<tbody><tr>
													<td><?php echo $dsr[0]['load_from'] ?></td>
													<td><?php echo $dsr[0]['load_to'] ?></td>
													<td><?php echo $dsr[0]['load_time'] ?></td>
													<td><?php echo $dsr[0]['generator_from'] ?></td>
													<td><?php echo $dsr[0]['generator_to'] ?></td>
													<td><?php echo $dsr[0]['generator_time'] ?></td>
													<td><?php echo $dsr[0]['diesel_per_hour'] ?></td>
													<td><?php echo $dsr[0]['diesel_consumed'] ?></td>
													<td><?php echo $dsr[0]['output_voltage'] ?></td>
													<td><?php if ($dsr[0]['fuel_level'] == 1){echo 'Ok';}elseif($dsr[0]['fuel_level'] == 2){ echo 'Satisfactory';}elseif($dsr[0]['fuel_level'] == 3){ echo 'Low';}elseif($dsr[0]['fuel_level'] == 4){ echo 'Refill';} ?></td>
													<td><?php if ($dsr[0]['oil_level'] == 1){echo 'Ok';}elseif($dsr[0]['oil_level'] == 2){ echo 'Satisfactory';}elseif($dsr[0]['oil_level'] == 3){ echo 'Low';}elseif($dsr[0]['oil_level'] == 4){ echo 'Refill';} ?></td>
													<td><?php if ($dsr[0]['oil_change'] == 1){echo 'Not Needed';}elseif($dsr[0]['oil_change']){ echo 'Changed';} ?></td>
													<td><?php if ($dsr[0]['radiator_water_level'] == 1){echo 'Ok';}elseif($dsr[0]['radiator_water_level'] == 2){ echo 'Satisfactory';}elseif($dsr[0]['radiator_water_level'] == 3){ echo 'Low';}elseif($dsr[0]['radiator_water_level'] == 4){ echo 'Refill';} ?></td>
													<td><?php if ($dsr[0]['battery_water_level'] == 1){echo 'Ok';}elseif($dsr[0]['battery_water_level'] == 2){ echo 'Satisfactory';}elseif($dsr[0]['battery_water_level'] == 3){ echo 'Low';}elseif($dsr[0]['battery_water_level'] == 4){ echo 'Refill';} ?></td>
													<td><?php if ($dsr[0]['battery_terminal_condition'] == 1){echo 'Ok';}elseif($dsr[0]['battery_terminal_condition'] == 2){ echo 'Corroded';}elseif($dsr[0]['battery_terminal_condition'] == 3){ echo 'Cleaned';} ?></td>
												</tr></tbody>
											</table>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<!--a href="<?php echo base_url()?>toolplaza/generate_dsr_pdf/<?php echo $dsr[0]['id'];?>" class="btn btn-info pull-right"><i class="fa fa-file-pdf-o"></i> &nbsp;Gemerate PDF</a-->
					</div>
				</div>
			</div>
		</div>
	</div>
    <script src="<?php echo base_url()?>assets/back/js/vendor/jquery-2.2.4.min.js"></script> 
	<!-- bootstrap 4 js --><script src="<?php echo base_url()?>assets/back/js/bootstrap.min.js"></script>
</body>