$(document).ready(function(){
 
  $('body').on('click', '.email-support-form', function(){
    $('#dialog-form-email-support').modal({backdrop:'static'});
  });

  $("#email_type").on("change",function(){
    if ($("#email_type").val() == "Other"){
    	$(".support-email-subject").show();
    } else {
    	$(".support-email-subject").hide();
    }
  });
  
});