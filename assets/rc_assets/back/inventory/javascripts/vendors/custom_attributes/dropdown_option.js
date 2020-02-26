function addOptionToDropdownField(association, content) {
  if ($('.custom_attribute_options_content .custom_dropdown_option:visible').length < parseInt(getGlobalData('customAttributeOptionLimit'))){
    var newId = new Date().getTime();
    var regexp = new RegExp("new_" + association, "g");
    $('.custom_attribute_options_content').append(content.replace(regexp, newId));
    $('.dropdown-ca-default-select').append("<option></option>");
  }
  else{
    alert("Options for the custom fields are limited to " + getGlobalData('customAttributeOptionLimit') + ". Please contact " + getGlobalData('supportEmail') + " for further queries.");
    return false;
  }
}

function removeOptionFromDropdownField(link){
  var element = $(link).closest(".custom_attribute_options_content");
  var option  = $(link).closest(".custom_dropdown_option");
  var optionIndex = $(".custom-attribute-dropdown-option:visible").get().indexOf($(option).children(".custom-attribute-dropdown-option").get(0));
  if (element.find(".custom_dropdown_option:visible").length == 1){
    alert("You have to have atleast one option");
    return false;
  }
  $(link).prev("input[type=hidden]").val(1);
  if(optionIndex > 0){
    $(".dropdown-ca-default-select option")[optionIndex + 1].remove();
  }
  option.fadeOut(300, function() {
    option.remove();
  });
}

function sortCaOptionsInit(){
  $('.sort-custom-attribute-options').sortable({
    revert: true,
    axis: 'y',
    handle:'.multihandle',
    update: function(){
      $.post($(this).data('update-url'), $(this).sortable('serialize'));
      if($(".dropdown-ca-default-select").length > 0){
        var selectTagOptions = [$(".dropdown-ca-default-select option:first").clone()];
        $(".custom-attribute-dropdown-option:visible:input").each(function(index){
          selectTagOptions.push(($(".dropdown-ca-default-select option[value='" + $(this).val() + "']:first").clone())); 
        });
        $(".dropdown-ca-default-select option").remove();
        $.each(selectTagOptions, function(){
          $(".dropdown-ca-default-select").append($(this));
        });
      }
    }
  });
}