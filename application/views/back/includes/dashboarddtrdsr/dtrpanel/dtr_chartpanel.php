<div class="col-xs-12 col-md-12">
	<div class="card">
		<div class="card-body">
			<div class="pull-left">
				<h4 class="card-title">DTR Status</h4>
			</div>
			<div class="pull-right" data-toggle="buttons">
				<label class="btn btn-outline-primary btn-xs btn-pill <?php if(isset($id)){ if($id == 'today-dtr' || $id == 'today') echo 'active';} ?>" id="today-dtr">
					<input type="radio" name="options" autocomplete="off"> Today
				</label>
				<label class="btn btn-outline-primary btn-xs btn-pill <?php if(isset($id)){ if($id == 'yesterday-dtr') echo 'active';}?>" id="yesterday-dtr">
					<input type="radio" name="options" autocomplete="off" checked="checked"> Yesterday
				</label>
				<label class="btn btn-outline-primary btn-xs btn-pill <?php if(isset($id)){ if($id == 'current-month-dtr') echo 'active';} ?>" id="current-month-dtr">
					<input type="radio" name="options" id="option1" autocomplete="off"> Current Month
				</label>
				<label class="btn btn-outline-primary btn-xs btn-pill <?php if(isset($id)){ if($id == 'current-quarter-dtr') echo 'active';} ?>" id="current-quarter-dtr">
					<input type="radio" name="options" id="option2" autocomplete="off"> Current Quarter
				</label>
				<label class="btn btn-outline-primary btn-xs btn-pill <?php if(isset($id)){ if($id == 'current-semiannual-dtr') echo 'active';} ?>" id="current-semiannual-dtr">
					<input type="radio" name="options" id="option3" autocomplete="off"> Current Semiannual
				</label>
			</div>
		</div>
		<div class="card-body">
			<div class="card-chart">
				<?php if($dtr){ include("dtr_graph.php"); }else{ if(isset($message_dtr)) echo $message_dtr; } ?>
			</div>
		</div>
	</div>
</div>