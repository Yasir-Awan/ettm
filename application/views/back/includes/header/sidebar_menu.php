<!-- sidebar menu area start -->
        <div class="sidebar-menu" >
			<div class="sidebar-header" style="background:none; border-bottom: none;">
                <div style='height:35px;' >
                    <a href="#"><img  src="<?php echo base_url();?>assets/back/images/icon/logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                <nav>
                        <ul class="metismenu" id="menu">
                        <hr class="sidebar-divider" style="    border-top: 1px solid rgba(255,255,255,.15);" >
                            <li <?php if($page == 'Dashboard')echo "class='active'";?>>
                            <?php if($this->session->userdata('omcid')) { ?>
                                <a style="color:#fff;" href="<?php echo base_url();?>omc" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span>Dashboard</span></a>
                            <?php  } if($this->session->userdata('adminid')) {	 ?>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span>Dashboard</span></a>
                            <?php  } ?>
                                
                            </li>
                            <li <?php if($page == 'DTR Dashboard')echo "class='active'";?>>
                            <?php if($this->session->userdata('omcid')) {	 ?>
                        <!-- <a style="color:#fff;" href="<?php echo base_url();?>omc/dashboard_dtr" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span> DTR Overall</span></a> -->
                            <?php   }  if($this->session->userdata('adminid')) { ?>
                        <a style="color:#fff;" href="<?php echo base_url();?>admin/dashboard_dtr" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span> DTR Overall</span></a>
                            <?php  } ?>
                                
                            </li>
                            <li <?php if($page == 'Dashboard ST')echo "class='active'";?>>
                            <?php if($this->session->userdata('omcid')) {	 ?>
                            <a style="color:#fff;" href="<?php echo base_url();?>omc/dashboard" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span> Dashboard ST</span></a>
                            <?php   }  if($this->session->userdata('adminid')) { ?>
                              <a style="color:#fff;" href="<?php echo base_url();?>admin/dashboard" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span> Dashboard ST</span></a>
                             <?php } ?>
							</li>
                            <?php if($this->session->userdata('adminid')) {	 ?>
                            <li>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span>Graphs</span></a>
                                <ul class="collapse <?php if(isset($page)) if( $page == 'Desired Chart' || $page == 'M Traffic Chart' || $page == 'Monthly DTR Chart' || $page == 'Five Years Chart'){echo 'in';}?>">
									<li <?php if(isset($page)) if($page == 'Monthly DTR Chart')echo "class='active'";?>>
										<a href="<?php echo base_url();?>admin/dtr_chart"><i style="color:#fff;" class="ti-dashboard"></i><span>Daily Chart</span></a>
									</li>
									<li <?php if(isset($page)) if($page == 'M Traffic Chart')echo "class='active'";?>>
										<a href="<?php echo base_url();?>admin/dtr_chart_tool"><i style="color:#fff;" class="ti-dashboard"></i><span>Daily Chart All</span></a>
									</li>
									<li <?php if(isset($page)) if($page == 'Five Years Chart')echo "class='active'";?>>
										<a href="<?php echo base_url();?>admin/get5yearchart"><i style="color:#fff;" class="ti-dashboard"></i><span>MTR 5 Year Charts</span></a>
									</li>
									<li <?php if(isset($page)) if($page == 'Desired Chart')echo "class='active'";?>>
										<a href="<?php echo base_url();?>admin/getdesiredchart"><i style="color:#fff;" class="ti-dashboard"></i><span>Three Months Graph</span></a>
									</li>
								</ul>
                            </li>
                            
                            
                            <li>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-building"></i><span>Tollplaza</span></a>
                                <ul class="collapse <?php if($page == 'Tollplaza' || $page == 'MTR' || $page == 'dtr' || $page == 'dsr' || $page == 'Toll Plaza Supervisor' || $page == 'Toll Plaza Staff' || $page == 'OMC' || $page == 'Tarrif'){echo "in";}?>">
                                   <li  <?php if($page == 'Tollplaza')echo "class='active'";?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/tollplaza"><i style="color:#fff;" class="fa fa-building"></i> <span>All Tollplaza</span></a></li>
                                   <li <?php if($page == 'MTR')echo "class='active'";?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/mtr"><i style="color:#fff;" class="fa fa-file"></i> <span>Monthly Traffic Report</span></a></li>
                                   <li <?php if($page == 'dtr')echo "class='active'";?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/dtr"><i style="color:#fff;" class="fa fa-file"></i> <span>Daily Traffic Report</span></a></li>
                                   <li <?php if($page == 'dsr')echo "class='active'";?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/dsr"><i style="color:#fff;" class="fa fa-file"></i> <span>Daily Site Report</span></a></li>
                                   <li <?php if($page == 'Toll Plaza Supervisor')echo "class='active'";?>style="line-height:10px;"><a href="<?php echo base_url()?>admin/toolplaza_supervisor"><i style="color:#fff;" class="fa fa-group"></i> <span>Supervisor</span></a></li> 
                                   <li <?php if($page == 'Toll Plaza Staff')echo "class='active'";?>style="line-height:10px;"><a href="<?php echo base_url()?>admin/tpstaff"><i style="color:#fff;" class="fa fa-group"></i> <span>Staff</span></a></li>
                                   <li <?php if($page == 'OMC')echo "class='active'";?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/omc"><i style="color:#fff;" class="fa fa-group"></i> <span>OMC</span></a></li>
                                   <li <?php if($page == 'Tarrif')echo "class='active'";?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/tarrif"><i style="color:#fff;" class="fa fa-usd"></i> <span>Tarrif</span></a></li>    
                                </ul>
                            </li> 
                            <li>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-group"></i><span>HeadQuarter</span></a>
                                  <ul class="collapse <?php if($page == 'admin' || $page == 'Member'){echo 'in';}?>">
                                    <li <?php if($page == 'Member')echo "class='active'";?>>
                                    <a href="<?php echo base_url()?>admin/member"><i style="color:#fff;" class="fa fa-group"></i> <span>Members</span></a></li>
                                    <li <?php if($page == 'admin')echo "class='active'";?>>
                                    <a href="<?php echo base_url()?>admin/admins"><i style="color:#fff;" class="fa fa-group"></i> <span>Admins</span></a></li> 
                                  </ul>
                            </li>
                            
                            <li <?php if($page == 'Weighstation' || $page == 'weighstation custom data'|| $page == 'Weighstation Category' || $page == 'Weightlimit' || $page == 'weighstation daily report'){echo "class='active'";}?>>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-balance-scale"></i><span>Weighstation</span></a>
                                <ul class="collapse" <?php if($page == 'Weighstation' || $page == 'weighstation custom data' || $page == 'Weighstation Category' || $page == 'Weightlimit' || $page == 'weighstation daily report'){echo "-in";}?>>
                                    <li <?php if($page == 'Weighstation'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/weighstation"> <i style="color:#fff;" class="fa fa-balance-scale"></i> &nbsp;All Weighstations</a></li>
                                    <li <?php if($page == 'Weightlimit'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/weighlimit" ><i style="color:#fff;" class="fa fa-ban"></i> &nbsp;Weigh Limit</a></li>
                                    <li <?php if($page == 'Weighstation Category'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/weighstation_categories" > <i style="color:#fff;" class="fa fa-list"></i> &nbsp;Categories</a></li>
                                    <li <?php if($page == 'weighstation daily report'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/weighstation_report" ><i style="color:#fff;" class="fa fa-file"></i> &nbsp; Report</a></li>
                                    <li <?php if($page == 'weighstation custom data'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/weighstation_custom_data" ><i style="color:#fff;" class="fa fa-file"></i> &nbsp;Custom Data</a></li>
                                
                                </ul>
                            </li>
                            <li>
     
                            <li <?php if($page == 'Google Locations' || $page == 'map' || $page == 'Google Roads'){echo "class='active'";}?>>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-map-marker"></i><span>Google Map</span></a>
                                <ul class="collapse" <?php if($page == 'map' || $page == 'Google Locations' || $page == 'Google Roads'){echo "-in";}?>>
                                    <li <?php if($page == 'Google Locations'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/googlelocations"> <i style="color:#fff;" class="fas fa-map-marker"></i> &nbsp;Google Locations</a></li>
                                    <li <?php if($page == 'Google Roads'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/googleroads" ><i style="color:#fff;" class="fas fa-road"></i>&nbsp; Google Roads</a></li>
                                    <li <?php if($page == 'map'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/map" > <i style="color:#fff;" class="fas fa-map"></i>&nbsp;Map</a></li>
                                
                                </ul>
                            </li>
                            <li <?php if($page == 'Tollplaza_lanes' || $page == 'Tollplaza_live' || $page == 'Tollplaza report'){echo "class='active'";}?>>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-building"></i><span>Tollplaza Live</span></a>
                                <ul class="collapse" <?php if($page == 'Tollplaza_lanes' || $page == 'Tollplaza_live' || $page == 'Tollplaza report'){echo "-in";}?>>
                                    <li <?php if($page == 'Tollplaza_live'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/tollplaza_live"> <i style="color:#fff;" class="fas fa-building"></i> &nbsp;Toll Plaza LIve</a></li>
                                    <li <?php if($page == 'Tollplaza_lanes'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/tollplaza_lanes" ><i style="color:#fff;" class="fas fa-road"></i>&nbsp; TollPlaza Lanes</a></li>
                                    <li <?php if($page == 'Tollplaza report'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/toll_plaza_report" > <i style="color:#fff;" class="fas fa-file"></i>&nbsp;Report</a></li>
                                
                                </ul>
                            </li>
                            <li>
                                <a style="color:#fff;" href="http://roadcrashpk.com" target="_blank" aria-expanded="true" ><i style="color:#fff;" class="fas fa-road"></i><span>Road Crash Data</span></a>
                                  <!-- <ul class="collapse <?php if($page == 'crash_data'){echo 'in';}?>">
                                    <li <?php // if($page == 'crash_list')echo "class='active'";?> >
                                    <a onclick="getCrashList()" style="color:#fff;" href="#"><img  src="<?php echo base_url();?>assets/back/images/icon/accident.png" alt="bus"><span>Crash List</span></a>
                                    </li>
                                    <li <?php // if($page == 'driver_list')echo "class='active'";?>> -->
                                    <!-- <a href="<?php echo base_url()?>admin/admins"><img  src="<?php echo base_url();?>assets/back/images/icon/driver.png" alt="driver"  style="width:35px; height:32px;" > <span>Driver List</span></a> -->
                                    <!-- </li> 
                                    <li <?php //if($page == 'images_list')echo "class='active'"?> style="padding-left:3%"; > -->
                                    <!-- <a href="<?php echo base_url()?>admin/admins"><i style="color:#fff;" class="fas fa-image"></i> <span>Images List</span></a> -->
                                    <!-- </li> 
                                  </ul> -->
                            </li>
                            <li <?php if($page == 'inventory')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>inventory/first_page"><i style="color:#fff;" class="fas fa-boxes"></i> <span>Inventory</span></a></li>
                            <!-- <li <?php if($page == 'crash_data')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>admin_crash"><i style="color:#fff;" class="fas fa-road"></i> <span>Road Crash Data</span></a></li> -->
                             <li>
								<a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span>Traffic Counting</span></a>
                                <ul class="collapse <?php if(isset($page)) if( $page == 'traffic_counting' || $page == 'Sensors Traffic Counting'){echo 'in';}?>">
									<li <?php if(isset($page)) if($page == 'Sensors Traffic Counting')echo "class='active'";?>><a href="<?php echo base_url()?>admin/tcd"><i style="color:#fff;" class="fas fa-file"></i> <span>Sensors Traffic Counting</span></a></li>
									<li <?php if(isset($page)) if($page == 'traffic_counting')echo "class='active'";?>><a href="<?php echo base_url()?>admin/traffic_counting"><i style="color:#fff;" class="fas fa-file"></i> <span>Manual Traffic Counting</span></a></li>
								 </ul>
							</li>                   
                            <li <?php if($page == 'site settings')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>admin/site_settings"><i style="color:#fff;" class="fas fa-wrench"></i> <span>Site Settings</span></a></li>
                            <?php } ?> 
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->

