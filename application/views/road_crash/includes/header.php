<!DOCTYPE html>
<html lang="en">

<head>
<title>Road Crash Data Collection App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/rc_assets/css/bootstrap.min (1).css" />

    <link rel="stylesheet" href="<?php echo base_url()?>assets/multiple_steps_form/multiple_steps.css" />

    <link rel="icon" type="image/png" href="<?php echo base_url()?>assets/rc_assets/responsive_assets/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/rc_assets/responsive_assets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/rc_assets/responsive_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/rc_assets/responsive_assets/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/rc_assets/responsive_assets/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/rc_assets/responsive_assets/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/rc_assets/responsive_assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/rc_assets/responsive_assets/css/main.css">
<!--===============================================================================================-->


    <script src="<?php echo base_url()?>assets/rc_assets/front/member/js/core/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/rc_assets/back/js/vendor/modernizr-2.8.3.min.js"></script>
    <link href="<?php echo base_url()?>assets/rc_assets/back/bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/rc_assets/back/chosen/chosen.min.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/rc_assets/back/chosen/chosen.jquery.min.js"></script>
    <style type="text/css">
        #results { padding:20px; border:1px solid; background:#ccc; }
    </style>

  
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
 
</head>

<body >
 