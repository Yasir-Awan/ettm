<div class="card">
	<h4 class="m-b-10 text-center"><strong>Inventory Report</strong></h4>
	<div class="card-body">
		<?php if(isset($dsr[0]['name_inventory']['lane'])){ ?>
		<div class="row">
			<?php include('inventory/lane_inventory.php'); ?>
		</div>
		<?php } ?>
		
		<div class="row">
			<?php if(isset($dsr[0]['name_inventory']['bound_inventory'])){ ?>
			<?php include('inventory/bound_inventory.php'); ?>
			<?php } ?>
			<?php if(isset($dsr[0]['name_inventory']['tollplaza'])){ ?>
			<?php include('inventory/inventory.php'); ?>
			<?php } ?>
		</div>
	</div>
</div>