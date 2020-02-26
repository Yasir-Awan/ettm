  $(document).ready(function(){

    if($('#ainInput').length > 0) {
      $('#ainInput').scannerDetection();
      $('#ainInput').focus();
    }

    $('#ainInput').on('scannerDetectionComplete', function(e, data){
      var itemId =  $('.ainInput')[0] ? parseInt($('.ainInput').first()[0].id.match(/\d+/)[0]) + 1 : 1;
      if(itemId === 1){
        $('.scanned-items-legend').show();
        $('#create-scanned-item').attr("disabled", false);
      }
      var itemAin = $(this).val().replace(/(^@)|(@$)/, '');
      $('.items').prepend("<div><input name='items_ain[" + itemId + "]' type='text' value=" + itemAin + " class='ainInput' id='item_" + itemId + "'><span class='margin-left-10 delete-scanned-item'><i class='icon-trash'></i></span></div>");
      $(this).val('');
      $(this).focus();
    });

    $('body').on('click', '.delete-scanned-item', function(){
      $(this).parent().remove();
      if($('.ainInput').length === 0){
        $('.scanned-items-legend').hide();
        $('#create-scanned-item').attr("disabled", true)
      }
      $('#ainInput').focus();
    });

    $("div.asset-thumb").prepend('<span class="thumb-checkbox">');

    $("#asset-history-link").on('click', function(e){
      if($("#collapse4").html().trim() == ""){
        $.ajax({ url: $(this).data('history-path') });
      }
      else if($("#collapse4").hasClass('in')){
        $("#collapse4").removeClass('in');
      }else{
        $("#collapse4").addClass('in');
      }
    });

    $("#include_retired_asset").on('click', function(){
      data  = "?search=" + $('#appendedPrependedInput').val();
      data += "&page=1";
      data += "&facet=" + $(this).val();
      data += "&search_bar=true";
      data += "&include_retired_assets=" + $(this).data('include-retired-assets');
      location.href = 'search' + data;
    });

    $("body").on("click", ".remove-filter", function(e){
      e.preventDefault();
      var filterName   = $(this).data('filter-name');
      var filterAction = $('#filter-action').val();
      
      if(filterAction == "inventory") {
        filterForm   = '#inventory_filter_frm';
        filterStatus = '#inventory_assets_filter';
      }
      else if(filterAction == 'stock_assets') {
        filterForm   = '#stock_filter_frm';
        filterStatus = '#stock_assets_filter';
      }
      else {
        filterForm   = '#asset_filter_frm';
        filterStatus = '#assets_filter';
      }

      $('#' + filterName).remove();
      if (filterName == 'location') {
        $('#applied-include-contained-assets').remove();
      } else if (filterName == 'availability_range') {
        $('#applied-include-overdue-assets').remove();
      } else if (filterName == 'reserved') {
        $('#applied-include-all-reserved-assets').remove();
      } else if (filterName == 'group') {
        $('#applied-sub-group-val').remove();
      }
      $(filterStatus).remove();
      $(filterForm).submit();
    });

    $("#current-checkout-custody-of-dialog  select").on('change',function(){
      var user_id = $(this).val();
      $("#current-checkout-custody-of-dialog").modal('hide');
      data = { user_id: user_id, current_checkout_status: 'quantity_in_custody_of' };
      $.get($('#current_checkout_filter_frm').attr('action'), data);
    });

    $('#reservation_requests input:checkbox').on('change', function(){
      $('#reservation_requests input:checkbox').not(this).prop('checked', false);  
    });

    $('#datetimepicker_asset_availability_start, #datetimepicker_asset_availability_end').datetimepicker({
      pickDate: false,
      pickSeconds: false
    });

    $('#enable-advanced-pricing').on('click', function(){
      $('#asset-advanced-pricing').show();
      $('#asset-flat-pricing').hide();
    });

    $('#enable-flat-pricing').on('click', function(){
      $('#asset-advanced-pricing').hide();
      $('#asset-flat-pricing').show();
    });

    $('#asset-zendesk-tickets-link').on("click", function(){
      $.ajax({url: location.href + "/get_tickets_from_zendesk" });
    });

    $('.reservation-checkout-link').on("click", function() {
      var actionPath = $(this).data('action-path');
      $('#approve_reservations_form').attr('action', actionPath);
      $('#approve_reservations_form_modal').modal({ backdrop:'static' });
    });

    $('#clear_availablility_fitlers_start').on("click",function(){
      $('#availability_range_start').val('');
      $('#availability_range_start-datepicker').val('');
      $('#availbility_range_time_start').val('');
    });

    $('#clear_availablility_fitlers_end').on("click",function(){
      $('#availability_range_end').val('');
      $('#availability_range_end-datepicker').val('');
      $('#availbility_range_time_end').val('');
    });

    $('#clear_range_fitlers_start').on("click",function(){
      if($('#reserved_range_end').val() == "" && $('#reserved_time_end').val() == ""){
        $('#include_all_reserved_assets').prop('checked', true);
      }
    });

    $('#clear_range_fitlers_end').on("click",function(){
      if($('#reserved_range_start').val() == "" && $('#reserved_time_start').val() == ""){
        $('#include_all_reserved_assets').prop('checked', true);
      }
    });

    $('#delete_from_library').on("click",function(){
      if($('#delete_from_library').prop("checked")){
        $('#remove_image').hide();
        $('#delete_image').show();
      }else{
        $('#remove_image').show();
        $('#delete_image').hide();
      }
    });

    $('body').on('click', "#edit_custom_attr_link", function(){
      url = '/assets/' + $(this).attr("asset_id") + '/get_custom_attributes_history'
      $.ajax({
        type: "GET",
        url: url,
        data: { history_id: $(this).attr("history_id")  }
      });
    });

    if( $('#add-to-cart').length > 0 && $('#print-label-large').length > 0 ){
      $('#add-to-cart').prop('id','small-add-to-cart');
      $('#print-label-large').prop('id','small-print-label');
    }

    $('body').on('click', "#custom_attr_history_submit_button", function(){
      $('#change_custom_attribute_history_form').submit();
    });

    $('body').on('click', ".remove_doc", function(e){
      e.preventDefault();
      doc_id = $(this).data('document-id');
      $(this).parents('#document_' + doc_id).remove();
    });

    $("#custom").change(function(){
      if($("#custom").is(':checked')){
        $("#note").show();
      }else{
        $("#note").hide();
      }
    });

    $("#mass_update_asset_form").submit(function() {
      if ($(".asset_field").length == 0) {
        alert("Please update any field to proceed");
        return false;
      }
    });

    $('#datetimepicker4').datetimepicker({
      pickDate: false,
      pickSeconds: false
    });

    var picker = $('#datetimepicker4').data('datetimepicker');
    if(picker) {
      if(typeof returnTime !== "undefined"){
        $('#till_time').val(returnTime);
      }else{
        picker.setLocalDate(new Date(0, 0, 0, 23, 59));
        $('#till_time').val('');
      }
    }

    $('body').on('click', '#clear_time, #clear_return_time', function(e){
      e.preventDefault();
      $('#till_time').val('');
      $('#return_time').val('');
    });

    $('body').on('click', '#checkout_forever_checkbox', function(){
      $('#till_time').val('');
      $('#till').val('');
      $('#till-datepicker').val('');
      $('#return_time').val('');
    });

    $('#return_time').click(function(){
      $('#checkout_forever_checkbox').prop("checked", false);
    });

    $('body').on('click', '#till, #till-datepicker', function(){
      $('#checkout_forever_checkbox').prop("checked", false);
    });
    
    $('body').on('click', '#service_indefinitely', function(){
      $('#service_date').prop('disabled', $(this).is(':checked'));
    });

    $('#extend_datetimepicker').datetimepicker({
      pickDate: false,
      pickSeconds: false
    });

    $('#extend_clear_time').on("click",function(){
      $('#extend_till_time').val('');
    });

    $('#extend_checkout_forever_checkbox').click(function() {
      $('#extend_till_time').val('');
      $('#extend_till').val('');
      $('#extend_till-datepicker').val('');
    });
    $('#extend_till_time, #extend_till').click(function() {
      $('#extend_checkout_forever_checkbox').prop("checked", false);
    });

    $('#dialog-form-items-in-order').on('hidden.bs.modal', function () {
      $('#search_all_baskets').val('');
    })

    $("#transfer_stock_suggested_price, #transfer_stock_quantity").on('keyup change focus', function(){
      $("#transfer_stock_total_price").prop('value', ($("#transfer_stock_quantity").prop('value') * $("#transfer_stock_suggested_price").prop('value')).toFixed(2));
    });
    
    $("#transfer_stock_total_price").on('keyup change focus', function(){
      $("#transfer_stock_suggested_price").prop('value', ($("#transfer_stock_total_price").prop('value') / $("#transfer_stock_quantity").prop('value')).toFixed(2));
    });

    $('.asset-picture').click(function(){
      var url = $(this).data('image-url');
      var fileName = $(this).data('file-name');
      $('#asset-image-modal').modal({backdrop:'static'});
      $('#asset-image-file').attr('src', url);
      $('.file-name').html(fileName);
    });

    function hideCheckinValues(){
      if($("#checkin_complete_package").is(':checked')){
        $("#checkin_custom_attributes").hide();
        $("#package_checkin_custom_attributes").show();
      }
      else{
        $("#checkin_custom_attributes").show();
        $("#package_checkin_custom_attributes").hide();
      }
    }

    function hideCheckoutValuesAndReservations(){
      if($("#checkout_complete_package").is(':checked')){
        $("#checkout_custom_attributes").hide();
        $("#package_checkout_custom_attributes").show();
        $(".other_assets_reservations").show();
      }
      else{
        $("#checkout_custom_attributes").show();
        $("#package_checkout_custom_attributes").hide();
        $(".other_assets_reservations .reservation_checkbox").prop('checked', false);
        $(".other_assets_reservations").hide();
      }
    }

    hideCheckinValues();
    hideCheckoutValuesAndReservations();
    $("#checkin_complete_package").click(hideCheckinValues);
    $("#checkout_complete_package").click(hideCheckoutValuesAndReservations);

    $('.dp').datepicker();


    var putRequest = function(path, data){
      if(!data){
        $.ajax({type: "PUT", url: path});
      }else{
        $.ajax({type: "PUT", url: path, data: data});
      }
    };

    var postRequest = function(path,formid,data){
      if(formid != null){
        data = $('#'+formid).serialize() + '&' + data ;
      }
      $.ajax({type: "POST", url: path, data: data});
    };

    var process_mass_edit = function(path){
      asset_form = $('#'+formid);
      asset_form.attr('action', path);
      asset_form.attr('method', 'GET');
      asset_form.submit();
    };

    $("body").on("click", "#reservation-btn, #reservation_submit", function(){
      if (!validateSignaturePad('#modelDialog')){
        return false;
      }
      var locationValue;
      if($(this).attr('id') == "reservation_submit"){
        locationValue = $('#location_id').val();
      }else{
        locationValue = $('#checkout_location_dropdown').val();
      }
      return checkForLocationValue('reservation', locationValue, "Location");
    });
    
    $('body').on('submit', "#reservation-form, #inventory-reservation-form", function(){
      if (!validateSignaturePad('#modelDialog')){
        return false;
      }
      return check_enforced_attrs("reservation");
    });

    $('#modelDialog').on("click", '#Checkout', function(e){

      if (!validateSignaturePad('#modelDialog')){
        return false;
      }

      if(!checkForLocationValue('checkout', $('#checkout_values_location_id').val(), "Location")){
        return false;
      }


      
      if($('#user_id').val() == ''){
        alert('Select a user');
        return;
      }

      if(!check_enforced_attrs("checkout")) return false;

      flag = checkNumberLength($('.number_field'));
      if(!flag){
        return flag;
      }else if(!validTillTime($('#till').val(), $('#till_time').val(), $('#checkout_forever_checkbox').prop("checked"))){
        return false;
      }
      e.preventDefault();

      payload= $("#checkout-form").serialize();
      selected_reservation_assets = [];
      $('.reservation_checkbox:checked').each(function(){
        selected_reservation_assets.push($(this).data('asset'));
      });
      previous_length = selected_reservation_assets.length;

      if(previous_length > $.unique(selected_reservation_assets).length){
        alert("Multiple reservations for a single asset cannot be approved.");
      }
      else{
        disableBtn('#Checkout');
        if(action_type == 'put'){
          putRequest(checkOutPath, payload);
        }else{
          postRequest(checkOutPath,formid,payload);
        }
        $('#dialog-form-checkout').modal('hide');

      }
    });

    $('body').on('click', '#sub-checkout', function(e){
      e.preventDefault();

      if($('#user_id').val() == ''){
        alert('Select a customer');
        return;
      }

      if ($('#asset_checkin_due_on').val() != undefined) {
        if(!validTimeForSubCheckout($('#sub-checkout-till').val(), $('#sub-checkout-till-time').val(), $('#asset_checkin_due_on').val())){

          alert('The return date must be before ' + serverTimezoneDateString(parseInt($('#asset_checkin_due_on').val(), 10)) + ' to avoid time conflicts.')
          return false;
        }
      } else if(!validTillTime($('#sub-checkout-till').val(), $('#sub-checkout-till-time').val(), $('#sub_checkout_forever_checkbox').prop("checked"))){
        return false;
      }

      payload = $("#sub-checkout-form").serialize();
      disableBtn('#sub-checkout');
      if(action_type == 'put'){
        putRequest(subCheckoutPath, payload);
      }else{
        postRequest(subCheckoutPath, formid, payload);
      }
      $('#modelDialog').modal('hide');
    });

    $('body').on('click', '#sub-checkin', function(e){
      e.preventDefault();

      payload = $("#sub-checkin-form").serialize();
      disableBtn('#sub-checkin');

      if(action_type == "put"){
        putRequest(subCheckinPath, payload);
      } else {
        postRequest(subCheckinPath, formid, payload);
      }
      $('#modelDialog').modal('hide');
    });

    $('body').on('click', '#extend-sub-checkout', function(e){
      e.preventDefault();

      if ($('#asset_checkin_due_on').val() != undefined) {
        if(!validTimeForSubCheckout($('#extend-sub-checkout-till').val(), $('#extend-sub-checkout-till-time').val(), $('#asset_checkin_due_on').val())){
          alert('The return date must be before ' + serverTimezoneDateString(parseInt($('#asset_checkin_due_on').val(), 10)) + ' to avoid time conflicts.')
          return false;
        }
      } else if(!validTillTime($('#extend-sub-checkout-till').val(), $('#extend-sub-checkout-till-time').val(), $('#extend_sub_checkout_forever_checkbox').prop("checked"))){
        return false;
      }

      payload = "";
      if(!$('#extend_sub_checkout_forever_checkbox').is(':checked')){
        payload += "till=" + $('#extend-sub-checkout-till').val() + "&till_time=" + $('#extend-sub-checkout-till-time').val();
      }

      if(action_type == 'put'){
        putRequest(extendSubCheckOutPath, payload);
      }else{
        postRequest(extendSubCheckOutPath, formid, payload);
      }
      $('#modelDialog').modal('hide');
    });

    $('#modelDialog').on('click', '#transfer_custody', function(e){
      if(!checkForLocationValue('transfer_custody', $('#transfer_custody_values_location_id').val(), "Location")){
        return false;
      }
      if (!validateSignaturePad('#modelDialog')){
        return false;
      }
      payload= $("#transfer_custody-form").serialize();
      disableBtn('#transfer_custody');
      if(action_type == 'put'){
        putRequest(transferCustodypath, payload)
      }else{
        postRequest(massTransferCustodypath, formid, payload);
      }
      $('#transfer_custody_dialog').modal('hide');
    });

    function basketLabel(){
      return isRentals ? 'order' : 'cart';
    }

    $('#asset-details, #system-details, #hardware-details, #software-details').on('click', function(e){
      $(this).addClass('btn-primary').siblings().removeClass('btn-primary');
      $("." + $(this).attr('id')).show().siblings().hide();
    });

    $('body').on('click', '#show-hardware', function(e){
      $.ajax({type: "GET", url: $('#show-hardware').data('show-hardware-url')});
    });

    $('#modelDialog').on('click', '#add_to_basket, #add_to_current_basket', function(e){
      var requiredFieldsSet = isRentals ? (($('#inventory_quantity').val() !=  "") && ($('#inventory_price').val() !=  "")) : ($('#inventory_quantity').val() !=  "");
      if(requiredFieldsSet){
        var data = '';
        if (isRentals){
          data += "basket_sequence_num=" + $('#order_ids').val();
        }else{
          data += "basket_sequence_num=" + $('#cart_number').val();
        }
        if($('#inventory_quantity').length > 0){
          data += "&inventory_quantity=" + $('#inventory_quantity').val();
        }
        if($('#inventory_price').length > 0){
          data += "&inventory_price=" + $('#inventory_price').val();
        }
        if($('#inventory_location_id').length > 0){
          data += "&inventory_location_id=" + $('#inventory_location_id').val();
        }
        $('#add_to_' + basketLabel() + '_dialog').modal('hide');
        postRequest(addToBasketpath, formid, data)
        return false;
      }
    });

    $('#modelDialog').on('click', '#add_to_purchase_order', function(e){
      var data = "purchase_order_sequence_num=" + $('#purchase_order_ids').val();
      $('#add-to-po-dialog').modal('hide');
      postRequest(addToPurchaseOrderPath, formid, data)
      return false;
    });

    $('#modelDialog').on('click', '#add_to_po_for_request_stock', function(e) {
      var poSequenceNum = $('#purchase_order_ids').val();
      if(poSequenceNum == undefined || poSequenceNum == '') {
        alert('Enter purchase order number to proceed.');
        return false;
      }
      var data = "purchase_order_sequence_num=" + $('#purchase_order_ids').val();
      var path = '/purchase_orders/' + $('#purchase_order_ids').val() + '/add_items';
      postRequest(path, 'request_stock_for_po_form', data);
      return false;
    });

    function validTimeForSubCheckout(till_date, till_time, due_date){
      var tillTime = till_time == "" ? "23:59:00" : till_time;
      var returnDate = Date.parse(till_date + " " + tillTime) / 1000;
      var dueDate = parseInt(due_date, 10);
      return returnDate <= dueDate;
    }

    function validateSignaturePad(parentId){
      if ($(parentId + ' #signature_mandatory').val() == "true" && $(parentId + ' #signature_input').val() == ""){
        alert("You must provide a signature to proceed");
        return false;
      }
      return true;
    }

    function validTillTime(till_date, till_time, checkoutForever){
      if((till_time == "" && till_date == "" && !checkoutForever) || (till_time != "" && till_date == "")){
        alert("Please select a valid return date");
        return false;
      }else if(till_date != ""){
        if(till_time == "")
          till_time = "23:59";
        var currentdate = new Date();
        var returndate = Date.parse(till_date + " " + till_time);
        if(currentdate < returndate){
          return true;
        }else{
          alert("Return time should be greater than current time");
          return false;
        }
      }else{
        return true;
      }
    }

    $('#modelDialog').on('click', '#Checkin', function(e){
      if($(this).attr('disabled')){
        return;
      }
      if(!checkForLocationValue('checkin', $('#checkin_values_location_id').val(), "Location")){
        return false;
      }

      if (!validateSignaturePad('#modelDialog')){
        return false;
      }

      if(!check_enforced_attrs("checkin")) return false;
      e.preventDefault();
      flag = checkNumberLength($('.number_field'));
      if(!flag)
        return flag;

      payload= $("#checkin-form").serialize();
       disableBtn('#Checkin');
      if(action_type == "put"){
        putRequest(checkInPath,payload);
      }else{
        postRequest(checkInPath,formid,payload);
      }
    });

    $("#Extend_Checkout").click(function(e){
      if(!validTillTime($('#extend_till').val(), $('#extend_till_time').val(), $('#extend_checkout_forever_checkbox').prop("checked"))){
        return false;
      }

      if(!$('#extend_checkout_forever_checkbox').prop("checked") && $("#sub_checkin_due_on").val() != undefined && !validExtendCheckoutDate($("#sub_checkin_due_on").val(), $('#extend_till').val(), $('#extend_till_time').val())){
        var dueDate = new Date(parseInt($('#sub_checkin_due_on').val(), 10));
        alert('The return date must be after ' + serverTimezoneDateString(parseInt($('#sub_checkin_due_on').val(), 10)) + ' to avoid time conflicts.')
        return false;
      }

      e.preventDefault();
      payload= "";
      if($('#ignore_conflicting_reservations_checkbox').is(':checked')){
        payload += "ignore_conflicting_reservations=" + true+ "&";
      }
      if(!$('#extend_checkout_forever').is(':checked')){
        payload += "till=" + $('#extend_till').val() + "&till_time=" + $('#extend_till_time').val();
      }
      if(action_type == 'put'){
          putRequest(extendCheckOutPath, payload);
      }else{
          postRequest(extendCheckOutPath, formid, payload);
      }

      $('#dialog-form-extend-checkout').modal('hide');
    });

    function validExtendCheckoutDate(sub_checkin_due_date, till_date, till_time){
      if(sub_checkin_due_date != undefined){
        var subCheckinDueDate = parseInt(sub_checkin_due_date, 10);
      }
      var tillTime = till_time == "" ? "23:59:00" : till_time;
      var returnDate = Date.parse(till_date + " " + tillTime) / 1000;
      return subCheckinDueDate == undefined || returnDate > subCheckinDueDate
    }

    $("#Send_Request").click(function(e){
      data = "by=" + $("#check_in_by").val();
      if(action_type == 'put'){
      putRequest(reqCheckInPath, data);
      }else{
      postRequest(reqCheckInPath,formid,data);
      }
      $('#dialog-form-request').modal('hide');
    });

    $("#Retire").click(function(e){
      e.preventDefault();
      if($("#asset_salvage_value").length > 0){
        if(isNaN($("#asset_salvage_value").val()) || (parseFloat($("#asset_salvage_value").val()) < 0.0)){
          jui_alert("Salvage value must be greater than or equal to 0.0");
          return false;
        }
      }
      payload = $("#retire-form").serialize();
      postRequest(retireAssetPath,formid,payload);
      $('#dialog-form-retire').modal('hide');
    });

   $('body').on('click', '#mass-delete', function(e){
      e.preventDefault();
      postRequest($('#mass-delete-path').val(), formid, null);
    });

    var requestAudit = function(path,type){
      if(type != "post"){
        $.ajax({type: "GET", url: path});
      }else{
        if ($('#'+formid).serialize()){
          if($("input:checked").length > 0){
            postRequest(auditPath,formid);
          }else{
            alert('Please select an asset to proceed');
            return false;
          }
        }
      }
    }  ;


    var requestCheckout = function(path, type){
      if(type != "post"){
        $.ajax({type: "GET", url: path});
      }else{
        //to be implemented in case mass request reservation
      }
    };

    var requestReservation = function(path, type){
      if(type != "post"){
        $.ajax({type: "GET", url: path});
      }else{
        if ($('#'+formid).serialize()){
          if($("input:checked").length > 0){
            postRequest(requestReservationPath,formid);
          }else{
            alert('Please select an asset to proceed');
            return false;
          }
        }
        //to be implemented in case mass request reservation
      }
    };


    var processOrder = function(asset_action, checkboxSelector){
      //TODO: This whole function needs to be refactored.
      var totalQuantity = 0;
      $("#location_by_quantity_options").val("");
      $('#new-location').html("");
      if(asset_action == "Add Stock"){
        $('#new-location').html("<a id='add_location_ajax_link_in_asset_form' data-remote='true' href='/locations/new' data-original-title=''>or Add new Location</a>");
      }
      if(asset_action == 'Add Stock' || asset_action == 'New Sale'){
        $("#company_location_select").empty();
        var location;
        data = "asset_action=" + asset_action;
        data= data + "&asset_id=" + $("#assetId").val() ;
        $.ajax({
          type: "GET",
          url: '/locations/get_line_item_locations',
          data: data,
          dataType: "json",
          success:function(data){
            if(data.include_blank == true && (asset_action != "New Sale" || parseInt($("#location_by_quantity_options option[value='']").text().trim()) > 0)){
              $("#company_location_select").append("<option value=''></option>");
            }
            for( i=0 ; i< data.locations.length ; i++ ){
              location = data.locations[i];
              if(asset_action != "New Sale" || parseInt($("#location_by_quantity_options option[value='" + location.id + "']").text().trim()) > 0){
                $("#company_location_select").append("<option value=" + location.id + ">" + location.name + "</option>");
              }
            }
            $("#company_location_select option[value='" + data.default_location + "']").attr("selected", "selected");
            totalQuantity = $("#location_by_quantity_options option[value='" + $("#company_location_select option:selected").val() + "']").text().trim();
            if(isNaN(totalQuantity) || totalQuantity == ''){
              totalQuantity = 0;
            }

            $("#txt_total_quantity").val(totalQuantity);
            $("#hidden_total_quantity").val(totalQuantity);
            $("#order_total_quantity_label_number").html(totalQuantity);
          }
        });
      }

      if (asset_action == 'New Sale' &&
        $("select#line_item_checked_out_to_location").length > 0) {
        var locations_url = '/locations/company_locations';
        $.getJSON(locations_url).done(function(data) {
          $("select#line_item_checked_out_to_location").empty();
          $("select#line_item_checked_out_to_location").html(data);
        });
      }

      if(asset_action == 'Request-check-in' || asset_action == 'Deny-stock-checkin'){
        $("form#new_line_item").submit();
      }

      toggleOrderFormFields(asset_action, checkboxSelector);

      $('#dialog-form-order').modal({backdrop:'static'});
      $("input#txt_order_quantity").focus();

      $("#process_order").off('click').on('click', function(e){

        e.preventDefault();
        if(!validateSignaturePad('#dialog-form-order')){
          return false;
        }

        if($('#order_type').val() == "checkout"){
          if(parseInt($('#txt_order_quantity').val()) == 0 || $('#txt_order_quantity').val() == ''){
            alert('Quantity should be greater than 0');
            return;
          }
          if(!checkForLocationValue($('#order_type').val(), $('#line_item_checked_out_to_location').val(), "Checkout At Location")){
            return false;
          }
        }

        if($("#process_order").attr('disabled') != undefined) {
          return;
        }

        if($("#order_type").val() == "Add Stock"){
          var number_fields= $("#dialog-form-order").find(".add_stock_number_field");
          for( var i=0; i< number_fields.length ; i++){
            if(!number_fields[i].checkValidity()){
              alert("Numeric fields can only contain numbers");
              number_fields[i].focus();
              return;
            }
          }
          if(!check_enforced_attrs("add_stock")){
            // alert("Please fill the required fields");
          }
          else if(parseInt($("#txt_total_quantity").val()) > parseInt($("#hidden_total_quantity").val())){
            disableBtn('#process_order');
            $("form#new_line_item").submit();
            $('#dialog-form-order').modal('hide');
          }
          else{
            alert("Total quantity should be greater than " + $("#hidden_total_quantity").val());
          }
        }else if($('#order_type').val() == 'checkin'){
          if(!check_enforced_attrs("checkin_stock")) return false;
          if(!isMassAction){
            if(parseInt($('#txt_order_quantity').val()) == 0 || $('#txt_order_quantity').val() == ''){
              alert('Quantity should be greater than 0');
              return;
            }
            else if(parseInt($('#txt_order_quantity').val()) > parseInt($('#total_checked_out_quantity').val())){
              alert('Quantity should be less than total checked out quantity i.e. ' + $('#total_checked_out_quantity').val());
              return;
            }
          }
          disableBtn('#process_order');
          $("form#new_line_item").submit();
          $('#dialog-form-order').modal('hide');
        }
        else{
          if($("#order_type").val() != 'New Sale'){
            if(!check_enforced_attrs("checkout_stock")) return false;
            if(!check_enforced_attrs("remove_stock")) return false;
          }
          if(parseInt($("#txt_total_quantity").val()) < 0){
            alert("Quantity should be less than " + $("#hidden_total_quantity").val());
          }
          else if(parseInt($("#txt_order_quantity").val()) < 0){
            alert("Quantity should be greater than zero");
          }
          else if(parseInt($("#txt_total_quantity").val()) >= parseInt($("#hidden_total_quantity").val())){
            // alert("Total Quantity should be less than " + $("#hidden_total_quantity").val());
          }
          else if(!check_enforced_attrs("remove_stock")){
            // alert("Please fill the required fields");
          }
          else{
            disableBtn('#process_order');
            $("form#new_line_item").submit();
            $('#dialog-form-order').modal('hide');
          }
        }
      });
    } ;

    $("#order_total_quantity_label_span").click(function(e){
      $("#order_total_quantity_span").show();
      $(this).hide();
    });
    
    $("#transfer-stock").click(function(e){
      e.preventDefault();


      if (!validateSignaturePad('#dialog-stock-transfer')){
        return false;
      }

      if($('#to_location').val() == $('#from_location').val())
      {
        alert('Please select different locations');
        return false;
      }

      if($('#transfer_stock_quantity').val() <= 0)
      {
        alert('Please enter correct amount of quantity');
        $('#transfer_stock_quantity').focus();
        return false;
      }

      if(parseInt($('#transfer_stock_quantity').val()) > parseInt( $('#from_location_total').text()))
      {
        alert('There are not enough stock items at your chosen location to transfer from');
        $('#transfer_stock_quantity').focus();
        return false;
      }

      $(this).attr('disabled', true);
      $(this).text("Please wait");

      $("#dialog-stock-transfer").modal('hide');
      $("form#transfer-stock-form").submit();
    });

    $('.transfer-stock, .transfer-stock-location').change(function(){
      var other_select_tag_id = '#to_location';
      if(this.id == 'to_location')
        other_select_tag_id = '#from_location';
      $(other_select_tag_id + "  option").prop("disabled", false);
      $(other_select_tag_id).find("[value='" + this.value + "']").prop('disabled', true);
      var totalQuantity = 0;
      $("#location_by_quantity_options").val(this.value);
      if($("#location_by_quantity_options option:selected").text().trim() != ""){
        totalQuantity = $("#location_by_quantity_options option:selected").text().trim()
      }

      if (this.className.indexOf('transfer-stock-location') >= 0) {
        $('#to_stock_location_total').html(totalQuantity);
      } else {
        $('#' + this.id + '_total').html(totalQuantity);
      }
      
    });

    $("#mass-checkin-stock-assets").click(function(e){
      if(!check_enforced_attrs("checkin_stock")) return false;
    });

    $("#mass_change_image").click(function(e){
      e.preventDefault();
      buttonTxt = $("#mass_change_image").text();

      if($("#image").val() == ""){
        alert("Please select a file to upload");
      }else{
        disableBtn("#mass_change_image");
        if(buttonTxt == "Change"){
          $("#mass_change_image_form").submit();
        }
      }
    });

    $('#stock-assets-mass-extend-checkout-dialog form').on('submit', function(){
      $('#stock-assets-mass-extend-checkout-dialog').modal('hide');
    });

    $('#stock-assets-mass-checkin-dialog form').on('submit', function(){
      $('#stock-assets-mass-checkin-dialog').modal('hide');
    });

    $("#print-label").click(function(e){
      data = "copies=" + $("#copies").val();
      if(isNaN($("#copies").val()) || $("#copies").val() > 100){
        alert("Number of copies should be between 1 - 100");
        return false;
      }
      if(typeof formid != "undefined"){
        postRequest(printLabelPath,formid,data);
      }else{
        postRequest(printLabelPath,null,data);
      }
      $('#inventory-print-label').modal('hide');
    });

    $("#select-po-to-add-stock-btn").click(function(e) {
      $.ajax({type: "GET", url: "/assets/mass_add_to_purchase_order?request_stock=true"});
    });

    function get_resources_for_mass_delete()
    {
        var data = $('#'+formid).serialize();
        $.ajax({type: "GET", url: '/assets/resources_for_mass_delete?form_id=' + formid, data: data});
    }

    var performAction = function(asset_action,type){
      if (asset_action == "Mass Print Code Volatile" || asset_action == "Mass Edit Volatile" || asset_action == 'Add to Basket Volatile' || asset_action == 'Mass Delete Volatile' || asset_action == 'Change Display Picture Volatile' || asset_action == 'Add to Purchase Order Volatile'){
        formid = 'volatile_asset_form';
      }else if (asset_action == "Mass Print Code Stock" || asset_action == "Mass Edit Stock" || asset_action == 'Add to Basket Stock' || asset_action == 'Mass Delete Stock' || asset_action == 'Change Display Picture Stock' || asset_action == 'Add to Purchase Order Stock'){
        formid = 'stock_asset_form';
      }else{
        formid = 'asset_form';
      }
      switch(asset_action){
        case 'Request Audit':
          //Audit is now a resource
          requestAudit(auditPath,type);
          //data = $('#'+formid).serialize();
          //}else{
          //   $.ajax({type: "GET", url: auditPath});
          //}
          break;
        case 'Acknowledge':
        break;
        case 'Request Reservation':
          requestReservation(requestReservationPath,type);
        break;
        case 'Request Checkout':
          requestCheckout(requestCheckoutPath,type);
        break;
        case 'Mass Print Code Fixed':
          postRequest(printCodePath,formid);
        break;
        case 'Mass Print Code Volatile':
        case 'Mass Print Code Stock':
          $('#inventory-print-label').modal({backdrop:'static'});
        break;
        case 'Show Anchor Tags':
          $('#anchor-tags-widget').modal({backdrop:'static'});
        break;
        case 'Print Code':
          $('#inventory-print-label').modal({backdrop:'static'});
        break;
        case 'Retire':
          $('#dialog-form-retire').modal({backdrop:'static'});
          break;
        case 'Activate':
          postRequest(activateAssetPath,formid);
          break;
        case 'Request Checkin':
          $('#dialog-form-request').modal({backdrop:'static'});
          break;
        case 'Arbitrated Checkin with Custom Fields':
          $('#request-checkin-dialog').modal({backdrop:'static'});
          break;
        case 'Stock Asset Mass Checkin':
          selectedLineItems    = $('.selected_assets_checkbox:checked').map(function(){ return this.value }).get().join(',');
          $('#selected_line_items').val(selectedLineItems);
          $('#stock-assets-mass-checkin-dialog').modal({backdrop:'static'});
          break;
        case 'Stock Asset Extend Checkout':
          selectedLineItems    = $('.selected_assets_checkbox:checked').map(function(){ return this.value }).get().join(',');
          $('#selected_line_item').val(selectedLineItems);
          $('#stock-assets-mass-extend-checkout-dialog').modal({backdrop:'static'});
          break;
        case 'Arbitrated Checkin':
          jui_confirm('Are you sure you want to send request for checkin?', function(){
            if(action_type == 'put'){
              putRequest(arbitratedCheckinPath);
            }else{
              postRequest(arbitratedCheckinRequestPath,formid);
            }

          });
          break;
        case 'Arbitrated Checkin Stock':
          $('#request-checkin-stock-assets-modal').modal({backdrop:'static'});
          break;
        case 'Approve Checkin Requests':
          $('#approve-checkin-stock-assets-modal').modal({backdrop:'static'});
          break;
        case 'checkin-stock':
          $('#checkin-stock-assets-modal').modal({backdrop:'static'});
          break;
        case 'Checkin':
          var selected_assets= '';
          var data = '';
          $('.selected_assets_checkbox:checked').each(function(){
            selected_assets +=  $(this).prop('value') + ',';
          });
          
          if(selected_assets.length > 0){
            data = "asset_sequence_nums=" + JSON.stringify(selected_assets.slice(0,-1)) + "&mass_action=" + 'checkin';
            $.get('/assets/get_data_for_mass_actions', data);
          }
          else if(selected_assets.length == 0){
            seq = $('#checkin-asset').data('seqs');
            $.get("/assets/" + seq + "/get_data_for_actions", "asset_action=checkin");
          }

          break;
        case 'Change Display Picture Volatile':
        case 'Change Display Picture Stock':
        case 'Change Display Picture':
          $.ajax({type: "GET", url: '/documents/get_list', data: { change_display: true, images_only: true, resource_type: 'Asset', scope: 'Asset' }});
          break;

        /* we have changed checkout request as resource so this is not in use now
        case 'Arbitrated Checkout':
          jui_confirm('Are you sure you want to send request for checkout?', function(){
            if(type == "put"){
              $.ajax({type: "GET", url: reqCheckOutPath});
            }else{
              postRequest(reqCheckOutPath,formid);
            }
          });
          break; */
        case 'Checkout':
          //checkOut($('#till'), $('#user_id'), $('#checkout_forever'), type);
          selected_assets= '';
          $('.selected_assets_checkbox:checked').each(function(){
            selected_assets +=  $(this).prop('value') + ',';
          });
          if(selected_assets.length > 0){
            data = "asset_sequence_nums=" + JSON.stringify(selected_assets.slice(0,-1)) + "&mass_action=" + 'checkout';
            $.get('/assets/get_data_for_mass_actions', data);
          }
          else if(selected_assets.length == 0){
            seq = $('#checkout-asset').data('seqs');
            $.get("/assets/" + seq + "/get_data_for_actions", "asset_action=checkout");
          }
          break;
        case 'Associate':
          $('#dialog-form-associate-assets').modal({backdrop:'static'});
          break;
        case 'Extend Checkout':
          $('#dialog-form-extend-checkout').modal({backdrop:'static'});
          break;
        case 'sub_checkout':
        case 'sub_checkin':
        case 'extend_sub_checkout':
          var selected_assets = $('.selected_assets_checkbox:checked').map(function(){ return this.value }).get().join(',');
          $.get('/assets/show_mass_sub_checkouts_dialog', { 'asset_action': asset_action, 'seqs': selected_assets });
          break;
        case 'New Sale':
          processOrder(asset_action, null);
          break;
        case 'Add Stock':
          processOrder(asset_action, null);
          break;
        case 'Request Stock':
          $('#dialog-stock-request').modal({backdrop:'static'});
          $("#dialog-stock-request").css('zIndex', 1041);
          break;
        case  'Transfer Stock':
          $('#dialog-stock-transfer').modal({backdrop:'static'});
          break;
        case 'Mass Edit Volatile':
        case 'Mass Edit Stock':
        case 'Mass Edit':
          process_mass_edit(massEditAssetPath);
          break;
        case 'Mass Delete Volatile':
        case 'Mass Delete Stock':
        case 'Mass Delete':
          get_resources_for_mass_delete();
          break;
        case 'Start Service':
          var selected_assets = $('.selected_assets_checkbox:checked').map(function(){ return this.value }).get().join(' ');
          $.get('/assets/mass_start_service', { 'seqs': selected_assets, 'return_url': location.href });
          break;
        case 'Schedule Service':
          var selected_assets = $('.selected_assets_checkbox:checked').map(function(){ return this.value }).get().join(' ');
          $.get('/assets/mass_schedule_service', { 'seqs': selected_assets, 'return_url': location.href });
          break;
        case 'End Service':
          var selected_assets = $('.selected_assets_checkbox:checked').map(function(){ return this.value }).get().join(' ');
          $.get('/assets/mass_finish_service', { 'seqs': selected_assets, 'return_url': location.href });
          break;
        case 'Extend Service':
          var selected_assets = $('.selected_assets_checkbox:checked').map(function(){ return this.value }).get().join(' ');
          $.get('/assets/mass_extend_service', { 'seqs': selected_assets, 'return_url': location.href });
          break;
        case 'Add to Basket Volatile':
        case 'Add to Basket Stock':
        case 'Add to Order':
          if (isRentals || canAddItemsToReservedCarts){
            if(typeof(assetNum) == 'undefined'){
              var assetNumber = '';
            }
            else{
              var assetNumber = assetNum;
            }
            var assetType = $('#add-to-cart').data('type') || $('#small-add-to-cart').data('type');
            $.get('/assets/add_to_basket', { 'type': assetType, 'sequence_num': assetNumber});
          }
          else{
            postRequest(addToBasketpath,formid);
          }
          break;
        case 'Add to Cart':
          if(typeof(assetNum) == 'undefined'){
            var sequenceNumber = '';
          }
          else{
            var sequenceNumber = assetNum;
          }
          var assetType = $('#add-to-cart').data('type') || $('#small-add-to-cart').data('type');
          $.get('/assets/add_to_basket', { 'type': assetType, 'sequence_num': sequenceNumber });
          break;
        case 'Verify Possession':
          postRequest(massVerifyPossessionPath, formid);
          break;
        case 'Add to Purchase Order Stock':
        case 'Add to Purchase Order Volatile':
        case 'Add to Purchase Order':
          $.ajax({type: "GET", url: "/assets/mass_add_to_purchase_order"});
          break;
        case 'Transfer Custody':
          selected_assets= '';
          $('.selected_assets_checkbox:checked').each(function(){
            selected_assets +=  $(this).prop('value') + ',';
          });

          if(selected_assets.length == 0){
            seq = $('#transfer-custody').data('seqs');
            $.get("/assets/" + seq + "/get_data_for_actions", "asset_action=transfer_custody");
          }
          else if(selected_assets.length > 0){
            data = "asset_sequence_nums=" + JSON.stringify(selected_assets.slice(0,-1)) + "&mass_action=" + 'transfer_custody';
            $.get('/assets/get_data_for_mass_actions', data);
          }
        default:
          //no action
        }
    }  ;

    $('#datepicker').datepick({altField: "#till", altFormat: "m/d/yyyy", minDate: 0});
    $('#datepicker-request').datepick({altField: "#check_in_by", altFormat: "m/d/yyyy", minDate: 0});
    $(function(){
      if (typeof(checkinDate) == "undefined" || checkinDate == ''){
        $('#extend_checkout_datepicker').datepick({altField: "#extend_till", altFormat: "m/d/yyyy", minDate: 0});
      }else{
        $('#extend_checkout_datepicker').datepick({altField: "#extend_till", altFormat: "m/d/yyyy", minDate: 0, defaultDate: checkinDate});
      }
    });

    $('body').on('click', "#action_links a, #action-buttons-wrapper a , #add-stock-flash", function(e){
      e.preventDefault();
      if($(this).attr('href') == "#post"){
        // Note(Sohaib): In the groups page, multiple #mass_actions are rendered.
        // A simple $('#mass_action input:checked') will always fetch the first
        if ($(this).closest('#asset-list').find('#mass_action input:checked').length > 0) {
          performAction($(this).data("action"),"post");
          action_type = "post";
        }else{
          alert('Please select an asset to proceed');
          return false;
        }
      }else{
        performAction($(this).data("action"),"put");
        action_type = "put";
      }
    });

    $('body').on('click', ".show-asset-details", function(e){
      e.preventDefault();
      $('#deletion-detail').show();
      $('.show-asset-details').hide();
    });

    $('#retire_stock_button').on('click', function(e){
      e.preventDefault();
      $('#retire_stock_dialog').modal({ backdrop: 'static' });
    });

    $('#add-to-po-btn').on('click', function(e){
      e.preventDefault();
      $('#add-to-po-dialog').modal({ backdrop: 'static' });
    });

    $('#change_location_btn').on('click', function(e){
      e.preventDefault();
      $('#change_location_dialog').modal({ backdrop: 'static' });
    });

    $('#asset_location_history').on('click', function(e){
      e.preventDefault();
      $('#location_history').modal({ backdrop: 'static' });
    });

    $('#action-buttons-wrapper-stock-asset .dropdown-menu a, #checkin-stock, #request-checkin-stock, #approve-checkin-requets, #deny-checkin-request').on('click', function(e){
      e.preventDefault();
      if ($(this).attr('id') == 'checkin-stock') {
        var checkboxSelector = '#checkin-list ';
        $('#checkin-stock-assets-modal').modal('hide');
      } else if($(this).attr('id') == 'request-checkin-stock') {
        var checkboxSelector = '#request-checkin-stock-list ';
        $('#checkin-stock-assets-modal').modal('hide');
      } else if($(this).attr('id') == 'approve-checkin-requets' || $(this).attr('id') == 'deny-checkin-request') {
        var checkboxSelector = '#checkin-list ';
        $('#approve-checkin-stock-assets-modal').modal('hide');
      } else {
        var checkboxSelector = '#checkin-stock-list ';
      }
      if($(checkboxSelector + '.selected_checkouts_checkbox:checked').length > 0){
        selected_item_ids = [];
        $(checkboxSelector + '.selected_checkouts_checkbox:checked').each(function(){ selected_item_ids.push($(this).val()); });
        $('.selected_line_items').val(selected_item_ids.join());
        if($(this).data('action') == 'Check-in'){
          isMassAction = $(checkboxSelector + '.selected_checkouts_checkbox:checked').length > 1;
          processOrder($(this).data('action'), checkboxSelector);
          if(isMassAction){
            $('form#new_line_item').attr('action', $(this).data('mass-url'));
          }
          else{
            $('form#new_line_item').attr('action', orderFormLink);
          }
        }
        else if($(this).attr('id') == 'request-checkin-stock'){
          $('form#new_line_item').attr('action', $(this).data('mass-url'));
          processOrder($(this).data('action'), checkboxSelector);
        }
        else if($(this).attr('id') == 'deny-checkin-request'){
          var action = $(this).data('action');
          $('form#new_line_item').attr('action', $(this).data('mass-url'));
          if($(checkboxSelector + ".selected_checkouts_checkbox:checked").filter("[data-checkin-requested-from-basket~='1']").length == 0 || 
            confirm("Denying check-in request for selected asset stock will also deny check-in request of the cart(s). Do you want to proceed?")){
            
            processOrder(action, checkboxSelector);
          }
        }
        else if($(this).data('action') == 'Extend Checkout'){
          $('#extend_checkout_items_dialog').modal({ backdrop: 'static' });
        }
      }
      else{
        alert('Please select an item to proceed');
      }
    });

    $('body').on('click', "#retire-from-delete", function(e){
      e.preventDefault();
      $('#modelDialog').modal('hide');
      $('#salvage-value-dialog-form').modal('show');
    });

    $('body').on('click', "#retire-from-mass-delete", function(e){
      e.preventDefault();
      $('#modelDialog').modal('hide');
      $('#dialog-form-retire').modal('show');
    });

    $("#btn-retire").click(function(e){
      e.preventDefault();
      $('#salvage-value-dialog-form').modal('show');
    });

    function toggleOrderFormFields(type, checkboxSelector){
      var fields_to_show;
      var fields_to_hide;
      if(type == 'Check-in'){
        showHideSignaturePad(signature_pad_options.show_on_checkin);
        fields_to_show = ['#orderHeadingCheckin', '#checkin_stock_custom_attributes', '#checkin-signature-text'];
        fields_to_hide = [
          '#order_by', '#orderHeddingSale', '#orderHeddingStock',
          '.new_sale_fields', '.sale_user_label', '#location_fields',
          '#order_total_quantity_label_span', '#add_stock_custom_attributes',
          '#checkout_stock_custom_attributes', '#remove_stock_custom_attributes',
          '#line_item_price_fields', '.visible_for_new_sale_only',
          '#add-stock-signature-text', '#remove-stock-signature-text', '#checkout-signature-text'
        ];
        $('#process_order').html("Check-in");
        $('#order_type').val('checkin');
        if($(checkboxSelector + '.selected_checkouts_checkbox:checked').length == 1){
          var total_checked_out_quantity = $(checkboxSelector + '.selected_checkouts_checkbox:checked').data('checked_out_quantity');
          var checkout_location_id       = $(checkboxSelector + '.selected_checkouts_checkbox:checked').data('checkout_location_id');
          fields_to_show.push('#quantity_fields');
          fields_to_show.push('#to-location.transfer-stock-location-fields');
          $('#txt_order_quantity, #total_checked_out_quantity').val(total_checked_out_quantity);
          $('#to_location').val(checkout_location_id);
          $('#to_location').change();
        }
        else{
          fields_to_hide.push('#quantity_fields');
          fields_to_hide.push('#to-location.transfer-stock-location-fields');
        }
      }
      else if(type == 'Add Stock'){
        showHideSignaturePad(signature_pad_options.show_on_add_stock);
        fields_to_show = [
          '#orderHeddingStock', '.purchase_user_label', '#order_by',
          '#location_fields', '#order_total_quantity_label_span',
          '#quantity_fields', '#add_stock_custom_attributes',
          '#line_item_price_fields', '.visible_for_new_purchase_only', '#add-stock-signature-text', '#vendor_field'
        ];
        fields_to_hide = [
          '#orderHeddingSale', '#orderHeadingCheckin',
          '.new_sale_fields', '.sale_user_label', '.visible_for_new_sale_only',
          '#remove_stock_custom_attributes', '#checkout_stock_custom_attributes',
          '#checkin_stock_custom_attributes', '#remove-stock-signature-text', 
          '#checkout-signature-text', '#checkin-signature-text', '.checkout-add-member-link', '#to-location.transfer-stock-location-fields'
        ];
        $('#process_order').html("Process Order");
        $('#order_type').val('Add Stock');
        $("#txt_suggested_price").val($('#stock_price').val());
      }
      else if(type == 'New Sale'){
        fields_to_show = [
          '#orderHeddingSale', '.sale_user_label', '.visible_for_new_sale_only',
          '#order_by', '#location_fields', '#order_total_quantity_label_span',
          '#quantity_fields', '#line_item_price_fields', '.checkout-add-member-link'
        ];
        fields_to_hide = [
          '#orderHeddingStock', '#orderHeadingCheckin', '.visible_for_new_purchase_only',
          '.purchase_user_label', '#add_stock_custom_attributes', '#checkin_stock_custom_attributes',
          '#add-stock-signature-text', '#checkin-signature-text', '#vendor_field', '.transfer-stock-location-fields'
        ];
        if($('#order_type_for_sale').val() == 'checkout'){
          showHideSignaturePad(signature_pad_options.show_on_checkout);
          fields_to_show.push('#checkout-signature-text');
          fields_to_hide.push('#remove-stock-signature-text');
          fields_to_show.push('#checkout_stock_custom_attributes');
          fields_to_show.push('.new_sale_fields');
          fields_to_hide.push('#remove_stock_custom_attributes');
          fields_to_hide.push('#line_item_price_fields');
        }
        else{
          showHideSignaturePad(signature_pad_options.show_on_remove_stock);
          fields_to_show.push('#remove-stock-signature-text');
          fields_to_hide.push('#checkout-signature-text');
          fields_to_show.push('#remove_stock_custom_attributes');
          fields_to_hide.push('#checkout_stock_custom_attributes');
          fields_to_hide.push('.new_sale_fields');
          $("#txt_suggested_price").val($('#sale_price').val());
        }
        $('#process_order').html("Process Order");
        $('#order_type').val($('#order_type_for_sale').val());
      }

      $.each(fields_to_show, function(index, value){
        $(value).show();
      });

      $.each(fields_to_hide, function(index, value){
        $(value).hide();
      });
    }

    function showHideSignaturePad(signature_pad_visible){
      if(signature_pad_visible){
        $('#signature_pad_wraper').show();
      } else {
        $('#signature_pad_wraper').hide();
      }
    }

   function toggleCheckoutTill(checkout_box){
     // $(checkout_box).attr('checked', !$(checkout_box).is(':checked'));
     if($(checkout_box).is(':checked')){
      $('.hasDatepick').datepick('disable');
     }else{
      $('.hasDatepick').datepick('enable');
     }
   }

   $('#datepicker .datepick .datepick-month-row .datepick-month a').click(function() {
     $('#checkout_forever').attr('checked',false);
  });

    $('#checkout_forever_wrapper, #checkout_forever').click(function() {
      toggleCheckoutTill($("#checkout_forever"));
    });

    $('#extend_checkout_forever_wrapper, #extend_checkout_forever').click(function() {
      toggleCheckoutTill($("#extend_checkout_forever"));
    });

     $('#action').change(function(){
      performAction($('#action option:selected').val());
     });

  /*moved to application.js and generlized for all submenu
    $('#assets-submenu .submenu li').click( function() {
      $('.sub_container').children('div').hide();
      $('#assets-submenu .active').removeClass('active');
      $(this).addClass('active');
      $('#'+this.id+'-contents').show();
      return false;
    });*/

    $('body').on('change', '#inventory_assets_filter', function(){
      filterAction = "inventory";
      filterForm   = '#inventory_filter_frm';
      var frm_action = $('#inventory_filter_frm').attr('action');
      if($(this).val()=='location'){
        showCompanyLocationDialog();
        return;
      }
      else if ($(this).val() == 'group') {
        showGroupsDialog();
        return;
      }
      else if ($(this).val()=='quantity_range'){
        $('#quantity-range-dialog').modal({backdrop:'static'});
        return;
      }
      else if($(this).val()=='items_in_order'){
        showItemsInOrderDialog();
        return;
      }
      else if($(this).val()=='reserved'){
        showReservedItemsDialog();
        return;
      }
      else if ($(this).val()=='retired'){
        showRetireReasonDialog();
        return;
      }
      else if ($(this).val() == 'update_time'){
        showUpdateTimeDialog();
      }
      else if($(this).val() == '') {
        frm_action = frm_action.replace('/filter', '');
        if($('#inventory_filter_frm input[name=classification]').length > 0) {
          frm_action += '/classification_view';
        }else if($('#inventory_filter_frm input[name=vendors]').length > 0) {
          frm_action += '/vendors';
        }
        window.location = frm_action;
      } else if ($(this).val()!='filter'){
        frm_action = frm_action + '#'+$('#page_type').val()+'-inventory';
        $('#inventory_filter_frm').attr('action',frm_action);

        applyFilter($('#inventory_assets_filter').val(), $('#inventory_assets_filter').val());
      } 
    });

    $('body').on('change', '#stock_assets_filter', function(){
      filterAction = "stock_asset";
      filterForm   = '#stock_filter_frm';
      var frm_action = $(filterForm).attr('action');
      if($(this).val()=='location'){
        showCompanyLocationDialog();
        return;
      }
      else if ($(this).val() == 'group') {
        showGroupsDialog();
        return;
      }
      else if($(this).val()=='items_in_order'){
        showItemsInOrderDialog();
        return;
      }
      else if($(this).val()=='stock_asset_possessions_of'){
        $('#asset-stock-in-custody-of-dialog').modal({backdrop:'static'});
        return;
      }
      else if ($(this).val()=='quantity_range'){
        $('#quantity-range-dialog').modal({backdrop:'static'});
        return;
      }
      else if($(this).val()=='reserved'){
        showReservedItemsDialog();
        return;
      }else if ($(this).val() == 'update_time'){
        showUpdateTimeDialog();
      }
      else if ($(this).val()=='retired'){
        showRetireReasonDialog();
        return;
      }
      else if($(this).val() == '') {
        frm_action = frm_action.replace('/filter', '');
        if($(filterForm + ' input[name=classification]').length > 0) {
          frm_action += '/classification_view';
        }else if($(filterForm + ' input[name=vendors]').length > 0) {
          frm_action += '/vendors';
        }
        window.location = frm_action;
      } else if ($(this).val()!='filter'){
        frm_action = frm_action + '#'+$('#page_type').val()+'-stock';
        $(filterForm).attr('action',frm_action);
        applyFilter($('#stock_assets_filter').val(), $('#stock_assets_filter').val());
      }
    });

    $("#asset-stock-in-custody-of-user, #user_id_stock_in_custody_of").change(function(){
      applyFilter('stock_asset_possessions_of', $(this).val());
    });

    $("#current_checkout_filter").change(function(){
      if($("#current_checkout_filter").val() != ''){
        if($("#current_checkout_filter").val() == 'quantity_in_custody_of'){
          $('#current-checkout-custody-of-dialog').modal({backdrop:'static'});
        }else{
          $("#current_checkout_filter_frm").submit();
        }
      }
    });

    $('body').on('change', '#assets_filter, #aggr_func', function(){
      filterAction = "fixed";
      filterForm   = '#asset_filter_frm';

      $(this).attr('id') == 'aggr_func' || $(this).val() == 'group_by_package' ? $('#aggr_func').show() : $('#aggr_func').hide();

      if($(this).val()=='location'){
        showCompanyLocationDialog();
        return;
      }
      else if ($(this).val() == 'group') {
        showGroupsDialog();
        return;
      }
      else if ($(this).val()=='possessions_of'){
        showAssetInCustodyOfDialog();
        return;
      }
      else if ($(this).val()=='retired'){
        showRetireReasonDialog();
        return;
      }else if($(this).val()=='availability_range'){
        showAvailabilityRangeDialog();
        return;
      }
      else if($(this).val()=='items_in_order'){
        showItemsInOrderDialog();
        return;
      }
      else if($(this).val()=='reserved'){
        showReservedItemsDialog();
        return;
      }
      else if ($(this).val() == 'update_time'){
        showUpdateTimeDialog();
      }
      else if($(this).val() == '') {
        var frm_action = $('#asset_filter_frm').attr('action');
        frm_action = frm_action.replace('/filter', '');
        if($('#asset_filter_frm input[name=classification]').length > 0) {
          frm_action += '/classification_view';
        }else if($('#asset_filter_frm input[name=vendors]').length > 0) {
          frm_action += '/vendors';
        }
        window.location = frm_action;
      } else if ($(this).val()!='filter'){
        applyFilter($('#assets_filter').val(), $('#assets_filter').val());
      }
    });

    $('#show-subgroup-dialog').click(function(e){
      e.preventDefault();
      $('#dialog-create-subgroup').modal('show');
    });

    $('#show-subgroup-dialog-asset-form').click(function(e){
      e.preventDefault();
      $('#create-sub-group').removeAttr("disabled");
      var selectedGroupId   = $('#asset_group_id option:selected').val();
      var selectedSubGroupId = $('#sub_group_drop_down option:selected').val(); 
      if(selectedGroupId != ''){
        var formUrl = '/groups/' + selectedGroupId + '/sub_groups';
        var form    = $('#add_sub_group_form');
        form.attr('action', formUrl);
        form.data('remote', true);
        $('#dialog-create-subgroup').modal('show');
        $('#sub_group_parent_id').val(selectedSubGroupId);
      }
      else{
        alert('Select Group to Add Subgroup');
      }
    });

    $('#add_sub_group_form').submit(function(){
      disableBtn('#create-sub-group');
    });

    $('#show-subgroup-delete-dialog').click(function(e){
      e.preventDefault();
      $('#subgroup-delete-dialog').modal('show');
    });

    $('#extend_till, #check_in_by').datepicker( { autoclose: true, startDate: getGlobalData('serverDate') } );
    //purchase date comparision
    $('.submit_asset').click(function(e){
      if($(".asset_retired_on").val() == ""){
        jui_alert("Retired on date cannot be empty, please select a date");
        return false;
      }
      else if(!checkNumberLength($('.numberField'))){
        return false;
      }

    //Html5 validation not triggered due to these lines
    //   today = new Date();
    //   if ((new Date($(".asset_purchased_on").val()) > today) && (new Date($(".asset_retired_on").val()) > today)){
    //     displayAlert(e, "Are you sure you want to set the purchase date and retired on date in the future?");
    //   }else if (new Date($(".asset_purchased_on").val()) > today){
    //     displayAlert(e, "Are you sure you want to set the purchase date in the future?");
    //   }else if (new Date($(".asset_retired_on").val()) > today){
    //     displayAlert(e, "Are you sure you want to set the retired on date in the future?");
    //   }
    });
  });

  function applyFilter(filterName, params, optional_html_dom){

    if(filterAction == "inventory"){
      filterStatus = '#inventory_assets_filter';
    }
    else if(filterAction == 'stock_asset'){
      filterStatus = '#stock_assets_filter';
    }
    else{
      filterStatus = '#assets_filter';
    }

    if(filterName == 'product_model_number' || filterName == 'group_by_package') {
      jui_confirm('The group filter will remove all existing filters', function(){
        $(filterForm + ' .applied_filters').remove();
      });
    } else if (filterName != null) {
      if (filterName == 'location') {
        $(filterForm).append("<input type='hidden' name='filters[" + filterName + "][value]' value='" + params + "'/>");
        $(filterForm).append("<input type='hidden' name='filters[" + filterName + "][include_contained_assets]' value='" + $('#include_contained_assets').is(':checked') + "'/>");
        $(filterForm).append("<input type='hidden' name='filters[" + filterName + "][exclude_zero_quantity]' value='" + $('#exclude_zero_quantity').is(':checked') + "'/>");
      } else if (filterName == 'availability_range') {
        $(filterForm).append("<input type='hidden' name='filters[" + filterName + "][value]' value='" + params + "'/>");
        $(filterForm).append("<input type='hidden' name='filters[" + filterName + "][include_overdue_assets]' value='" + $('#include_overdue_assets').is(':checked') + "'/>");
      } else if (filterName == 'reserved') {
        $(filterForm).append("<input type='hidden' name='filters[" + filterName + "][value]' value='" + params + "'/>");
        $(filterForm).append("<input type='hidden' name='filters[" + filterName + "][include_all_reserved_assets]' value='" + $('#include_all_reserved_assets').is(':checked') + "'/>");
      } else {
        $(filterForm).append("<input type='hidden' name='filters[" + filterName + "][value]' value='" + params + "'/>");
      }
      $(filterStatus).remove();
    }
    $(filterForm).submit();
  }

