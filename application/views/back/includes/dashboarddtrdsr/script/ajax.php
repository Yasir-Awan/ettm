<script type="text/javascript">
	$(document).ready(function(){
        function addingzero(dat){
            if(dat < 10){
                dat = "0"+dat;
            }
            return dat;
        }
		$('#month').datepicker({format:'yyyy-mm'});
		$('#start_date').datepicker({format:'yyyy-mm-dd'});
		$('#end_date').datepicker({format:'yyyy-mm-dd'});
		$(this).click(function(event){
			if(event.target.id == "today" || event.target.id == "yesterday" || event.target.id == "current-month" || event.target.id == "current-quarter" || event.target.id =="current-semiannual" || event.target.id == "today-dtr" || event.target.id == "yesterday-dtr" || event.target.id == "current-month-dtr" || event.target.id == "current-quarter-dtr" || event.target.id =="current-semiannual-dtr" ){
				
				var date = new Date();
                    var year = date.getFullYear()
                    var month = date.getMonth() + 1;
                    /* if(month < 10){
                        month = "0"+month;
                    } */
                    var quar_month = month - 3;
                    if(quar_month > 9){ quar_year = year - 1; }
                    else{ quar_year = year; }
                    var semi_month = month - 6;
                    if(semi_month > 6){ semi_year = year - 1; }
                    else{ semi_year = year; }
                    var dated = date.getDate();
                    
                    var previous = dated - 1;
                    var prev_last = previous - 1;
                    var tomorrow = dated + 1;
                    dated = addingzero(dated);
                    previous = addingzero(previous);
                    prev_last = addingzero(prev_last);
                    tomorrow = addingzero(tomorrow);
                    month = addingzero(month);
                    quar_month = addingzero(quar_month);
                    semi_month = addingzero(semi_month);
                    //console.log(month);
				var verify = "#" + event.target.id;
				var id = $(verify).attr('id');
				if(id == "today" || id == "yesterday" || id == "current-month" || id == "current-quarter" || id == "current-semiannual" || id == "today-dtr" || id == "yesterday-dtr" || id == "current-month-dtr" || id == "current-quarter-dtr" || id == "current-semiannual-dtr"){
				
					$('#id').val(id);
                   
				}
				else{
					
				}
				if(id == "today"){
					$.ajax({
						url: "<?php echo base_url();?>admin/dashboard_dsr",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dsr_panel").html(data);
						}
					});
                    
                    var from_date = [year,month,dated].join('-');
                    var to_date = [year,month,tomorrow].join('-');
					$('#from_date').val(from_date);
					$('#to_date').val(to_date);
				}
				if(id == "yesterday"){
					$.ajax({
						url: "<?php echo base_url();?>admin/dashboard_dsr",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dsr_panel").html(data);
						}
					});
                    var from_date = [year,month,previous].join('-');
                    var to_date = [year,month,dated].join('-');
					$('#from_date').val(from_date);
					$('#to_date').val(to_date);
				}
				if(id == "current-month"){
					console.log(id);
					$.ajax({
						url: "<?php echo base_url();?>admin/dashboard_dsr",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dsr_panel").html(data);
						}
					});
                    var from_date = [year,month,"0"+1].join('-');
                    var to_date = [year,month,tomorrow].join('-');
					$('#from_date').val(from_date);
					$('#to_date').val(to_date);
				}
				if(id == "current-quarter"){
					$.ajax({
						url: "<?php echo base_url();?>admin/dashboard_dsr",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dsr_panel").html(data);
						}
					});
                    var from_date = [quar_year,quar_month,"0"+1].join('-');
                    var to_date = [year,month,tomorrow].join('-');
					$('#from_date').val(from_date);
					$('#to_date').val(to_date);
				}
				if(id == "current-semiannual"){
					$.ajax({
						url: "<?php echo base_url();?>admin/dashboard_dsr",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dsr_panel").html(data);
						}
					});
                    var from_date = [semi_year,semi_month,"0"+1].join('-');
                    var to_date = [year,month,tomorrow].join('-');
					$('#from_date').val(from_date);
					$('#to_date').val(to_date);
				}
				if(id == "today-dtr"){
					$.ajax({
						url: "<?php echo base_url();?>admin/dashboard_dsr",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dtr_panel").html(data);
						}
					});
                    var from_date = [year,month,previous].join('-');
                    var to_date = [year,month,dated].join('-');
					$('#from_date').val(from_date);
					$('#to_date').val(to_date);
				}
				if(id == "yesterday-dtr"){
					$.ajax({
						url: "<?php echo base_url();?>admin/dashboard_dsr",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dtr_panel").html(data);
						}
					});
                    var from_date = [year,month,prev_last].join('-');
                    var to_date = [year,month,previous].join('-');
					$('#from_date').val(from_date);
					$('#to_date').val(to_date);
				}
				if(id == "current-month-dtr"){
					$.ajax({
						url: "<?php echo base_url();?>admin/dashboard_dsr",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dtr_panel").html(data);
						}
					});
                    var from_date = [year,month,"0"+1].join('-');
                    var to_date = [year,month,dated].join('-');
					$('#from_date').val(from_date);
					$('#to_date').val(to_date);
				}
				if(id == "current-quarter-dtr"){
					$.ajax({
						url: "<?php echo base_url();?>admin/dashboard_dsr",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dtr_panel").html(data);
						}
					});
                    var from_date = [quar_year,quar_month,"0"+1].join('-');
                    var to_date = [year,month,dated].join('-');
					$('#from_date').val(from_date);
					$('#to_date').val(to_date);
				}
				if(id == "current-semiannual-dtr"){
					$.ajax({
						url: "<?php echo base_url();?>admin/dashboard_dsr",
						type: "POST",
						data: { id },
						async: false,
						success: function(data){
							$("#dtr_panel").html(data);
						}
					});
                    var from_date = [semi_year,semi_month,"0"+1].join('-');
                    var to_date = [year,month,dated].join('-');
					$('#from_date').val(from_date);
					$('#to_date').val(to_date);
				}
			}
			if(event.target.id.includes("dsr-toll")){
				var id = event.target.id;
				$("#extended").removeClass("d-none");
				if(id.includes("dsr-toll")){
					var id_array = id.split("-"); var toll = id_array[4];
					$.ajax({
						url: "<?php echo base_url();?>admin/dash_dsr_extend",
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
						url: "<?php echo base_url();?>admin/dash_dsr_extend",
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