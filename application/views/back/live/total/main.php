<div class="row">
	<h4 class="container text-center" style="">Total</h4>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 py-12 py-3 row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 py-3">
			<?php if(isset($total[0]['traffic'])){ include('traffic.php');} ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 py-3">
			<?php if(isset($total[0]['revenue'])){ include('revenue.php');} ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 py-3">
			<?php if(isset($total[0]['paid'])){ include('paid.php');} ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 py-3">
			<?php if(isset($total[0]['exempt'])){ include('exempt.php');} ?>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 py-3">
			<?php if(isset($total[0]['violations'])){ include('violations.php');} ?>
		</div>
	</div>
</div>