// function filterInventory(filterName,params,optional_html_dom){
//     if(typeof(optional_html_dom) != 'undefined'){
//        optional_html_dom.clone().hide().appendTo('#asset_filter_frm');
//     }
//     $('#filter_param_val').val(params);
//     $('#inventory_filter_frm').submit();
//   }

function displayAlert(e, message){
  e.preventDefault();
  jui_confirm(message, function(){
    $("#create_asset_form").submit();
  });
}

function checkNumberLength(element){
  flag = true;
  message = "";
  element.each(function(){
    var value = $(this).val();
    if(value.indexOf('.') > -1){
      value_after_decimal = value.substr(value.indexOf('.') + 1, value.length);
      value = value.substr(0, value.indexOf('.'));
      if(value_after_decimal.length > 9){
        message += "Maximum 9 digits are allowed after the decimal point for " + $(this).parent().find('label').text() + "<br />";
        flag = false;
      }
    }
    if(value.length > 45){
      message += "Value is too large for " + $(this).parent().find('label').text() + "<br />";
      flag = false;
    }
  });
  if(!flag){
    jui_alert(message);
  }
  return flag;
}

$(function(){
  $("#filter_asset_location_name").click(function(e){
    e.preventDefault();
    showCompanyLocationDialog();
  });
});

