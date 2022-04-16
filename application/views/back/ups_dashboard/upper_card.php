<!-- Content row Start-->
<div class="row mb-2" style="margin-left:0px; margin-right:0px;">

  <!-- plaza and month filter START -->
  <div class="search-box pull-left col-xl-3 col-md-6 mb-1">
    <!-- Hidden Form START -->
    <?php if ($page == "UPS Dashboard") { ?>
      <?php $hidden = array('plaza_id' => $ups_data['toolplaza_id'], 'month' => $ups_data['date']); ?>
      <?php echo form_open_multipart(base_url() . 'admin/dashboard_timer', array('id' => 'timer', 'method' => 'post'), $hidden); ?>
      </form>
    <?php } ?>
    <!-- Hidden Form END -->

    <?php if ($page == "UPS Dashboard") { ?>
      <?php echo form_open_multipart(base_url() . 'ups_dashboard/searchforUPS', array('id' => 'searchforUPSsite', 'method' => 'post')); ?>
      <select class="form-control required text-primary mb-1" name="ups_site" id="ups_site" class="card border-left-primary shadow h-100 py-2" style="height: 35px !important; padding-bottom: 6px; padding-left: 5px; border-left: .25rem solid #4e73df!important;">
        <option value="">Select UPS</option>
        <?php foreach ($tollplaza as $row) { ?>
          <option value="<?php echo $row['id']; ?>"><?php echo $row['site']; ?></option>
        <?php } ?>
      </select>

      <div class="ups_date" style="display:none; width:50.25px; margin-right:30px;">
        <input type="text" id="ups_formonth" name="ups_formonth" class="form-control" placeholder="Select month" class="card border-left-primary shadow h-100 py-2" style="height: 30px !important;">
      </div>
      </form>
    <?php } ?>
  </div><!-- plaza and month filter END -->

  <!-- Plazas (Name) Card -->
  <div class="col-xl-3 col-md-6 mb-1" style="height: 8%;">
    <div class="card border-left-primary shadow h-100 py-2" style="border-left: .25rem solid #f6c23e!important;">
      <div class="card-body" style="padding: 1% !important;">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2" style="padding-left: 8%;">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
              <h5 class="card-category text-warning" style="font-size: 16px;"><?php if (!empty($ups_data)) {
                                                                                echo $ups_data[0]['site'];
                                                                              } ?>
                <span class="pull-right text-warning"></span>
              </h5>
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php if (!empty($ups_data)) {
                                                                                            echo date("F, Y", strtotime($ups_data[0]['date']));
                                                                                          } ?></div>
          </div>
          <div class="col-auto" style="padding-right: 15%;">
            <i class="fas fa-calendar fa-2x text-gray-300" style="color:#f6c23e !important; margin-right: 5% !important;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Traffic Card -->
  <div class="col-xl-3 col-md-6 mb-1" style="height: 8%;">
    <div class="card border-left-primary shadow h-100 py-2" style="border-left: .25rem solid #36b9cc!important;">
      <div class="card-body" style="padding: 1% !important;">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2" style="padding-left: 8%;">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
              <h5 style="font-size: 16px;">Battery Voltage </h5>
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php echo ceil($monthlyVbat); ?></div>
          </div>
          <div class="col-auto" style="padding-right: 10%;">
            <i class="fa fa-bolt fa-2x text-gray-300" style="color:#36b9cc !important;"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total REVENUE Card -->
  <div class="col-xl-3 col-md-6 mb-1" style="height: 8%;">
    <div class="card border-left-success shadow h-100 py-2" style="border-left: .25rem solid #1cc88a!important;">
      <div class="card-body" style="padding: 1% !important;">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2" style="padding-left: 8%;">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
              <h5 style="font-size: 16px;">Temprature</h5>
            </div>
            <?php $exempt = $this->db->get_where('exempt', array('mtr_id' => $mtrid))->result_array();
            // echo $monthlyTemp;
            ?>
            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php echo ceil($monthlyTemp); ?></div>
          </div>
          <div class="col-auto" style="padding-right: 13%;">
            <i class="fas fa-temperature-high"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

</div><!-- Content row End -->