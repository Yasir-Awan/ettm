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
                                <?php echo form_open(base_url()."admin/googlelocations/update/".$location[0]['id'],array('id' => 'edit_loc'));?>
                                <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Add Location Name</label>
                                  <input type="text" name="name" class="form-control required" id="exampleInputEmail1" value="<?php echo $location[0]['name'];?>"  placeholder="Enter location name">

                                </div>
                                  <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Select Road</label>
                                  <select class="form-control required" name="road" id="road">
                                        <option value="">Choose Road</option>
                                        <?php foreach($roads as $row){?>
                                    <option value="<?php echo $row['id']?>" <?php if($row['id'] == $location[0]['road_id']){echo "selected";}?>><?php echo $row['name']?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Type</label>
                                  <select class="form-control required" name="type" id="type">
                                        <option value="">Choose Type</option>
                                        <option value="1" <?php if($location[0]['type'] == 1){echo "selected";}?>>Toll Plaza</option>
                                        <option value="2" <?php if($location[0]['type'] == 2){echo "selected";}?>>Weigh Station</option>
                                        <option value="3" <?php if($location[0]['type'] == 3){echo "selected";}?>>Camera</option>
                                        <option value="4" <?php if($location[0]['type'] == 4){echo "selected";}?>>Weather Information System</option>
                                        <option value="5" <?php if($location[0]['type'] == 5){echo "selected";}?>>variable Message Sign</option>
                                        <option value="6" <?php if($location[0]['type'] == 6){echo "selected";}?>>Motorway Advisory Radio</option>
                                        <option value="7" <?php if($location[0]['type'] == 7){echo "selected";}?>>Emergency Road Side Telephole</option>
                                        <option value="8" <?php if($location[0]['type'] == 8){echo "selected";}?>>Microwave Vehicle Detector</option>
                                        <option value="9" <?php if($location[0]['type'] == 9){echo "selected";}?>>Speed Enforcement System</option>
                                        <option value="10" <?php if($location[0]['type'] == 10){echo "selected";}?>>E-fine</option>
                                        <option value="11" <?php if($location[0]['type'] == 11){echo "selected";}?>>Fiber Optic Cable</option>
                                        <option value="12" <?php if($location[0]['type'] == 12){echo "selected";}?>>Service Areas</option>
                                        <option value="13" <?php if($location[0]['type'] == 13){echo "selected";}?>>Rest Areas</option>
                                    </select>
                                </div>
                                <div id="dynamic-input">
                                    <div class="form-group">
                                        <?php if($location[0]['type'] == 1){?>
                                            <label for="exampleInputEmail1" style="font-weight: 900;">Tollplaza</label>
                                        <?php }elseif($location[0]['type'] == 2){?>
                                            <label for="exampleInputEmail1" style="font-weight: 900;">Weighstation</label>
                                        <?php } ?>
                                       <select class="form-control required" name="loc_id" id="loc_id">
                                          
                                            
                                           <?php if($location[0]['type'] == 1){
                                            echo ' <option value="">Choose Tollplaza</option>';
                                            $tollplaza = $this->db->get_where('toolplaza',array('status' => 1))->result_array();
                                            foreach($tollplaza as $row){
                                            ?>
                                                <option value="<?php echo $row['id']?>" <?php if($location[0]['location_id'] == $row['id']){echo "selected";}?>><?php echo $row['name'];?></option>
                                            
                                             <?php }
                                            ?>
                                            
                                        <?php }elseif($location[0]['type'] == 2){ 
                                                echo '<option value="">Choose Weighstation</option>';
                                            $weighstation = $this->db->get_where('weighstation',array('status' => 1))->result_array();
                                            foreach($weighstation as $val){
                                            ?>
                                                <option value="<?php echo $val['id']?>" <?php if($location[0]['location_id'] == $val['id']){echo "selected";}?>><?php echo $val['name'];?></option>
                                            
                                             <?php }
                                            ?>
                                    
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-weight: 900;">Add Location Address</label>
                                    <div id="locationField">
                                        <input type="text" name="address" class="form-control required" id="autocomplete" value="<?php echo $location[0]['address'];?>"  placeholder="Enter location address">
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
                                              <input type="text" name="lat" id="lat" class="form-control required" value="<?php echo $location[0]['lat'];?>" readonly>
                                   
                                        </div>
                                    </td>

                                <td style="border-top: 0px !important;">
                                    <div class="form-group"  style="margin-left:2%">
                                          <label for="exampleInputEmail1" style="font-weight: 900;">Longitude</label>
                                          <input type="text" class="form-control required" value="<?php echo $location[0]['lang'];?>" name="lang" id="lang" readonly>
                                    </div> 
                                    </td>
                                </tr>
                            </table>
                          </div>
                          <div class="col-md-6">
                            
                            <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Provience</label>
                                  <input type="text" class="form-control required" name="state" id="administrative_area_level_1" value="<?php echo $location[0]['state'];?>">
                            </div> 
                                    
                          </div>
                          <div class="col-md-6">
                            
                            <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Chain Age</label>
                                  <input type="text" class="form-control required" name="chainage" id="chainage" value="<?php echo $location[0]['chainage'];?>" placeholder="Enter chainage in kilometers">
                            </div> 
                                    
                          </div>
                        </div> 
                         <div class="row">
                            <div class="col-md-12">
                                     <span class="btn btn-primary pull-right" onclick="form_submit('edit_loc');">Update Location</span>
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
                lat: <?php echo $location[0]['lat'];?>,
                lng: <?php echo $location[0]['lang'];?>
            },
            zoom: 7
        });
        var myLatLng = {lat: <?php echo $location[0]['lat'];?>, lng: <?php echo $location[0]['lang'];?>};
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          draggable: true
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
        
        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            console.log(place);

            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                // window.alert("No details available for input: '" + place.name + "'");
                // return;
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