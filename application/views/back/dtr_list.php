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
                <th>Supervise Date</th>
                <th>DTR Date</th>
                <th width="15%">Status</th>
                <th width="30%">Action</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if($dtr){
              
                $counter = 0;
                foreach($dtr['dtr'] as $row){
                      //echo "<pre>"; echo print_r($row); exit;
                      $counter++;

                        

            ?>
             <tr>
                <td><?php echo $counter;?></td>
                <td>
                  <?php
                        echo $row->getUser();
                         // print_r($upload_name);

                        
                       ?></td>
                <td><?php echo $row->getToolplazaName();?></td>
                <td><?php echo date('F j, Y, g:i a',$row->getAddDate()); ?></td>
                <td><?php echo $row->getTollDelay(); ?></td>
                <td><?php if($row->getActionDate() != '') echo date('F j, Y, g:i a',$row->getActionDate());  ?></td>
                <td> <?php if($row->getForDate() != '') echo date('F j, Y',strtotime($row->getForDate()));?></td>
                <td> 
                         <span class="badge <?php echo $row->getHtmlClass(); ?>"><?php echo $row->getState(); ?></span>

                          
                        <?php if($row->getStatus() == 2){ ?>
                              <span class="btn-info btn-xs fa fa-eye" onclick="ajax_html('<?php echo base_url().'admin/dtr/view_reason/'.$row->getId();?>','viewreason_contents');" data-toggle="modal" data-target="#viewreason"> Reason</span>
                        <?php } ?> 
                </td>
                <td>
                          <a href="<?php echo base_url()?>admin/daily_traffic_report/<?php echo $row->getId()?>" class="btn-info btn-xs" target="__blank"><i class="fa fa-eye"></i> View</a>
                            <a href="<?php echo base_url()?>uploads/dtr/<?php echo $row->getFile();?>" style="background-color: #6c757d" class="btn-info btn-xs fa fa-paperclip" target="__blank"> View Attachment</a>
                            <?php 
                                  if($row->getStatus() != 2){
                            ?>
<?php if($this->session->userdata('role') == 1) {?>
                            <span class="btn-warning btn-xs fa fa-thumbs-down" onclick="ajax_html('<?php echo base_url().'admin/dtr/disapprove/'.$row->getId();?>','dissaprove_contents');" data-toggle="modal" data-target="#dissaprove"> Disapprove</span>        
                            <?php  
                                  }
                                }
                            ?>
                            <?php 
                                  if($row->getStatus() != 1){

                                    if($this->session->userdata('role') == 1) {
                            ?>
                           
                            <span class="btn-success btn-xs fa fa-check" onclick="approve_confirm('Really want to approve this','<?php echo $row->getId(); ?>')"> Approve</span>       
                            <?php  
                                  }
                                }
                            ?>
                        
                          <?php if($row->getSupportDocument() !== NULL){?>
                          <span class="btn-primary btn-xs fa fa-eye" style="background-color: #820484;" onclick="ajax_html('<?php echo base_url().'admin/view_dtrsupporting/'.$row->getId();?>','support_contents');" data-toggle="modal" data-target="#support"> Suppporting Files</span>
                          <?php } ?>
                          <?php if($this->session->userdata('role') == 1) {?>
                          <span class="btn-danger btn-xs fa fa-trash" onclick="delete_confirm('Really want to delete This','<?php echo $row->getId(); ?>')"> Delete</span>
                          <?php  } ?>
                        </td>
                
            </tr> 
            <?php    }
            }?>
           
        </tbody>
    </table>
    <script>
    $(document).ready(function(){

        $('#dataTable3').DataTable();
    })
    </script>
    <span id = 'show' href="<?php if(isset($dtr['feat']['show'])) echo $dtr['feat']['show']; ?>" class="btn-info float-right btn-sm">Show More</span>
	<?php if(isset($dtr['feat']['less'])){ ?><span id = 'show-less' href="<?php if(isset($dtr['feat']['less'])) echo $dtr['feat']['less']; ?>" class="btn-info float-left btn-sm">Show Less</span> <?php } ?>
	<script>
		$('#show').click(function(){
			var count =$(this).attr('href');
			$.ajax({url: "<?php echo base_url()?>admin/dtr/list", type:"POST", data: {count}, async: false, success: function(data){
				$('#list').html(data);
			}});
	});
		$('#show-less').click(function(){
			var count =$(this).attr('href');
			$.ajax({url: "<?php echo base_url()?>admin/dtr/list", type:"POST", data: {count}, async: false, success: function(data){
				$('#list').html(data);
			}});
	});
	</script>