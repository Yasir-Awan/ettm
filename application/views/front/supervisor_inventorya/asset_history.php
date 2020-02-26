<div class="table-responsive hide_div" style="">
            <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12 pl-1 pr-1">
                   <table class="table table-bordered dataTable" id="dataTable_11" width="100%" cellspacing="0" role="grid"; aria-describedby="dataTable_info" style="width: 100%; ">
                  <thead align='center'>
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: auto;">#Sr</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width:auto;">Name</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Transaction</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Asset Site</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Transaction Performed by</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Transaction Add Date</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Transaction Added by</th>
                      <!-- <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Action</th> -->
                    </tr>
                  </thead>
                  <tfoot align='center'>
                    <tr>
                       <th rowspan="1" colspan="1">Sr#</th>
                       <th rowspan="1" colspan="1">Name</th>
                       <th rowspan="1" colspan="1">Transaction</th>
                       <th rowspan="1" colspan="1">Asset Site</th>
                       <th rowspan="1" colspan="1">Transaction Performed by</th>
                       <th rowspan="1" colspan="1">Transaction Add Date</th>
                       <th rowspan="1" colspan="1">Transaction Added by</th>
                       <!-- <th rowspan="1" colspan="1">Action</th> -->
                    </tr>
                  </tfoot>
                  <?php if($asset_transactions) { ?>
                  <tbody align='center'>  
                    <?php $counter=1; ?>
                  <?php foreach($asset_transactions as $transaction) { ?>         
                  <tr role="row" class="odd">
                   <td style="width:2%;" valign="middle">
                      <?php echo $counter++ ?> 
                   </td>
                   <td style="width:5%;" valign="middle">
                   <?php
                   $asset = $this->db->get_where('assets',array('id'=>$transaction['asset_id']))->result_array();                   
                   $asset_name = $this->db->get_where('items',array('id'=>$asset[0]['name']))->result_array();
                   echo $asset_name[0]['name'];
                   ?>
                   </td>
                   <td style="width:3%;" valign="middle">
                      <?php
                      if($transaction['transaction_type']==1){
                        echo "Checked Out";
                      }
                      if($transaction['transaction_type']==2){
                        echo "Checked In";
                      }
                      if($transaction['transaction_type']==3){
                        echo "Install";
                      }
                      if($transaction['transaction_type']==4){
                        echo "Started Repairing";
                      }
                      if($transaction['transaction_type']==6){
                        echo "Retired";
                      }
                      if($transaction['transaction_type']==9){
                        echo "Repaired & Reinstalled";
                      }
                      ?>
                   </td>
                   <td >
                     <?php if($transaction['transaction_type']==1){ ?>
                      <?php 
                        $fromSite = $this->db->get_where('sites',array('id'=>$transaction['checkout_from_site']))->result_array();
                        $toSite = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();  
                      ?>                      
                      <span class="btn-primary btn-xs"> <?php echo "from:".$fromSite[0]['name'] ?></span><br>
                      <span class="btn-danger btn-xs"><?php echo "to:".$toSite[0]['name'] ?></span>
                     <?php 
                     }
                     elseif($transaction['transaction_type']==2)
                     { 
                           $fromSite = $this->db->select('*')->where('asset_id',$transaction['asset_id'])->where('transaction_type',1)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
                           $fromSiteName = $this->db->get_where('sites',array('id'=>$fromSite[0]['checkout_from_site']))->result_array();
                           $toSite = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();  
                         ?>                      
                         <span class="btn-primary btn-xs"> <?php echo "Checkout from:".$fromSiteName[0]['name'] ?></span><br>
                         <span class="btn-danger btn-xs"><?php echo "Checkin at:".$toSite[0]['name'] ?></span> 
                      
                      <?php 
                      }
                      elseif($transaction['transaction_type']==6)
                      { 
                          // $Site = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();  
                          ?>                      
                          <span class="btn-danger btn-xs"><?php echo "Retire Site not added yet! by developer."; ?></span> 
                       
                       <?php 
                       }    
                     else 
                     { 
                     $transactionToSite = $this->db->get_where('sites',array('id'=>$transaction['site']))->result_array();
                     $transactionToLocation = $this->db->get_where('locations',array('id'=>$transaction['location']))->result_array();  
                      ?>                      
                      <span class="btn-primary btn-xs"> <?php echo "Site:".$transactionToSite[0]['name'] ?></span><br>
                      <span class="btn-danger btn-xs"><?php echo "Location:".$transactionToLocation[0]['location'] ?></span>
                <?php } ?>
                   </td>
                  
                   <td style="width:20%;">
                      <?php if($transaction['transaction_type']==3){ ?>
                      <?php    if($transaction['organisation_type']==1)
                               {
                                 $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();?>
                                 <span class="btn-success btn-xs"><?php echo $tspName[0]['name']?></span><br>
                         <?php } 
                               if($transaction['organisation_type']==2)
                               {
                                 ?>
                                 <span class="btn-success btn-xs"><?php echo $transaction['organisation']?></span><br>
                         <?php } ?>
                      <?php 
                            if($transaction['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                      <span class="btn-primary btn-xs"><?php echo  "Installed by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php   
                            }
                            elseif($transaction['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Installed by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php 
                            }
                            elseif($transaction['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Installed by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                       <?php
                            }
                            else
                            {
                            ?>
                              <span class="btn-primary btn-xs"><?php echo  "Installed by:".$transaction['person'] ?></span><br>
                      <?php } ?>
                      <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                    <?php } ?>
                      <?php if($transaction['transaction_type']==4){ ?>
                        <?php $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();?>
                      <span class="btn-success btn-xs"><?php echo $tspName[0]['name']?></span><br>
                      <?php 
                            if($transaction['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                      <span class="btn-primary btn-xs"><?php echo  "Repairing Started by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php   
                            }
                            elseif($transaction['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Repairing Started by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php 
                            }
                            elseif($transaction['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Repairing Started by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                       <?php
                            }
                            else
                            {
                            ?>
                              <span class="btn-primary btn-xs"><?php echo  "Repairing Started by:".$transaction['person'] ?></span><br>
                      <?php } ?>
                      <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                      <?php } ?>
                      <?php if($transaction['transaction_type']==9){ ?>
                        <?php $tspName = $this->db->get_where('tsp',array('id'=>$transaction['organisation']))->result_array();?>
                      <span class="btn-success btn-xs"><?php echo $tspName[0]['name']?></span><br>
                      <?php 
                            if($transaction['repairing_person_type']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                      <span class="btn-primary btn-xs"><?php echo  "Repaired/Reinstalled by:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php   
                            }
                            elseif($transaction['repairing_person_type']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Repaired/Reinstalled:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php 
                            }
                            elseif($transaction['repairing_person_type']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Repaired/Reinstalled:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                       <?php
                            }
                            else
                            {
                            ?>
                              <span class="btn-primary btn-xs"><?php echo  "Repaired/Reinstalled:".$transaction['person'] ?></span><br>
                      <?php } ?>
                      <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                      <?php } ?>
                      <?php if($transaction['transaction_type']==1){ ?>
                      <?php 
                            if($transaction['checkout_user_role']==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$transaction['person']))->result_array();
                        ?>
                      <span class="btn-primary btn-xs"><?php echo  "Checked Out to:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php   
                            }
                            elseif($transaction['checkout_user_role']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Checked Out to:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                            <?php 
                            }
                            elseif($transaction['checkout_user_role']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$transaction['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Checked Out to:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                       <?php } ?>
                            
                      <span class="btn-danger btn-xs"><?php echo $transaction['person_contact'] ?></span>
                      <?php } ?>
                      <?php if($transaction['transaction_type']==2){  
                          $lastCheckoutAsset = $this->db->select('*')->where('asset_id',$transaction['asset_id'])->where('transaction_type',1)->order_by('id','desc')->limit(1)->get('asset_transaction')->result_array();
                            if($lastCheckoutAsset[0]['checkout_user_role'] ==3){
                              $personName = $this->db->get_where('tpsupervisor',array('id'=>$lastCheckoutAsset[0]['person']))->result_array();
                        ?>
                      <span class="btn-primary btn-xs"><?php echo  $personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php   
                            }
                            elseif($lastCheckoutAsset[0]['checkout_user_role']==2)
                            {
                              $personName = $this->db->get_where('member',array('id'=>$lastCheckoutAsset[0]['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Checked Out to:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                      <?php 
                            }
                            elseif($lastCheckoutAsset[0]['checkout_user_role']==1)
                            {
                              $personName = $this->db->get_where('admin',array('id'=>$lastCheckoutAsset[0]['person']))->result_array();
                            ?>
                              <span class="btn-primary btn-xs"><?php echo "Checked Out to:".$personName[0]['fname']." ".$personName[0]['lname'] ?></span><br>
                       <?php } ?>
                            
                      <span class="btn-danger btn-xs"><?php echo $lastCheckoutAsset[0]['person_contact'] ?></span> 
                      <?php } ?>
                      <?php if($transaction['transaction_type']==6){ ?>
                        
                      <span class="btn-primary btn-xs"><?php echo  $transaction['action_comments']?></span><br>
                      
                      <?php } ?>
                   </td>

                   <td><span class="btn-success btn-xs"><?php echo date('F j, Y, g:i a',strtotime($transaction['action_date'])) ?></span></td>
                   <td style="width:5%;" >
                   <?php 
                          if($transaction['user_type']==1){
                            $adding_person_name = $this->db->get_where('admin',array('id'=>$transaction['added_by']))->result_array();
                            echo $adding_person_name[0]['fname']." ".$adding_person_name[0]['lname'];
                          }
                          if($transaction['user_type']==2){
                            $adding_person_name = $this->db->get_where('tpsupervisor',array('id'=>$transaction['added_by']))->result_array();
                            echo $adding_person_name[0]['fname']." ".$adding_person_name[0]['lname'];
                          }
                          if($transaction['user_type']==3){
                            $adding_person_name = $this->db->get_where('member',array('id'=>$transaction['added_by']))->result_array();
                            echo $adding_person_name[0]['fname']." ".$adding_person_name[0]['lname'];
                          }
                       ?>
                   </td>
                   
                  </tr>
                  <?php } ?>
                   </tbody>
              <?php } ?>
                </table>
                </div><!-- col-sm-12 END -->
             </div><!-- row END -->
             
            </div><!-- dataTable wrapper END -->
          </div>
          <script>
          $(document).ready(function(){
            $('#dataTable_11').DataTable();
          })
          </script>
         