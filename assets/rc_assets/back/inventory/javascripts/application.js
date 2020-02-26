globalData = {};
isHtml5Supported = (typeof document.createElement('canvas').getContext === "function");
function setGlobalData(key, value){
  globalData[key] = value;
}

function getGlobalData(key){
  return globalData[key];
}

function resetFilter(filter_id){
  $("#" + filter_id +" option:eq(0)").prop("selected", true);
}

//https://github.com/loopj/jquery-tokeninput/issues/785
function regexEscape(value) {
  return value.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
}

$.titleize = function(value){
  if(typeof(value) === 'string'){
    result = "";
    $(value.split(/[ _]/)).each(function(index, value){
      result += value[0].toUpperCase() + value.slice(1) + " ";
    });
    return $.trim(result);
  }
};

// The argument should be the number of seconds in UTC i.e. epoch
function serverTimezoneDateString(epoch){
  var clientOffset = new Date().getTimezoneOffset() * 60;
  var result       = epoch - getGlobalData('serverOffset') + clientOffset;
  var date         = new Date(result * 1000);
  var day          = ("0" + date.getDate()).slice(-2);
  var hours        = ("0" + date.getHours()).slice(-2);
  var minutes      = ("0" + date.getMinutes()).slice(-2);
  var month        = {
    '0' : 'January', '1' : 'February', '2' : 'March', '3' : 'April',
    '4' : 'May', '5' : 'June', '6' : 'July', '7' : 'August', '8' : 'September',
    '9' : 'October', '10' : 'November', '11' : 'December'
  }[date.getMonth()];
  return month + " " + day + ", " + date.getFullYear() + " " + hours + ":" + minutes + " " + getGlobalData('serverTimeZone');
}

function showFancyBox(fancyBoxLinkId){
  $('#' + fancyBoxLinkId).fancybox({
    autoScale: true
  });
  window.setTimeout(function(){
    $('#' + fancyBoxLinkId).trigger('click');
  }, 100);
}

function scrollToElement(eid){
  var element = $(eid);
  $('html, body').animate({ scrollTop: element.offset().top }, 'slow');
}

function setDateDisplayFormat(date, dateDisplayFormat){
  if (dateDisplayFormat === 'dd/mm/yyyy'){
    date = moment(date, 'MM/DD/YYYY').format('DD/MM/YYYY');
  }
  else if (dateDisplayFormat === 'mm/dd/yyyy'){
    date = moment(date, 'MM/DD/YYYY').format('MM/DD/YYYY');
  }
  else if (dateDisplayFormat === 'Long'){
    date = moment(date, 'MM/DD/YYYY').format('MMMM D, YYYY');
  }
  return date;
}

function check_enforced_attrs(action){
  all_filled=true;
    $("["+action+"_values_enforce_required]").each(function(index){
      if($(this).val() == ''){
        alert('Please enter value of '+$(this).attr('c-attr-name'));
        all_filled=false;
        return false;
      }
    });
    for(i = 0; i < multi_ids.length && all_filled; i++)
    {
      if($('.' + action + '_values_multi' + multi_ids[i]).length != 0 && $('.' + action + '_values_multi' + multi_ids[i] + ':checked').length < 1){
        all_filled=false;
        alert('Please select some value of '+$('.'+action+'_values_multi'+multi_ids[i]).attr('c-attr-name'));
        break;
      } 
    }
    for(var i = 0; i < dropdown_ids.length; i++ ){
      if($('.' + action + '_values_dropdown' + dropdown_ids[i]).val() == ''){
        all_filled = false;
        alert('Please select some value of '+ $('.' + action + '_values_dropdown' + dropdown_ids[i]).attr('c-attr-name'));
        break;
      } 
    }
  return all_filled;
}

$.removeInvalidPlaceholders = function(email_body, template_type){
  var a1 = (email_body.match(/\{\{[ '&nbsp;']*[a-zA-Z0-9_]*[ '&nbsp;']*\}\}/g) || [""]).join(',').replace(/{{/g, '').replace(/}}/g, '').split(',');
  var a2;
  if(template_type.indexOf('custom_field_') == 0){
    a2 = custom_attribute_placeholders;
  }
  else{
    a2 = allowed_placeholders[template_type];
  }
  var diff = $.grep(a1, function(x) { return $.inArray(x, a2) < 0 });
  result_body = email_body

  $.each(diff, function(index, value){
    result_body = result_body.replace('{{' + value + '}}', '');
  });

  if(result_body != email_body){
    if(confirm("Invalid placeholders will be removed from email body. Continue?")){
      return result_body;
    }
    else{
      $("#email_template_template_type option[value='" + previous_template_type + "']").prop('selected', true);
      return email_body;
    }
  }
  return result_body;
};

