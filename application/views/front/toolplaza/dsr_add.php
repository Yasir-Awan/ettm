<style>
	input[type="radio"] {
		display: none;
	}

	.radio {
		padding: 10px;
		display: inline-block;
	}

	input[type="radio"]:checked+.radio {
		background-color: #14CF63;
		border-radius: 5px;
		cursor: default;
		color: #E6E6E6;
	}

	.padding {
		padding: 15px 20px;
	}

	.textcenter {
		text-align: center;
	}
</style>
<div>
	<div>
		<?php if (isset($page)) {
			if ($page == 'C') {
				echo form_open_multipart(base_url() . 'toolplaza/dsr/do_add', array('id' => 'add_dsr', 'method' => 'post'));
			}
			if ($page == 'U') {
				echo form_open_multipart(base_url() . 'toolplaza/dsr/do_update/' . $dsr['dsr'][0]['id'], array('id' => 'edit_dsr', 'method' => 'post'));
			}
		} ?>
		<div class='container'>
			<?php include('dsr/add/top_display.php'); ?>
			<h6>Summary</h6>
			<?php include('dsr/add/summary.php'); ?>


			<?php // include('dsr/add/inventory.php'); 
			?>


			<?php include('dsr/add/features.php');
			?>


			<?php include('dsr/add/attendance.php'); ?>


			<?php include('dsr/add/feedback.php'); ?>
			<div class="row">
				<div class="col-md-9 form-group"></div>
				<div class="col-md-3 form-group">
					<div class="col-md-12 pr-1 wrap-input-container">
						<span type="input" class="btn btn-info btn-block pull-right" onclick="<?php if (isset($page)) {
																									if ($page == 'C') {
																										echo "form_submit('add_dsr');";
																									}
																									if ($page == 'U') {
																										echo "form_submit('edit_dsr');";
																									}
																								} ?>"><?php if ($page == 'C') {
																											echo 'Submit';
																										}
																										if ($page == 'U') {
																											echo 'Update';
																										} ?></span>
						<!--This code is used for testing form submit with database-->
						<?php //  echo form_submit('Submit', 'submit', array('class' => 'btn btn-info btn-block pull-right') ); 
						?>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<?php include('dsr/script.php'); ?>