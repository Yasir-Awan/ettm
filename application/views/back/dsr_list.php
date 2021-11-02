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
                <th>Reason for Delay</th>
                <th>DSR Date</th>
				<th>Supervised Date</th>
                <th width="10%">Status</th>
                <th width="30%">Action</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if($dsr['dsr']){
              //echo "<pre>";
             /// print_r($dsr); exit;
                $counter = 0;
                foreach($dsr['dsr'] as $row){

                      $counter++;

                        
                          
                        $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza_id']))->row()->name;
                        

            ?>
             <tr>
                <td><?php echo $counter;?></td>
                <td>
					<?php
					$this->db->select('fname, lname');
					$this->db->from('tpsupervisor');
					$this->db->where('id', $row['supervisor_id']);
					$upload_name = $this->db->get()->result_array();
					$this->db->select('role');
					$this->db->from('tpsupervisor');
					$this->db->where('id', $row['supervisor_id']);
                          $role = $this->db->get()->result_array();
					
                          echo $upload_name[0]['fname'].' '.$upload_name[0]['lname'].' '; if($role[0]['role'] == 2){ echo "(Technical Manager)"; } elseif($role[0]['role'] == -1){ echo "(Technician)"; } elseif($role[0]['role'] == 1) { echo '(Site Incharge)';} elseif($role[0]['role'] == 0) { echo "(Supervisor)";};
                       ?>
				 </td>
                <td> <?php echo $toolplaza_name;?></td>
                <td> <?php echo date('F j, Y g:i a',$row['created_at']);?></td>
                <td> <?php echo $row['toll_delay'];?></td>
                <td> <?php echo  date('F j, Y',strtotime($row['datecreated']));?></td>
				<td> <?php if($row['supervised_at'] != ''){ echo date('F j, Y g:i a',$row['supervised_at']); }
					elseif($row['updated_at'] != '' && $row['status'] == 1){ echo date('F j, Y',$row['updated_at']); }?></td>
                <td> <?php if($row['status'] == 0){?>
                         <span class="badge badge-primary">Pending</span>

                          <?php }elseif($row['status'] == 1){?>
                          <span class="badge badge-success"> Approved</span>
                          <?php }elseif($row['status'] == 2){?>
                          
                            <span class="badge badge-danger"> Rejected</span>
                              <span class="btn-info btn-xs fa fa-eye" onclick="ajax_html('<?php echo base_url().'admin/dsr/view_reason/'.$row['id'];?>','viewreason_contents');" data-toggle="modal" data-target="#viewreason"> Reason</span>
                         <?php }?>
                </td>
                <td>
                          <a href="<?php echo base_url()?>admin/daily_site_report/<?php echo $row['id']?>" class="btn-info btn-xs" target="__blank"><i class="fa fa-eye"></i> View</a>
                            <!--a href="<?php echo base_url()?>uploads/dsr/<?php echo $row['file'];?>" style="background-color: #6c757d" class="btn-info btn-xs fa fa-paperclip" target="__blank"> View Attachment</a-->
                            <?php 
                                  if($row['status'] != 2){
                            ?>

                            <span class="btn-warning btn-xs fa fa-thumbs-down" onclick="ajax_html('<?php echo base_url().'admin/dsr/disapprove/'.$row['id'];?>','dissaprove_contents');" data-toggle="modal" data-target="#dissaprove"> Disapprove</span>        
                            <?php  
                                  }
                            ?>

                            <?php 
                                  if($row['status'] != 1){
                            ?>

                            <span class="btn-success btn-xs fa fa-check" onclick="approve_confirm('Really want to approve this','<?php echo $row['id']; ?>')"> Approve</span>       
                            <?php  
                                  }
                            ?>
                          <span class="btn-danger btn-xs fa fa-trash" onclick="delete_confirm('Really want to delete This','<?php echo $row['id']; ?>')"> Delete</span>
                        </td>
                
            </tr> 
            <?php    }
            }?>
           
        </tbody>
    </table>
    <script>
    $(document).ready(function(){
        //$.fn.dataTable.luxon( 'F j, Y g:i a' );
        $('#dataTable3').DataTable();
    })
    </script>
	
	
	<span id = 'show' href="<?php if(isset($dsr['feat']['show'])) echo $dsr['feat']['show']; ?>" class="btn-info float-right btn-sm">Show More</span>
	<?php if(isset($dsr['feat']['less'])){ ?><span id = 'show-less' href="<?php if(isset($dsr['feat']['less'])) echo $dsr['feat']['less']; ?>" class="btn-info float-left btn-sm">Show Less</span> <?php } ?>
	<script>
		$('#show').click(function(){
			var count =$(this).attr('href');
			$.ajax({url: "<?php echo base_url()?>admin/dsr/list", type:"POST", data: {count}, async: false, success: function(data){
				$('#list').html(data);
			}});
	});
		$('#show-less').click(function(){
			var count =$(this).attr('href');
			$.ajax({url: "<?php echo base_url()?>admin/dsr/list", type:"POST", data: {count}, async: false, success: function(data){
				$('#list').html(data);
			}});
	});
	</script>