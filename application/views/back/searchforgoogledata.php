 <div id="map" style="width: 100%; height: 700px;"></div>
 <script>

var apiKey = '<?php echo $key;?>';
 var locations = [
      <?php if($locations){ 
      			foreach($locations as $loc){
         echo "['".$loc['name']."',".$loc['lat'].",".$loc['lang'].",".$loc["id"].",".$loc['type']."],";
      }
  }?>
       
      
    ];
var map;
var placeIdArray = [];
var polylines = [];
var snappedCoordinates = [];
<?php 
  if($roads){
  foreach($roads as $row){
?>
    snappedCoordinates.push('<?php echo $row["data"]; ?>');
 <?php  } }
?>

function initialize() {
  var mapOptions = {
    
    <?php if($roads){
    	//////check if roads are searched/////
    		if(sizeof($roads) > 1){
    			//check if all roads all searched then show complete country map///
    	?>
      
    	zoom: 6,
    	mapTypeId: google.maps.MapTypeId.ROADMAP,
    <?php }else{
  		////check if single road is searched then highlight taht specific road
  	 ?>
  		zoom: 6,
    	mapTypeId: google.maps.MapTypeId.ROADMAP,
    	center: {lat: <?php echo @$roads[0]['lat']?>, lng: <?php echo @$roads[0]['lang']?>}
  	
 	<?php	} }else{ 
 		//check if no road is searched then highlight conty locations////
 	?>
 		zoom: 6,
    	mapTypeId: google.maps.MapTypeId.ROADMAP
 	<?php } ?>
  };
  map = new google.maps.Map(document.getElementById('map'), mapOptions);

  // Adds a Places search box. Searching for a place will center the map on that
  // location.
  map.controls[google.maps.ControlPosition.RIGHT_TOP].push(
      document.getElementById('bar'));
      geocoder = new google.maps.Geocoder();
    
    var country = "Pakistan";
    var geocoder;
    <?php if($roads && sizeof($roads) > 1){
    	//check if roads are multiple then highlight country
    ?>
	    geocoder.geocode( {'address' : country}, function(results, status) {
	        if (status == google.maps.GeocoderStatus.OK) {
	            map.setCenter(results[0].geometry.location);
	        }
	    });
    <?php } ?>
    <?php if(empty($roads)){
    	//if no road is choosen then highlight country///
    ?>
    	geocoder.geocode( {'address' : country}, function(results, status) {
	        if (status == google.maps.GeocoderStatus.OK) {
	            map.setCenter(results[0].geometry.location);
	        }
	    });
    <?php }?>
    /////////////Highlight Code Ends Here//////////
    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
      var icoon;
        if(locations[i][4] == 1){
          icoon  =  "<?php echo base_url()?>assets/images/tollplaza_s.png"; // url
                      
        }else if(locations[i][4] == 2){
          icoon = 'http://maps.google.com/mapfiles/ms/icons/truck.png';
        }else if(locations[i][4] == 3){
              icoon  =  { url: "<?php echo base_url()?>assets/images/speedcamera.png", // url
                      scaledSize: new google.maps.Size(40, 40), // scaled size
                      origin: new google.maps.Point(0,0), // origin
                      anchor: new google.maps.Point(0, 0), // anchor};'<?php echo base_url()?>assets/images/tollplaza.jpg';
        
                     };
        }else if(locations[i][4] == 4){
            icoon  =  { url: "<?php echo base_url()?>assets/images/weather2.png", // url
                      scaledSize: new google.maps.Size(35, 35), // scaled size
                      origin: new google.maps.Point(0,0), // origin
                      anchor: new google.maps.Point(0, 0), // anchor};'<?php echo base_url()?>assets/images/tollplaza.jpg';
        
                     };
        }else if(locations[i][4] == 5){
              icoon  =  { url: "<?php echo base_url()?>assets/images/vms.png", // url
                      scaledSize: new google.maps.Size(40, 40), // scaled size
                      origin: new google.maps.Point(0,0), // origin
                      anchor: new google.maps.Point(0, 0), // anchor};'<?php echo base_url()?>assets/images/tollplaza.jpg';
        
                     };
        }
        else if(locations[i][4] == 6){
             icoon  =  { url: "<?php echo base_url()?>assets/images/radi2.png", // url
                      scaledSize: new google.maps.Size(40, 40), // scaled size
                      origin: new google.maps.Point(0,0), // origin
                      anchor: new google.maps.Point(0, 0), // anchor};'<?php echo base_url()?>assets/images/tollplaza.jpg';
        
                     };
        }
        else if(locations[i][4] == 7){
          icoon = 'http://maps.google.com/mapfiles/ms/icons/phone.png';
        }
        else if(locations[i][4] == 8){
           icoon  =  { url: "<?php echo base_url()?>assets/images/detector.png", // url
                      scaledSize: new google.maps.Size(35, 35), // scaled size
                      origin: new google.maps.Point(0,0), // origin
                      anchor: new google.maps.Point(0, 0), // anchor};'<?php echo base_url()?>assets/images/tollplaza.jpg';
        
                     };
        }
        else if(locations[i][4] == 9){
            icoon  =  { url: "<?php echo base_url()?>assets/images/SPEED_INFO.png", // url
                      scaledSize: new google.maps.Size(35, 35), // scaled size
                      origin: new google.maps.Point(0,0), // origin
                      anchor: new google.maps.Point(0, 0), // anchor};'<?php echo base_url()?>assets/images/tollplaza.jpg';
        
                     };
        }
        else if(locations[i][4] == 10){
          icoon  =  { url: "<?php echo base_url()?>assets/images/efine.png", // url
                      scaledSize: new google.maps.Size(35, 35), // scaled size
                      origin: new google.maps.Point(0,0), // origin
                      anchor: new google.maps.Point(0, 0), // anchor};'<?php echo base_url()?>assets/images/tollplaza.jpg';
        
                     };
        }
        else if(locations[i][4] == 11){
          icoon  =  { url: "<?php echo base_url()?>assets/images/optical fiber.png", // url
                      scaledSize: new google.maps.Size(50, 50), // scaled size
                      origin: new google.maps.Point(0,0), // origin
                      anchor: new google.maps.Point(0, 0), // anchor};'<?php echo base_url()?>assets/images/tollplaza.jpg';
        
                     };
        }
        else if(locations[i][4] == 12){
          icoon  =  { url: "<?php echo base_url()?>assets/images/service areas.png", // url
                      scaledSize: new google.maps.Size(35, 35), // scaled size
                      origin: new google.maps.Point(0,0), // origin
                      anchor: new google.maps.Point(0, 0), // anchor};'<?php echo base_url()?>assets/images/tollplaza.jpg';
        
                     };
        }
        else if(locations[i][4] == 13){
           icoon = 'http://maps.google.com/mapfiles/ms/icons/lodging.png';
        }
        
        //alert(icoon);
      marker = new google.maps.Marker({
        icon : icoon,
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        animation: google.maps.Animation.DROP,
        title: locations[i][0],
        id: locations[i][3]
      });
      //addMarkerWithTimeout(new google.maps.LatLng(locations[i][1], locations[i][2]), i * 200);
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          //infowindow.setContent('<div style="width:300px; height:400px;background-color:red;">');
          //infowindow.open(map, marker);
          load_content(map,this,infowindow); 
        }
      })(marker, i));
    }

}





$(document).ready(function(){
   initialize();
   var i;
   if(snappedCoordinates){
	   for(i= 0; i< snappedCoordinates.length; i++){
		   console.log(snappedCoordinates[i]);
		   var snappedPolyline = new google.maps.Polyline({
		    	path: JSON.parse(snappedCoordinates[i]),
		    	strokeColor: 'orange',
		    	strokeWeight: 5
		   });

		   snappedPolyline.setMap(map);
		}
   }

});

    </script>
 <script type="text/javascript">
   

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 7,
      //center: new google.maps.LatLng(30.375321,69.34511599999996),
      
    });
    /////Code for highlighting Country On google Maps////


       function addMarkerWithTimeout(position, timeout) {
        window.setTimeout(function() {
          marker.push(new google.maps.Marker({
            position: position,
            map: map,
            animation: google.maps.Animation.DROP
          }));
        }, timeout);
      }



  </script>