<input type="hidden" name="id_<?php echo $s['abr'] ?>" value="<?php echo $s['id']; ?>">
<input type="radio" id="toggle-<?php echo $s['abr']; ?>-open" name="status_<?php echo $s['abr']; ?>" <?php if(isset($dsr['dsr'][0]['bound'][1]['lane'][$counter]['status'])){ if($dsr['dsr'][0]['bound'][1]['lane'][$counter]['status'] == 0){ echo 'checked'; } ;}else{ echo 'checked';} ?> value="0">
<label for="toggle-<?php echo $s['abr']; ?>-open" class="radio">Open</label>
<input type="radio" id="toggle-<?php echo $s['abr']; ?>-closed" name="status_<?php echo $s['abr']; ?>" <?php if(isset($dsr['dsr'][0]['bound'][1]['lane'][$counter]['status'])){ if($dsr['dsr'][0]['bound'][1]['lane'][$counter]['status'] == 1){ echo 'checked'; } } ?> value="1">
<label for="toggle-<?php echo $s['abr']; ?>-closed" class="radio">Close</label>