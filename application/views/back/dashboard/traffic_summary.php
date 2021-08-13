<div class="card  card-tasks">
            <div class="card-header" class="card border-top-info shadow h-100 py-2" style=" padding-left:1rem; padding-right:1rem; padding-top:3px; border-top: .25rem solid #36b9cc!important;">
               <div class='row '>
                  <div class="col-md-12">
                    <h4 class="card-title text-info" style="color:#303641 !important;" >Traffic summary of  <?php if(!empty($chart)){ echo $chart['tollplaza'];}?>  <?php if(!empty($chart)){ echo date("F, Y",strtotime($chart['month'])); } ?></h4>
                  </div>
                </div>
              </div>
              <div class="card-body" style="padding:0px;">
                <div id="table_for_class_vise_traffic_reveneu">
                  <!-- Table START -->
                  <table class="table table-hover" style="line-height: 0.5;">
                    <thead>
                      <tr class="table-info">
                        <th >Vehicle Type</th>
                        <th >Car</th>
                        <th >Wagon</th>
                        <th >Truck</th>
                        <th >Bus</th>
                        <th >Art. Truck</th>
                        <th >Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="col">Traffic</th>
                        <td><?php echo number_format( $chart['class1']['data']);?></td>
                        <td><?php echo number_format( $chart['class2']['data']);?></td>
                        <td><?php echo number_format( $chart['class3']['data']);?></td>
                        <td><?php echo number_format( $chart['class4']['data']);?></td>
                        <td><?php echo number_format( $chart['class5']['data']);?></td>
                        <td><?php echo number_format( $chart['total']['traffic']);?></td>
                      </tr>
                      <?php if($exempt){ ?>
                      <tr>
                        <th scope="col">Exempt</th>
                        <td><?php echo number_format( $exempt['0']['class1']);?></td>
                        <td><?php echo number_format( $exempt['0']['class2']);?></td>
                        <td><?php echo number_format( $exempt['0']['class3']+ $exempt['0']['class5']+$exempt['0']['class6'] );?></td>
                        <td><?php echo number_format( $exempt['0']['class4']);?></td>
                        <td><?php echo number_format( $exempt['0']['class7']+ $exempt['0']['class8']+$exempt['0']['class9']+$exempt['0']['class10'] );?></td>
                        <td><?php echo number_format( $exempt['0']['class1']+ $exempt['0']['class2']+$exempt['0']['class3']+$exempt['0']['class4']+ $exempt['0']['class5']+$exempt['0']['class6']+$exempt['0']['class7']+ $exempt['0']['class8']+$exempt['0']['class9']+$exempt['0']['class10'] );?></td>
                      </tr>
                      <?php }?>
                      <?php if($terrif){ ?>
                      <?php if($exempt){ ?>
                      <tr>
                        <th scope="col">Revenue</th>
                        <td><?php echo number_format(($chart['class1']['data'] - $exempt[0]['class1']) * $terrif[0]['class_1_value']);?></td>
                        <td><?php echo number_format(($chart['class2']['data'] - $exempt[0]['class2']) * $terrif[0]['class_2_value']);?></td>
                        <td><?php echo number_format(($chart['class3']['data'] - $exempt[0]['class3'] - $exempt[0]['class5'] - $exempt[0]['class6']) *  $terrif[0]['class_3_value']  );?></td>
                        <td><?php echo number_format(($chart['class4']['data'] - $exempt[0]['class4']) * $terrif[0]['class_4_value']);?></td>
                        <td><?php echo number_format(($chart['class5']['data'] - $exempt[0]['class7'] - $exempt[0]['class8'] - $exempt[0]['class9'] - $exempt[0]['class10'] ) *  $terrif[0]['class_7_value']  );?></td>
                        <?php $total_revenue = (($chart['class1']['data'] - $exempt[0]['class1']) * $terrif[0]['class_1_value'])+
                               (($chart['class2']['data'] - $exempt[0]['class2']) * $terrif[0]['class_2_value'])+
                               (($chart['class3']['data'] - $exempt[0]['class3'] - $exempt[0]['class5'] - $exempt[0]['class6']) *  $terrif[0]['class_3_value']  )+
                               (($chart['class4']['data'] - $exempt[0]['class4']) * $terrif[0]['class_4_value'])+
                               (($chart['class5']['data'] - $exempt[0]['class7'] - $exempt[0]['class8'] - $exempt[0]['class9'] - $exempt[0]['class10'] ) *  $terrif[0]['class_7_value']  );
                        ?>
                        <td><?php echo number_format($total_revenue) ;?></td>
                      </tr>
                      <?php } else{ ?>               
                      <tr>
                        <th scope="col">Reveneu</th>
                        <td><?php echo number_format(($chart['class1']['data']) * $terrif[0]['class_1_value']);?></td>
                        <td><?php echo number_format(($chart['class2']['data'] ) * $terrif[0]['class_2_value']);?></td>
                        <td><?php echo number_format(($chart['class3']['data'] ) *  $terrif[0]['class_3_value']  );?></td>
                        <td><?php echo number_format(($chart['class4']['data'] ) * $terrif[0]['class_4_value']);?></td>
                        <td><?php echo number_format(($chart['class5']['data'] ) *  $terrif[0]['class_7_value']  );?></td>
                        <?php $total_revenue = (($chart['class1']['data'] ) * $terrif[0]['class_1_value'])+
                               (($chart['class2']['data'] ) * $terrif[0]['class_2_value'])+
                               (($chart['class3']['data'] ) *  $terrif[0]['class_3_value']  )+
                               (($chart['class4']['data'] ) * $terrif[0]['class_4_value'])+
                               (($chart['class5']['data'] ) *  $terrif[0]['class_7_value']  );
                        ?>
                        <td><?php echo number_format($total_revenue) ;?></td>
                      </tr>
                      <?php } ?>
                      <?php } else{ ?>
                      <tr>
                        <th scope="col">Reveneu</th>
                        <td colspan='6'><h2><?php echo 'Tarrif Not Added yet!';?></h2></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table> 
                   <!-- Table END -->
                </div>
              </div>
            </div>
          </div>