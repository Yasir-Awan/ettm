<?php echo form_open(base_url() . "api/item_faulty/$id", array('id' => 'faulty')); ?>
<div class="form-group">
  <div class='row'>
    <div class='col-md-4'>
      <label for="example-text-input" class="col-form-label" data-original-title="" title="">Asset Name</label>
    </div>
    <div class="col-md-8">
      <span required="" style="margin-left:-45px;" class="form-control" value="" type="" name="asset_name" id="asset_name">
        <?php
        foreach ($data as $row) {
          echo $row[0]['name'] . ", ";
        } ?>
      </span>
    </div>
  </div>
  <br>
  <div class="form-group">
    <div class="row">
      <div class='col-md-3'>
        <label for="example-date-input" class="col-form-label">Item site</label>
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

  <div class="form-group">
    <div class='row'>
      <div class='col-md-3'>
        <label for="example-text-input" class="col-form-label" data-original-title="" title="">OMC Name</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-8'>
        <input type="text" class="form-control required" name="faulty_time_omc" id="omc_name" value="">
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="row">
      <div class='col-md-3'>
        <label for="example-date-input" class="col-form-label">Faulty Date</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-4'>
        <input type="text" class="form-control required" id="faulty_date" name="faulty_date" placeholder="Enter Faulty Date">
      </div>
      <div class='col-md-3'>
        <a style='line-height:45px;' class="clear-date-time" data-date-field="date-field" data-remote="true" href="#" data-original-title="" title="">Reset Date</a>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class='row'>
      <div class='col-md-3'>
        <label for="fixed_asset_price" data-original-title="" title="">Estimate Cost</label>
        <span class="asterisk" data-original-title="" title="">*</span>
      </div>
      <div class='col-md-4'>
        <input value="0.00" class="custom-select form-control " maxlength="13" step="0.01" min="0" size="13" type="text" name="est_cost" id="estimated_cost">
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
        <textarea rows="5" class="form-control" style="margin-left:-45px;" name="comments" id="faulty_comments"></textarea>
      </div>
    </div>


    <div class="form-group">
      <div class='row'>
        <!-- <input class="form-control" value="<?php echo implode(",", $repairs); ?>" type="hidden" name="asset_id" id="asset_id"> -->
        <input class="form-control" value="<?php echo $this->session->userdata("supervisor_id"); ?>" type="hidden" name="supervisor_id" id="supervisor_id">
        <input class="form-control" value="<?php echo $identification_no; ?>" type="hidden" name="identification_no" id="identification_no">
      </div>
    </div>

    <span class="btn btn-primary pull-right" onclick="api_form_submit('faulty');">Faulty</span>
    <?php echo form_close(); ?>

    <script>
      $(document).ready(function() {
        var endYear = new Date(new Date().getFullYear(), 11, 31);
        $("#faulty_date").datepicker({
          format: "yyyy-mm-dd",
          startDate: "2010-01-01",
          autoclose: true,
          endDate: endYear
        })
      });

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

      function api_form_submit(form_id, noty, e) {

        //alert(); return false;
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

              if (here.closest('div').find('.badge-danger').length) {

              } else {

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
          $.ajax({
            url: form.attr('action'), // form action url
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
    </script>