<style>

nav > .nav.nav-tabs{

  border: none;
    color:#fff;
    background:#272e38;
    border-radius:0;

}
nav > div a.nav-item.nav-link,
nav > div a.nav-item.nav-link.active
{
  border: none;
    padding: 18px 25px;
    color:#fff;
    background:#1a385c;
    border-radius:0;
}

nav > div a.nav-item.nav-link.active:after
 {
  content: "";
  position: relative;
  bottom: -60px;
  left: -10%;
  border: 15px solid transparent;
  border-top-color: #f96332 ;
}
.tab-content{
  background: #fdfdfd;
    line-height: 25px;
    border: 1px solid #ddd;
    border-top:5px solid #f96332;
    border-bottom:5px solid #f96332;
    padding:30px 25px;
}

nav > div a.nav-item.nav-link:hover,
nav > div a.nav-item.nav-link:focus
{
  border: none;
    background: #f96332;
    color:#fff;
    border-radius:0;
    transition:background 0.20s linear;
}    
      
</style>
 <?php include('includes/header.php');?>
<div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Site Setting</h4>
                
              </div>
              <div class="card-body">
                     
               <div class="container">
              <div class="row">
                <div class="col-xs-12 col-md-12">
                  <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Google Map Api</a>
                      <!-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Change Password</a> -->
                    </div>
                  </nav>
                  <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <?php 

                        $api = $this->db->get_where('settings',array('type' => 'google_map_api_key'))->result_array();  ?>
                        <?php echo form_open_multipart(base_url().'admin/site_settings/update_map_key', array('id' => 'update_key', 'method' => 'post'));?>
                           <div class="row">
                              <div class="col-md-1"></div>
                                <div class="col-md-8 pr-">
                                  <div class="form-group">
                                    <label>Api Key</label>
                                    <input type="text" name="apikey" class="form-control required" placeholder="Enter Api Key" value="<?php echo $api[0]['value'];?>">
                                  </div>
                                </div>
                                
                                <div class="col-md-3"></div>
                                <div class="col-md-12">
                                    <span class="btn btn success pull-right" onclick="form_submit('update_key');" style="margin-right:2%; color: white; background-color:#1a385c;">Update</span>
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div>
                    <!-- <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?php echo form_open_multipart(base_url().'admin/settings/update_pwd', array('id' => 'update_pwd', 'method' => 'post'));?>
                           <div class="row">
                              <div class="col-md-1"></div>
                                <div class="col-md-8 pr-">
                                  <div class="form-group">
                                    <label>Old Password</label>
                                    <input type="password" name="oldpwd" class="form-control required" placeholder="Enter Old Password">
                                  </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8 pr-">
                                  <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="newpwd" class="form-control required" placeholder="Enter New Password">
                                  </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-1"></div>
                                <div class="col-md-8 pr-">
                                  <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="repwd" class="form-control required" placeholder="Retype New Password">
                                  </div>
                                </div>
                                <div class="col-md-3"></div>
                                
                                <div class="col-md-12">
                                    <span class="btn btn success pull-right" onclick="form_submit('update_pwd');" style="margin-right:2%; color: white; background-color:#1a385c;">Update</span>
                                </div>
                            </div>
                        <?php echo form_close();?>
                    </div> -->
                   
                  </div>
                
                </div>
              </div>
        </div>
      </div>
</div>

            </div>
              
          </div>
          
        </div>
      </div>
      
<?php include('includes/footer.php');?>

