$(document).ready(function() {
  $('#billings_btn').click(function() {
    $.cookie('selected_tab', "billing-settings-link", { path: '/' });
    localStorage.setItem('activeCompanySettingsTab', 'billing-nav-item');
  });

  $('.unlimited-choose-btn').on('click', function(){
    var assetsCount = parseInt($('#unlimited-package-selected-quantity').val());
    $(this).attr('href', $(this).data('url') + "&assets_count=" + assetsCount);
  });

  $('.a-la-carte-choose-btn').on('click', function(){
    if(
      $(this).data("payment-cycle") &&
      ($(this).data("payment-cycle") === "annual" && $(this).data("price-to-charge") < parseFloat($("#a-la-carte-package-attributes").data("minimum-annual-price"))) ||
      ($(this).data("payment-cycle") === "monthly" && $(this).data("price-to-charge") < parseFloat($("#a-la-carte-package-attributes").data("minimum-monthly-price")))
    ){
      var minPriceAttribute = $(this).data('payment-cycle') === 'annual' ? 'minimum-annual-price' : 'minimum-monthly-price';
      var minPrice          = parseFloat($('#a-la-carte-package-attributes').data(minPriceAttribute));
      alert('The price cannot be less than $' + minPrice + '. Change number of items, users or the add-ons to go above $' + minPrice + '.');
      return false;
    }
    var assetsCount = parseInt($("#a-la-carte-package-selected-quantity").val());
    var usersCount  = parseInt($("#a-la-carte-package-selected-user-quantity").val());
    var addOnsLevel = $('.add-ons-level:checked').val();
    $(this).attr("href", $(this).data("url") + "&assets_count=" + assetsCount + "&users_count=" + usersCount + "&add_on_package=" + addOnsLevel);
  });

  $('body').on('change', '#company_addresses_country', function (){
    var select_wrapper = $('#order_state_code_wrapper');
    $('select', select_wrapper).attr('disabled', true);
    var country_code = $(this).val();
    var controller   = "companies";
    var url = "/" + controller + "/subregion_options?parent_region=" + country_code;
    select_wrapper.load(url);
  });
});