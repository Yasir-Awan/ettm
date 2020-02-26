<style>
	input[type="radio"]{ display:none; }
	.radio{ padding: 10px; display: inline-block; }
	input[type="radio"]:checked + .radio{ background-color:#14CF63; border-radius: 5px; cursor:default; color: #E6E6E6; }
	.padding{ padding: 15px 20px; }
	.textcenter{ text-align: center; }
</style>
<div>
	<div>
		<?php echo form_open_multipart(base_url().'admin/tcd/do_add', array('id' => 'add_tcd', 'method' => 'post'));?>
		<div class='container'>
			<div class="row">
				<div class="col-md-4 pr-1">
					<div class="form-group"> 
						<label>Toll Plaza: </label> 
						<select  class="form-control"  name="toolplaza_id" id="">
							<?php $i = 0; foreach($toolplaza as $row){ ?>
							<option value="<?php echo $row['id'] ?>"><?php echo $row['name']; ?></option>
							<?php $i++; } ?>
						</select>
					</div> 
				</div> 
				<div class="col-md-4 pr-1"> 
					<div class="form-group">
                        <label>Date</label>
                        <input class="form-control required" id="datecreated" autocomplete="off" name="datecreated" placeholder="Choose Date" value="<?php set_value('datecreated');?>"> 
                      </div>
				</div>
				<div class="col-md-4 pr-1"> 
					<div class='form-group'> 
						<label>Prepared By:</label> 
						<input type='text' class='form-control' disabled='' placeholder='Prepared By' value='<?php echo $admin_name; ?>'> 
					</div>
				</div> 
			</div>
			<div class="row">
				<div class="col-md-6 pr-1">
					<div class="form-group">
						<label>Description</label>
						<input type="text" name="description" class="form-control required" placeholder="Enter Description" value="TRAFFIC">
					</div>
				</div>
				<div class="col-md-6 pr-1">
					<div class="form-group">
						<label>Notes</label>
						<input type="text" name="notes" class="form-control required" placeholder="Enter Notes" value="No of Passages">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 pr-1">
					<div class="form-group">
						<label>Class1</label>
						<input type="number" name="class1" id="class1" class="form-control classes required" placeholder="Enter Car/Jeep passages" min="0">
					</div>
				</div>
				<div class="col-md-6 pr-1">
					<div class="form-group">
						<label>Class2</label>
						<input type="number" name="class2" id="class2" class="form-control classes required" placeholder="Enter Wagons/Hiace passages" min="0">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 pr-1">
					<div class="form-group">
						<label>Class3</label>
						<input type="number" name="class3" id="class3" class="form-control classes required" placeholder="Enter 2,3 Axle Trucks/Tractors/Trolleys passages" min="0">
					</div>
				</div>
				<div class="col-md-6 pr-1">
					<div class="form-group">
						<label>Class4</label>
						<input type="number" name="class4" id="class4" class="form-control classes required" placeholder="Enter Buses/Coasters passages" min="0">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 pr-1">
					<div class="form-group">
						<label>Class5</label>
						<input type="number" name="class5" id="class5" class="form-control classes required" placeholder="Enter Above 3 Axle Articluated Trucks passages" min="0">
					</div>
				</div>
				 <div class="col-md-6 pr-1">
					 <div class="form-group">
						 <label>Total</label>
						 <input type="number" class="form-control" id="total" name="total" placeholder="Total" value="">
					 </div>
				</div>
			</div>
			<div class="row">	
				<div class="col-md-9 form-group"></div>
				<div class="col-md-3 form-group">
					<div class="col-md-12 pr-1 wrap-input-container">
						<span type="input" class="btn btn-info btn-block pull-right" onclick="form_submit('add_tcd');">Submit</span>
						<!--This code is used for testing form submit with database-->
						<?php //  echo form_submit('Submit', 'submit', array('class' => 'btn btn-info btn-block pull-right') ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_close();?> 
	</div>
</div>
<script>
	$('#datecreated').datepicker({format:'yyyy-mm-dd'});
	$('input.classes').on('keyup keydown change',function() {   
        var total = 0;
        $('input.classes').each(function(){
            if (this.value == ''){
                total += parseInt(0);
            }else{
                total += parseInt(this.value);
            }
        });
        $('#total').val(total);
	});
	$.ajax({
              type: 'POST',
              url: '<?php echo base_url()?>toolplaza/check_start_date',
              data: {formonth: $('#datePicker').val()},
              success: function(data)
              {
                if(data == 'completed'){
                    notify('You have Complete dtr for This Month','danger','top','right');
                      $('#dtr_type').prop('selectedIndex',0);
                      $('.start_date').hide('slow');
                      $('.start_date').html('');
                      $('.end_date').hide('slow');
                      $('.end_date').html('');
                }else{
                    var fields = data.split('_');
                    var datea = fields[0].split('-');
                    // var now = new Date();
                    // alert(now.getMonth()); return false;
                    var startDate = new Date(datea[0], datea[1]-1, fields[1]);
                    var endDate1   = new Date(datea[0], datea[1]-1, fields[1]);
                    var mont_last = new Date(datea[0], datea[1], 0).getDate();
                    var end_start = new Date(datea[0],datea[1]-1,fields[1]);
                    var actual = mont_last - fields[1];
                    var end_end = new Date(datea[0],datea[1]-1,mont_last);
                      $("#start_date").datepicker({
                        format: "dd/mm/yyyy",
                        //minViewMode: 1,
                        autoclose: true,
                        startDate: startDate,
                        endDate: endDate1
                      });
                      $("#end_date").datepicker({
                        format: "dd/mm/yyyy",
                        //minViewMode: 1,
                        autoclose: true,
                        startDate: end_start,
                        endDate: end_end
                      });
                }
                
                  
              }
            });
	
</script>