$(function(){
  $("#asset_group_id, #volatile_asset_group_id, #stock_asset_group_id").change(function(){
    var selected_option = $(this).children(":selected");
    var val = selected_option.attr('value');
    if(typeof val == 'undefined' || val == ''){
      return;
    }
    groupHasDifferentCustomAttributes(val, $(this));
  });
});
var previous_group_value = "";
$(function(){
  $("#asset_group_id, #volatile_asset_group_id, #stock_asset_group_id").focus(function(){
    var selected_option = $(this).children(":selected");
    previous_group_value = selected_option.attr('value');
  });
});

function groupHasDifferentCustomAttributes(val, ctrl){
  data = "&asset=" + $("#asset_id").attr('value') + "&group=" + val;
  $.ajax({
    type: "GET",
    url: '/assets/group_has_different_custom_attributes',
    data: data,
    dataType: "json",
    success:function(data){
      if(data.group_has_different_custom_attributes == true){
        if(confirm("Custom Fields data of the older group may be lost for this item")){
          changeGroup(val);
        }else{
          $(ctrl).children("[value='" + previous_group_value + "']").prop("selected", true);
        }
      }else{
        changeGroup(val);
      }
    }
  });
}

function changeGroup(val){
  data = "group=" + val;
  if ($('#new-asset-via-clone').length){
    data = data + "&clone=true"
  }
  data = data + "&asset=" + $("#asset_id").attr('value') + "&type=" + $("#asset_type").attr('value');
  $.ajax({
    type: "GET",
    url: '/assets/change_group',
    data: data,
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      alert(XMLHttpRequest.responseText);
    }
  });
}

