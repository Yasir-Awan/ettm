 <div class="col-md-12 col-xs-12">
	 <div class="card">
		 <div class="card-body">
			 <div id="lanelower" class="media">
				 <div class="media-middle media-body">
					 <h3 class="media-heading"><span class="fw-l">Data-Sheet</span></h3>
					 <table>
						 <thead>
							 <tr>
								 <th width="20%">Tollplaza</th>
								 <th width="30%">OMC</th>
								 <th width="20%">Lanes Closed</th>
								 <th width="30%">Faulty Lane Cameras</th>
							 </tr>
						 </thead>
						 <tbody>
							 <?php if($dsr){ $u = 0; foreach($dsr as $row){ ?>
							 <tr>
								 <td><a href="<?php echo base_url()?>admin/daily_site_report/<?php echo $row['id']?>" target="_blank"><?php echo $toolplaza_st[$u]['name']; ?></a></td>
								 <td><?php echo $toolplaza_st[$u]['omc_name'] ?></td>
								 <td class="text-right"><?php echo $toolplaza_st[$u]['closed_lanes'].' / '.$toolplaza_st[$u]['total_lanes']; ?></td>
								 <td class="text-right"><?php echo $toolplaza_st[$u]['faulty_cameras'].' / '.$toolplaza_st[$u]['total_cameras']; ?></td>
							 </tr>
							 <?php $u++;  } ?>
						 </tbody>
						 <tfoot>
							 <tr>
								 <td><strong>Overall</strong></td>
								 <td></td>
								 <td class="text-right"><?php echo $toolplaza_st['closed_lanes'].' / '.$toolplaza_st['total_lanes'] ?></td>
								 <td class="text-right"><?php echo $toolplaza_st['faulty_cameras'].' / '.$toolplaza_st['total_lanes'] ?></td>
							 </tr>
						 </tfoot>
						 <?php } else {?><tr><?php echo $message_dsr; ?></tr> <?php } ?>
					 </table>
				 </div>
			 </div>
		 </div>
	 </div>
</div>
			