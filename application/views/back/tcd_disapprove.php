<style>
ol li {
  margin-left: 10px !important;
  /* Or display: inline; */
  /* Or display: inline-block; */
}
</style>
<div class="row">
  <div class="col-md-12">
        <?php echo form_open(base_url()."admin/tcd/disapprove_do/".$id,array('id' => 'dissapprove'));?>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 900;">Reason For Dissapprove</label>
      <div class="abstract">
      	<textarea class="form-control summernotes" data-name="dissapprove_reason" rows="5" id="dissapprove"></textarea>
      </div>
    </div>
    <span class="btn btn-primary pull-right btn-xs" onclick="form_submit('dissapprove');">Update TCR</span>
  
<?php echo form_close();?>
</div>
</div>

<script>
function set_summer(){
        $('.summernotes').each(function() {
            var now = $(this);
            var h = 200;//now.data('height');
            var n = now.data('name');
            //alert(n);
			if(now.closest('.abstract').find('.val').length){
			} else {
            	now.closest('.abstract').append('<input type="hidden" class="val" name="'+n+'">');
				now.summernote({
					height: h,
					margin:10,
					onChange: function() {
						now.closest('.abstract').find('.val').val(now.code());
					}
				});
				now.closest('.abstract').find('.val').val(now.code());
			}
        });
	}
	$('body').on('click','',function(){
		//set_summer();
		
	});
    $(document).ready(function() {
        
		set_summer();
    });
</script>