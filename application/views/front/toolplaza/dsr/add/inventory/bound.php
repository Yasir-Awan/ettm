<?php  $i = 0; $j = 0;  foreach($dsr_bound as $b){ if(isset($b_inventory[$i])){	foreach($b_inventory[$i] as $inv){?> 
<div class="col-md-6">
	<div class="container row">
		<?php include('bound/main.php'); ?>
	</div>
</div>
<?php  $j++;} } $i++; }  ?>