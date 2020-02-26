<script>
	$(document).ready(function(){
		//ajax function to be used in further
		var ajax_year =  function(info){
				$.ajax({
					url: "<?php echo base_url();?>admin/get5yeartollchart",
					type: "POST",
					data: info,
					async: false,
					success: function(data){
						console.log(info);
						$("#5yearchart").html(data);
					}
				});
			}
		$('#tollplaza_id').change(function(event){
			var id = $('#tollplaza_id').val();
			var time = $('#duration').val();
			if(time === undefined){
				var info = { id }
			}
			else{
				var info = { id, time }
			}	
			
			ajax_year(info);
			
			
		});
		$('#duration').change(function(event){
			var id = $('#tollplaza_id').val();
			var time = $('#duration').val();
			if(time === undefined){
				var info = { id }
			}
			else{
				var info = { id, time }
			}	
			
			ajax_year(info);
			
			
		});
	});
</script>