<?php echo form_open(base_url()."inventory/action_on_asset/install_do/",array('id' => 'install'));?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Asset Name</label>
             </div>
             <div class="col-md-7">
              <span required="" class="form-control" value="" 
               type="" name="asset_name" id="asset_name"><?php 
             foreach($data as $row) 
             {  echo $row[0]['name'].", "; } ?></span>
             </div>
          </div>

          <div class="form-group" >
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Equipment Serial #</label>
                    </div>
                    <div class='col-md-7' >
                    <input class="form-control" type="text" name='equip_serial' placeholder="Enter Serial No" value="<?php echo $data1[0]['serial_no']; ?>">
                    <!-- <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo $row['id']; ?>"> -->
                    </div>
                   </div>
              

          <?php if(!empty($data2)){
            $counterr=0;
            foreach($data2 as $row){
               ?>
                  <div class='row'>
                  <?php if(!empty($alreadyGivenSerialNo[$counterr])){ ?>
                    <div class='col-md-3' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title=""><?php echo $row[0]['name']; ?></label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4' >
                    <input class="form-control" type="text" name='comp_serial[]' placeholder="Enter Serial No" value="<?php echo $alreadyGivenSerialNo[$counterr]['comp_serial']; ?>" >
                    <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo $row['id']; ?>" >
                    </div>
                    <div class='col-md-4' >
                    <input class="form-control" type="text" name='comp_model[]' placeholder="Enter Model No" value="<?php echo $alreadyGivenSerialNo[$counterr]['comp_model_no']; ?>" >
                    </div>
                    <?php } ?>
                   </div>
              
            <?php 
            $counterr++;
                  }
                }
            ?>

             <div class='row'>
                <div class='col-md-3'>
                <label class="col-form-label" data-original-title="" title="">Site</label>
                </div>
                <div class='col-md-8' >
                <span style="padding-left:17%;"><?php echo $sites[0]['name']; ?></span>
            <input type="hidden" class="form-control required" name="site_id" id="site_id" value="<?php echo $sites[0]['id'] ?>" >
                </div>
              </div>
            
          
      <div class="row installing_location" style="display:none;">
      <label style="font-weight: 900;padding-left:2%; margin-top:12px;">Location</label>
      <span class="asterisk" data-original-title="" title="">*</span>
      <select name="location[]"  class="form-control required"  data-placeholder="Choose Location" tabindex="-1" data-hide-disabled="true" id="site_locations" style="margin-left:25.5%; width: 54.5%; ">
      </select>
    </div>


        <div class='row'>
          <div class='col-md-4'>
          <label for="example-text-input" class="col-form-label" data-original-title="" title="">Installing Company</label>
          <span class="asterisk" data-original-title="" title="">*</span>
          </div>
          <div class='col-md-7' >
          <select class="form-control " name="repairing_company" id="repairing_company" placeholder="" >
          <option value="">Select Installing Company</option>
          <option value="1" >TSP</option>
          <option value="2" >Outsider/Other</option>
          </select>
          </div>
        </div>
      


             <div class='row repairing_tsp' style='display:none;'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Name</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <select class="form-control " name="repairing_tsp" id="repairing_tsp" placeholder="Select Asset Name" >
                        <option value=""><?php echo "Select TSP Name";?></option>
                <?php foreach($tsps as $tsp){?>
                    <option value="<?php echo $tsp['id'] ?>"><?php echo $tsp['name'];?></option>
                    <?php } ?> 
                </select>
                </div>
              </div>


                  <div class='row tsp_address' style="display:none;">
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Address</label>
                    </div>
                    <div class='col-md-7' >
                    <textarea rows="5"  class="form-control" style="" name="tsp_address" id="tsp_address" readonly ></textarea>
                    </div>
                   </div>
         

             <div class='row person_type' style='display:none;'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Person Type</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <select class="form-control " name="tsp_person_type" id="tsp_person_type" placeholder="Select Asset Name" >
                        <option value=""><?php echo "Select Person Type";?></option>
                        <option value="1">Admin</option>
                        <option value="2">Member</option>
                        <option value="3">Supervisor</option>
                </select>
                </div>
              </div>

                  <div class='row tsp_person' style="display:none;">
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Person</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-7' >
                    <select class="form-control " name="tsp_person" id="tsp_person" placeholder="Select Asset Name" >
                    </select>
                    </div>
                   </div>

                  <div class='row tsp_person_contact' style="display:none;">
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Person Contact</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-7' >                    
                    <input type="text"  class="form-control" style="" name="tsp_person_contact" id="tsp_person_contact">
                    </div>
                   </div>

          <div class='row outer_company_name' style="display:none;">
             <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Company Name</label>
             </div>
             <div class="col-md-7">
                <input class="form-control" type="text" name='outer_company_name' id='outer_company_name' value="" >  
             </div>
          </div>
           
          <div class='row outer_company_address' style="display:none;">
             <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Company Address</label>
             </div>
             <div class="col-md-7">
                <textarea rows="5"  class="form-control" style="" name="outer_company_address" id="outer_company_name"></textarea>
             </div>
          </div>

                      <div class="row outsider_name" style="display:none;">
                         <div class='col-md-4'>  
                            <label for="example-date-input" class="col-form-label">Person Name</label>
                         </div>
                         <div class='col-md-7'>
                            <input class="form-control " type="text" name='outsider_name' value="">  
                         </div>
                       </div>


                      <div class="row outsider_contact" style="display:none;">
                         <div class='col-md-4'>  
                            <label for="example-date-input" class="col-form-label">Person Contact</label>
                         </div>
                         <div class='col-md-7'>
                            <input class="form-control" type="text" name='outsider_contact' value="" >  
                         </div>
                       </div>

          <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Installing Cost</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-7">
             <input class="form-control" type="text" name='cost' value="" >
             </div>
          </div>

          <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Comments</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-7">
             <textarea rows="5"  class="form-control" name="install_comments" id="install_comments"></textarea>
             </div>
          </div>
           <br>
         <div class="form-group">
          <div class='row'>
            <input class="form-control" value="<?php echo implode(",",$installs);?>" 
               type="hidden" name="asset_id" id="asset_id">
          </div>
          </div>

        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('install');">Install</button>
          <?php echo form_close();?>

          <script>
          $(document).ready(function() {
            var site_id = document.getElementById("site_id").value;
             $.ajax({ 
              url: "<?php echo base_url();?>inventory/site_related_locations/"+site_id,
              cache       : false,
              contentType : false,
              processData : false,
              success: function(data) {
                  locations = JSON.parse(data);
                  console.log(locations);
                  $('.installing_location').show('slow');
                  $('#site_locations').show();
                  $('#site_locations').empty().append('<option value="">Choose Location</option>');
                  locations.forEach(loc => {
                  $('#site_locations').append('<option value="'+loc.id+'">'+ loc.location + '</option>');
                  })
                },
              error: function(e) { }
          });
     });

      $('body').on('change', "#repairing_company", function (){    
        var repair_company = this.value;
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

        $('body').on('change', "#repairing_tsp", function (){
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
            tsps = JSON.parse(data);
            console.log(tsps);
              $('.tsp_address').show('slow');
              $('#tsp_address').html(tsps.address);
              $('.tsp_person').show('slow');
              $('#tsp_person').empty().append('<option value="">Choose Option</option>');
              tsps.person_names.forEach(user => {
              $('#tsp_person').append('<option value="'+user.id+'">'+ user.fname + ' ' + user.lname +'</option>');
              });                                
            },
          error: function(e) { }
        });
      });

        $('body').on('change', "#tsp_person_type", function (){ 
               var tsp = this.value;  
          });
        $('body').on('change', "#tsp_person", function (){ 
          var tsp_person = this.value;
          var tsp = $('#tsp_person_type').val();
             $.ajax({ 
              url: "<?php echo base_url() ?>inventory/action_on_asset/person_contact/"+tsp+"/"+tsp_person,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                var top = '200';
              },
              success: function(data) {
                person_contact = JSON.parse(data);
                console.log(person_contact);
                  $('.tsp_person_contact').show('slow'); 
                  $('#tsp_person_contact').val(person_contact.contact);       
                },
              error: function(e) { }
            });
          });
</script>