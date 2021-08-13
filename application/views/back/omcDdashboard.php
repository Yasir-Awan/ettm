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
		<?php include('includes/omcdashboarddtrdsr/dsr.php');?>
		</div>
		<div id="dtr_panel" class="col-md-6 col-xs-12">
		<?php include('includes/omcdashboarddtrdsr/dtr.php');?>
		</div>
	</div>
	<div class="row gutter-xs">
		<div id="upload_supervise" class="col-md-6 col-xs-6 d-none">
		<?php include('includes/omcdashboarddtrdsr/supervise_upload.php');?>
		</div>
	</div>
</div>

<?php include("includes/omcdashboarddtrdsr/script/main.php"); ?>
<?php include("includes/omcdashboarddtrdsr/script/ajax.php"); ?>
<?php include("includes/footer.php"); ?>
	