
<?php echo form_open(base_url()."admin/tarrif/add_tarrif/",array('id' => 'add_terrif'));?>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Toll Plaza</label>
      <select name="plaza[]" onchange="(this.value,this)" class="demo-cs-multiselect form-control" multiple="multiple" data-placeholder="Choose Toll Plaza" tabindex="-1" data-hide-disabled="true" id="service_category">
          <option value="">Choose Plaza</option>
          <?php foreach($plaza as $value){
              
            
            ?>
            
          <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
        
          <?php } ?>
      </select>
    </div>
  </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Effective From</label>
        <input type="text" class="form-control required" id="start_date" name="start_date" placeholder="Choose Start Date"> 
      </div>
      
    </div>
    <div class="col-md-6">

      <div class="form-group">
        <label>Effective Till</label>
        <input type="text" class="form-control required" id="end_date" name="end_date" placeholder="Choose End Date"> 
      </div>
      
    </div>
    <div class="col-md-6">
    <div class="form-group ">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-1 Description</label>
      <input type="text" name="class_1_desc" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class1 description" value="Class-1 (Car, Jeep)">
      
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-1 Rate</label>
      <input type="text" name="class_1_rate"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class1 rate">
      
    </div>
  </div>
  
  <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-2 Description</label>
      <input type="text" name="class_2_desc"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class2 Description" value="Class-2 (Wagon, Hiace)">
      
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-2 Rate</label>
      <input type="text" name="class_2_rate"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class2 rate">
      
    
    </div>
  </div>
   <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-3 Description</label>
      <input type="text" name="class_3_desc" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class3 Description" value="Class-3 (Tractor & Trolly)">
      </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-3 Rate</label>
      <input type="text" name="class_3_rate"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class3 rate">
      </div>
    </div>
  
 
    <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-4 Description</label>
      <input type="text" name="class_4_desc"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class4 Description" value="Class-4 (Buses, Coaster)">
      </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-4 Rate</label>
      <input type="text" name="class_4_rate"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class4 rate">
      </div>
    </div>
   
<div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-5 Description</label>
      <input type="text" name="class_5_desc"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class5 Description" value="Class-5 (2 Axle Trucks) ">
      </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-5 Rate</label>
      <input type="text" name="class_5_rate"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class5 rate">
      </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-6 Description</label>
      <input type="text" name="class_6_desc"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class6 Description" value="Class-6 (3 Axle Trucks)">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-6 Rate</label>
        <input type="text" name="class_6_rate"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class6 rate">
        
      </div> 
  </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-7 Description</label>
        <input type="text" name="class_7_desc" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class7 Description" value="Class-7 (3 Axle Articulated)">
      </div>    
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-7 Rate</label>
        <input type="text" name="class_7_rate"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class7 rate">
      </div>    
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-8 Description</label>
        <input type="text" name="class_8_desc"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class8 Description" value="Class-8 (4 Axle Articulated)">
      </div>  
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-8 Rate</label>
        <input type="text" name="class_8_rate"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class8 rate">
      </div>    
    </div>
  
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-9 Description</label>
        <input type="text" name="class_9_desc"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class9 Description" value="Class-9 (5 Axle Articulated) ">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-9 Rate</label>
        <input type="text" name="class_9_rate"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class9 rate">
        
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-10 Description</label>
        <input type="text" name="class_10_desc" class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class10 Description" value="Class-10 (6 Axle Articulated)">
        
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-10 Rate</label>
        <input type="text" name="class_10_rate"  class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class10 rate" >
        
      </div>
    </div>

    <div class="col-md-12">
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('add_terrif');">Add Tarrif</span>
    </div>

</div>
<?php echo form_close();?>
<script>
  $(document).ready(function() {
    $('.demo-chosen-select').chosen();
    $('.demo-cs-multiselect').chosen({width:'100%'});
  });
  $(document).ready(function(){
          var endYear = new Date(new Date().getFullYear(), 11, 31);
          $("#start_date").datepicker({
            format: "yyyy/mm/dd",
            //startDate: "01/01/2010",
            autoclose: true
            //endDate: endYear,
            
          })
          $("#end_date").datepicker({
            format: "yyyy/mm/dd",
            //startDate: "01/01/2010",
            autoclose: true
            //endDate: endYear,
            
          })
      

    });
  </script>