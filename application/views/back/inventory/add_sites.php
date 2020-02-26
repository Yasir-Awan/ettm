<?php echo form_open(base_url()."inventory/add_site_do/",array('id' => 'add_site_locations'));?>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-3'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">SITE NAME</label>
             </div>
             <div class="col-md-8">
              <input required="required" style="margin-left:-45px;" class="form-control" value="Head Quarter" 
               type="text" name="site_name" id="site_name">
             </div>
          </div>
          

          <div class="form-group general_loc" >
          <div class='row'>
             <div class="col-md-7" style='margin-left:100px;'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">General Locations</label>
             <select name="general[]"  class="form-control" multiple="multiple" data-placeholder="North Locations" tabindex="-1" data-hide-disabled="true" id="general">
              <option value="Support Room">Support Room</option>
              <option value="Cashup Room">Cashup Room</option>
              <option value="Technical Room">Technical Room</option>
              <option value="Server Room">Server Room</option>
              <option value="OPS 1">OPS 1</option>
              <option value="OPS 2">OPS 2</option>
              <option value="Computer Bearue">Computer Bearue</option>
              <option value="Store Room">Store Room</option>
             </select>
             </div>
          </div>
          </div>

          <div class="form-group " >
          <div class='row'>  
             <div class="col-md-3 " id="north_loc" style="margin-left:100px;">
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">North Lanes</label>
             <select name="north[]" class="form-control" multiple="multiple" data-placeholder="North Locations" tabindex="-1" data-hide-disabled="true" id="north">
              <option value="N1">N1</option>
              <option value="N2">N2</option>
              <option value="N3">N3</option>
              <option value="N4">N4</option>
              <option value="N5">N5</option>
              <option value="N6">N6</option>
             </select>
             </div>
           
            <div class="col-md-5 north_booth" style="display:none; margin-left:-25px; margin-top:5px;">
            <label>North Booths</label>
            <select class="form-control " multiple="multiple" name="northBooths[]" id="northbooth" >
            <option value="N1 Inside Booth" >N1 Inside Booth</option>
            <option value="N2 Inside Booth" >N2 Inside Booth</option>
            <option value="N3 Inside Booth" >N3 Inside Booth</option>
            <option value="N4 Inside Booth" >N4 Inside Booth</option>
            <option value="N5 Inside Booth" >N5 Inside Booth</option>
            <option value="N6 Inside Booth" >N6 Inside Booth</option>
            </select>
             </div>
          </div>
          </div>

          <div class="form-group">
          <div class='row'>
             <div class="col-md-3" id="south_loc" style="margin-left:100px;">
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">South Lanes</label>
             <select name="south[]"  class="form-control" multiple="multiple" data-placeholder="North Locations" tabindex="-1" data-hide-disabled="true" id="south">
              <option value="S1">S1</option>
              <option value="S2">S2</option>
              <option value="S3">S3</option>
              <option value="S4">S4</option>
              <option value="S5">S5</option>
              <option value="S6">S6</option>
             </select>
             </div>
      
            <div class="col-md-5 south_booth" style="display:none; margin-left:-25px; margin-top:5px;">
            <label>South Booths</label>
            <select class="form-control" multiple="multiple" name="southBooths[]" id="southbooth" >
            <option value="S1 Inside Booth" >S1 Inside Booth</option>
            <option value="S2 Inside Booth" >S2 Inside Booth</option>
            <option value="S3 Inside Booth" >S3 Inside Booth</option>
            <option value="S4 Inside Booth" >S4 Inside Booth</option>
            <option value="S5 Inside Booth" >S5 Inside Booth</option>
            <option value="S6 Inside Booth" >S6 Inside Booth</option>
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