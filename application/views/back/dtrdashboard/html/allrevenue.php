        <div class="tab-pane fade" id="all-revenue">
            <div class=" tabbable">
                <ul class=" row nav nav-tabs day">
                    <li class="heading btn-primary btn-primary col-md-3 p-day"><a class="active" id="allrevenuepday" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)" href="#all-revenue-p-day">Previous Day</a>
                    </li>
                    <li class="heading btn-primary col-md-3 btn-primary today"><a id="allrevenuetoday" date="DATE(for_date) = CURDATE()" href="#all-revenue-today">Today</a>
                    </li>
                    <li class="heading btn-primary col-md-3 btn-primary p-week"><a id="allrevenuepweek" date="for_date BETWEEN CURDATE()-INTERVAL 1 WEEK AND CURDATE()" href="#all-revenue-p-week">Previous Week</a>
                    </li>
                    <li class="heading btn-primary col-md-3 btn-primary p-month"><a id="allrevenuepmonth" date="for_date BETWEEN CURDATE()-INTERVAL 1 MONTH AND CURDATE()" href="#all-revenue-p-month">Previous Month</a>
                    </li>
                </ul>
                <div class="row tab-content">
                    <div class="graph-div col-md-12 tab-pane fade active in show" id="all-revenue-p-day">
                        <div class="row">
                        	<?php if($dtr){ ?>								
								<div class="col-md-12">
									<div class="p-4">Total Revenue <?php echo $tollplazatoday['dtr']['revenue']['total']; ?></div>
									<div id="allchartrevenuetoday"></div>
								</div>
                       		<?php }
							else{ ?>
								<div class="col-md-12">
									<div class="p-4"><?php echo $message ?></div>
								</div>
							<?php } ?>
                        </div>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-revenue-today">
                    	<p>All Revenue Today</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-revenue-p-week">
                        <p>All Revenue Previous Week</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-revenue-p-month">
                        <p>All Revenue Previous Month</p>
                    </div>
                </div>
            </div>
        </div>