$(function(){

  $('body').on('change', "input.radio-group-with-dif-names", function(){
    $('div#' + $(this).parent().attr('id') + ' input.radio-group-with-dif-names:checked').not(this).prop('checked', false);
  });

  $('body').on('click', '.help-link', function(e){
    e.preventDefault();
  });

  $('body').on('click', '.show-alert', function(e){
    e.preventDefault();
    alert($(this).data('alert'));
  });

  $('#add-new-work-order').on('click', function(e){
    $('#work_order_modal_dialog').modal({ backdrop: 'static' });
  });

  $('#work_order_modal_dialog').on('click', '#add_to_work_order', function(e){
    if($('#tasks_number').val() == ""){
      alert("Please select a work order to proceed");
    }else{
      var data = { resource_id: $('#add-new-work-order').data('resource-id'), resource_type: $('#add-new-work-order').data('resource-type'), title: $('#add-new-work-order').data('title') };
      $.post("/tasks/" + $('#tasks_number').val() + "/add_to_task", data);
    }
  });

  var inventory_threshold = '';
  // this one for dynamicaly added fields

  $('#reset_password_link').click(function(e){
    e.preventDefault();
    if($(this).data("password-hidden")){
      $(this).data("password-hidden", false);
      $('#password-box-in-form').append($('#reset-password-box'));
    }
    else{
      $('#password-box-outside-form').append($('#reset-password-box'));
      $(this).data("password-hidden", true);
    }    
  });

  $(".show_delete_document_overlay").on("click", function(){
    var action_path = $(this).data('action-path');
    var association_count = $(this).data('association-count');
    $(".delete_document").attr('action', action_path);
    if(association_count > 1)
      $("#confirmation_text").text("This document is referenced by other items, are you sure you want to delete it permanently?");
    $("#delete_document_overlay").modal('show');
  });

  $(".show-cannot-delete-document-overlay").on("click", function(e){
    e.preventDefault();
    alert('Your company settings prevent you from deleting documents.');
  });

  //Note: Remove class in case of html5 error and on closing the model
  $("body").on('click', '.single-click', function(){
    if($(this).hasClass('disabled')){
      return false;
    }else{
      $(this).addClass('disabled');
    }
  });

  $("#modelDialog").on("hidden.bs.modal", function () {
    $(".subscription-confirmation-btn").removeClass("disabled");
  });

  //Patch to fix the issue where authenticity token was passed 
  //in Pagination parameters
  $('body').on('click', "#assets_list_toggler a.btn, #assets_view_toggler a.btn", function(e) {
    if( $(this).attr('data-stock-view') == 'stock-view' )
      {
        if ($('#inventory_filter_frm input#stock_view').val() == 'false'){
          $('#inventory_filter_frm input#stock_view').val('true');
        }
        else{
          $('#inventory_filter_frm input#stock_view').val('false');
        }
        $('#inventory_filter_frm').submit();
      }
    else if( $(this).attr('data-stock-view') == 'stock-asset-stock-view' )
      {
        $('#stock_filter_frm input#stock_view').val($('#stock_filter_frm input#stock_view').val() == 'false');
        $('#stock_filter_frm input#stock_asset_current_checkout_view').val('false');
        $('#stock_filter_frm').submit();
      }
    else if( $(this).attr('data-compact-view') == 'compact-view' )
    {   
      if ($('#asset_filter_frm input#compact_view').val() == ''){
        $('#asset_filter_frm input#compact_view').val('true');
      }else{
        $('#asset_filter_frm input#compact_view').val('');
      }
      $('#asset_filter_frm').submit();
    }
    else if( $(this).attr('data-current-checkout-view') == 'current-checkout-view' )
    {   
      if ($('#stock_filter_frm input#stock_asset_current_checkout_view').val() == 'false'){
        $('#stock_filter_frm input#stock_asset_current_checkout_view').val('true');
      }else{
        $('#stock_filter_frm input#stock_asset_current_checkout_view').val('false');
      }
      $('#stock_filter_frm input#stock_view').val('false');
      $('#stock_filter_frm').submit();
    }
    else{
      window.href(this.href);
    }
  });

    $('[data-toggle="tooltip_copy"]').tooltip();

    $(".js-copy-code-tag").click( function(e){
      $( ".fa-check" ).each(function() {
        $(this).removeClass('fa-check');
        $(this).addClass('fa-clipboard');
        $(this).parent().attr('title', "Copy to clipboard").tooltip('fixTitle');
      });
      $(this).tooltip('destroy');
      var $temp = $("<input>");
      $("body").append($temp);
      if ($(this).hasClass('multi_store')) {
        var text_to_copy = $.parseHTML($(this).prev().html())[0].data.trim() +"\n"+$.parseHTML($(this).prev().html())[2].data.trim();
      } else {
        var text_to_copy = $(this).prev().val();
      }
      $temp.val(text_to_copy).select();
      document.execCommand("copy");
      $temp.remove();
      $(this).find('i').removeClass('fa-clipboard').addClass('fa-check')
      $(this).attr('title', "Copied").tooltip('show');
    });

  // Patch to fix wildcard subdomain issue in OAuth 2
  $('.google-button a').bind('click', function(e){
    host_without_protocol=jQuery(location).attr('href').split("//")[1];
    subdomain=host_without_protocol.split(".")[0];
    this.href = this.href.replace(subdomain, 'www');
    window.location = this.href;    
  });

  $("#asset_image_thumb").click(function(e) {
    e.preventDefault();
    $('#asset-image-dialog').modal({backdrop:'static'});
  });

  $('body').on('submit', "form[name='document-upload-form']", function() {
    var num = $("#attachments_")[0].files.length;
    for(i=0 ; i<num ; i++){
      if( $("#attachments_")[0].files[i].size > 10485760 ){
        alert($("#attachments_")[0].files[i]['name'] + ' - File Size Should be less than 10MB');
        return false;
      }
    }

    $("form[name='document-upload-form'] :submit").val('Uploading').attr("disabled", true);
  });


  $("#user_display_picture_thumb").click(function(e) {
    e.preventDefault();
    $('#user-display-picture-dialog').modal({backdrop:'static'});
  });

  $('body').on('click', '.clear-time', function(e){
    e.preventDefault();
    $('#' + $(this).data('time-field')).val('');
  });

  $('body').on('change', '#shipping_addresses_filter', function(){
    $("#shipping_addresses_filter_form").submit();
  })

  $('body').on('click', '.clear-date-time', function(e){
    if($(this).attr('href') != undefined && $(this).attr('href').indexOf('#') >= 0){
      e.preventDefault();
    }

    $('#' + $(this).data('time-field')).val('');
    $('#' + $(this).data('date-field')).val('');
    $('#' + $(this).data('date-field') + '-datepicker').val('');
    $('.' + $(this).data('date-field')).val('');
  });

  $('body').on('click', '.reset-forever-on-input input[type=text]', function() {
    $('.reset-forever-on-input input[type=checkbox]').prop('checked', false);
  });

  $('body').on('mouseover', '.dateField, .report-endDate, .report-startDate', function(){
    $('.dateField.disablePast').datepicker({
      autoclose: true,
      todayHighlight: true,
      startDate: $(this).data('disable-from') ? $(this).data('disable-from').toString() : '+0d'
    });

    $('.dateField.disableFuture').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: new Date()
    });

    $('.dateField.with-server-start-date').datepicker({
      autoclose: true,
      startDate: getGlobalData('serverDate')
    });

    $('.dateField.with-server-end-date').datepicker({
      autoclose: true,
      endDate: getGlobalData('serverDate')
    });

    $('.dateField, .report-endDate, .report-startDate').datepicker({
      autoclose: true,
      todayHighlight: true
    });
  });

  $('body').on('mouseover', '.timeField', function(){
    $(this).datetimepicker({
      pickDate: false,
      pickSeconds: false
    });
  });

  $('.clear-date-report').on("click",function(event) {
    event.preventDefault();
    $('.'+$(this).prop('id')).val('');
  });


  $("#showLocationOnMap").bind('click',function(e){
    e.preventDefault();
  });
  $(document).ajaxSend(function(event, request, settings) {
    // Show spinner for all ajax requests except for loading the header data. 
    // We do not want it to be blocking.
    if (!settings.hide_spinner){
      $("#ajax_indicator").show();
    }
  });

  $(document).ajaxError(function(){
    $("#ajax_indicator").hide();
  });

  $(document).ajaxComplete(function() {
    $("#ajax_indicator").hide();
  });

  $(".salvage_value").on('keypress', function(event){
    return isNumberKey(event);
  });

  $('.submenu_panel .submenu li').click( function() {
    if($('.submenu_panel .submenu li').children('a').length==0) {
      $(this).parent().parent().next('div').children('div').hide();/*for main submenu*/
      $('.sub_container').children('div').hide();/*for submenue inside left container.they have content in sub_container like asset,and group show page*/
      $('.submenu_panel .active').removeClass('active');
      $(this).addClass('active');
      $('#'+this.id+'-contents').show();
    }
    if(this.id == 'company-locations'){
      window.setTimeout(function(){
        $.jstree._reference("#locations-tree").open_all(-1);
      }, 100);
    }
  });



  $(".up_down_icon").on('click', function() {
    var icon = ($(this).children("i").get(0)) ? $(this).children("i") : $(this).parent().find('i#toggle_box_icon');
    if(icon.hasClass('icon-chevron-down')){
      $(".up_down_icon").children("i").attr('class', 'icon-chevron-down');
      icon.attr('class', 'icon-chevron-up');      
    } else {
      $(".up_down_icon").children("i").attr('class', 'icon-chevron-down');      
    }     
  });

  $('#email_notification_submit').on('click', function(){
    $('#selected-groups-for-alerts option').prop('selected', true);
    $('#selected-locations-for-alerts option').prop('selected', true);
  });

  $('.submit_store_settings').on('click', function(){
    $('#applied-items-list-page-columns option, #applied-bundles-list-page-columns option, #applied-detail-page-columns option, #applied-bundle-detail-page-columns option, #selected-pick-up-locations option, #mandatory-signup-attributes option, #mandatory-fields-for-guests option').prop('selected', true);
    var invalidUrls = [];
    $('.menu-external-urls').each(function(){
      if ($(this).val() != "" && !isUrl($(this).val())) {
        invalidUrls.push($(this).val());
      } 
    });
    if (invalidUrls.length > 0) {
      alert('Invalid URL: ' + invalidUrls.join(', '));
      return false;
    }
  });

  $("#clean_up_link").click(function(e) {
    e.preventDefault();
    $('#clean-up-dialog').modal({backdrop:'static'});
  });
  

  $(function(){
    $("h4.expand").toggler({initShow: "div.expand"});
    $("div.expand").toggler({initShow: "div.init_open"});

    var minHeight=150;
    mainContainerHeight=$("#main_container").height();
    footerHeight= $("#footer").height();
    documentHeight=$(document).height();
    headerHeight=$("#header").height();
    minMainContainerHeight=documentHeight-(footerHeight+headerHeight);
    $("#main_container").height(minMainContainerHeight);

  });

  
  $(function(){
    $("#hide_notification_link").click(function() {
      $("#notification_bar").fadeOut(3000);
      return false;
    });
  });

  jQuery.ajaxSetup({
    'beforeSend': function(xhr) {
      xhr.setRequestHeader("Accept", "text/javascript");
    },
    cache: false
  });
});

