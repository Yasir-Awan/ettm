<?php if(isset($inventory_north) || isset($inventory_south) || isset($b_inventory) || isset($t_inventory)){ ?>
<h6>Inventory Status:</h6>
<div class="row">
	<?php if($this->session->userdata['toolplaza'] == 9){}else{ ?>
	<div class="col-md-6">
		<div class="textcenter">North</div><br/>
		<div class="container row">
			<?php include('inventory/north.php'); ?>
		</div>
	</div>
	<?php } ?>
	<div class="col-md-6">
		<div class="textcenter">South</div><br/>
		<div class="row">
			<?php include('inventory/south.php') ?>
		</div>
	</div>
</div><br>
<div class="row">
	<?php  if(isset($b_inventory)) { ?> 
		<?php include('inventory/bound.php'); ?> 
	<?php } ?>
</div><br>
<div class="row">
	<?php if(isset($t_inventory)) { ?> 
		<?php include('inventory/tollplaza.php'); ?>
	<?php } ?>
</div><br>
<?php } ?>