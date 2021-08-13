<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>Total DTR Uploaded <?php if(isset($id)){ if($id == 'today' || $id == 'today-dtr'){ echo 'Today'; } if($id == 'current-month-dtr'){ echo 'in current month';} if($id == 'current-quarter-dtr'){ echo 'in current quarter';} if($id == 'current-semiannual-dtr'){ echo 'in half year';} } ?> </small>
				<h3 class="card-title fw-l text-right"><?php if(isset($dtr_count)){ echo $dtr_count; } else { echo "Not Calculated Yet"; }; ?></h3>
			</div>
		</div>
	</div>
</div>
<div class="col-xs-6 col-md-6">
	<div class="card">
		<div class="card-values">
			<div class="p-x">
				<small>Total DTR Not Uploaded <?php if(isset($id)){ if($id == 'today' || $id == 'today-dtr'){ echo 'Today'; } if($id == 'current-month-dtr'){ echo 'in current month';} if($id == 'current-quarter-dtr'){ echo 'in current quarter';} if($id == 'current-semiannual-dtr'){ echo 'in half year';} } ?> </small>
				<h3 class="card-title fw-l text-right"><?php  if(isset($toolplaza_dtr)){ echo $toolplaza_dtr; } else { echo "Not Calculated Yet"; } ?></h3>
			</div>
		</div>
	</div>
</div>