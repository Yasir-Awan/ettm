<div class="row">
	<div class="col-md-12">
		<?php echo form_open(base_url()."admin/add_plaza_do/",array('id' => 'add_toolplaza'));?>
		<div class="form-group">
			<label for="toolplazaname" style="font-weight: 900;">Toll Plaza Name</label>
			<input type="text" name="toolplazaname" class="form-control required" id="toolplazaname"  placeholder="Enter toll plaza name">
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="toolplazabound1" style="font-weight: 900;">Toll Plaza Bound 1</label>
					<select name="toolplazabound1" class="form-control required" id="toolplazabound1">
						<option value="">---Select Toolplaza Bound---</option>
						<option value="0">Nill</option>
						
						<?php $no = 0; foreach($bound as $b){ ?>
						<option value="<?php echo $b['id'] ?>"><?php echo $b['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="toolplazabound2" style="font-weight: 900;">Toll Plaza Bound 2</label>
					<select name="toolplazabound2" class="form-control required" id="toolplazabound2">
						<option value="">---Select Toolplaza Bound---</option>
						<option value="0">Nill</option>
						
						<?php $no = 0; foreach($bound as $b){ ?>
						<option value="<?php echo $b['id'] ?>"><?php echo $b['name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="numberoflanes" style="font-weight: 900;">Total Lanes in Bound</label>
					<select name="numberoflanes" class="form-control required" id="numberoflanes">
						<option value="">---Select Toolplaza Lanes---</option>
						<?php for($v = 1; $v <= 8; $v++){ ?>
							<option value="<?php echo $v ?>"><?php echo $v; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<span class="btn btn-primary pull-right btn-xs" onclick="form_submit('add_toolplaza');"> Add Toll Plaza</span>
	</div>
	<?php echo form_close();?>
</div>