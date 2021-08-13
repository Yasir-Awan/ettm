</div>
<?php for($i = 0; $i < 10; $i++){ $j = $i + 1; ?>
<div class="col-md-6 pr-1">
    <div class="form-group">
        <label>Class<?php echo $j ?></label>
        <input type="number" name="class<?php echo $j ?>" id="class<?php echo $j ?>" class="form-control classes required" placeholder="Enter class<?php echo $j ?> passages" min="0">
    </div>
</div>
<?php } ?>
<div class="col-md-6 pr-1">
    <div class="form-group">
        <label>Total</label>
        <input type="number" class="form-control" id="total" disabled="" placeholder="Total" value="">
    </div>
</div>


                  