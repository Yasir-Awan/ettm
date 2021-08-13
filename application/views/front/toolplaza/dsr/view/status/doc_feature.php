<?php if(isset($dsr[0]['s_features'])){  ?>
	<div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
		<h5 class="m-b-10 text-center">Documents</h5>
		<div class="table-responsive">
			<table class="table table-condensed table-bordered table-hover text-right" style="table-layout:auto">
				<thead class="text-capitalize bg-warning">
					<tr>
						<th style="width:40%">Name</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php include('doc_features_table.php'); ?>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
<?php }?>