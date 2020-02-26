<?php echo form_open(base_url()."member_inventory/action_on_asset/checkout_do/",array('id' => 'checkout'));?>     
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Asset Name</label>
             </div>
             <div class="col-md-5">
             <span rows="auto" class="form-control fluid" style="padding:unset; height:auto;" name="" id="">
             <?php 
             foreach($data as $row) 
             {  echo $row[0]['name'].", "; } ?>
             </span>
             </div>
          </div>
          <br>

          <div class="form-group">
                  <div class='row'>
                    <div class='col-md-4'>
                    <label  class="col-form-label" data-original-title="" title="">Checkout Site</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-5'>
                    <select class="form-control required" name="checkout_site" id="checkout_site">
                    <?php foreach($sites as $site){?>
                    <option value="<?php echo $site['id'] ?>"><?php echo $site['name'];?></option>
                    <?php } ?>
                    </select>
                    </div>
                    <div class='col-md-3 pull-left' style="">
                    <button type="button" style="background-color: transparent;margin-left: -20px; color: blue;border: none;" class="btn btn-primary" data-toggle="modal" data-target="#modal-b">Add</button>  
                    </div>
                  </div>
            </div>
          <br>

          <div class="form-group">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Person Type</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-5' >
                <select class="form-control required" name="user_role" id="employeetype" placeholder="Select Asset Name" >
                <option value="">Select Employee Role</option>
                <option value="1" >Admin</option>
                <option value="2" >Member</option>
                <option value="3" >Supervisor</option> 
                </select>
                </div>
              </div>
            </div>
                                          
                  <div class="form-group checkout_to" style="display:none;">
                  <div class='row'>
                    <div class='col-md-4' >
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Checkout To</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-4' >
                    <?php //$current_asset = $this->db->get_where('items',array('id' => $asset[0]['name']))->result_array(); ?>
                    <select class="form-control required" name="role" id="role" placeholder="Select Employee Role">
                    <!-- <option value="<?php// echo $current_asset[0]['id'];?>"><?php// echo $current_asset[0]['name'];?></option>
                    <?php// foreach($items as $item){?>
                    <option value="<?php // echo $item['id'] ?>"><?php// echo $item['name'];?></option>
                    <?php //} ?> -->
                    </select>
                    </div>
                   </div>
                </div>
                

          <div class="form-group">
                      <div class="row">
                         <div class='col-md-4'>  
                         <label for="example-date-input" class="col-form-label">Person Contact</label>
                         </div>
                         <div class='col-md-5'>
                         <input class="form-control required" type="text" name='person_contact'>  
                         </div>
                         <!-- <div class='col-md-3'>
                         <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                         </div> -->
                       </div>
                     </div>
          
          <div class="form-group">
          <div class='row'>
          <input class="form-control" value="<?php echo implode(",",$checkouts);?>" 
               type="hidden" name="asset_id" id="asset_id">
         
          </div>
          <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Reason</label>
             </div>
             <div class="col-md-5">
             <textarea rows="5"  class="form-control required" style="" name="checkout_reason" id="checkout_reason"></textarea>
             </div>
          </div>
           <br>

           <div class="form-group">
             <div class='row'>
                <div class='col-md-4'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Issuance Type</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class='col-md-5' >
                <select class="form-control " name="issuance_type" id="issuance_type" placeholder="Select the option" >
                <option value="">Select issuance type</option>
                <option value="1" >Permanent</option>
                <option value="2" >Temporary</option>
                </select>
                </div>
              </div>
            </div>

           <div class="form-group return_date" style="display:none;">
                      <div class="row">
                         <div class='col-md-4'>  
                         <label for="example-date-input" class="col-form-label">Return Date</label>
                         </div>
                         <div class='col-md-5'>
                         <input class="form-control" type="date" name='return_date' value="" id="example-date-input">  
                         </div>
                         <div class='col-md-3'>
                         <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
                         </div>
                       </div>
                     </div>
                     <br>


        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('checkout');">Check Out</button>
          <?php echo form_close();?>


          <script>
           $('body').on('change', "#employeetype", function (){    
            var userRole = this.value;
             $.ajax({ 
              url: "<?php echo base_url() ?>member_inventory/action_on_asset/change_role/"+userRole,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                var top = '200';
                $('#role').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
              },
              success: function(data) {
                // alert(data);
                  users = JSON.parse(data);
                  $('.checkout_to').show('slow');
                  users.forEach(user => {
                  $('#role').append('<option value="'+user.id+'">'+ user.fname + ' ' + user.lname +'</option>');
                  });                
                },
              error: function(e) {
              //  console.log(e)
              }
          });
        });
        </script>

        <script>
           $('body').on('change', "#issuance_type", function (){    
             var issuance_type = this.value;
            //  console.log(issuance_type);
            if( issuance_type == 1)
            {
              $('.return_date').hide('slow');
            }
            else
            {
               $('.return_date').show('slow');
            }     
          });
        </script>