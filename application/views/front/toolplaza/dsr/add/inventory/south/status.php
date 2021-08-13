<input type="hidden" name="lane_id_<?php echo $inv['abr'] ?>" value="<?php echo $inv['lane_id']; ?>">
<input type="hidden" name="id_<?php echo $inv['abr'] ?>" value="<?php echo $inv['id']; ?>">
<input type="radio" id="toggle-<?php echo $inv['abr']; ?>-no" name="status_<?php echo $inv['abr']; ?>" <?php if(isset($dsr['dsr'][0]['lane_inventory_south'][$counter][$i]['status'])){ if($dsr['dsr'][0]['lane_inventory_south'][$counter][$i]['status'] == 1){ echo 'checked'; } }else{ echo 'checked';} ?> value="1">
<label for="toggle-<?php echo $inv['abr']; ?>-no" class="radio">OK</label>
<input type="radio" id="toggle-<?php echo $inv['abr']; ?>-yes" name="status_<?php echo $inv['abr']; ?>" <?php if(isset($dsr['dsr'][0]['lane_inventory_south'][$counter][$i]['status'])){ if($dsr['dsr'][0]['lane_inventory_south'][$counter][$i]['status'] == 2){ echo 'checked'; } } ?> value="2">
<label for="toggle-<?php echo $inv['abr']; ?>-yes" class="radio">Faulty</label>