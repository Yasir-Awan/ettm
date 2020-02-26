 <ul class="row nav nav-tabs">
        <li class="heading btn-primary col-md-6"><a class="active" href="#all">All TollPlazas</a>
        </li>
        <li class="heading btn-primary col-md-6"><div class="dropdown show">
  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Tollplaza
  </a>
  <form method="post" id="dashboard_dtr_tollplaza" action="<?php base_url().'admin/dashboard_dtr_tollplaza'?>">
	<select name="toolid" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
  	<option class="dropdown-item" value="">Select Tollplaza</option>
   <?php $i = 0; foreach($toolplazatoday as $tollplaza){ ?>
    <option class="dropdown-item" value="<?php echo $tollplaza['id'] ?>"><?php echo $tollplaza['name'] ?></option>
    <?php $i++;}?>
  </select>
</form>
  
</div>
        </li>
    </ul>