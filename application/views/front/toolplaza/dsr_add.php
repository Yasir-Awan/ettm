<style>
	input[type="radio"]{ display:none; }
	.radio{ padding: 10px; display: inline-block; }
	input[type="radio"]:checked + .radio{ background-color:#14CF63; border-radius: 5px; cursor:default; color: #E6E6E6; }
	.padding{ padding: 15px 20px; }
	.textcenter{ text-align: center; }
</style>
<div>
	<div>
		<?php echo form_open_multipart(base_url().'toolplaza/dsr/do_add', array('id' => 'add_dsr', 'method' => 'post'));?>
		<div class='container'>
			<div class="row">
				<div class="col-md-6 pr-1"> <div class="form-group"> <label>Toll Plaza: </label> <input type="text" class="form-control" disabled="" placeholder="tollplaza" value="<?php echo $toolplaza; ?>"> </div> </div> <div class="col-md-6 pr-1"> <div class="form-group"> <label>Date: </label> <?php date_default_timezone_set('Asia/Karachi');?> <input name='datecreated' id="datecreated" autocomplete="off" class="form-control required" value='<?php set_value('datecreated');?>'> </div> </div>
			</div>
			<div class="row">
				<div class="col-md-6 pr-1"> <div class='form-group'> <label>Prepared By:</label> <input type='text' class='form-control' disabled='' placeholder='preparedby' value='<?php echo $supervisor_name; ?>'> </div> </div> <div class="col-md-6 pr-1"> <div class="form-group"> <label>Designation:</label> <input type='text' class='form-control' disabled='' placeholder='designation' value='<?php if($supervisor_id == 12 || $supervisor_id == 13 || $supervisor_id == 15){ echo "Technical Manager"; } elseif($supervisor_id == 20){ echo "Technician"; } elseif($supervisor_id == 14 || $supervisor_id == 16 || $supervisor_id == 17 || $supervisor_id == 18 || $supervisor_id == 19 || $supervisor_id == 22 || $supervisor_id == 23 ) { echo 'Site Incharge';} else { echo "Supervisor";};?>'> </div> </div>
			</div>
			<div class='row'>
				<div class="col-md-6 pr-1"> <div class="form-group"> <label>Phone No.:</label> <input type='text' class='form-control' disabled='' placeholder='phoneno.' value='<?php echo $phone;?>'> </div> </div> <div class="col-md-6 pr-1">  <div class="form-group">  <label>OMC:</label> <select class="form-control required" name="omc" id="omc" type="int">  <option value="">Choose OMC</option> <?php foreach($omc as $val){?> <option value="<?php echo $val['id'];?>"> <?php echo $val['name'];?></option> <?php } ?> </select>  </div> </div>
			</div>
			<h6>Summary</h6>
			<div class="row">
				<?php if($this->session->userdata['toolplaza'] == 9){} else{ ?><div class="col-md-6 pr-1"><div class="textcenter">North</div><br/><?php $counter = 0; foreach($north as $n){ $counter++; $section = $counter; $section1= $counter+100; $section2= $counter+200; $section3 = $counter+300; $section4 = $counter+400; $section5 = $counter+500;?><div class="container row"><div class="col-md-6 pr-1"><?php echo 'Lane '.$n['name'].' : ';?><input type="hidden" name="nlane<?php echo $section; ?>" value="<?php echo $n['name']; ?>"></div><div class="col-md-6"><input type="radio" id="togglen<?php echo $section1; ?>-open" name="nlanestatus<?php echo $section; ?>" value="0"  checked><label for="togglen<?php echo $section1; ?>-open" class="radio">Open</label><input type="radio" id="togglen<?php echo $section1; ?>-closed" name="nlanestatus<?php echo $section; ?>" value="1"><label for="togglen<?php echo $section1; ?>-closed" class="radio">Close</label></div><div id='sectionn<?php echo $section1 ?>' class="col-md-12 d-none"><input type="radio" id="togglen<?php echo $section1; ?>-omc" name="nlclosed<?php echo $section; ?>" value="1"><label for="togglen<?php echo $section1; ?>-omc" class="radio">By OMC</label><input type="radio" id="togglen<?php echo $section1; ?>-tech" name="nlclosed<?php echo $section; ?>" value="2"><label for="togglen<?php echo $section1; ?>-tech" class="radio">Due to Technical Issue</label><div id='sectionn<?php echo $section3;?>' class="d-none"><div class="container row"><div class="col-md-6 pr-1"><label><?php echo 'From :';?></label> <input name	='nlclosed_from<?php echo $section ?>' type='time' id= 'nlclosed_from<?php echo $section ?>' value='<?php set_value('nlclosed_from'.$section.'');?>' class='form-control'></div><div class='col-md-6 pr-1'><label><?php echo 'To :';?></label><input name	='nlclosed_to<?php echo $section ?>' type='time', id= 'nlclosed_to<?php echo $section ?>' value='<?php set_value('nlclosed_to'.$section.'');?>' class='form-control'></div></div><div class='container row'><?php echo 'Reason :';?><textarea name= 'nlclosed_description<?php echo $section ?>' id= 'nlclosed_description<?php echo $section ?>' value='<?php set_value('nlclosed_description'.$section.'');?>' class= 'form-control' style='border:1px solid #E3E3E3' width="100%"></textarea><br/></div><br/></div></div></div><?php } ?></div><?php } ?><div class="col-md-6 pr-1"><div class="textcenter">South</div><br/><?php  $counter = 0; foreach($south as $s){	 $counter++; $section = $counter; $section1= $counter+100; $section2 = $counter+200; $section3 = $counter+300;?><div class="container row"><div class="col-md-6 pr-1"><?php echo 'Lane '.$s['name'].' : ';?><input type="hidden" name="slane<?php echo $section; ?>" value="<?php echo $s['name']; ?>"></div><div class="col-md-6 pr-1"><input type="radio" id="toggles<?php echo $section1; ?>-open" name="slanestatus<?php echo $section; ?>" value="0" checked><label for="toggles<?php echo $section1; ?>-open" class="radio">Open</label><input type="radio" id="toggles<?php echo $section1; ?>-closed" name="slanestatus<?php echo $section; ?>" value="1" ><label for="toggles<?php echo $section1; ?>-closed" class="radio">Close</label></div><div id='sections<?php echo $section2 ?>' class="col-md-12 pr-1 d-none"><input type="radio" id="toggles<?php echo $section1; ?>-omc" name="slclosed<?php echo $section; ?>" value="1" ><label for="toggles<?php echo $section1; ?>-omc" class="radio">By OMC</label><input type="radio" id="toggles<?php echo $section1; ?>-tech" name="slclosed<?php echo $section; ?>" value="2" ><label for="toggles<?php echo $section1; ?>-tech" class="radio">Due to Technical Issue</label><div id='sections<?php echo $section3;?>' class="container d-none"><div class="row container"><div class='col-md-6 pr-1'><label><?php echo 'From :';?></label><input name='slclosed_from<?php echo $section ?>' type='time' id= 'slclosed_from<?php echo $section ?>' value='<?php set_value('slclosed_from'.$section.'');?>' class='form-control'></div><div class="col-md-6 pr-1"><label><?php echo 'To :';?></label><input name	='slclosed_to<?php echo $section ?>' type='time' id= 'slclosed_to<?php echo $section ?>' value='<?php set_value('slclosed_to'.$section.'');?>' class='form-control'></div></div><div class='container row'><?php echo 'Reason :';?> <textarea name= 'slclosed_description<?php echo $section ?>' id= 'slclosed_description<?php echo $section ?>' value='<?php set_value('slclosed_description'.$section.'');?>' class= 'form-control' style='border:1px solid #E3E3E3' width="100%"></textarea><br/></div><br/></div></div></div><?php } ?></div>
			</div>
			Camera Status:
			<div class="row">
				<?php if($this->session->userdata['toolplaza'] == 9){} else{ ?><div class="col-md-6"><div class="textcenter">North</div><br/><div class="container row"><div class="col-md-6 pr-1"><?php echo 'Camera PTZ : ';?><input type="hidden" name="cameraptz1" value="<?php echo 'NPTZ'?>"></div><div class="col-md-6"><input type="radio" id="toggleptz1-cno" name="ptzstatus1" value="0" checked><label for="toggleptz1-cno" class="radio">OK</label><input type="radio" id="toggleptz1-cyes" name="ptzstatus1" value="1"><label for="toggleptz1-cyes" class="radio">Faulty</label></div><div id='sectionptz1' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'ptzfc_desc1' id= 'ptzfc_desc1' value='<?php set_value('ptzfc_desc1');?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><?php  $counter = 0; foreach($north as $n) { $counter++; $section = $counter; $section1= $counter+100; $section2= $counter+200; $section3 = $counter+300; $section4 = $counter+400; ?><div class="col-md-6 pr-1"> <?php echo 'Camera '.$n['name'].' : ';?><input type='hidden' name='ncamera<?php echo $section ?>' value='<?php echo $n['name']; ?>'></div><div class="col-md-6"><input type="radio" id="togglen<?php echo $section1; ?>-cno" name="ncstatus<?php echo $section; ?>" value="0" checked><label for="togglen<?php echo $section1; ?>-cno" class="radio">OK</label><input type="radio" id="togglen<?php echo $section1; ?>-cyes" name="ncstatus<?php echo $section; ?>" value="1"><label for="togglen<?php echo $section1; ?>-cyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionnfc<?php echo $section4 ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'nfc_desc<?php echo $section ?>' id= 'nfc_desc<?php echo $section ?>' value='<?php set_value('nfc_desc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><?php } ?></div></div><?php } ?><div class="col-md-6"><div class="textcenter">South</div><br/><div class="row"><div class="col-md-6 pr-1"><?php echo 'Camera PTZ : ';?><input type="hidden" name="cameraptz2" value="<?php echo 'SPTZ'?>"></div><div class="col-md-6"><input type="radio" id="toggleptz2-cno" name="ptzstatus2" value="0" checked><label for="toggleptz2-cno" class="radio">OK</label><input type="radio" id="toggleptz2-cyes" name="ptzstatus2" value="1"><label for="toggleptz2-cyes" class="radio">Faulty</label></div><div id='sectionptz2' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'ptzfc_desc2' id= 'ptzfc_desc2' value='<?php set_value('ptzfc_desc2');?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><?php $counter = 0; foreach($south as $s){ $counter++; $section = $counter; $section1= $counter+100; $section2 = $counter+200; $section3 = $counter+300; $section4 = $counter+400; ?><div class="col-md-6"><?php echo 'Camera '.$s['name'].' : ';?> <input type='hidden' name='scamera<?php echo $section ?>' value='<?php echo $s['name']; ?>'></div><div class="col-md-6"><input type="radio" id="toggles<?php echo $section1; ?>-cno" name="scstatus<?php echo $section; ?>" value="0" checked><label for="toggles<?php echo $section1; ?>-cno" class="radio">OK</label><input type="radio" id="toggles<?php echo $section1; ?>-cyes" name="scstatus<?php echo $section; ?>" value="1"><label for="toggles<?php echo $section1; ?>-cyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionsfc<?php echo $section4 ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'sfc_desc<?php echo $section ?>' id= 'sfc_desc<?php echo $section ?>' value='<?php set_value('sfc_desc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><?php } ?></div></div>
			</div><br/>	
			Inventory Status:
			<div class="row">
				<?php if($this->session->userdata['toolplaza'] == 9){}else{ ?><div class="col-md-6"><div class="textcenter">North</div><br/><div class="container row"><?php $counter = 0; foreach($north as $n){ $counter++; $section = $counter; $section1= $counter+100; $section2= $counter+200; $section3 = $counter+300; $section4 = $counter+400; $section5 = $counter+500; ?><div class="col-md-7 pr-1"><?php echo 'OHLS '.$n['name'].' : ';?></div><div class="col-md-5"><input type="radio" id="togglen<?php echo $section1; ?>-ohlsno" name="nohlsstatus<?php echo $section; ?>" value="1" checked><label for="togglen<?php echo $section1; ?>-ohlsno" class="radio">OK</label><input type="radio" id="togglen<?php echo $section1; ?>-ohlsyes" name="nohlsstatus<?php echo $section; ?>" value="2"><label for="togglen<?php echo $section1; ?>-ohlsyes" class="radio">Faulty</label></div><div id='sectionnohls<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'nohlsdesc<?php echo $section ?>' id= 'nohlsdesc<?php echo $section ?>' value='<?php set_value('nohlsdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-7 pr-1"><?php echo 'Boom Arm '.$n['name'].' : ';?></div><div class="col-md-5"><input type="radio" id="togglen<?php echo $section1; ?>-boomarmno" name="nboomarmstatus<?php echo $section; ?>" value="1" checked><label for="togglen<?php echo $section1; ?>-boomarmno" class="radio">OK</label><input type="radio" id="togglen<?php echo $section1; ?>-boomarmyes" name="nboomarmstatus<?php echo $section; ?>" value="2"><label for="togglen<?php echo $section1; ?>-boomarmyes" class="radio">Faulty</label></div><div id='sectionnboomarm<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'nboomarmdesc<?php echo $section ?>' id= 'nboomarmdesc<?php echo $section ?>' value='<?php set_value('nboomarmdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-7 pr-1"><?php echo 'Boom Mechanical '.$n['name'].' : ';?></div><div class="col-md-5"><input type="radio" id="togglen<?php echo $section1; ?>-boommechno" name="nboommechstatus<?php echo $section; ?>" value="1" checked><label for="togglen<?php echo $section1; ?>-boommechno" class="radio">OK</label><input type="radio" id="togglen<?php echo $section1; ?>-boommechyes" name="nboommechstatus<?php echo $section; ?>" value="2"><label for="togglen<?php echo $section1; ?>-boommechyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionnboommech<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'nboommechdesc<?php echo $section ?>' id= 'nboommechdesc<?php echo $section ?>' value='<?php set_value('nboommechdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-7 pr-1"><?php echo 'Thermal Printer '.$n['name'].' : ';?></div><div class="col-md-5"><input type="radio" id="togglen<?php echo $section1; ?>-tprinterno" name="ntprinterstatus<?php echo $section; ?>" value="1" checked><label for="togglen<?php echo $section1; ?>-tprinterno" class="radio">OK</label><input type="radio" id="togglen<?php echo $section1; ?>-tprinteryes" name="ntprinterstatus<?php echo $section; ?>" value="2"><label for="togglen<?php echo $section1; ?>-tprinteryes" class="radio">Faulty</label></div><div id='sectionntprinter<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'ntprinterdesc<?php echo $section ?>' id= 'ntprinterdesc<?php echo $section ?>' value='<?php set_value('ntprinterdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-7 pr-1"><?php echo 'TCT with Keyboard '.$n['name'].' : ';?></div><div class="col-md-5"><input type="radio" id="togglen<?php echo $section1; ?>-tctno" name="ntctstatus<?php echo $section; ?>" value="1" checked><label for="togglen<?php echo $section1; ?>-tctno" class="radio">OK</label><input type="radio" id="togglen<?php echo $section1; ?>-tctyes" name="ntctstatus<?php echo $section; ?>" value="2"><label for="togglen<?php echo $section1; ?>-tctyes" class="radio">Faulty</label></div><div id='sectionntct<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'ntctdesc<?php echo $section ?>' id= 'ntctdesc<?php echo $section ?>' value='<?php set_value('ntctdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-7 pr-1"><?php echo 'Lane PC '.$n['name'].' : ';?></div><div class="col-md-5"><input type="radio" id="togglen<?php echo $section1; ?>-lanepcno" name="nlanepcstatus<?php echo $section; ?>" value="1" checked><label for="togglen<?php echo $section1; ?>-lanepcno" class="radio">OK</label><input type="radio" id="togglen<?php echo $section1; ?>-lanepcyes" name="nlanepcstatus<?php echo $section; ?>" value="2"><label for="togglen<?php echo $section1; ?>-lanepcyes" class="radio">Faulty</label></div><div id='sectionnlanepc<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'nlanepcdesc<?php echo $section ?>' id= 'nlanepcdesc<?php echo $section ?>' value='<?php set_value('nlanepcdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-7 pr-1"><?php echo 'Traffic Lights '.$n['name'].' : ';?></div><div class="col-md-5"><input type="radio" id="togglen<?php echo $section1; ?>-tlightno" name="ntlightstatus<?php echo $section; ?>" value="1" checked><label for="togglen<?php echo $section1; ?>-tlightno" class="radio">OK</label><input type="radio" id="togglen<?php echo $section1; ?>-tlightyes" name="ntlightstatus<?php echo $section; ?>" value="2"><label for="togglen<?php echo $section1; ?>-tlightyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionntlight<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'ntlightdesc<?php echo $section ?>' id= 'ntlightdesc<?php echo $section ?>' value='<?php set_value('ntlightdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-7 pr-1"><?php echo 'PFD '.$n['name'].' : ';?></div><div class="col-md-5"><input type="radio" id="togglen<?php echo $section1; ?>-pfdno" name="npfdstatus<?php echo $section; ?>" value="1" checked><label for="togglen<?php echo $section1; ?>-pfdno" class="radio">OK</label><input type="radio" id="togglen<?php echo $section1; ?>-pfdyes" name="npfdstatus<?php echo $section; ?>" value="2"><label for="togglen<?php echo $section1; ?>-pfdyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionnpfd<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'npfddesc<?php echo $section ?>' id= 'npfddesc<?php echo $section ?>' value='<?php set_value('npfddesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><?php } ?></div></div><?php } ?>
				<div class="col-md-6"><div class="textcenter">South</div><br/><div class="row"><?php $counter = 0; foreach($south as $s){	$counter++; $section = $counter; $section1= $counter+100; $section2 = $counter+200; $section3 = $counter+300; $section4 = $counter+400; ?><div class="col-md-6"><?php echo 'OHLS '.$s['name'].' : ';?></div><div class="col-md-6"><input type="radio" id="toggles<?php echo $section1; ?>-ohlsno" name="sohlsstatus<?php echo $section; ?>" value="1" checked><label for="toggles<?php echo $section1; ?>-ohlsno" class="radio">OK</label><input type="radio" id="toggles<?php echo $section1; ?>-ohlsyes" name="sohlsstatus<?php echo $section; ?>" value="2"><label for="toggles<?php echo $section1; ?>-ohlsyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionsohls<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'sohlsdesc<?php echo $section ?>' id= 'sohlsdesc<?php echo $section ?>' value='<?php set_value('sohlsdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-6 pr-1"><?php echo 'Boom Arm '.$s['name'].' : ';?></div><div class="col-md-6"><input type="radio" id="toggles<?php echo $section1; ?>-boomarmno" name="sboomarmstatus<?php echo $section; ?>" value="1" checked><label for="toggles<?php echo $section1; ?>-boomarmno" class="radio">OK</label><input type="radio" id="toggles<?php echo $section1; ?>-boomarmyes" name="sboomarmstatus<?php echo $section; ?>" value="2"><label for="toggles<?php echo $section1; ?>-boomarmyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionsboomarm<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'sboomarmdesc<?php echo $section ?>' id= 'sboomarmdesc<?php echo $section ?>' value='<?php set_value('sboomarmdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-6 pr-1"><?php echo 'Boom Mechanical '.$s['name'].' : ';?></div><div class="col-md-6"><input type="radio" id="toggles<?php echo $section1; ?>-boommechno" name="sboommechstatus<?php echo $section; ?>" value="1" checked><label for="toggles<?php echo $section1; ?>-boommechno" class="radio">OK</label><input type="radio" id="toggles<?php echo $section1; ?>-boommechyes" name="sboommechstatus<?php echo $section; ?>" value="2"><label for="toggles<?php echo $section1; ?>-boommechyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionsboommech<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'sboommechdesc<?php echo $section ?>' id= 'sboommechdesc<?php echo $section ?>' value='<?php set_value('sboommechdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-6 pr-1"><?php echo 'Thermal Printer '.$s['name'].' : ';?></div><div class="col-md-6"><input type="radio" id="toggles<?php echo $section1; ?>-tprinterno" name="stprinterstatus<?php echo $section; ?>" value="1" checked><label for="toggles<?php echo $section1; ?>-tprinterno" class="radio">OK</label><input type="radio" id="toggles<?php echo $section1; ?>-tprinteryes" name="stprinterstatus<?php echo $section; ?>" value="2" ><label for="toggles<?php echo $section1; ?>-tprinteryes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionstprinter<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'stprinterdesc<?php echo $section ?>' id= 'stprinterdesc<?php echo $section ?>' value='<?php set_value('stprinterdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-6 pr-1"><?php echo 'TCT with keyboard'.$s['name'].' : ';?></div><div class="col-md-6"><input type="radio" id="toggles<?php echo $section1; ?>-tctno" name="stctstatus<?php echo $section; ?>" value="1" checked><label for="toggles<?php echo $section1; ?>-tctno" class="radio">OK</label><input type="radio" id="toggles<?php echo $section1; ?>-tctyes" name="stctstatus<?php echo $section; ?>" value="2" ><label for="toggles<?php echo $section1; ?>-tctyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionstct<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'stctdesc<?php echo $section ?>' id= 'stctdesc<?php echo $section ?>' value='<?php set_value('stctdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-6 pr-1"><?php echo 'Lane PC '.$s['name'].' : ';?></div><div class="col-md-6"><input type="radio" id="toggles<?php echo $section1; ?>-lanepcno" name="slanepcstatus<?php echo $section; ?>" value="1" checked><label for="toggles<?php echo $section1; ?>-lanepcno" class="radio">OK</label><input type="radio" id="toggles<?php echo $section1; ?>-lanepcyes" name="slanepcstatus<?php echo $section; ?>" value="2"><label for="toggles<?php echo $section1; ?>-lanepcyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionslanepc<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'slanepcdesc<?php echo $section ?>' id= 'slanepcdesc<?php echo $section ?>' value='<?php set_value('slanepcdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-6 pr-1"><?php echo 'Traffic Lights '.$s['name'].' : ';?></div><div class="col-md-6"><input type="radio" id="toggles<?php echo $section1; ?>-tlightno" name="stlightstatus<?php echo $section; ?>" value="1" checked><label for="toggles<?php echo $section1; ?>-tlightno" class="radio">OK</label><input type="radio" id="toggles<?php echo $section1; ?>-tlightyes" name="stlightstatus<?php echo $section; ?>" value="2"><label for="toggles<?php echo $section1; ?>-tlightyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionstlight<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'stlightdesc<?php echo $section ?>' id= 'stlightdesc<?php echo $section ?>' value='<?php set_value('stlightdesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><div class="col-md-6 pr-1"><?php echo 'PFD '.$s['name'].' : ';?></div><div class="col-md-6"><input type="radio" id="toggles<?php echo $section1; ?>-pfdno" name="spfdstatus<?php echo $section; ?>" value="1" checked><label for="toggles<?php echo $section1; ?>-pfdno" class="radio">OK</label><input type="radio" id="toggles<?php echo $section1; ?>-pfdyes" name="spfdstatus<?php echo $section; ?>" value="2"><label for="toggles<?php echo $section1; ?>-pfdyes" class="radio">Faulty</label></div><div id="section000"></div><div id='sectionspfd<?php echo $section ?>' class="col-md-12 d-none"><div class='container row'><?php echo 'Reason :';?><textarea name= 'spfddesc<?php echo $section ?>' id= 'spfddesc<?php echo $section ?>' value='<?php set_value('spfddesc'.$section);?>' class= 'form-control' style='border:1px solid #E3E3E3' width='100%'></textarea><br/></div><br/></div><?php } ?></div></div>
			</div><br>
			<div class="row">
				<div class='col-md-4 pr-1'><div class="form-group"><div class="col-md"><label><?php echo 'Link Issue: ';?></label></div><div class="col-md"><input type="radio" id="togglelink-no" name="linkissue" value="0" checked><label for="togglelink-no" class="radio">No</label><input type="radio" id="togglelink-yes" name="linkissue" value="1"><label for="togglelink-yes" class="radio">Yes</label></div></div><div id='sectionlissue' class="d-none"><div class='form-group'><div class="col-md"><label><?php echo 'Link Issue Detail :';?></label><textarea name= 'lissue_desc' type= 'text' id= 'lissue_desc' value='<?php set_value('lissue_desc');?>' class= 'form-control' style='border:1px solid #E3E3E3' width="100%"></textarea></div></div></div></div><div class='col-md-5 pr-1'><div class="form-group"><div class="col-md"><label><?php echo 'Shutdown Report :';?></label></div><div class="col-md"><input type="radio" id="toggleshut-no" name="shutdown" value="0" checked><label for="toggleshut-no" class="radio">No</label><input type="radio" id="toggleshut-yes" name="shutdown" value="1"><label for="toggleshut-yes" class="radio">Yes</label></div></div><div id='sectionshut' class="d-none"><div class='row form-group'><div class="col-md-6"><label><?php echo 'From:';?></label><input type="time" name='shut_from' type='text' id= 'shut_from' value='<?php set_value('shut_from');?>' class='form-control' style='border:1px solid #E3E3E3' width="100%"></div><div class="col-md-6"><label><?php echo 'To:';?></label><input type="time" name= 'shut_to' type= 'text' id= 'shut_to' value='<?php set_value('shut_to');?>' class='form-control' style='border:1px solid #E3E3E3' width="100%"></div></div></div></div><div class='col-md-3 pr-1'><div class="form-group"><div class="col-md-2"><label><?php echo 'Server: ';?></label></div><div class="col-md"><input type="radio" id="toggleserver-on" name="serverstatus" value="0" checked><label for="toggleserver-on" class="radio">Online</label><input type="radio" id="toggleserver-off" name="serverstatus" value="1"><label for="toggleserver-off" class="radio">Offline</label></div></div></div>
			</div><br/>
			<div class='row'>
				<div class='col-md pr-1'><div class="form-group"><div class="col-md-2"><label><?php echo 'LSDU: ';?></label></div><div class="col-md-12"><input type="radio" id="togglelsdu-w" name="site_lsdu" value="0" checked><label for="togglelsdu-w" class="radio">Working</label><input type="radio" id="togglelsdu-nw" name="site_lsdu" value="1"><label for="togglelsdu-nw" class="radio">Not Working</label></div></div></div><div class="col-md"><div class="form-group"><div class="col-md"><label><?php echo 'Frame Grabber: ';?></label></div><div class="col-md"><input type="radio" id="toggleframe-w" name="frame" value="0" onclick='' checked><label for="toggleframe-w" class="radio">Working</label><input type="radio" id="toggleframe-nw" name="frame" value="1" onclick=''><label for="toggleframe-nw" class="radio">Not Working</label></div></div></div><div class='col-md'><div class="form-group"><div class="col-md"><label><?php echo 'Image: ';?></label></div><div class="col-md"><input type="radio" id="toggleimage-a" name="image" value="0" onclick='' checked><label for="toggleimage-a" class="radio">Available</label><input type="radio" id="toggleimage-na" name="image" value="1" onclick=''><label for="toggleimage-na" class="radio">Not Available</label></div></div></div>
			</div>
			<div class='row'>
				<div class="col-md-4"><div class="form-group"><div class="col-md"><label><?php echo 'Traffic: ';?></label></div><div class="col-md"><input name='site_dt' type='int' id='site_dt' value='<?php set_value('site_dt')?>' class='form-control required'></div></div></div><div class="col-md-4"><div class="form-group"><div class="col-md"><label><?php echo 'Revenue :';?></label></div><div class="col-md"><input name='site_dr' type='int' id='site_dr' value='<?php set_value('site_dr')?>' class='form-control required'></div></div></div><div class='col-md-4'><div class="form-group"><div class="col-md"><label><?php echo ' MTR Clear upto '?></label></div><div class="col-md"><input name= 'mtrstatus' type= 'month' value='<?php set_value('mtrstatus');?>' class= 'form-control required'></div></div></div>
			</div>		
			<div class='row'>
				<div class='col-md-4'><div class="form-group"><div class="col-md"><label><?php echo 'Pending MTR :';?></label></div><div class="col-md"><input name= 'apmtr' type= 'text'  value='<?php set_value('apmtr');?>' class= 'form-control required'></div></div></div><div class='col-md-4'><div class="form-group"><div class="col-md"><label><?php echo 'Uploaded MTR Upto :';?></label></div><div class="col-md"><input name='mtrupto' type='month'  value='<?php set_value('mtrupto');?>' class='form-control required'></div></div></div><div class='col-md-4'><div class="form-group"><div class="col-md"><label><?php echo 'Archived MTR Upto :';?></label></div><div class="col-md"><input name= 'asmtr' type= 'month'  value='<?php set_value('asmtr');?>' class= 'form-control required'></div></div></div>
			</div>
			<!--whitespace-->
			Attendance of Staff:
			<div class="container">
				<?php $as = 0; foreach($staff as $s){  $as++; $sectionh = $as + 1000;	?><div class='row'><div id="hol1<?php echo $as ?>" class="col-md-6 pr-1 form-group"><label><?php echo $as.'. '.$s['fname'].' '.$s['lname'] ?></label><input type="hidden" name= "as<?php echo $as; ?>" value="<?php echo 'as'.$as;?>" class="form-control"><select name= "as<?php echo $as ?>status" type= "int" value="<?php set_value('as'.$as.'status');?>" class= "form-control"><option value="">--Attendance--</option><option value="3">Present</option><option value="2">Absent</option><option value="1">Leave</option></select></div><div id="hol2<?php echo $as ?>" class="col-md-3 pr-1 form-group"><br><button type="button" name="button" class="btn btn-primary" id="holiday<?php echo $as ?>"><?php echo 'Planned Holidays';?></button></div><div id="section<?php echo $sectionh ?>" class="d-none col-md-6 row pr-1"><div class="col-md-6 form-group"><label><?php echo 'From '; ?></label><input name= "as<?php echo $as ?>holidayfrom" type= "date" value="<?php set_value('as'.$as.'holidayfrom');?>" class= "form-control"></div><div class="col-md-6 form-group"><label><?php echo' To '; ?></label><input name= "as<?php echo $as ?>holidayto" type= "date" value="<?php set_value('as'.$as.'holidayto');?>" class= "form-control"></div></div></div><?php } ?>
			</div>
			Plaza Condition:
			<div class="container">
				<div class='row container'>
					<div class="col-md-4">
						<div class="form-group">
							<label><?php echo 'Cleaning:';?></label>
							<select name ='pccleaning' type ='int' value='<?php set_value('pccleaning');?>' class='form-control required'><option value="">--Current Status--</option><option value="1">Worse</option><option value="2">Bad</option><option value="3">Average</option><option value="4">Good</option><option value="5">Excellent</option></select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label><?php echo 'Building:';?></label>
							<select name ='pcbuilding' type ='int' value='<?php set_value('pcbuilding');?>' class='form-control required'><option value="">--Current Status--</option><option value="1">Worse</option><option value="2">Bad</option><option value="3">Average</option><option value="4">Good</option><option value="5">Excellent</option></select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label><?php echo 'Meal:';?></label>
							<select name ='pcmeal' type ='int' value='<?php set_value('pcmeal');?>' class='form-control required'><option value="">--Current Status--</option><option value="1">Worse</option><option value="2">Bad</option><option value="3">Average</option><option value="4">Good</option><option value="5">Excellent</option></select>
						</div>
					</div>
				</div><br/>
				<div class='row container'>
					<div class="col-md-4">
						<div class="form-group">
							<label><?php echo 'Water:';?></label>
							<select name ='pcwater' type ='int' value='<?php set_value('pcwater');?>' class='form-control required'><option value="">--Current Status--</option><option value="1">Worse</option><option value="2">Bad</option><option value="3">Average</option><option value="4">Good</option><option value="5">Excellent</option></select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label><?php echo 'Receipts:';?></label>
							<select name ='pcreceipts' type ='text' value='<?php set_value('pcreceipts');?>' class='form-control required'><option value="">--Current Status--</option><option value="1">Automatic</option><option value="2">Manual</option></select>
						</div>
					</div>
					<div class='col-md-4'>
						<div class="form-group">
							<label><?php echo 'Queuing:';?></label>
							<input name= 'pcqueuing' type= 'text' value='<?php set_value('pcqueuing');?>' class= 'form-control required'>
						</div>
					</div>
				</div><br/>
				<div class='row container'>
					<div class='col-md-6'>
						<div class="row form-group">
							<div class="col-md-6">
								<label><?php echo 'Electricity:';?></label>
							</div>
							<div class="col-md-6">
								<select name ='pcelectricity' type ='int' value='<?php set_value('pcelectricity');?>' class='form-control required' onchange="selectionelectricity(this)"><option value="1">Stable</option><option value="2">Unstable</option></select>
							</div>
						</div>
					</div>
				</div>
				<div class="row container">
					<div class="col-md-12 form-group">
						<div id="sectionstable" style="display:none"></div>
						<div id="sectionunstable" style="display:none">
							<div class="row form-group">
								<div class="col-md-6 row">
									<div class="col-md-6"><label for="">Loadshedding Status</label></div>
									<div class="col-md-6"><select name="loadshedding-status" id="load-status" class="form-control"><option id="load-no" value="1">No</option><option id="load-yes" value="2">Yes</option></select></div>
								</div>
							</div>
							<div id="loadshedding" class="d-none">
								<p><strong>Loadshedding</strong></p>
								<div class="row container">
									<div class="col-md-4">
										<label for="load-from">From</label>
										<input type="time" id="load-from" class="form-control" name="load-from">
									</div>
									<div class="col-md-4">
										<label for="load-to">To</label>
										<input type="time" id="load-to" class="form-control" name="load-to">
									</div>
									<div class="col-md-4">
										<label for="load-time">Total Time</label>
										<input type="text" id="load-time" class="form-control" name="load-time">
									</div>
								</div>
							</div>
							
							<div class="row container text-center">
								<div class="col-md-3">
									<input type="radio" id="toggleun-g" name="ecause" value="2" onclick= ''>
									<label for="toggleun-g" class="radio">Generator</label>
								</div>
								<div class="col-md-3">
									<input type="radio" id="toggleun-u" name="ecause" value="3" onclick= ''>
									<label for="toggleun-u" class="radio">UPS</label>
								</div>
								<div class="col-md-6" id="ups-reason">
									<div class='container row'><?php echo 'Reason :';?><textarea name= 'ereason' id= 'ereason' value='<?php set_value('ereason');?>' class= 'form-control' style='border:1px solid #E3E3E3' width="100%"></textarea><br/></div><br/>
								</div>
							</div>
							<div id="generator-log" class="d-none container">
								<p><strong>Generator Log</strong></p>
								<div class="row container">
									<div class="col-md-4">
										<label for="generator-from">From</label>
										<input type="time" id="generator-from" class="form-control" name="generator-from">
									</div>
									<div class="col-md-4">
										<label for="generator-from">To</label>
										<input type="time" id="generator-to" class="form-control" name="generator-to">
									</div>
									<div class="col-md-4">
										<label for="generator-time">Total Time</label>
										<input type="text" id="generator-time" class="form-control" name="generator-time">
									</div>
								</div>
								<p><strong>Fuel Consumption</strong></p>
								<div class="row container">
									<div class="col-md-4">
										<label for="diesel-per-hour">Diesel per Hour</label>
										<input name="diesel-per-hour" class="form-control" id="diesel-per-hour" type="number">
									</div>
									<div class="col-md-4">
										<label for="diesel-consumed">Diesel Consumed</label>
										<input name="diesel-consumed" class="form-control" id="diesel-consumed" type="number">
									</div>
									<div class="col-md-4">
										<label for="output-voltage">Output Voltage</label>
										<input name="output-voltage" class="form-control" id="output-voltage" type="number">
									</div>
								</div>
								<div class="row container">
									<div class="col-md-4">
										<label for="fuel-level">Fuel Level</label>
										<select class="form-control" name="fuel-level" id="fuel-level"><option value="1">Ok</option><option value="2">Satisfactory</option><option value="3">Low</option><option value="4">Refill</option></select>
									</div>
									<div class="col-md-4">
										<label for="oil-level">Oil Level</label>
										<select class="form-control" name="oil-level" id="oil-level"><option value="1">Ok</option><option value="2">Satisfactory</option><option value="3">Low</option><option value="4">Refill</option></select>
									</div>
									<div class="col-md-4">
										<label for="oil-change">Oil Change</label>
										<select class="form-control" name="oil-change" id="oil-change"><option value="1">Not Needed</option><option value="2">Changed</option></select>
									</div>
								</div>
								<div class="row container">
									<div class="col-md-4">
										<label for="radiator-water-level">Radiator Water Level</label>
										<select class="form-control" name="radiator-water-level" id="radiator-water-level"><option value="1">Ok</option><option value="2">Satisfactory</option><option value="3">Low</option><option value="4">Refill</option></select>
									</div>
									<div class="col-md-4">
										<label for="battery-water-level">Battery Water Level</label>
										<select class="form-control" name="battery-water-level" id="battery-water-level"><option value="1">Ok</option><option value="2">Satisfactory</option><option value="3">Low</option><option value="4">Refill</option></select>
									</div>
									<div class="col-md-4">
										<label for="battery-terminal-condition">Battery Terminal Condition</label>
										<select class="form-control" name="battery-terminal-condition" id="battery-terminal-condition"><option value="1">Ok</option><option value="2">Corroded</option><option value="3">Cleaned</option></select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><div class="row"><div class='col-md-6'><div class="row form-group"><div class="col-md-7"><label><?php echo 'Support Request Generated :';?></label></div><div class="col-md-5"><select name ='asrg' type ='int' value='<?php set_value('asrg');?>' class='form-control required' onchange='selectionasrg(this)'><option value="">--Status--</option><option value="2">Yes</option><option value="1">No</option></select></div></div></div></div><br/><div id='sectionr3'></div><div id='sectionrequest' style='display:none'><div class='row container'><div class='col-md-3 pr-1'><div class="form-group"><label><?php echo 'Reference No: ';?></label><input name= 'refno' type= 'text' value='<?php set_value('refno');?>' class= 'form-control'></div></div><div class="col-md-3 pr-1"><div class='form-group'><label><?php echo 'Date Generated :';?></label><input name= 'refduration' type= 'date' value='<?php set_value('refduration');?>' class= 'form-control'></div></div><div class="col-md-6"><div class="form-group"><label><?php echo 'Detail :';?></label><textarea name='request_detail' value='<?php set_value('request_detail');?>' class= 'form-control' style="border:'1px solid #E3E3E3'" width="100%"></textarea></div></div></div></div>
			</div>
			<div class="row">	
				<div class="col-md-9 form-group"></div>
				<div class="col-md-3 form-group">
					<div class="col-md-12 pr-1 wrap-input-container">
						<span type="input" class="btn btn-info btn-block pull-right" onclick="form_submit('add_dsr');">Submit</span>
						<!--This code is used for testing form submit with database-->
						<?php  // echo form_submit('Submit', 'submit', array('class' => 'btn btn-info btn-block pull-right') ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_close();?> 
	</div>
</div>
<script>
	$('#datecreated').datepicker({format:'yyyy-mm-dd'});
	<?php $counter = 0; foreach($north as $n){ $counter++; $section = $counter; $section1= $counter+100; $section2= $counter+200; $section3= $counter+300; $section4= $counter+400; $section5= $counter+500; ?>
	var northsec1 = 'togglen<?php echo $section1 ?>';
	/*var sect1 = '#sectionn<?php echo $section1 ?>';*/
	$('#'+northsec1+'-open').click(function(){ $('#sectionn<?php echo $section1 ?>').addClass('d-none'); });
	$('#'+northsec1+'-closed').click(function(){ $('#sectionn<?php echo $section1 ?>').removeClass('d-none'); });
	$('#'+northsec1+'-omc,#'+northsec1+'-tech').click(function(){ $('#sectionn<?php echo $section3 ?>').removeClass('d-none'); });
	$('#'+northsec1+'-ohlsno').click(function(){ $('#sectionnohls<?php echo $section ?>').addClass('d-none'); });
	$('#'+northsec1+'-ohlsyes').click(function(){ $('#sectionnohls<?php echo $section ?>').removeClass('d-none'); });
	$('#'+northsec1+'-cno').click(function(){ $('#sectionnfc<?php echo $section4 ?>').addClass('d-none'); });
	$('#'+northsec1+'-cyes').click(function(){ $('#sectionnfc<?php echo $section4 ?>').removeClass('d-none'); });
	$('#'+northsec1+'-boomarmno').click(function(){ $('#sectionnboomarm<?php echo $section ?>').addClass('d-none'); });
	$('#'+northsec1+'-boomarmyes').click(function(){ $('#sectionnboomarm<?php echo $section ?>').removeClass('d-none'); });
	$('#'+northsec1+'-boommechno').click(function(){ $('#sectionnboommech<?php echo $section ?>').addClass('d-none'); });
	$('#'+northsec1+'-boommechyes').click(function(){ $('#sectionnboommech<?php echo $section ?>').removeClass('d-none'); });
	$('#'+northsec1+'-tprinterno').click(function(){ $('#sectionntprinter<?php echo $section ?>').addClass('d-none'); }); 
	$('#'+northsec1+'-tprinteryes').click(function(){ $('#sectionntprinter<?php echo $section ?>').removeClass('d-none'); });
	$('#'+northsec1+'-tctno').click(function(){ $('#sectionntct<?php echo $section ?>').addClass('d-none'); });
	$('#'+northsec1+'-tctyes').click(function(){ $('#sectionntct<?php echo $section ?>').removeClass('d-none'); });
	$('#'+northsec1+'-lanepcno').click(function(){ $('#sectionnlanepc<?php echo $section ?>').addClass('d-none'); });
	$('#'+northsec1+'-lanepcyes').click(function(){ $('#sectionnlanepc<?php echo $section ?>').removeClass('d-none'); });
	$('#'+northsec1+'-tlightno').click(function(){ $('#sectionntlight<?php echo $section ?>').addClass('d-none'); });
	$('#'+northsec1+'-tlightyes').click(function(){ $('#sectionntlight<?php echo $section ?>').removeClass('d-none'); });
	$('#'+northsec1+'-pfdno').click(function(){ $('#sectionnpfd<?php echo $section ?>').addClass('d-none'); });
	$('#'+northsec1+'-pfdyes').click(function(){ $('#sectionnpfd<?php echo $section ?>').removeClass('d-none'); });
	<?php }
	$counter = 0; foreach($south as $s){ $counter++; $section = $counter; $section1= $counter+100; $section2= $counter+200; $section3= $counter+300; $section4= $counter+400; $section5= $counter+500; ?>
	var togsec1 = 'toggles<?php echo $section1 ?>';
	/*var sect1 = '#sectionn<?php echo $section1 ?>';*/
	$('#'+togsec1+'-open').click(function(){ $('#sections<?php echo $section2 ?>').addClass('d-none'); });
	$('#'+togsec1+'-closed').click(function(){ $('#sections<?php echo $section2 ?>').removeClass('d-none'); });
	$('#'+togsec1+'-omc,#'+togsec1+'-tech').click(function(){ $('#sections<?php echo $section3 ?>').removeClass('d-none'); });
	$('#'+togsec1+'-ohlsno').click(function(){ $('#sectionsohls<?php echo $section ?>').addClass('d-none'); });
	$('#'+togsec1+'-ohlsyes').click(function(){ $('#sectionsohls<?php echo $section ?>').removeClass('d-none'); });
	$('#'+togsec1+'-cno').click(function(){ $('#sectionsfc<?php echo $section4 ?>').addClass('d-none'); });
	$('#'+togsec1+'-cyes').click(function(){ $('#sectionsfc<?php echo $section4 ?>').removeClass('d-none'); });
	$('#'+togsec1+'-boomarmno').click(function(){ $('#sectionsboomarm<?php echo $section ?>').addClass('d-none'); });
	$('#'+togsec1+'-boomarmyes').click(function(){ $('#sectionsboomarm<?php echo $section ?>').removeClass('d-none'); });
	$('#'+togsec1+'-boommechno').click(function(){ $('#sectionsboommech<?php echo $section ?>').addClass('d-none'); });
	$('#'+togsec1+'-boommechyes').click(function(){ $('#sectionsboommech<?php echo $section ?>').removeClass('d-none'); });
	$('#'+togsec1+'-tprinterno').click(function(){ $('#sectionstprinter<?php echo $section ?>').addClass('d-none'); });
	$('#'+togsec1+'-tprinteryes').click(function(){ $('#sectionstprinter<?php echo $section ?>').removeClass('d-none'); });
	$('#'+togsec1+'-tctno').click(function(){ $('#sectionstct<?php echo $section ?>').addClass('d-none'); });
	$('#'+togsec1+'-tctyes').click(function(){ $('#sectionstct<?php echo $section ?>').removeClass('d-none'); });
	$('#'+togsec1+'-lanepcno').click(function(){ $('#sectionslanepc<?php echo $section ?>').addClass('d-none'); });
	$('#'+togsec1+'-lanepcyes').click(function(){ $('#sectionslanepc<?php echo $section ?>').removeClass('d-none'); });
	$('#'+togsec1+'-tlightno').click(function(){ $('#sectionstlight<?php echo $section ?>').addClass('d-none'); });
	$('#'+togsec1+'-tlightyes').click(function(){ $('#sectionstlight<?php echo $section ?>').removeClass('d-none'); });
	$('#'+togsec1+'-pfdno').click(function(){ $('#sectionspfd<?php echo $section ?>').addClass('d-none'); });
	$('#'+togsec1+'-pfdyes').click(function(){ $('#sectionspfd<?php echo $section ?>').removeClass('d-none'); });
	<?php } ?>
	$('#toggleptz1-cno').click(function(){ $('#sectionptz1').addClass('d-none'); });
	$('#toggleptz1-cyes').click(function(){ $('#sectionptz1').removeClass('d-none'); });
	$('#toggleptz2-cno').click(function(){ $('#sectionptz2').addClass('d-none'); });
	$('#toggleptz2-cyes').click(function(){ $('#sectionptz2').removeClass('d-none'); });
	
	var selectionelectricity = function(select){
		var sections = { '1': 'sectionstable', '2': 'sectionunstable' }
		for(i in sections){ document.getElementById(sections[i]).style.display = "none"; document.getElementById(sections[select.value]).style.display = "block"; }
	}
	var selectionasrg = function(select){
		var sections = { '2': 'sectionrequest', '1': 'sectionr3' }
		for(i in sections){ document.getElementById(sections[i]).style.display = "none"; document.getElementById(sections[select.value]).style.display = "block"; }
	}
	<?php for($count = '1'; $count < '6'; $count++){ $as = $count; $sectionh = $count + 1000; ?>
	var as = '#holiday'+<?php echo $as ?>; var sec = '#section<?php echo $sectionh; ?>';
	$(as).click(function(){
		$('#section<?php echo $sectionh; ?>').toggleClass('d-none');
		$('#hol1<?php echo $as ?>').toggleClass('col-md-3');
		$('#hol1<?php echo $as ?>').toggleClass('col-md-6');
	})
	<?php } ?> 
	
	$('#toggleun-g').click(function(){ $('#generator-log').removeClass('d-none'); });
	$('#toggleun-u').click(function(){ $('#generator-log').addClass('d-none'); });
	$('#togglelink-yes').click(function(){ $('#sectionlissue').removeClass('d-none'); });
	$('#togglelink-no').click(function(){ $('#sectionlissue').addClass('d-none'); });
	$('#toggleshut-yes').click(function(){ $('#sectionshut').removeClass('d-none'); });
	$('#toggleshut-no').click(function(){ $('#sectionshut').addClass('d-none'); });
	$('select#load-status').change(function(){
		if($(this).val() == 2){ $('#loadshedding').removeClass('d-none');}
		if($(this).val() == 1){ $('#loadshedding').addClass('d-none');} 
	});
	$('#load-to').keyup(function(){
		var load_to = $('#load-to').val().split(':'); 
		var load_from = $('#load-from').val().split(':'); 
		var time_hours =  load_to[0] - load_from[0];
		var time_minutes = load_to[1] - load_from[1];
		if(time_minutes){
			$('#load-time').val(time_hours + ' Hours ' + time_minutes + ' Minutes'); 
		}
		else{
			$('#load-time').val(time_hours + ' Hours'); 
		}
		
	});
	$('#generator-to').keyup(function(){
		var generator_to = $('#generator-to').val().split(':'); 
		var generator_from = $('#generator-from').val().split(':'); 
		var time_hours =  generator_to[0] - generator_from[0];
		var time_minutes =  generator_to[1] - generator_from[1];
		if(time_minutes){
			$('#generator-time').val(time_hours + ' Hours ' + time_minutes + ' Minutes');
		}
		else{
			$('#generator-time').val(time_hours + ' Hours'); 
		}
	});
	
</script>
