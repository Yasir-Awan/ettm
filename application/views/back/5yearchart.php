<?php include('includes/header.php'); ?>
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
		<div id="upper_panel" class="col-md-12 col-xs-12 pull-right">
			<div class="row gutter-xs">
				
				<?php include('includes/5yearchart/toll_panel.php'); ?>
			</div>
		</div>
	</div>
	<?php include('includes/5yearchart/index.php'); ?>
</div>
<?php include('includes//5yearchart/script/ajax.php'); ?>
<?php include('includes/footer.php')?>