$.fn.inline_editable = function() {

  var CLICK_TO_EDIT_HTML = "--"

  return this.each(function () {
    var $this = $(this);
    var owner_id = $(this).data('owner-id');
    var attr_name = $(this).data('attr-name');
    var controller = $(this).data('controller');

    if ($("div.value", $this).text().trim()=='') {
      $("div.value", $this).html(CLICK_TO_EDIT_HTML);
    }

    $("div.value", $this).click(function() {
      $("div.value", $this).hide();
      $("div.field", $this).show();
      if(!$("div.field", $this).data("radio-field")){
        $("div.field input, textarea, select", $this).focus();
      }
    });

    $("div.field input, textarea, select", $this).focusout(function() {
      if ($(this.parentElement).is(':not(:visible)')){
        return;
      }
      if (! this.validity.valid) {
        var attrName = $(this).closest("div.custom-attributes.editable-inline").find("div.custom-attributes.title").text().trim()
        alert("Invalid value for \'"+ attrName + "\'.");
        if(!$("div.field", $this).data("radio-field")){
          $("div.field input, select", $this).val($("div.value", $this).text().trim());
        }
        $("div.field", $this).hide();
        $("div.value", $this).show();
        return;
      }

      var url = '/' + controller  + '.json';
      var value = this.value;
      $.ajax({
           type:'POST'
           ,url: url
           ,data: $.param({ owner_id: owner_id, name: attr_name, value: value })
           , success: function(data) {
              if (data.value) {
                if(data.custom_attribute_defn.attr_type == "dropdown"){
                  var value = data.selected_option;
                }else{
                  var value = data.value;
                }
                var strValue = '' + data.value;
                if(!$("div.field", $this).data("radio-field")){
                  $("div.field input, textarea, select", $this).val(value);
                }
                $("div.value", $this).html(strValue.replace(/\n/g, '<br/>'));
              } else {
                $("div.value", $this).html(CLICK_TO_EDIT_HTML);
              }

              $("div.field", $this).hide();
              $("div.value", $this).show();
           }
      });
    });

  });
};

$("div.custom-attributes.editable-inline").inline_editable();