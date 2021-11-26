<div class="table-responsive hide_div">
  <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
    <div class="row">
      <div class="col-sm-12 pl-1 pr-1">
        <!-- Add Assets & Action Button Start -->

        <div class='row mb-1 mt-1'>
          <div class='col-md-4'>
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
              <button type="button" class="btn btn-primary btn-sm" style='line-height: 0.5;' name="submit">Action</button>
              <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" style='line-height: 0.5;' class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu" id="action_btn" aria-labelledby="btnGroupDrop1">
                  <a class="dropdown-item submit" href="#" value="Faulty" data-toggle="modal" data-target="#assets_faulty" onclick="ajax_html_cust('<?php echo base_url() ?>inventory/action_on_asset/faulty/','start_faulty_assets');">Faulty</a>
                  <a class="dropdown-item submit" href="#" value="Repair" data-toggle="modal" data-target="#assets_repair" onclick="ajax_html_cust('<?php echo base_url() ?>inventory/action_on_asset/start_repair/','start_repair_assets');">Repair</a>
                  <a class="dropdown-item submit" href="#" value="Repair" data-toggle="modal" data-target="#assets_end_repair" onclick="ajax_html_cust('<?php echo base_url() ?>inventory/action_on_asset/end_repair/','end_repair_assets');">Reinstall</a>
                  <a class="dropdown-item submit" href="#" value="Retire" data-toggle="modal" data-target="#assets_retire" onclick="ajax_html_cust('<?php echo base_url() ?>inventory/action_on_asset/retire/','retire_asset_contents');"> Retire</a>
                </div>
              </div>
            </div>
          </div><!-- col-md-4 END -->

          <div class="col-md-4" style="padding:unset;">
            <!-- <select class="form-control required pull-left" name="installfilter" id="installfilter" style="content: none;">
              <option value="0">Filter By</option>
              <option value="2">Site</option>
            </select> -->
          </div><!-- col-md-2 END -->
          <div class="col-md-2 blankdiv" style="display:none;">
          </div>
          <div class="col-md-2 installed_by_site" style="display:none; padding: unset;">
            <!-- <select class="form-control required" id="installedsite">
              <option value="">Choose Type</option>
              <?php foreach ($sites as $site) { ?>
                <option value="<?php echo $site['id'] ?>"><?php echo $site['name'] ?></option>
              <?php } ?>
            </select> -->
          </div>
          <!-- col-md-2 END -->

          <div class='col-md-4' style='width:auto;'>

          </div><!-- col-md-4 END -->
        </div><!-- row END -->
        <!-- Add Assets & Action Button END -->
        <table class="table table-bordered dataTable" id="installed_items_table" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width:auto;">
          <thead>
            <tr role="row">
              <th class="sorting_desc" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" aria-sort="descending" aria-label="counter: activate to sort column ascending" style="width: auto;">SR #</th>
              <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" style="width: auto;">Name</th>
              <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" style="width: auto;">Serial No</th>
              <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" style="width: auto;">Id #</th>
              <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" style="width: auto;">Status</th>
              <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" style="width: auto;">Site</th>
              <th class="sorting" tabindex="0" aria-controls="installed_items_table" rowspan="1" colspan="1" style="width: auto;">Location</th>
            </tr>
          </thead>

        </table>
      </div><!-- col-sm-12 END -->
    </div><!-- row END -->

  </div><!-- dataTable wrapper END -->
</div>
<!-- <div id='display_selected_install' style="display:none;"></div> -->
<div class="modal fade" id="inventoryModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title">Equpment Detail</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="display_selected_install">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id='display_install_history' style="display:none;">
</div>


<div id="divResult">
</div>

<!-- <div id='item_type_filter' class ="item_type_filter"></div> -->



<!--**********************************************************-->
<!--******************* MODAL WINDOWS START ******************-->
<!--**********************************************************-->

<!-- Modal for Edit Asset START -->
<div class="modal fade" id="assets-edit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Asset</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="edit_asset_contents">
        </div>
      </div>

    </div>
  </div>
</div>
<!-- Modal for Edit Asset END -->