function initLocationSearchInput(){
  $('.location_search_input').tokenInput('/locations/search.json', {
    tokenLimit: 1,
    theme: 'facebook',
    hintText: "Type in a location name, or '#' for location#, or '@' for Location Identification Number",
    queryParam: 'term'    
  });
}

$(function(){
  $("#mass_edit_change_group").change(function(){
    var selected_option = $(this).children(":selected");
    var val = selected_option.attr('value');
    if(typeof val == 'undefined' || val == ''){
      return;
    }
    data = "group=" + val;
    $.ajax({
      type: "GET",
      url: '/assets/get_sub_groups',
      data: data
    });
  });
});




$(function(){
  $("#txt_total_quantity").on('change focus', function(){
    if($("#order_type").val() == "Add Stock"){
      if(parseInt($("#txt_total_quantity").val()) < parseInt($("#hidden_total_quantity").val())){
        alert("Total quantity should be greater than " + $("#hidden_total_quantity").val());
        $("#txt_total_quantity").val($("#hidden_total_quantity").val());
        $("#order_total_quantity_label_number").html($("#hidden_total_quantity").val());
      }
    }else{
      if(parseInt($("#txt_total_quantity").val()) > parseInt($("#hidden_total_quantity").val())){
        alert("Total quantity should be less than " + $("#hidden_total_quantity").val());
        $("#txt_total_quantity").val($("#hidden_total_quantity").val());
        $("#order_total_quantity_label_number").html($("#hidden_total_quantity").val());
      }
    }
    if($("#order_type").val() == "Add Stock"){
      $("#txt_order_quantity").prop('value', ($("#txt_total_quantity").prop('value') - $("#hidden_total_quantity").prop('value')));
    }else{
      $("#txt_order_quantity").prop('value', ($("#hidden_total_quantity").prop('value') - $("#txt_total_quantity").prop('value')));
    }

  });
});

