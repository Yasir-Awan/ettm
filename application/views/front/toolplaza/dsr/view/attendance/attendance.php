<?php if(isset($dsr[0]['staff'])){ ?>
<div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
	<div class="table-responsive">
		<h5 class="m-b-10 text-center">Attendance</h5>
		<table class="table table-condensed table-bordered table-hover text-right" style="table-layout:auto">
			<thead class="text-capitalize bg-warning">
				<tr>
					<th style="width:25%">Name</th>
					<th>Attendance</th>
					<th>Leave From</th>
					<th>Leave To</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php include('attendance_table.php'); ?>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php }?>