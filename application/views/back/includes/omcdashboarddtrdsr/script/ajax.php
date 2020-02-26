<script type="text/javascript">
	$(document).ready(function(){
		$(this).click(function(event){
			var verify = "#" + event.target.id;
			var id = $(verify).attr('id');
			console.log(verify);
			if(id == "today"){
				$.ajax({
					url: "<?php echo base_url();?>omc/dashboard_dsr",
					type: "POST",
					data: { id },
					async: false,
					success: function(data){
						$("#dsr_panel").html(data);
					}
				})
			}
			if(id == "current-month"){
				$.ajax({
					url: "<?php echo base_url();?>omc/dashboard_dsr",
					type: "POST",
					data: { id },
					async: false,
					success: function(data){
						$("#dsr_panel").html(data);
					}
				})
			}
			if(id == "current-quarter"){
				$.ajax({
					url: "<?php echo base_url();?>omc/dashboard_dsr",
					type: "POST",
					data: { id },
					async: false,
					success: function(data){
						$("#dsr_panel").html(data);
					}
				})
			}
			if(id == "current-semiannual"){
				$.ajax({
					url: "<?php echo base_url();?>omc/dashboard_dsr",
					type: "POST",
					data: { id },
					async: false,
					success: function(data){
						$("#dsr_panel").html(data);
					}
				})
			}
			if(id == "today-dtr"){
				$.ajax({
					url: "<?php echo base_url();?>omc/dashboard_dsr",
					type: "POST",
					data: { id },
					async: false,
					success: function(data){
						$("#dtr_panel").html(data);
					}
				})
			}
			if(id == "current-month-dtr"){
				$.ajax({
					url: "<?php echo base_url();?>omc/dashboard_dsr",
					type: "POST",
					data: { id },
					async: false,
					success: function(data){
						$("#dtr_panel").html(data);
					}
				})
			}
			if(id == "current-quarter-dtr"){
				$.ajax({
					url: "<?php echo base_url();?>omc/dashboard_dsr",
					type: "POST",
					data: { id },
					async: false,
					success: function(data){
						$("#dtr_panel").html(data);
					}
				})
			}
			if(id == "current-semiannual-dtr"){
				$.ajax({
					url: "<?php echo base_url();?>omc/dashboard_dsr",
					type: "POST",
					data: { id },
					async: false,
					success: function(data){
						$("#dtr_panel").html(data);
					}
				})
			}
		})
		
	});
</script>