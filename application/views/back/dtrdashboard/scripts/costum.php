<script>
	$('document').ready(function(){
					   
					  
$("ul.nav-tabs > li > a").click(function (e) {
	"use strict";
  e.preventDefault();  
    $(this).tab('show');
});
$("#toolselect > a").click(function (e) {
	"use strict";
  e.preventDefault();  
    $('#toll').tab('show');
}); 
$(".heading").select(function(){
	"use strict";
	$(this).toggleClass(".active");
});
<?php $i = 0; foreach($toolplazatoday as $toll){ ?>
	$("#<?php echo $toll['id']; ?>> a").click(function (e) {
	"use strict";
  e.preventDefault();  
    $('#toll-<?php echo $toll['id'] ?>').tab('show');
	});
<?php $i++;} ?>

$(this).click(function(event){
	var id = "#"+event.target.id
	var date = $(id).attr('date');
	var href = $(id).attr('href');
	console.log(href);
	if(date && href){
		$.ajax({
			url:"<?php echo base_url();?>admin/dashboard_dtr_day",
			type:"POST",

			data: { date, href },

			async: false,
			success: function(data){
				if ( data.error) console.log(data.error);
  				console.log(data)
				$(href).html(data);
			}
		});
	 	
	}	
});
	});
</script>