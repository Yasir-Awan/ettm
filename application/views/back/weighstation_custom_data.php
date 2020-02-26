  <?php include('includes/header.php'); ?>
            <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- data table start -->
                    
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="header-title">Get Weighstation Custom Data</h4>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-2">
                                    </div>
                                      <div class="col-md-8">
                                         <?php echo form_open(base_url()."admin/search_weighstation_custom_data/",array('id' => 'search_weighstation'));?>
                                        <div class="form-group">
                                          <label for="exampleInputEmail1" style="font-weight: 900;">Toll Plaza Name</label>
                                          <select class="form-control required" name="weighstation" id="weighstation">
                                                <option value="">Choose Weighstation</option>
                                                <?php foreach($weighstations as $row){?>
                                                <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
                                                <?php } ?>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label for="exampleInputEmail1" style="font-weight: 900;">Choose Date</label>
                                              <input type="text" id="day" name="day" class="form-control" placeholder="Choose Date" >
                                                
                                        </div>
                                        <span class="btn btn-primary pull-right btn-sm enterer" id="disable_on_submit" onclick="form_submit('search_weighstation');">Search</span>
                                      
                                        <?php echo form_close();?>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dark table end -->
                </div>
            </div>
        </div>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var user_type = 'admin';
    var module = 'weighstation_daily_report';
    var list_cont_func = 'list';
    var dlt_cont_func = 'delete';
    $(document).ready(function(){
         $("#day").datepicker({
                    format: "dd/mm/yyyy/",
                    autoclose: true
                    
                 })
    });
    
</script>


        <!-- footer area start-->
   <?php include('includes/footer.php')?>      