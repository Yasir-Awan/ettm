<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/front/img/nhalogo.png">
    <title>ETTM Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/slicknav.min.css">
    <link href="<?php echo base_url()?>assets/back/summernote/summernote.min.css" rel="stylesheet" type="text/css">

     <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/responsive.jqueryui.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/typography.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/responsive.css">
   
    <!-- modernizr css -->
    <script src="<?php echo base_url()?>assets/front/member/js/core/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/vendor/modernizr-2.8.3.min.js"></script>
    <link href="<?php echo base_url()?>assets/back/bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/back/chosen/chosen.min.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/back/chosen/chosen.jquery.min.js"></script>

  <link href="<?php echo base_url()?>assets/front/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" />
   <!-- Custom fonts for admin logout button template-->
  <link href="<?php echo base_url();?>assets/admin_logout_vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places,drawing&key=<?php echo $key;?>"></script>


  <!-- Custom styles for admin logout and password button template-->
  
   
  <style>
  .panel-header {
  height: 260px;
  padding-top: 20px;
  padding-bottom: 10px;
  background-color: #f8f9fc;
  position: relative;
  overflow: hidden; }
  .panel-header .header .title {
    color: #FFFFFF; }
  .panel-header .header .category {
    max-width: 600px;
    color: rgba(255, 255, 255, 0.5);
    margin: 0 auto;
    font-size: 13px; }
    .panel-header .header .category a {
      color: #FFFFFF; }
.panel-header-sm {
  height: 135px; }

.panel-header-lg {
  height: 380px; }
select.form-control:not([size]):not([multiple]) {
    height: calc(2.25rem + 5px) !important;
}
  
.dataTables_filter{
  float: right;
}
.dataTables_paginate {
  float: right;
}
.datepicker-dropdown {
  top: 0;
  left: 0;
  padding: 4px;
  background-color:#4e73df;  
  border-radius: 10px;
}
.datepicker table {
  margin: 0;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.datepicker table tr td,
.datepicker table tr th {
  text-align: center;
  width: 30px;
  height: 30px;
  border-radius: 4px;
  border: none;
  color: #000000;
}

.datepicker table tr td {
    border:dotted 1px #3A2218;
    background-color:#f8f9fa;;
    background-image: linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,0));
}

.datepicker table tr th {
    color: #fff;
    line-height:35px;    
}

.datepicker table tr td.day:hover,
.datepicker table tr td.focused {  
  background: #DCDCDC;
  cursor: pointer;
}
.datepicker table tr td.old,
.datepicker table tr td.new {
  color: #8F5036;
}

.datepicker table tr td.today {
  color: #FFFFFF;
  background-color: #3A2218;
  border-color: #FFB76F;
}
.datepicker table tr td.today:hover {
  color: #FFFFFF;
  background-color: #884400;
  border-color: #f59e00;
}
.datepicker table tr td.active:active,
.datepicker table tr td.active.highlighted:active,
.datepicker table tr td.active.active,
.datepicker table tr td.active.highlighted.active,
.open > .dropdown-toggle.datepicker table tr td.active,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted {
  color: #ffffff;
  background-color: #F27900;
  border-color: #285e8e;
}


.datepicker table tr td.active:active:hover,
.datepicker table tr td.active.highlighted:active:hover,
.datepicker table tr td.active.active:hover,
.datepicker table tr td.active.highlighted.active:hover,
.open > .dropdown-toggle.datepicker table tr td.active:hover,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted:hover,
.datepicker table tr td.active:active:focus,
.datepicker table tr td.active.highlighted:active:focus,
.datepicker table tr td.active.active:focus,
.datepicker table tr td.active.highlighted.active:focus,
.open > .dropdown-toggle.datepicker table tr td.active:focus,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted:focus,
.datepicker table tr td.active:active.focus,
.datepicker table tr td.active.highlighted:active.focus,
.datepicker table tr td.active.active.focus,
.datepicker table tr td.active.highlighted.active.focus,
.open > .dropdown-toggle.datepicker table tr td.active.focus,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted.focus {
  color: #ffffff;
  background-color: #285e8e;
  border-color: #193c5a;
}
.datepicker table tr td.active:active,
.datepicker table tr td.active.highlighted:active,
.datepicker table tr td.active.active,
.datepicker table tr td.active.highlighted.active,
.open > .dropdown-toggle.datepicker table tr td.active,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted {
  color: #ffffff;
  background-color: #FF8033;
  border-color: #285e8e;
}
.datepicker table tr td.active:active:hover,
.datepicker table tr td.active.highlighted:active:hover,
.datepicker table tr td.active.active:hover,
.datepicker table tr td.active.highlighted.active:hover,
.open > .dropdown-toggle.datepicker table tr td.active:hover,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted:hover,
.datepicker table tr td.active:active:focus,
.datepicker table tr td.active.highlighted:active:focus,
.datepicker table tr td.active.active:focus,
.datepicker table tr td.active.highlighted.active:focus,
.open > .dropdown-toggle.datepicker table tr td.active:focus,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted:focus,
.datepicker table tr td.active:active.focus,
.datepicker table tr td.active.highlighted:active.focus,
.datepicker table tr td.active.active.focus,
.datepicker table tr td.active.highlighted.active.focus,
.open > .dropdown-toggle.datepicker table tr td.active.focus,
.open > .dropdown-toggle.datepicker table tr td.active.highlighted.focus {
  color: #ffffff;
  background-color: #285e8e;
  border-color: #193c5a;
}
.datepicker .datepicker-switch {
  font-family:Optima;
  text-transform:uppercase;
  font-size:16px;
  width: 145px;
  color: #EAAA01;
}
.datepicker .datepicker-switch:hover,
.datepicker .prev:hover,
.datepicker .next:hover,
.datepicker tfoot tr th:hover {
  background: #3A2218;
  color: #EAAA01;
}
</style>

</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
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
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span>Dashboard</span></a>
                                <!-- <ul class="collapse">
                                    <li class="active"><a href="index.html">ICO dashboard</a></li>
                                    <li><a href="index2.html">Ecommerce dashboard</a></li>
                                    <li><a href="index3.html">SEO dashboard</a></li>
                                </ul> -->
                            </li>
                            <li>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span>Graphs</span></a>
                                <ul class="collapse">
                                <li <?php if($page == 'Daily Traffic Chart')echo "class='active'";?>>
										<a style="color:#fff" href="<?php echo base_url();?>admin/dtr_chart" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span>Daily Chart</span></a>
									</li>
                  <li <?php if($page == 'M Traffic Chart')echo "class='active'";?>>
										<a style="color:#fff" href="<?php echo base_url();?>admin/dtr_chart_tool" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span>Daily Chart All</span></a>
									</li>
                                    <li <?php if($page == 'Desired Chart')echo "class='active'";?>>
										<a style="color:#fff" href="<?php echo base_url();?>admin/getdesiredchart" aria-expanded="true" ><i style="color:#fff;" class="ti-dashboard"></i><span>Three Months Graph</span></a>
									</li>
                                </ul>
                            </li>
                            <li>
                             	<a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-building"></i><span>Reports</span></a>
                             	<ul class="collapse">
									<li <?php if($page == 'MTR')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>admin/mtr"><i style="color:#fff;" class="fa fa-building"></i> <span>Monthly Traffic Report</span></a></li>
									<li <?php if($page == 'dtr')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>admin/dtr"><i style="color:#fff;" class="fa fa-building"></i> <span>Daily Traffic Report</span></a></li>
									<li <?php if($page == 'dsr')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>admin/dsr"><i style="color:#fff;" class="fa fa-building"></i> <span>Daily Site Report</span></a></li>
								 </ul>                            	
                            </li>
                            
                            <li>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-map-marker"></i><span>Advanced</span></a>
                                <ul class="collapse">
                                	
									<li>
										<a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-group"></i><span>HeadQuarter</span></a>
										<ul class="collapse">
											<li <?php if($page == 'Member')echo "class='active'";?>>
											<a style="color:#fff;" href="<?php echo base_url()?>admin/member"><i style="color:#fff;" class="fa fa-group"></i> <span>Members</span></a></li>
											<li <?php if($page == 'admin')echo "class='active'";?>>
											<a style="color:#fff;" href="<?php echo base_url()?>admin/admins"><i style="color:#fff;" class="fa fa-group"></i> <span>Admins</span></a></li> 
										</ul>
									</li>
                                	<li>
                                		<a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-group"></i><span>Toll Plaza</span></a>
										<ul class="collapse">
											<li  <?php if($page == 'Tollplaza')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>admin/tollplaza"><i style="color:#fff;" class="fa fa-map-marker"></i> <span>List</span></a></li>
											<li <?php if($page == 'Toll Plaza Staff')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>admin/tpstaff"><i style="color:#fff;" class="fa fa-group"></i> <span>Staff</span></a></li>
											<li <?php if($page == 'Toll Plaza Supervisor')echo "class='active'";?>>
											<a style="color:#fff;" href="<?php echo base_url()?>admin/toolplaza_supervisor"><i style="color:#fff;" class="fa fa-group"></i> <span>Supervisor</span></a></li> 
										</ul>
                                	</li>
									
									
									<li <?php if($page == 'OMC')echo "class='active'";?>>
									<a style="color:#fff;" href="<?php echo base_url()?>admin/omc"><i style="color:#fff;" class="fa fa-group"></i> <span>OMC</span></a></li>
									 <li <?php if($page == 'Tarrif')echo "class='active'";?>>
									<a style="color:#fff;" href="<?php echo base_url()?>admin/tarrif"><i style="color:#fff;" class="fa fa-usd"></i> <span>Tarrif</span></a></li>    
                                </ul>
                            </li> 
							<li <?php if($page == 'inventory')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>inventory/first_page"><i style="color:#fff;" class="fas fa-clipboard"></i> <span>Inventory</span></a></li>
                                                        
                            
                            <!-- <li <?php if($page == 'Weighstation')echo "class='active'";?>>
                            <a style="color:#fff;" href="<?php echo base_url()?>admin/weighstation"><i style="color:#fff;" class="fa fa-balance-scale"></i> <span>Weighstation</span></a>
                            </li>
                            <li <?php if($page == 'Weighstation')echo "class='active'";?>>
                            <a style="color:#fff;" href="<?php echo base_url()?>admin/weighlimit"><i style="color:#fff;" class="fa fa-balance-scale"></i> <span>Add Weight Limit</span></a></li> 
                            <li>
                            <li <?php if($page == 'Weighstation')echo "class='active'";?>>
                            <a style="color:#fff;" href="<?php echo base_url()?>admin/weighstation_daily_report"><i style="color:#fff;" class="fa fa-balance-scale"></i> <span>Weightstation Daily Report</span></a></li> 
                            <li>  -->
                            <li>
                            <!-- <li <?php if($page == 'inventory')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>inventory/first_page"><i style="color:#fff;" class="fas fa-clipboard"></i> <span>ITEMS (inventory)</span></a></li>    
                             -->
                            
                            <!--  <li <?php if($page == 'Locations')echo "class='active'";?>>
                            <a href="<?php echo base_url()?>admin/location"><i class="fa fa-building"></i> <span>Locations</span></a></li> -->                          
                            <li <?php if($page == 'Google Locations' || $page == 'Google Roads'){echo "class='active'";}?>>
                                <a style="color:#fff;" href="<?php echo base_url();?>admin" aria-expanded="true" ><i style="color:#fff;" class="fa fa-map-marker"></i><span>Google Map</span></a>
                                <ul class="collapse" <?php if($page == 'Google Locations' || $page == 'Google Roads'){echo "-in";}?>>
                                    <li <?php if($page == 'Google Locations'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/googlelocations">Google Locations</a></li>
                                    <li <?php if($page == 'Google Roads'){echo "class='active'";}?> style="line-height:10px;"><a href="<?php echo base_url()?>admin/googleroads" >Google Roads</a></li>
                                </ul>
                            </li>
                            <li <?php if($page == 'site settings')echo "class='active'";?>><a style="color:#fff;" href="<?php echo base_url()?>admin/site_settings"><i style="color:#fff;" class="fas fa-wrench"></i> <span>Site Settings</span></a></li> 
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
           
                        <div class="page-title-area" style='line-height=0%' >
                        <div class="nav-btn pull-left" style='margin-top:14px;'>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                <div class="row align-items-center" >
                    <div class="col-sm-8">
                        <div class="breadcrumbs-area clearfix"style='margin-top:12px;'>
                            <h4 class="page-title pull-left">Dashboard </h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="<?php echo base_url().'admin';?>">Home</a></li>
                                <li><a href="<?php echo $page_url;?>"><?php echo $page;?></a></li>
                            </ul>
                        </div>
                    </div>
                    
                    
                    <div class="col-sm-4 clearfix ">
                    
                       <div class="topbar-divider d-none d-sm-block"></div>
              <ul>
            <!-- Nav Item - User Information -->
           
           
             <!-- admin button area START --> 
            <li class="nav-item dropdown no-arrow pull-right">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" style='padding-right: unset; padding-left: unset;'  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> Admin</span>
                <img class="img-profile rounded-circle" style='width:20px; height:20px;' src="<?php echo base_url();?>assets/back/images/author/AdminLogo.png">
    
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="<?php echo base_url()?>admin/settings">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo base_url()?>admin/logout" >
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
                
               
              </div>
            </li><!-- admin button area END -->
           
           
           
           
           
           <!-- Notificatoins area START -->
           <li class="nav-item dropdown no-arrow mx-1 pull-right">
              <a class="nav-link dropdown-toggle" href="#" id="notify_msg" style='padding-right: 15px; padding-left: unset;' id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter" id="notify_counter">
               
                </span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                
                <div class="small text-gray-500 " id="show_notify_msg">
                
                                        
                <a class="dropdown-item d-flex align-items-center ml-8" href="<?php echo base_url()?>admin/mtr" style="margin-left: 50px !important;">
 <?php
        //           if($row['mtr_type']==1)
        //           {
        //                $plazaName = $this->db->get_where("toolplaza",array('id'=>$row['tollplaza']))->result_array();
        //                  foreach($plazaName as $plaza)
        //                  {
        //                echo  date("F, Y",strtotime($row['mtr_month'])) .' mtr of '.$plaza['name'].' updated.';
        //                  }
        //           }
        //           elseif($row['mtr_type']== 2)
        //           {
        //             $plazaName = $this->db->get_where("toolplaza",array('id'=>$row['tollplaza']))->result_array();
        //             foreach($plazaName as $plaza)
        //             {
        //           echo  date("F, Y",strtotime($row['mtr_month'])) .' custom mtr of '.$plaza['name'].' updated.';
        //             }
        //           }                
        //      }
        //  } 
               ?>                   
                  </div>
                </a>

<!--               
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a> -->
                <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
              </div> 
            </li>
            <!-- Notificatoins area END -->
                            <!-- Messages area START -->
                            <li class="nav-item dropdown no-arrow mx-1 pull-right">
              <a class="nav-link dropdown-toggle" href="#" style='padding-right: unset; padding-left: unset;' id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li> <!-- Messages area END -->
         

          </ul>
                </div>


                </div>
            </div> 