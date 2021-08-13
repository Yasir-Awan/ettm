<script>
	var timer =  setInterval(function(){
		$.ajax({  
			url: "<?php echo base_url().'admin/live_data';?>", // form action url
			type: 'POST', // form submit method get/post
			dataType: 'html',
			success: function(data) {
				var obj = JSON.parse(data);
				$('#total_traffic').html(obj.total.traffic);
				$('#total_revenue').html(obj.total.revenue);
				$('#total_paid').html(obj.total.paid);
				$('#total_exempt').html(obj.total.exempt);
				$('#total_violations').html(obj.total.violations); 
				$('#today_traffic').html(obj.today.traffic);
				$('#today_revenue').html(obj.today.revenue);
				$('#today_paid').html(obj.today.paid);
				$('#today_exempt').html(obj.today.exempt);
				$('#today_violations').html(obj.today.violations);
			},
			error: function(e) {
				console.log(e)
			}
		});
	},5000); 
</script>