<!-- Content row Start-->
<div class="row mb-2" style="margin-left:0px; margin-right:0px;">

  <!-- plaza and month filter START -->
  <div class="search-box pull-left col-xl-3 col-md-6 mb-1 " style="">
    <!-- Hidden Form START -->
    <?php if ($page == "Dashboard") { ?>
      <?php $hidden = array('plaza_id' => $chart['toolplaza_id'], 'month' => $chart['month']); ?>
      <?php echo form_open_multipart(base_url() . 'admin/dashboard_timer', array('id' => 'timer', 'method' => 'post'), $hidden); ?>

      </form>
    <?php } ?>
    <!-- Hidden Form END -->

    <?php if ($page == "Dashboard") { ?>

      <?php echo form_open_multipart(base_url() . 'admin/searchforchart', array('id' => 'searchforchart', 'method' => 'post')); ?>

      <select class="form-control required text-primary mb-1" name="tollplaza" id="tollplaza" class="card border-left-primary shadow h-100 py-2" style="height: 35px !important; padding-bottom: 6px; padding-left: 5px; border-left: .25rem solid #4e73df!important;">
        <option value="">Select Toll Plaza</option>
        <?php foreach ($tollplaza as $row) { ?>
          <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
        <?php } ?>
      </select>

      <div class="date" style="display:none; width:50.25px; margin-right:30px !mportant; ">
        <input type="text" id="formonth" name="formonth" class="form-control" placeholder="Select month" class="card border-left-primary shadow h-100 py-2" style="height: 30px !important; ">
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
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1" style="">
              <h5 class="card-category text-warning" style="font-size: 16px;"><?php if (!empty($chart)) {
                                                                                echo $chart['tollplaza'];
                                                                              } ?>
                <span class="pull-right text-warning"></span>
              </h5>
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php if (!empty($chart)) {
                                                                                            echo date("F, Y", strtotime($chart['month']));
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
              <h5 style="font-size: 16px;">Total Traffic</h5>
            </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php echo number_format($chart['total']['traffic']); ?></div>
          </div>
          <div class="col-auto" style="padding-right: 10%;">
            <i class="fa fa-bus fa-2x text-gray-300" style="color:#36b9cc !important;"></i>
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
              <h5 style="font-size: 16px;">Total Revenue</h5>
            </div>
            <?php $exempt = $this->db->get_where('exempt', array('mtr_id' => $mtrid))->result_array();
            if ($terrif) {
              if ($exempt) {
                $total_revenue = (($chart['class1']['data'] - $exempt[0]['class1']) * $terrif[0]['class_1_value']) +
                  (($chart['class2']['data'] - $exempt[0]['class2']) * $terrif[0]['class_2_value']) +
                  (($chart['class3']['data'] - $exempt[0]['class3'] - $exempt[0]['class5'] - $exempt[0]['class6']) *  $terrif[0]['class_3_value']) +
                  (($chart['class4']['data'] - $exempt[0]['class4']) * $terrif[0]['class_4_value']) +
                  (($chart['class5']['data'] - $exempt[0]['class7'] - $exempt[0]['class8'] - $exempt[0]['class9'] - $exempt[0]['class10']) *  $terrif[0]['class_7_value']);
              } else {

                $total_revenue = (($chart['class1']['data']) * $terrif[0]['class_1_value']) +
                  (($chart['class2']['data']) * $terrif[0]['class_2_value']) +
                  (($chart['class3']['data']) *  $terrif[0]['class_3_value']) +
                  (($chart['class4']['data']) * $terrif[0]['class_4_value']) +
                  (($chart['class5']['data']) *  $terrif[0]['class_7_value']);
              }
            } else {
              $total_revenue = 'Tarrif Not Added yet!';
            }
            ?>
            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 16px;"><?php echo number_format($total_revenue); ?></div>
          </div>
          <div class="col-auto" style="padding-right: 13%;">
            <i><img style="width:40px;height:40px;" src="<?php echo base_url(); ?>assets/back/images/icon/pkr.png" alt="logo"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

</div><!-- Content row End -->