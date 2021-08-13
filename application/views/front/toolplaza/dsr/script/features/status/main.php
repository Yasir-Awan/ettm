var feature = 'toggle-<?php echo $feat['abr']; ?>';
<?php if($feat['detail'] == 1 || $feat['detail'] == 2){ ?>
	$('#'+feature+'-option0').click(function(){	$('#<?php echo $feat['abr'] ?>-display').addClass('d-none'); });
	$('#'+feature+'-option1').click(function(){ $('#<?php echo $feat['abr'] ?>-display').removeClass('d-none'); });
<?php }  ?>
<?php if($feat['detail'] == 3 || $feat['detail'] == 4){ ?>
	$('#'+feature+'-option0').click(function(){	$('#<?php echo $feat['abr'] ?>-doc-display').addClass('d-none'); });
	$('#'+feature+'-option1').click(function(){ $('#<?php echo $feat['abr'] ?>-doc-display').removeClass('d-none'); });
<?php } ?>
	

