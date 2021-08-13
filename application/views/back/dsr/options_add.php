<div class="row">
	<div class="col-md-12">
		<?php if(isset($options)){ echo form_open(base_url()."admin/dsr_feature_options/update/".$options[0]['id'],array('id' => 'edit_dsr_feature_option')); } else{ echo form_open(base_url()."admin/dsr_feature_options/add_do/",array('id' => 'add_dsr_feature_option')); }?>
		<div class="form-group">
			<label for="option_name" style="font-weight: 900;">Option Name</label>
			<input type="text" name="name" class="form-control required" id="option_name" placeholder="Enter Option name" value="<?php if(isset($options)){ echo $options[0]['name'];} else{ set_value('name');} ?>">
		</div>
			<div id="appendd" class="form-group">
				<select name="type" class="form-control required" id="type">
					<option value="">Select</option>
					<option id="status" value="1" <?php if(isset($options)){ if($options[0]['type'] == 1){  echo 'selected';} } ?> >Status</option>
					<option id="rating" value="2" <?php if(isset($options)){ if($options[0]['type'] == 2){ echo 'selected';} } ?> >Rating</option>
				</select>
			</div>
		
		<span class="btn btn-primary pull-right btn-xs" onclick="form_submit(<?php if(isset($options)){ ?>'edit_dsr_feature_option'<?php } else{ ?>'add_dsr_feature_option'<?php } ?>);" ><?php if(isset($options)){ ?>Update <?php } else{ ?>Add <?php } ?> Option</span>
		<?php echo form_close();?>
	</div>
</div>
<script>
	$(document).ready(function(){
		<?php if(isset($options)){ ?>
			if($('#type').val() == 1){
				$('#rating-value').remove();
				$('#appendd').append('<div id="status-value" class="form-group"><br><select name="value" id="value" class="form-control required"><?php for($i = 0; $i < 2; $i++){ ?><option <?php if(isset($options)){ if($options[0]['value'] == $i){ echo 'selected';} } ?>  value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select></div>');
			}
			else if($('#type').val() == 2){
				$('#status-value').remove();
				$('#appendd').append('<div id="rating-value" class="form-group"><br><select name="value" id="value" class="form-control required"><?php for($i = 1; $i < 6; $i++){ ?><option <?php if(isset($options)){ if($options[0]['type'] == $i){ echo 'selected';} } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select></div>');
			}
			else{
				$('#status-value').remove();
				$('#rating-value').remove();
			}
		<?php } ?>
		$('#type').change(function(){ 
			if($('#type').val() == 1){
				$('#rating-value').remove();
				$('#appendd').append('<div id="status-value" class="form-group"><br><select name="value" id="value" class="form-control required"><?php for($i = 0; $i < 2; $i++){ ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select></div>');
			}
			else if($('#type').val() == 2){
				$('#status-value').remove();
				$('#appendd').append('<div id="rating-value" class="form-group"><br><select name="value" id="value" class="form-control required"><?php for($i = 1; $i < 6; $i++){ ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php } ?></select></div>');
			}
			else{
				$('#status-value').remove();
				$('#rating-value').remove();
			}
		});
	});
</script>