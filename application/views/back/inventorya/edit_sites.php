<?php echo form_open(base_url()."inventory/edit_site_do/".$site[0]['id'],array('id' => 'edit_sites'));?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Name</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control" value='<?php echo $site[0]['name']?>' 
               type="text" name="site_name" id="site_name">
             </div>
          </div>
          <br>
        </div>

        <?php 
              
              $locations = $this->db->select('*')->where('site',$site[0]['id'])->get('locations')->result_array();  
              // echo "<pre>"; print_r($location); exit;
              if($locations){
              ?>
                <div class="row" id="supporting_file_list">
                     <div class="col-md-8">
                        <table class="table">
                          
                          <tbody>
                            <?php 
                              foreach ($locations as  $location) {            
                            ?>
                       <tr >
                            <td style="border:none !important;">  
                        <div class="form-group">
                          <div class="row">
                          <div class='col-md-3'>
                            <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Name</label>
                            </div>
                           <div class="col-md-8 ">
                            
                        <!-- <label>Supporting document name <span class="text-info">(Optional)</optional</label> -->
                            <input type="text" name="site_location_name[]" id="location_0" class="form-control classes" value="<?php echo $location['location'] ; ?>" placeholder="Enter Location Name" >
                            <input type="hidden" name="site_location_id[]" id="location_0" class="form-control classes" value="<?php echo $location['id'] ; ?>" placeholder="Enter Location Name" >
                            </div>
                          </div>
                         </td>
                      </tr>
                    <?php 
                      }       
                   } 
                   ?>     
              </tbody>
            </table>
          <div class="form-group">
              <div class='row'>
                <!-- <div class='col-md-3'>
                   <a href="javascript:void(0);" class="btn btn-xs btn-info " title="Add More Location" onclick="addFormulaProcedures();" data-toggle="tooltip">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add More Location
                  </a>   
                 </div> -->
                <div class="col-md-8">
                  <div id="dynamicInput2"></div> 
                   <input type="hidden" name="theValue" id="theValue" value="0"/>
                   <input type="hidden" name="theValue2" id="theValue2" value="0"/>
                 </div>
              </div>
            </div>
           <br>
                      </div>
                  </div>
                 
                 
                

        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('edit_sites');">Update Site</button>
          <?php echo form_close();?>
          


          <script>
  function addFormulaProcedures() {
    var ni = document.getElementById('dynamicInput2');
    var numi = document.getElementById('theValue2');
    
    var num = (document.getElementById("theValue2").value -1)+ 2;
    numi.value = num;
    var num2=num+1; 
    var divIdName = "my"+num+"Div";
    var newdiv = document.createElement('div');
    newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = '<div id='+divIdName+' class="row"><div class="col-md-8 "><div class="form-group" style="margin-top:25px;"><label>Location Name <span class="text-info"></optional</label><input type="text" name="site_location_name[]" id="location_0" class="form-control classes required" placeholder="Enter Location Name" ></div></div><div class="col-md-3  wrap-input-container" style="margin-top:50px;"><a href="javascript:void(0);" class="btn btn-xs btn-danger" title="Remove File" onclick="minusValueFrom('+num+');" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i>Remove</a></div></div>';
  ni.appendChild(newdiv);
  
  } 

  var subtractValue;
  function minusValueFrom(idd_v) {
    //alert(idd_v);
    var totalCostVal;
    var subTotalCost;
    var new_cost;
    var nxt_check = '';
    
  
    //remove div
    n = idd_v + 1;
    nxt_check = document.getElementById('total_cost_'+n);
    var d = document.getElementById('dynamicInput2');
    var olddiv = document.getElementById('my'+idd_v+'Div');

    d.removeChild(olddiv);
    var numi = document.getElementById('theValue2');
    var num = document.getElementById("theValue2").value;
    if(nxt_check == null){
      numi.value = num-1;  
    }else{
      numi.value = num;
    }
          
  }

</script>