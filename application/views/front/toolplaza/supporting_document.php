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
                                <td>
                                  <a href="#" class="btn btn-danger btn-xs" onclick="delete_con('<?php echo base_url(); ?>toolplaza/delete_suppporting/<?php echo $mtr[0]['id']; ?>/<?php echo $sprt['id']; ?>')"><i class="fa fa-trash" ></i></a>
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