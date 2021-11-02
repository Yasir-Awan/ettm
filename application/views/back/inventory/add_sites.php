<?php echo form_open(base_url()."inventory/add_site_do/",array('id' => 'add_site_locations'));?>
        <div class="form-group">

        <div class='row'>
            <div class='col-md-3'>
            <label for="route" class="col-form-label" data-original-title="" title="">Route</label>
             </div>
             <div class="col-md-7" >
             <select name="route" id="route" class="form-control required" tabindex="-1">
             <option value="">Select Route</option>
             <?php if($this->session->userdata('role')==3){ ?>
              <option value="3">M3</option>
             <?php } ?>
             <?php if($this->session->userdata('role')==14){ ?>
              <option value="14">Havelian-Thakot</option>
             <?php } ?>
             <?php if($this->session->userdata('role')==5){ ?>
              <option value="5">M5</option>
             <?php } ?>
             <?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==2){ ?>
              <option value="1">N-5</option>
              <option value="3">M-3</option>
              <option value="4">M-4</option>
              <option value="5">M-5</option>
              <option value="6">N-55</option>
              <option value="7">M-1</option>
              <option value="8">M-4</option>
              <option value="9">E-35</option>
              <option value="10">N-65</option>
              <option value="11">KKHH</option>
              <option value="12">N-25</option>
              <option value="13">N-40</option>
              <option value="14">Head Quater</option>
             <?php } ?>
             </select>
             </div>
             </div>
          
        <div class='row'>
            <div class='col-md-3'>
            <label for="site_type" class="col-form-label" data-original-title="" title="">Site Type</label>
             </div>
             <div class="col-md-7" >
             <select name="site_type" id="site_type" class="form-control required" tabindex="-1">
             <option value="">Select Site Type</option>
              <option value="1">Toll Plaza</option>
             <?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==2){ ?>
              <option value="2">Weigh Station</option>
              <option value="3">Head Quarter</option>
             <?php } ?>
             </select>
             </div>
             </div>

          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">SITE NAME</label>
             </div>
             <div class="col-md-7">
              <input required="required" class="form-control" value="Head Quarter" 
               type="text" name="site_name" id="site_name">
             </div>
          </div>
          

          <div class="form-group general_loc" >
          <div class='row'>
               <div class='col-md-3'>
               <label for="example-text-input" class="col-form-label" data-original-title="" title="">General Locations</label>
               </div>
             <div class="col-md-7" style='margin-left:3px;'>
             <select name="general[]"  class="form-control" multiple="multiple" data-placeholder="North Locations" tabindex="-1" data-hide-disabled="true" id="general">
              <option value="Support Room">Support Room</option>
              <option value="Cashup Room">Cashup Room</option>
              <option value="Technical Room">Technical Room</option>
              <option value="Server Room">Server Room</option>
              <option value="OPS 1">OPS 1</option>
              <option value="OPS 2">OPS 2</option>
              <option value="Computer Bearue">Computer Bearue</option>
              <option value="Store Room">Store Room</option>
              <option value="Control Room">Control Room</option>
              <option value="Generator Room">Generator Room</option>
              <option value="Weigh Station Service Area">Weigh Station Service Area</option>
             </select>
             </div>
          </div>
          </div>

          <div class="form-group " >
          <div class='row'>  
             <div class="col-md-4" id="north_loc" style="margin-left:100px;">
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">North Lanes/Bound</label>
             <select name="north[]" class="form-control" multiple="multiple" data-placeholder="North Locations" tabindex="-1" data-hide-disabled="true" id="north" style="width:auto;">
              <option value="N1">N1</option>
              <option value="N2">N2</option>
              <option value="N3">N3</option>
              <option value="N4">N4</option>
              <option value="N5">N5</option>
              <option value="N6">N6</option>
              <option value="N7">N7</option>
              <option value="N8">N8</option>
              <option value="North Bound">North Bound</option>
             </select>
             </div>
           
            <div class="col-md-5 north_booth" style="display:none;">
            <label>Booths</label>
            <select class="form-control " multiple="multiple" name="northBooths[]" id="northbooth" >
            <option value="N1 Inside Booth" >N1 Booth</option>
            <option value="N2 Inside Booth" >N2 Booth</option>
            <option value="N3 Inside Booth" >N3 Booth</option>
            <option value="N4 Inside Booth" >N4 Booth</option>
            <option value="N5 Inside Booth" >N5 Booth</option>
            <option value="N6 Inside Booth" >N6 Booth</option>
            <option value="N7 Inside Booth" >N7 Booth</option>
            <option value="N8 Inside Booth" >N8 Booth</option>
            </select>
             </div>
          </div>
          </div>

          <div class="form-group">
          <div class='row'>
             <div class="col-md-4" id="south_loc" style="margin-left:100px;">
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">South Lanes/Bound</label>
             <select name="south[]"  class="form-control" multiple="multiple" data-placeholder="North Locations" tabindex="-1" data-hide-disabled="true" id="south" style="width:auto;">
              <option value="S1">S1</option>
              <option value="S2">S2</option>
              <option value="S3">S3</option>
              <option value="S4">S4</option>
              <option value="S5">S5</option>
              <option value="S6">S6</option>
              <option value="S7">S7</option>
              <option value="S8">S8</option>
              <option value="South Bound">South Bound</option>
             </select>
             </div>
      
            <div class="col-md-5 south_booth" style="display:none; ">
            <label>Booths</label>
            <select class="form-control" multiple="multiple" name="southBooths[]" id="southbooth" >
            <option value="S1 Inside Booth" >S1 Booth</option>
            <option value="S2 Inside Booth" >S2 Booth</option>
            <option value="S3 Inside Booth" >S3 Booth</option>
            <option value="S4 Inside Booth" >S4 Booth</option>
            <option value="S5 Inside Booth" >S5 Booth</option>
            <option value="S6 Inside Booth" >S6 Booth</option>
            <option value="S7 Inside Booth" >S7 Booth</option>
            <option value="S8 Inside Booth" >S8 Booth</option>
            </select>
             </div>
          </div>
          </div>


        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('add_site_locations');">Add SITE</button>
          <?php echo form_close();?>

          <script>       
              $('body').on('click', "#north_loc", function (){ 
              $('.north_booth').show('slow');  
              });
          </script>

          <script>       
              $('body').on('click', "#south_loc", function (){ 
              $('.south_booth').show('slow');  
              });
          </script>