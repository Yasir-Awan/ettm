<?php echo form_open(base_url()."admin/tarrif/update_terrif/".$terrif[0]['id'],array('id' => 'edit_terrif'));?>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Toll Plaza</label>
      <select name="plaza[]" onchange="(this.value,this)" class="demo-cs-multiselect form-control" multiple="multiple" data-placeholder="Choose Toll Plaza" tabindex="-1" data-hide-disabled="true" id="service_category">
          <option value="">Choose Plaza</option>
          <?php foreach($plaza as $value){
              $selected = explode(',', $terrif[0]['toolplaza']);
            
            ?>
            <?php //foreach($selected as $select){?>
          <option value="<?php echo $value['id'];?>" <?php if(in_array($value['id'],$selected)){echo "selected";}?>><?php echo $value['name'];?></option>
          <?php //} ?>
          <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-6">
      <div class="form-group">
        <label>Effective From</label>
        <input type="text" class="form-control required" id="start_date" name="start_date" placeholder="Choose Start Date" value="<?php echo str_replace('-', '/', $terrif[0]['start_date']);?>"> 
      </div>
      
    </div>
    <div class="col-md-6">

      <div class="form-group">
        <label>Effective Till</label>
        <input type="text" class="form-control required" id="end_date" name="end_date" placeholder="Choose End Date" value="<?php echo str_replace('-', '/', $terrif[0]['end_date']);?>"> 
      </div>
      
    </div>
    <div class="col-md-6">
    <div class="form-group ">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-1 Description</label>
      <input type="text" name="class_1_desc"  value= '<?php echo $terrif[0]['class_1_description']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class1 description">
      
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-1 Rate</label>
      <input type="text" name="class_1_rate"  value= '<?php echo $terrif[0]['class_1_value']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class1 rate">
      
    </div>
  </div>
  
  <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-2 Description</label>
      <input type="text" name="class_2_desc"  value= '<?php echo $terrif[0]['class_2_description']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class2 description">
      
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-2 Rate</label>
      <input type="text" name="class_2_rate"  value= '<?php echo $terrif[0]['class_2_value']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class2 rate">
      
    
    </div>
  </div>
   <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-3 Description</label>
      <input type="text" name="class_3_desc"  value= '<?php echo $terrif[0]['class_3_description']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class3 description">
      </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-3 Rate</label>
      <input type="text" name="class_3_rate"  value= '<?php echo $terrif[0]['class_3_value']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class3 rate">
      </div>
    </div>
  
 
    <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-4 Description</label>
      <input type="text" name="class_4_desc"  value= '<?php echo $terrif[0]['class_4_description']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class4 description">
      </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-4 Rate</label>
      <input type="text" name="class_4_rate"  value= '<?php echo $terrif[0]['class_4_value']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class4 rate">
      </div>
    </div>
   
<div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-5 Description</label>
      <input type="text" name="class_5_desc"  value= '<?php echo $terrif[0]['class_5_description']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class5 description">
      </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-5 Rate</label>
      <input type="text" name="class_5_rate"  value= '<?php echo $terrif[0]['class_5_value']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class5 rate">
      </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Class-6 Description</label>
      <input type="text" name="class_6_desc"  value= '<?php echo $terrif[0]['class_6_description']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class6 description">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-6 Rate</label>
        <input type="text" name="class_6_rate"  value= '<?php echo $terrif[0]['class_6_value']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class6 rate">
        
      </div> 
  </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-7 Description</label>
        <input type="text" name="class_7_desc"  value= '<?php echo $terrif[0]['class_7_description']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class7 description">
      </div>    
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-7 Rate</label>
        <input type="text" name="class_7_rate"  value= '<?php echo $terrif[0]['class_7_value']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class7 rate">
      </div>    
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-8 Description</label>
        <input type="text" name="class_8_desc"  value= '<?php echo $terrif[0]['class_8_description']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class8 description">
      </div>  
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-8 Rate</label>
        <input type="text" name="class_8_rate"  value= '<?php echo $terrif[0]['class_8_value']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class8 rate">
      </div>    
    </div>
  
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-9 Description</label>
        <input type="text" name="class_9_desc"  value= '<?php echo $terrif[0]['class_9_description']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class9 description">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-9 Rate</label>
        <input type="text" name="class_9_rate"  value= '<?php echo $terrif[0]['class_9_value']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class9 rate">
        
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-10 Description</label>
        <input type="text" name="class_10_desc"  value= '<?php echo $terrif[0]['class_10_description']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class10 description">
        
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" style="font-weight: 900;">Class-10 Rate</label>
        <input type="text" name="class_10_rate"  value= '<?php echo $terrif[0]['class_10_value']?>'class="form-control required" id="exampleInputEmail1"  placeholder="Enter Class10 rate">
        
      </div>
    </div>

    <div class="col-md-12">
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('edit_terrif');">Update Tarrif</span>
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