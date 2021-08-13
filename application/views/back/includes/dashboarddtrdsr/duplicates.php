<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Duplicates</title>
<link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/bootstrap.min.css"><link rel="stylesheet" href="<?php echo base_url()?>assets/back/css/styles.css">
</head>

<body>
	<div class="main-content-inner">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="card">
					<div class="card-title text-center py-5"><h4>Duplicate DSRs And DTRs</h4></div>
				</div>
			</div>
			<?php if(isset($dtr_dsr)){ $ent = 0; foreach($dtr_dsr as $entry){ ?>
			<div class="col-md-6 text-center">
				<div class="card">
					<div class="card-title text-center py-2"><h4><?php echo $entry['name'];?> Tollplaza</h4></div>
					<div class="card-body">
						<div id="dsr" class="py-2">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 py-2"><strong>DSRs</strong></div>
								<?php if(isset($entry['dsr'])){ $dsr_no = 0; foreach($entry['dsr'] as $dsr){ ?>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><?php echo date('j F Y',strtotime($dsr['datecreated'])); ?> </div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><?php echo $dsr['number']; ?></div>
								<?php $dsr_no++; } } ?>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 py-2"><strong>Entries</strong></div>
							</div>
							
						</div>
						<div id="dtr" class="py-3">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 py-2"><strong>DTRs</strong></div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 py-2"><strong>Entries</strong></div>
							</div>
							<?php if(isset($entry['dtr'])){ $dtr_no = 0; foreach($entry['dtr'] as $dtr){ ?> 
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><?php echo date('j F Y',strtotime($dtr['for_date'])); ?> </div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><?php echo $dtr['number']; ?></div>
							</div>
							<?php $dtr_no++; } } ?>
						</div>
						
					</div>
				</div>
			</div>
			<?php $ent++; } } ?>
		</div>
	</div>
</body>
</html>