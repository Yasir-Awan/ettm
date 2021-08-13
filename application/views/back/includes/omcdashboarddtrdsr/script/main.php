<script>
$(document).ready(function() {
    $('#dsr-table').DataTable();
	$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();
} );
	
</script>
<script>
$(document).ready(function() {
    $('#dtr-table').DataTable();
	$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();
} );
	
</script>
<script>
$(document).ready(function() {
	$('#upload_time').timepicker({
	    timeFormat: 'h:mm p',
	    interval: 60,
	    minTime: '10',
	    maxTime: '6:00pm',
	    defaultTime: '11',
	    startTime: '10:00',
	    dynamic: true,
	    dropdown: true,
	    scrollbar: true
	});
	$('#supervise_time').timepicker({
	    timeFormat: 'h:mm p',
	    interval: 60,
	    minTime: '10',
	    maxTime: '6:00pm',
	    defaultTime: '12',
	    startTime: '11:00',
	    dynamic: false,
	    dropdown: true,
	    scrollbar: true
	});
});
</script>
