<?php echo form_open(base_url() . "supervisor_inventory/action_on_asset/start_repair_do/", array('id' => 'startrepair')); ?>

<div class="form-group">
  <div class='row'>
    <div class='col-md-4'>
      <label for="example-text-input" class="col-form-label" data-original-title="" title="">Asset Name</label>
    </div>
    <div class="col-md-8">
      <span required="" style="margin-left:-45px;" class="form-control" value="" type="" name="asset_name" id="asset_name"><?php

                                                                                                                            foreach ($data as $row) {
                                                                                                                              echo $row[0]['name'] . ", ";
                                                                                                                            } ?></span>
    </div>
  </div>
  <br>
  <div class="form-group">
    <div class="row">
      <div class='col-md-3'>
        <label for="example-date-input" class="col-form-label">Item site</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-4'>

        <?php foreach ($sites as $site) { ?>
          <input type="text" class="form-control required" name="site_name" id="site_name" placeholder="Select Asset Name" value="<?php echo $site['name']; ?>" readonly>
          <input type="hidden" class="form-control required" name="item_site" id="item_site" placeholder="Select Asset Name" value="<?php echo $site['id']; ?>">

        <?php } ?>

      </div>

      <div class='col-md-4' style="margin-left:-8px;">
        <?php foreach ($locations as $location) { ?>
          <input type="text" class="form-control required" name="location_name" id="location_name" placeholder="Select  Name" value="<?php echo $location['location']; ?>" readonly>
          <input type="hidden" class="form-control required" name="item_location" id="item_location" value="<?php echo $location['id']; ?>">
        <?php } ?>
      </div>

    </div>
  </div>


  <!-- <div class="form-group">
                <div class="row">
                <div class='col-md-4'>  
                  <label for="example-date-input" class="col-form-label">Item Location</label>
                  <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                
                </div>
              </div> -->

  <div class="form-group">
    <div class='row'>
      <div class='col-md-4'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">Available or Not</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-5'>
        <select class="form-control required" name="item_availability" id="item_availability" placeholder="Select Asset Name">
          <option value=""><?php echo "Select Option"; ?></option>
          <option value="1"><?php echo "Available"; ?></option>
          <option value="0"><?php echo "Dismental "; ?></option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class='row'>
      <div class='col-md-4'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">Repair Type</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-5'>
        <select class="form-control required" name="repair_type" id="repair_type" placeholder="Select Asset Name">
          <option value=""><?php echo "Select Option"; ?></option>
          <option value="1"><?php echo "Standard"; ?></option>
          <option value="2"><?php echo "Warranty"; ?></option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-group repair_cmpny">
    <div class='row'>
      <div class='col-md-4'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">Repairing Company</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-5'>
        <select class="form-control " name="repairing_company" id="repairing_company" placeholder="">
          <option value="">Select Repairing Company</option>
          <option value="1">TSP</option>
          <option value="2">Outsider/Other</option>
        </select>
      </div>
    </div>
  </div>



  <div class="form-group repairing_tsp" style='display:none;'>
    <div class='row'>
      <div class='col-md-4'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">Repairing TSP</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-5'>
        <select class="form-control " name="repairing_tsp" id="repairing_tsp" placeholder="Select Asset Name">
          <option value=""><?php echo "Select Option"; ?></option>
          <?php foreach ($tsps as $tsp) { ?>
            <option value="<?php echo $tsp['id'] ?>"><?php echo $tsp['name']; ?></option>
          <?php } ?>
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
      <div class='col-md-5'>
        <select class="form-control " name="tsp_person_type" id="tsp_person_type" placeholder="Select Asset Name">
          <option value=""><?php echo "Select Option"; ?></option>
          <option value="1"><?php echo "Admin"; ?></option>
          <option value="2"><?php echo "Member"; ?></option>
          <option value="3"><?php echo "Tollplaza Supervisor"; ?></option>
        </select>
      </div>
    </div>
  </div>


  <div class="form-group tsp_person" style="display:none;">
    <div class='row'>
      <div class='col-md-4'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Person</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-4'>
        <select class="form-control " name="tsp_person" id="tsp_person" placeholder="Select Asset Name">

        </select>

      </div>
    </div>
  </div>

  <div class="form-group tsp_person_contact" style="display:none;">
    <div class='row'>
      <div class='col-md-4'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">Person Contact</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-4'>
        <?php //$current_asset = $this->db->get_where('items',array('id' => $asset[0]['name']))->result_array(); 
        ?>

        <input type="text" class="form-control" name="tsp_person_contact" id="tsp_person_contact">

        </select>
      </div>
    </div>
  </div>


  <div class="form-group tsp_address" style="display:none;">
    <div class='row'>
      <div class='col-md-4'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">TSP Address</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-4'>
        <?php //$current_asset = $this->db->get_where('items',array('id' => $asset[0]['name']))->result_array(); 
        ?>

        <textarea rows="5" class="form-control" name="tsp_address" id="tsp_address"></textarea>

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
        <input class="form-control" type="text" name='outer_company_name' id='outer_company_name'>
      </div>
    </div>
  </div>



  <div class="form-group outer_company_address" style="display:none;">
    <div class='row'>
      <div class='col-md-4'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">Company Address</label>
      </div>
      <div class="col-md-5">
        <textarea rows="5" class="form-control" name="outer_company_address" id="outer_company_name"></textarea>
      </div>
    </div>
  </div>


  <div class="form-group outsider_name" style="display:none;">
    <div class="row">
      <div class='col-md-4'>
        <label for="example-date-input" class="col-form-label">Person Name</label>
      </div>
      <div class='col-md-5'>
        <input class="form-control " type="text" name='outsider_name'>
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
        <input class="form-control" type="text" name='outsider_contact'>
      </div>
      <!-- <div class='col-md-3'>
        <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
        </div> -->
    </div>
  </div>


  <div class="form-group">
    <div class="row">
      <div class='col-md-4'>
        <label for="example-date-input" class="col-form-label">Expected Completion</label>
      </div>
      <div class='col-md-4'>
        <input type="text" class="form-control required" id="expected_completion" name="expected_completion" placeholder="expected Date">
      </div>
      <div class='col-md-3'>
        <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class='row'>
      <div class='col-md-4'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">Comments</label>
      </div>
      <div class="col-md-8">
        <textarea rows="5" class="form-control" style="margin-left:-45px;" name="start_repair_reason" id="start_repair_comments"></textarea>
      </div>
    </div>


    <div class="form-group">
      <div class='row'>
        <input class="form-control" value="<?php echo $identification_no; ?>" type="hidden" name="identification_no" id="identification_no">
        <input class="form-control" value="<?php echo $supervisor_id; ?>" type="hidden" name="supervisor_id" id="identification_no">
      </div>
    </div>

    <span class="btn btn-primary pull-right" onclick="api_form_submit('startrepair');">Start Repairing</span>
    <?php echo form_close(); ?>

    <script>
      $(document).ready(function() {
        var endYear = new Date(new Date().getFullYear(), 11, 31);
        $("#expected_completion").datepicker({
          format: "yyyy-mm-dd",
          startDate: "2010-01-01",
          autoclose: true,
          endDate: endYear
        })
      });
    </script>
    <script>
      $('body').on('change', "#repair_type", function() {
        let repair_type = this.value;
        if (repair_type == 2) {
          $('.repair_cmpny').hide('slow');
        }
        if (repair_type == 1) {
          $('.repair_cmpny').show('slow');
        }
      });
    </script>
    <script>
      $('body').on('change', "#repairing_company", function() {
        var repair_company = this.value;
        //  console.log(issuance_type);
        if (repair_company == 1) {
          $('.outsider_contact').hide('slow');
          $('.outsider_name').hide('slow');
          $('.outer_company_address').hide('slow');
          $('.outer_company_name').hide('slow');
          $('.repairing_tsp').show('slow');
        } else {
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
      $('body').on('change', "#repairing_tsp", function() {
        // var tsp = this.value;
        $('.person_type').show('slow');
      });
      $('body').on('change', "#tsp_person_type", function() {
        var tsp = $('#repairing_tsp').val();

        var person_type = this.value;
        $.ajax({
          url: "<?php echo base_url() ?>supervisor_inventory/action_on_asset/repairing_tsp/" + tsp + "/" + person_type,
          cache: false,
          contentType: false,
          processData: false,
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
              $('#tsp_person').append('<option value="' + user.id + '">' + user.fname + ' ' + user.lname + '</option>');
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
      $('body').on('change', "#tsp_person_type", function() {
        var tsp = this.value;
        // $('.person_type').show('slow');   
      });
      $('body').on('change', "#tsp_person", function() {
        var tsp_person = this.value;
        var tsp = $('#tsp_person_type').val();

        //var person_type = this.value;
        $.ajax({
          url: "<?php echo base_url() ?>supervisor_inventory/action_on_asset/person_contact/" + tsp + "/" + tsp_person,
          cache: false,
          contentType: false,
          processData: false,
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

      function api_form_submit(form_id, noty, e) {
        var alerta = $('#form'); // alert div for show alert message
        var form = $('#' + form_id);
        //alert(form_id); return false;
        var can = '';
        if (!extra) {
          var extra = '';
        }
        form.find('.summernotes').each(function() {
          var now = $(this);
          now.closest('div').find('.val').val(now.code());
        });

        //var form = $(this);
        var formdata = false;
        if (window.FormData) {
          formdata = new FormData(form[0]);
        }

        var a = 0;
        var req = 'This field required';
        var take = '';
        form.find(".required").each(function() {
          var txt = '*' + req;
          a++;
          if (a == 1) {
            take = 'scroll';
          }
          var here = $(this);
          if (here.val() == '') {
            if (!here.is('select')) {
              here.css({
                borderColor: 'red'
              });
              if (here.attr('type') == 'number') {
                txt = '*This field required';
              }

              if (here.closest('div').find('.badge-danger').length) {} else {
                here.closest('div').append('' +
                  '  <span id="' + take + '" class="badge badge-danger" >' +
                  '      ' + txt +
                  '  </span>'
                );
              }
            } else if (here.is('select')) {
              here.closest('div').find('.chosen-single').css({
                borderColor: 'red'
              });
              if (here.closest('div').find('.require_alert').length) {

              } else {
                here.closest('div').append('' +
                  '  <span id="' + take + '" class="badge badge-danger" >' +
                  '      *Required' +
                  '  </span>'
                );
              }
            }
            var topp = 100;
            if (form_id == 'product_add' || form_id == 'product_edit') {} else {
              $('html, body').animate({
                // scrollTop: $("#scroll").offset().top - topp
              }, 500);
            }
            can = 'no';
          }

          if (here.attr('type') == 'email') {
            if (!isValidEmailAddress(here.val())) {
              here.css({
                borderColor: 'red'
              });
              if (here.closest('div').find('.badge-valid').length) {

              } else {

                here.closest('div').append('' +
                  '  <span id="' + take + '" class="badge badge-danger badge-valid" >' +
                  '      *Enter valid Email' +
                  '  </span>'
                );
              }
              can = 'no';
            }
          }

          take = '';
        });

        if (can !== 'no') {
          let api_path;
          let repair_type = document.getElementById("repair_type").value;
          if (repair_type == 1) {
            let repair_company = document.getElementById("repairing_company").value;
            if (repair_company == 1) {
              api_path = '<?php echo base_url(); ?>api/item_repair_standard/1';
            }
            if (repair_company == 2) {
              api_path = '<?php echo base_url(); ?>api/item_repair_standard/2';
            }
          }
          if (repair_type == 2) {
            api_path = '<?php echo base_url(); ?>api/item_repair_warranty';
          }


          $.ajax({
            // url: form.attr('action'), // form action url
            url: api_path, // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: formdata ? formdata : form.serialize(), // serialize form data 
            cache: false,
            contentType: false,
            processData: false,
            async: true,
            beforeSend: function(xhr) {
              xhr.setRequestHeader('Authorization', 'Bearer <?php echo $this->session->userdata("access_token"); ?>');
              var buttonp = $('.enterer');
              buttonp.removeClass('enabled');
              buttonp.addClass('disabled');
              buttonp.html('working');
            },
            success: function(data) {
              var obj = JSON.parse(data);


              if (!obj.response) {
                var buttonp = $('.enterer');
                buttonp.removeClass('disabled');
                buttonp.addClass('enabled');
                buttonp.html('Search');
                notify(obj.message, 'danger', 'top', 'right');

              } else {
                var buttonp = $('.enterer');
                buttonp.removeClass('disabled');
                buttonp.addClass('enabled');
                buttonp.html('Search');
                notify(obj.message, 'success', 'top', 'right');
                if (obj.is_redirect) {
                  setTimeout(function() {
                    top.location.href = obj.redirect_url;
                  }, 800);
                  return false;
                }
              }


            },
            error: function(e) {
              console.log(e)
            }
          });

          //  else {

          // 	//form.html('fff');
          // 	form.submit();
          // 	//alert('ff');
          // 	return false;
          // }
        } else {

          if (form_id == 'product_add' || form_id == 'product_edit') {
            var ih = $('.require_alert').last().closest('.tab-pane').attr('id');
            $("[href=#" + ih + "]").click();
          }
          //$('body').scrollTo('#scroll');
          return false;
        }
      }

      function notify(message, type, from, align) {
        $.notify({
          message: message
        }, {
          // settings
          type: type,
          placement: {
            from: from,
            align: align
          }
        });
      }
    </script>