<!-- Modal for Edit Asset START -->
<div class="modal fade" id="clone" style="margin-left:2%;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Clone</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="clone_contents">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal for Edit Asset END -->
<div id="result"></div>
<!-- Modal for Retire  START -->
<div class="modal fade" id="assets_retire">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Retire </h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="retire_asset_contents">
        </div>
      </div>
    </div>
  </div>
</div><!-- Modal for Retire END -->

<!-- Modal for Repair START -->
<div class="modal fade" id="assets_repair">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Start Repairing</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="start_repair_assets">
        </div>
      </div>
    </div>
  </div>
</div><!-- Modal for start Repairing END -->

<!-- Modal for Faulty START -->
<div class="modal fade" id="assets_faulty">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Equipment Faulty</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="start_faulty_assets">

        </div>
      </div>
    </div>
  </div>
</div><!-- Modal for Faulty END -->

<!-- Modal for End Repair START -->
<div class="modal fade" id="assets_end_repair">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Repair Complete</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div id="end_repair_assets">
        </div>
      </div>
    </div>
  </div>
</div><!-- Modal for End Repairing END -->


<!--**********************************************************-->
<!--******************* MODAL WINDOWS END ********************-->
<!--**********************************************************-->

<script>
  // $(document).ready(function() {
  //   $('#installed_items_table').DataTable();
  // })

  function ajax_html_cust(url, id) {

    var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
    var list = $('#' + id);
    var assets = [];

    var result = $('#installed_items_table').find('input[type="checkbox"]:checked');

    if (result.length == 0) {
      notify('No Item is Selected. Please Select the item first.', 'danger', 'top', 'center');
      return;
    } else {
      $('#installed_items_table').find('input[type="checkbox"]:checked').each(function() {
        assets.push($(this).val());
      });
    }
    var data1 = assets.join(",");

    $.ajax({
      url: url,
      method: "post",
      data: {
        asset: data1
      },
      beforeSend: function() {
        list.html(loading_set);
      },
      success: function(data) {
        list.html('');
        list.html(data).fadeIn();
      },
      error: function(e) {
        //notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
      }
    });
  }

  function show_asset(url, id) {
    var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
    var list = $('#' + id);
    $.ajax({
      url: url,
      beforeSend: function() {
        list.html(loading_set);
      },
      success: function(data) {
        $('#display_selected_install').html(data).show('slow');
      },
      error: function(e) {
        //notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
      }
    });
  }

  $(document).ready(function() {
    $('#installfilter').change();
  });
  $('body').on('change', "#installfilter", function() {
    var filter_by = this.value;
    if (filter_by == 0) {
      $('.installed_by_site').hide();
      $('.blankdiv').show();
    }
    if (filter_by == 2) {
      $('.blankdiv').hide();
      $('.by_item_type').hide();
      $('.installed_by_site').show();
    }
  });

  $('body').on('change', '#installedsite', function() {
    var site = this.value;
    $.ajax({
      url: "<?php echo base_url(); ?>inventory/installed_filterby_site/" + site,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function() {
        var top = '200';
        $('.hide_div').html('<div style="text-align:center;width:100%;position:relative;top:' + top + 'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
      },
      success: function(data) {
        $('.hide_div').html(data);
        $('#installed_items_table').DataTable();

        $('.emptydiv').show();
        $("[data-toggle='toggle']").bootstrapToggle('destroy')
        $("[data-toggle='toggle']").bootstrapToggle();
      },
      error: function(e) {
        console.log(e)
      }
    });
  });

  $(function() {
    $('#installed_items_table').DataTable({
      "processing": true,
      "destroy": true,
      "serverSide": true,
      "stateSave": true,
      "ajax": {
        "url": "<?php echo base_url('inventory/pagination_data/installed_inventory') ?>",
        "dataType": "json",
        "type": "POST",
      },

      "columns": [{
          "data": "counter"
        },
        {
          "data": "name"
        },
        {
          "data": "serial"
        },
        {
          "data": "identification_no"
        },
        {
          "data": "transaction_type"
        },
        {
          "data": "site"
        },
        {
          "data": "location"
        },

      ],
      "columnDefs": [{
        "aTargets": [0, 5],
        "bSortable": true
      }],

    })
  });
</script>