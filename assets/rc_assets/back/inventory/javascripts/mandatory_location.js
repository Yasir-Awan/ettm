function checkForLocationValue(actionName, locationValue, locationLabel){
  if($('.' + actionName + '_location').data('location-required') && locationValue == ''){
    jui_alert("Please select a "+ locationLabel + " to proceed");
    return false;
  }
  return true;
}