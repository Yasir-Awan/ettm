 <?php include('includes/header.php');?>
<div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Faulty Equipment List</h4>
                <span class="btn btn-success btn-sm pull-right"  data-toggle="modal" data-target="#faultyAdd" onclick="ajax_html('<?php echo base_url()?>toolplaza/faulty_equipment_list/add/', 'faultyAdd_contents');"><i class="fa fa-plus"></i>Add New List</span>
              </div>
              <div class="card-body">
                <div id="list"></div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      
<?php include('includes/footer.php');?>
<script>
      var table = $('#dataTable').DataTable({
   drawCallback: function(){
      $('.paginate_button', this.api().table().container())          
         .on('click', function(){
      //$("[data-toggle='toggle']").bootstrapToggle('destroy'); 
    //$("[data-toggle='toggle']").bootstrapToggle();
           
         });       
   }
}); 
      </script>

      <script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'toolplaza';
    var module = 'faulty_equipment_list';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    $(document).ready(function(){
        //$("[data-toggle='toggle']").bootstrapToggle('destroy'); 
        //$("[data-toggle='toggle']").bootstrapToggle();
    });
    $('body').on('click','a.paginate_button',function(){
    //alert();
       //$("[data-toggle='toggle']").bootstrapToggle('destroy'); 
       // $("[data-toggle='toggle']").bootstrapToggle();
        
    });
     $('a.paginate_button').on('click',function(){
    //alert('here');
});

$(document).ready(function(){
            $.ajax({ 
            url: "<?php echo base_url();?>toolplaza/faulty_equipment_list/list",
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
                  ////$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
                  //$("[data-toggle='toggle']").bootstrapToggle();
                                
            },
            error: function(e) {
                console.log(e)
            }
            });
        
        
        });
    
</script>
<div class="modal fade" id="faultyAdd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Faulty Equipment List</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="faultyAdd_contents">
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="faultyEDIT">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Faulty Equipment List</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="faultyEDIT_contents">
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>


var forIID;
function assignFormulaId(forIID) {
  document.getElementById('formulaId').value = forIID;
}

var curValue22;

