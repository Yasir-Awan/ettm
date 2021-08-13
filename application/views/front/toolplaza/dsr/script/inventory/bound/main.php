var togbound = 'toggle-<?php echo $inv['abr']; ?>';
$('#'+togbound+'-no').click(function(){ $('#div-<?php echo $inv['abr']; ?>').addClass('d-none'); });
$('#'+togbound+'-yes').click(function(){ $('#div-<?php echo $inv['abr']; ?>').removeClass('d-none'); });