<div class="col-sm-4 col-xl-4 col-md-4">
	<h5 class="m-b-10 text-center">Plaza</h5>
	<div class="table-responsive">
		<?php if(isset($dsr[0]['name_inventory']['tollplaza'])){ ?>
		<table class="table table-condensed table-bordered table-hover text-right" style="table-layout:auto">
			<thead class="">
				<tr class="text-capitalize bg-warning">
					<th class="text-left" style="width:10%">Plaza</th>
					<th>Status/Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php include('main/main.php'); ?>
					
				</tr>
			</tbody>
		</table>
		<?php }else{ echo '<div class="text-danger">Tollplaza Inventory was not found</div>';} ?>
	</div>
</div>