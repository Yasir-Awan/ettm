<style>

.datepicker-dropdown {
  top: 0;
  left: 0;
  padding: 4px;
  background-color:#8F5036;  
  border-radius: 10px;
}
.datepicker table {
  margin: 0;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;

}

.datepicker table tr td,
.datepicker table tr th {
  text-align: center;
  width: 30px;
  height: 30px;
  border-radius: 4px;
  border: none;
  color: #000000;
}

.datepicker table tr td {
    border:dotted 1px #3A2218;
    background-color:#B77F0E;
    background-image: linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,0));
    
}

.datepicker table tr th {
    color: #fff;
    line-height:35px;    
}

.datepicker table tr td.day:hover,
.datepicker table tr td.focused {
  
  background: #DCDCDC;
  cursor: pointer;
}
.datepicker table tr td.old,
.datepicker table tr td.new {
  color: #8F5036;
}

.datepicker table tr td.today {
  color: #FFFFFF;
  background-color: #3A2218;
  border-color: #FFB76F;
}
.datepicker table tr td.today:hover {
  color: #FFFFFF;
  background-color: #884400;
  border-color: #f59e00;
}
.datepicker table tr td.active:active,
.datepicker table tr td.active.highlighted:active,
.datepicker table tr td.active.active,
.datepicker table tr td.active.highlighted.active,
.open > .dropdown-toggle.datepicker table tr td.active,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted {
  color: #ffffff;
  background-color: #F27900;
  border-color: #285e8e;
}


.datepicker table tr td.active:active:hover,
.datepicker table tr td.active.highlighted:active:hover,
.datepicker table tr td.active.active:hover,
.datepicker table tr td.active.highlighted.active:hover,
.open > .dropdown-toggle.datepicker table tr td.active:hover,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted:hover,
.datepicker table tr td.active:active:focus,
.datepicker table tr td.active.highlighted:active:focus,
.datepicker table tr td.active.active:focus,
.datepicker table tr td.active.highlighted.active:focus,
.open > .dropdown-toggle.datepicker table tr td.active:focus,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted:focus,
.datepicker table tr td.active:active.focus,
.datepicker table tr td.active.highlighted:active.focus,
.datepicker table tr td.active.active.focus,
.datepicker table tr td.active.highlighted.active.focus,
.open > .dropdown-toggle.datepicker table tr td.active.focus,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted.focus {
  color: #ffffff;
  background-color: #285e8e;
  border-color: #193c5a;
}
.datepicker table tr td.active:active,
.datepicker table tr td.active.highlighted:active,
.datepicker table tr td.active.active,
.datepicker table tr td.active.highlighted.active,
.open > .dropdown-toggle.datepicker table tr td.active,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted {
  color: #ffffff;
  background-color: #FF8033;
  border-color: #285e8e;
}
.datepicker table tr td.active:active:hover,
.datepicker table tr td.active.highlighted:active:hover,
.datepicker table tr td.active.active:hover,
.datepicker table tr td.active.highlighted.active:hover,
.open > .dropdown-toggle.datepicker table tr td.active:hover,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted:hover,
.datepicker table tr td.active:active:focus,
.datepicker table tr td.active.highlighted:active:focus,
.datepicker table tr td.active.active:focus,
.datepicker table tr td.active.highlighted.active:focus,
.open > .dropdown-toggle.datepicker table tr td.active:focus,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted:focus,
.datepicker table tr td.active:active.focus,
.datepicker table tr td.active.highlighted:active.focus,
.datepicker table tr td.active.active.focus,
.datepicker table tr td.active.highlighted.active.focus,
.open > .dropdown-toggle.datepicker table tr td.active.focus,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted.focus {
  color: #ffffff;
  background-color: #285e8e;
  border-color: #193c5a;
}
.datepicker .datepicker-switch {
  font-family:Optima;
  text-transform:uppercase;
  font-size:16px;
  width: 145px;
  background: #3A2218;
  color: #EAAA01;
  
}
.datepicker .datepicker-switch:hover,
.datepicker .prev:hover,
.datepicker .next:hover,
.datepicker tfoot tr th:hover {
  background: #3A2218;
  color: #EAAA01;
}
</style>
 <?php include('includes/header.php');?>
