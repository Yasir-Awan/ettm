<?php echo form_open(base_url()."supervisor_inventory/action_on_asset/end_repair_do/",array('id' => 'endrepair'));?>
                 <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Asset Name</label>
             </div>
             <div class="col-md-8">
              <span required="" style="margin-left:-45px;" class="form-control" value="" 
               type="" name="asset_name" id="asset_name"><?php 
             foreach($data as $row) 
             {  echo $row[0]['name'].", "; } ?></span>
             </div>
          </div>
         <br>

         <div class="form-group">
                <div class="row">
                <div class='col-md-3'>  
                  <label for="example-date-input" class="col-form-label">Item site</label>
                </div>
                <div class='col-md-4' style="margin-left:-8px;">
                    <!-- <option value=""><?php echo "Select Option";?></option> -->
                    <?php foreach($sites as $site) {?>
                      <input type="text" class="form-control required" name="site_name" id="site_name" placeholder="Select Asset Name" value="<?php echo $site['name'];?>" readonly >
                      <input type="hidden" class="form-control required" name="item_site" id="item_site" placeholder="Select Asset Name" value="<?php echo $site['id'];?>" >
                    <?php } ?>
               
                </div>
                <div class='col-md-5' style="margin-left:-26px;">
                    <?php foreach($locations as $location) {?>
                      <input type="text" class="form-control required" name="location_name" id="location_name" placeholder="Select  Name" value="<?php echo $location['location'];?>" readonly >
                      <input type="hidden" class="form-control required" name="item_location" id="item_location"  value="<?php echo $location['id'];?>" >
                    <?php } ?>
                
                </div>
              </div>
              <br>

          <div class="form-group">
                <div class="row">
                <div class='col-md-3'>  
                  <label for="example-date-input" class="col-form-label">Repaired At</label>
                  <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-4'>
                <input type="text" class="form-control required" id="repair_completion" name="repair_completion" placeholder="Repair Date">
                </div>
                <div class='col-md-5'>
                  <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                </div>
                </div>
              </div>

              <div class="form-group">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label for="fixed_asset_price" data-original-title="" title="">Repair Cost</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4'>
                    <input value="0.00"  class="custom-select form-control " maxlength="13" step="0.01" min="0" size="13" type="number" name="repair_price" id="repair_price">
                    </div>
                  </div>
                </div>  


          <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Comments</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="end_repair_comments" id="start_repair_comments"></textarea>
             </div>
          </div> 
           <br>

        <div class="form-group">
          <div class='row'>
            <input class="form-control" value="<?php echo implode(",",$end_repairs);?>" 
               type="hidden" name="asset_id" id="asset_id">
          </div>
       </div>

      

       <!-- <div class="form-group">
          <div class='row'>
            <input class="form-control" value="<?php echo implode(",",$locations); ?>" 
               type="hidden" name="selected_locations" id="selectd_locations">
          </div>
       </div> -->

       <div class="form-group">
          <div class='row'>
            <input class="form-control" value="<?php echo $quantity;?>" 
               type="hidden" name="quantity" id="qty">
          </div>
       </div>
          
<span class="btn btn-primary pull-right" onclick="form_submit('endrepair');">Reinstall</span>
          <?php echo form_close();?>

<script>
        $(document).ready(function(){
          var endYear = new Date(new Date().getFullYear(), 11, 31);
          $("#repair_completion").datepicker({
            format: "yyyy-mm-dd",
            startDate: "2010-01-01",
            autoclose: true,
            endDate: endYear            
          })
        });
</script>
<!-- <script>
      $('body').on('change', "#repairing_company", function (){    
        var repair_company = this.value;
        //  console.log(issuance_type);
        if( repair_company == 1)
        {
          $('.outsider_contact').hide('slow');
          $('.outsider_name').hide('slow');
          $('.outer_company_address').hide('slow');
          $('.outer_company_name').hide('slow');
          $('.repairing_tsp').show('slow');
        }
        else
        {
          $('.tsp_address').hide('slow');
          $('.tsp_person_contact').hide('slow');
          $('.tsp_person').hide('slow');
          $('.person_type').hide('slow');
          $('.repairing_tsp').hide('slow');
          $('.outer_company_name').show('slow');
          $('.outer_company_address').show('slow');
          $('.outsider_name').show('slow');
          $('.outsider_contact').show('slow');
        }     
      });
</script> -->


<!-- <script>
           $('body').on('change', "#repairing_tsp", function (){ 
            // var tsp = this.value;
            $('.person_type').show('slow');             
           });
        $('body').on('change', "#tsp_person_type", function (){ 
          var tsp = $('#repairing_tsp').val();
          
              var person_type = this.value;
             $.ajax({ 
              url: "<?php echo base_url() ?>inventory/action_on_asset/repairing_tsp/"+tsp+"/"+person_type,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                var top = '200';
               
              },
              success: function(data) {
                // alert(data);
                tsps = JSON.parse(data);
                console.log(tsps);
                  $('.tsp_address').show('slow');
                  $('#tsp_address').html(tsps.address);
                  $('.tsp_person').show('slow');
                  $('#tsp_person').empty().append('<option value="">Choose Option</option>');
                  tsps.person_names.forEach(user => {
                  $('#tsp_person').append('<option value="'+user.id+'">'+ user.fname + ' ' + user.lname +'</option>');
                  });  
                 
                 
                  // $('.tsp_person').show('slow');
                  // $('#tsp_person').val(tsps.person_name);
                  // $('.tsp_person_contact').show('slow');
                  // $('#tsp_person_contact').val(tsps.person_contact);
                              
                },
              error: function(e) {
              //  console.log(e)
              }
            });
          });
</script> -->

<!-- <script>
        $('body').on('change', "#tsp_person_type", function (){ 
               var tsp = this.value;
             // $('.person_type').show('slow');   
          });
        $('body').on('change', "#tsp_person", function (){ 
          var tsp_person = this.value;
          var tsp = $('#tsp_person_type').val();
          
            //var person_type = this.value;
             $.ajax({ 
              url: "<?php echo base_url() ?>inventory/action_on_asset/person_contact/"+tsp+"/"+tsp_person,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                var top = '200';
               
              },
              success: function(data) {
                // alert(data);
                person_contact = JSON.parse(data);
                console.log(person_contact);
                 
                  $('.tsp_person_contact').show('slow'); 
                  $('#tsp_person_contact').val(person_contact.contact);
                            
                },
              error: function(e) {
              //  console.log(e)
              }
            });
          });
</script> -->