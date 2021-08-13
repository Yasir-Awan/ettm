<?php include("includes/header.php"); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/back/css/dashboard-st.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/back/css/jquery.timepicker.min.css">
<style>
	.card-chart-lane{
		height: 200px;
	}
	.card-chart{
		height: 200px;
	}
</style>
<div class="m-4">
	<div class="row gutter-xs">
		<div id="dsr_panel" class="col-md-6 col-xs-12">
		<?php include('includes/dashboarddtrdsr/dsr.php');?>
		</div>
		<div id="dtr_panel" class="col-md-6 col-xs-12">
		<?php include('includes/dashboarddtrdsr/dtr.php');?>
		</div>
	</div>
	<div class="row gutter-xs">
		<div id="upload_supervise" class="col-md-12 col-xs-12">
		<?php include('includes/dashboarddtrdsr/supervise_upload.php');?>
		</div>
	</div>
</div>

<?php include("includes/dashboarddtrdsr/script/main.php"); ?>
<?php include("includes/dashboarddtrdsr/script/ajax.php"); ?>

<?php include("includes/footer.php"); ?>
	