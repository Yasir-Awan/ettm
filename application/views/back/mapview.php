<?php include('includes/header.php'); ?>
<style>
.hide-checkbox{
  opacity: 0;
}
.list-group-item.active {
    z-index: 0;
    
}



@media screen and (min-width: 1200px) {
 .leftsidebar{
  background-color: red; width: auto;position: absolute;left: 21%;
    margin-top: 5%;
    z-index: 1;
}

}
@media screen and (min-width: 1500px)  {
  .leftsidebar{
  background-color: red; width: auto;position: absolute;left: 17%;
    margin-top: 5%;
    z-index: 1;
}

}
@media screen and (min-width: 1900px) {
 .leftsidebar{
  background-color: red; width: auto;position: absolute;left: 15%;
    margin-top: 5%;
    z-index: 1;
}

}
@media screen and (min-width: 2500px) {
 .leftsidebar{
  background-color: red; width: auto;position: absolute;left: 15%;
    margin-top: 5%;
    z-index: 1;
}

}


@media screen and (max-height: 600px) {  
.rightsidebar{
  background-color: red; width: 5%;min-height: 100px;position: absolute;right: 5px;margin-top: -50%;
}

}
@media screen and (max-height: 950px) {
.rightsidebar{
  background-color: red; width: 5%;min-height: 100px;position: absolute;right: 5px;margin-top: -48%;
}
}
@media screen and (max-height: 1080px) {
.rightsidebar{
  background-color: red; width: 5%;min-height: 100px;position: absolute;right: 5px;margin-top: -34%;
}

}
@media screen and (max-height: 770px) {
.rightsidebar{
  background-color: red; width: 5%;min-height: 100px;position: absolute;right: 5px;margin-top: -48%;
}

}
</style>
<div class="panel-header panel-header-sm" style="height:50px; padding-top:10px">

</div>
 <div class="container-fluid">
  <?php echo form_open(base_url()."admin/searchforgoogledata",array('id' => 'datasearch'));?>
       
  <div class="left-div leftsidebar">
        <ul class="list-group list-left">
            <li class="list-group-item fa fa-road left-click" data-toggle="tooltip" data-placement="right" title="All Roads" style="padding: 0.75rem 0.50rem;cursor: pointer;">&nbsp;All Roads<input type="checkbox" class="hide-checkbox" name="specific_road" value="all"></li>
          
          <?php foreach($roads as $row){?>
            <li class="list-group-item fa fa-road left-click" data-toggle="tooltip" data-placement="right" title="<?php echo $row['name']?>" style="padding: 0.75rem 0.50rem;cursor: pointer;">&nbsp;<?php echo $row['route'];?><input type="checkbox" class="hide-checkbox" name="specific_road" value="<?php echo $row['id']?>"></li>
          <?php } ?>
        </ul>
      </div>
      <div id="ajax-load">
      
      <div id="map" style="width: 100%; height: 700px;"></div>
      
      <script>

        var apiKey = '<?php echo $key;?>';

        var map;
        var drawingManager;
        var placeIdArray = [];
        var polylines = [];
        var snappedCoordinates = [];
        <?php 
          foreach($roads as $row){
        ?>    
        //snappedCoordinates = <?php echo $row['data'];?>,
            snappedCoordinates.push('<?php echo $row["data"]; ?>');
         <?php  }
        ?>
        //console.log(snappedCoordinates);
        function initialize() {
          var mapOptions = {
            zoom: 6
          };
          map = new google.maps.Map(document.getElementById('map'), mapOptions);

          // Adds a Places search box. Searching for a place will center the map on that
          // location.
          map.controls[google.maps.ControlPosition.RIGHT_TOP].push(
              document.getElementById('bar'));

          //////highlight a whole country

            geocoder = new google.maps.Geocoder();
    
          var country = "Pakistan";
          var geocoder;

          geocoder.geocode( {'address' : country}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                  map.setCenter(results[0].geometry.location);
              }
          });

        }
        $(document).ready(function(){
           initialize();
           var i;
           for(i= 0; i< snappedCoordinates.length; i++){
            console.log(snappedCoordinates[i]);
            var snappedPolyline = new google.maps.Polyline({
            path: JSON.parse(snappedCoordinates[i]),
            strokeColor: 'orange',
            strokeWeight: 5
          });

          snappedPolyline.setMap(map);
           }

         

        });
      </script>
    
                              
    
    
  
  </div>
