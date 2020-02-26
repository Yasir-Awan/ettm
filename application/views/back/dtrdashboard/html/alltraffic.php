
        <div class="tab-pane fade active in show" id="all-summary">
            <div class=" tabbable">
                   <ul class=" row nav nav-tabs day">
                    <li class="heading btn-primary col-md-3 p-day"><a id="allsummarypday" class="active" date="DATE(for_date) = DATE(NOW() - INTERVAL 1 DAY)" href="#all-summary-p-day">Previous Day</a>
                    </li>
                    <li class="heading btn-primary col-md-3 today"><a id="allsummarytoday" href="#all-summary-today">Today</a>
                    </li>
                    <li class="heading btn-primary col-md-3 p-week"><a id="allsummarypweek" href="#all-summary-p-week">Previous Week</a>
                    </li>
                    <li class="heading btn-primary col-md-3 p-month"><a id="allsummarypmonth" href="#all-summary-p-month">Previous Month</a>
                    </li>
                </ul>
               <div class="row tab-content">
                    <div class="graph-div col-md-12 tab-pane fade active in show" id="all-summary-p-day">
                        <?php include('allsummarypday.php'); ?>                   
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-summary-today">
                        <?php include('allsummarytoday.php') ?>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-summary-p-week">
                        <?php include('allsummarypweek.php') ?>
                    </div>
                    <div class="graph-div col-md-12 tab-pane fade" id="all-summary-p-month">
                        <?php include('allsummarypmonth.php') ?>
                    </div>
                </div>
            </div>
        </div>