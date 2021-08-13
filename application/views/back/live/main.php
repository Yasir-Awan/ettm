

<!-- page title area end -->
	<div class="main-content-inner">
		<div class="income-order-visit-user-area">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 py-2">
				<?php if(isset($total[0])) include('total/main.php'); ?>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php if(isset($today[0])) include('today/main.php') ?>
				</div>
				
				
			</div>
		</div>
	</div>

<?php include('script/odometer.php'); ?>
<?php include('script/ajax.php'); ?>
 
     