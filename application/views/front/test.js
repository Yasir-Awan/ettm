function ClearMsgInterval(){
	IsFirstTimeLoaded = true;
	ExtendWithOldMessages = false;
	clearInterval(MessageDisplayLoopID); // Stop message loading Loop
	clearInterval(check_status_LoopID); // Stop checking quote status changes loading Loop
}

var MessageDisplayLoopID; // Defining Global Variable
	var IsFirstTimeLoaded = true; // Defining Global Variable
	var ExtendWithOldMessages = false;


		function display_messages(){
	
	var thread_id = $('#thread_id').val();
	var list = $('#message_display_center');
	var old_contents = list.html();
	var url = '<?php echo base_url()?>courses/display_messages/'+thread_id;
		
	$.ajax({
		type: "POST",
		url: url,
		data: '',
		contentType: false,
		processData: false,
		cache: false,
		beforeSend: function() {
			//
		},
		success: function(data) {
			
			var obj = JSON.parse(data);
			
			if(!obj.response){
				notify(obj.message,'danger','bottom','right');
			}else{
				
				if(obj.new_message){
					ExtendWithOldMessages = true;
					list.html(obj.message+old_contents).fadeIn();
				}
				
				// Checking if System is loading messages first time
				// AND retrieved messages have nothing to show
				// Then ask user to load old messages
				if(IsFirstTimeLoaded==true && obj.new_message==false){
					//var default_msg = '<div class="col-md-12 nopadding clearfix" style="margin-bottom:5px !important;"><div class="col-md-12 nopadding message_box_system"></div></div>';
					//list.html(default_msg).fadeIn();
					
					//load_old_messages(); // Load old messages
				}
				
				IsFirstTimeLoaded = false; // After procesing all request set this variable to false that not first time on next calls
			}
			
			if(obj.clear_loop){
				ClearMsgInterval(); // Stop message loading Loop
			}
		},
		error: function(e) {
			notify('An error occurred while loading messages. Please try again or contact administrator.','danger','bottom','right');
		}
	});
}

function ClearMsgInterval(){
	IsFirstTimeLoaded = true;
	ExtendWithOldMessages = false;
	clearInterval(MessageDisplayLoopID); // Stop message loading Loop
	clearInterval(check_status_LoopID); // Stop checking quote status changes loading Loop
}