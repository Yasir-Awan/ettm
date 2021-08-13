<div class="col-xs-12 col-md-12">
	<div class="card">
		<div class="card-body">
			<div class="media">
				<div class="media-middle media-body">
					<h3 class="media-heading"><span class="">Comparison Chart</span></h3>
					<div class="row">
						<div class="col-md-12">
							<table>
								<thead>
									<tr>
										<th width="30%">Month (MTR)</th>
										<th width="30%">Start Date</th>
										<th width="30%">Last Date</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<?php echo form_open(base_url()."admin/dtr_comparison_chart/",array('id' => 'comparison_chart')); ?>
										<td><input class="form-control" autocomplete="off" id ="month" name="month"></td>
										<td><input class="form-control"  autocomplete="off" id="start_date" name="start_date"></td>
										<td><input class="form-control"  autocomplete="off" id="end_date" name="end_date"></td>
										<td><input type="submit" class="btn btn-primary" onclick="form_submit('comparison_chart');" href="<?php echo base_url(); ?>'admin/dtr_comparison_chart" formtarget="_blank"></td>
										<?php echo form_close(); ?>
										
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
					
				
			</div>
		</div>
		
		
	</div>
	
</div>