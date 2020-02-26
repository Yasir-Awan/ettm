<?php include('includes/header.php');?>
<div class="card text-white mb-3" >
  <div class="card-header" style="color:black;">Road Crash Data Collection App
  
  </div>
  <div class="card-body" style="padding:unset !important; ">
    <!-- <h4 class="card-title">Road Crash Data</h4> -->
<?php echo form_open_multipart(base_url()."road_crash/crash_data/",array('id' => 'crashdata_form','method'=>'post'));?>

   <!---->
<div class="bg-contact3" style="background-image: url('<?php echo base_url()?>assets/rc_assets/responsive_assets/images/bg-06.jpg');">
		<div class="container-contact3">
			<div class="wrap-contact3" >
				<form class="contact3-form validate-form">
					<span class="contact3-form-title" style="padding-bottom:50px; color:yellow;">
						Road Crash app
					</span>



      <div class="tab" ><!-- class tab Start -->
        <fieldset>
        <legend style="margin-top:0.5rem; padding-left:2px; padding-right:2px; display:block; color:yellow;" align="center">Vehicles</legend>
            <input class="input3 form-control" id="coords" style="border:none;" type="hidden" name="coords" placeholder="Your Coordinates" >
						

          <div class="wrap-input3 validate-input has-success" data-validate="Address is required">
          <label class="control-label" style="color:yellow;" for="inputSuccess1">Accident Address</label>
          <input class="input3 form-control is-valid" id="address" style="" type="text" name="address" placeholder="Your Address" >
						<span class="focus-input3"></span>
					</div>
          
           <div class="wrap-input3 validate-input" data-validate="Time is required">
            <div class="form-group has-success" style="margin-bottom:unset">
             <label class="form-control-label" style="color:yellow;" for="inputSuccess1">Crash Time</label>
             <input type="datetime"  class="input3 form-control is-valid " placeholder="Your Name" name="crash_time"  value="<?php echo date("Y-m-d\  H:i:s"); ?>"/>
             </div>
						<span class="focus-input3"></span>
					</div>
          </fieldset>
           
          <fieldset >
               
                <div class="row" style="padding-left:5%; padding-right:5%;">
                  <div class="col-auto wrap-input3 select-input3  form-group validate-input" style="margin-bottom:unset" data-validate="Vehicle Type is required"> 
                      <select class="custom-select input3 form-control required classes selection-2" style="width:inherit;"  placeholder="" name="vehicle_type[]">
                          <option selected="">Select Vehicle Type involved</option>
                          <option value="car">Car</option>
                          <option value="jeep">Jeep</option>
                          <option value="van">Van</option>
                          <option value="coaster">Coaster</option>
                          <option value="bus">Bus</option>
                          <option value="trucK">Truck</option>
                          <option value="bike">Bike</option>
                          <option value="rikshaw">Rikshaw</option>
                        </select>
                    </div>
      
                  <div class="col-auto form-group wrap-input3 validate-input" style="margin-bottom:unset" data-validate="Number of vehicles is required">
                        <input type="number" style="width:inherit; border:none;" name="vehicle_no[]" id="vno_0" class="input3 form-control required classes custom-input" placeholder="Number of Vehicles" min="0">
						            <span class="focus-input3"></span>
                    </div> 

                  <div class="col-auto form-group wrap-input3 validate-input" style="margin-bottom:unset" data-validate="Number of vehicles is required">
                      <input type="text" style="width:inherit; border:none;" name="vehicle_registration[]" id="vno_0" class="input3 form-control required classes custom-input" placeholder="Vehicle Registration No" min="0">
                      
						          <span class="focus-input3"></span>
                   </div> 
 
                  <div class="col-auto wrap-input-container form-group" style=" height:fit-content; padding-left:60%; margin-bottom:unset">
                    <a href="javascript:void(0);" class="btn btn-sm btn-info pull-right form-control" style=" margin-top:0.18rem; height:auto; width:fit-content; " title="Add More Vehicles" onclick="addFormulaProceduress();" data-toggle="tooltip">
                    <i class="fa fa-plus" aria-hidden="true"></i> More Vehicles
                    </a>
                  </div>

                  



                <div class="col-sm-12">
                  <div id="dynamicInput" class="row"></div>
                  </div>
  
            <div class="clearfix"></div>
              <input type="hidden" name="theValue" id="theValue" value="0"/>
          </fieldset>


          
          <!-- <div class="wrap-input3 validate-input" data-validate="Vehicle Registration Number is required">
          <input type="text" class="input3 form-control required custom-input3" style="border:none;"  placeholder="Vehicle Registration No" name="vehicle_registration" id="inputDefault">
						<span class="focus-input3"></span>
          </div>  -->
          


        </div><!-- class tab End -->
        
        <div class="tab" ><!-- class tab Start -->
				

               <div class="wrap-input3 input3-select">
					      	<div>
                  <select class="form-control required selection-2"  placeholder="" name="rtc_cause">
                    <option selected="">Cause of RTC</option>
                    <option value="Over speeding">Over speeding</option>
                    <option value="Carelessness">Carelessness</option>
                    <option value="Wrong turn">Wrong turn</option>
                     <option value="Tyre burst">Tyre burst</option>
                     <option value="Break Failure">Break Failure</option>
                   <option value="sleeping behind the wheel">sleeping behind the wheel</option>
                    <option value="Drunk">Drunk</option>
                   <option value="One Wheeling">One Wheeling</option>
                 </select>
					      	</div>
					        	<span class="focus-input3"></span>
				      	</div>

                <div class="wrap-input3 input3-select">
					      	<div>
                  <select class="custom-select form-control required selection-2" placeholder="" name="wheather_condition">
                     <option selected="">Wheather Condition</option>
                     <option value="Sunny">Sunny</option>
                     <option value="Rainy">Rainy</option>
                      <option value="Cloudy">Cloudy</option>
                      <option value="Foggy">Foggy</option>
                     <option value="Dust Strom">Dust Strom</option>
                    </select>
					      	</div>
					        	<span class="focus-input3"></span>
				      	</div>

                <div class="wrap-input3 input3-select">
					      	<div>
                    <select class="custom-select form-control required selection-2" placeholder="" name="pavement_condition">
                      <option selected="">Pavement Condition</option>
                      <option value="Dry">Dry</option>
                      <option value="Wet">Wet</option>
                      <option value="Slippery">Slippery</option>
                      <option value="Snowy">Snowy</option>
                      <option value="Muddy">Muddy</option>
                    </select>
					      	</div>
					        	<span class="focus-input3"></span>
				      	</div>

                <div class="wrap-input3 input3-select">
					      	<div>
                    <select class="custom-select form-control required selection-2" placeholder="" name="light_condition">
                      <option selected="">Lighting Condition</option>
                      <option value="Day Light">Day Light</option>
                      <option value="Street Light">Street Light</option>
                      <option value="Dark">Dark</option>
                    </select>
					      	</div>
					        	<span class="focus-input3"></span>
                </div>
            </div><!-- class tab End -->

            
          <div class="tab" > <!-- class tab Start -->

          <fieldset >

                

