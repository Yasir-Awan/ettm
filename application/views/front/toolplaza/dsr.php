<style>
	.datepicker-dropdown { top: 0;left: 0; padding: 4px; background-color:#8F5036; border-radius: 10px; }
	.datepicker table { margin: 0; -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;}
	.datepicker table tr td, .datepicker table tr th { text-align: center; width: 30px; height: 30px; border-radius: 4px; border: none; color: #000000; }
	.datepicker table tr td { border:dotted 1px #3A2218; background-color:#B77F0E; background-image: linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,0)); }
	.datepicker table tr th { color: #fff; line-height:35px;} 
	.datepicker table tr td.day:hover, .datepicker table tr td.focused { background: #DCDCDC; cursor: pointer; }
	.datepicker table tr td.old, .datepicker table tr td.new { color: #8F5036; }
	.datepicker table tr td.today { color: #FFFFFF;  background-color: #3A2218; border-color: #FFB76F; }
	.datepicker table tr td.today:hover { color: #FFFFFF; background-color: #884400; border-color: #f59e00; }
	.datepicker table tr td.active:active, .datepicker table tr td.active.highlighted:active, .datepicker table tr td.active.active, .datepicker table tr td.active.highlighted.active, .open > .dropdown-toggle.datepicker table tr td.active, .open > .dropdown-toggle.datepicker table tr td.active.highlighted { color: #ffffff; background-color: #F27900; border-color: #285e8e; }
	.datepicker table tr td.active:active:hover, .datepicker table tr td.active.highlighted:active:hover, .datepicker table tr td.active.active:hover, .datepicker table tr td.active.highlighted.active:hover, .open > .dropdown-toggle.datepicker table tr td.active:hover, .open > .dropdown-toggle.datepicker table tr td.active.highlighted:hover, .datepicker table tr td.active:active:focus, .datepicker table tr td.active.highlighted:active:focus, .datepicker table tr td.active.active:focus, .datepicker table tr td.active.highlighted.active:focus, .open > .dropdown-toggle.datepicker table tr td.active:focus, .open > .dropdown-toggle.datepicker table tr td.active.highlighted:focus, .datepicker table tr td.active:active.focus, .datepicker table tr td.active.highlighted:active.focus, .datepicker table tr td.active.active.focus, .datepicker table tr td.active.highlighted.active.focus, .open > .dropdown-toggle.datepicker table tr td.active.focus, .open > .dropdown-toggle.datepicker table tr td.active.highlighted.focus { color: #ffffff; background-color: #285e8e; border-color: #193c5a;}
	.datepicker table tr td.active:active, .datepicker table tr td.active.highlighted:active, .datepicker table tr td.active.active, .datepicker table tr td.active.highlighted.active, .open > .dropdown-toggle.datepicker table tr td.active, .open > .dropdown-toggle.datepicker table tr td.active.highlighted { color: #ffffff; background-color: #FF8033; border-color: #285e8e; }
	.datepicker table tr td.active:active:hover, .datepicker table tr td.active.highlighted:active:hover, .datepicker table tr td.active.active:hover, .datepicker table tr td.active.highlighted.active:hover, .open > .dropdown-toggle.datepicker table tr td.active:hover, .open > .dropdown-toggle.datepicker table tr td.active.highlighted:hover, .datepicker table tr td.active:active:focus, .datepicker table tr td.active.highlighted:active:focus, .datepicker table tr td.active.active:focus, .datepicker table tr td.active.highlighted.active:focus, .open > .dropdown-toggle.datepicker table tr td.active:focus, .open > .dropdown-toggle.datepicker table tr td.active.highlighted:focus, .datepicker table tr td.active:active.focus, .datepicker table tr td.active.highlighted:active.focus, .datepicker table tr td.active.active.focus, .datepicker table tr td.active.highlighted.active.focus, .open > .dropdown-toggle.datepicker table tr td.active.focus, .open > .dropdown-toggle.datepicker table tr td.active.highlighted.focus { color: #ffffff; background-color: #285e8e; border-color: #193c5a; }
	.datepicker .datepicker-switch { font-family:Optima; text-transform:uppercase; font-size:16px; width: 145px; background: #3A2218; color: #EAAA01; }
	.datepicker .datepicker-switch:hover, .datepicker .prev:hover, .datepicker .next:hover, .datepicker tfoot tr th:hover { background: #3A2218; color: #EAAA01; }
</style>
<?php include('includes/header.php');?>
<div class="panel-header panel-header-sm"></div>
<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<?php if($this->session->userdata['supervisor_id'] < 12){ echo "This Area is Not in your Access."; } else{ ?>
				<div class="card-header">
					<h4 class="card-title"> Daily Site Report</h4>
					<span class="btn btn-success btn-sm pull-right"  data-toggle="modal" data-target="#dsrAdd" onclick="ajax_html('<?php echo base_url()?>toolplaza/dsr/add/', 'dsrAdd_contents');"><i class="fa fa-plus"></i>Add New Report</span>
				</div>
				<div class="card-body">
					<div id="list"></div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php include('includes/footer.php');?>
<script>
      var table = $('#dataTable').DataTable({
		  drawCallback: function(){
			  $('.paginate_button', this.api().table().container()).on('click', function(){
				  $("[data-toggle='toggle']").bootstrapToggle('destroy'); 
				  $("[data-toggle='toggle']").bootstrapToggle();
			  }); 
		  }
	  }); 
</script>
<script>
	var base_url = '<?php echo base_url(); ?>'; var user_type = 'toolplaza'; var module = 'dsr'; var list_cont_func = 'list'; var dlt_cont_func = 'delete';
    $(document).ready(function(){
		if(typeof bootstrapToggle === 'function'){
			$("[data-toggle='toggle']").bootstrapToggle('destroy'); 
			$("[data-toggle='toggle']").bootstrapToggle();
		}
		else{}
        
    });
    $('body').on('click','a.paginate_button',function(){
		alert();
		$("[data-toggle='toggle']").bootstrapToggle('destroy'); 
		$("[data-toggle='toggle']").bootstrapToggle();
	});
	$('a.paginate_button').on('click',function(){
		alert('here');
	});
	$(document).ready(function(){
		$.ajax({ 
			url: "<?php echo base_url();?>toolplaza/dsr/list",
			cache       : false,
			contentType : false,
			processData : false,
			beforeSend: function(){
				var top = '200';
				$('#list').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
			},
			success: function(data) {
				//console.log(data);
				$('#list').html(data);
				$('#dataTable3').DataTable();
				if(typeof bootstrapToggle === 'function'){
					$("[data-toggle='toggle']").bootstrapToggle('destroy');
					$("[data-toggle='toggle']").bootstrapToggle();
				}
				else{}
				
			},
			error: function(e){ console.log(e); }
		});
	});
</script>
<div class="modal fade" id="dsrAdd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Add Daily Site Report</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
            <div class="modal-body"><div id="dsrAdd_contents"></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>
<div class="modal fade" id="dsrEDIT">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header"><h5 class="modal-title">Edit Daily Site Report</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
            <div class="modal-body"><div id="dsrEDIT_contents"></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewreason">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"> <h5 class="modal-title">Reason</h5> <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button> </div>
            <div class="modal-body"> <div id="viewreason_contents"></div> </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> </div>
		</div>
	</div>
</div>
<script>
	function addFormulaProcedure() {
		var ni = document.getElementById('dynamicInput2'); var numi = document.getElementById('theValue2'); var num = (document.getElementById("theValue2").value -1)+ 2; numi.value = num; var num2=num+1; var divIdName = "my"+num+"Div"; var newdiv = document.createElement('div'); newdiv.setAttribute("id",divIdName); newdiv.innerHTML = '<div id='+divIdName+' class="row"><div class="col-md-1 pr-1 form-group"><label>'+num+'.</label></div><div class="col-md-5 pr-1 form-group"><input name= "as'+num+'" type= "text" value="<?php set_value('as'.'+num+'.'');?>" class="form-control"></input></div><div class="col-md-1 pr-1 form-group"><label>Status: </label></div><div class="col-md-5 pr-1 form-group"><select name= "as'+num+'status" type= "int" value="<?php set_value('as'.'+num+'.'status');?>" class= "form-control"><option value="">--Select Status--</option><option value="3">Present</option><option value="2">Absent</option><option value="1">Leave</option></select></div></div><div class="row"><div class="col-md-2 pr-1 form-group"><button type="button" name="button" class="btn btn-info" onclick="holiday'+num+'(this)">Planned Holidays</button></div></div><div id="section100'+num+'" style="display:none"><div class="row"><div class="col-md-6 pr-1"><div class="form-group"><label>From </label><input name= "as'+num+'holidayfrom" type= "date" value="<?php set_value('as'.'+num+'.'holidayfrom');?>" class= "form-control"></input></div></div><div class="col-md-6 pr-1"><div class="form-group"><label> To </label><input name= "as'+num+'holidayto" type= "date" value="<?php set_value('as'.'+num+'.'holidayto');?>" class= "form-control"></input></div></div></div></div><div class="col-md-2 pr-1 wrap-input-container"><a href="javascript:void(0);" class="btn btn-sm btn-danger" title="Remove File" onclick="minusValueFrom('+num+');" data-toggle="tooltip"><i class="fa fa-remove-circle" aria-hidden="true"></i> Remove</a></div></div>'; ni.appendChild(newdiv);
	}
	var subtractValue;
	function minusValueFrom(idd_v) { 
		//alert(idd_v);
		var totalCostVal; var subTotalCost; var new_cost; var nxt_check = '';
		//remove div 
		n = idd_v + 1; nxt_check = document.getElementById('total_cost_'+n); 
		var d = document.getElementById('dynamicInput2'); var olddiv = document.getElementById('my'+idd_v+'Div'); d.removeChild(olddiv);
		var numi = document.getElementById('theValue2'); var num = document.getElementById("theValue2").value;
		if(nxt_check == null){
			numi.value = num-1;  
		}else{
			numi.value = num;
		}
	}
</script>