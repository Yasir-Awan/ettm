<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form>
  <div class="col-md-8">
              <input id="address" type="textbox" class="form-control" placeholder = "Get Address through Googgle Map" >
            </div>
            <div class="col-md-4">
             <input type="button" value="Get Address" onclick="codeAddress()" class="btn btn-primary" style="height:49px; margin-left:-30px;">
            </div>
            
             <div class="col-md-12">
                <div id="map_canvas" style="height:300px;top:10px;margin-bottom:30px;"></div>
            </div>
            <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control required" name="address1" id="address1" type="text" placeholder="<?php echo 'address_line_1';?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control required" name="address2" id="address2" type="hidden" placeholder="<?php echo 'address_line_2';?>" readonly>
                            </div>
                        </div>
            <input type="hidden" name="lat" id="lat" class="form-control">
            <input type="hidden" name="lang" id="lang" class="form-control">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control required" type="text" name="city" id="city" placeholder="<?php echo 'city';?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <input class="form-control required" name="zip" id="zip" type="text" placeholder="<?php echo 'zip';?>" readonly>
                            </div>
</form>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDC9uWg1q9lQ1gR8VS97PbbRx2ZpUgRITE"></script>
<script>
var geocoder;
var map;
var marker;
var infowindow = new google.maps.InfoWindow({
  size: new google.maps.Size(150, 50)
});

function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  var mapOptions = {
    zoom: 8,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
  google.maps.event.addListener(map, 'click', function() {
    infowindow.close();
  });
}

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      marker.formatted_address = responses[0].formatted_address;
    document.getElementById('address1').value = marker.formatted_address;
    document.getElementById('address2').value = marker.formatted_address;
     var latitude = responses[0].geometry.location.lat();
     var longitude = responses[0].geometry.location.lng();
    
       document.getElementById('lat').value = latitude;
       document.getElementById('lang').value = longitude;
     for (var i=0; i < responses[0].address_components.length; i++) {
          for (var j=0; j < responses[0].address_components[i].types.length; j++) {
      if (responses[0].address_components[i].types[j] == "postal_code"){
        
          postal = responses[0].address_components[i];
          
          document.getElementById('zip').value = postal.short_name;
        }
      if (responses[0].address_components[i].types[j] == "administrative_area_level_1") {
              city = responses[0].address_components[i];
       // alert(city.long_name);
        
              document.getElementById('city').value = city.long_name;
//              console.log(country.short_name)
            }
      //alert(results[0].address_components[i].long_name);
          }
        }
    } else {
      marker.formatted_address = 'Cannot determine address at this location.';
    }
    infowindow.setContent(marker.formatted_address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
    infowindow.open(map, marker);
  });
}

function codeAddress() {
  var address = document.getElementById('address').value;
  geocoder.geocode({
    'address': address
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      if (marker) {
        marker.setMap(null);
        if (infowindow) infowindow.close();
      }
      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: results[0].geometry.location
      });
    //alert(results[0].formatted_address);
    //alert(results[0].address_components.length);
    if (results && results.length > 0) {
       document.getElementById('address1').value = results[0].formatted_address;
     document.getElementById('address2').value = results[0].formatted_address;
     var latitude = results[0].geometry.location.lat();
     var longitude = results[0].geometry.location.lng();
    
       document.getElementById('lat').value = latitude;
       document.getElementById('lang').value = longitude;
       for (var i=0; i < results[0].address_components.length; i++) {
          for (var j=0; j < results[0].address_components[i].types.length; j++) {
      if (results[0].address_components[i].types[j] == "postal_code"){
        
          postal = results[0].address_components[i];
          //alert(postal.short_name);
          document.getElementById('zip').value = postal.short_name;
        }
      if (results[0].address_components[i].types[j] == "administrative_area_level_1") {
              city = results[0].address_components[i];
        //alert(city.long_name);
        
              document.getElementById('city').value = city.long_name;
//              console.log(country.short_name)
            }
      //alert(results[0].address_components[i].long_name);
          }
        }
    }else{
      marker.formatted_address = 'Cannot determine address at this location.';
    }
      google.maps.event.addListener(marker, 'dragend', function() {
        geocodePosition(marker.getPosition());
      });
      google.maps.event.addListener(marker, 'click', function() {
        if (marker.formatted_address) {
          infowindow.setContent(marker.formatted_address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
        } else {
          infowindow.setContent(address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
        }
        infowindow.open(map, marker);
      });
      google.maps.event.trigger(marker, 'click');
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

google.maps.event.addDomListener(window, "load", initialize);

</script>

</body>
</html>