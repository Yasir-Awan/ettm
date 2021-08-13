<div class="col-md-12 col-xs-12" id="dtr-extended">
	<div class="row">
		<div class="col-md-12 col-xs-12" id="toll-name">
			<div class="card">
				<div class="card-title text-center"><h4><?php if(isset($toolplaza)) echo $toolplaza; ?></h4></div>
			</div>
		</div>
		<div class="col-md-4 col-xs-4" id="not-uploaded">
			<div class="card">
				<div class="card-title text-center"><h4>Not Uploaded</h4></div>
				<div class="card-body text-center">
					<div class="media">
						<div style="margin: 0 auto">
							<ul>
								<?php if(isset($dates['missing'])){$l = 0; foreach($dates['missing'] as $date){ ?>
								<li px-5><?php echo $date; ?></li>
								<?php $l++; } } ?>
							</ul>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-4" id="not-uploaded">
			<div class="card">
				<div class="card-title text-center"><h4>Pending</h4></div>
				<div class="card-body text-center">
					<div class="media">
						<div style="margin: 0 auto">
							<ul>
								<?php if(isset($dates['pending'])){$y = 0; foreach($dates['pending'] as $date){ ?>
								<li px-5><?php echo $date; ?></li>
								<?php $y++; } }  ?>
							</ul>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-4" id="not-uploaded">
			<div class="card">
				<div class="card-title text-center"><h4>Rejected</h4></div>
				<div class="card-body text-center">
					<div class="media">
						<div style="margin: 0 auto">
							<ul>
								<?php if(isset($dates['rejected'])){if($dates['rejected'] != ''){$m = 0; foreach($dates['rejected'] as $date){ ?>
								<li px-5><?php echo $date; ?></li>
								<?php $m++; } } } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

