<div class="col-xs-12 col-md-12">
	<div class="card">
		<div class="card-body">
			<div class="pull-left">
				<h4 class="card-title">DSR Status</h4>
			</div>
			<div class="pull-right" data-toggle="buttons">
				<label class="btn btn-outline-primary btn-xs btn-pill <?php if(isset($id)){ if($id == 'today') echo 'active';}?>" id="today">
					<input type="radio" name="options" autocomplete="off" checked="checked"> Today
				</label>
				<label class="btn btn-outline-primary btn-xs btn-pill <?php if(isset($id)){ if($id == 'yesterday') echo 'active';}?>" id="yesterday">
					<input type="radio" name="options" autocomplete="off" checked="checked"> Yesterday
				</label>
				<label class="btn btn-outline-primary btn-xs btn-pill <?php if(isset($id)){ if($id == 'current-month') echo 'active';}?>" id="current-month">
					<input type="radio" name="options" autocomplete="off"> Current Month
				</label>
				<label class="btn btn-outline-primary btn-xs btn-pill  <?php if(isset($id)){ if($id == 'current-quarter') echo 'active';}?>" id="current-quarter">
					<input type="radio" name="options" autocomplete="off"> Current Quarter
				</label>
				<label class="btn btn-outline-primary btn-xs btn-pill  <?php if(isset($id)){ if($id == 'current-semiannual') echo 'active';}?>" id="current-semiannual">
					<input type="radio" name="options" autocomplete="off"> Current Semi-annual
				</label>
			</div>
		</div>
		<div class="card-body">
			<div class="card-chart-lane">
				<?php if($dsr){ include("dsr_graph.php"); }else{ if(isset($message_dsr)) echo $message_dsr; } ?>
			</div>
		</div>
	</div>
</div>