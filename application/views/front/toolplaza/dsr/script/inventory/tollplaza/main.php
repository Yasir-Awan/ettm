var togtoll = 'toggle-<?php echo $inv['abr']; ?>';
$('#'+togtoll+'-no').click(function(){ $('#div-<?php echo $inv['abr']; ?>').addClass('d-none'); });
$('#'+togtoll+'-yes').click(function(){ $('#div-<?php echo $inv['abr']; ?>').removeClass('d-none'); });