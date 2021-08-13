<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>ETTM Weighstations Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>assets/back/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/typography.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/back/css/responsive.css">
    <!-- modernizr css -->
    <script src="<?php echo base_url();?>assets/back/js/vendor/modernizr-2.8.3.min.js"></script>
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
    <!-- login area start -->
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <?php echo form_open(base_url().'weighstations/do_login',array('id' => 'weigh_login'));?>
                    <div class="login-form-head">
                        <h4>Weighstation Sign In</h4>
                        <p>Welcome To Weighstations. &nbsp;Please Login to continue.....</p>
                    </div>
                    <div class="login-form-body">
                           <label for="exampleInputEmail1">Username</label>
                        <div class="form-gp">
                            <input type="text" id="exampleInputEmail1" name="username" class="form-control required">
                            <i class="ti-user" style="bottom:8px;"></i>
                        </div>
                           <label for="exampleInputPassword1">Password</label>
                        <div class="form-gp">
                            <input type="password" class="form-control required" id="exampleInputPassword1" name="password">
                            <i class="ti-lock" style="bottom:8px;"></i>
                        </div>
                        <div class="row mb-4 rmber-area">
                          <!--   <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                    <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                </div>
                            </div> -->
                            <!-- <div class="col-6 text-right">
                                <a href="#">Forgot Password?</a>
                            </div> -->
                        </div>
                        <div class="submit-btn-area">
                            <span id="form_submit" class="btn btn-primary btn-lg" onclick="form_submit('weigh_login');">Submit <i class="ti-arrow-right"></i></span>
                           <!--  <div class="login-other row mt-4">
                                <div class="col-6">
                                    <a class="fb-login" href="#">Log in with <i class="fa fa-facebook"></i></a>
                                </div>
                                <div class="col-6">
                                    <a class="google-login" href="#">Log in with <i class="fa fa-google"></i></a>
                                </div>
                            </div> -->
                        </div>
                     </div>
                <?php echo form_close();?>

            </div>
        </div>
    </div>
    <!-- login area end -->

    <!-- jquery latest version -->
    <script src="<?php echo base_url();?>assets/back/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/vendor/bootstrap-notify.min.js"></script>
    <!-- bootstrap 4 js -->
    <!--<script src="<?php echo base_url();?>assets/back/js/popper.min.js"></script>-->
    <script src="<?php echo base_url();?>assets/ajax_method.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/bootstrap.min.js"></script>
    <!--<script src="<?php echo base_url();?>assets/back/js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/jquery.slicknav.min.js"></script>-->
    
    <!-- others plugins -->
    <script src="<?php echo base_url();?>assets/back/js/plugins.js"></script>
    <script src="<?php echo base_url();?>assets/back/js/scripts.js"></script>
    <script>
        $(document).on('keypress',function(e) {
            if(e.which == 13) {
                form_submit('weigh_login');
            }
        });
    </script>
</body>

</html>