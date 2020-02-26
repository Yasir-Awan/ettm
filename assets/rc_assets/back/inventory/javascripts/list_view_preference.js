$(function(){
  $('body').on('click', '#add-column', function(e){
    e.preventDefault();
    var totalColumns    = $('#list_view_preferences_form').find('.column-dropdown').length;
    totalColumns += 1;
    if (totalColumns >= 10) {
      $('#add_column').hide();
    }
    var dropdownOptions = $('.controls').children('select:last').children().clone();
    
    dropdownOptions = dropdownOptions.each(function(){
      $(this).children().each(function() {
          if(this.selected) {
          this.removeAttribute("selected");
          this.setAttribute("disabled", "disabled");
        }
      });
    });

    var newColumnHtml = "<div class='column-dropdown margin-bottom-15'>";
    newColumnHtml    += "<a href='#' class='delete-col pull-right'><i class='icon-trash'></i></a>";
    newColumnHtml    += "<label class='control-label label-width list-view-column-heading'>Column # " + totalColumns + ":</label>";
    newColumnHtml    += "<div class='controls margin-left-120' id='column-dropdown-div-" + totalColumns + "'>";
    newColumnHtml    += "<select name='selected_column_names[]' class='dropdown_options' data-column-index=" + totalColumns + ">";
    if($('.controls').children('select:last').find("option:contains('--Select option name--')").length == 0){
      newColumnHtml  += "<option value=''>--Select option name--</option>";
    }
    newColumnHtml    += "</select><span class='margin-left-5' id='character-limit-container-" + totalColumns + "'></span></div></div>";
    $('.column-dropdown:last').after(newColumnHtml);
    $('.column-dropdown:last').find('select').append(dropdownOptions);
    var first_column    = $('.column-dropdown:last').find('select option:first');
    first_column.prop('selected', true);
    var columnOptions   = all_list_columns[first_column.val()];
    var characterLimitFieldClass = $("#change-character-limit").is(":checked") ? "" : "hide";
    if(columnOptions){
      if(!columnOptions['skip_truncation']){
        characterLimitHtml += "<input type='number' name='selected_columns["+ first_column.val() +"][truncate_length]' id='character-limit-field-";
        characterLimitHtml += totalColumns + "' value='" + columnOptions['truncate_length'];
        characterLimitHtml += "' class='truncation-length-field  " + characterLimitFieldClass + "min='1' max='1000'>";
      }else{
        characterLimitHtml += "<input type='hidden' name='selected_columns[" + first_column.val() + "][skip_truncation]' value='true' id='skip-trucation-" + totalColumns +"'>";
      }
      $("#character-limit-container-" + totalColumns).html($("#character-limit-container-" + totalColumns).html() + characterLimitHtml);
    }
  });

  $('body').on('click', '#change-character-limit', function(){
    $(".truncation-length-field").toggleClass("hide");
  });

  var previousValue;
  $('body').on('focus', '#list_view_preferences_form select', function(){
    previousValue = this.value;  
  }).on('change', '#list_view_preferences_form select', function(){
    var dropDowns = $('#list_view_preferences_form select').not(this);
    if (previousValue == '--Select option name--') {
      dropDowns.find("[value='" + this.value + "']").prop('disabled', true);
    } else {
      $(this).find("[value='" + previousValue + "']").removeAttr('selected');
      $(this).find("[value='" + this.value + "']").attr('selected', 'selected');
      dropDowns.find("[value='" + previousValue + "']").prop('disabled', false);
      dropDowns.find("[value='" + this.value + "']").prop('disabled', true);
    }

    var columnIndex   = $(this).data("column-index");
    var columnOptions = all_list_columns[this.value];
    if(columnOptions){
      var characterLimitHtml = '';
      var characterLimitFieldClass = $("#change-character-limit").is(":checked") ? "" : "hide";
      if(!columnOptions['skip_truncation']){
        if($("#character-limit-field-" + columnIndex).length == 0){
          characterLimitHtml += "<input type='number' name='selected_columns["+ this.value +"][truncate_length]' id='character-limit-field-";
          characterLimitHtml += columnIndex + "' value='" + columnOptions['truncate_length'];
          characterLimitHtml += "' class='truncation-length-field " + characterLimitFieldClass + "' min='1' max='1000'>";
          $("#character-limit-container-" + columnIndex).html($("#character-limit-container-" + columnIndex).html() + characterLimitHtml);
          $("#skip-trucation-" + columnIndex).remove();
        }else{
          $("#character-limit-field-" + columnIndex).val(columnOptions['truncate_length']);
          $("#character-limit-field-" + columnIndex).attr("name", "selected_columns["+ this.value +"][truncate_length]");
        }
      }else{
        $("#character-limit-field-" + columnIndex).remove();
        $("#set-character-limit-" + columnIndex).remove();

        if($("#skip-trucation-" + columnIndex).length == 0){
          characterLimitHtml += "<input type='hidden' name='selected_columns[" + this.value + "][skip_truncation]' value='true' id='skip-trucation-" + columnIndex +"'>";
          $("#character-limit-container-" + columnIndex).html($("#character-limit-container-" + columnIndex).html() + characterLimitHtml);
        }else{
          $("#skip-trucation-" + columnIndex).attr("name", "selected_columns[" + this.value + "][skip_truncation]");
        }
      }
    }
  });

  $('body').on('click', '.delete-col', function(){
    if(confirm("Are you sure you want to remove this column from listing?")){
        var controlGroupDiv   = $(this).parent();
        var deleteDropdown    = controlGroupDiv.find('select')
        var deleteDropdownVal = deleteDropdown.val();
        
        var dropDowns = $('#list_view_preferences_form select').not(deleteDropdown);
        if (deleteDropdownVal) {
          dropDowns.find("[value='" + deleteDropdownVal + "']").prop('disabled', false);
        }
        var index = $(this).closest('.column-dropdown').index();
        $(this).closest('.column-dropdown').nextAll().find('label').each(function(){ 
          $(this).text("Column # " + index + ":");
          index++; 
        });
        $(this).closest('.column-dropdown').remove();
        
        var totalColumns = $('#list_view_preferences_form').find('.column-dropdown').length;
        if(totalColumns < 10 && $('#add_column').is(':hidden')) {
          $('#add_column').show();
        }
        return false;
    } else {
        return false;
    }
  });
});