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
                <th>Uploaded By </th>
                <th>Toll Plaza</th>
                <th>Upload Date</th>
                <th>TCR Date</th>
                <th width="10%">Status</th>
                <th width="35%">Action</th>
			</tr>
        </thead>
        <tbody>
            <?php if(isset($tcd)){ $counter = 0; foreach($tcd as $row){ $counter++; ?>
             <tr>
				 <td><?php echo $counter;?></td>
				 <td><?php echo $admin_name; ?></td>
				 <td> <?php echo $tool_name[$counter-1][0]['name'];?></td>
				 <td> <?php echo date('F j, Y',$row['add_date']);?></td>
				 <td> <?php echo  date('F j, Y',strtotime($row['datecreated']));?></td>
				 <td> <?php if($row['status'] == 0){?>
					 <span class="badge badge-primary">Pending</span>
					 <?php }elseif($row['status'] == 1){?>
					 <span class="badge badge-success"> Approved</span>
					 <?php }elseif($row['status'] == 2){?>
					 <span class="badge badge-danger"> Rejected</span>
					 <span class="btn-info btn-xs fa fa-eye" onclick="ajax_html('<?php echo base_url().'admin/tcd/view_reason/'.$row['id'];?>','viewreason_contents');" data-toggle="modal" data-target="#viewreason"> Reason</span>
					 <?php }?>
				 </td>
				 <td>
					 <a href="<?php echo base_url()?>admin/traffic_counter_report/<?php echo $row['id']?>" class="btn-info btn-xs" target="__blank"><i class="fa fa-eye"></i> View</a>
					 <?php if($row['status'] != 2){ ?>
					 <span class="btn-secondary btn-xs fa fa-edit" onclick="ajax_html('<?php echo base_url().'admin/tcd/edit/'.$row['id'];?>','tcdEDIT_contents');" data-toggle="modal" data-target="#tcdEDIT">Edit</span>  
					 <span class="btn-warning btn-xs fa fa-thumbs-down" onclick="ajax_html('<?php echo base_url().'admin/tcd/disapprove/'.$row['id'];?>','dissaprove_contents');" data-toggle="modal" data-target="#dissaprove"> Disapprove</span>   
					 <?php } ?>
					 <?php if($row['status'] != 1){ ?>
					 <span class="btn-success btn-xs fa fa-check" onclick="approve_confirm('Really want to approve this','<?php echo $row['id']; ?>')"> Approve</span>  
					 <?php } ?>
					 <span class="btn-danger btn-xs fa fa-trash" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"> Delete</span>
				 </td>
			</tr> 
			<?php } }else{ } ?>
		</tbody>
    </table>
    <script>
    $(document).ready(function(){
		$('#dataTable3').DataTable();
    })
    </script>
	
	
	<!--<span id = 'show' href="<?php if(isset($show)) echo $show; ?>" class="btn-info float-right btn-sm">Show More</span>
	<?php if(isset($less)){ ?><span id = 'show-less' href="<?php if(isset($less)) echo $less; ?>" class="btn-info float-left btn-sm">Show Less</span> <?php } ?>-->
	<script>
		$('#show').click(function(){
			var count =$(this).attr('href');
			$.ajax({url: "<?php echo base_url()?>admin/tcd/list", type:"POST", data: {count}, async: false, success: function(data){
				$('#list').html(data);
			}});
	});
		$('#show-less').click(function(){
			var count =$(this).attr('href');
			$.ajax({url: "<?php echo base_url()?>admin/tcd/list", type:"POST", data: {count}, async: false, success: function(data){
				$('#list').html(data);
			}});
	});
	</script>