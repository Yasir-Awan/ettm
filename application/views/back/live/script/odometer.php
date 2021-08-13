<script src="<?php echo base_url();?>assets/back/js/odometer.js"></script>
<script>
	var k = 0;
	var odometers = document.querySelectorAll(".odometer");
	for (var i = 0, len = odometers.length; i < len; ++i) {
		var it = odometers[i];
		var desc = it.parentNode.querySelector(".desc");
		var valuee = it.textContent || it.innerText; 
		var format = it.getAttribute("data-format");
		var minIntegerLen = it.getAttribute("data-min-integer-len");
		if (minIntegerLen)
			minIntegerLen = parseInt(minIntegerLen);
		else 
			minIntegerLen = 0;
		if (!format){
			//desc.textContent = "real value";
		}
		else {
			try {
				od = new Odometer({
					el: it,
					value: valuee,
					format: format,
					minIntegerLen: minIntegerLen
				});
			}
			catch (e) {
				alert(e.message);
			}
		}
	}
</script>