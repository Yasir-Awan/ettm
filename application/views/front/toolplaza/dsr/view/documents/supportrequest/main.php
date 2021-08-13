<?php if(isset($feat['support_request'][0])){  ?>
<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
			<h5 class="m-b-10 text-center">Support Request</h5>
			<div class="table-responsive">
				<table class="table table-condensed table-bordered table-hover text-right" style="table-layout:auto">
					<thead class="text-capitalize bg-warning">
						<tr>
							<th style="width:30%">Name</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<?php include('data.php'); ?>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php }?>