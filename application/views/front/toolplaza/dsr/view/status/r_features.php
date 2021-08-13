<?php if(isset($dsr[0]['r_features'])){ ?>
<div class="col-md-4 col-sm-4 col-lg-4 col-xl-4">
	<h5 class="m-b-10 text-center">Plaza Condition</h5>
	<div class="table-responsive">
		<table class="table table-condensed table-bordered table-hover text-right" style="table-layout:auto">
			<thead class="text-capitalize bg-warning">
				<tr>
					<th style="width:30%">Name</th>
					<th>Rating</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php include('r_features_table.php'); ?>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php }?>