<div class="row">
	<div class="col-md-6 pr-1">
		<div class="form-group"> 
			<label>Toll Plaza: </label> 
			<input type="text" class="form-control" disabled="" placeholder="tollplaza" value="<?php echo $dsr_heading[0]['tollplaza_name']; ?>"> 
		</div> 
	</div> 
	<div class="col-md-6 pr-1"> 
		<div class="form-group"> 
			<label>Date: </label> 
			<?php date_default_timezone_set('Asia/Karachi');?> 
			<input name='datecreated' id="datecreated" autocomplete="off" class="form-control required" value='<?php if(isset($dsr['dsr'][0]['dsr_date'])){ echo $dsr['dsr'][0]['dsr_date'] ;} else{ set_value('datecreated');}?>'> 
		</div> 
	</div>
</div>
<div class="row">
	<div class="col-md-6 pr-1"> 
		<div class='form-group'> 
			<label>Prepared By:</label> 
			<input type='text' class='form-control' disabled='' placeholder='preparedby' value='<?php echo $dsr_heading[0]['supervisor_name']; ?>'> 
		</div> 
	</div> 
	<div class="col-md-6 pr-1"> 
		<div class="form-group"> 
			<label>Designation:</label> 
			<input type='text' class='form-control' disabled='' placeholder='designation' value='<?php if($dsr_heading[0]['supervisor_id'] == 12 || $dsr_heading[0]['supervisor_id'] == 13 || $dsr_heading[0]['supervisor_id'] == 15){ echo "Technical Manager"; } elseif($dsr_heading[0]['supervisor_id'] == 20){ echo "Technician"; } elseif($dsr_heading[0]['supervisor_id'] == 14 || $dsr_heading[0]['supervisor_id'] == 16 || $dsr_heading[0]['supervisor_id'] == 17 || $dsr_heading[0]['supervisor_id'] == 18 || $dsr_heading[0]['supervisor_id'] == 19 || $dsr_heading[0]['supervisor_id'] == 22 || $dsr_heading[0]['supervisor_id'] == 23 ) { echo 'Site Incharge';} else { echo "Supervisor";}?>'> 
		</div> 
	</div>
</div>
<div class='row'>
	<div class="col-md-6 pr-1"> 
		<div class="form-group"> 
			<label>Phone No.:</label> 
			<input type='text' class='form-control' disabled='' placeholder='phoneno.' value='<?php echo $dsr_heading[0]['supervisor_contact'];  ?>'>
		</div> 
	</div> 
	<div class="col-md-6 pr-1">  
		<div class="form-group">  
			<label>OMC:</label> 
			<select class="form-control required" name="omc" id="omc" type="int">  
				<option value="">Choose OMC</option> 
				<?php foreach($dsr_heading[0]['omc'] as $val){?> 
				<option <?php if(isset($dsr['dsr'][0]['omc_id'])){ if($dsr['dsr'][0]['omc_id'] == $val['id']){ echo 'selected' ;}else{ echo $val['id']; } } ?> value="<?php echo $val['id'];?>"> <?php echo $val['name'];?></option> 
				<?php } ?> 
			</select>  
		</div> 
	</div>
</div>