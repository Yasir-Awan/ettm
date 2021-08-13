var invnsec1 = 'toggle-<?php echo $inv['abr']; ?>';
$('#'+invnsec1+'-no').click(function(){ $('#div-<?php echo $inv['abr'] ?>').addClass('d-none'); });
$('#'+invnsec1+'-yes').click(function(){ $('#div-<?php echo $inv['abr'] ?>').removeClass('d-none'); });