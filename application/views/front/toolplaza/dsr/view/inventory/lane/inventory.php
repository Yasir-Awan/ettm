<td <?php if(isset($lane['status'])){ if($lane['status'] == 1){ echo 'class="bg-success"';} if($lane['status'] == 2){ echo 'class="bg-danger"';} } ?>>
	<?php if(isset($lane['status'])){ if($lane['status'] == 1){ echo 'OK'; } if($lane['status'] == 2){ echo $lane['description'];} }; ?>
</td>