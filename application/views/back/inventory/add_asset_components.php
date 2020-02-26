<ul class="nav nav-tabs uts" id="myTab" role="tablist">
<?php 
$tabid=0;
$cid=0;
$esid=0;
$csid=0;
$cmodelid=0;
$cmfcid=0;
$cmfgid=0;
$cwtid=0;
$cwdid=0;
$ccostid=0;
for($i=0; $i<$quantity; $i++)
{
?>
  <li class="nav-item">
    <a class="nav-link <?php if($i == 0){ echo "active";} ?>" id="<?php echo $i."-tab"; ?>" data-toggle="tab" href="#<?php echo $i+1; ?>_div"  role="tab" aria-controls="home" aria-selected="true">STEP <?php echo $i+1; ?></a>
  </li>
<?php 
} ?>
</ul>
<?php echo validation_errors(); ?>

<form action="" id="asset_components" >
<div class="tab-content" id="compTabContent">
 <?php
 for($i=0; $i<$quantity; $i++)
 {
  if($i == 0 && $quantity == 1){ ?>
  <div class="tab-pane fade single active show" id="1_div" role="tabpanel" aria-labelledby="<?php echo $tabid++ ?>-tab">
    <!-- <p><?php echo "Step 1 "; ?>.</p> -->
            <div class="form-group mt-2" >
                  <div class='row'>
                    <div class='col-md-4'>
                    <label class="col-form-label" data-original-title="" title="">Equipment Serial #</label>
                    </div>
                    <div class='col-md-6'>
                    <input class="form-control equipSerial" type="text" id="eserial<?php echo $esid++ ?>" name='equip_serial[]' placeholder="Equipment Serial No" value="">
                    </div>
                   </div>
              
          <div class='row'>
             <div class='col-md-4'>
             <label class="col-form-label" data-original-title="" title="">Total Components</label>
             </div>
             <div class="col-md-6">
              <span class="form-control" readonly><?php  echo $total_comps.","?></span>
               <input class="form-control" type="hidden" name='company_type' value="" >
             </div>
          </div>
          </div>
          
          <div class="row" > <!-- div for individual componet checkbox START -->
        <?php for($even=0; $even<$total_comps; $even=$even+2){ ?>
          <?php $cid++; ?>
          <div class="form-group col-md-6">
          <div class="row">
             <div class='col-md-2' style="padding-top:3%;">
             <input type="checkbox" class="selection componentId" id="cid<?php echo $cid ?>" onchange = "console.log(this.getAttribute('value'))" name="cmpastselection" id="cmpastischecked" value="<?php echo $comps[$even]['id'] ?>">
             </div>
             <div class="col-md-7">
             <label  for="cid<?php echo $cid ?>" class="col-form-label" data-original-title="" title=""><?php echo $comps[$even]['name'];?></label>
             </div>
          </div>
          <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="" >Serial#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compSerial " id="cserial<?php echo $csid++ ?>" type="text" name='comp_serial[]' data-comp-id="cid<?php echo $cid ?>" placeholder="Serial No" value="<?php echo set_value('comp_serial[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Model#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compModel" id="cmodal<?php echo $cmodelid++ ?>" type="text" data-comp-id="cid<?php echo $cid ?>" name='comp_model[]' placeholder="Model No" value="<?php echo set_value('comp_model[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Manufacturer</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compManufacturer" id="cmfc<?php echo $cmfcid++ ?>" data-comp-id="cid<?php echo $cid ?>" type="text" name='comp_manufacturer[]' placeholder="Manufacturer" value="<?php echo set_value('comp_manufacturer[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Mfg Date</label>
             </div>
             <div class="col-md-7">
             <input type="date" id="cmfg<?php echo $cmfgid++ ?>" class="form-control compMfg" data-comp-id="cid<?php echo $cid ?>" onclick="manufacturer_date(this.getAttribute('id'))"  name="mfg_date[]" placeholder="Choose Manufacturing Date">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Wrnty Type</label>
             </div>
             <div class="col-md-7">
             <select class="form-control required compWarrantyType" name="cmp_warranty_type[]" data-comp-id="cid<?php echo $cid ?>" id="cwt<?php echo $cwtid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','0') ?>" >Have No Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','1') ?>" >Replacement Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','2') ?>" >Repairing Warranty</option>
                </select>
             </div>
            </div>
            <div class="row cmp_warranty_duration" >
             <div class="col-md-5">
             <label class="col-form-label">Duration</label>
             </div>
             <div class="col-md-7">
             <select class="form-control compWarrantyDuration" name="cmp_warranty_duration[]" data-comp-id="cid<?php echo $cid ?>" id="cwd<?php echo $cwdid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','3 Months') ?>" >3 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','6 Months') ?>" >6 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','9 Months') ?>" >9 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','12 Months') ?>" >1 Year</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','24 Months') ?>" >2 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','36 Months') ?>" >3 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','48 Months') ?>" >4 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','60 Months') ?>" >5 Years</option>
                </select>
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Cost</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compCost" type="text" name='comp_cost[]' data-comp-id="cid<?php echo $cid ?>" id="ccost<?php echo $ccostid++ ?>" placeholder="Cost" value="<?php echo set_value('comp_cost[]') ?>">
             </div>
            </div>
          </div>
        <?php } ?>
        <?php for($odd=1; $odd<$total_comps; $odd=$odd+2){ ?>
          <?php $cid++; ?>
          <div class="form-group col-md-6" >
          <div class="row">
             <div class='col-md-2' style="padding-top:3%;">
             <input type="checkbox" class="selection componentId" id="cid<?php echo $cid ?>"  onchange = "console.log(this.getAttribute('value'))" name="cmpastselection" id="cmpastischecked" value="<?php echo $comps[$odd]['id'] ?>">
             </div>
             <div class="col-md-7">
             <label for="cid<?php echo $cid ?>" class="col-form-label" data-original-title="" title=""><?php echo $comps[$odd]['name'];?></label>
             <input class="form-control" type="hidden" name='comp_id[]'   value="<?php echo set_value('comp_id[]',$comps[$odd]['id']) ?>">
             </div>
          </div>
          <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" >Serial#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compSerial" id="cserial<?php echo $csid++ ?>" data-comp-id="cid<?php echo $cid ?>" type="text" name='comp_serial[]' placeholder="Serial No" value="<?php echo set_value('comp_serial[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" >Model#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compModel" id="cmodel<?php echo $cmodelid++ ?>" data-comp-id="cid<?php echo $cid ?>" type="text" name='comp_model[]' placeholder="Model No" value="<?php echo set_value('comp_model[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" >Manufacturer</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compManufacturer" data-comp-id="cid<?php echo $cid ?>" id="cmfc<?php echo $cmfcid++ ?>" type="text" name='comp_manufacturer[]' placeholder="Manufacturer" value="<?php echo set_value('comp_manufacturer[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" >Mfg Date</label>
             </div>
             <div class="col-md-7">
             <input type="date" class="form-control compMfg " data-comp-id="cid<?php echo $cid ?>" id="cmfg<?php echo $cmfgid++ ?>" name="mfg_date[]" placeholder="Choose Manufacturing Date">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" >Wrnty Type</label>
             </div>
             <div class="col-md-7">
             <select class="form-control required compWarrantyType" data-comp-id="cid<?php echo $cid ?>" name="cmp_warranty_type[]" id="cwt<?php echo $cwtid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','0') ?>" >Have No Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','1') ?>" >Replacement Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','2') ?>" >Repairing Warranty</option>
                </select>
             </div>
            </div>
            <div class="row cmp_warranty_duration" >
             <div class="col-md-5">
             <label class="col-form-label">Duration</label>
             </div>
             <div class="col-md-7">
             <select class="form-control compWarrantyDuration" data-comp-id="cid<?php echo $cid ?>" name="cmp_warranty_duration[]" id="cwd<?php echo $cwdid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','3 Months') ?>" >3 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','6 Months') ?>" >6 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','9 Months') ?>" >9 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','12 Months') ?>" >1 Year</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','24 Months') ?>" >2 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','36 Months') ?>" >3 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','48 Months') ?>" >4 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','60 Months') ?>" >5 Years</option>
                </select>
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label">Cost</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compCost" data-comp-id="cid<?php echo $cid ?>" id="ccost<?php echo $ccostid++ ?>" type="text" name='comp_cost[]' placeholder="Cost" value="<?php echo set_value('comp_cost[]') ?>">
             </div>
            </div>
          </div>
        <?php } ?>
          </div><!-- div for individual componet checkbox END -->      
    <?php } ?>  
