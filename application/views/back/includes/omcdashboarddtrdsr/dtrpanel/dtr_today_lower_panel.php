 <div class="col-md-12 col-xs-12">
              <div class="card">
                <div class="card-body">
                    <div class="media">
                    
                    <div class="media-middle media-body">
                      <h3 class="media-heading">
                        <span class="fw-l">Data-Sheet</span>
                        
                      </h3>
                      <table>
						  <thead>
							  <tr>
								  <th width="50%">Tollplaza</th>
								  <th width="40%">Traffic</th>
								  <th width="30%">Revenue</th>
							  </tr>
						  </thead>
						  <?php if($dtr){ if(isset($toolplaza_ts)){ $u = 0; foreach($dtr as $row){  ?>
						  <tbody>
							  <tr>
								  <td><a href="<?php echo base_url()?>admin/daily_traffic_report/<?php echo $row['id']?>"><?php echo $toolplaza_ts[$u]['name']; ?></a></td>
								  <td><?php echo $toolplaza_ts[$u]['traffic']; ?></td>
								  <td><?php echo $toolplaza_ts[$u]['revenue']; ?></td>
							  </tr>
							  <?php $u++;  } ?>
						  </tbody>
						  <tfoot>
							  <tr>
								  <td><strong>Total</strong></td>
								  <td><?php echo $toolplaza_ts['total_traffic']; ?></td>
								  <td><?php echo $toolplaza_ts['total_revenue']; ?></td>
							  </tr>
						  </tfoot>
						  <?php } } else {?><tr><?php echo $message_dtr; ?></tr> <?php } ?>
					  </table>
                    </div>
                  </div>
                </div>
              </div>
	 		</div>