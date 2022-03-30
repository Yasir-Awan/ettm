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
            <th>Vout</th>
            <th>Iout</th>
            <th>Wout</th>
            <th>Vbat</th>
            <th>Temp</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($ups_data as $row) { ?>
            <tr>
              <td><?php echo date("F, j/Y", strtotime($row['date'])); ?></td>
              <td><?php echo ceil($row['avg_Vmin']); ?></td>
              <td><?php echo ceil($row['avg_Vmax']); ?></td>
              <td><?php echo ceil($row['avg_Vbp1']); ?></td>
              <td><?php echo ceil($row['avg_Iin1']); ?></td>
              <td><?php echo ceil($row['avg_Vout1']); ?></td>
              <td><?php echo ceil($row['avg_Wout1']); ?></td>
              <td><?php echo ceil($row['avg_Vbat']); ?></td>
              <td><?php echo ceil($row['avg_Temp']); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <!-- Table END -->
    </div>
  </div>
</div>
</div>