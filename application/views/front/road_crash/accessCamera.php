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
<!-- <select id="select"></select> -->
 <canvas id="canvas" ></canvas> <br>

 <button onclick="" id="button" >Camera</button> 
 <!-- <select id="audioSource"></select>  -->
 <select id="videoSource"></select> 
 <button onclick="snap();" id="" >Snap</button>
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
 /*
Copyright 2017 Google Inc.
Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at
    http://www.apache.org/licenses/LICENSE-2.0
Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

'use strict';
  const  button = document.getElementById('button')
var videoElement = document.querySelector('video');
// var audioSelect = document.querySelector('select#audioSource');
var videoSelect = document.querySelector('select#videoSource');
var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    button.addEventListener('click', event => {
// audioSelect.onchange = getStream;
videoSelect.onchange = getStream;

getStream().then(getDevices).then(gotDevices);

function getDevices() {
  // AFAICT in Safari this only gets default devices until gUM is called :/
  return navigator.mediaDevices.enumerateDevices();
}

function gotDevices(deviceInfos) {
  window.deviceInfos = deviceInfos; // make available to console
  console.log('Available input and output devices:', deviceInfos);
  for (const deviceInfo of deviceInfos) {
    const option = document.createElement('option');
    option.value = deviceInfo.deviceId;
    // if (deviceInfo.kind === 'audioinput') {
    //   option.text = deviceInfo.label || `Microphone ${audioSelect.length + 1}`;
    //   audioSelect.appendChild(option);
    // } else
     if (deviceInfo.kind === 'videoinput') {
      option.text = deviceInfo.label || `Camera ${videoSelect.length + 1}`;
      videoSelect.appendChild(option);
    }
  }
}

function getStream() {
  if (window.stream) {
    window.stream.getTracks().forEach(track => {
      track.stop();
    });
  }
//   const audioSource = audioSelect.value;
  const videoSource = videoSelect.value;
  const constraints = {
    // audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
    video: {deviceId: videoSource ? {exact: videoSource} : undefined}
  };
  return navigator.mediaDevices.getUserMedia(constraints).
    then(gotStream).catch(handleError);
}

function gotStream(stream) {
  window.stream = stream; // make stream available to console
//   audioSelect.selectedIndex = [...audioSelect.options].
//     findIndex(option => option.text === stream.getAudioTracks()[0].label);
  videoSelect.selectedIndex = [...videoSelect.options].
    findIndex(option => option.text === stream.getVideoTracks()[0].label);
  videoElement.srcObject = stream;
  videoElement.play();
}

function handleError(error) {
  console.error('Error: ', error);
}
});
function snap(){
        
        canvas.width = video.clientWidth;
        canvas.height = video.clientHeight;
        context.drawImage(video,0,0);
    }

 </script> 
 
 </body>
 </html>