$(document).ready(function(){
  if($.fn.wysihtml5){
    $('.customer_email_body').wysihtml5({
      placeholders: false,
      paymentlink: true,
      orderTemplatePublicLink: true,
      orderImageLink: $('#attachments-section').length > 0
    });
    $('.configurable-header').wysihtml5({
      "placeholders": false,
      "font-styles": false,
      "font-sizes": true,
      "color": true,
      "emphasis": true,
      "lists": true,
      "html": false,
      "link": true,
      "image": false
    });
    $('.terms-and-conditions-header').wysihtml5({
      "placeholders": false,
      "font-styles": false,
      "font-sizes": true,
      "color": true,
      "emphasis": true,
      "lists": true,
      "html": false,
      "link": true,
      "image": false
    });
  }

  var sendEmail = function(){
    var data = $('#send-email-form').serialize();
    if(typeof formid !== 'undefined'){
      data = $('#' + formid).serialize() + '&' + data ;
    }
    if(typeof(sendMassEmailPath) == "undefined")
      $.ajax({type: "POST", url: sendEmailPath, data: data}); 
    else
      $.ajax({type: "POST", url: sendMassEmailPath, data: data});
  };

  $('body').on('click', '#send_email', function(e){
    e.preventDefault();

    var subject                  = $('#subject').val();
    var body                     = $('#body').val();
    var templateName             = $('#template_name_for_email').val();
    var insertPrintOrderDom      = $('#insert-print-order-email');
    var selectedTemplateType     = $('#template_type_for_email').find(':selected');
    var templateId               = $('#templates_list_for_email').find(':selected').val();
    var basketId                 = insertPrintOrderDom.data('basketId');
    var printOutUrlAdded         = false;
    var attachments              = $('#attachments-section').text();
    
    var publicUrlWithoutProtocol = '//' + location.host + '/' + 'basket_invoice' + '?code=' +
      insertPrintOrderDom.data('secureCode') + "&template_type=" +
      selectedTemplateType.val() + "&template_id=" + templateId + "&basket_id=" + basketId;

    $('.wysihtml5-sandbox').contents().find('a').each(function(){
      if($(this).attr('href') == ('http:' + publicUrlWithoutProtocol) || $(this).attr('href') == ('https:' + publicUrlWithoutProtocol)){
        printOutUrlAdded = true;
        return false; 
      }
    });

    if (typeof(sendEmailPath) != "undefined" && (sendEmailPath.indexOf('baskets') > 0) && $('#recipients').val() == ''){
      jui_alert("Please select an email address");
    }
    else if(selectedTemplateType.text() != "--Printout Type--" && templateName != "" && !printOutUrlAdded && attachments.indexOf(selectedTemplateType.text()) == -1){
      jui_confirm("It seems like you forgot to insert a print order link. Click on the 'Insert' button to add it.\n Send anyway?", sendEmail, undefined, "OK", "Cancel")
    }
    else if(subject == "" && body == "" && confirm("Send email without a subject and text in the body?")){
      sendEmail();
    }
    else if(subject || body){
      sendEmail();
    }
  });

  $("#stripe-payment-form").on('submit', function() {
    if($('#basket_payment_method_for_pre_payment').val() === '') {
      alert("Please select any payment method");
      return false;
    }
    else {
      return true;
    }
  });
});