function add_fields(link, association, content) {
  var new_id = new Date().getTime();  
  var regexp = new RegExp("new_" + association, "g");

  $("."+association).append(content.replace(regexp, new_id));
  /*
     $('.remove_document').click( function(){
     $(this).parents('.asset_document').remove();
     return false;
     });*/

  var  document_id="#asset_document_"+new_id+"_remove_link";
  var file_filed_id="#asset_documents_attributes_"+new_id+"_attachment";

  $(document_id).hide();/* initially remove link will be hidden when user select file show this link*/
  $("#add_new_document").hide();
  $(file_filed_id).change(function(){

    if ($(this).val().length> 0)
  {
    $(document_id).show();
    $("#add_new_document").show();
  }
    else
  {

    $(this).parents('.asset_document').remove();
    $(document_id).hide();
    $("#add_new_document").hide();
  }

  });
  $(document_id).click(function(){
    $(this).parents('.asset_document').remove();
    return false;
  });

}

var jui_confirm = function(message, successCallback, failureCallback, okButtonLabel, cancelButtonLabel){
  if(okButtonLabel === undefined){
    okButtonLabel = 'Yes';
  }
  if(cancelButtonLabel === undefined){
    cancelButtonLabel = 'No';
  }
  bootbox.confirm(message, cancelButtonLabel, okButtonLabel, function(result) {    
    if (result) {
      successCallback();
    }
    else if(failureCallback !== undefined){
      failureCallback();
    }
  });  
};

var jui_box = function(bwidth, box_title, body_content, buttons){
  $("#overlay p:first").html(body_content);
  $("#overlay").dialog({
    title: box_title,
    resizable: false,
    width: bwidth,
    height: 'auto',
    modal: true,
    buttons: buttons
  });
};

var jui_alert = function(content){
  bootbox.alert(content);
};

//override default alert & confirm messages

window.alert = function(message){
  return jui_alert(message);
};

$(function()
    {
      /*
         this function is use to remove first document in asset form
         $("#add_new_document").fadeOut();

*/
      $("#asset_document_new_documents_remove_link").click(function(){
        $(this).prev("#asset_documents_attributes_0_attachment").val('');
        return false;
      });

      $('.add_through_url').click(function(){
        $(this).parents('.attachment').hide();
        $('.document_url').show();
        return false;
      });

    });

