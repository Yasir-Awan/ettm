<!DOCTYPE html>
<head>
<title>Geo Location Api by yasir</title>
</head>
<body>
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
  
</body>
</html>