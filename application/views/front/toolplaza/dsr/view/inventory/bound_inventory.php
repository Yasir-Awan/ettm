<div class="col-sm-8 col-xl-8 col-lg-8 col-md-8">
	<h5 class="m-b-10 text-center">Bound</h5>
	<div class="table-responsive">
		<?php if(isset($dsr[0]['name_inventory']['bound_inventory'])){ ?>
		<table class="table table-condensed table-bordered table-hover text-right" style="table-layout:auto">
			<thead class="">
				<tr class="text-capitalize bg-warning">
					<th class="text-left" style="width:15%">Bound</th>
					<?php include('bound/main.php'); ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php include('bound/loop.php'); ?>
				</tr>
			</tbody>
		</table>
		<?php }else{ echo '<div class="text-danger">Bound Inventory was not found</div>';} ?>
	</div>
</div>