<div class="row">
	<div class="col-md-12">
		<?php if(isset($features)){ echo form_open(base_url()."admin/dsr_generator_log_features/update/".$features[0]['id'],array('id' => 'edit_dsr_feature')); } else{ echo form_open(base_url()."admin/dsr_generator_log_features/add_do/",array('id' => 'add_dsr_feature')); }?>
		<div class="form-group">
			<label for="feature_name" style="font-weight: 900;">Feature Name</label>
			<input type="text" name="name" class="form-control required" id="feature_name" placeholder="Enter Feature name" value="<?php if(isset($features)){ echo $features[0]['name'];} else{ set_value('name');} ?>">
		</div>
		<div class="form-group">
			<label for="type" style="font-weight: 900;">Type</label>
			<select name="type" id="add-options" class="form-control required">
				<option value="" <?php if(isset($features)){ if($features[0]['type'] == ''){ echo 'selected';} }?>>Select</option>
				<option value="1" <?php if(isset($features)){ if($features[0]['type'] == 1){ echo 'selected';} }?> >Status</option>
				<option value="2" <?php if(isset($features)){ if($features[0]['type'] == 2){ echo 'selected';} }?> >Rating</option>
				<option value="3" <?php if(isset($features)){ if($features[0]['type'] == 3){ echo 'selected';} }?> >Value</option>
			</select>
		</div>
		
		<?php if(isset($options)){  ?>
		<div id="options" class="form-group">
			<label for="options" style="font-weight: 900;">Options</label>
			<select name="options[]" id="options" class="form-control" multiple>
				<?php  $i = 0; foreach($options as $option){ ?>
				<option value="<?php echo $option['id']; ?>" <?php if(isset($features)){ if(isset($opted[$i])){ if($opted[$i]['id'] == $option['id']){ echo 'selected'; } } } ?>><?php echo $option['name']; ?></option>
				
				<?php $i++;  }  ?>
			</select>
		</div>
		<?php } ?>
		<div class="form-group">
			<label for="detail" style="font-weight: 900;">Detail</label>
			<select name="detail" id="detail" class="form-control required">
				<option value="0" <?php if(isset($features)){ if($features[0]['detail'] == '0'){ echo 'selected'; } }?> >None</option>
				<option value="1" <?php if(isset($features)){ if($features[0]['detail'] == '1'){ echo 'selected'; } }?> >Description</option>
				<option value="2" <?php if(isset($features)){ if($features[0]['detail'] == '2'){ echo 'selected'; } }?>  >Time</option>
				<option value="3" <?php if(isset($features)){ if($features[0]['detail'] == '3'){ echo 'selected'; } }?>  >Document</option>
				<option value="4" <?php if(isset($features)){ if($features[0]['detail'] == '4'){ echo 'selected'; } }?>  >Log</option>
			</select>
		</div>
		<span class="btn btn-primary pull-right btn-xs" onclick="form_submit(<?php if(isset($features)){ ?>'edit_dsr_feature'<?php } else{ ?>'add_dsr_feature'<?php } ?>);" ><?php if(isset($features)){ ?>Update <?php } else{ ?>Add <?php } ?> Feature</span>
		<?php echo form_close();?>
	</div>
</div>
<script>
	
</script>