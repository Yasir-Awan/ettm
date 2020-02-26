<?php 
 if($support){
?>
                 
                      <div class="col-md-12">
                          <table class="table">
                            <tbody>
                              <?php 
                                foreach ($support as  $sprt) {
                                
                                
                              ?>
                              <tr>
                                <td>
                                  <a href="<?php echo base_url()?>uploads/supporting/<?php echo $sprt['path'];?>" target="_blank"><?php echo $sprt['name']?></a>
                                </td>
                              
                              </tr>
                              <?php 
                                }
                              ?>
                            </tbody>
                          </table>
                      </div>
                 
                  <?php }else{

                    echo '<div class="col-md-12"></div>';
                  } ?>