$(function(){
  $("#txt_order_quantity").on('keyup change focus', function(){
    $("#txt_order_price").prop('value', ($("#txt_order_quantity").prop('value') * $("#txt_suggested_price").prop('value')).toFixed(2));
    if($("#order_type").val() == "Add Stock"){
      var value = parseInt($("#txt_order_quantity").val()) + parseInt($("#hidden_total_quantity").val());
      $("#txt_total_quantity").val(value);
      $("#order_total_quantity_label_number").html(value);
    }else{
      var value = parseInt($("#hidden_total_quantity").val()) - parseInt($("#txt_order_quantity").val());
      $("#txt_total_quantity").val(value);
      $("#order_total_quantity_label_number").html(value);
    }
  });
});

$(function(){
  $("#txt_suggested_price").on('keyup change focus', function(){
    $("#txt_order_price").prop('value', ($("#txt_order_quantity").prop('value') * $("#txt_suggested_price").prop('value')).toFixed(2));
  });
});

$(function(){
  $("#txt_order_price").on('keyup change focus', function(){
    if($("#txt_order_quantity").prop('value') >= 1){
      $("#txt_suggested_price").prop('value', ($("#txt_order_price").prop('value') / $("#txt_order_quantity").prop('value')));
    }
  });
});

$(function(){
  $("#line_item_retire_suggested_price, #line_item_retire_quantity").on('keyup change focus', function(){
    $("#line_item_retire_order_price").prop('value', ($("#line_item_retire_quantity").prop('value') * $("#line_item_retire_suggested_price").prop('value')).toFixed(2));
  });
});

