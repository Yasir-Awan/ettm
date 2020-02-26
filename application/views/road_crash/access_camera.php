<!DOCTYPE html>
<html>
<head>
    <title>Capture webcam image with php and jquery - NHA.com</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <style type="text/css">
        #results { padding:20px; border:1px solid; background:#ccc; }
    </style>
</head>
<body>

<video id="video"></video> 
 <button onclick="" id="button" >Snap</button> 
 <select id="select"></select>  
<!-- <div class="container">
    <h1 class="text-center">Capture webcam image  - Road Crash app</h1>
   
    <form method="POST" action="storeImage.php">
        <div class="row">
            <div class="col-md-6">
                <div id="my_camera"></div>
                <br/>
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="image" class="image-tag">
            </div>
            <div class="col-md-6">
                <div id="results">Your captured image will appear here...</div>
            </div>
            <div class="col-md-12 text-center">
                <br/>
                <button class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
</div>  -->

<h1>hello, lets trace your location</h1>
    <button onClick="getLocation()">Get Location</button>
    <div id="output"></div>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script>
  var x = document.getElementById('output');
//  x.innerHTML = "My Name Is Yasir ."
  function getLocation()
  {
    alert(1);
      if(navigator.geolocation){
          navigator.geolocation.getCurrentPosition(showPosition);
      }
      else
      {
          x.innerHTML = "Browser Not Supporting"
      }
  }
  function showPosition(position)
  {
      // x.innerHTML =  "Latitude = "+ position.coords.latitude
      // x.innerHTML += "<br>"
      // x.innerHTML += "Longitude = "+ position.coords.longitude

      var locAPI = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDCtVwXOq2RjbUyDOmyJLBTYyY6HorvyrI&latlng="+position.coords.latitude+","+position.coords.longitude+"&sensor=true";
      
      $.get({
        url: locAPI,
        success: function (data){
          console.log(data);
          x.innerHTML = data.results[0].address_components[4].long_name+", ";
          x.innerHTML += data.results[0].address_components[7].long_name+", ";
          x.innerHTML += data.results[0].address_components[8].long_name+", ";
          x.innerHTML += data.results[0].address_components[9].long_name;
        }
      });

  };
  </script>
<script>
// app.js
const video = document.getElementById('video');
const button = document.getElementById('button');
const select = document.getElementById('select');

    
    

button.addEventListener('click', event => {
    const constraints = {
        advanced: [{
            facingMode: "environment"
        }]
    };
    navigator.mediaDevices
        .getUserMedia({
            video: constraints
        })
        .then((stream) => {
            //video.src = window.URL.createObjectURL(stream);
            video.srcObject = stream;
            video.play();
        })
    .catch(error => {
      console.error(error);
    });
});
function gotDevices(mediaDevices) {
  select.innerHTML = '';
  select.appendChild(document.createElement('option'));
  let count = 1;
  mediaDevices.forEach(mediaDevice => {
    if (mediaDevice.kind === 'videoinput') {
      const option = document.createElement('option');
      option.value = mediaDevice.deviceId;
      const label = mediaDevice.label || `Camera ${count++}`;
      const textNode = document.createTextNode(label);
      option.appendChild(textNode);
      select.appendChild(option);
    }
  });
}
navigator.mediaDevices.enumerateDevices().then(gotDevices);


</script>
  
<!-- Configure a few settings and attach camera -->
<!-- <script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script> -->
<!-- <script>
    var video = document.getElementById('video');
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');

    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia 
    || navigator.mozGetUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia;

    if(navigator.getUserMedia){
        navigator.getUserMedia({video:true},streamWebCam,throwError);
    }

    function streamWebCam(stream){
        video.srcObject = stream;
        video.play();
    }

    function throwError(e){
        alert(e.name);
    }

    function snap(){
        
        canvas.width = video.clientWidth;
        canvas.height = video.clientHeight;
        context.drawImage(video,0,0);
    }

 </script> -->
 
</body>
</html>