<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventory Report</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/back/inventory_report/inventory_report.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/admin_logout_vendor/fontawesome-free/css/all.min.css">
  
  <script src="<?php echo base_url();?>assets/back/inventory_report/inventory_report_jquery.js"></script>
  <script src="<?php echo base_url();?>assets/back/inventory_report/inventory_report_bootstrap.js"></script>
</head>
<body>
<div class="container">
  <h2><?php echo $sitename; ?> Inventory Report</h2>
  <div class="panel-group">
    <div class="panel panel-primary">
      <div class="panel-heading">Overview</div>
      <div class="panel-body">
      <ul class="list-group">
        <li class="list-group-item">
            <span class="badge" style="background:#337ab7;"><?php echo $total_items?></span>
            TOTAL EQIPMENT at SITE
        </li>
        <li class="list-group-item">
            <span class="badge" style="background:green;"><?php echo $operational;?></span>
            OPERATIONAL
        </li>
        <li class="list-group-item">
            <span class="badge" style="background:red;"><?php echo $nonOperational;?></span>
            Non Operational
        </li>
        </ul>

        <ul class="list-group">
        <?php foreach($itemqty as $key => $value){ ?>
        <li class="list-group-item">
            <span class="badge" style="background:#337ab7;"><?php echo $value;?></span>
            <?php echo $key;?>
        </li>
        <?php } ?>
        </ul>
      </div>
    </div>
<?php foreach ($report_data as $key => $loc_data){
  if(!empty($loc_data)){ 
  ?>
    <div class="panel panel-primary">
      <div class="panel-heading"><?php echo $key;?> <span class="pull pull-right">Total Items <i class="badge"><?php echo $location_vise_count[$key];?></i></span></div>
      <div class="panel-body">
      <table class="table">
  <!-- <caption>List of users</caption> -->
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">NAME</th>
      <th scope="col">ID</th>
      <th scope="col">STATUS</th>
      <th scope="col">SERIAL</th>
    </tr>
  </thead>
  <tbody>
  <?php $rowNo = 0; ?>
  <?php foreach($loc_data as $keyy => $val){ ?>
    <tr>
      <th scope="row"><?php echo ++$rowNo;?></th>
      <td><?php echo $item_id_with_name[$val['name']]; ?></td>
      <td><?php echo $val['identification_no']; ?></td>
      <td> <?php if($val['transaction_type']==3 || $val['transaction_type']==9 || $val['transaction_type']==14){ ?> 
                                        <i class="fa fa-check"  style="color:green;"></i>
                                      <?php 
                                      }
                                      else{
                                      ?>
                                      <i class="fa fa-close"  style="color:red;"></i>
                                      <?php } ?></td>
      <td><?php echo $val['serial_no']; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table></div>
    </div>
    <?php } ?>
    <?php } ?>

  </div>
</div>

</body>
</html>
