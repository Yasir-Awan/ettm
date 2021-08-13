  <?php include('includes/header.php'); ?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- data table start -->
                    
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Weigh Station</h4>
                                <span class="btn btn-success btn-xs pull-right fa fa-plus" data-toggle="modal" data-target="#weighAdd" onclick="ajax_html('<?php echo base_url()?>admin/weighstation/add/', 'addweigh_contents');">Add New Weigh Station</div>
                                <div class='list' id='list'>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dark table end -->
                </div>
            </div>
        </div>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'admin';
    var module = 'weighstation';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    $(document).ready(function(){
        $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        $("[data-toggle='toggle']").bootstrapToggle();
    });
    $('body').on('click','a.paginate_button',function(){
    //alert();
       $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        $("[data-toggle='toggle']").bootstrapToggle();
        
    });
     $('a.paginate_button').on('click',function(){
    //alert('here');
});
     $('body').on('change', 'input[name=toggle]', function (){
    
    var mode= $(this).prop('checked');
    var id=$( this ).val();
    $.ajax({
      type:'POST',
      url:'<?php echo base_url()?>admin/weighstation/tp_publish_set/' + id + '/' +mode,
      cache       : false,
      contentType : false,
      processData : false,
      
      success:function(data)
      {
        
                var obj = data;
                console.log(data);
                if(obj == 'true'){
                    
                    notify('Active Successfully','success','top','right');
                }else{
                    notify('Inactive Successfully','danger','top','right');
                }
                //progress.html('');
            
      }
    });
  });
     $('body').on('change', 'input[name=toggle1]', function (){
    
    var mode= $(this).prop('checked');
    var id=$( this ).val();
    $.ajax({
      type:'POST',
      url:'<?php echo base_url()?>admin/weighstation/gm_publish_set/' + id + '/' +mode,
      cache       : false,
      contentType : false,
      processData : false,
      
      success:function(data)
      {
        
                var obj = data;
                console.log(data);
                if(obj == 'true'){
                    
                    notify('Active Successfully','success','top','right');
                }else{
                    notify('Inactive Successfully','danger','top','right');
                }
                //progress.html('');
            
      }
    });
  });
  $('body').on('change', 'input[name=toggle2]', function (){
    
    var mode= $(this).prop('checked');
    var id=$( this ).val();
    $.ajax({
      type:'POST',
      url:'<?php echo base_url()?>admin/weighstation/camera_publish_set/' + id + '/' +mode,
      cache       : false,
      contentType : false,
      processData : false,
      
      success:function(data)
      {
                var obj = data;
                console.log(data);
                if(obj == 'true'){ 
                    notify('Active Successfully','success','top','right');
                }else{
                    notify('Inactive Successfully','danger','top','right');
                }
                //progress.html('');
      }
    });
  });
$(document).ready(function(){
            $.ajax({ 
            
            url: "<?php echo base_url();?>admin/weighstation/list",
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                var top = '200';
                $('#list').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
            },
            success: function(data) {
                //console.log(data);
                $('#list').html(data);
                 $('#dataTable3').DataTable();
                  $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                    $("[data-toggle='toggle']").bootstrapToggle();
            },
            error: function(e) {
                console.log(e)
            }
            });
        });
</script>
<div class="modal fade" id="weighAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Weigh Station</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="addweigh_contents">
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="weigh_edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Weigh Station</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="edit_weigh_contents">
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

        <!-- footer area start-->
   <?php include('includes/footer.php')?>      