$(function(){
  $("#line_item_retire_order_price").on('keyup change focus', function(){
    if($("#line_item_retire_quantity").prop('value') >= 1){
      $("#line_item_retire_suggested_price").prop('value', ($("#line_item_retire_order_price").prop('value') / $("#line_item_retire_quantity").prop('value')));
    }
  });
});

$(function(){
  $('body').on('keyup change focus', ".requested_quantity, .stock_request_unit_price", function(){
    $('#stock_request_total_price_' + $(this).parent().attr('id')).val(($('#requested_quantity_'+ $(this).parent().attr('id')).val() * $('#stock_request_unit_price_' + $(this).parent().attr('id')).val()).toFixed(2));
  });
});

$(function(){
  $('body').on('keyup change focus', '.stock_request_total_price', function(){
   $('#stock_request_unit_price_'+ $(this).parent().attr('id')).val(($('#stock_request_total_price_'+ $(this).parent().attr('id')).val() / $('#requested_quantity_'+ $(this).parent().attr('id')).val()).toFixed(2));
  });
});


$(function(){

  $('body').on('change', '#company_location_select_on_reservtaion', function(){
    var totalQuantity = 0;
    $("#location_by_quantity_options").val($("#company_location_select_on_reservtaion").val());
    if($("#location_by_quantity_options option:selected").text().trim() != ""){
      totalQuantity = $("#location_by_quantity_options option:selected").text().trim()
    }
    $("#txt_total_quantity_reserve").html(totalQuantity);
    if(totalQuantity < parseInt($('#quantity').val())){
      $('#quantity_warning').show();
    }
    else{
      $('#quantity_warning').hide();
    }
  });

  $('body').on('change', '#company_location_select', function(){
    var totalQuantity = 0;
    $("#location_by_quantity_options").val($("#company_location_select").val());
    if($("#location_by_quantity_options option:selected").text().trim() != ""){
      totalQuantity = $("#location_by_quantity_options option:selected").text().trim()
    }
    $("#hidden_total_quantity").val(totalQuantity);
    if($("#order_type").val() == "Add Stock"){
      totalQuantity = parseInt(totalQuantity) + parseInt($("#txt_order_quantity").val())
    }else{
      totalQuantity = parseInt(totalQuantity) - parseInt($("#txt_order_quantity").val())
    }
    $("#txt_total_quantity").val(totalQuantity);
    $("#order_total_quantity_label_number").html(totalQuantity);
  });

  $('#line_item_retire_location_id').on('change', function(){
    $("#location_by_quantity_options").val($("#line_item_retire_location_id").val());
    $('#line_item_retire_quantity').attr('max', $("#location_by_quantity_options option:selected").text().trim());
  });

  initLocationSearchInput();

  $('body').on('change', '#quantity', function(){
    if (parseInt($(this).val()) > parseInt($('#txt_total_quantity_reserve').html())){
      $('#quantity_warning').show();
    }
    else{
      $('#quantity_warning').hide();
    }
  });

});

