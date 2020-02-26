<?php echo form_open(base_url()."inventory/action_on_asset/install_do/",array('id' => 'install'));?>
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

          <div class="form-group" >
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Equipment Serial #</label>
                    </div>
                    <div class='col-md-7' >
                    <input class="form-control" type="text" name='equip_serial' placeholder="Enter Serial No" value="">
                    <!-- <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo $row['id']; ?>"> -->
                    </div>
                   </div>
              </div>


          <?php if(!empty($data2)){
            foreach($data2 as $row){
            //  if($row['same']==0){ 
               ?>
          <div class="form-group" >
                  <div class='row'>
                    <div class='col-md-3' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title=""><?php echo $row['name']; ?></label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4' >
                    <input class="form-control" type="text" name='comp_serial[]' placeholder="Enter Serial No" value="" >
                    <input class="form-control" type="hidden" name='subitem_id[]' value="<?php echo $row['id']; ?>" >
                    </div>
                    <div class='col-md-4' >
                    <input class="form-control" type="text" name='comp_model[]' placeholder="Enter Model No" value="" >
                    </div>
                   </div>
              </div>
            <?php 
            //  }
            }
          } ?>
          
          <!-- <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Custody Of</label>
             </div>
             <div class="col-md-8">
              <span required="required" style="margin-left:-45px;" class="form-control" value="" 
               type="text" name="custdy_of" id="custody_of">
               <?php 
             foreach($data1 as $row) 
             {  echo $row[0]['checkout_to'].", "; } ?>
               </span>
             </div>
          </div> -->
          

          <div class="form-group">
             <div class='row'>
                <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Site</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-8' >
                <select class="form-control required" name="site_id" id="site_id" placeholder="Select Asset Name" >
                <?php foreach($sites as $site){?>
                    <option value="<?php echo $site['id'] ?>"><?php echo $site['name'];?></option>
                    <?php } ?> 
                </select>
                </div>
              </div>
            </div>
          
          <div class="form-group installing_location" style="display:none;">
      <label for="exampleInputEmail1" style="font-weight: 900;">Location</label>
      <select name="location[]"  class="form-control required"  data-placeholder="Choose Location" tabindex="-1" data-hide-disabled="true" id="site_locations" style="margin-left:35%; width: 56%;">
      <!-- <option value="">Choose Option</option> -->
      </select>

    </div>
            <div class="form-group">
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
            </div>

            <div class="form-group repairing_tsp" style='display:none;'>
             <div class='row'>
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
            </div>

            <div class="form-group tsp_address" style="display:none;">
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Address</label>
                    </div>
                    <div class='col-md-7' >
                    <?php //$current_asset = $this->db->get_where('items',array('id' => $asset[0]['name']))->result_array(); ?>
                    
                    <textarea rows="5"  class="form-control" style="" name="tsp_address" id="tsp_address" readonly ></textarea>
                    <!-- <option value="<?php// echo $current_asset[0]['id'];?>"><?php// echo $current_asset[0]['name'];?></option>
                    <?php// foreach($items as $item){?>
                    <option value="<?php // echo $item['id'] ?>"><?php// echo $item['name'];?></option>
                    <?php //} ?> -->
                    </select>
                    </div>
                   </div>
              </div>

            <div class="form-group person_type" style='display:none;'>
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Person Type</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-7' >
                <select class="form-control " name="tsp_person_type" id="tsp_person_type" placeholder="Select Asset Name" >
                        <option value=""><?php echo "Select Person Type";?></option>
                    <option value="1"><?php echo "Admin";?></option>
                    <option value="2"><?php echo "Member";?></option>
                    <option value="3"><?php echo "Tollplaza Supervisor";?></option>
                </select>
                </div>
              </div>
            </div>

            <div class="form-group tsp_person" style="display:none;">
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Person</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-7' >
                    <select class="form-control " name="tsp_person" id="tsp_person" placeholder="Select Asset Name" >
                        
                    </select>
                    
                    </div>
                   </div>
              </div>

              <div class="form-group tsp_person_contact" style="display:none;">
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Person Contact</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-7' >
                    <?php //$current_asset = $this->db->get_where('items',array('id' => $asset[0]['name']))->result_array(); ?>
                    
                    <input type="text"  class="form-control" style="" name="tsp_person_contact" id="tsp_person_contact">
                    <!-- <option value="<?php// echo $current_asset[0]['id'];?>"><?php// echo $current_asset[0]['name'];?></option>
                    <?php// foreach($items as $item){?>
                    <option value="<?php // echo $item['id'] ?>"><?php// echo $item['name'];?></option>
                    <?php //} ?> -->
                    </select>
                    </div>
                   </div>
              </div>


              <div class="form-group outer_company_name" style="display:none;">
          <div class='row'>
             <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Company Name</label>
             </div>
             <div class="col-md-5">
                <input class="form-control" type="text" name='outer_company_name' id='outer_company_name' value="" >  
             </div>
          </div>
          </div>
           
         <div class="form-group outer_company_address" style="display:none;">
          <div class='row'>
             <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Company Address</label>
             </div>
             <div class="col-md-5">
                <textarea rows="5"  class="form-control" style="" name="outer_company_address" id="outer_company_name"></textarea>
             </div>
          </div>
          </div>


            <div class="form-group outsider_name" style="display:none;">
                      <div class="row">
                         <div class='col-md-4'>  
                            <label for="example-date-input" class="col-form-label">Person Name</label>
                         </div>
                         <div class='col-md-5'>
                            <input class="form-control " type="text" name='outsider_name' value="">  
                         </div>
                         <!-- <div class='col-md-3'>
                         <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                         </div> -->
                       </div>
              </div>


            <div class="form-group outsider_contact" style="display:none;">
                      <div class="row">
                         <div class='col-md-4'>  
                            <label for="example-date-input" class="col-form-label">Person Contact</label>
                         </div>
                         <div class='col-md-5'>
                            <input class="form-control" type="text" name='outsider_contact' value="" >  
                         </div>
                         <!-- <div class='col-md-3'>
                         <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                         </div> -->
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
          <br>

          <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Comments</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-8">
             <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="install_comments" id="install_comments"></textarea>
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
           $('body').on('change', "#site_id", function (){    
            var site_id = this.value;
             $.ajax({ 
              url: "<?php echo base_url();?>inventory/site_related_locations/"+site_id,
              cache       : false,
              contentType : false,
              processData : false,
              // beforeSend: function() {
              //    var top = '200';
              //    $('#location').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
              // },
              success: function(data) {
                //  alert(data);
                  locations = JSON.parse(data);
                  console.log(locations);
                  // $('.installing_location').hide('slow');
                  $('.installing_location').show('slow');
                  $('#site_locations').show();
                  // $('#site_locations').append(locations);
                  
                  $('#site_locations').empty().append('<option value="">Choose Option</option>');
                  locations.forEach(loc => {
                  $('#site_locations').append('<option value="'+loc.id+'">'+ loc.location + '</option>');
                  })
                  
                },
              error: function(e) {
              //  console.log(e)
              }
          });
        });
        </script>
<script>
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
</script>


<script>
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
</script>

<script>
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
</script>
<script>
// $(document).ready(function() {
//   $(".demo-cs-multiselect").chosen();

//   $(".demo-cs-multiselect").on("change", function() {
//     let chosenVal = $(".demo-cs-multiselect").val();
//     $("#out").text(chosenVal);
//   });
// });
    // $(document).ready(function() {
    // $('.chosen-container').chosen();
    // $('.cs-multiselect').chosen({width:'100%'});
    //  });
  </script>