var togsec1 = 'toggle-<?php echo $s['abr']; ?>';
$('#'+togsec1+'-open').click(function(){ $('#div-<?php echo $s['abr'] ?>').addClass('d-none'); });
$('#'+togsec1+'-closed').click(function(){ $('#div-<?php echo $s['abr'] ?>').removeClass('d-none'); });
$('#'+togsec1+'-omc,#'+togsec1+'-tech').click(function(){ $('#expand-div-<?php echo $s['abr']; ?>').removeClass('d-none'); });