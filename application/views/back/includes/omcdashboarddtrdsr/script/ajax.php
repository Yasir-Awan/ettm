<script type="text/javascript">
	$(document).ready(function(){
		$('#month').datepicker({format:'yyyy-mm'});
		$('#start_date').datepicker({format:'yyyy-mm-dd'});
		$('#end_date').datepicker({format:'yyyy-mm-dd'});
		$(this).click(function(event){
			if(event.target.id == "today" || event.target.id == "yesterday" || event.target.id == "current-month" || event.target.id == "current-quarter" || event.target.id =="current-semiannual" || event.target.id == "today-dtr" || event.target.id == "yesterday-dtr" || event.target.id == "current-month-dtr" || event.target.id == "current-quarter-dtr" || event.target.id =="current-semiannual-dtr" ){
				
				
				
				var verify = "#" + event.target.id;
				var id = $(verify).attr('id');
				if(id == "current-month" || id == "current-quarter" || id == "current-semiannual" || id == "current-month-dtr" || id == "current-quarter-dtr" || id == "current-semiannual-dtr"){
					$('#upload_supervise').removeClass('d-none');
					$('#id').val(id);
					
				}
				else{
					$('#upload_supervise').addClass('d-none');
				}
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
				if(id == "yesterday"){
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
					console.log(id);
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
				if(id == "yesterday-dtr"){
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
			}
			if(event.target.id.includes("dsr-toll")){
				var id = event.target.id;
				$("#extended").removeClass("d-none");
				if(id.includes("dsr-toll")){
					var id_array = id.split("-"); var toll = id_array[4];
					$.ajax({
						url: "<?php echo base_url();?>omc/dash_dsr_extend",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dsr-extended").html(data);
						}
					})
				}
			}
			if(event.target.id.includes("dtr-toll")){
				console.log(event.target.id);
				var id = event.target.id;
				$("#t-extended").removeClass("d-none");
				if(id.includes("dtr-toll")){
					var id_array = id.split("-"); var toll = id_array[4];
					$.ajax({
						url: "<?php echo base_url();?>omc/dash_dsr_extend",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dtr-extended").html(data);
						}
					})
				}
			}
		})
	});
</script>