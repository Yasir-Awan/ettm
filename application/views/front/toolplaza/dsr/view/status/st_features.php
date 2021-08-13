<?php if(isset($dsr[0]['s_features'])){  ?>
<div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
	<h5 class="m-b-10 text-center">Time Related</h5>
	<div class="table-responsive">
		<table class="table table-condensed table-bordered table-hover text-right" style="table-layout:auto">
			<thead class="text-capitalize bg-warning">
				<tr>
					<th style="width:25%">Name</th>
					<th>Status</th>
					<th>Time From</th>
					<th>Time To</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php include('st_features_table.php'); ?>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php }?>