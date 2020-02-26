<?php echo form_open(base_url()."inventory/add_subitem_do/",array('id' => 'add_subitems'));?>
        <div class="form-group">
              <div class='row'>
                  <div class='col-md-4'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Category</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                  </div>
                  <div class='col-md-7' >
                    <select class="form-control required" style="margin-left:-45px;" name="item_category" id="item_category" placeholder="Select Asset Name">
                    <option value="">Select Option</option>
                    <option value=1>Marketing/Promotional Material</option>
                    <option value=2>Event/Staging Equipment</option>
                    <option value=3>Electronic Equipment</option>
                    <option value=4>Support Room Equipment</option>
                    <option value=5>Cashup Room Equipmet</option>
                    <option value=6>Control Room Equipment</option>
                    <option value=7>Power Supply Equipment</option>
                    <option value=8>Lane Equipment</option>
                    <option value=9>Booth Equipment</option>
                    <option value=10>Consumeable Items</option>
                    <option value=11>Furniture</option>
                    <option value=12>IT Assets</option>
                    <option value=13>Tools</option> 
                    </select>
                  </div>
              </div>
        </div>
        <div class="form-group mainitem_name" style="display:none;">
                  <div class='row'>
                    <div class='col-md-3'>
                    <label for="example-text-input" class="col-form-label" data-original-title="" title="">Item Name</label>
                    <span class="asterisk" data-original-title="" title="">*</span>
                    </div>
                    <div class='col-md-7' >
                    <select class="form-control required" name="item_name" id="item_name" placeholder="Select Asset Name">
                    <option value=""><?php echo "Select Asset Name";?></option>
                   <!-- <?php foreach($items as $item){?>
                    <option value="<?php echo $item['id'] ?>"><?php echo $item['name'];?></option>
                    <?php } ?> -->
                    </select>
                    </div>
                   </div>
                </div>
        <div class="form-group">
          <div class='row'>
             <div class='col-md-4'>
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Subitem Name</label>
             <span class="asterisk" data-original-title="" title="">*</span>
             </div>
             <div class="col-md-7">
              <input required="required" style="margin-left:-45px;" class="form-control" value="LCD" 
               type="text" name="subitem_name" id="subitem_name">
             </div>
          </div>
          <br>

          <div class="form-group">
                <div class='row'>
                 <div class='col-md-3'>
                <label for="example-text-input" class="col-form-label" data-original-title="" title="">Quantity</label>
                <span class="asterisk" data-original-title="" title="">*</span>
                </div>
                <div class="col-md-7">

               <input type="number" class="form-control required" id="quantity" name="quantity" value="" placeholder="Enter Quantity" min="1"> 
               </div>
               </div>
                </div> 


        <div class="form-group">
            <div class="row">
              <div class='col-md-4'>
              <label for="fixed_asset_description" class="col-form-label" data-original-title="" title="">Description</label>
              <span class="asterisk" data-original-title="" title="">*</span>
              </div>
              <div class="col-md-7">
              <textarea rows="5"  class="form-control" style="margin-left:-45px;" name="item_[description]" id="item_description"></textarea>
              </div>     
            </div>
          </div>
        </div>
           <br>




        <button type="button" class="btn btn-primary pull-right" onclick="form_submit('add_subitems');">Add Sub Item</button>
          <?php echo form_close();?>


          <script>
           $('#item_category').change(function (){    
            var itemType = this.value;
             $.ajax({ 
              url: "<?php echo base_url() ?>inventory/items_have_subitems/"+itemType,
              cache       : false,
              contentType : false,
              processData : false,
              beforeSend: function() {
                var top = '200';
                $('#item_name').html('<div style="text-align:center;width:100%;position:relative;top:'+top+'px; min-height:300px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>'); // change submit button text
              },
              success: function(data) {
                //  alert(data);
                  items = JSON.parse(data);
                  console.log(items);
                  $('.mainitem_name').show('slow');
                  items.items.forEach(item => {
                  $('#item_name').append('<option value="'+item.id+'">'+ item.name  +'</option>');
                  });                
                },
              error: function(e) {
              //  console.log(e)
              }
          });
        });
        </script>