<?php if(isset($dsr[0][0]['uploaded'])){ ?>
<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>DSR Uploaded <?php if(isset($id)){ if($id == 'today'){ echo 'Today';}if($id == 'current-month'){ echo 'in current month';} if($id == 'current-quarter'){ echo 'in current quarter';} if($id == 'current-semiannual'){ echo 'in half year';} } ?></small>
				<h3 class="card-title fw-l text-right"><?php  if($dsr[0][0]){ echo $dsr[0][0]['uploaded']; } else { echo "Not Calculated Yet"; } ?></h3>
			</div>
		</div>
	</div>
</div>
<?php }  ?>
<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>DSR Not Uploaded <?php if(isset($id)){ if($id == 'today'){ echo 'Today';}if($id == 'current-month'){ echo 'in current month';} if($id == 'current-quarter'){ echo 'in current quarter';} if($id == 'current-semiannual'){ echo 'in half year';} } ?></small>
				<h3 class="card-title fw-l text-right"><?php  if($dsr[0][0]){ echo $dsr[0][0]['not_uploaded']; } else { echo "Not Calculated Yet"; } ?></h3>
			</div>
		</div>
	</div>
</div>
<?php if($dsr[0][0]['uploaded'] != 0){ if(isset($dsr[0][0]['approved'])){ ?>
<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>DSR Approved <?php if(isset($id)){ if($id == 'today'){ echo 'Today';} if($id == 'current-month'){ echo 'in current month';} if($id == 'current-quarter'){ echo 'in current quarter';} if($id == 'current-semiannual'){ echo 'in half year';} } ?> </small>
				<h3 class="card-title fw-l text-right"><?php if($dsr[0][0]){ echo $dsr[0][0]['approved']; } else { echo "Not Calculated Yet"; }; ?></h3>
			</div>
		</div>
	</div>
</div>
<?php }if(isset($dsr[0][0]['rejected'])){ ?>
<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>DSR Rejected <?php if(isset($id)){ if($id == 'today'){ echo 'Today';} if($id == 'current-month'){ echo 'in current month';} if($id == 'current-quarter'){ echo 'in current quarter';} if($id == 'current-semiannual'){ echo 'in half year';} } ?> </small>
				<h3 class="card-title fw-l text-right"><?php if($dsr[0][0]){ echo $dsr[0][0]['rejected']; } else { echo "Not Calculated Yet"; }; ?></h3>
			</div>
		</div>
	</div>
</div>
<?php } } ?>