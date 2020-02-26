<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>ETTM</title>
<!--
Newline Template
http://www.templatemo.com/tm-503-newline
-->
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/front/img/nhalogo.png">

        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/fontAwesome.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/templatemo-style.css">

        <link href="<?php echo base_url()?>assets/front/member/css/fonts.css" rel="stylesheet" />

        <script src="<?php echo base_url();?>assets/front/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

        <style>
        .badge {
    
          background-color: #f10707;
   
        }
        </style>
    </head>
    <body>

        <div class="overlay"></div>
        <section class="top-part">
          <video controls autoplay loop>
            <source src="<?php echo base_url();?>assets/front/videos/final_5bd9811e8ebfc9001361b200.mp4" type="video/mp4">
            <source src="<?php echo base_url();?>assets/front/videos/final_5bd9811e8ebfc9001361b200.ogg" type="video/ogg">
          Your browser does not support the video tag.
          </video>
        </section>
        
        <section class="cd-hero">

          <div class="cd-slider-nav">
            <nav>
              <span class="cd-marker item-1"></span>
              <ul>
                <li class="selected"><a href="#0"><div class="image-icon"><img src="<?php echo base_url();?>assets/front/img/home-icon.png"></div><h6>Welcome</h6></a></li>
                <li><a href="#0"><div class="image-icon" style="    margin-left: 15%;"><img src="<?php echo base_url();?>assets/front/img/about-icon.png" ></div><h6>Member Login</h6></a></li>
                <li><a href="#0"><div class="image-icon" style="    margin-left: 20%;"><img src="<?php echo base_url();?>assets/front/img/about-icon.png" ></div><h6>Toll Plaza Login</h6></a></li>
                <!-- <li><a href="#0"><div class="image-icon"><img src="<?php echo base_url();?>assets/front/img/projects-icon.png"></div><h6>Projects</h6></a></li>
                <li><a href="#0"><div class="image-icon"><img src="<?php echo base_url();?>assets/front/img/contact-icon.png"></div><h6>Contact Us</h6></a></li> -->
              </ul>
            </nav> 
          </div> <!-- .cd-slider-nav -->

          <ul class="cd-hero-slider">

            <li class="selected">
              <div class="heading">
                <h1>ETTM</h1>
                <span>Welcome To NHA ETTM</span>
              </div>
              <div class="cd-full-width first-slide">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="content first-content">
                        <h4>Let’s Talk More About ETTM</h4>
                        <p>ETTM (Electronic Traffic Toll Management) system is used for traffic classifications category wise installed at Toll Plazas. Following are the category wise traffic alongwith toll amount:-
