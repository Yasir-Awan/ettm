<div id="upper_panel" class="col-md-12 col-xs-12">
			<div class="row gutter-xs">
				<div class="col-xs-12 col-md-12">
					<div class="card">
						<div class="card-title">Traffic Summary</div>
						<div class="card-values">
							<div class="p-x">
								<table class="table table-hover" style="line-height: 0.5;">
									<thead>
										<tr class="table-info">
											<th >Vehicle Type</th>
											<th class="text-right">Car</th>
											<th class="text-right">Wagon</th>
											<th class="text-right">Truck</th>
											<th class="text-right">Bus</th>
											<th class="text-right">Art. Truck</th>
											<th class="text-right">Total</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th scope="col">Traffic</th>
											<?php for($class = 1; $class < 6; $class++){ ?>
											<td class="text-right"><?php echo number_format($total_not_exempt_clas[$class]) ?></td>
											<?php } ?>
											<td class="text-right"><?php echo number_format($total_not_exempt) ?></td>
										</tr>
										<tr>
											<th scope="col">Exempt</th>
											<?php for($class = 1; $class < 6; $class++){ ?>
											<td class="text-right"><?php echo number_format($total_exempt_clas[$class]) ?></td>
											<?php } ?>
											<td class="text-right"><?php echo number_format($total_exempt) ?></td>
										</tr>
										<tr>
											<th scope="col">Revenue</th>
											<?php for($class = 1; $class < 6; $class++){ ?>
											<td class="text-right"><?php echo number_format($total_revenue_clas[$class]) ?></td>
											<?php } ?>
											<td class="text-right"><?php echo number_format($total_revenue) ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>