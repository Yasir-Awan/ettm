<div class="row">
	<?php if($this->session->userdata['toolplaza'] == 9){} else{ ?>
	<div class="col-md-6 pr-1">
		<div class="textcenter">North</div><br/>
		<?php if(isset($north)){ ?>
			<?php include('summary/north.php'); ?>
		<?php } ?>
	</div>
	<?php } ?>
	<div class="col-md-6 pr-1">
		<div class="textcenter">South</div><br/>
		<?php if(isset($south)){ ?>
			<?php include('summary/south.php'); ?>
		<?php } ?>
	</div>
</div>