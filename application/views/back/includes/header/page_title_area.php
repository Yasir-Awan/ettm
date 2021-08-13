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
                                <li><a href="<?php if(isset($page_url)) echo $page_url;?>"><?php  if(isset($page)) echo $page;?></a></li>
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
									<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php if($this->session->userdata('omcid')){echo "OMC";} if($this->session->userdata('adminid')){echo $this->session->userdata('fname')." ".$this->session->userdata('lname');} ?></span>
									<img class="img-profile rounded-circle" style='width:20px; height:20px;' src="<?php echo base_url();?>assets/back/images/author/AdminLogo.png">
								</a>
								<!-- Dropdown - User Information -->
								<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
									<a class="dropdown-item" href="#">
										<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profile
									</a>
									<a class="dropdown-item" href="<?php echo base_url()?>admin/settings">
										<i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>Settings
									</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="<?php echo base_url()?>admin/logout" >
										<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout
									</a>
								</div>
							</li><!-- admin button area END -->
							<!-- Notifications area START -->
							<li class="nav-item dropdown no-arrow mx-1 pull-right">
								<a class="nav-link dropdown-toggle" href="#" id="notify_msg" style='padding-right: 15px; padding-left: unset;' id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="far fa-bell fa-fw"></i>
									<!-- Counter - Alerts -->
									<span class="badge badge-danger badge-counter" id="notify_counter"></span>
								</a>
								<!-- Dropdown - Alerts -->
								<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
									<div class="small text-gray-500 " id="show_notify_msg">
										<a class="dropdown-item d-flex align-items-center ml-8" href="<?php echo base_url()?>admin/mtr" style="margin-left: 50px !important;">
											<?php	
												/*if($row['mtr_type']==1){	$plazaName = $this->db->get_where("toolplaza",array('id'=>$row['tollplaza']))->result_array();
													foreach($plazaName as $plaza){
														echo  date("F, Y",strtotime($row['mtr_month'])) .' mtr of '.$plaza['name'].' updated.';
													}
												}
									   			elseif($row['mtr_type']== 2){	$plazaName = $this->db->get_where("toolplaza",array('id'=>$row['tollplaza']))->result_array();
													foreach($plazaName as $plaza){
														echo  date("F, Y",strtotime($row['mtr_month'])) .' custom mtr of '.$plaza['name'].' updated.';
													}
												} */
											?> 
										</a>
									</div>
									<!--<a class="dropdown-item d-flex align-items-center" href="#">
										<div class="mr-3">
											<div class="icon-circle bg-warning">
												<i class="fas fa-exclamation-triangle text-white"></i>
											</div>
										</div>
										<div>
											<div class="small text-gray-500">December 2, 2019</div>
											Spending Alert: We've noticed unusually high spending for your account.
										</div>
									</a>-->
									<!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
								</div> 
							</li>
							<!-- Notifications area END -->
                            <!-- Messages area START -->
                            <li class="nav-item dropdown no-arrow mx-1 pull-right">
								<!-- <a class="nav-link dropdown-toggle" href="#" style='padding-right: unset; padding-left: unset;' id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="far fa-envelope fa-fw"></i> -->
									<!-- Counter - Messages -->
									<!-- <span class="badge badge-danger badge-counter">7</span> -->
								<!-- </a> -->
								<!-- Dropdown - Messages -->
								<!-- <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
									<h6 class="dropdown-header">Message Center</h6>
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
								</div> -->
							</li> 
							<!-- Messages area END -->
						</ul>
					</div>
				</div>
			</div> 