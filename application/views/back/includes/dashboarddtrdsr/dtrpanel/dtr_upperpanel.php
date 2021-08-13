<?php if(isset($dtr[0][0]['uploaded'])){ ?>
<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>DTR Uploaded <?php if(isset($id)){ if($id == 'today-dtr'){ echo 'Today';}if($id == 'current-month'){ echo 'in current month';} if($id == 'current-quarter'){ echo 'in current quarter';} if($id == 'current-semiannual'){ echo 'in half year';} } ?></small>
				<h3 class="card-title fw-l text-right"><?php  if($dtr[0][0]){ echo $dtr[0][0]['uploaded']; } else { echo "Not Calculated Yet"; } ?></h3>
			</div>
		</div>
	</div>
</div>
<?php }  ?>
<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>DTR Not Uploaded <?php if(isset($id)){ if($id == 'today-dtr'){ echo 'Today';}if($id == 'current-month'){ echo 'in current month';} if($id == 'current-quarter'){ echo 'in current quarter';} if($id == 'current-semiannual'){ echo 'in half year';} } ?></small>
				<h3 class="card-title fw-l text-right"><?php  if($dtr[0][0]){ echo $dtr[0][0]['not_uploaded']; } else { echo "Not Calculated Yet"; } ?></h3>
			</div>
		</div>
	</div>
</div>
<?php if($dtr[0][0]['uploaded'] != 0){ if(isset($dtr[0][0]['approved'])){ ?>
<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>DTR Approved <?php if(isset($id)){ if($id == 'today-dtr'){ echo 'Today';} if($id == 'current-month'){ echo 'in current month';} if($id == 'current-quarter'){ echo 'in current quarter';} if($id == 'current-semiannual'){ echo 'in half year';} } ?> </small>
				<h3 class="card-title fw-l text-right"><?php if($dtr[0][0]){ echo $dtr[0][0]['approved']; } else { echo "Not Calculated Yet"; }; ?></h3>
			</div>
		</div>
	</div>
</div>
<?php }if(isset($dtr[0][0]['rejected'])){ ?>
<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>DTR Rejected <?php if(isset($id)){ if($id == 'today-dtr'){ echo 'Today';} if($id == 'current-month'){ echo 'in current month';} if($id == 'current-quarter'){ echo 'in current quarter';} if($id == 'current-semiannual'){ echo 'in half year';} } ?> </small>
				<h3 class="card-title fw-l text-right"><?php if($dtr[0][0]){ echo $dtr[0][0]['rejected']; } else { echo "Not Calculated Yet"; }; ?></h3>
			</div>
		</div>
	</div>
</div>
<?php } } ?>