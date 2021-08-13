<div class="col-xs-6 col-md-6">
					<div class="card">
						<div class="card-values">
							<div class="p-x">
								<small>Duration</small>
								<h3 class="card-title fw-l text-right">
									<select name="duration" id="duration" class="border-0">
										
										<option <?php if($duration == 2){ echo 'selected';} ?> value="1">1 Year</option>
										<option <?php if($duration == 3){ echo 'selected';} ?> value="2">2 Year</option>
										<option <?php if($duration == 4){ echo 'selected';} ?> value="3">3 Years</option>
										<option <?php if($duration == 5){ echo 'selected';} ?> value="4">4 Years</option>
										<option <?php if($duration == 6){ echo 'selected';} ?> value="">5 Years</option>
									</select>
								</h3>
							</div>
						</div>
					</div>
				</div>
<div class="col-xs-6 col-md-6">
					<div class="card">
						<div class="card-values">
							<div class="p-x">
								<small>Location</small>
								<h3 class="card-title fw-l text-right">
									<select name="tollplaza_id" class="border-0" id="tollplaza_id">
										<option value="none">All Tollplazas</option>
										<?php foreach($tollplaza as $toll){ ?>
										<option <?php if(isset($id)) echo 'selected'; ?> value="<?php echo $toll['id'] ?>"><?php echo $toll['name'] ?></option>
										<?php } ?>
									</select>
								</h3>
							</div>
						</div>
					</div>
				</div>