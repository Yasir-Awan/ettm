<?php include('includes/header.php'); ?>
<?php include('dtrdashboard/css/dashboard.php'); ?>

<div class="tabbable boxed parentTabs p-1">
   <!--<?php include('dtrdashboard/html/firstheading.php');?>-->
<ul class="row nav nav-tabs">
        <li class="heading btn-primary col-md"><a id="head-all" date="" class="active" href="#all">All TollPlazas</a>
        </li>
        <!--<li class="heading btn-primary col-md"><a id="head-toll" date="" href="#tollselect">Tollplaza</a></li>-->
    </ul>
	<div class="tab-content">
   		<?php //include('dtrdashboard/html/alltollplazas.php'); ?>
   		<div class="tab-pane fade in active show" id="all">
            <div class="tabbable">
			<ul class="row nav nav-tabs">
				<li class="heading btn-primary col-md"><a id="allsummary" class="active show" href="#all-summary">Summary</a>
				</li>
				<li class="heading btn-primary col-md"><a id="alltraffic" href="#all-traffic">Traffic</a>
				</li>
				<li  class="heading btn-primary col-md"><a id="allrevenue" href="#all-revenue">Revenue</a>
				</li>
				<!--<li  class="heading btn-primary col-md-3"><a id="allexempt" href="#all-exempt">Exemptions</a>
				</li>-->
			</ul>
      
    <div class="tab-content">
        <div class="tab-pane fade active in show" id="all-summary">
            <div class="tabbable">
                <ul class=" row nav nav-tabs day">
                    <li class="heading btn-primary col-md-3 pday"><a id="allsummarypday" class="active show" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)" href="#all-summary-pday">Previous Day</a>
                    </li>
                    <li class="heading col-md-3 btn-primary today"><a id="allsummarytoday" href="#all-summary-today" date="DATE(for_date) = CURDATE()">Today</a>
                    </li>
                    <li class="heading col-md-3 btn-primary pweek"><a id="allsummarypweek" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 WEEK)" href="#all-summary-pweek">Previous Week</a>
                    </li>
                    <li class="heading col-md-3 btn-primary pmonth"><a id="allsummarypmonth" date="MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH)" href="#all-summary-pmonth">Previous Month</a>
                    </li>
                </ul>
                <div class="row tab-content">
                    <div class="graph-div col-md-12 tab-pane fade active in show" id="all-summary-pday">
                        <?php if($dtr){ 
									if($section == 'summary'){ ?>
                        
                        <div class="row">
							<div class="col-md">
								<div class="p-4">Total Traffic <?php echo $tollplazatoday['dtr']['traffic']['total']; ?></div>
								<div id="allcharttraffic1<?php echo $duration ?>"></div>
							</div>
							<div class="col-md">
								<div class="p-4">Total Revenue <?php echo $tollplazatoday['dtr']['revenue']['total']; ?></div>
								<div id="allchartrevenue1<?php echo $duration ?>"></div>
							</div>
						</div>
								<?php } 	
						}else{ ?>
							<div class="p-4"><?php echo $message; ?></div>
						<?php } ?>						
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-summary-today">
                        <p>allplaza Summary Today</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-summary-pweek">
                        <p>allplaza Summary Previous Week</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-summary-pmonth">
                        <p>allplaza Summary Previous Month</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="all-traffic">
            <div class="tabbable">
                <ul class=" row nav nav-tabs day">
                    <li class="heading btn-primary col-md-3 pday"><a date="DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)" class="active" id="alltrafficpday" href="#all-traffic-pday">Previous Day</a>
                    </li>
                    <li class="heading col-md-3 btn-primary today"><a id="alltraffictoday" href="#all-traffic-today" date="DATE(for_date) = CURDATE()">Today</a>
                    </li>
                    <li class="heading col-md-3 btn-primary pweek"><a id="alltrafficpweek" href="#all-traffic-pweek" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 WEEK)" href="#all-summary-pweek">Previous Week</a>
                    </li>
                    <li class="heading col-md-3 btn-primary pmonth"><a id="alltrafficpmonth" date="MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH)" href="#all-traffic-pmonth">Previous Month</a>
                    </li>
                </ul>
                <div class="row tab-content">
                    <div class="graph-div col-md-12 tab-pane fade active show" id="all-traffic-pday">
                       <div id="allcharttrafficpday"></div>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-traffic-today">
                        <p>allplaza Traffic Today</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-traffic-pweek">
                        <p>allplaza Traffic Previous Week</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-traffic-pmonth">
                        <p>allplaza Traffic Previous Month</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="all-revenue">
            <div class="tabbable">
                <ul class=" row nav nav-tabs day">
                    <li class="heading btn-primary show col-md-3 pday"><a id="allrevenuepday" class="active" href="#all-revenue-pday" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)">Previous Day</a>
                    </li>
                    <li class="heading btn-primary col-md-3 today"><a id="allrevenuetoday" href="#all-revenue-today" date="DATE(for_date) = CURDATE()">Today</a>
                    </li>
                    <li class="heading btn-primary col-md-3 pweek"><a id="allrevenuepweek" href="#all-revenue-pweek" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 WEEK)" href="#all-summary-pweek">Previous Week</a>
                    </li>
                    <li class="heading btn-primary col-md-3 pmonth"><a id="allrevenuepmonth" date="MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH)" href="#all-revenue-pmonth">Previous Month</a>
                    </li>
                </ul>
                <div class="row tab-content">
                    <div class="graph-div col-md-12 tab-pane fade active show" id="all-revenue-pday">
                        <div class="p-4">Total Revenue <?php echo $tollplazatoday['dtr']['revenue']['total']; ?></div>
                        <div id="allchartrevenuepday"></div>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-revenue-today">
                        <p>allplaza Revenue Today</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-revenue-pweek">
                        <p>allplaza Revenue Previous Week</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-revenue-pmonth">
                        <p>allplaza Revenue Previous Month</p>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="tab-pane fade" id="all-exempt">
            <div class="tabbable">
                <ul class=" row nav nav-tabs day">
                    <li class="heading btn-primary col-md-3 pday"><a id="allexemptpday" class="active" href="#all-exempt-pday" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)">Previous Day</a>
                    </li>
                    <li class="heading btn-primary col-md-3 today"><a id="allexempttoday" href="#all-exempt-today" date="DATE(for_date) = CURDATE()">Today</a>
                    </li>
                    <li class="heading btn-primary col-md-3 pweek"><a id="allexemptpweek" href="#all-exempt-pweek" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 WEEK)" href="#all-summary-pweek">Previous Week</a>
                    </li>
                    <li class="heading btn-primary col-md-3 pmonth"><a id="allexemptpmonth" date="MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH)" href="#all-exempt-pmonth">Previous Month</a>
                    </li>
                </ul>
                <div class="row tab-content">
                    <div class="graph-div col-md-12 tab-pane fade active show" id="all-exempt-pday">
                        <p>allplaza Exemptions Previous Day</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-exempt-today">
                        <p>allplaza Exemptions Today</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-exempt-pweek">
                        <p>allplaza Exemptions Previous Week</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-exempt-pmonth">
                        <p>allplaza Exemptions Previous Month</p>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