<legend style="margin-top:0.5rem; padding-left:2px; padding-right:2px; color:yellow; display:block;" align="center">Detail of Victims</legend>
<div class="row" style="padding-left:5%; padding-right:5%;">
  <div class="col-auto form-group wrap-input3 validate-input" style="padding:unset; margin-bottom:unset;" data-validate="Number of vehicles is required">
  <input type="number" style="width:inherit; border:none;" name="victim_tno" id="v_0" class="input3 form-control required classes" placeholder="Total Number of Victims" min="0">
        <span class="focus-input3"></span>
    </div> 
</div> 
<div class="row" style="padding-left:5%; padding-right:5%;" >
  
  <div class="col-sm-6 form-group wrap-input3 validate-input" style="padding:unset; margin-bottom:unset;" data-validate="Number of vehicles is required">
        <input type="number" style="width:inherit; border:none;" name="victim_mno" id="vmno_0" class="input3 form-control required classes" placeholder="Number of Males" min="0">
        <span class="focus-input3"></span>
    </div>

    <div class="col-sm-6 form-group wrap-input3 validate-input" style="padding:unset; margin-bottom:unset;" data-validate="Number of vehicles is required">
        <input type="number" style="width:inherit; border:none;" name="victim_fno" id="vfno_0" class="input3 form-control required classes" placeholder="Number of Females" min="0">
        <span class="focus-input3"></span>
    </div>
 </div>
 <br>
 <div class="row" style="padding-left:5%; padding-right:5%;">
  <div class="col-auto wrap-input3 select-input3  form-group validate-input" style="padding:unset; margin-bottom:unset;" data-validate="Injurie Type is required"> 
      
        <select class="custom-select input3 classes selection-2 form-control required" placeholder="Type of Injurie"  style="width:inherit;" name="victim_status[]">
          <option selected="">Type of Injurie</option>
          <option value="Conscious">Conscious</option>
          <option value="Semi-Conscious">Semi-Conscious</option>
          <option value="Unconscious">Unconscious</option>
          <option value="Dead">Dead</option>
        </select>
    </div>

  <div class="col-auto form-group wrap-input3 validate-input" style="padding:unset; margin-bottom:unset;" data-validate="Number of victims is required">
  <input type="number" style="width:inherit; border:none;" class="input3 classes form-control required" placeholder="Selected Injurie Victims" name="victim_no[]" id="inputDefault">

        <span class="focus-input3"></span>
    </div> 

  <div class="col-auto wrap-input-container form-group" style=" height:fit-content; margin-bottom:unset; padding-left:60%;">
    <a href="javascript:void(0);" class="btn btn-sm btn-info pull-right form-control "style="margin-top:.16rem; height:auto; width:fit-content;" title="Add More Victims" onclick="addVictimProcedures();" data-toggle="tooltip">
    <i class="fa fa-plus" aria-hidden="true"></i>More Victims
    </a>
  </div>

  <div class="col-sm-12">
  <div id="dynamicInput3" class="row"></div>
  </div>

  <div class="clearfix"></div>

  <input type="hidden" name="theValue3" id="theValue3" value="0"/>




