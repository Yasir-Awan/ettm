<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
 <!--  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png"> -->
  <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/front/img/nhalogo.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    ETTM TOLL PLAZA SUPERVISOR DASHBOARD
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->

  <link href="<?php echo base_url()?>assets/front/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" />
  <link href="<?php echo base_url()?>assets/front/member/css/fonts.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="<?php echo base_url()?>assets/front/member/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url()?>assets/front/member/css/now-ui-dashboard.css?v=1.2.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url()?>assets/front/member/demo/demo.css" rel="stylesheet" />
<style>

.dataTables_filter{

  float: right;
}
.dataTables_paginate {

  float: right;
}
</style>

<style>

.datepicker-dropdown {
  top: 0;
  left: 0;
  padding: 4px;
  background-color:#8F5036;  
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
    background-color:#B77F0E;
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
  background: #3A2218;
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
<script src="<?php echo base_url()?>assets/front/member/js/core/jquery.min.js"></script>
 
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="#" class="simple-text logo-mini" style="width:auto;">
          <?php echo $toolplaza[0]['name']?>
        </a>

        <a href="#" class="simple-text logo-normal">
          TOLL PLAZA 
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li <?php if($page_name == 'dashboard'){?>class="active"<?php } ?>>
            <a href="<?php echo base_url()?>toolplaza">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <!-- <li <?php if($page_name == 'faulty'){?>class="active"<?php } ?>>
            <a href="<?php echo base_url()?>toolplaza/faulty_equipment_list">
              <i class="now-ui-icons education_atom"></i>
              <p>Faulty Equipment List</p>
            </a>
          </li> -->
          <li <?php if($page_name == 'mtr'){?>class="active"<?php } ?>>
            <a href="<?php echo base_url()?>toolplaza/mtr">
              <i class="now-ui-icons education_atom"></i>
              <p>Monthly Traffic Report</p>
            </a>
          </li>
          <li <?php if($page_name == 'inventory'){?>class="active"<?php } ?>>
            <a href="<?php echo base_url()?>supervisor_inventory/first_page">
              <i class="now-ui-icons design_app"></i>
              <p>Inventory(items)</p>
            </a>
          </li>
          <!-- <li>
            <a href="./icons.html">
              <i class="now-ui-icons education_atom"></i>
              <p>Icons</p>
            </a>
          </li>
          <li>
            <a href="./map.html">
              <i class="now-ui-icons location_map-big"></i>
              <p>Maps</p>
            </a>
          </li>
          <li>
            <a href="./notifications.html">
              <i class="now-ui-icons ui-1_bell-53"></i>
              <p>Notifications</p>
            </a>
          </li>
          <li>
            <a href="./user.html">
              <i class="now-ui-icons users_single-02"></i>
              <p>User Profile</p>
            </a>
          </li>
          <li>
            <a href="./tables.html">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Table List</p>
            </a>
          </li>
          <li>
            <a href="./typography.html">
              <i class="now-ui-icons text_caps-small"></i>
              <p>Typography</p>
            </a>
          </li>
          <li class="active-pro">
            <a href="./upgrade.html">
              <i class="now-ui-icons arrows-1_cloud-download-93"></i>
              <p>Upgrade to PRO</p>
            </a>
          </li> -->
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg fixed-top navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
           <?php if($page_name == "dashboard"){?>
            <form>
              <div class="input-group no-border">
                <input type="text" id="formonth" name="formonth" class="form-control" placeholder="Select month">
                
              </div>
            </form>
            <?php } ?>
            <ul class="navbar-nav ">
             
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <?php echo $this->session->userdata('supervisor_name');?>
                </a>
              </li>
             

               <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="now-ui-icons users_single-02"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="<?php echo base_url()?>toolplaza/settings"><i class="fa fa-wrench"></i>Settings</a>
                  <a class="dropdown-item" href="<?php echo base_url()?>toolplaza/logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
                  
                  
                </div>
              </li>
              <li class="nav-item dropdown">
             <a class="nav-link dropdown-toggle" href="http://example.com" id="notify_msg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <!-- <?php $userId = $this->session->userdata('supervisor_id'); ?> -->
             <!-- <?php $disapprovedMtrs = $this->db->get_where('notifications',array('user_id' => $userId))->result_array(); 
                  if(!empty($disapprovedMtrs))
                  {
                    $notifyCounter = 0;
                    foreach($disapprovedMtrs as $row)
                    {
                      
                      $notifyCounter++;
                    }
                  }?> -->
             <span class="badge badge-danger badge-counter" id="notify_counter" style=" font-size:122%;">
             <!-- <?php if(!empty($disapprovedMtrs))
                    { 
                      if($notifyCounter>=13)
                      {
                       echo "12+"; 
                      }
                      else
                      {
                        echo $notifyCounter ;
                      }
                    } ?> -->
              </span>
                  <i class="fa fa-bell"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Account</span>
                  </p>
                </a>
                
                <div class="dropdown-menu dropdown-menu-right " id="show_notify_msg" aria-labelledby="navbarDropdownNotifyLink">
                <?php $userId = $this->session->userdata('supervisor_id'); ?>
             <?php $disapprovedMtrs = $this->db->get_where('notifications',array('user_id' => $userId))->result_array(); 
                  if(!empty($disapprovedMtrs))
                  {
                    $notifyCounter = 0;
                    foreach($disapprovedMtrs as $row)
                    {
                      $mtrid = $row['ref_id'];
                      $notifyCounter++;
                      if($notifyCounter>=13)
                      break;
                    ?>
                 
           <a class="dropdown-item page-link" href="<?php echo base_url()?>toolplaza/mtr" >
               
                          <?php
                  // if($row['mtr_type']==1)
                  // {
                  // echo 'Your  '. date("F, Y",strtotime($row['mtr_month'])) .' mtr disapproved.';
                  // }
                  // elseif($row['mtr_type']== 2)
                  // {
                  //    echo 'Your '.date("F, Y",strtotime($row['mtr_month'])).'Custom mtr disapproved.';
                  // }           
                  ?>
                 
                       
                  <?php  }
                  }
               ?>
               </a>
              
                </div>
                              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->