$(function(){
  $('.modal-close-btn').click(function(e){
    e.preventDefault();
    $('#new_line_item').each(function(){
      this.reset();
    });
  });

  $('body').on('click', '.remove_asset_field', function(e){
    e.preventDefault();

    $("#asset_field_select option[value='" + $(this).attr('href') + "']").prop('disabled', false);
    $("#asset_field_select option[value='" + $(this).attr('href') + "']").css('background-color', '');
    $(this).parent().parent().remove();
    reset_fields_count();
  });

  $("#asset_field_select").change(function(){
    var val = $(this).val();

    data = "field=" + val;
    $.ajax({
      type: "GET",
      url: '/assets/render_field',
      data: data
    });
  });

  var reset_fields_count = function(){
    $('#fields_count').text($('.asset_field').length);
  }

  $("#change_group ").click(function(e){
    e.preventDefault();
    $('#mass_change_group_dialog').modal({backdrop:'static'});
  });
});

function sendRequestForCustomAttributes(data)
{
  $.ajax({
    type: "GET",
    url: '/assets/get_custom_attributes_for_mass_actions',
    data: data
  });
}

$(function(){
  $('body').on('click', "div.asset-thumb div.asset-details, div.asset-thumb span.thumb-checkbox", function(e){
    if(typeof isCustomer != 'undefined' && isCustomer) return;
    $( e.target ).parent( ".asset-thumb" ).toggleClass( "asset-thumb-selected" );
    $( e.target ).closest( "span.thumb-checkbox" ).toggleClass( "thumb-checkbox-selected" );
    var checkbox = $( e.target ).parent( ".asset-thumb" ).find('.thumb-checkbox').find("i");
    var itemId = '';
    if(e.target.id == ''){
      itemId = $( this ).parent().find('.asset-details').attr('id');
    }else{
      itemId = e.target.id;
    }
    if(checkbox.length){
      $('#seqs_' + itemId).prop('checked', false);
      $( e.target ).parent( ".asset-thumb" ).find('.thumb-checkbox').children().remove();
    } else{
      $('#seqs_' + itemId).prop('checked', true);
      $( e.target ).parent( ".asset-thumb" ).find('.thumb-checkbox').html('<i class="icon-ok icon-blue"></i>');
    }
  });

  $('body').on('click', '#set_default', function(){
    var message = "This listing will be the default for all Users";
    if(is_rentals) message += " and Customers";
    if($(this).is(':checked')) alert(message);
  });
});

