

<?php 
	if($dtr){
		if($current){ 
			if($section == 'summary'){
				include("dtrdashboard/html/summarychartsscript.php");
				include("dtrdashboard/html/summarychartshtml.php");?> 
			<?php }
			elseif($section == 'traffic'){
				include("dtrdashboard/html/trafficchartsscript.php");
				include("dtrdashboard/html/trafficchartshtml.php");
			}
			elseif($section == 'revenue'){
				include("dtrdashboard/html/revenuechartsscript.php");
				include("dtrdashboard/html/revenuechartshtml.php");
			}
		}		
	}
	elseif(!$dtr){ ?>	
		<div class="p-4"><?php echo $message ?></div>
	<?php  }   ?>