 <div class="col-md-12 col-xs-12">
              <div class="card">
                <div class="card-body">
                    <div class="media">
                    
                    <div class="media-middle media-body data-tables">
                      <h3 class="media-heading">
                        <span class="fw-l">Data-Sheet</span>
                        
                      </h3>
                      <table id="dtr-table">
						  <thead>
							  <tr>
								  <th width="25%">Tollplaza</th>
								  <th width="25%">OMC</th>
								  <th width="25%">Traffic</th>
								  <th width="30%">Revenue</th>
								  <th width="30%">Status</th>
							  </tr>
						  </thead>
						  <tbody>
							 <?php if(isset($tool['tool'])){ $t = 0; foreach($tool['tool'] as $toll){?>
							 <tr>
								 <th><?php echo $toll['name']; ?></th>
								 <?php  if(isset($toll['dtr'])){$u = 0; foreach($toll['dtr'] as $row){ ?>
								 <td><a href="<?php echo base_url()?>admin/daily_traffic_report/<?php echo $row['id']?>" target="_blank"><?php if(isset($row['omc_name'])) echo $row['omc_name'] ?></a></td>
								 <td class="text-center"><?php if(isset($row['total'])) echo $row['total']; ?></td>
								 <td class="text-center"><?php if(isset($row['revenue'])) echo $row['revenue']; ?></td>
								  <?php if(isset($toll['dtr'][0]['message'])){ ?>
								 <td class="text-right"><?php echo $toll['dtr'][0]['message']; ?></td>
								 <?php } $u++; } }else{  ?>
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
    $('#dtr-table').DataTable({
		"pageLength": 20
	});
	$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();
} );
	
</script>