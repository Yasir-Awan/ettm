<div class="form-group container">
	<div class='row'>
		<div class="col-md-12">
			<h6>Delay Reason:</h6>
			<textarea class="form-control" placeholder="leave blank if none" style="border: 1px solid #E3E3E3;" name="toll_delay" id="toll_delay" cols="100" rows="10"><?php if(isset($dsr['dsr'][0]['toll_delay'])){ echo $dsr['dsr'][0]['toll_delay']; } ?></textarea>
		</div>
		
	</div>
</div>