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
                <th>Toolplaza</th>
                <th>Effective From</th>
                <th>Effective To</th>
                <th>Last Updated</th>
                <th style="width: 20%;">Action</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if($terrif){
                $counter = 0;
                foreach($terrif as $row){
                $counter++;
                $toolplazas = explode(',', $row['toolplaza']);    
            ?>
             <tr>
                <td><?php echo $counter; ?></td>
                <td><?php  foreach($toolplazas as $value){
                    @$tp_name = @$this->db->get_where('toolplaza',array('id' => $value))->row()->name;
                    ?>
                    <span class="badge badge-secondary"><?php echo $tp_name; ?></span>
                    <?php }?>
                </td>
                <td><?php echo date('F j, Y',strtotime(str_replace('/', '-', $row['start_date'])));?></td>
                <td><?php echo date('F j, Y',strtotime(str_replace('/', '-', $row['end_date'])));?></td>
                <td><?php echo date('F j, Y, g:i a',$row['date']);?></td>
                <td>
                    <span style="cursor:pointer;" class="btn-success btn-sm pull-right fa fa-eye" data-toggle="modal" data-target="#viewterrif" onclick="ajax_html('<?php echo base_url()?>admin/tarrif/view/<?php echo $row['id']?>', 'viewterrif_contents');">View</span>
                    <?php if($this->session->userdata('role') == 1) {?>
                    <span style="cursor:pointer;" class="btn-info btn-sm pull-right fa fa-edit" data-toggle="modal" data-target="#editterrif" onclick="ajax_html('<?php echo base_url()?>admin/tarrif/edit/<?php echo $row['id']?>', 'editterrif_contents');">Edit</span>
                <?php  } ?>     
                </td>
            </tr>
              
           <?php
                }
            } ?>
        </tbody>
    </table>
    <script>
    $(document).ready(function(){

        $('#dataTable3').DataTable();
    })
    </script>