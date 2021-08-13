<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
  .toggle.ios { width: 60.0781px !important;
    height: 30px !important;}
    .btn{
        padding: 0.375rem 0.95rem !important;
        font-size: 1rem !important;
        line-height: 1 !important;
    }
    .toggle-off{
        background-color: #e31515 !important;
        color: white !important;
    }
    .toggle-on{
        background-color: #0f9b0f !important;
        color: white !important;
    }
</style>                     
<div class="data-tables datatable-dark">
    <table id="dataTable3" class="text-center">
        <thead class="text-capitalize">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Status</th>
				<?php if($this->session->userdata('role') == 1) { ?>
                <th>Action</th>
                <?php } ?>
                
            </tr>
        </thead>
        <tbody>
            <?php if($options){ $counter = 0; foreach($options as $row){ $counter++; ?>
			<tr>
				<td><?php echo $counter;?></td>
				<td><?php echo $row['name'];?></td>
                <td>
					<?php if($this->session->userdata('role') == 1) { if($row['status'] != '1') { ?>
					<input type="checkbox" name="toggle" id="toggle_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" data-toggle="toggle" data-off="Off" data-on="On" data-style="ios">
					<?php }elseif($row['status'] == '1'){ //echo 'else'.$row['status']; ?>
					<input type="checkbox" name="toggle" id="toggle_<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" data-toggle="toggle" data-off="Off" data-on="On" data-style="ios" checked="checked">
					<?php } } else{ if($row['status'] != '1'){ ?>
					<span class="badge badge-danger">InActive</span>
					<?php } elseif($row['status'] == '1'){ //echo 'else'.$row['status']; ?>
					<span class="badge badge-success">Active</span> 
					<?php } } ?>
				</td>
				<?php if($this->session->userdata('role') == 1) {?>
				<td>
					<span class="btn btn-success btn-sm btn-labeled fa fa-edit" id="cancel_reason" name="dsr_option_edit" onclick="ajax_html('<?php echo base_url().'admin/dsr_feature_options/edit/'.$row['id'];?>','edit_dsr_option_contents');" data-toggle="modal" data-target="#dsr_option_edit">&nbsp;Edit</span>
					<span class="btn btn-danger btn-xs  far fa-trash-alt" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"> Delete</span>
				</td>
				<?php  } ?>
			</tr> 
			<?php } }?>
		</tbody>
    </table>
    <script>
    $(document).ready(function(){

        $('#dataTable3').DataTable();
        $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
        $("[data-toggle='toggle']").bootstrapToggle();
    })
    </script>