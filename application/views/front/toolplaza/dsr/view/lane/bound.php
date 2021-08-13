<div class="col-sm-6 col-xl-6 col-md-6">
	<div>
		<h4 class="text-md-center text-xl-center text-lg-center text-sm-center m-b-10">
			<?php if(isset($bound['name'])){ echo $bound['name'];} ?> 
		</h4>
		<table class="table table-bordered table-hover text-right">
			<thead class="bg-warning">
				<tr class="text-capitalize">
					<th class="text-left" style="width:5%">Lane</th>
					<th class="text-center" style="width:10%;">Status</th>
					<th class="text-center" style="width:10%">Responsible</th>
					<th class="text-centered" style="width:10%">From</th>
					<th class="text-centered" style="width:10%">To</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				if(isset($bound['lane'])){
					$lane_number = 0;
					foreach($bound['lane'] as $lane){
						include('main.php');
						$lane_number++;
					}
				}
				else{
					echo '<tr class="text-danger">No Lane is found in DSR</tr>';
				}
			?>
			</tbody>
		</table>
	</div>
</div>