<div class="rightsidebar">
          <ul class="list-group">
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="All Tollplaza" style="margin-bottom:-15px;"><i class="fa fa-bank" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="alltollplaza"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="All Weighstations" style="margin-bottom:-15px;"><i class="fa fa-balance-scale" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="allweighstation"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="All Cameras" style="margin-bottom:-15px;"><i class="fa fa-camera" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="cameras"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="Weather Information System" style="margin-bottom:-15px;"><i class="fa fa-cloud" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="wis"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="Emergency Road Side Telephone" style="margin-bottom:-15px;"><i class="fa fa-phone" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="erst"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="Motorway Advisory Radio" style="margin-bottom:-15px;"><i class="fa fa-podcast" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="advisory_radio"></i></li>
           
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="Microwave Vehicle Detector" style="margin-bottom:-15px;"><i class="fa fa-car" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="microwavevd"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="Variable Message Sign" style="margin-bottom:-15px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="vms"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="E-fine" style="margin-bottom:-15px;"><i class="fa fa-money" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="efine"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="Optical Fiber Cable" style="margin-bottom:-15px;"><i class="fa fa-magic" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="ofc"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="Speed Enforcement System" style="margin-bottom:-15px;"><i class="fa fa-assistive-listening-systems" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="speedes"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="Service Areas" style="margin-bottom:-15px;"><i class="fa fa-wrench" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="service"></i></li>
            <li class="list-group-item right-click" data-toggle="tooltip" data-placement="left" title="Rest Areas" style="margin-bottom:-15px;"><i class="fa fa-bed" aria-hidden="true"><input type="checkbox" class="hide-checkbox" name="rest"></i></li>
          </ul>
        </div>
        </form>
      </div>
        <?php include('includes/footer.php');?>  
<script>
    var base_url = '<?php echo base_url(); ?>';
    var selector = '.list-left li';


$('body').on('click','.right-click', function(){
   if($(this).hasClass('active')){
        $(this).removeClass('active');
        jQuery(this).closest('li').find('[type=checkbox]').prop('checked', false);

   }else{
         $(this).addClass('active');
        jQuery(this).closest('li').find('[type=checkbox]').prop('checked', true);

   }
   customsearchformdata();

});
  
  $('body').on('click','.left-click', function(){
      if($(this).hasClass('active')){
         $('.left-click').removeClass('active');
         $('.left-click').find('[type=checkbox]').prop('checked', false);

      }else{
        $('.left-click').removeClass('active');
        $('.left-click').find('[type=checkbox]').prop('checked', false);


        $(this).addClass('active');
        jQuery(this).closest('li').find('[type=checkbox]').prop('checked', true);

      }
       
    customsearchformdata();

}); 
function customsearchformdata(){
  
  var loading_set = '<div class="col-md-12"><div class="stat" style="text-align:center;"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
  var form = $('#datasearch');
  var list = $('#ajax-load');
    var formdata = false;
      if (window.FormData){
          formdata = new FormData(form[0]);
      }
    $.ajax({
          url: form.attr('action'), // form action url
          type: 'POST', // form submit method get/post
          dataType: 'html', // request type html/json/xml
          data: formdata ? formdata : form.serialize(), // serialize form data 
              cache       : false,
              contentType : false,
              processData : false,
              async: true,
          beforeSend: function() {
           list.html(loading_set);
          },
          success: function(data) {
            list.html('');
            list.html(data).fadeIn();
          },
          error: function(e) {
            console.log(e)
          }
        });
}  

</script>
<script>

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
function load_content(map,marker,infowindow){
  var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
  $.ajax({
    url: "<?php echo base_url();?>admin/getcontents/" + marker.id,
    beforeSend: function() {
      infowindow.setContent(loading_set);
      infowindow.open(map, marker);
    },
    success: function(data){
      infowindow.setContent(data);
      //infowindow.open(map, marker);
    }
  });
}
$('body').on('click','.nav-btn',function(){
  var width = $(window).width();
alert($(window).height());
alert($(window).width());
  if ($(".page-container").hasClass("sbar_collapsed")) {
     $('.left-div').css("left", "5px"); 
  }else{
    if(width <= 1500){
        $('.left-div').css("left", "21%");
    }else if(width <= 1700){
        $('.left-div').css("left", "18%");
    }else{
        $('.left-div').css("left", "15%");
    }
    

 } 
});

    </script>
 

        <!-- footer area start-->