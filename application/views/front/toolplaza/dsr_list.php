<div class="table-responsive"> 
	<table class="table" id="dataTable3" width="100%">
		<thead class=" text-primary">
			<th>No</th><th>Uploaded By</th><th>Toll Plaza</th><th>Upload Timed</th><th>Upload Date</th><th>Status</th><th>Action</th>
		</thead>
		<tbody>
			<?php $counter = 0; foreach($dsr as $row){ $counter++; $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza_id']))->row()->name; ?>
			<tr> 
				<td> <?php echo $counter;?> </td> 
				<td> <?php $this->db->select('fname, lname'); $this->db->from('tpsupervisor'); $this->db->where('id', $row['supervisor_id']); $upload_name = $this->db->get()->result_array(); $this->db->select('role'); $this->db->from('tpsupervisor'); $this->db->where('id', $row['supervisor_id']); $role = $this->db->get()->result_array(); echo $upload_name[0]['fname'].' '.$upload_name[0]['lname'].' '; if($role[0]['role'] == 2){ echo "(Technical Manager)"; } elseif($role[0]['role'] == -1){ echo "(Technician)"; } elseif($role[0]['role'] == 1) { echo '(Site Incharge)';} elseif($role[0]['role'] == 0) { echo "(Supervisor)";}?> </td> 
				<td> <?php echo $toolplaza_name;?> </td> 
				<td> <?php echo  date("F j, Y", $row['created_at']); ?> </td> 
				<td> <?php echo   date('F j, Y',strtotime($row['datecreated']));?> </td> 
				<td> <?php if($row['status'] == 0){?> <span class="badge badge-primary">Pending</span> <?php }elseif($row['status'] == 1){?> <span class="badge badge-success">Approved</span> <?php }elseif($row['status'] == 2){?> <span class="badge badge-danger">Rejected</span> <span class="btn btn-info" style="padding: 1px 5px;font-size: 12px; line-height: 1.5;border-radius: 3px;" onclick="ajax_html('<?php echo base_url().'toolplaza/dsr/view_reason/'.$row['id'];?>','viewreason_contents');" data-toggle="modal" data-target="#viewreason"><i class="fa fa-eye"></i>Reason</span> <?php }?> </td> 
				<td> <a href="<?php echo base_url()?>toolplaza/daily_site_report/<?php  echo $row['id']?>" class="btn btn-success btn-sm" target="__blank"><i class="fa fa-eye"></i>View</a> <?php if($row['status'] != 1 /*&& $row['upload_type'] == 1 */&& $row['supervisor_id'] == $this->session->userdata('supervisor_id')){ if($row['status'] == 2){?> <span class="btn btn-info btn-sm" onclick="ajax_html('<?php echo base_url().'toolplaza/dsr/edit/'.$row['id'];?>','dsrEDIT_contents');" data-toggle="modal" data-target="#dsrEDIT"><i class="fa fa-edit"></i>Edit</span> <?php } ?> <span class="btn btn-danger btn-sm" style="margin-top:1%;" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"><i class="fa fa-trash" ></i>Delete</span>  <?php } ?> </td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<script>
	$(document).ready(function(){
		$('#dataTable3').DataTable();
	});
</script>