$(function()
    { 
      $('#advance-filters-link').on("click", function(){
        $(this).parent().remove();
        $('.advance-search-filters').show();
      });
      $('#close_flash_message_bar_button').on("click", function()
        {
          $('#flash_message_bar').fadeOut(1000);
        });
      $('#close_alert_message_bar_button').click(function(){
        $('#asset_alert_bar').fadeOut(1000);
      });

      //onclick funtion to add asset to print Queue
      $('#print').click(function()
        {
          $("#print_form").attr("action", "/print_queues/print");
          $("#print_form").submit();
        });

      $("#print_barcode").click(function()
          {
            $("#print_form").attr("action", "/print_queues/print?type=barcode");
            $("#print_form").submit();
          });

      $("#print_queue_more").click(function(event)
          {
            $("#print_barcode").toggle();
            event.stopPropagation();
          });

      $("body").click(function() {
        $("#print_barcode").hide();
      });

      // Make this page specific
      $(document).ready(function(){  

        //load javascript for stripe and or gateway
        var gateway = $("#payment_gateway").find(":selected").val();
        if ($('.gateway_information').data('total-gateways') > 1) {
          if (gateway == "stripe") {
            $.getScript("/javascripts/stripe_token.js");
          }
          else if ( gateway && gateway != "square") {
            $.getScript("/javascripts/gateways.js");
          }
        }

        if ($("#signature-pad").length > 0 && !isHtml5Supported){
          alert("You cannot use the signature pad as your browser does not support HTML5.");
        };

        $('#consolidated-invoice').click(function(e) {
          e.preventDefault();
          $('#consolidated-invoice-model').modal({backdrop: 'static'})
        });

        $("#hide_side_bar").on("click", function(){
          hide_side_bar();
          $.cookie('hide_side_bar', true)
        });
        $("#show_side_bar").on("click", function(){
          showSideBar();
        });

        $('#see-failed-users').on('click', function(){
          $('#failed-users').removeClass('hide');
          scrollToElement($(this).attr('href'));
        });

        if($.cookie('hide_side_bar')){
          if($("#hide_side_bar").length){
            hide_side_bar();
          }  
        }

        $('body').on('click', '#gdpr-compliance-submit', function(e){
          if($('input[name="gdpr_compliance[gdpr_option]"]:checked').length != 1){
            alert("Please select one option");
            return false;
          }
        });


        $("#appendedPrependedInput").popover({
          content: "Enter any keyword. To go to a specific item, type # followed by the item# OR type @ before Identification Number. " + ((typeof(search_help_for_rentals) != "undefined") ? search_help_for_rentals : ""),
          placement: "bottom",
          container: "body",
          trigger: "hover"
        });
        $("#search_form_trigger").popover({ 
          html : true, 
          content: function() {
          return $('#popover_content_wrapper').html();
          }
        });

        if($("#asset_identifier").val() != ""){
          $("#add_identifier").hide();
          $("#asset_identification_number").show();
        }

        $(".pagination li.disabled a").on('click', function(e){
          e.preventDefault();
        });

        $("span.gap").parents('li').on('click', function(){
          $('.go-to-page .goto-page-field').show();
        });

        $("#page-nums, #current_page_numinventory").on('click', function(){
          $(".page-nums").hide();
          $(".pagination1 .goto-page-field").show();
        });

        $(".goto-page-button").on('click', function(e){
          e.preventDefault();
          if($(this).siblings()[0].value == ''){
            alert('Please enter page number');
            return false;
          }else{
            var pageNumber = Math.abs(parseInt($.trim($(this).siblings()[0].value)));
            var totalPages = Math.abs(parseInt($(this).data("total-pages")));
            if(isNaN(pageNumber) || (!isNaN(pageNumber) && !((1 <= pageNumber) && (pageNumber <= totalPages)))){
              alert('Please enter a valid page number');
              return false;
            }
            var path;
            var locPath = window.location.href.replace('#', '');
            if(locPath.indexOf('?') >= 0){
              pageIndex = locPath.indexOf('page=');
              indexToTruncate = locPath.indexOf('&', pageIndex);
              if(pageIndex >= 0){
                if(indexToTruncate >= 0){
                  path = locPath.replace(locPath.substring(pageIndex, indexToTruncate), 'page=' + pageNumber);
                }else{
                  path = locPath.replace(locPath.substring(pageIndex, locPath.length), 'page=' + pageNumber);
                }
              }else{
                path = locPath + '&page=' + pageNumber;
              }
            }else{
              path = locPath + '?page=' + pageNumber;
            }
            window.location.href = path;
          }
        });
      });


      /*$('#add_to_print_queue').click(function(){

        if ($("input:checked").length > 0){
        $("#asset_form").attr("action", "/qrcodes");
        $("#asset_form").submit();
        }else{

        jui_box('auto','opps!','Please select an asset to proceed','false');
        return false;
        }

        });*/




    });
/*jQuery(function($) {
  $("#sign_in_link").bind("ajax:success", function(event, data, status, xhr) {
  $('#signin_overlay').fadeIn('fast',function(){
  $('#sign_in_overlay_box').animate({'top':'50px'},50);
  });
  });
  });*/

function showSideBar() {
  $("#show_side_bar").hide();
  $("#side_bar").show();
  $("#hide_side_bar").show();
  $("#dynamic_view_right").removeClass('span12');
  $("#dynamic_view_right").addClass('span9');
  $("#dynamic_view_left").show();
  $(".dashboard-events-border").removeClass('span4');
  $(".dashboard-events-border").addClass('span3');
  $.removeCookie("hide_side_bar");
  refreshGoogleMap();
}

function showOverlay()
{
  $('#overlay').fadeIn('fast',function()
      {
        $('#overlay_box').animate({'top':'130px'},500);
      });
  $('.overlay_boxclose').click(function()
      {
        $('#overlay_box').animate({'top':'-700px'},500,function()
          {
            $('#overlay').fadeOut('fast');
          });
      });
}

$(function()
    {  
      $("#add_vendor_ajax_link_in_asset_form").bind("ajax:success", function(event, data, status, xhr)
        { 
          showOverlay();
        });

      $("#add_services_with_ajax").bind("ajax:success", function(event, data, status, xhr)
        { 
          showOverlay();
        });

      $("#add_group_ajax_link_in_asset_form").bind("ajax:success", function(event, data, status, xhr)
        {
          $("#asset_group_id").trigger('change');
          showOverlay();
        });
      $("#sign_in_link").bind("ajax:success", function(event, data, status, xhr)
        {
          showOverlay();
        });
    });

function loadLocationsMap(){
  path = '/locations/locations_map?map_type=' + $("#location_map_select").val();
  $.ajax({ type: "GET" , url: path});
}

function loadTabFromCookie(){
  if($.cookie('selected_tab') != undefined) {
    $('#' + $.cookie('selected_tab')).click();
  }
}

function bindCookiesWithTabs(){
  if($('.suspend-msg').length == 1){
    hide_side_bar();
  }
  $('.nav-tabs.preloaded a').on('click', function(e){
    e.preventDefault();
    if($(this).attr('id') == 'billing-settings-link') {
      hide_side_bar();
    } else {
      showSideBar();
    }
    $.cookie('selected_tab', $(this).attr('id'), { path: '/' });
  });
}

function loadLocations(newLocationId){
  $.getJSON('/assets/locations.js', function(locationOptions) {
    $("[data-load-locations=true]").find('option').not(':first').remove();
    $("[data-load-locations=true]").append(locationOptions);
    $("[data-load-locations=true]").val($("[data-load-locations=true]").data('selected-location'));
    if (newLocationId !== undefined) {
      $('[data-load-locations=true] option[value=' + newLocationId + ']').prop('selected', true);
    }
    $("[data-load-locations=true]").attr("data-load-locations", false);
    var userAgent = window.navigator.userAgent.toLowerCase();
    var isIOS = /iphone|ipod|ipad/.test(userAgent);
    if(isIOS){
      window.setTimeout(function(){
        alert('Locations loaded successfully.');
      }, 100);  
    }
  });
}

