 <?php include('includes/header.php'); ?>
 <!-- page title area end -->
 <div class="main-content-inner">
    <div class="row">
        <!-- data table start -->

        <!-- Dark table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                                <?php echo form_open(base_url()."admin/googlelocations/do_add",array('id' => 'add_loc'));?>
                                <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Add Location Name</label>
                                  <input type="text" name="name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter location name">

                                </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Select Road</label>
                                  <select class="form-control required" name="road" id="road">
                                        <option value="">Choose Road</option>
                                        <?php foreach($roads as $row){?>
                                        <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Type</label>
                                  <select class="form-control required" name="type" id="type">
                                        <option value="">Choose Type</option>
                                        <option value="1">Toll Plaza</option>
                                        <option value="2">Weigh Station</option>
                                        <option value="3">Camera</option>
                                        <option value="4">Weather Information System</option>
                                        <option value="5">variable Message Sign</option>
                                        <option value="6">Motorway Advisory Radio</option>
                                        <option value="7">Emergency Road Side Telephole</option>
                                        <option value="8">Microwave Vehicle Detector</option>
                                        <option value="9">Speed Enforcement System</option>
                                        <option value="10">E-fine</option>
                                        <option value="11">Fiber Optic Cable</option>
                                        <option value="12">Service Areas</option>
                                        <option value="13">Rest Areas</option>
                                    </select>
                                </div>
                               
                                <div id="dynamic-input" style="display:none"></div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-weight: 900;">Add Location Address</label>
                                    <div id="locationField">
                                        <input type="text" name="address" class="form-control required" id="autocomplete"  placeholder="Enter location address">
                                    </div>
                           
                                </div>
                        </div>
                        <div class="col-md-12">
                                <div id="map" style="height:300px;top:10px;margin-bottom:30px;">
                                </div>
                        </div>
                        <div class="col-md-10">
                            <table width="100%">
                                <tr>
                                    <td style="border-top: 0px !important;">
                                        <div class="form-group">
                                             <label for="exampleInputEmail1" style="font-weight: 900;">Latitude</label>
                                              <input type="text" name="lat" id="lat" class="form-control required" readonly>
                                   
                                        </div>
                                    </td>

                                <td style="border-top: 0px !important;">
                                    <div class="form-group"  style="margin-left:2%">
                                          <label for="exampleInputEmail1" style="font-weight: 900;">Longitude</label>
                                          <input type="text" class="form-control required" name="lang" id="lang" readonly>
                                    </div> 
                                    </td>
                                </tr>
                            </table>
                          </div>
                          <div class="col-md-6">
                            
                            <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Provience</label>
                                  <input type="text" class="form-control required" name="state" id="administrative_area_level_1" >
                            </div> 
                                    
                          </div>
                          <div class="col-md-6">
                            
                            <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Chain Age</label>
                                  <input type="text" class="form-control required" name="chainage" id="chainage" placeholder="Enter chainage in kilometers">
                            </div> 
                                    
                          </div>
                        </div> 
                         <div class="row">
                            <div class="col-md-12">
                                     <span class="btn btn-primary pull-right" onclick="form_submit('add_loc');">Add Location</span>
                            </div>
                         </div>           

      <?php echo form_close();?>
  
  <div class="col-md-2"></div>
</div>


</div>
</div>
</div>
<!-- Dark table end -->
</div>
</div>
</div> 

<div id="infowindow-content">
    <img src="" width="16" height="16" id="place-icon">
    <span id="place-name" class="title"></span><br>
    <span id="place-address"></span>
</div>

<script>
    var componentForm = {
        administrative_area_level_1: 'short_name'
    };



    var input = document.getElementById('autocomplete');

    function initMap() {
        var geocoder;
        var autocomplete;

        geocoder = new google.maps.Geocoder();
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: -33.8688,
                lng: 151.2195
            },
            zoom: 13
        });
        var card = document.getElementById('locationField');
        autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            draggable: true
        });

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            console.log(place);

            if (!place.geometry) {
                geocodeAddress(geocoder, map);
                
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17); // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            infowindow.open(map, marker);
            fillInAddress();

        });

    function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('autocomplete').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            marker.setPosition(results[0].geometry.location);
            marker.setVisible(true);
            $('#autocomplete').val(results[0].formatted_address);
                        $('#lat').val(marker.getPosition().lat());
                        $('#lang').val(marker.getPosition().lng());
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                        // google.maps.event.trigger(autocomplete, 'place_changed');
                        fillInAddress(results[0]);
            
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }

        function fillInAddress(new_address) { // optional parameter
            if (typeof new_address == 'undefined') {
                var place = autocomplete.getPlace(input);
            } else {
                place = new_address;
            }
            console.log(place);
            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }
            $('#lat').val(marker.getPosition().lat());
            $('#lang').val(marker.getPosition().lng());
            for (var i = 0; i < place.address_components.length; i++) {
                
                 
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
        }

        google.maps.event.addListener(marker, 'dragend', function() {
            geocoder.geocode({
                'latLng': marker.getPosition()
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        console.log(autocomplete);
                        $('#autocomplete').val(results[0].formatted_address);
                        $('#lat').val(marker.getPosition().lat());
                        $('#lang').val(marker.getPosition().lng());
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                        // google.maps.event.trigger(autocomplete, 'place_changed');
                        fillInAddress(results[0]);
                    }
                }
            });
        });
    }
    $(document).ready(function(){
        initMap();
    });
</script>
<script>
    $('body').on('change','#type',function(){
        var stype = $( this ).val();
         $('#dynamic-input').hide('slow');
        $.ajax({
          type:'html',
          url:'<?php echo base_url()?>admin/getgoogledata/' + stype,
          cache       : false,
          contentType : false,
          processData : false,
          
          success:function(data)
          {
           
            $('#dynamic-input').show('slow');
            $('#dynamic-input').html('');
            $('#dynamic-input').html(data);    
          }
        });
    });
</script>

<?php include('includes/footer.php')?> 