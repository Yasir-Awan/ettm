<?php include('includes/header.php'); ?>

<?php include('ups_dashboard/style.php'); ?>

<br>
<div class="chart_div" style="margin-top: -10px !important;">

    <?php include('ups_dashboard/upper_card.php'); ?>

    <?php if ($this->session->userdata('adminid') != 22) { ?>
        <div class="main-content-inner">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <!-- Traffic summary table -->
                    <?php include('ups_dashboard/ups_summary.php'); ?>
                    <!-- Traffic summary Table END -->
                    <?php // include('ups_dashboard/charts.php'); 
                    ?>
                </div>
                <?php if ($page == "UPS Dashboard") { ?>
                    <?php include('ups_dashboard/scripts/charts_links.php'); ?>
                    <!-- Chart code -->
                    <?php if (!empty($chart)) { ?>
                        <?php include('ups_dashboard/scripts/pie_chart.php'); ?>
                        <?php include('ups_dashboard/scripts/comparison_chart.php'); ?>
                        <?php include('ups_dashboard/scripts/bar_charts.php'); ?>
                <?php }
                } ?>
            </div>
        <?php } ?>
        <?php if ($this->session->userdata('adminid') == 22) { ?>
            <div class="main-content-inner">
                <div class="row" style="padding:12rem;"></div>
            </div>
        <?php } ?>
        <?php include('includes/footer.php') ?>