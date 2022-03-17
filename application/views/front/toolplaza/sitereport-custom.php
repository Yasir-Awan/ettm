<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Daily Site Report">
	<title>Report - DSR</title>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/back/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/back/css/styles.css">
</head>

<body>
	<!-- page title area end -->
	<?php if (isset($dsr)) { ?>
		<div class="main-content-inner">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<?php include('dsr/view/heading.php'); ?>
						</div>
					</div>
					<!--lane report start-->
					<?php include('dsr/view/lane_report.php'); ?>
					<!--lane report end-->
					<!--inventory report start-->
					<?php if (isset($dsr[0]['name_inventory']['lane']) || isset($dsr[0]['name_inventory']['bound_inventory']) || isset($dsr[0]['name_inventory']['bound_inventory']['tollplaza'])) { ?>
						<?php // include('dsr/view/inventory_report.php'); 
						?>
					<?php } ?>
					<!--inventory report end-->
					<!--status report start-->
					<?php include('dsr/view/status_report.php'); ?>
					<!--status report end-->
					<!--documents start-->
					<?php if (empty($support_request) && empty($generator_log)) {
					} else {
						include('dsr/view/documents.php');
					} ?>
					<!--documents end-->
					<!--Feedback Start-->
					<?php if (isset($dsr[0]['feedback'])) {
						include('dsr/view/feedback.php');
					} else {
					} ?>
					<!--Feedback End-->
					<!--Feedback Start-->
					<?php if ($dsr[0]['toll_delay'] != '') {
						include('dsr/view/delay.php');
					} else {
					} ?>
					<!--Feedback End-->
					<!-- <a href="<?php echo base_url() ?>toolplaza/generate_dsrpdf/<?php echo $dsr[0]['id']; ?>" class="btn btn-info pull-right"><i class="fa fa-file-pdf-o"></i> &nbsp;Generate PDF</a> -->
				</div>
			</div>
		</div>
	<?php } else {
		echo 'DSR of this Tollplaza is not submitted yet.';
	} ?>
	<script src="<?php echo base_url() ?>assets/back/js/vendor/jquery-2.2.4.min.js"></script>
	<!-- bootstrap 4 js -->
	<script src="<?php echo base_url() ?>assets/back/js/bootstrap.min.js"></script>
</body>