</fieldset>
      
          </div><!-- tab class End -->

       <div class="tab" > <!-- class tab Start -->
         
      

       <fieldset >
                <legend style="margin-top:0.5rem; padding-left:2px; padding-right:2px; display:block; color:yellow;" align="center">Comments & Photos</legend>                
                <br>
               
                <div class="col-auto form-group wrap-input3 " style="" >
                      <textarea style="width:inherit; border:none;" data-validate="Comments required" name="comments" id="cmnts" class="input3 form-control-required classes custom-input validate-input" placeholder="Type some comments" min="0"></textarea>
                      
						          <span class="focus-input3"></span>
                   </div> 

                <div class="row" style="padding-left:0%; padding-right:8%;">
                  <div class="col-auto form-group wrap-input3 validate-input" style="padding:unset; margin-left:1rem; margin-bottom:unset;" data-validate="Image is required">
                  <input class="input3 file-upload form-control-file" name="supporting_file[]" style="width:fit-content; border:none;" type="file" capture="environment" class="image-tag" placeholder="Take snap or upload from device"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ,application/pdf,image/*">
                
						            <span class="focus-input3"></span>
                    </div> 
 
                  <div class="col-sm-1 wrap-input-container form-group" style="marging-bottom:unset; height:fit-content; padding-left:60%;">
                    <a href="javascript:void(0);" class="btn btn-sm btn-info form-control"  style="margin-top:.15rem; height:auto; width:fit-content; " title="Add More Images" onclick="addFormulaProcedures();" data-toggle="tooltip">
                       <i class="fa fa-plus" aria-hidden="true"> </i> Add More Images
                      </a>
                  </div>


                  <div class="col-sm-12">
                    <div id="dynamicInput2" class="row"></div>
                    </div>
                 </div>
                 
                <div class="clearfix"></div>

                 <input type="hidden" name="theValue2" id="theValue2" value="0"/>
          </fieldset>
                
       
                
               
       </div><!-- tab class End -->

        
       <!-- <div class="tab" > 
       <div class="wrap-contact3-form-radio" style="margin-bottom:-1rem; margin-left:0.5rem;">
          <label class="control-label" for="disabledInput">Driver Lisence</label>
						<div class="contact3-form-radio m-r-42">

							<input class="input-radio3" id="radio3" type="radio" name="license" value="Yes" checked="checked">
							<label class="label-radio3" for="radio3" style="margin-left:90px;">
								Yes
							</label>
						</div>

						<div class="contact3-form-radio">
							<input class="input-radio3" id="radio4" type="radio" name="license" value="No">
							<label class="label-radio3" for="radio4" style="margin-left:10px;">
								No
							</label>
						</div>
          </div>


            <div class="wrap-contact3-form-radio">
          <label class="control-label" for="disabledInput">Driver Gender</label>
						<div class="contact3-form-radio m-r-42">
            
							<input class="input-radio3" id="radio1" type="radio" name="D_gender" value="Male" checked="checked">
							<label class="label-radio3" for="radio1" style="margin-left:35px; margin-top:2px;">
								Male
							</label>
						</div>

						<div class="contact3-form-radio">
							<input class="input-radio3" id="radio2" type="radio" name="D_gender" value="Female">
							<label class="label-radio3" for="radio2">
								Female
							</label>
						</div>
          </div>
       
       </div> -->
          <br>


<div style="float:none; overflow:">
          <div class="row" style="margin-left:1%; margin-right:8%;">
            <div style="width:30%;">
             <button type="button" id="prevBtn" class="btn btn-md" style="background:yellow; color:black;" onclick="nextPrev(-1)">Previous</button>
             </div>
             <div style="width:56%;"></div>
            <div style="width:5%;">
              <button type="button" id="nextBtn" class="btn btn-md" style="background:yellow; color:black; margin-right:5%;" onclick="nextPrev(1)">Next</button>
              </div>
          </div>
      </div>
  


<!-- Circles which indicates the steps of the form: -->
<div style="text-align:center;margin-top:40px;">
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>


</div>




					<div class="container-contact3-form-btn " id="submit_btn" style="display:none;" align="center">
          <button type="submit" class="contact3-form-btn " onclick="form_submit('crashdata_form');">Submit</button>
         </div>
  <?php echo form_close();?>
					
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>





<!-- 
<script>

  $(document).ready(function(){

if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showPosition);
    }
    else
    {
        y.value = "Browser Not Supporting";
    }
});
</script> -->




    

  <!--   Core JS Files   -->
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<!-- Configure a few settings and attach camera -->
  <script>

  var x = document.getElementById('address');
  var y = document.getElementById('coords');
  
//  x.innerHTML = "My Name Is Yasir ."
 $(document).ready(function(){

  if(navigator.geolocation){
          navigator.geolocation.getCurrentPosition(showPosition);
      }
      else
      {
          x.value = "Browser Not Supporting";
          y.value = "Browser Not Supporting";
      }
 });
      
  
  function showPosition(position)
  {
       y.value =  "Lat = "+ position.coords.latitude;
       y.value += " ";
       y.value += "Long = "+ position.coords.longitude;

      var locAPI = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDCtVwXOq2RjbUyDOmyJLBTYyY6HorvyrI&latlng="+position.coords.latitude+","+position.coords.longitude+"&sensor=true";
      
      $.get({
        url: locAPI,
        success: function (data){
          console.log(data);
          x.value = data.results[0].address_components[1].long_name+", ";
          x.value += data.results[0].address_components[2].long_name+", ";
          x.value += data.results[0].address_components[4].long_name+", ";
          x.value += data.results[0].address_components[7].long_name+", ";
          x.value += data.results[0].address_components[8].long_name+", ";
          x.value += data.results[0].address_components[9].long_name;
          
        }
      });

  };
  </script> 
 

 <script>
 

 </script> 
 <!-- Script for adding more Vehicles & its Types Start -->
 <script>
  function addFormulaProceduress() {
    var ni = document.getElementById('dynamicInput');
    var numi = document.getElementById('theValue');
    
    var num = (document.getElementById("theValue").value -1)+ 2;
    numi.value = num;
    var num2=num+1; 
    var divIdName = "my"+num+"Div";
    var newdiv = document.createElement('div');
    newdiv.setAttribute("id",divIdName);
    newdiv.setAttribute("style","width:inherit;");
    
  newdiv.innerHTML = '<div id='+divIdName+' class="row" style="padding-left:10%; padding-right:10%;"><div class="col-auto wrap-input3 select-input3  form-group validate-input" style="margin-bottom:unset;" data-validate="Vehicle Type is required""> <select class="custom-select input3 form-control required classes selection-2" style="width:inherit; border:none;"  placeholder="" name="vehicle_type[]"><option selected="">Select Vehicle Type</option><option value="car">Car</option><option value="jeep">Jeep</option><option value="van">Van</option><option value="coaster">Coaster</option><option value="bus">Bus</option><option value="trucK">Truck</option><option value="bike">Bike</option><option value="rikshaw">Rikshaw</option></select></div><div class="col-auto form-group wrap-input3 validate-input" style="margin-bottom:unset;" data-validate="Number of vehicles is required" ><input type="number" style="width:inherit; border:none;" name="vehicle_no[]" id="vno_0" class="input3 form-control required classes custom-input" placeholder="Number of Vehicles" min="0"></div><div class="col-auto form-group wrap-input3 validate-input" style="margin-bottom:unset;" data-validate="Number of vehicles is required"><input type="text" style="width:inherit; border:none;" name="vehicle_registration[]" id="vno_0" class="input3 form-control required classes custom-input" placeholder="Vehicle Registration No" min="0"><span class="focus-input3"></span></div> <div class="col-auto wrap-input-container" style="height:fit-content; padding-left:75%;" ><a href="javascript:void(0);" class="btn btn-sm btn-danger" title="Remove File" onclick="minusVehicleFrom('+num+');" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i> Remove</a></div></div>';
  ni.appendChild(newdiv);
  
  } 

  var subtractValue;
  function minusVehicleFrom(idd_v) {
    //alert(idd_v);
    var totalCostVal;
    var subTotalCost;
    var new_cost;
    var nxt_check = '';
    
  
    //remove div
    n = idd_v + 1;
    nxt_check = document.getElementById('total_cost_'+n);
    var d = document.getElementById('dynamicInput');
    var olddiv = document.getElementById('my'+idd_v+'Div');

    d.removeChild(olddiv);
    var numi = document.getElementById('theValue');
    var num = document.getElementById("theValue").value;
    if(nxt_check == null){
      numi.value = num-1;  
    }else{
      numi.value = num;
    }
          
  }

</script>
  <!-- Script for adding more Vehicles & its Types End -->
 

<!-- Script for add more Images Start -->
<script>
  function addFormulaProcedures() {
    var ni = document.getElementById('dynamicInput2');
    var numi = document.getElementById('theValue2');
    
    var num = (document.getElementById("theValue2").value -1)+ 2;
    numi.value = num;
    var num2=num+1; 
    var divIdName = num+"Div";
    var newdiv = document.createElement('div');
    newdiv.setAttribute("id",divIdName);
    newdiv.setAttribute("style","width:inherit; ");
  newdiv.innerHTML = '<div id='+divIdName+' class="row"><div class="col-auto wrap-input-container form-group" style="margin-bottom:unset; padding-left:5%; padding-right:5%;"><label style="color:yellow;">Accident Images (<img height="20" width="25" style="background-color:wheat; padding:2px;"  src="<?php echo base_url();?>assets/photos/cam2.png" alt="logo">)</label><input class="file-upload form-control required "  name="supporting_file[]" type="file"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ,application/pdf,image/*"></div><div  class="col-auto  wrap-input-container" style="padding-left:70%;"><a href="javascript:void(0);" class="btn btn-sm btn-danger" title="Remove File" onclick="minusValueFrom('+num+');" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i> Remove</a></div></div>';
  ni.appendChild(newdiv);
  
  } 

  var subtractValue;
  function minusValueFrom(iddiv) {
    //alert(idd_v);
    var totalCostVal;
    var subTotalCost;
    var new_cost;
    var nxt_check = '';
    
  
    //remove div
    n = iddiv + 1;
    nxt_check = document.getElementById('total_cost_'+n);
    var d = document.getElementById('dynamicInput2');
    var olddiv = document.getElementById(iddiv+'Div');

    d.removeChild(olddiv);
    var numi = document.getElementById('theValue2');
    var num = document.getElementById("theValue2").value;
    if(nxt_check == null){
      numi.value = num-1;  
    }else{
      numi.value = num;
    }
          
  }

</script>
<!-- Script for add more Images End -->

<!-- Script for add more Victims & their Status Start -->
<script>
  function addVictimProcedures() {
    var ni = document.getElementById('dynamicInput3');
    var numi = document.getElementById('theValue3');
    
    var num = (document.getElementById("theValue3").value -1)+ 2;
    numi.value = num;
    var num2=num+1; 
    var divIdName = "Div"+num;
    var newdiv = document.createElement('div');
    newdiv.setAttribute("id",divIdName);
    newdiv.setAttribute("style","width:auto; ");
  newdiv.innerHTML = '<div id='+divIdName+' class="row" style="padding-left:10%; padding-right:10%;"><div class="col-auto wrap-input3 select-input3  form-group validate-input" style="padding:unset; margin-bottom:unset;" data-validate="Injurie Type is required" > <select class="custom-select input3 classes selection-2 form-control required" style="border:none;" placeholder="Type of Injurie"  style="width:inherit;" name="victim_status[]"><option selected="">Type of Injurie</option><option value="Conscious">Conscious</option><option value="Semi-Conscious">Semi-Conscious</option><option value="Unconscious">Unconscious</option><option value="Dead">Dead</option></select></div> <div class="col-auto form-group required wrap-input3 validate-input" style="padding:unset; margin-bottom:unset;" data-validate="Number of victims is required"><input type="number" style="width:inherit; border:none;" class="input3 classes form-control required" placeholder="Selected Injurie Victims" name="victim_no[]" id="inputDefault"></div><div class="col-auto wrap-input-container" style="height:fit-content; padding-left:75%;" ><a href="javascript:void(0);" class="btn btn-sm btn-danger" title="Remove File" onclick="minusVictimFrom('+num+');" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i> Remove</a></div></div>';
  ni.appendChild(newdiv);
  
  } 
  var subtractValue;
  function minusVictimFrom(iddiv) {
    //alert(idd_v);
    var totalCostVal;
    var subTotalCost;
    var new_cost;
    var nxt_check = '';
    //remove div
    n = iddiv + 1;
    nxt_check = document.getElementById('total_cost_'+n);
    var d = document.getElementById('dynamicInput3');
    var olddiv = document.getElementById('Div'+iddiv);

    d.removeChild(olddiv);
    var numi = document.getElementById('theValue3');
    var num = document.getElementById("theValue3").value;
    if(nxt_check == null){
      numi.value = num-1;  
    }else{
      numi.value = num;
    }      
  }
</script>
<!-- Script for add more Victims & their Status End -->


    <?php include('includes/footer.php');?>
    
    
 