$(function(){
  $(document).ready(function(){
    $('body').on('focus', '[data-load-locations=true]', function(){
      loadLocations();
    });
    if ($('#show_gdpr_compliance_from').val() == "true"){
      $('#dialog-form-gdpr-compliances').modal({backdrop:'static'});
    }
    $("#request_callback_link").click(function(e){
      e.preventDefault();
      $('#request-callback-dialog').modal({ backdrop:'static' });
    });

    $('#subscribe_from_trial').on('click', function(){
      $.cookie('selected_tab', 'billing-settings-link', { path: '/' });
    });
    
    $('.feed_pagination_ajax a').attr('data-remote', 'true');
    // toggle the add asset and add inventory buttons on group/sub-group detail page
    bindCookiesWithTabs();
    loadTabFromCookie();

  });
});
$(function()
    {
      // check/uncheck all checkboxes when checkbox of head row is checked/unchecked
      $('body').on('click', 'table tr th input:checkbox', function() {
        var tableObj = $(this).parents('table');
        if($(this).is(':checked')) {
          $(tableObj).find('input:checkbox:not(:disabled)').attr('checked', 'checked');
          $(tableObj).find('tr').addClass('hover');
        } else {
          $(tableObj).find('input:checkbox:not(:disabled)').removeAttr('checked');
          $(tableObj).find('tr').removeClass('hover');
        }
      });

      // check/uncheck of individual checkboxes and effect on checkbox of head row
      $('body').on('click', 'table tr td input:checkbox', function() {
        if($(this).is(':checked')) {
          $(this).parents('tr').addClass('hover');
        } else {
          $(this).parents('tr').removeClass('hover');
          var tableObj = $(this).parents('table');
          $(tableObj).find('tr').find('th').find('input:checkbox').removeAttr('checked');
        }
      });

      $('.remove_document').click( function(){
        $(this).parents('.asset_document').remove();
        return false;
      });


      $('.expandable-50').truncate({max_length: 50, more: 'more...', less: '...less', class_name: 'less-more-link'});
      $('.document_description').truncate({max_length: 300, more: 'more...', less: '...less', class_name: 'less-more-link'});
      $('#group-description').truncate({max_length: 440, more: 'more...', less: '...less', class_name: 'less-more-link'});
      $('#asset-description').truncate({max_length: 450, more: 'more...', less: '...less', class_name: 'less-more-link'});
      $('.description').truncate({max_length: 440, more: 'more...', less: '...less', class_name: 'less-more-link'});
      $('.lessmore_long').truncate({max_length: 440, more: 'more...', less: '...less', class_name: 'less-more-link'});
      $('.comment_content').truncate({max_length: 300, more: 'more...', less: '...less', class_name: 'less-more-link'});
    });

/* shows and hides ajax indicator */



$(window).bind("ajax:success",function(){
  if ($('#ajax-indicator') && $.active== 0) {
    $('#ajax-indicator').show();
  }
  $('.expandable-100').truncate({max_length: 100, more: 'more...', less: '...less', class_name: 'less-more-link'});
});

/* Search filter functions*/
$(function(){

  $(".set_scope a").click(function(e){
    e.preventDefault();
    var scope = $(this).data("action");
    $("#scope").val(scope);
    $('#search_form').submit();
  });
});

function showCurrentTab(hashString,force) {
  //http://erraticdev.blogspot.com/2011/02/jquery-scroll-into-view-plugin-with.html
  hashString = hashString || self.document.location.hash;

  hashString = hashString.replace("%23","#");
  if(hashString.toString().length <=0){
    return;
  }

  $.each(hashString.toString().split("#"),function(i,div){
    if(div.length>0){
      divEle = $("#"+div.toString());
      if(divEle.is(':visible')){
        if(i==1){
          divEle.trigger("click");
          divContents = $("#"+div.toString()+"-contents");
          divContents.scrollToMe();
        }else{
          divEle.highlightMe();
        }
      }
    }
  });
}

$(document).ready(function(){
  var screenWidth = screen.width;

  $('#new_location').submit(function(e){
    disableBtn('#create-location-btn')
  })

  var toggleBroadbandView = function() {
    if ($.cookie('screen_resolution') === 'broadband') {
      $.cookie('screen_resolution', screenWidth);
    } else {
      $.cookie('screen_resolution', 'broadband');
    }
    location.reload();
  };

  $('#toggle-broadband').click(function(e) {
    e.preventDefault();
    toggleBroadbandView();
  });

  if ($.cookie('screen_resolution') !== 'broadband') {
    $.cookie('screen_resolution', screenWidth);
  }

  $('a').tooltip();
  $('img').tooltip();
  $('label').tooltip();
  $('select').tooltip();
  $('span').tooltip();

  if (window.innerWidth <= 480){
    $('.hidden-phone').remove();
  } else if (window.innerWidth > 767 && window.innerWidth < 979){
    $('.hidden-tablet').remove();
  }
  else {
    $('.visible-phone').remove();
  }

  $('#action-buttons-wrapper .next_page a, #action-buttons-wrapper .previous_page a').click(function(e){
      window.location.href = $(this).attr('href');
    });

  if($("#enabled_mobile_view").is(':checked')){
    $("#mobile_options").show();
  }else{
    $("#mobile_options").hide();
  }

  $("#company_subdomain").on('click', function(){
    $('#widget-links-invalid').show();
  });

  $("#enabled_self_audit").on('click',function(e){        
    $("#initiate_audit_request").fadeIn();      
  });

  $("#disabled_self_audit").on('click',function(e){        
    $("#initiate_audit_request").fadeOut();
    $('#audit_request_checkbox').prop('checked', false);      
  });  

  $("#enabled_mobile_view").on('click',function(e){        
    $("#mobile_options").fadeIn();      
  });

  $("#disabled_mobile_view").on('click',function(e){        
    $("#mobile_options").fadeOut();      
  });

  if($("#enabled-corporate-url-option").is(':checked')){
    $("#corporate-url-steps").show();
    $("#custom-domain").show();
  }else{
    $("#corporate-url-steps").hide();
    $("#custom-domain").hide();
  }

  if($('#disabled-ldap-option').is(':checked')){
    $('#ldap_configuration').hide();
  }

  $('#enabled-ldap-option').on('click', function(e){
    $('#ldap_configuration').fadeIn();
  });

  $('#disabled-ldap-option').on('click', function(e){
    $('#ldap_configuration').fadeOut();
  });

  if($('#disable-signatures-option').is(':checked')){
    $('#signature-settings-configuration').hide();
  }

  $('#enable-signatures-option').on('click', function(e){
    $('#signature-settings-configuration').fadeIn();
  });

  $('#disable-signatures-option').on('click', function(e){
    $('#signature-settings-configuration').fadeOut();
  });

  /* Business Hours Add On logic Start */
  if ($('#company_company_settings_attributes_enable_business_hours_false').is(':checked')){
    $('#business-hour-configurations').hide();
  }

  $('#company_company_settings_attributes_enable_business_hours_true').click(function() {
    $('#business-hour-configurations').fadeIn();
  });

  $('#company_company_settings_attributes_enable_business_hours_false').click(function() {
    $('#business-hour-configurations').fadeOut();
  });

  $('#triage-completion-period-basis-select').on('change', function(){
    if($(this).val() == 'indefinite') {
      $('#indefinite-triage').val('true');
      $('#triage-completion-period-input').val('');
      $('#triage-completion-period-input').prop('disabled', true);
    } else {
      $('#indefinite-triage').val('false');
      $('#triage-completion-period-input').prop('disabled', false);
    }
  });

  $('.business-day-closed').change(function() {
    var $parent   = $(this).closest('tr');
    var isChecked = $(this).is(':checked');

    var $startTimeCol   = $parent.find('.start-time-col');
    var $startTimeField = $parent.find('.start-time-col input');
    var $endTimeCol     = $parent.find('.end-time-col');
    var $endTimeField   = $parent.find('.end-time-col input');

    $startTimeField.attr('disabled', isChecked);
    $startTimeField.toggle(!isChecked);

    $endTimeField.attr('disabed', isChecked);
    $endTimeField.toggle(!isChecked);

    var businessClosedTemplate = '<span class="business-holiday">Closed</span>';

    if (isChecked) {
      $startTimeCol.append(businessClosedTemplate);
      $endTimeCol.append(businessClosedTemplate);
    } else {
      $startTimeCol.find('.business-holiday').remove();
      $endTimeCol.find('.business-holiday').remove();
    }
  });
  /* Business Hours Add On logic End */

  $('#verify_ldap_connection').on('click', function(e){
    e.preventDefault();
    var host = $('#company_ldap_setting_attributes_host').val();
    var port = $('#company_ldap_setting_attributes_port').val();
    var dn   = $('#company_ldap_setting_attributes_admin_login_dn').val();
    var pass = $('#company_ldap_setting_attributes_admin_password').val();
    var enc  = $('#company_ldap_setting_attributes_encrypted').is(':checked');
    data = { host: host, port: port, dn: dn, pass: pass, enc: enc }
    $.post($('#verify_ldap_connection')[0].href, data);
  });

  $("#enabled-corporate-url-option").on('click',function(e){        
    $("#corporate-url-steps").fadeIn();      
    $("#custom-domain").fadeIn();      
  });

  $("#disabled-corporate-url-option").on('click',function(e){        
    $("#corporate-url-steps").fadeOut();     
    $("#custom-domain").fadeOut(); 
  });

  $("#enabled_bundles_option, .cart-addon-required").on('click', function(){
    if(!$(this).hasClass('restrict_enable')){
      $("#enabled_cart_option")[0].checked = true;
    }
  });

  if($("#is_audited_true").is(':checked')){
    $("#audit-response-filter").show();
    $("#audit-status-filter").hide();
  }else{
    $("#audit-response-filter").hide();
    $("#audit-status-filter").show();
  }

  $("#is_audited_true").on('click', function(){
    $("#audit-response-filter").show();
    $("#audit-status-filter").hide();
  });
  $("#is_audited_false").on('click', function(){
    $("#audit-status-filter").show();
    $("#audit-response-filter").hide();
  });
  
  showCurrentTab();

  $('body').on('mouseover', ".comment, .dcoument_detail", function(){
    $(this).find(".actions_links:first").show();
  });

  $('body').on('mouseout', ".comment, .dcoument_detail", function(){
    $(this).find(".actions_links:first").hide();
  });

  $('body').on('click', ".comment-cancle-update", function(e){
    e.preventDefault();
    var content = $(this).parents(".comment").children(".comment-hidden-content").html();
    $(this).parents(".comment").html(content);
    $('.comment_content').truncate({max_length: 300, more: 'more...', less: '...less', class_name: 'less-more-link'});
    $("#add-comments-box").show();
  });
});