</div>
 </div>
		<?php //include('dtrdashboard/html/tollplazas.php'); ?>
		<div class="tab-pane fade" id="tollselect">
            <div class="tabbable">
			<ul class="row nav nav-tabs">
			<?php $i = 0; foreach($toolplazatoday as $toll){ ?>
				<li class="heading btn-primary col-md"><a class="<?php if($tollplaza['id'] == $i+1){ echo 'active show';} ?>" id="<?php echo $toll['id'];?>" href="#toll-<?php echo $toll['id'] ?>"><?php echo $toll['name'] ?></a>
				</li>
			<?php $i++; } ?>
			</ul>
			<div class="tab-content"> 
		<?php $i = 0; foreach($toolplazatoday as $toll){ ?>
	
		<div class="tab-pane fade " id="toll-<?php echo $toll['id'] ?>">
            <div class="tabbable">
			<ul class="row nav nav-tabs">
				<li class="heading toll btn-primary col-md"><a id="tollsummary" class="active show" href="#toll-<?php echo $toll['id'] ?>-summary">Summary</a>
				</li>
				<li class="heading toll btn-primary col-md"><a id="tolltraffic" href="#toll-<?php echo $toll['id'] ?>-traffic">Traffic</a>
				</li>
				<li  class="heading toll btn-primary col-md"><a id="tollrevenue" href="#toll-<?php echo $toll['id'] ?>-revenue">Revenue</a>
				</li>
				<!--<li  class="heading toll btn-primary col-md-3"><a id="tollexempt" href="#toll-<?php echo $toll['id'] ?>-exempt">Exemptions</a>
				</li>-->
			</ul>
    <div class="tab-content">
        <div class="tab-pane fade active in show" id="toll-<?php echo $toll['id'] ?>-summary">
            <div class="tabbable">
                <ul class=" row nav nav-tabs day">
                    <li class="heading btn-primary col-md-3 pday"><a id="tollsummarypday" href="#toll-<?php echo $toll['id']  ?>-summary-pday" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)">Previous Day</a>
                    </li>
                    <li class="heading col-md-3 btn-primary today"><a id="tollsummarytoday" href="#toll-<?php echo $toll['id'] ?>-summary-today" date="DATE(for_date) = CURDATE()">Today</a>
                    </li>
                    <li class="heading col-md-3 btn-primary pweek"><a id="tollsummarypweek" href="#toll-<?php echo $toll['id'] ?>-summary-pweek" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 WEEK)" href="#all-summary-pweek">Previous Week</a>
                    </li>
                    <li class="heading col-md-3 btn-primary pmonth"><a id="tollsummarypmonth" date="MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH)" href="#toll-<?php echo $toll['id'] ?>-summary-pmonth">Previous Month</a>
                    </li>
                </ul>
                <div class="row tab-content">
                    <div class="graph-div col-md-12 tab-pane fade active in show" id="toll-<?php echo $toll['id'] ?>-summary-pday">
                        <p>Tollplaza <?php echo $toll['id'] ?> Summary Previous Day</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-summary-today">
                        <p>Tollplaza <?php echo $toll['id'] ?> Summary Today</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-summary-pweek">
                        <p>Tollplaza <?php echo $toll['id'] ?> Summary Previous Week</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-summary-pmonth">
                        <p>Tollplaza <?php echo $toll['id'] ?> Summary Previous Month</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content">
        <div class="tab-pane fade" id="toll-<?php echo $toll['id'] ?>-traffic">
            <div class="tabbable">
                <ul class=" row nav nav-tabs day">
                    <li class="heading  btn-primary show col-md-3 pday"><a date="DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)" id="toll<?php echo $toll['id'] ?>trafficpday" class="active" href="#toll-<?php echo $toll['id'] ?>-traffic-pday">Previous Day</a>
                    </li>
                    <li class="heading col-md-3 btn-primary today"><a id="toll<?php echo $toll['id'] ?>traffictoday" href="#toll-<?php echo $toll['id'] ?>-traffic-today" date="DATE(for_date) = CURDATE()">Today</a>
                    </li>
                    <li class="heading col-md-3 btn-primary pweek"><a id="toll<?php echo $toll['id'] ?>trafficpweek" href="#toll-<?php echo $toll['id'] ?>-traffic-pweek" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 WEEK)" href="#all-summary-pweek">Previous Week</a>
                    </li>
                    <li class="heading col-md-3 btn-primary pmonth"><a id="toll<?php echo $toll['id'] ?>trafficpmonth" date="MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH)" href="#toll-<?php echo $toll['id'] ?>-traffic-pmonth">Previous Month</a>
                    </li>
                </ul>
                <div class="row tab-content">
                    <div class="graph-div col-md-12 tab-pane fade active show" id="toll-<?php echo $toll['id'] ?>-traffic-pday">
                        <p>Tollplaza <?php echo $toll['id'] ?> Traffic Previous Day</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-traffic-today">
                        <p>Tollplaza <?php echo $toll['id'] ?> Traffic Today</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-traffic-pweek">
                        <p>Tollplaza <?php echo $toll['id'] ?> Traffic Previous Week</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-traffic-pmonth">
                        <p>Tollplaza <?php echo $toll['id'] ?> Traffic Previous Month</p>
                    </div>
                </div>
            </div>
        </div>
				</div>
        <div class="tab-content">
        <div class="tab-pane fade" id="toll-<?php echo $toll['id'] ?>-revenue">
            <div class="tabbable">
                <ul class=" row nav nav-tabs day">
                    <li class="heading btn-primary show col-md-3 pday"><a id="toll<?php echo $toll['id'] ?>revenuepday" class="active" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)" href="#toll-<?php echo $toll['id'] ?>-revenue-pday">Previous Day</a>
                    </li>
                    <li class="heading btn-primary col-md-3 today"><a id="toll<?php echo $toll['id'] ?>revenuetoday" href="#toll-<?php echo $toll['id'] ?>-revenue-today" date="DATE(for_date) = CURDATE()">Today</a>
                    </li>
                    <li class="heading btn-primary col-md-3 pweek"><a id="toll<?php echo $toll['id'] ?>revenuepweek" href="#toll-<?php echo $toll['id'] ?>-revenue-pweek" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 WEEK)" href="#all-summary-pweek">Previous Week</a>
                    </li>
                    <li class="heading btn-primary col-md-3 pmonth"><a id="toll<?php echo $toll['id'] ?>revenuepmonth" date="MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH)" href="#toll-<?php echo $toll['id'] ?>-revenue-pmonth">Previous Month</a>
                    </li>
                </ul>
                <div class="row tab-content">
                    <div class="graph-div col-md-12 tab-pane fade active show" id="toll-<?php echo $toll['id'] ?>-revenue-pday">
                        <p>Tollplaza <?php echo $toll['id'] ?>-Revenue Previous Day</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-revenue-today">
                        <p>Tollplaza <?php echo $toll['id'] ?>-Revenue Today</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-revenue-pweek">
                        <p>Tollplaza <?php echo $toll['id'] ?>-Revenue Previous Week</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-revenue-pmonth">
                        <p>Tollplaza <?php echo $toll['id'] ?>-Revenue Previous Month</p>
                    </div>
                </div>
            </div>
        </div>
				</div>
     <!--   <div class="tab-content">
        <div class="tab-pane fade" id="toll-<?php echo $toll['id'] ?>-exempt">
            <div class="tabbable">
                <ul class=" row nav nav-tabs day">
                    <li class="heading btn-primary col-md-3 pday"><a id="toll<?php echo $toll['id'] ?>exemptpday" href="#toll-<?php echo $toll['id'] ?>-exempt-pday" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)">Previous Day</a>
                    </li>
                    <li class="heading btn-primary col-md-3 today"><a id="toll<?php echo $toll['id'] ?>exempttoday" href="#toll-<?php echo $toll['id'] ?>-exempt-today" date="DATE(for_date) = CURDATE()">Today</a>
                    </li>
                    <li class="heading btn-primary col-md-3 pweek"><a id="toll<?php echo $toll['id'] ?>exemptpweek" href="#toll-<?php echo $toll['id'] ?>-exempt-pweek" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 WEEK)" href="#all-summary-pweek">Previous Week</a>
                    </li>
                    <li class="heading btn-primary col-md-3 pmonth"><a id="toll<?php echo $toll['id'] ?>exemptpmonth" date="MONTH(for_date) = MONTH(NOW() - INTERVAL 1 MONTH)" href="#toll-<?php echo $toll['id'] ?>-exempt-pmonth">Previous Month</a>
                    </li>
                </ul>
                <div class="row tab-content">
                    <div class="graph-div col-md-12 tab-pane fade active show" id="toll-<?php echo $toll['id'] ?>-exempt-pday">
                        <p>Tollplaza <?php echo $toll['id'] ?>- Exemptions Previous Day</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-exempt-today">
                        <p>Tollplaza <?php echo $toll['id'] ?>- Exemptions Today</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-exempt-pweek">
                        <p>Tollplaza <?php echo $toll['id'] ?>- Exemptions Previous Week</p>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="toll-<?php echo $toll['id'] ?>-exempt-pmonth">
                        <p>Tollplaza <?php echo $toll['id'] ?>- Exemptions Previous Month</p>
                    </div>
                </div>
            </div>
        </div>
				</div>-->
    </div>
</div>
 </div>
				
 		<?php $i++; } ?>
				</div></div>
		</div>
		</div>
</div>
<?php include('dtrdashboard/scripts/costum.php'); ?>

			<?php include("dtrdashboard/scripts/trafficchart.php"); ?>
			<?php include("dtrdashboard/scripts/traffic1chart.php"); ?>
			<?php include("dtrdashboard/scripts/revenuechart.php"); ?>
			<?php include("dtrdashboard/scripts/revenue1chart.php"); ?>		
	
 
<?php include('includes/footer.php')?>