<div aria-live="polite" aria-atomic="true" style="height: 330px; overflow-x:hidden; overflow-y:auto" >
  <!-- Position it -->
  <div style=" top: 0; right: 0;">
  <?php $counter = 0; 	
		foreach($notifications as $row){
            $counter++; 
           
		?>
    <!-- Then put toasts within -->
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false" style=" padding: 10px; width: max-content;" >
      <div class="toast-header">
        <svg class="rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice"
          focusable="false" role="img">
          <rect fill="#007aff" width="100%" height="100%" /></svg>
        <strong class="mr-auto"><?php echo $row->getName(); ?></strong>
        <small class="text-muted"><?php echo $row->getDate(); ?></small>
      </div>
      <div class="toast-body">
		    <a href="<?php echo base_url()?>toolplaza/specific_notification/<?php echo $row->getID() ?>" style="color:black;" ><?php echo "&nbsp&nbsp".$row->getNotificationMsg();?> </a>	
      </div>
    </div>
  </div>
</div>
            <?php 
            
        } 
        ?>
        <!-- <a  class="btn-xs   mb-1" href="#" onclick="" style="background:#007aff; align:center; margin-left:100px; font-size:12px; padding:5px;">See All</a> -->


<script>
function action_notification(url,id){

  var list = $('#show_notify_msg');
  
  event.stopPropagation();
  
    $.ajax({
    url: url,
    type: 'post',
    dataType: 'html',
    data : 'id='+id,

		beforeSend: function() {
			
		},
		success: function(data) {
			list.html('');
			list.html(data).fadeIn();	 
		},
		error: function(e) {
			//notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
		}
	});
}
</script>

<script>
function specific_notification(url,id, lvl){
	var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
	var list = $('#'+id).value;
	$.ajax({
    url: url,
    type: 'post',
    dataType: 'html',
    data : list,
		beforeSend: function() {
			list.html(loading_set);
		},
		success: function(data) {
			list.html('');
			list.html(data).fadeIn();
			 $('#dataTable').DataTable();
			$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
   			 $("[data-toggle='toggle']").bootstrapToggle();
		},
		error: function(e) {
			
			//notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
		}
	});
}
</script>
<script>
function specific_asset(url,id){
	var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
	var list = $('#'+id).value;
	$.ajax({
    url: url,
    type: 'post',
    dataType: 'html',
    data : list,
		beforeSend: function() {
			list.html(loading_set);
		},
		success: function(data) {
			list.html('');
			list.html(data).fadeIn();
			 $('#dataTable').DataTable();
			$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
   			 $("[data-toggle='toggle']").bootstrapToggle();
		},
		error: function(e) {
			
			//notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
		}
	});
}
</script>