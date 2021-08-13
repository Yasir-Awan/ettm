var northsec1 = 'toggle-<?php echo $n['abr']; ?>';
$('#'+northsec1+'-open').click(function(){ $('#div-<?php echo $n['abr'] ?>').addClass('d-none'); });
$('#'+northsec1+'-closed').click(function(){ $('#div-<?php echo $n['abr'] ?>').removeClass('d-none'); });
$('#'+northsec1+'-omc,#'+northsec1+'-tech').click(function(){ $('#expand-div-<?php echo $n['abr']; ?>').removeClass('d-none'); });