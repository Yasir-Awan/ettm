<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>Total DSR Uploaded <?php if(isset($id)){ if($id == 'today'){ echo 'Today';} if($id == 'current-month'){ echo 'in current month';} if($id == 'current-quarter'){ echo 'in current quarter';} if($id == 'current-semiannual'){ echo 'in half year';} } ?> </small>
				<h3 class="card-title fw-l text-right"><?php if($dsr){ echo $dsr_count; } else { echo "Not Calculated Yet"; }; ?></h3>
			</div>
		</div>
	</div>
</div>
<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>Total DSR Not Uploaded <?php if(isset($id)){ if($id == 'today'){ echo 'Today';}if($id == 'current-month'){ echo 'in current month';} if($id == 'current-quarter'){ echo 'in current quarter';} if($id == 'current-semiannual'){ echo 'in half year';} } ?></small>
				<h3 class="card-title fw-l text-right"><?php  if($dsr){ echo $toolplaza_dsr; } else { echo "Not Calculated Yet"; } ?></h3>
			</div>
		</div>
	</div>
</div>