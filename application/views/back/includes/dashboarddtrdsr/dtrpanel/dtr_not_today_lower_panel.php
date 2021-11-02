 <div class="col-md-12 col-xs-12">
	 <div class="card">
		 <div class="card-body">
			 <div id="lanelower" class="media">
				 <div class="media-middle media-body data-tables">
					 <h3 class="media-heading"><span class="fw-l">Data-Sheet</span></h3>
					 <table id="dtr-table">
						 <thead>
							 <tr>
								 <th width="30%">Tollplaza</th>
								 <th width="20%">Uploaded</th>
								 <th width="20%">Not Uploaded</th>
								 <th width="20%">Approved</th>
								 <th width="20%">Rejected</th>
							 </tr>
						 </thead>
						 <tbody>
							 <?php if(isset($tool['tool'])){ $u = 0; foreach($tool['tool'] as $toll){ ?>
							 <tr>
								 <td><span id="<?php if($id == "current-month-dtr"){ ?>current-month-dtr-toll-<?php echo $toll['id']; }if($id == "current-quarter-dtr"){ ?>current-quarter-dtr-toll-<?php echo $toll['id']; }if($id == "current-semiannual-dtr"){ ?>current-semiannual-dtr-toll-<?php echo $toll['id']; } ?>"><?php if(isset($toll['name'])) echo $toll['name']; ?></span></td>
								 <td><?php if(isset($toll['count'][0]['uploaded'])) echo $toll['count'][0]['uploaded'] ?></td>
								 <td><?php if(isset($toll['count'][0]['not_uploaded'])) echo $toll['count'][0]['not_uploaded'] ?></td>
								 <td><?php if(isset($toll['count'][0]['approved'])) echo $toll['count'][0]['approved'] ?></td>
								 <td><?php if(isset($toll['count'][0]['rejected'])) echo $toll['count'][0]['rejected'] ?></td>
							 </tr>
							 <?php $u++;  } } ?>
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