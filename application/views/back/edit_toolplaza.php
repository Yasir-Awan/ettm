<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/edit_plaza_do/".$toolplza[0]['id'],array('id' => 'edit_toolplaza'));?>
    <div class="form-group">
      <label for="toolplazaname" style="font-weight: 900;">Toll Plaza Name</label>
      <input type="text" name="toolplazaname"  value= '<?php echo $toolplza[0]['name']?>'class="form-control required" id="toolplazaname"  placeholder="Enter toll plaza name">
      
    </div>
	  <div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="toolplazabound1" style="font-weight: 900;">Toll Plaza Bound 1</label>
					<select name="toolplazabound1" class="form-control required" id="toolplazabound1">
						<option value="">---Select Toolplaza Bound---</option>
						<option value="0">Nill</option>
						
						<?php $no = 0; foreach($bound as $b){ ?>
						<option <?php if(isset($value[0])){ if($value[0] == $b['id']){ echo 'selected';} } ?> value="<?php echo $b['id'] ?>"><?php echo $b['name']; ?></option>
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
						<option <?php if(isset($value[1])){ if($value[1] == $b['id']){ echo 'selected';} } ?> value="<?php echo $b['id'] ?>"><?php echo $b['name']; ?></option>
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
							<option <?php if(isset($numberoflanes)){ if($numberoflanes == $v){ echo 'selected';}} ?> value="<?php echo $v ?>"><?php echo $v; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('edit_toolplaza');">Update Toll Plaza</span>
  
<?php echo form_close();?>
</div>
</div>