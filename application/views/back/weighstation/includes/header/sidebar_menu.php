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
                            <?php
                            if($this->session->userdata('weighsupr_id'))
                            {	
                            ?>
                            <li <?php if($page == 'weighstation daily report'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>weighstations/weighstation_dashboard" ><i style="color:#fff;" class="ti-dashboard"></i> &nbsp; Dashboard</a></li>
<!--                             
                            <li <?php if($page == 'Weighstation' || $page == 'weighstation custom data'|| $page == 'Weighstation Category' || $page == 'Weightlimit' || $page == 'weighstation daily report'){echo "class='active'";}?>>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-balance-scale"></i><span>Weighstation</span></a>
                                <ul class="collapse" <?php if($page == 'Weighstation' || $page == 'weighstation custom data' || $page == 'Weighstation Category' || $page == 'Weightlimit' || $page == 'weighstation daily report'){echo "-in";}?>>
                                <li <?php if($page == 'weighstation daily report'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>weighstations/weighstation_dashboard" ><i style="color:#fff;" class="ti-dashboard"></i> &nbsp; Dashboard</a></li>
                                    <li <?php if($page == 'Weightlimit'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/weighlimit" ><i style="color:#fff;" class="fa fa-ban"></i> &nbsp;Weigh Limit</a></li>
                                    <li <?php if($page == 'Weighstation Category'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/weighstation_categories" > <i style="color:#fff;" class="fa fa-list"></i> &nbsp;Categories</a></li>
                                    <li <?php if($page == 'weighstation daily report'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/weighstation_report" ><i style="color:#fff;" class="fa fa-file"></i> &nbsp; Report</a></li>
                                    <li <?php if($page == 'weighstation custom data'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/weighstation_custom_data" ><i style="color:#fff;" class="fa fa-file"></i> &nbsp;Custom Data</a></li>
                                </ul>
                            </li> -->
                            <?php } ?> 
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->

