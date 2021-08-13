<div class="row">
        <div class="col-md-6 pr-1">
            <div class="form-group">
                <label>Toll Plaza</label>
                <input type="text" class="form-control" disabled="" placeholder="Tollplaza" value="<?php echo $toolplaza; ?>">
            </div>
        </div>
        <div class="col-md-6 pr-1">
            <div class="form-group">
                <label>OMC</label>
                <Select class="form-control required" name="omc" id="omc">
                    <option value="">Choose OMC</option>
                    <?php foreach($omc as $val){?>
                        <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                    <?php } ?>
                </select> 
            </div>
        </div>
        <div class="col-md-6 pr-1">
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control required" id="" name="for_date" placeholder="Choose Date"> 
            </div>
        </div>
        <div class="col-md-6 pr-1 start_date" style="display:none;"></div>
        <div class="col-md-6 pr-1 end_date" style="display:none;"><div>
    </div>
</div>
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