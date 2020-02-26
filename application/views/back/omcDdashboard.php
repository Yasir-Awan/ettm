<?php include("includes/header.php"); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/back/css/dashboard-st.css">
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
<?php include("includes/omcdashboarddtrdsr/script/ajax.php"); ?>
<?php include("includes/footer.php"); ?>