<div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Monthly Traffic Report</h4>
                <span class="btn btn-success btn-sm pull-right"  data-toggle="modal" data-target="#mtrAdd" onclick="ajax_html('<?php echo base_url()?>toolplaza/mtr/add/', 'mtrAdd_contents');"><i class="fa fa-plus"></i>Add New Report</span>
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
    var module = 'mtr';
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
            url: "<?php echo base_url();?>toolplaza/mtr/list",
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
<div class="modal fade" id="mtrAdd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Monthly Traffic Report</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
              <div id="mtrAdd_contents">
              </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mtrEDIT">
    <div class="modal-dialog modal-lg">
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
  newdiv.innerHTML = '<div id='+divIdName+' class="row"><div class="col-md-6 pr-1"><div class="form-group"><label>Supporting document name <span class="text-info">(Optional)</optional</label><input type="text" name="suppporting_document_name[]" id="supporting_0" class="form-control classes required" placeholder="Enter File Name" min="0"></div></div><div class="col-md-4 pr-1 wrap-input-container"><label>Upload File(<span class="text-info">Optional &nbsp;Only PDF,Excel and Image is allowed</span>)</label><input class="file-upload form-control required" name="supporting_file[]" type="file"  accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel ,application/pdf,image/*"></div><div class="col-md-2 pr-1 wrap-input-container"><a href="javascript:void(0);" class="btn btn-sm btn-danger" title="Remove File" onclick="minusValueFrom('+num+');" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i> Remove</a></div></div>';
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
<script>
  function addexempt() {
    var ni = document.getElementById('dynamicexempt');

    if($('.dynamic_input_exempt').length){
        
    }else{
      var newdiv = '<div class="row"><div class="col-md-6 pr-1"> <div class="form-group"><label>Exempt Description</label><input type="text" name="excempt_desc" id="exempt_desc" class="form-control classes required" value="Exempt" placeholder="Enter exempt Description" ></div><div></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Exempt Notes</label><input type="text" name="exempt_notes" id="exempt_notes" class="form-control classes required" value="No of Passages" placeholder="Enter exempt notes"></div><div></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Class1 Exempt</label><input type="number" name="exempt1" id="exempt1" class="form-control classes required" placeholder="Enter class1 exempt" min="0"></div><div></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Class2 Exempt</label><input type="number" name="exempt2" id="exempt2" class="form-control classes required" placeholder="Enter class2 exempt" min="0"></div><div></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Class3 Exempt</label><input type="number" name="exempt3" id="exempt3" class="form-control classes required" placeholder="Enter class3 exempt" min="0"></div><div></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Class4 Exempt</label><input type="number" name="exempt4" id="exempt4" class="form-control classes required" placeholder="Enter class4 exempt" min="0"></div><div></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Class5 Exempt</label><input type="number" name="exempt5" id="exempt5" class="form-control classes required" placeholder="Enter class5 exempt" min="0"></div><div></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Class6 Exempt</label><input type="number" name="exempt6" id="exempt6" class="form-control classes required" placeholder="Enter class6 exempt" min="0"></div><div></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Class7 Exempt</label><input type="number" name="exempt7" id="exempt7" class="form-control classes required" placeholder="Enter class7 exempt" min="0"></div><div></div> </div> <div class="col-md-6 pr-1"><div class="form-group"><label>Class8 Exempt</label> <input type="number" name="exempt8" id="exempt8" class="form-control classes required" placeholder="Enter class8 exempt" min="0"></div><div></div> </div><div class="col-md-6 pr-1"><div class="form-group"><label>Class9 Exempt</label><input type="number" name="exempt9" id="exempt9" class="form-control classes required" placeholder="Enter class9 exempt" min="0"></div><div></div></div><div class="col-md-6 pr-1"><div class="form-group"><label>Class10 Exempt</label><input type="number" name="exempt10" id="exempt10" class="form-control classes required" placeholder="Enter class10 exempt" min="0"></div><div></div></div><div class="col-md-12 pr-1 wrap-input-container"><a href="javascript:void(0);" class="btn btn-sm btn-danger pull-right" title="Remove Exempt" onclick="remove_exempt();" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i> Remove Exempt</a></div></div>';
    ni.innerHTML = newdiv;
    $('#add_exempt').val('1');
    }
    
  
  } 


  function remove_exempt() {
    var ni = document.getElementById('dynamicexempt');
    ni.innerHTML = '';
     $('#add_exempt').val('0');     
  }

</script>
<!-- <div id='+divIdName+' class="row">
  <div class="col-md-6 pr-1">
    <div class="form-group">
      <label>Location</label>
      <select class="form-control required" name="location_'+num+'" id="location_'+num+'">
        <option value="">Choose Location</option>
        <?php foreach($location as $row){?>
        <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option><?php } ?>
      </select></div></div>
      <div class="col-md-6 pr-1">
        <div class="form-group">
          <label>Equipment Name</label>
          <input type="text" name="equip_name_'+num+'" id="equip_name_'+num+'" class="form-control required" placeholder="Equipment Name">
        </div>
        <div>
        </div>
      </div>
      <div class="col-md-6 pr-1"> 
        <div class="form-group">
          <label>Quantity</label>
          <input type="number" name="quantity_'+num+'" id="quantity_'+num+'" class="form-control classes required" placeholder="Enter Quantity" min="1">
        </div>
        <div>
        </div>
      </div>
      <div class="col-md-6 pr-1">
        <div class="form-group">
          <label>Price</label>
          <input type="number" name="price_'+num+'" id="price_'+num+'" class="form-control classes required" placeholder="Enter Price" min="0">
        </div>
        <div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 text-right">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger" title="Remove Question" onclick="minusValueFrom('+num+');" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i> Remove</a>
        <input type="hidden" value="" id="total_cost_'+num+'" name="total_cost">
      </div>
      <div class="form-group col-md-12 col-xs-12 nopadding-left"><hr />
      </div>
      <input type="hidden" id="question_no"  value="'+num+'" class="question_no" name="questions[]">
    </div> -->
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