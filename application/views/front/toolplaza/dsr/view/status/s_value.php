<td class="<?php if(isset($feat['val'])){ if($feat['val']== 0){ echo 'bg-success'; } if($feat['val']== 1){ echo 'bg-danger'; } }  ?>">
	<?php 
	if(isset($feat['val'])){ 
		if($feat['val']== 0){ if(isset($feat['status'])){ echo $feat['status']; }  } 
		if($feat['val']== 1){ 
			if(isset($feat['description'])){ echo $feat['description']; }
			else{ if(isset($feat['status'])){ echo $feat['status']; }  }
		}
	} 
	?>
</td>