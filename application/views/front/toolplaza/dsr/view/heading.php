<div class="row">
	<div class="col-sm-6 col-xl-6 col-md-6 m-b-20">
		<img src="<?php echo base_url() ?>assets/back/images/icon/logo.png" class="inv-logo" alt="">
		<ul class="list-unstyled mb-0">
			<li class="">Plaza Name: <span><?php if(isset($dsr[0]['tollplaza_name'])){ echo $dsr[0]['tollplaza_name']; } ?> </span></li>
			<li class="">OMC Name: <span><?php if(isset($dsr[0]['omc_name'])){ echo $dsr[0]['omc_name']; } ?></span></li>
		</ul>
	</div>
	<div class="col-sm-6 col-xl-6 col-md-6 m-b-20">
		<div class="text-md-right text-xl-right text-sm-right font-weight-bold">
			<h3 class="text-uppercase">Daily Site Report NHA</h3>
			<ul class="list-unstyled">
				<li class="">Date: <span><?php if(isset($dsr[0]['dsr_date'])){ echo $dsr[0]['dsr_date']; } ?></span></li>
			</ul>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-xl-12 col-md-12 m-b-20">
		<ul class="list-unstyled">
			<li><h5 class="mb-0"><strong><?php if(isset($dsr[0]['supervisor_name'])){ echo $dsr[0]['supervisor_name']; } ?></strong></h5></li>
			<li><span><?php if(isset($dsr[0]['supervisor_designation'])){ if($dsr[0]['supervisor_designation'] == 'TSI'){ echo 'Site Incharge';}else{ echo $dsr[0]['supervisor_designation']; } } ?></span></li>
			<li><?php if(isset($dsr[0]['supervisor_contact'])){ echo $dsr[0]['supervisor_contact']; } ?></li>
		</ul>
	</div>
</div>