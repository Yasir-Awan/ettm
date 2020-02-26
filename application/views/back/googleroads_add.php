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
                                <?php echo form_open(base_url()."admin/googleroads/do_add",array('id' => 'add_road'));?>
                                <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Add Road Name</label>
                                  <input type="text" name="name" class="form-control required" id="exampleInputEmail1"  placeholder="Enter road name">

                                </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail1" style="font-weight: 900;">Add Route</label>
                                  <input type="text" name="route" class="form-control required" id="exampleInputEmail1"  placeholder="Enter route">

                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1" style="font-weight: 900;">Add Road Address</label>
                                    <div>
                                        <input type="text" name="address" class="form-control required" id="autoc"  placeholder="Enter road address">
                                    </div>
                           
                                </div>
                        </div>
                             
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class='btn btn-xs fa fa-eraser btn-warning pull-right' id="clear" style="color:#ffffff">&nbsp;Clear Map</span>
                                    <span class='btn btn-xs fa fa-eraser btn-info pull-right' id="erase" style="color:#ffffff">&nbsp;Erase</span>
                                
                                </div>
                            </div>
                                <div id="map" style="height:500px;top:10px;margin-bottom:30px;">
                                </div>
                        </div>
                        <input type="hidden" name="road_data" id="road_data"/>
                        <input type="hidden" name="lat" id="lat"/>
                        <input type="hidden" name="lang" id="lang"/>
                         <div class="row">
                            <div class="col-md-12">
                                     <span class="btn btn-primary pull-right" onclick="form_submit('add_road');">Add Road</span>
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
<!-- <div id="bar">
      <p class="auto"><input type="text" id="autoc"/></p>
      <p><a id="clear" href="#">Click here</a> to clear map.</p>
    <p><a id="test" href="#">click to see</a></p>
    </div> -->


<script>
var apiKey = '<?php echo $key;?>';

var map;
var drawingManager;
var placeIdArray = [];
var polylines = [];
var snappedCoordinates = [];

function initialize() {
  var mapOptions = {
    zoom: 15,
    center: {lat: 31.1704063, lng: 72.70971609999992}
  };
  map = new google.maps.Map(document.getElementById('map'), mapOptions);

  // Adds a Places search box. Searching for a place will center the map on that
  // location.
  map.controls[google.maps.ControlPosition.RIGHT_TOP].push(
      document.getElementById('bar'));
  var autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('autoc'));
  autocomplete.bindTo('bounds', map);
  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
     //console.log(place.geometry.location.lat());
      //alert(map.fitBounds(place.geometry.lang);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }
  });

  // Enables the polyline drawing control. Click on the map to start drawing a
  // polyline. Each click will add a new vertice. Double-click to stop drawing.
  drawingManager = new google.maps.drawing.DrawingManager({
    drawingMode: google.maps.drawing.OverlayType.POLYLINE,
    drawingControl: true,
    drawingControlOptions: {
      position: google.maps.ControlPosition.TOP_CENTER,
      drawingModes: [
        google.maps.drawing.OverlayType.POLYLINE
      ]
    },
    polylineOptions: {
      strokeColor: '#696969',
      strokeWeight: 2
    }
  });
  drawingManager.setMap(map);

  // Snap-to-road when the polyline is completed.
  drawingManager.addListener('polylinecomplete', function(poly) {
    var path = poly.getPath();
    polylines.push(poly);
    placeIdArray = [];
    runSnapToRoad(path);
  });

  
  
  

}

// Snap a user-created polyline to roads and draw the snapped path
function runSnapToRoad(path) {
    //alert();
  var pathValues = [];
  for (var i = 0; i < path.getLength(); i++) {
    pathValues.push(path.getAt(i).toUrlValue());

    // if(i < 1){
    //   var first = path.getAt(i).toUrlValue();
    //   var split = first.split(',');
    //    document.getElementById("lat").value = split[0];
    //    document.getElementById("lang").value = split[1];
      
    // }
  }
  

  $.get('https://roads.googleapis.com/v1/snapToRoads', {
    interpolate: true,
    key: apiKey,
    path: pathValues.join('|')
  }, function(data) {
    console.log(data);
    processSnapToRoadResponse(data);
    drawSnappedPolyline();
    //getAndDrawSpeedLimits();
    //document.getElementById("road_data").value = JSON.stringify(data);
  });
}

// Store snapped polyline returned by the snap-to-road service.
function processSnapToRoadResponse(data) {
    //alert('processSnapToRoadResponse');
  snappedCoordinates = [];
  placeIdArray = [];
  for (var i = 0; i < data.snappedPoints.length; i++) {
    var latlng = new google.maps.LatLng(
        data.snappedPoints[i].location.latitude,
        data.snappedPoints[i].location.longitude);
    snappedCoordinates.push(latlng);
    placeIdArray.push(data.snappedPoints[i].placeId);
  }
}

// Draws the snapped polyline (after processing snap-to-road response).
function drawSnappedPolyline() {
    //alert(snappedCoordinates);
  var snappedPolyline = new google.maps.Polyline({
    path: snappedCoordinates,
    strokeColor: 'orange',
    strokeWeight: 5
  });
 
  //get middle value of coordinates////////
  var middle = snappedCoordinates[Math.floor(snappedCoordinates.length / 2)];
  var middle = middle.toString().replace(/[()]/g,'');
  var fields = middle.split(',');
  document.getElementById("lat").value = fields[0];
  document.getElementById("lang").value = fields[1];
  snappedPolyline.setMap(map);
  polylines.push(snappedPolyline);
  document.getElementById("road_data").value = JSON.stringify(snappedCoordinates);
  
}
  $('#erase').click(function(ev){
      //console.log(snappedCoordinates);
    snappedCoordinates.pop();
    //console.log(snappedCoordinates);
    for (var i = 0; i < polylines.length; ++i) {
      polylines[i].setMap(null);
    }
    polylines = [];
    var snappedPolyline = new google.maps.Polyline({
    path: snappedCoordinates,
    strokeColor: 'orange',
    strokeWeight: 5
  });
    snappedPolyline.setMap(null);
    snappedPolyline.setMap(map);
    polylines.push(snappedPolyline);
    document.getElementById("road_data").value = JSON.stringify(snappedCoordinates);
  
  });
//Clear button. Click to remove all polylines.
  $('#clear').click(function(ev) {

  
    for (var i = 0; i < polylines.length; ++i) {
      polylines[i].setMap(null);
    }
    polylines = [];
    document.getElementById("road_data").value = '';
  
    ev.preventDefault();
    return false;
  });
$(document).ready(function(){
   initialize();
});

    </script>
<?php include('includes/footer.php')?> 