<div class="col-xs-12 col-md-12">
	<div class="card">
		<div class="card-body">
			<div class="media">
				<div class="media-middle media-body">
					<h3 class="media-heading"><span class="">Time Comparison</span></h3>
					<div class="row">
						<div class="col-md-12">
							<table>
								<thead>
									<tr>
										<th width="30%">Upload Time</th>
										<th width="30%">Supervise Time</th>
										<th width="30%">Tollplaza</th>
										<th width="20%"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<?php echo form_open(base_url()."admin/dsr_dtr_all_dates/",array('id' => 'all_dates')); ?>
										<td><input class="form-control" class="timepicker" autocomplete="off" value="<?php set_value("upload_time") ?>" id="upload_time" name="upload_time"></td>
										<td><input class="form-control" class="timepicker" autocomplete="off" value="<?php set_value("supervise_time") ?>" id="supervise_time" name="supervise_time"></td>
										<td><select class="form-control" name="tollplaza" id="tollplaza">
											<?php $tool_no = 0; foreach($tool['tool'] as $toll){ ?>
												<option value="<?php echo $toll['id'] ?>"><?php echo $toll['name']; ?></option>	
											<?php } ?>
												<option value="<?php echo 'all' ?>"><?php echo 'All'; ?></option>
											</select>
										</td>
										<input type="hidden" id="id" name="id">
										<td><input type="submit" class="btn btn-primary" onclick="form_submit('all_dates');" href="http://localhost/nha/'admin/dsr_dtr_all_dates" formtarget="_blank"></td>
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