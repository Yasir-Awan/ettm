<div class="row">
	<div class="col-md-6"> 
		<div class="p-4">Total Traffic <?php echo $tollplazatoday['dtr']['traffic']['total']; ?></div>
		<div id="allchartsummary1<?php echo $duration ?>"></div>
	</div>
	
	<div class="col-md-6">
		<div class="p-4">Total Revenue <?php echo $tollplazatoday['dtr']['revenue']['total']; ?></div>
		<div id="allchartsummary2<?php echo $duration ?>"></div>
	</div>	
</div>