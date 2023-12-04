<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid'] == 0)) {
    header('location:logout.php');
}

$userRole = $_SESSION['userRole'];
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>J. Castillon Dental Clinic | Admin Dashboard</title>

    <link type="image/png" sizes="32x32" rel="icon" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">

    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- font CSS -->
    <!-- font-awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome icons -->
    <!-- js-->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>
    <!--webfonts-->
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <!--//webfonts-->
    <!--animate-->
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <!--//end-animate-->
    <!-- chart -->
    <script src="js/Chart.js"></script>
    <!-- //chart -->
    <!--Calender-->
    <link rel="stylesheet" href="css/clndr.css" type="text/css" />
    <script src="js/underscore-min.js" type="text/javascript"></script>
    <script src="js/moment-2.2.1.js" type="text/javascript"></script>
    <script src="js/clndr.js" type="text/javascript"></script>
    <script src="js/site.js" type="text/javascript"></script>
    <!--End Calender-->
    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->
</head>

<body class="cbp-spmenu-push">
    <div class="main-content">

        <?php include_once('includes/sidebar.php'); ?>

        <?php include_once('includes/header.php'); ?>
        <!-- main content start-->
        <div id="page-wrapper" class="row calender widget-shadow">
            <div class="main-page">

                <div class="row calender widget-shadow">
                    <div class="row-one">
                        <div class="col-md-4 widget">
                            <?php $query1 = mysqli_query($con, "Select * from tbluser");
                            $totalcust = mysqli_num_rows($query1);
                            ?>
                            <div class="stats-left ">
                                <h5>Total</h5>
                                <h4>Customer</h4>
                            </div>
                            <div class="stats-right">
                                <label> <?php echo $totalcust; ?></label>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="col-md-4 widget states-mdl">
                            <?php $query2 = mysqli_query($con, "Select * from tblbook");
                            $totalappointment = mysqli_num_rows($query2);
                            ?>
                            <div class="stats-left">
                                <h5>Total</h5>
                                <h4>Appointment</h4>
                            </div>
                            <div class="stats-right">
                                <label> <?php echo $totalappointment; ?></label>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="col-md-4 widget states-last">
                            <?php $query3 = mysqli_query($con, "Select * from tblbook where Status='Selected'");
                            $totalaccapt = mysqli_num_rows($query3);
                            ?>
                            <div class="stats-left">
                                <h5>Total</h5>
                                <h4>Accepted Apt</h4>
                            </div>
                            <div class="stats-right">
                                <label><?php echo $totalaccapt; ?></label>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                    <div class="row calender widget-shadow">
                        <div class="row-one">
                            <div class="col-md-4 widget">
                                <?php
                                $query4 = mysqli_query($con, "Select * from tblbook where Status='Rejected'");
                                $totalrejapt = mysqli_num_rows($query4);
                                ?>
                                <div class="stats-left ">
                                    <h5>Total</h5>
                                    <h4>Rejected Apt</h4>
                                </div>
                                <div class="stats-right">
                                    <label> <?php echo $totalrejapt; ?></label>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="col-md-4 widget states-mdl">
                                <?php
                                $query5 = mysqli_query($con, "Select * from tblservices");
                                $totalser = mysqli_num_rows($query5);
                                ?>
                                <div class="stats-left">
                                    <h5>Total</h5>
                                    <h4>Services</h4>
                                </div>
                                <div class="stats-right">
                                    <label> <?php echo $totalser; ?></label>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                            <div class="col-md-4 widget states-last">
                                <?php
                                $query6 = mysqli_query($con, "select tblinvoice.ServiceId as ServiceId, tblinvoice.ServiceCost from tblinvoice join tblservices on tblservices.ID=tblinvoice.ServiceId where date(PostingDate)=CURDATE();");
                                $uniqueBillingIdsToday = array();
                                $todysale = 0;

                                while ($row = mysqli_fetch_array($query6)) {
                                    $serviceIdToday = $row['ServiceId'];

                                    // Check if the ServiceId is already in the array
                                    if (!isset($uniqueBillingIdsToday[$serviceIdToday])) {
                                        // If not, add it to the array and update today's sale
                                        $uniqueBillingIdsToday[$serviceIdToday] = true;

                                        $todays_sale = $row['ServiceCost'];
                                        $todysale += $todays_sale;
                                    }
                                }
                                ?>
                                <?php if ($userRole !== 'Staff') { ?>
                                    <div class="stats-left">
                                        <h5>Today</h5>
                                        <h4>Sales</h4>
                                    </div>
                                    <div class="stats-right">
                                        <label> <?php if ($todysale == "") :
                                                    echo "0";
                                                else :
                                                    echo $todysale;
                                                endif; ?></label>
                                    </div>
                                    <div class="clearfix"> </div>
                                </div>
                                <div class="clearfix"> </div>
                            <?php } ?>
                            <?php if ($userRole !== 'Staff') { ?>
                                <div class="row calender widget-shadow">
                                    <div class="row-one">
                                        <div class="col-md-4 widget">
                                            <?php
                                            $query7 = mysqli_query($con, "select tblinvoice.ServiceId as ServiceId, tblinvoice.ServiceCost
                                                from tblinvoice 
                                                join tblservices  on tblservices.ID=tblinvoice.ServiceId where date(PostingDate)=CURDATE()-1;");
                                            $uniqueBillingIdsYesterday = array();
                                            $yesterdaysale = 0;

                                            while ($row7 = mysqli_fetch_array($query7)) {
                                                $serviceIdYesterday = $row7['ServiceId'];

                                                // Check if the ServiceId is already in the array
                                                if (!isset($uniqueBillingIdsYesterday[$serviceIdYesterday])) {
                                                    // If not, add it to the array and update yesterday's sale
                                                    $uniqueBillingIdsYesterday[$serviceIdYesterday] = true;

                                                    $yesterdays_sale = $row7['ServiceCost'];
                                                    $yesterdaysale += $yesterdays_sale;
                                                }
                                            }
                                            ?>
                                            <div class="stats-left ">
                                                <h5>Yesterday</h5>
                                                <h4>Sales</h4>
                                            </div>
                                            <div class="stats-right">
                                                <label> <?php
                                                        if ($yesterdaysale == "") :
                                                            echo "0";
                                                        else :
                                                            echo $yesterdaysale;
                                                        endif;
                                                        ?></label>
                                            </div>
                                            <div class="clearfix"> </div>
                                        </div>
                                        <div class="col-md-4 widget states-mdl">
                                            <?php
                                            $query8 = mysqli_query($con, "select tblinvoice.ServiceId as ServiceId, tblinvoice.ServiceCost
                                                from tblinvoice 
                                                join tblservices  on tblservices.ID=tblinvoice.ServiceId where date(PostingDate)>=(DATE(NOW()) - INTERVAL 7 DAY);");
                                            $uniqueBillingIdsSevenDays = array();
                                            $tseven = 0;

                                            while ($row8 = mysqli_fetch_array($query8)) {
                                                $serviceIdSevenDays = $row8['ServiceId'];

                                                // Check if the ServiceId is already in the array
                                                if (!isset($uniqueBillingIdsSevenDays[$serviceIdSevenDays])) {
                                                    // If not, add it to the array and update seven days' sale
                                                    $uniqueBillingIdsSevenDays[$serviceIdSevenDays] = true;

                                                    $sevendays_sale = $row8['ServiceCost'];
                                                    $tseven += $sevendays_sale;
                                                }
                                            }
                                            ?>
                                            <div class="stats-left">
                                                <h5>Last Sevendays</h5>
                                                <h4>Sale</h4>
                                            </div>
                                            <div class="stats-right">
                                                <label> <?php
                                                        if ($tseven == "") :
                                                            echo "0";
                                                        else :
                                                            echo $tseven;
                                                        endif; ?></label>
                                            </div>
                                            <div class="clearfix"> </div>
                                        </div>
					<div class="col-md-4 widget states-last">
					<?php
$query9 = mysqli_query($con, "SELECT tblinvoice.ServiceId as ServiceId, tblinvoice.ServiceCost, tblinvoice.BillingId
                               FROM tblinvoice
                               JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId");

$uniqueBillingIds = array();
$totalsale = 0;

while ($row9 = mysqli_fetch_array($query9)) {
    $billingId = $row9['BillingId'];

    // Check if the BillingId is already in the array
    if (!isset($uniqueBillingIds[$billingId])) {
        // If not, add it to the array and update the total sale
        $uniqueBillingIds[$billingId] = true;
        
        $total_sale = $row9['ServiceCost'];
        $totalsale += $total_sale;
    }
}
// Now $totalsale contains the sum of unique transactions based on BillingId
 ?>
						<div class="stats-left">
							<h5>Total</h5>
							<h4>Sales</h4>
						</div>
						<div class="stats-right">
							<label><?php

		if($totalsale==""):
							echo "0";
else:
	echo $totalsale;
endif;
						?></label>
						</div>
						<?php } ?>
						<div class="clearfix"> </div>	
					</div>
					<div class="clearfix"> </div>	
				</div>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
</div>
</div>
<div>
		<!--footer-->
		<?php include_once('includes/footer.php');?>
        <!--//footer-->
	</div>
	<!-- Classie -->
		<script src="js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.js"> </script>
</body>
</html>