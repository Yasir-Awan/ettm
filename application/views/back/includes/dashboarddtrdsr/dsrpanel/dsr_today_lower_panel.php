<div class="col-md-12 col-xs-12">
	 <div class="card">
		 <div class="card-body">
			 <div id="lanelower" class="media">
				 <div class="media-middle media-body data-tables">
					 <h3 class="media-heading"><span class="fw-l">Data-Sheet</span></h3>
					 <table id="dsr-table">
						 <thead>
							 <tr>
								 <th width="20%">Tollplaza</th>
								 <th width="20%">OMC</th>
								 <th width="20%">Lanes Closed</th>
								 <th width="20%">Faulty Lane Cameras</th>
								 <th width="20%" id='status'>Status</th>
							 </tr>
						 </thead>
						 <tbody>
							 <?php if(isset($tool['tool'])){ $t = 0; foreach($tool['tool'] as $toll){?>
							 <tr>
								 <th><?php echo $toll['name']; ?></th>
								 <?php  if(isset($toll['dsr'])){$u = 0; foreach($toll['dsr'] as $row){ ?>
								 <td><a href="<?php echo base_url()?>admin/daily_site_report/<?php echo $row['id']?>" target="_blank"><?php if(isset($row['omc_name'])) echo $row['omc_name'] ?></a></td>
								 <td class="text-right"><?php if(isset($row['closed_lanes']) && isset($row['total_lanes']))  echo $row['closed_lanes'].' / '.$row['total_lanes']; ?></td>
								 <td class="text-right"><?php  if(isset($row['faulty_cameras']) && isset($row['total_cameras'])) echo $row['faulty_cameras'].' / '.$row['total_cameras']; ?></td>
								 <?php if(isset($toll['dsr'][0]['message'])){ ?>
								 <td class=""><?php echo $toll['dsr'][0]['message']; ?></td>
								 <?php }  $u++; } }else{  ?>
								 <td></td><td></td><td></td><td class="text-center">Not Uploaded</td>
								 <?php } ?>
							 </tr>
							 <?php $t++; } } ?>
						 </tbody>
					 </table>
				 </div>
			 </div>
		 </div>
	 </div>
</div>
<script>
$(document).ready(function() {
    $('#dsr-table').DataTable({
		"pageLength": 20
	});
	$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();
} );
	
</script>