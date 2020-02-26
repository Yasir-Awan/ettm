<?php include('includes/header.php'); ?>
<style>
.card label {
    font-size: 0.8571em;
    margin-bottom: 5px;
    color: #000;
    font-weight: 600;
}
</style>
<?php 
$toll = $this->db->get_where('toolplaza',array('id' => $session_data[0]['tollplaza']))->row()->name;
?>
<div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
               <!--  <h4 class="card-title"> Monthly Traffic Report</h4> -->
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="card-title">Traffic Counting Session</h4>
                    </div>
                                    
                </div>
              </div>
              <div class="card-body">
                  <div class="row">
                    <?php 
                      if($error){
                        echo '<div class="col-md-12"><div class="alert alert-danger" role="alert">'.$error.'</div></div>';
                      }else{

                    ?>
                    <div class="col-md-12">
                      <table class="table">
                        <tr>
                          <td width="33%">
                            <div class="form-group">
                              <label>TollPlaza</label>
                              <select class="form-control" name="tp" id="tb" readonly>
                                <option value="<?php echo $session_data[0]['tollplaza']?>"><?php echo $toll;?></option>
                              </select>
                             </div>
                          </td>
                          <td width="33%">
                            <div class="form-group">
                              <label>Video Date</label>
                               <input type="text" class="form-control" name="date" id="date" value="<?php echo date('d/m/Y',$session_data[0]['video_start_date']);?>" readonly/>
                            </div>
                          </td>
                          <td>
                            <div class="form-group" width="33%">
                              <label>Video Time</label>
                               <input type="time" class="form-control" name="time" id="time" value="<?php echo date('h:i:s',$session_data[0]['video_start_date']);?>" readonly/>
                            </div>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <?php echo form_open_multipart(base_url().'member/mtr/do_add', array('id' => 'add_mtr', 'method' => 'post'));?>
                        <table class="table">
                          <tr>
                            <input type="hidden" name="session_id" id="session_id" value="<?php echo $insert_id;?>">
                            <td width="50%">
                            
                                <div class="form-group" >
                                   <label><span style="color: red;">Press key 1 for:</span><br/>Class1 (Cars)</label>
                                   <input type="number" class="form-control required" name="class1" id="class1" value="<?php echo $session_data[0]['class1']?>" readonly/> 
                                </div>
                              
                            </td>
                            <td>
                             
                                <div class="form-group" >
                                   <label><span style="color: red;">Press key 2 for:</span><br/>Class2 (Wagon, Hiace)</label>
                                   <input type="number" class="form-control required" name="class2" id="class2" value="<?php echo $session_data[0]['class2']?>" readonly /> 
                                </div>
                            
                            </td>
                            </tr>
                            <tr>
                            <td>
                             
                                <div class="form-group" >
                                   <label><span style="color: red;">Press key 3 for:</span><br/>Class3 (Bus, Coaster)</label>
                                   <input type="number" class="form-control required" name="class3" id="class3" value="<?php echo $session_data[0]['class3']?>"  readonly/> 
                                </div>
                            </td>
                            <td>
                                <div class="form-group" >
                                   <label><span style="color: red;">Press key 4 for:</span><br/>Class4 (Tractor Trolly, 2 Axle, 3 Axle Truck)</label>
                                   <input type="number" class="form-control required" name="class4" id="class4" value="<?php echo $session_data[0]['class4']?>" readonly/> 
                                </div>
                          
                            </td>
                            </tr>
                            <tr>
                            <td>
                           
                                <div class="form-group" >
                                   <label><span style="color: red;">Press key 5 for</span><br/>Class5 (3 Axle Articulated, 4 Axle Articulated, 5 Axle Articulated, 6 Axle Articulated Truck)</label>
                                   <input type="number" class="form-control required" name="class5" id="class5" value="<?php echo $session_data[0]['class5']?>" readonly/> 
                                </div>
                             
                            </td>
                            </tr>
                          </table>  
                          <span class="btn btn-info btn-sm pull-right" id="submit" data-toggle="modal" data-target="#counterup" onclick="ajax_html('<?php echo base_url()?>member/traffic_counting/update/<?php echo $session_data[0]['id'];?>', 'counterup_contents');">Update Session</span>                  
                      </form>
                    </div>
                  </div>
                  <?php } ?>
              </div>
            </div>
          </div>
          
        </div>
      </div>
<?php include('includes/footer.php');?>  
<script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'member';
    var module = 'traffic_counting';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    var approve_cnt_fun = 'approve';
   
     $('a.paginate_button').on('click',function(){
    //alert('here');
});
  document.onkeypress=function(e){
    if(!$('#counterup').is(':visible')){
      if(e.keyCode === 49 || e.keyCode === 50 || e.keyCode === 51 || e.keyCode === 52 || e.keyCode === 53){
        var data =  [];
        var val = '';
        var sess_id = $('#session_id').val();
        if(e.keyCode === 49){
          val = (parseInt($('#class1').val()) + 1);
          data.push({
            key:   "class1",
            value: val
          });  
          $('#class1').val(val);
        }else if(e.keyCode === 50){
          val = (parseInt($('#class2').val()) + 1);
          data.push({
            key:   "class2",
            value: val
          });  
          $('#class2').val(val);
          
        }else if(e.keyCode === 51){
          val = (parseInt($('#class3').val()) + 1);
          data.push({
            key:   "class3",
            value: val
          });  
          $('#class3').val(val);
         
        }else if(e.keyCode === 52){
          val = (parseInt($('#class4').val()) + 1);
          data.push({
            key:   "class4",
            value: val
          });
          $('#class4').val(val);  
          
        }else if(e.keyCode === 53){
          val = (parseInt($('#class5').val()) + 1);
            data.push({
            key:   "class5",
            value: val
          });  
          $('#class5').val(val);      
        }
        
          $.ajax({ 
                url: "<?php echo base_url();?>member/traffic_counting/traffic_add", // form action url
                type: 'POST', // form submit method get/post
                 // request type html/json/xml
                data: {result:JSON.stringify(data),session:sess_id},
                beforeSend: function() {
                    var top = '200';
                    $('.list').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
                },
                success: function(data) {
                    //console.log(data);
                    $('.list').html(data);
                                    
                },
                error: function(e) {
                    console.log(e)
                }
            });
        }
    }

}   
</script>

<div class="modal fade" id="counterup">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Traffic Counting Session</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="counterup_contents">
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mtrEDIT">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Monthly Traffic Report</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="mtrEDIT_contents">
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewreason">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reason</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="viewreason_contents">
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="support">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supporting Documents</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="support_contents">
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        <!-- footer area start-->
       