$(document).ready(function(){
  $('body').on('change', 'select#user_country', function() {
    var select_wrapper = $('#order_state_code_wrapper');
    $('select', select_wrapper).attr('disabled', true);
    var country_code = $(this).val();
    var controller   = $('#user_state').data("controller");
    var overlay_param = '';
    if ($('#is_overlay').text() == 'true') {
      overlay_param = '&is_overlay=true'; 
    }
    var url = "/" + controller + "/subregion_options?parent_region=" + country_code + overlay_param;
    select_wrapper.load(url);
  });

  $('body').on('change', 'select#customer_country', function() {
    var select_wrapper = $('#order_state_code_wrapper');
    $('select', select_wrapper).attr('disabled', true);
    var country_code = $('select#customer_country').val();
    var url = "/customers/subregion_options?parent_region="+country_code;
    select_wrapper.load(url);
  });
});