<?php  if($i == 0 && $quantity > 1){  ?>
  <div class="tab-pane fade active first show" id="1_div" role="tabpanel" aria-labelledby="<?php echo $tabid++ ?>-tab">
   
    <div class="form-group mt-2" >
                  <div class='row'>
                    <div class='col-md-4' >
                    <label class="col-form-label" data-original-title="" title="">Equipment Serial #</label>
                    </div>
                    <div class='col-md-6' >
                    <input class="form-control equipSerial" id="eserial<?php echo $esid++ ?>" type="text" name='equip_serial[]'  placeholder="Equipment Serial No" value="<?php //echo set_value('equip_serial[]') ?>">
                    </div>
                   </div>
              
          <div class='row '>
             <div class='col-md-4'>
             <label class="col-form-label" data-original-title="" title="">Total Components</label>
             </div>
             <div class="col-md-6">
              <span required="" class="form-control" readonly><?php echo $total_comps.","?></span>
             </div>
          </div>
          </div>

         <div class="row" > <!-- div for individual componet checkbox START -->
        <?php for($even=0; $even<$total_comps; $even=$even+2){ ?>
        <?php $cid++; ?>
          <div class="form-group col-md-6">
          <div class="row">
             <div class='col-md-2' style="padding-top:3%;">
             <input type="checkbox" id="cid<?php echo $cid ?>"  onchange = "console.log(this.getAttribute('value'))" name="cmpastselection" id="cmpastischecked" class="selection componentId" value="<?php echo $comps[$even]['id'] ?>">
             </div>
             <div class="col-md-7">
             <label for="cid<?php echo $cid ?>" class="col-form-label" data-original-title="" title=""><?php echo $comps[$even]['name'];?></label>
             </div>
          </div>
          <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Serial#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compSerial" type="text" name='comp_serial[]' id="cserial<?php echo $csid++ ?>" data-comp-id="cid<?php echo $cid ?>"  placeholder="Serial No" value="<?php echo set_value('comp_serial[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5 pb-1">
             <label class="col-form-label" data-original-title="" title="">Model#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compModel" id="cmodel<?php echo $cmodelid++ ?>" data-comp-id="cid<?php echo $cid ?>" type="text" name='comp_model[]' placeholder="Model No" value="<?php echo set_value('comp_model[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Manufacturer</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compManufacturer" id="cmfc<?php echo $cmfcid++ ?>" data-comp-id="cid<?php echo $cid ?>" type="text" name='comp_manufacturer[]'  placeholder="Manufacturer Name" value="<?php echo set_value('comp_manufacturer[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Mfg Date</label>
             </div>
             <div class="col-md-7">
             <input type="date" class="form-control compMfg" placeholder="Choose Date" id="cmfg<?php echo $cmfgid++ ?>" data-comp-id="cid<?php echo $cid ?>" name="mfg_date[]">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Wrnty Type</label>
             </div>
             <div class="col-md-7">
             <select class="form-control required compWarrantyType" name="cmp_warranty_type[]" id="cwt<?php echo $cwtid++ ?>" data-comp-id="cid<?php echo $cid ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','0') ?>" >Have No Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','1') ?>" >Replacement Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','2') ?>" >Repairing Warranty</option>
                </select>
             </div>
            </div>
            <div class="row cmp_warranty_duration" >
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Duration</label>
             </div>
             <div class="col-md-7">
             <select class="form-control compWarrantyDuration" name="cmp_warranty_duration[]" id="cwd<?php echo $cwdid++ ?>" data-comp-id="cid<?php echo $cid ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','3 Months') ?>" >3 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','6 Months') ?>" >6 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','9 Months') ?>" >9 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','12 Months') ?>" >1 Year</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','24 Months') ?>" >2 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','36 Months') ?>" >3 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','48 Months') ?>" >4 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','60 Months') ?>" >5 Years</option>
                </select>
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Cost</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compCost" id="ccost<?php echo $ccostid++ ?>" type="text" name='comp_cost[]' data-comp-id="cid<?php echo $cid ?>" placeholder="Cost" value="<?php echo set_value('comp_cost[]') ?>">
             </div>
            </div>
          </div>
        <?php } ?>
        <?php for($odd=1; $odd<$total_comps; $odd=$odd+2){ ?>
          <?php $cid++; ?>
          <div class="form-group col-md-6" >
          <div class="row">
             <div class='col-md-2' style="padding-top:3%;">
             <input type="checkbox" id="cid<?php echo $cid ?>" onchange = "console.log(this.getAttribute('value'))" name="cmpastselection" id="cmpastischecked" class="selection componentId" value="<?php echo $comps[$odd]['id'] ?>">
             </div>
             <div class="col-md-7">
             <label for="cid<?php echo $cid ?>" class="col-form-label" data-original-title="" title=""><?php echo $comps[$odd]['name'];?></label>
             </div>
          </div>
          <div class="row">
             <div class="col-md-5">
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Serial#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compSerial " type="text" name='comp_serial[]' data-comp-id="cid<?php echo $cid ?>" id="cserial<?php echo $csid++ ?>" placeholder="Serial No" value="<?php echo set_value('comp_serial[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Model#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compModel" type="text" data-comp-id="cid<?php echo $cid ?>" id="cmodel<?php echo $cmodelid++ ?>" name='comp_model[]' style="margin-left:-20;" placeholder="Model No" value="<?php echo set_value('comp_model[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Manufacturer</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compManufacturer" data-comp-id="cid<?php echo $cid ?>" id="cmfc<?php echo $cmfcid++ ?>" type="text" name='comp_manufacturer[]' placeholder="Manufacturer" value="<?php echo set_value('comp_manufacturer[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Mfg Date</label>
             </div>
             <div class="col-md-7">
             <input type="date" class="form-control compMfg" placeholder="Choose Date" data-comp-id="cid<?php echo $cid ?>" id="cmfg<?php echo $cmfgid++ ?>" name="mfg_date[]">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Wrnty Type</label>
             </div>
             <div class="col-md-7">
             <select class="form-control compWarrantyType" name="cmp_warranty_type[]" id="cwt<?php echo $cwtid++ ?>" data-comp-id="cid<?php echo $cid ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','0') ?>" >Have No Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','1') ?>" >Replacement Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','2') ?>" >Repairing Warranty</option>
                </select>
             </div>
            </div>
            <div class="row cmp_warranty_duration" >
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Duration</label>
             </div>
             <div class="col-md-7">
             <select class="form-control compWarrantyDuration" name="cmp_warranty_duration[]" data-comp-id="cid<?php echo $cid ?>" id="cwd<?php echo $cwdid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','3 Months') ?>" >3 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','6 Months') ?>" >6 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','9 Months') ?>" >9 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','12 Months') ?>" >1 Year</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','24 Months') ?>" >2 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','36 Months') ?>" >3 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','48 Months') ?>" >4 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','60 Months') ?>" >5 Years</option>
                </select>
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Cost</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compCost" type="text" data-comp-id="cid<?php echo $cid ?>" placeholder="Cost" id="ccost<?php echo $ccostid++ ?>" name='comp_cost[]' value="<?php echo set_value('comp_cost[]') ?>">
             </div>
            </div>
          </div>
        <?php } ?>
          </div><!-- div for individual componet checkbox END -->
          <br>
    <div class="input-group mb-3 group-end">
      <a class="btn btn-success btnNext btn-md">Next</a>
    </div>
    </div>
        <!--/. form element wrap -->
    <?php } ?>

  <?php 
  if($i>=1 && $i<$quantity-1){
  ?>
  <div class="tab-pane fade middle" id="<?php echo $i+1; ?>_div" role="tabpanel" aria-labelledby="<?php echo $tabid++ ?>-tab">
    <!-- <p>STEP <?php echo $i+1; ?>.</p> -->
    <div class="form-group mt-2" >
                  <div class='row'>
                    <div class='col-md-4' >
                    <label class="col-form-label" data-original-title="" title="">Equipment Serial #</label>
                    </div>
                    <div class='col-md-6' >
                    <input class="form-control equipSerial" id="eserial<?php echo $esid++; ?>" type="text" name='equip_serial[]' placeholder="Equipment Serial No" value="">
                    </div>
                   </div>
            
                  <div class='row'>
                  <div class='col-md-4'>
                  <label class="col-form-label" data-original-title="" title="">Total Components</label>
                  </div>
                  <div class="col-md-6">
                    <span  class="form-control" readonly><?php echo $total_comps.","?></span>
                    <input class="form-control" type="hidden" name='equip_id[]' value="<?php //echo set_value('equip_id[]',$equip_id) ?>" >
                  </div>
                </div>
          

          <div class="row" > <!-- div for individual componet checkbox START -->
        <?php for($even=0; $even<$total_comps; $even=$even+2){ ?>
          <?php $cid++; ?>
          <div class="form-group col-md-6">
          <div class="row">
             <div class='col-md-2' style="padding-top:3%;">
             <input type="checkbox" id="cid<?php echo $cid ?>"  onchange = "console.log(this.getAttribute('value'))" name="cmpastselection" id="cmpastischecked" class="selection componentId" value="<?php echo $comps[$even]['id'] ?>">
             </div>
             <div class="col-md-7">
             <label for="cid<?php echo $cid ?>" class="col-form-label" data-original-title="" title=""><?php echo $comps[$even]['name'];?></label>
             </div>
          </div>
          <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Serial#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compSerial" type="text" data-comp-id="cid<?php echo $cid ?>" id="cserial<?php echo $csid++ ?>" name='comp_serial[]' placeholder="Serial No" value="<?php echo set_value('comp_serial[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Model#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compModel" type="text" id="cmodel<?php echo $cmodelid++ ?>" data-comp-id="cid<?php echo $cid ?>" name='comp_model[]' placeholder="Model No" value="<?php echo set_value('comp_model[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Manufacturer</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compManufacturer" id="cmfc<?php echo $cmfcid++ ?>" data-comp-id="cid<?php echo $cid ?>" type="text" name='comp_manufacturer[]' placeholder="Manufacturer Name" value="<?php echo set_value('comp_manufacturer[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Mfg Date</label>
             </div>
             <div class="col-md-7">
             <input type="date" class="form-control required compMfg" placeholder="Choose Date" data-comp-id="cid<?php echo $cid ?>" id="cmfg<?php echo $cmfgid++ ?>" name="mfg_date[]">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Wrnty Type</label>
             </div>
             <div class="col-md-7">
             <select class="form-control required compWarrantyType" name="cmp_warranty_type[]" data-comp-id="cid<?php echo $cid ?>" id="cwt<?php echo $cwtid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','0') ?>" >Have No Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','1') ?>" >Replacement Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','2') ?>" >Repairing Warranty</option>
                </select>
             </div>
            </div>
            <div class="row cmp_warranty_duration" >
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Duration</label>
             </div>
             <div class="col-md-7">
             <select class="form-control compWarrantyDuration" name="cmp_warranty_duration[]" data-comp-id="cid<?php echo $cid ?>" id="cwd<?php echo $cwdid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','3 Months') ?>" >3 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','6 Months') ?>" >6 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','9 Months') ?>" >9 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','12 Months') ?>" >1 Year</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','24 Months') ?>" >2 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','36 Months') ?>" >3 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','48 Months') ?>" >4 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','60 Months') ?>" >5 Years</option>
                </select>
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Cost</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compCost" type="text" name='comp_cost[]' id="ccost<?php echo $ccostid++ ?>" data-comp-id="cid<?php echo $cid ?>" placeholder="Cost" value="<?php echo set_value('comp_cost[]') ?>">
             </div>
            </div>
          </div>
        <?php } ?>
        <?php for($odd=1; $odd<$total_comps; $odd=$odd+2){ ?>
          <?php $cid++; ?>
          <div class="form-group col-md-6" >
          <div class="row">
             <div class='col-md-2' style="padding-top:3%;">
             <input type="checkbox" id="cid<?php echo $cid ?>" onchange ="console.log(this.getAttribute('value'))" name="cmpastselection" id="cmpastischecked" class="selection componentId" value="<?php echo $comps[$odd]['id'] ?>">
             </div>
             <div class="col-md-7">
             <label for="cid<?php echo $cid ?>" class="col-form-label" data-original-title="" title=""><?php echo $comps[$odd]['name'];?></label>
             </div>
          </div>
          <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Serial#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compSerial" type="text" id="cserial<?php echo $csid++ ?>" name='comp_serial[]' data-comp-id="cid<?php echo $cid ?>" placeholder="Serial No" value="<?php echo set_value('comp_serial[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Model#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compModel" type="text" data-comp-id="cid<?php echo $cid ?>" id="cmodel<?php echo $cmodelid++ ?>" name='comp_model[]'  placeholder="Model No" value="<?php echo set_value('comp_model[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Manufacturer</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compManufacturer" type="text" data-comp-id="cid<?php echo $cid ?>" id="cmfc<?php echo $cmfcid++ ?>" name='comp_manufacturer[]' placeholder="Manufacturer Name" value="<?php echo set_value('comp_manufacturer[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Mfg Date</label>
             </div>
             <div class="col-md-7">
             <input type="date" class="form-control compMfg" placeholder="Choose Date" data-comp-id="cid<?php echo $cid ?>" id="cmfg<?php echo $cmfgid++ ?>" name="mfg_date[]">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label " data-original-title="" title="">Wrnty Type</label>
             </div>
             <div class="col-md-7">
             <select class="form-control required compWarrantyType" data-comp-id="cid<?php echo $cid ?>" name="cmp_warranty_type[]" id="cwt<?php echo $cwtid++ ?>" >
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','0') ?>" >Have No Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','1') ?>" >Replacement Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','2') ?>" >Repairing Warranty</option>
                </select>
             </div>
            </div>
            <div class="row cmp_warranty_duration" >
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Duration</label>
             </div>
             <div class="col-md-7">
             <select class="form-control compWarrantyDuration" data-comp-id="cid<?php echo $cid ?>" name="cmp_warranty_duration[]" id="cwd<?php echo $cwdid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','3 Months') ?>" >3 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','6 Months') ?>" >6 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','9 Months') ?>" >9 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','12 Months') ?>" >1 Year</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','24 Months') ?>" >2 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','36 Months') ?>" >3 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','48 Months') ?>" >4 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','60 Months') ?>" >5 Years</option>
                </select>
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Cost</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compCost" data-comp-id="cid<?php echo $cid ?>" type="text" name='comp_cost[]' id="ccost<?php echo $ccostid++ ?>" placeholder="Cost" value="<?php echo set_value('comp_cost[]') ?>">
             </div>
            </div>


          </div>
        <?php } ?>
    </div><!-- div for individual componet checkbox END -->
    

    <div class="input-group mb-3 group-end">
      <a class="btn btn-danger btnPrevious btn-md">Previous</a>
      <a class="btn btn-success btnNext btn-md">Next</a>
    </div>
  </div>
  </div>

  
    <!--/. form element wrap -->
    <?php }?>
    
  

  <?php if($i==$quantity-1 && $quantity > 1){ ?>
  <div class="tab-pane fade last" id="<?php echo $quantity; ?>_div" role="tabpanel" aria-labelledby="<?php echo $i+1 ?>-tab">
    <!-- <p><?php echo "STEP".$quantity; ?>.</p> -->
    <div class="form-group mt-2">
                  <div class='row'>
                    <div class='col-md-4' >
                    <label class="col-form-label" data-original-title="" title="">Equipment Serial#</label>
                    </div>
                    <div class='col-md-6' >
                    <input class="form-control equipSerial" type="text" id="eserial<?php echo $esid++ ?>" name='equip_serial[]'  placeholder="Equipment Serial No" value="">
                    </div>
                   </div>
              

          <div class='row'>
             <div class='col-md-4'>
             <label class="col-form-label" data-original-title="" title="">Total Components</label>
             </div>
             <div class="col-md-6">
              <span class="form-control" readonly><?php  echo $total_comps.","?></span>
             </div>
          </div>
          </div>

          <div class="row" > <!-- div for individual componet checkbox START -->
        <?php for($even=0; $even<$total_comps; $even=$even+2){ ?>
          <?php $cid++; ?>
          <div class="form-group col-md-6">
          <div class="row">
             <div class='col-md-2' style="padding-top:3%;">
             <input type="checkbox" id="cid<?php echo $cid ?>" onchange="console.log(this.getAttribute('value'))" name="cmpastselection" id="cmpastischecked" class="selection componentId" value="<?php echo $comps[$even]['id'] ?>">
             </div>
             <div class="col-md-7">
             <label for="cid<?php echo $cid ?>" class="col-form-label" data-original-title="" title=""><?php echo $comps[$even]['name'];?></label>
             </div>
          </div>
          <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Serial#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compSerial" type="text" name='comp_serial[]' data-comp-id="cid<?php echo $cid ?>" id="cserial<?php echo $csid++ ?>" placeholder="Serial No" value="<?php echo set_value('comp_serial[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Model#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compModel" type="text" name='comp_model[]' data-comp-id="cid<?php echo $cid ?>" id="cmodel<?php echo $cmodelid++ ?>" placeholder="Model No" value="<?php echo set_value('comp_model[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Manufacturer</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compManufacturer" data-comp-id="cid<?php echo $cid ?>" type="text" name='comp_manufacturer[]' id="cmfc<?php echo $cmfcid++ ?>" placeholder="Manufacturer Name" value="<?php echo set_value('comp_manufacturer[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label  class="col-form-label" data-original-title="" title="">Mfg Date</label>
             </div>
             <div class="col-md-7">
             <input type="date" class="form-control compMfg" placeholder="Choose Date" data-comp-id="cid<?php echo $cid ?>" id="cmfg<?php echo $cmfgid++ ?>" name="mfg_date[]" >
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label  class="col-form-label" data-original-title="" title="">Wrnty Type</label>
             </div>
             <div class="col-md-7">
             <select class="form-control required compWarrantyType" data-comp-id="cid<?php echo $cid ?>" name="cmp_warranty_type[]" id="cwt<?php echo $cwtid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','0') ?>" >Have No Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','1') ?>" >Replacement Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','2') ?>" >Repairing Warranty</option>
              </select>
             </div>
            </div>
            <div class="row cmp_warranty_duration" >
             <div class="col-md-5">
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Duration</label>
             </div>
             <div class="col-md-7">
             <select class="form-control compWarrantyDuration" data-comp-id="cid<?php echo $cid ?>" name="cmp_warranty_duration[]" id="cwd<?php echo $cwdid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','3 Months') ?>" >3 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','6 Months') ?>" >6 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','9 Months') ?>" >9 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','12 Months') ?>" >1 Year</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','24 Months') ?>" >2 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','36 Months') ?>" >3 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','48 Months') ?>" >4 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','60 Months') ?>" >5 Years</option>
                </select>
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Cost</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compCost" type="text" data-comp-id="cid<?php echo $cid ?>" name='comp_cost[]' id="ccost<?php echo $ccostid++ ?>" placeholder="Cost" value="<?php echo set_value('comp_cost[]') ?>">
             </div>
            </div>
          </div>
        <?php } ?>
        <?php for($odd=1; $odd<$total_comps; $odd=$odd+2){ ?>
          <?php $cid++; ?>
          <div class="form-group col-md-6" >
          <div class="row">
             <div class='col-md-2' style="padding-top:3%;">
             <input type="checkbox" id="cid<?php echo $cid ?>"  onchange = "console.log(this.getAttribute('value'))" name="cmpastselection" id="cmpastischecked" class="selection componentId" value="<?php echo $comps[$odd]['id'] ?>">
             </div>
             <div class="col-md-7">
             <label for="cid<?php echo $cid ?>" class="col-form-label" data-original-title="" title=""><?php echo $comps[$odd]['name'];?></label>
             </div>
          </div>
          <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Serial#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compSerial" type="text" name='comp_serial[]' data-comp-id="cid<?php echo $cid ?>" id="cserial<?php echo $csid++ ?>" placeholder="Serial No" value="<?php echo set_value('comp_serial[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Model#</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compModel" type="text" name='comp_model[]' data-comp-id="cid<?php echo $cid ?>" id="cmodel<?php echo $cmodelid++ ?>" placeholder="Model No" value="<?php echo set_value('comp_model[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Manufacturer</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compManufacturer" type="text" name='comp_manufacturer[]' data-comp-id="cid<?php echo $cid ?>" id="cmfc<?php echo $cmfcid++ ?>" placeholder="Manufacturer Name" value="<?php echo set_value('comp_manufacturer[]') ?>">
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Mfg Date</label>
             </div>
             <div class="col-md-7">
             <input type="date" class="form-control compMfg" placeholder="Choose Date" data-comp-id="cid<?php echo $cid ?>" name="mfg_date[]" id="cmfg<?php echo $cmfgid++ ?>" >
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Wrnty Type</label>
             </div>
             <div class="col-md-7">
             <select class="form-control required compWarrantyType" data-comp-id="cid<?php echo $cid ?>" name="cmp_warranty_type[]" id="cwt<?php echo $cwtid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','0') ?>" >Have No Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','1') ?>" >Replacement Warranty</option>
                <option value="<?php echo set_value('cmp_warranty_type[]','2') ?>" >Repairing Warranty</option>
                </select>
             </div>
            </div>
            <div class="row cmp_warranty_duration" >
             <div class="col-md-5">
             <label for="example-text-input" class="col-form-label" data-original-title="" title="">Duration</label>
             </div>
             <div class="col-md-7">
             <select class="form-control compWarrantyDuration" name="cmp_warranty_duration[]" data-comp-id="cid<?php echo $cid ?>" id="cwd<?php echo $cwdid++ ?>">
                <option value="">Choose</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','3 Months') ?>" >3 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','6 Months') ?>" >6 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','9 Months') ?>" >9 Months</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','12 Months') ?>" >1 Year</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','24 Months') ?>" >2 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','36 Months') ?>" >3 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','48 Months') ?>" >4 Years</option>
                <option value="<?php echo set_value('cmp_warranty_duration[]','60 Months') ?>" >5 Years</option>
                </select>
             </div>
            </div>
            <div class="row">
             <div class="col-md-5">
             <label class="col-form-label" data-original-title="" title="">Cost</label>
             </div>
             <div class="col-md-7">
             <input class="form-control compCost" type="text" name='comp_cost[]' data-comp-id="cid<?php echo $cid ?>" id="ccost<?php echo $ccostid++ ?>" placeholder="Cost" value="<?php echo set_value('comp_cost[]') ?>">
             </div>
            </div>
          </div>
        <?php } ?>
          </div><!-- div for individual componet checkbox END -->
    <div class="input-group mb-3 group-end">
      <a class="btn btn-danger btnPrevious btn-md">Previous</a>
    </div>
        <!--/. form element wrap -->
  <?php } ?>

    <?php
      }
     ?>
</div>
<button type="button" class="btn btn-primary pull-right" onclick="asset_component_form_submit()">Submit</button>

</form>

<script>
  $(document).ready(function() {
  $('.btnNext').click(function() {
    $('.uts .active').parent().next('li').find('a').trigger('click');
  });
  
  $('.btnPrevious').click(function() {
    $('.uts .active').parent().prev('li').find('a').trigger('click');
  });
});
</script>