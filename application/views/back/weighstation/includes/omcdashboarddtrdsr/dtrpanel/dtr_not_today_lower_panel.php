 <div class="col-md-12 col-xs-12">
	 <div class="card">
		 <div class="card-body">
			 <div id="lanelower" class="media">
				 <div class="media-middle media-body">
					 <h3 class="media-heading"><span class="fw-l">Data-Sheet</span></h3>
					 <table>
						 <thead>
							 <tr>
								 <th width="30%">Tollplaza</th>
								 <th width="20%">Uploaded</th>
								 <th width="25%">Not Uploaded</th>
								 <th width="30%">Status</th>
							 </tr>
						 </thead>
						 <tbody>
							 <?php if(isset($tool)){ $u = 0; foreach($tool as $toll){ ?>
							 <tr>
								 <td><a href="" target="_blank"><?php echo $toll['name']; ?></a></td>
								 <td><?php if(isset($days_count)){ /*if($dtr_tool[$u]['count'] <= $days_count) */echo $dtr_tool[$u]['count'];} ?></td>
								 <td><?php  /*if($dtr_tool[$u]['not_uploaded'] >= 0)*/ echo $dtr_tool[$u]['not_uploaded']; ?></td>
								 <td><?php if(isset($dtr_tool[$u]['error'])){ echo $dtr_tool[$u]['error']; }elseif(isset($dtr_tool[$u]['success'])){ echo $dtr_tool[$u]['success']; } ?></td>
							 </tr>
							 <?php $u++;  } } ?>
						 </tbody>
					 </table>
				 </div>
			 </div>
		 </div>
	 </div>
</div>
			