var thisValue2;
var thisValue222; 
function choose_question(option) {
  //alert(option.value); return false;
  if(option.value == 'mcq'){
    $(option).closest('div').next('.options').show('slow');
  }else{
    $(option).closest('div').next('.options').hide('slow')
  } 
}
function option_values(noptions){
  var num = $(noptions).closest('div').next('div').find('.question_no').val();
  $(noptions).closest('div').next('div').next('.dynamic_options').empty();
  for(var i = 1; i<= noptions.value; i++){
    var option = '<div class="form-group col-md-3 col-xs-6 nopadding-left"><input type="text" class="form-control" name="question_'+num+'_options[]" placeholder="Option '+ i+ ' Value" id="question"></div>';
    $(noptions).closest('div').next('div').next('.dynamic_options').append(option);
  }

}



  var divNum;
  function removeProcedures(divNum) {
    var d = document.getElementById('dynamicInput2');
    var olddiv = document.getElementById('my'+divNum+'Div');
    
      d.removeChild(olddiv);

      var numi = document.getElementById('theValue2');
      var num = document.getElementById("theValue2").value;
      numi.value = num-1;  
  } // removeUplaodFileElement()
  
  function addFormulaProcedures() {
    var ni = document.getElementById('dynamicInput2');
    var numi = document.getElementById('theValue2');
    
    var num = (document.getElementById("theValue2").value -1)+ 2;
    numi.value = num;
    var num2=num+1; 
    var divIdName = "my"+num+"Div";
    var newdiv = document.createElement('div');
    newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = '<div id='+divIdName+' class="row"><div class="col-md-6 pr-1"><div class="form-group"><label>Location</label><select class="form-control required" name="location_'+num+'" id="location_'+num+'"><option value="">Choose Location</option><?php foreach($location as $row){?><option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option><?php } ?></select></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Equipment Name</label><input type="text" name="equip_name_'+num+'" id="equip_name_'+num+'" class="form-control required" placeholder="Equipment Name"></div><div></div></div><div class="col-md-6 pr-1"> <div class="form-group"><label>Quantity</label><input type="number" name="quantity_'+num+'" id="quantity_'+num+'" class="form-control classes required" placeholder="Enter Quantity" min="1"></div><div></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Price</label><input type="number" name="price_'+num+'" id="price_'+num+'" class="form-control classes required" placeholder="Enter Price" min="0"></div><div></div></div><div class="clearfix"></div><div class="col-md-12 text-right"><a href="javascript:void(0);" class="btn btn-sm btn-danger" title="Remove Question" onclick="minusValueFrom('+num+');" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i> Remove</a><input type="hidden" value="" id="total_cost_'+num+'" name="total_cost"></div><div class="form-group col-md-12 col-xs-12 nopadding-left"><hr /></div><input type="hidden" id="question_no"  value="'+num+'" class="question_no" name="questions[]"></div>';
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
  
  var divNum;
  
  var inCurntVal;

  function addFormulaProcedures_edit() {
  //alert();
    var ni = document.getElementById('dynamicInput2');
    var numi = document.getElementById('theValue2');
    
    var num = (document.getElementById("theValue2").value -1)+ 2;
    numi.value = num;
    var num2=num+1; 
    var divIdName = "my"+num+"Div";
    var newdiv = document.createElement('div');
    newdiv.setAttribute("id",divIdName);
  
  newdiv.innerHTML = '<div id='+divIdName+' ><div class="form-group col-md-6 col-xs-12 nopadding-left"><label>Ingredient Name:</label><input type="text" class="form-control" name="ingredeient_name['+num+']" placeholder="Ingredient Name" id="ingredeient_name_'+num+'"></div><div class="form-group col-md-6 col-xs-12 nopadding-left"><label>Ingredient Number:</label><input type="text" class="form-control" name="ingredient_number['+num+']" placeholder="Ingredient Number" id="ingredient_number_'+num+'"></div><div class="col-md-12 nopadding"><div class="form-group col-md-8 nopadding-left"><label>Quantity:</label><input type="text" class="form-control" id="ingred_quantity_'+num+'" name="ingred_quantity['+num+']" placeholder="Quantity" onchange="calculateTotalCost_edit('+num+');"></div><div class="form-group col-md-4 nopadding-left"><label>Units of measurement in formula</label><span id="changedOptions"><select name="ingred_quantity_unit['+num+']" id="ingred_quantity_unit_'+num+'" class="form-control" onchange="changeFormulaMeasurment_edit(this.value, '+num+'), calculateTotalCost_edit('+num+');"><option value="">Select Unit</option><option value="ounce">Ounce</option><option value="microgram">Microgram</option><option value="gram">Gram</option><option value="milligram">Milligram</option><option value="pound">Pound</option><option value="kilogram">Kilogram</option><option value="microlitre">Microliter</option><option value="teaspoon">Teaspoon</option><option value="tablespoon">Tablespoon</option><option value="millilitre">Milliliter</option><option value="fluidounce">Fluid Ounce</option><option value="cup">Cup</option><option value="liter">Liter</option><option value="pint">Pint</option><option value="quart">Quart</option><option value="gallon">Gallon</option></select><input type="hidden"  name="ingredientQuantityUnit" id="ingredientQuantityUnit"/></span></div><div class="clearfix"></div></div><div class="col-md-12 nopadding"><div class="form-group col-md-8 nopadding-left"><label>Cost:</label><div class="input-group m-b-10"><span class="input-group-addon">$</span><input type="text" class="form-control" name="cost_val['+num+']" id="cost_val_'+num+'" placeholder="Cost" onchange="calculateTotalCost_edit('+num+');"></div></div><div class="form-group col-md-4 nopadding-left"><label>Units of measurement for cost</label><span id="changedOptions_'+num+'"><select name="cost_unit['+num+']" id="cost_unit_'+num+'" class="form-control" onchange="calculateTotalCost_edit('+num+');"><option value="">Select Unit</option><option value="ounce">Ounce</option><option value="microgram">Microgram</option><option value="gram">Gram</option><option value="milligram">Milligram</option><option value="pound">Pound</option><option value="kilogram">Kilogram</option><option value="microlitre">Microliter</option><option value="teaspoon">Teaspoon</option><option value="tablespoon">Tablespoon</option><option value="millilitre">Milliliter</option><option value="fluidounce">Fluid Ounce</option><option value="cup">Cup</option><option value="liter">Liter</option><option value="pint">Pint</option><option value="quart">Quart</option><option value="gallon">Gallon</option></select></span></div><div class="clearfix"></div></div><div class="col-md-12 text-right"><a href="javascript:void(0);" class="btn btn-sm btn-danger" title="Remove Question" onclick="minusValueFrom('+num+');" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i> Remove</a><input type="hidden" value="" id="total_cost_'+num+'" name="total_cost"></div><div class="form-group col-md-12 col-xs-12 nopadding-left"><hr /></div></div>';
  ni.appendChild(newdiv);
  
  }
</script>
