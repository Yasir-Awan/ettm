<div class="row">
	<div class="col-md-12">
		<?php if(isset($inventory)){ echo form_open(base_url()."admin/inventory/update/".$inventory[0]['id'],array('id' => 'edit_inventory')); } else{ echo form_open(base_url()."admin/inventory/add_do/",array('id' => 'add_inventory')); }?>
		<div class="form-group">
			<label for="inventory_name" style="font-weight: 900;">Inventory Name</label>
			<input type="text" name="name" class="form-control required" id="inventory_name" placeholder="Enter Inventory name" value="<?php if(isset($inventory)){ echo $inventory[0]['name'];} else{ set_value('name');} ?>">
		</div>
		<div class="form-group">
			<label for="installed_at" style="font-weight: 900;">Installed at</label>
			<select name="installed_at" id="installed_at" class="form-control required">
				<option value="" <?php if(isset($inventory)){ if($inventory[0]['installed_at'] == ''){ echo 'selected';} }?>>Select</option>
				<option value="1" <?php if(isset($inventory)){ if($inventory[0]['installed_at'] == 1){ echo 'selected';} }?> >Tollplaza</option>
				<option value="2"<?php if(isset($inventory)){ if($inventory[0]['installed_at'] == 2){ echo 'selected';} }?> >Bound</option>
				<option value="3"<?php if(isset($inventory)){ if($inventory[0]['installed_at'] == 3){ echo 'selected';} }?> >Lane</option>
			</select>
		</div>
		<span class="btn btn-primary pull-right btn-xs" onclick="form_submit(<?php if(isset($inventory)){ ?>'edit_inventory'<?php } else{ ?>'add_inventory'<?php } ?>);" ><?php if(isset($inventory)){ ?>Update <?php } else{ ?>Add <?php } ?> Inventory</span>
		<?php echo form_close();?>
	</div>
</div>