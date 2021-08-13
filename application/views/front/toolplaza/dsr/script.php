<script>
	$('#datecreated').datepicker({format:'yyyy-mm-dd'});
	<?php include('script/main.php'); ?>
	
	var selectionelectricity = function(select){
		var sections = { '1': 'sectionstable', '2': 'sectionunstable' }
		for(i in sections){ document.getElementById(sections[i]).style.display = "none"; document.getElementById(sections[select.value]).style.display = "block"; }
	}
	var selectionasrg = function(select){
		var sections = { '2': 'sectionrequest', '1': 'sectionr3' }
		for(i in sections){ document.getElementById(sections[i]).style.display = "none"; document.getElementById(sections[select.value]).style.display = "block"; }
	}
	$('#toggleun-g').click(function(){ $('#generator-log').removeClass('d-none'); });
	$('#toggleun-u').click(function(){ $('#generator-log').addClass('d-none'); });
	$('#togglelink-yes').click(function(){ $('#sectionlissue').removeClass('d-none'); });
	$('#togglelink-no').click(function(){ $('#sectionlissue').addClass('d-none'); });
	$('#toggleshut-yes').click(function(){ $('#sectionshut').removeClass('d-none'); });
	$('#toggleshut-no').click(function(){ $('#sectionshut').addClass('d-none'); });
	$('select#load-status').change(function(){
		if($(this).val() == 2){ $('#loadshedding').removeClass('d-none');}
		if($(this).val() == 1){ $('#loadshedding').addClass('d-none');} 
	});
	$('#time-to').keyup(function(){
		var generator_to = $('#time-to').val().split(':'); 
		var generator_from = $('#time-from').val().split(':'); 
		var time_hours =  generator_to[0] - generator_from[0];
		var time_minutes =  generator_to[1] - generator_from[1];
		if(time_minutes){
			$('#total-time').val(time_hours + ' Hours ' + time_minutes + ' Minutes');
		}
		else{
			$('#total-time').val(time_hours + ' Hours'); 
		}
	});
	
</script>
