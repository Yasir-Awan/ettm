var invssec1 = 'toggle-<?php echo $inv['abr']; ?>';
$('#'+invssec1+'-no').click(function(){ $('#div-<?php echo $inv['abr'] ?>').addClass('d-none'); });
$('#'+invssec1+'-yes').click(function(){ $('#div-<?php echo $inv['abr'] ?>').removeClass('d-none'); });