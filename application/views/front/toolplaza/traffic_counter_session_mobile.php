<?php include('includes/header.php'); ?>
<style>
.card label {
    font-size: 0.8571em;
    margin-bottom: 5px;
    color: #000;
    font-weight: 600;
}

.custom_mobile{
  padding: 0px 0px !important;
  vertical-align: top !important;
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
            <div class="card hide-on-landscape">
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
                      <?php echo form_open_multipart(base_url().'toolplaza/mtr/do_add', array('id' => 'add_counter_p', 'method' => 'post'));?>
                        <table class="table">
                          <tr>
                            <input type="hidden" name="session_id" id="session_id" value="<?php echo $insert_id;?>">
                            <td width="50%" class="custom_mobile">
                            
                                <div class="form-group" >
                                   <label><span style="color: red;">Press Class 1 for:</span><br/>Class1 (Cars)</label>
                                   <input type="number" class="form-control required" name="class1" id="class1_p" value="<?php echo $session_data[0]['class1']?>" readonly/> 
                                </div>
                              
                            </td>
                            <td class="custom_mobile">
                             
                                <div class="form-group" >
                                   <label><span style="color: red;">Press Class 2 for:</span><br/>Class2 (Wagon, Hiace)</label>
                                   <input type="number" class="form-control required" name="class2" id="class2_p" value="<?php echo $session_data[0]['class2']?>" readonly /> 
                                </div>
                            
                            </td>
                            </tr>
                            <tr>
                            <td class="custom_mobile">
                             
                                <div class="form-group" >
                                   <label style="line-height: 2.25;"><span style="color: red;">Press Class 3 for:</span><br/>Class3 (Bus, Coaster)</label>
                                   <input type="number" class="form-control required" name="class3" id="class3_p" value="<?php echo $session_data[0]['class3']?>"  readonly/> 
                                </div>
                            </td>
                            <td class="custom_mobile">
                                <div class="form-group" >
                                   <label><span style="color: red;">Press Class 4 for:</span><br/>Class4 (Tractor,2,3 Axle Truck)</label>
                                   <input type="number" class="form-control required" name="class4" id="class4_p" value="<?php echo $session_data[0]['class4']?>" readonly/> 
                                </div>
                          
                            </td>
                            </tr>
                            <tr>
                            <td class="custom_mobile" colspan="2">
                           
                                <div class="form-group" >
                                   <label><span style="color: red;">Press Class 5 for</span><br/>Class5 (3, 4, 5, 6 Axle Art Truck)</label>
                                   <input type="number" class="form-control required" name="class5" id="class5_p" value="<?php echo $session_data[0]['class5']?>" readonly/> 
                                </div>
                             
                            </td>
                            </tr>
                          </table>
                          <table class="table">
                        <tr>
                          <td>
                            <span class="btn btn-success add_counter_p" id="class_1_p">Class1</span>
                          </td>
                          <td>
                            <span class="btn btn-success add_counter_p" id="class_2_p">Class2</span>
                          </td>
                          <td>
                            <span class="btn btn-success add_counter_p" id="class_3_p">Class3</span>
                          </td>

                        </tr>
                        <tr>
                          <td>
                            <span class="btn btn-success add_counter_p" id="class_4_p">Class4</span>
                          </td>
                          <td>
                            <span class="btn btn-success add_counter_p" id="class_5_p">Class5</span>
                          </td>
                        </tr>
                      </table>  
                          <span class="btn btn-info btn-sm pull-right" id="submit" data-toggle="modal" data-target="#counterup" onclick="ajax_html('<?php echo base_url()?>toolplaza/traffic_counting/update/<?php echo $session_data[0]['id'];?>', 'counterup_contents');">Update Session</span>                  
                      </form>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
                    </div>
                  </div>
                  <?php } ?>
              </div>
            </div>





            <div class="card hide-on-portrait">
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
                      <table class="table" style="padding-top:0px; padding-bottom:0px; margin-bottom:0px">
                        <tr>
                          <td width="33%" class="custom_mobile">
                            <div class="form-group" style="margin-bottom:0px">
                              <label>TollPlaza</label>
                              <select class="form-control" name="tp" id="tb" readonly>
                                <option value="<?php echo $session_data[0]['tollplaza']?>"><?php echo $toll;?></option>
                              </select>
                             </div>
                          </td>
                          <td width="33%" class="custom_mobile">
                            <div class="form-group" style="margin-bottom:0px">
                              <label>Video Date</label>
                               <input type="text" class="form-control" name="date" id="date" value="<?php echo date('d/m/Y',$session_data[0]['video_start_date']);?>" readonly/>
                            </div>
                          </td>
                          <td class="custom_mobile">
                            <div class="form-group style="margin-bottom:0px"" width="33%">
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
                      <?php echo form_open_multipart(base_url().'toolplaza/mtr/do_add', array('id' => 'add_mtr', 'method' => 'post'));?>
                        <table class="table" style="padding-top:0px; padding-bottom:0px; margin-bottom:0px">
                          <tr>
                            <input type="hidden" name="session_id" id="session_id" value="<?php echo $insert_id;?>">
                            <td width="33%" class="custom_mobile">
                            
                                <div class="form-group" >
                                   <label><span style="color: red;">Press Class 1 for:</span><br/>Class1 (Cars)</label>
                                   <input type="number" class="form-control required" name="class1" id="class1_l" value="<?php echo $session_data[0]['class1']?>" readonly/> 
                                </div>
                              
                            </td>
                            <td class="custom_mobile">
                             
                                <div class="form-group" >
                                   <label><span style="color: red;">Press Class 2 for:</span><br/>Class2 (Wagon, Hiace)</label>
                                   <input type="number" class="form-control required" name="class2" id="class2_l" value="<?php echo $session_data[0]['class2']?>" readonly /> 
                                </div>
                            
                            </td>
                            <td class="custom_mobile">
                             
                                <div class="form-group" >
                                   <label><span style="color: red;">Press Class 3 for:</span><br/>Class3 (Bus, Coaster)</label>
                                   <input type="number" class="form-control required" name="class3" id="class3_l" value="<?php echo $session_data[0]['class3']?>"  readonly/> 
                                </div>
                            </td>
                            </tr>
                            <tr>
                            
                            <td class="custom_mobile">
                                <div class="form-group" >
                                   <label><span style="color: red;">Press Class 4 for:</span><br/>Class4 (Tractor,2,3 Axle Truck)</label>
                                   <input type="number" class="form-control required" name="class4" id="class4_l" value="<?php echo $session_data[0]['class4']?>" readonly/> 
                                </div>
                          
                            </td>
                            <td class="custom_mobile" colspan="2">
                           
                                <div class="form-group" >
                                   <label><span style="color: red;">Press Class 5 for</span><br/>Class5 (3, 4, 5, 6 Axle Art Truck)</label>
                                   <input type="number" class="form-control required" name="class5" id="class5_l" value="<?php echo $session_data[0]['class5']?>" readonly/> 
                                </div>
                             
                            </td>
                            </tr>
                            
                          </table>
                          <table class="table" style="margin-bottom:0px">
                            <tr>
                              <td style="padding-top:0px;">
                                <span class="btn btn-success add_counter_l" id="class_1_l">Class1</span>
                              </td>
                              <td style="padding-top:0px;">
                                <span class="btn btn-success add_counter_l" id="class_2_l">Class2</span>
                              </td>
                              <td style="padding-top:0px;">
                                <span class="btn btn-success add_counter_l" id="class_3_l">Class3</span>
                              </td>
                              <td style="padding-top:0px;">
                                <span class="btn btn-success add_counter_l" id="class_4_l">Class4</span>
                              </td>
                              <td style="padding-top:0px;">
                                <span class="btn btn-success add_counter_l" id="class_5_l">Class5</span>
                              </td>
                            </tr>
                            
                          </table>  
                          <span class="btn btn-info btn-sm pull-right" id="submit" data-toggle="modal" data-target="#counterup" onclick="ajax_html('<?php echo base_url()?>toolplaza/traffic_counting/update/<?php echo $session_data[0]['id'];?>', 'counterup_contents');">Update Session</span>                  
                      </form>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      
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
    var user_type = 'toolplaza';
    var module = 'traffic_counting';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    var approve_cnt_fun = 'approve';
   
     $('a.paginate_button').on('click',function(){
    //alert('here');
});
  $('body').on('click','.add_counter_p',function(){
    var data =  [];
    var val = '';
    
    var sess_id = $('#session_id').val();
    if(this.id == 'class_1_p'){
      val = (parseInt($('#class1_p').val()) + 1);
      data.push({
        key:   "class1",
        value: val
      });  
      $('#class1_p').val(val);
    }else if(this.id == 'class_2_p'){
      val = (parseInt($('#class2_p').val()) + 1);
      data.push({
        key:   "class2",
        value: val
      });  
      $('#class2_p').val(val);
      
    }else if(this.id == 'class_3_p'){
      val = (parseInt($('#class3_p').val()) + 1);
      data.push({
        key:   "class3",
        value: val
      });  
      $('#class3_p').val(val);
     
    }else if(this.id == 'class_4_p'){
      val = (parseInt($('#class4_p').val()) + 1);
      data.push({
        key:   "class4",
        value: val
      });
      $('#class4_p').val(val);  
      
    }else if(this.id == 'class_5_p'){
      val = (parseInt($('#class5_p').val()) + 1);
        data.push({
        key:   "class5",
        value: val
      });  
      $('#class5_p').val(val);      
    }
    
      $.ajax({ 
            url: "<?php echo base_url();?>toolplaza/traffic_counting/traffic_add", // form action url
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
});   
  $('body').on('click','.add_counter_l',function(){
    var data =  [];
    var val = '';
    
    var sess_id = $('#session_id').val();
    if(this.id == 'class_1_l'){
      val = (parseInt($('#class1_l').val()) + 1);
      data.push({
        key:   "class1",
        value: val
      });  
      $('#class1_l').val(val);
    }else if(this.id == 'class_2_l'){
      val = (parseInt($('#class2_l').val()) + 1);
      data.push({
        key:   "class2",
        value: val
      });  
      $('#class2_l').val(val);
      
    }else if(this.id == 'class_3_l'){
      val = (parseInt($('#class3_l').val()) + 1);
      data.push({
        key:   "class3",
        value: val
      });  
      $('#class3_l').val(val);
     
    }else if(this.id == 'class_4_l'){
      val = (parseInt($('#class4_l').val()) + 1);
      data.push({
        key:   "class4",
        value: val
      });
      $('#class4_l').val(val);  
      
    }else if(this.id == 'class_5_l'){
      val = (parseInt($('#class5_l').val()) + 1);
        data.push({
        key:   "class5",
        value: val
      });  
      $('#class5_l').val(val);      
    }
    
      $.ajax({ 
            url: "<?php echo base_url();?>toolplaza/traffic_counting/traffic_add", // form action url
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
});

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
       