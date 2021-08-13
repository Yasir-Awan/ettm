<div class="col-sm-12 col-xl-12 col-md-12">
	<h5 class="m-b-10 text-center">Lane</h5>
	<div class="table-responsive">
		<?php if(isset($dsr[0]['name_inventory']['lane'])){ ?>
		<table class="table table-condensed table-bordered table-hover text-right" style="table-layout:auto">
			<thead class="">
				<tr class="text-capitalize bg-warning">
					<th class="text-left" style="width:5%">Lane</th>
					<?php include('lane/name.php'); ?>
				</tr>
			</thead>
			<tbody>
				<tr><?php include('lane/bound.php'); ?></tr>
			</tbody>
		</table>
		<?php }else{ echo '<div class="text-danger">Lane Inventory was not found</div>';} ?>
	</div>
</div>