function showCompanyLocationDialog(){
  $('#company-locations-with-assets-dialog').modal({backdrop:'static'});    
}

function showAvailabilityRangeDialog(){
  $('#dialog-form-availability-range').modal({backdrop:'static'});  
}

function showItemsInOrderDialog(){
  $('#search_all_baskets').val('true');
  $('#dialog-form-items-in-order').modal({backdrop:'static'});
}

function showAssetInCustodyOfDialog(){
  $('#dialog-form-asset_in_custody').modal({backdrop:'static'});  
}

function showRetireReasonDialog(){
  $('#dialog-form-retire_reason').modal({backdrop:'static'});  
}

function showCustomFilterDialog(){
  $('#custom-filter-dialog').modal({backdrop:'static'});  
}

jQuery.fn.extend({
  scrollToMe: function () {
                var x = jQuery(this).offset().top - 100;
                jQuery('html,body').animate({scrollTop: x}, 400);
              }});
jQuery.fn.extend({
  highlightMe: function () {
                 jQuery(this).css("background-color","#F0A83D");
                 jQuery(this).stop().animate({ backgroundColor:'#FFF' }, 2000, 'linear', function() { $(this).css('background-color', ''); });

               }});

$(function(){
  $('.set_default_print_label').click(function(){
    var id = $(this).data('print-label-template-id');
    var templateType = $(this).data('print-label-template-type');
    $.ajax({type: 'GET', url: '/print_label_templates/' + id + '/set_default', data: { template_type: templateType } });
  });
  $('.set_default_invoice_template').click(function(){
    var id = $(this).data('invoice-template-id');
    var templateType = $(this).attr('id');
    $.ajax({type: 'PATCH', url: '/invoice_templates/' + id + '/set_default', data: { template_type: templateType } });
  });
});

$(function(){
/*
  $("div#public-pages-packages a.btn-plan.paid").click(function(e){
    e.preventDefault();

    var id = $(this).attr('id');
    id = id.substr(id.lastIndexOf('_') + 1);
    $("form#paypal_" + id).submit();
    return false;
  });
*/
  $('#print-queue-user-single-step-bundles-qr-printing').click(function(e){
    var datastring = {};
    datastring['user'] = {};
    var id = $(this).data('user-id');
    if($('#print-queue-user-single-step-bundles-qr-printing:checked').length == 0){
      datastring['user']['single_step_bundles_qr_printing'] = 0;
    }else{
      datastring['user']['single_step_bundles_qr_printing'] = 1;
    }
    $.ajax({type: "PATCH", url: '/members/' + id + '/update_single_step_bundles_qr_printing', data: datastring});
  });

  $('#print-queue-user-single-step-members-qr-printing').click(function(e){
    var dataString = {};
    dataString['user'] = {};
    var id = $(this).data('user-id');
    dataString['user']['single_step_members_qr_printing'] = $('#print-queue-user-single-step-members-qr-printing:checked').length;
    $.ajax({type: "PATCH", url: '/members/' + id + '/update_single_step_members_qr_printing', data: dataString});
  });

  $("#export-items-print-label").on("click", function() {
    var data = {};
    data["template_id"] = $('#print_label_template_id option:selected').val();
    data["assets_ids"]  = $('#export-items-print-label').data('assets-ids');
    $.ajax({ type: "GET", url: '/print_label_templates/export_data', data: data });
  });

  $('#print-queue-user-single-step-printing').click(function(e){
    var datastring = {};
    datastring['user'] = {};
    var id = $(this).data('user-id');
    if($('#print-queue-user-single-step-printing:checked').length == 0){
      datastring['user']['single_step_printing'] = 0;
    }else{
      datastring['user']['single_step_printing'] = 1;
    }
    $.ajax({type: "POST", url: 'members/' + id + '/update_single_step_param', data: datastring});
  });

  $('#print-queue-user-single-step-baskets-qr-printing').click(function(e){
    $.ajax({ 
      type: "PATCH", 
      url: '/members/' + $(this).data('user-id') + '/update_single_step_baskets_qr_printing', 
      data: {'user': { 'single_step_baskets_qr_printing': $(this).is(":checked") }}
    });
  });
});