$(function() {
  $('body').on('click', "div.asset-thumb span.thumb-checkbox i.icon-ok.icon-blue", function(e) {
    if(typeof isCustomer != 'undefined' && isCustomer) return;
    $(e.target).remove();
  });
});


function showReservedItemsDialog(){
  $('#dialog-form-reserved').modal({backdrop:'static'});  
}

function showUpdateTimeDialog(){
  $('#update-time-dialog').modal({ backdrop: 'static' });
}

function showGroupsDialog() {
  $('#groups-assets-dialog').modal({ backdrop:'static' });
}

$(function () {
  $("#filter_group_id").on('change', function() {
    var subGroupDom = $('#subgroup_name_for_filter');
    $.get('/assets/get_sub_groups.json', { group: $(this).val() }, function(data) {
      var subGroupOptions = '';
      $.each(data.sub_groups, function(idx, subGroupData) {
        subGroupOptions += '<option value="' + subGroupData.id + '">' + subGroupData.name + '</option>';
      });

      if (subGroupOptions === '') {
        subGroupDom.addClass('hide');
        $("#groups-assets-dialog").modal('hide');
        applyGroupFilter($("#filter_group_id").val(), '');
      }
      else {
        subGroupOptions = "<option selected value=''>Select Sub-Group</option>" + "<option value='all'>All Sub-Groups</option>" + subGroupOptions;
        subGroupDom.removeClass('hide');
        subGroupDom.html(subGroupOptions);
      }
    });
  });

  $("#subgroup_name_for_filter").on('change', function() {
    $("#groups-assets-dialog").modal('hide');
    if ($(this).val() == 'all') {
      applyGroupFilter($("#filter_group_id").val(), '');
    }
    else {
      applyGroupFilter($('#filter_group_id').val(), $(this).val());
    }
  });

});

function applyGroupFilter(groupId, subGroupId) {

  if(filterAction == "inventory") {
    filterForm = 'inventory_filter_frm';
  }
  else if(filterAction == 'stock_asset') {
    filterForm = 'stock_filter_frm';
  }
  else {
    filterForm = 'asset_filter_frm';
  }

  if (groupId != undefined) {
    $('#' + filterForm).append("<input type='hidden' name='filters[group][value]' value='" + groupId + "'/>");
  } 
  if (subGroupId != undefined) {
    $('#' + filterForm).append("<input type='hidden' name='filters[group][sub_group_param_val]' value='" + subGroupId + "'/>");
  }

  $('#' + filterForm).submit();
}

$(function () {

  $("#update-time-dialog #submit_update_time_range").click(function(e){
    var start_date = $("#update_date_start").val();
    if(start_date != ""){ //date and time should be empty string if no date is being selected
      start_date += " " + $("#update_time_start").val();
    }

    var end_date = $("#update_date_end").val()
    if(end_date != ""){
      end_date += " " + $("#update_time_end").val();
    }

    if (start_date && end_date && (new Date(start_date) > new Date(end_date))) {
      alert("'From' date should be less than 'to' date");
      return;
    } else {
      $("#update-time-dialog").modal('hide');
      applyFilter('update_time', start_date + "," + end_date);
    } 
  });

  $("#dialog-form-reserved  #submit_reserved_range").click(function(e){
    start_date  = $("#reserved_range_start").val();
    end_date    = $("#reserved_range_end").val();

    start_date += ' ' + $("#reserved_time_start").val();
    end_date   += ' ' + $("#reserved_time_end").val();
    start_date_test  = new Date(start_date);
    end_date_test    = new Date(end_date);
    if(start_date==" " && end_date==" " && $('#include_all_reserved_assets').prop("checked")==false){
      alert("Please enter valid date range");
      return;
    }

    if(start_date_test > end_date_test){
      alert("'From' date should be less than 'to' date");
      e.preventDefault();
      return;
    }

    $("#dialog-form-reserved").modal('hide');
      params = start_date+','+end_date;
      applyFilter('reserved', params, $('#include_all_reserved_assets'));
    });

    $('#reserved_range_start, #reserved_range_end').change(function(){
      $('#include_all_reserved_assets').prop('checked', false);
    })
})