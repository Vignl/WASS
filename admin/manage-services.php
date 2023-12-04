<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_GET['action']) && isset($_GET['serviceid'])) {
        $serviceId = $_GET['serviceid'];
        $action = $_GET['action'];

        if ($action === 'disable') {
            // Disable the service
            $query = "UPDATE tblservices SET IsEnabled = 0 WHERE ID = '$serviceId'";
            mysqli_query($con, $query);
            updateHistoricalCost($con, $serviceId); // Update HistoricalCost
            echo "<script>alert('Service Disabled');</script>";
        } elseif ($action === 'enable') {
            // Enable the service
            $query = "UPDATE tblservices SET IsEnabled = 1 WHERE ID = '$serviceId'";
            mysqli_query($con, $query);
            updateHistoricalCost($con, $serviceId); // Update HistoricalCost
            echo "<script>alert('Service Enabled');</script>";
        }

        // Redirect back to the manage-services.php page
        echo "<script>window.location.href='manage-services.php'</script>";
    }
}

function updateHistoricalCost($con, $serviceId) {
    $queryUpdateHistorical = "UPDATE tblservices SET HistoricalCost = Cost WHERE ID = '$serviceId'";
    mysqli_query($con, $queryUpdateHistorical);
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>J. Castillon Dental Clinic || Manage Services</title>
<link type="image/png" sizes="32x32" rel="icon" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
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
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!--left-fixed -navigation-->
		 <?php include_once('includes/sidebar.php');?>
		<!--left-fixed -navigation-->
		<!-- header-starts -->
		 <?php include_once('includes/header.php');?>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<h3 class="title1">Manage Services</h3>
					
					
				
					<div class="table-responsive bs-example widget-shadow">
						<h4>Update Services:</h4>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Service Name</th>
									<th>Service Cost</th>
									<th>Creation Date</th><th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$ret=mysqli_query($con,"select *from  tblservices");
								$cnt=1;
								while ($row=mysqli_fetch_array($ret)) {

								?>

	<tr>
		<th scope="row"><?php echo $cnt;?></th>
		<td><?php  echo $row['ServiceName'];?></td>
		<td>₱<?php echo $row['Cost'];?></td>
		<td><?php echo date('F j, Y', strtotime($row['CreationDate'])); ?></td>
		<td>
		<a href="edit-services.php?editid=<?php echo $row['ID']; ?>" class="btn btn-primary">Edit</a>

            <?php if ($row['IsEnabled'] == 1) { ?>
                <a href="manage-services.php?action=disable&serviceid=<?php echo $row['ID']; ?>"
                   class="btn btn-warning"
                   onClick="return confirm('Are you sure you want to disable this service?')">Disable</a>
            <?php } else { ?>
                <a href="manage-services.php?action=enable&serviceid=<?php echo $row['ID']; ?>"
                   class="btn btn-success"
                   onClick="return confirm('Are you sure you want to enable this service?')">Enable</a>
            <?php } ?>
        </td>
    </tr>
    <?php
    $cnt = $cnt + 1;
}
?>
	</tbody> </table> 
					</div>
				</div>
			</div>
		</div>
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