</p>
                        <div class="primary-button">
                          <a href="#">Discover More</a>
                        </div>
                      </div>
                    </div>
                  </div>                  
                </div>
              </div>
            </li>

            <li>
              <div class="heading">
                <h1>Member Login</h1>
                <span>Please Login To Continue</span> 
              </div>
              <div class="cd-half-width second-slide">   
                  <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="content second-content">
                        <div class="row">
                    <div class="col-sm-offset-3 col-sm-6">
                      <div class="tile">
                        <div class="login show">
                        <img src="<?php echo base_url();?>assets/front/img/logo-2.png" class="logo">
                         <?php echo form_open(base_url().'home/member_login',array('id' => 'member_login_form'));?>
                            <div class="form-group">
                              <input type="text" class="form-control required" placeholder="Username" name="username">
                            </div><!-- group -->
                            <div class="form-group">
                              <input type="password" class="form-control required" placeholder="Password" name="password" >
                            </div><!-- group -->
                            <div>
                            </div>
                            <span  class="btn btn-info btn-block" onclick="form_submit('member_login_form');">Login</span>
                           
                          <?php echo form_close();?>
                        </div><!-- login -->
                        
                    </div><!-- col-6 -->
                  </div><!-- row -->
                      </div>
                    </div>
                  </div>                  
                </div>
                 

              </div>
            </li>

            <li>
              <div class="heading">
                <h1>Toll Plaza Supervisor Login</h1>
                <span>Please Login To Continue</span> 
              </div>
              <div class="cd-half-width third-slide">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="content third-content">
                          <div class="row">
                    <div class="col-sm-offset-3 col-sm-6">
                      <div class="tile">
                        <div class="login show">
                        <img src="<?php echo base_url();?>assets/front/img/logo-2.png" class="logo">
                          <?php echo form_open(base_url().'home/toolplaza_login',array('id' => 'tpsupervisor_login'));?>
                            <div class="form-group">
                              <input type="text" class="form-control required" placeholder="Username" name="username">
                            </div><!-- group -->
                            <div class="form-group">
                              <input type="password" class="form-control required" placeholder="Password" name="password">
                            </div><!-- group -->
                            <span class="btn btn-warning btn-block" onclick="form_submit('tpsupervisor_login');">Login</span>
                           
                          <?php echo form_close();?>
                        </div><!-- login -->
                        
                    </div><!-- col-6 -->
                  </div><!-- row -->
                      </div>
                    </div>
                  </div>                  
                </div>
              </div>
            </li>

            <!-- <li>
              <div class="heading">
                <h1>Our projects</h1>
                <span>Here you can check our recent projects</span> 
              </div>
              <div class="cd-half-width fourth-slide">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="content fourth-content">
                        <div class="row">
                          <div class="col-md-3 project-item">
                            <a href="<?php echo base_url();?>assets/front/img/item-01.jpg" data-lightbox="image-1"><img src="<?php echo base_url();?>assets/front/img/project-item-01.jpg"></a>
                          </div>
                          <div class="col-md-3 project-item">
                            <a href="<?php echo base_url();?>assets/front/img/item-02.jpg" data-lightbox="image-1"><img src="<?php echo base_url();?>assets/front/img/project-item-02.jpg"></a>
                          </div>
                          <div class="col-md-3 project-item">
                            <a href="<?php echo base_url();?>assets/front/img/item-03.jpg" data-lightbox="image-1"><img src="<?php echo base_url();?>assets/front/img/project-item-03.jpg"></a>
                          </div>
                          <div class="col-md-3 project-item">
                            <a href="<?php echo base_url();?>assets/front/img/item-04.jpg" data-lightbox="image-1"><img src="<?php echo base_url();?>assets/front/img/project-item-04.jpg"></a>
                          </div>
                          <div class="col-md-3 project-item">
                            <a href="img/item-05.jpg" data-lightbox="image-1"><img src="<?php echo base_url();?>assets/front/img/project-item-05.jpg"></a>
                          </div>
                          <div class="col-md-3 project-item">
                            <a href="img/item-06.jpg" data-lightbox="image-1"><img src="<?php echo base_url();?>assets/front/img/project-item-06.jpg"></a>
                          </div>
                          <div class="col-md-3 project-item">
                            <a href="<?php echo base_url();?>assets/front/img/item-07.jpg" data-lightbox="image-1"><img src="<?php echo base_url();?>assets/front/img/project-item-07.jpg"></a>
                          </div>
                          <div class="col-md-3 project-item">
                            <a href="<?php echo base_url();?>assets/front/img/item-08.jpg" data-lightbox="image-1"><img src="<?php echo base_url();?>assets/front/img/project-item-08.jpg"></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>                  
                </div>
              </div>
            </li>

            <li>
              <div class="heading">
                <h1>Contact us</h1>
                <span>You'll be responded within 48 hrs</span> 
              </div>
              <div class="cd-half-width fivth-slide">
                <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="content fivth-content">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="left-info">
                              <p>Maecenas imperdiet sagittis lacus, ut consequat velit iaculis id. Praesent eu consequat urna. Morbi justo dolor, ornare sed lorem et, auctor iaculis ligula.
                              <br><br>
                              <em>3344 Donec mollis libero<br>at metus luctus 10110</em>
                              </p>
                              <ul class="social-icons">
                                <i><a href="#"><i class="fa fa-facebook"></i></a></i>
                                <i><a href="#"><i class="fa fa-twitter"></i></a></i>
                                <i><a href="#"><i class="fa fa-linkedin"></i></a></i>
                                <i><a href="#"><i class="fa fa-rss"></i></a></i>
                                <i><a href="#"><i class="fa fa-behance"></i></a></i>
                              </ul>
                            </div>
                          </div>
                          <div class="col-md-8">
                            <div class="row">
                              <form id="contact" action="" method="post">
                                <div class="col-md-6">
                                  <fieldset>
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Your Name" required="">
                                  </fieldset>
                                </div>
                                <div class="col-md-6">
                                  <fieldset>
                                    <input name="email" type="email" class="form-control" id="email" placeholder="Email" required="">
                                  </fieldset>
                                </div>
                                <div class="col-md-12">
                                  <fieldset>
                                    <textarea name="message" rows="6" class="form-control" id="message" placeholder="Message" required=""></textarea>
                                  </fieldset>
                                </div>
                                <div class="col-md-12">
                                  <fieldset>
                                    <button type="submit" id="form-submit" class="btn">Send Message</button>
                                  </fieldset>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>                  
                </div>
              </div>
            </li> -->
          </ul> <!-- .cd-hero-slider -->
        </section> <!-- .cd-hero -->


        <footer>
          <p>Copyright &copy; 2019 ETTM 
                                
        	| Designed by <a href="#" target="_parent"><em>ETTM Web Developers Team</em></a></p>
        </footer>
    
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url();?>assets/front/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="<?php echo base_url();?>assets/front/js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/front/js/plugins.js"></script>
        <script src="<?php echo base_url();?>assets/front/js/main.js"></script>
 <script src="<?php echo base_url();?>assets/back/js/vendor/bootstrap-notify.min.js"></script>
    
<script src="<?php echo base_url();?>assets/ajax_method.js"></script>
    </body>
</html>