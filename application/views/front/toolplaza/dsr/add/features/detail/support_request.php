<div class="col-md-12">
	<h6><?php echo $feat['name']; ?></h6>
	<div class="row container">
		<div class="col-md-3 pr-1">
			<div class="form-group">
				<label>Reference No: </label>
				<input name="reference_no_<?php echo $feat['abr']; ?>" type="text" <?php if(isset($dsr['support_request'][0]['reference_no'])){ echo 'value='.$dsr['support_request'][0]['reference_no']; } ?> class="form-control">
			</div>
		</div>
		<div class="col-md-3 pr-1">
			<div class="form-group">
				<label>Date Generated :</label>
				<input name="date_generated_<?php echo $feat['abr']; ?>" type="date" <?php if(isset($dsr['support_request'][0]['date'])){ echo 'value='.$dsr['support_request'][0]['date']; } ?> class="form-control">
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Detail :</label>
				<textarea name="detail_<?php echo $feat['abr']; ?>" class="form-control" style="border:'1px solid #E3E3E3'" width="100%"><?php if(isset($dsr['support_request'][0]['detail'])){ echo $dsr['support_request'][0]['detail']; } ?></textarea>
			</div>
		</div>
	</div>
</div>