/*
$(function(){
  $("#upgrade_package").on("click",function(e){ 
    $("form#paypal_"+$(this).data('package-id')).submit();
    $('#modelDialog').modal('hide');  
  });
});
*/
function isNumberKey(evt)
{
  //#TODO add charCode to allow only one decimal place
  var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

  return true;
}

$(function(){
  $('.login-by-email-toggle').click(function() {
    $('.login-by-email').removeClass('hide');
    $('.forgot-password-link').removeClass('hide');
    $(this).parent().hide();
  });

  $('#access_token').on("click",function(e){
    e.preventDefault();
    var req = $.ajax({type: 'GET', url: 'generate_api_access_token'});
    req.success(function(resp){
      var token = resp.replace(/["]/g,'');
      $('#api_secret_key').text('Secret key: ' + token);
      api_token_blank = false;
      $('#disable_api_warning').modal('hide');
      $('#api_token_success').modal('show');
    });
  });
});

function instantiateSubGroupTree(drag_drop) {
  $('#sub-groups-tree')
    .on('move_node.jstree', subGroupTreeNodeMoved)
    .jstree({
      themes: {"theme": "classic",
        dots: true,
        icons: false
      },
      plugins: ["themes", "html_data", "ui", "crrm", "hotkeys", drag_drop, "core"]
    });
}

function moveSubGroupToChildOf(groupId, subGroupId, parentSubGroupId){
  var clickedNodeIds   = subGroupId.toString().split('_');    
  var subGroupId       = clickedNodeIds[clickedNodeIds.length - 1];

  var parentNodeIds    = parentSubGroupId.toString().split('_');
  var parentSubGroupId = parentNodeIds[parentNodeIds.length - 1];

  var payload          = "parent_id=" + parentSubGroupId;
  var url              = "/groups/"+ groupId +"/sub_groups/" + subGroupId + "/moveto_child_of";

  $.ajax({
    type: "PATCH",
    url: url,
    data: payload
  });
}

function subGroupTreeNodeMoved(event, data){
  moveSubGroupToChildOf(
    $('#sub-groups-tree').data('group-id'),
    data.node.attr("id"), 
    data.parent == -1 ? -1 : data.parent.attr("id") 
    );
}

$(document).ready(function(){
  addAllGroupdOption();
  addAllLocationOptions();

  $(document).on('click','#sub-groups-tree a',function(){
    clicked_sub_group_id  = $(this).parent('li').attr('id').toString().split('_');
    clicked_sub_group_id  = clicked_sub_group_id[clicked_sub_group_id.length - 1]
    window.location       = '/groups/' + $('#sub-groups-tree').data('group-id') + '/sub_groups/' + clicked_sub_group_id;
  });
});

$(function(){

  $('#move-items-right').bind('click', function(e){
    e.preventDefault();
    $('#selected-groups-for-alerts').children('#all-groups').remove();
    moveItems('non-selected-groups', 'selected-groups-for-alerts');
    $("#move-items-left").prop('disabled', false);
    addAllGroupdOption();
  });

  $('#move-items-left').bind('click', function(e){
    e.preventDefault();
    moveItems('selected-groups-for-alerts', 'non-selected-groups');
    addAllGroupdOption();
  });

  $('#move-location-right').bind('click', function(e){
    e.preventDefault();
    $('#selected-locations-for-alerts').children('#all-locations').remove();
    moveItems('non-selected-locations', 'selected-locations-for-alerts');
    $("#move-location-left").prop('disabled', false);
    addAllLocationOptions();
  });

  $('#move-location-left').bind('click', function(e){
    e.preventDefault();
    moveItems('selected-locations-for-alerts', 'non-selected-locations');
    addAllLocationOptions();
  });

  $('body').on('click', "#delete-card", function() {
    var deleteCardLink = $("#delete-card").attr("href");
    $("#delete-card").attr("href", deleteCardLink.split("?")[0] + '?gateway=' + $("#payment_gateway").val());
  });
  

  $('body').on('change', "#payment_gateway", function() {

    $('body').off('click', "#checkout-inventory-btn, #upgrade_package, #customer-cc-form-submit, #pre_pay_online_submit_button");
    if(this.value == "stripe") {
      $("#stripe-payments input, #stripe-payments select").attr("name", "");
      $.getScript("/javascripts/stripe_token.js");
    }
    else {
      $(".card-number").attr("name", "card_info[card_number]");
      $(".card-name").attr("name", "card_info[name]");
      $(".card-cvc").attr("name", "card_info[verification_value]");
      $(".card-expiry-date").attr("name", "card_info[expiry_date]");
      $(".card-address-line1").attr("name", "card_info[card-address-line1]");
      $(".card-address-line2").attr("name", "card_info[card-address-line2]");
      $(".card-address-country").attr("name", "card_info[card-country]");
      $(".card-address-state").attr("name", "card_info[card-address-state]");
      $(".card-address-city").attr("name", "card_info[card-address-city]");
      $(".card-address-zip").attr("name", "card_info[card-address-zip]");
      $('body').off('click', '#upgrade_package, #checkout-inventory-btn');
      $('#update-credit-card').off('click');
      $('body').off('click', '#customer-cc-form-submit');
      $.getScript("/javascripts/gateways.js");
    }
    if(this.value != "square") {
      $('#stripe-card-options').removeClass('hidden');
    }

    var gateway = $('.gateway_information').data('gateway', $('#payment_gateway').val());
    var gateways_card_availability = $('.gateways_card_availability').data('gateways-card-availability');
    var gateways_card_last_four    = $('.gateways_card_availability').data('card-last-four-digits-details');
    if (gateways_card_availability && gateways_card_availability[$('#payment_gateway').val()]) {
      var lastFour = gateways_card_last_four[$('#payment_gateway').val()];
      if(lastFour) {
        $('.last-four-digits').text(lastFour);
       }
      $('#existing-card').show();
    }
    else {
      $('#existing-card').hide();
    }
  });

  $('#add-detail-page-column').on('click', function(e){
    e.preventDefault();
    moveColumns('detail-page-columns-to-apply', 'applied-detail-page-columns', 'add-detail-page-column');
  });

  $('#add-pick-up-locations').on('click', function(e){
    e.preventDefault();
    moveColumns('all-pick-up-locations', 'selected-pick-up-locations', 'add-pick-up-locations');
  });

  $('#remove-pick-up-locations').on('click', function(e){
    e.preventDefault();
    moveItems('selected-pick-up-locations', 'all-pick-up-locations', 'add-pick-up-locations');
  });

  function togglePickUpLocation(){
    var webstore_pick_up_location = $('.webstore-pick-up-locations').is(':checked') && !($('.webstore-pick-up-locations').is(':disabled'));
    $('.show-available-locations').toggle(webstore_pick_up_location);
    $('.pick-up-location-mandatory').toggle(webstore_pick_up_location);
    $('#selected-pick-up-locations').prop("disabled", !webstore_pick_up_location);
  }

  $('.webstore-pick-up-locations').on('change', function(e){
    togglePickUpLocation();
  });

  togglePickUpLocation();

  $('#add-items-list-page-column').on('click', function(e){
    e.preventDefault();
    var selectedColumns = $('#items-list-page-columns-to-apply option:selected').length;
    var appliedColumns  = $('#applied-items-list-page-columns option:selected').length;
    if (appliedColumns + selectedColumns > 5){
      alert('A maximum of 5 attributes can be added to the items grid view.');
    } else {
      moveColumns('items-list-page-columns-to-apply', 'applied-items-list-page-columns', 'add-items-list-page-column');
    }
  });
  
  $('#add-bundles-list-page-column').on('click', function(e){
    e.preventDefault();
    var selectedColumns = $('#bundles-list-page-columns-to-apply option:selected').length;
    var appliedColumns = $('#applied-bundles-list-page-columns option:selected').length;
    if (appliedColumns + selectedColumns > 4){
      alert('A maximum of 4 attributes can be added to the bundle listing.');
    } else {
      moveColumns('bundles-list-page-columns-to-apply', 'applied-bundles-list-page-columns', 'add-bundles-list-page-column');
    }
  });

  $('#remove-items-list-page-column').on('click', function(e){
    e.preventDefault();
    moveColumns('applied-items-list-page-columns', 'items-list-page-columns-to-apply', 'remove-items-list-page-column');
  });

  $('#remove-bundles-list-page-column').on('click', function(e){
    e.preventDefault();
    moveColumns('applied-bundles-list-page-columns', 'bundles-list-page-columns-to-apply', 'remove-bundles-list-page-column');
  });
  $('#add-bundle-detail-page-column').on('click', function(e){
    e.preventDefault();
    moveColumns('bundle-detail-page-columns-to-apply', 'applied-bundle-detail-page-columns', 'add-bundle-detail-page-column');
  });

  $('#remove-detail-page-column').on('click', function(e){
    e.preventDefault();
    moveColumns('applied-detail-page-columns', 'detail-page-columns-to-apply', 'remove-detail-page-column');
  });

  $('#remove-bundle-detail-page-column').on('click', function(e){
    e.preventDefault();
    moveColumns('applied-bundle-detail-page-columns', 'bundle-detail-page-columns-to-apply', 'remove-bundle-detail-page-column');
  });

  $('.reset_report_dates').on('click', function(e){
    e.preventDefault();
    $('.dateField').val('');
  });

  $('body').on('click', '.signature_enable', function() {
    if(!$(this).is(':checked')){
      $("#" + $(this).data('signature-enforce')).prop('checked', false);
    }
  });

  $('body').on('click', '.signature_enforce', function() {
    if($(this).is(':checked')){
      $("#" + $(this).data('signature-enable')).prop('checked', true);
    }
  });

  $('body').on('click', ".show-items", function(){
    if ($(".selected-items").hasClass("hide")) {
      $(".show-items").text('Hide Details');
      $('.selected-items').fadeIn();
    } else {
      $(".show-items").text('Show Details');
      $('.selected-items').fadeOut();
    }
    $('.selected-items').toggleClass('hide');
  });

});

function moveColumns(moveFromId, moveToId, clickedOnId){
  moveItems(moveFromId, moveToId);
  $('#' + clickedOnId).prop('disabled', false);
}

function moveItems(id1, id2){
  var sel1 = document.getElementById(id1);
  var sel2 = document.getElementById(id2);
  $("#" + id1 + ' option:selected').each(function(){
    if (id1 != 'applied-bundle-detail-page-columns' || ($(this).val() != 'description' && $(this).val() != 'name'))
      $(sel2).append($(this));
  });
}

function moveSubGroups(selector1, selector2){
  $(selector1 + ' :selected').each(function(){
    if ($(selector2 + " optgroup[label='" + $(this).parent().attr('label') + "']").length == 0){
      $(selector2).append("<optgroup label='" + $(this).parent().attr('label') + "'></optgroup>");
    }
    $(selector2 + " optgroup[label='" + $(this).parent().attr('label') + "']").append($(this));
    if ($(selector1 + " optgroup[label='" + $(this).parent().attr('label') + "']").children().length == 0){
      $(selector1 + " optgroup[label='" + $(this).parent().attr('label') + "']").remove();
    }
  });
}

function moveItemDown(id) {
  var $element = $('#' + id + ' option:selected');
  $element.next().after($element);
}

function moveItemUp(id) {
  var $element = $('#' + id + ' option:selected');
  $element.prev().before($element);
}

function addAllGroupdOption(){
  if($('#selected-groups-for-alerts').children('option').length == 0){
    var option = '<option selected="selected" id="all-groups" value=all>All Groups</option>';
    $('#selected-groups-for-alerts').append(option);
    $("#move-items-left").prop('disabled', true);
  }
}

function addAllLocationOptions(){
  if($('#selected-locations-for-alerts').children('option').length == 0){
    var option = '<option selected="selected" id="all-locations" value=all>All Locations</option>';
    $('#selected-locations-for-alerts').append(option);
    $("#move-location-left").prop('disabled', true);
  }
}

//Use this method to disable submit buttons
var disableBtn = function(btnIdOrObject){
  if(typeof btnIdOrObject === 'string')
    btnIdOrObject = $(btnIdOrObject);

  btnIdOrObject.attr("disabled", "disabled");
  btnIdOrObject.text("Please wait");
  btnIdOrObject.val("Please wait");
};

 function setSearchFitler(radio){
  $("#formFilter").val(radio.value);
   }

function hide_side_bar(){
  $("#show_side_bar").show();
  $("#side_bar").hide();
  $("#hide_side_bar").hide();
  $("#dynamic_view_right").removeClass('span9');
  $("#dynamic_view_right").addClass('span12');
  $("#dynamic_view_left").hide();
  $(".dashboard-events-border").removeClass('span3');
  $(".dashboard-events-border").addClass('span4');
  refreshGoogleMap();
  // body...
}
function refreshGoogleMap() {
  if($('#google-map-container').length > 0) {
    var width = $('#google-map-container').width();
    $('#map_canvas').css('height', width * 0.55);
    $('#map_canvas').css('width', width * 0.9);
    
    var map = getGlobalData('map');
    if(map) {
      var center = map.getCenter();
      google.maps.event.trigger(map, "resize");
      map.setCenter(center);
    }
  }
}

jQuery.fn.modal.Constructor.prototype.enforceFocus = function () { };