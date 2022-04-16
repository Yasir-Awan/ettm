<div class="card  card-tasks">
  <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #36b9cc!important;">
    <div class='row '>
      <div class="col-md-12">
        <h4 class="card-title text-info" style="color:#303641 !important;">UPS summary of <?php if (!empty($ups_data)) {
                                                                                            echo $ups_data[0]['site'];
                                                                                          } ?> <?php if (!empty($ups_data)) {
                                                                                                  echo date("F, Y", strtotime($ups_data[0]['date']));
                                                                                                } ?></h4>
      </div>
    </div>
  </div>
  <div class="card-body" style="padding:0px;">
    <div id="table_for_class_vise_traffic_reveneu">
      <!-- Table START -->
      <table class="table table-hover" style="line-height: 0.5;">
        <thead>
          <tr class="table-info">
            <th>Date</th>
            <th>Vmin</th>
            <th>Vmax</th>
            <th>Vbp</th>
            <th>Iin</th>
            <th>Vout</th>
            <th>Wout</th>
            <th>Vbat</th>
            <th>Temp</th>
            <th>Hours</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $hCount = 0;
          foreach ($ups_data as $row) { ?>
            <tr>
              <td style="padding-top:2em;"><?php echo date("F, j/Y", strtotime($row['date'])); ?></td>
              <td style="padding-top:2em;"><?php echo ceil($row['avg_Vmin']); ?></td>
              <td style="padding-top:2em;"><?php echo ceil($row['avg_Vmax']); ?></td>
              <td style="padding-top:2em;"><?php echo ceil($row['avg_Vbp1']); ?></td>
              <td style="padding-top:2em;"><?php echo ceil($row['avg_Iin1']); ?></td>
              <td style="padding-top:2em;"><?php echo ceil($row['avg_Vout1']); ?></td>
              <td style="padding-top:2em;"><?php echo ceil($row['avg_Wout1']); ?></td>
              <td style="padding-top:2em;"><?php echo ceil($row['avg_Vbat']); ?></td>
              <td style="padding-top:2em;"><?php echo ceil($row['avg_Temp']); ?></td>
              <td>
                <?php
                $vals = "";
                if (empty($row['hours'])) {
                  $vals = "Not Shutdown";
                } else {
                  $vals = implode('  &  ', $row['hours']);
                  // $vals = implode('')
                }
                if ($vals == "Not Shutdown") {
                ?>
                  <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="left" title="<?php echo $vals; ?>">
                    <?php echo $row['hourCount']; ?>
                  </button>
                <?php
                } else {
                ?>
                  <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="<?php echo $vals; ?>">
                    <?php echo $row['hourCount']; ?>
                  </button>
                <?php
                }
                ?>

              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <!-- Table END -->
    </div>
  </div>
</div>
</div>
<script>
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
  $('#example').tooltip(options)
</script>