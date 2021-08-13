<td class="<?php if(isset($inv['status'])){ if($inv['status'] == 1){ echo 'bg-success';} if($inv['status'] == 2){ echo 'bg-danger';} } ?>">
	<?php if(isset($inv['status'])){ if($inv['status'] == 1){ echo 'OK'; } if($inv['status'] == 2){ echo $inv['description'];} }; ?>
</td>