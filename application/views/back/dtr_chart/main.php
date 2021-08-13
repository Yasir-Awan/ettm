<html>
	<head>
		 <meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="Description" content="Daily Site Report">
		<title>DTR Comparative Chart</title>
		<link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/styles.css">
		<script src="<?php echo base_url();?>assets/amcharts4/core.js"></script>
		<script src="<?php echo base_url();?>assets/amcharts4/charts.js"></script>
		<script src="<?php echo base_url();?>assets/amcharts4/animated.js"></script>
	</head>
	<body>
		<div class="main-content-inner">
			<div class="row">
				<div class="col-md-12">
		<?php $toll_no = 0; foreach($tool as $toll){ 
            /* echo $toll['month_total'];exit; */
			if(isset($toll['traffic']) && isset($toll['month_total'])){ 
				if($toll['traffic'] != 0){?>
					<div class="card my-5">
						<h4 class="m-b-10 text-center"><strong><?php echo $toll['name']; ?></strong></h4>
						<h5 class="m-b-10 text-center"><?php echo $toll['duration']; ?></h5>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="container m-b-10 col-md-10">
										<?php include('chart.php'); ?>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				<?php }
			}  
			$toll_no++; 
		} ?>
		
	</body>
</html>

