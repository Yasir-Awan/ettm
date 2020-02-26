  <?php include('includes/header.php'); ?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- data table start -->
                    
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Roads</h4>
                                <?php if($this->session->userdata('role') == 1){?>
                                     <a class="btn btn-success btn-xs pull-right fa fa-plus" href="<?php echo base_url()?>admin/googleroads/add" />Add New Road </a></div>
                                <?php } ?>
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
<div id="infowindow-content">
    <img src="" width="16" height="16" id="place-icon">
    <span id="place-name" class="title"></span><br>
    <span id="place-address"></span>
</div>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'admin';
    var module = 'googleroads';
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
      url:'<?php echo base_url()?>admin/googleroads/tp_publish_set/' + id + '/' +mode,
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
            url: "<?php echo base_url();?>admin/googleroads/list",
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

        <!-- footer area start-->
   <?php include('includes/footer.php')?>      