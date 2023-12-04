<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['delid'])) {
        $sid = $_GET['delid'];
        mysqli_query($con, "DELETE FROM tblservicereviews WHERE ReviewID = '$sid'");
        echo "<script>alert('Review Deleted');</script>";
        echo "<script>window.location.href='manage-reviews.php'</script>";
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>J. Castillon Dental Clinic || Manage Reviews</title>
    <link type="image/png" sizes="32x32" rel="icon" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">
    <!-- Your CSS and JavaScript files -->
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

</head>
<body class="cbp-spmenu-push">
    <div class="main-content">
        <!-- Include your admin sidebar and header here -->
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>
        <!-- Main content start -->
        <div id="page-wrapper">
            <div class="main-page">
                <div class="tables">
                    <h3 class="title1">Manage Reviews</h3>
                    <div class="table-responsive bs-example widget-shadow">
                        <h4>View Reviews:</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Service rated</th>
                                    <th>Reviewer name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Review date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $rowsPerPage = 5;
                                if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                                    $currentPage = $_GET['page'];
                                } else {
                                    $currentPage = 1;
                                }
                                $offset = ($currentPage - 1) * $rowsPerPage;

                                $ret = mysqli_query($con, "SELECT sr.*, s.ServiceName FROM tblservicereviews sr INNER JOIN tblservices s ON sr.ServiceID = s.ID LIMIT $offset, $rowsPerPage");

                                $cnt = 1 + $offset;

                                while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                    <tr class="gradeX">
                                        <td><?php echo $cnt;?></td>
                                        <td><?php echo $row['ServiceName']; ?></td>
                                        <td><?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></td>
                                        <td><?php echo $row['Email']; ?></td>
                                        <td><?php echo $row['Phone']; ?></td>
                                        <td><?php echo date('F j, Y g:i A', strtotime($row['ReviewDate'])); ?></td>
                                        <td>
                                            <a href="view-reviews.php?viewid=<?php echo $row['ReviewID'];?>" class="btn btn-primary">View</a>
                                            <a href="manage-reviews.php?delid=<?php echo $row['ReviewID'];?>" class="btn btn-danger" onClick="return confirm('Are you sure you want to delete this review?')">Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                    $cnt = $cnt + 1;
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        $totalRows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblservicereviews"));
                        $totalPages = ceil($totalRows / $rowsPerPage);

                        echo "<ul class='pagination'>";
                        for ($i = 1; $i <= $totalPages; $i++) {
                            echo "<li><a href='manage-reviews.php?page=$i'>$i</a></li>";
                        }
                        echo "</ul>";
                        ?>
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
<?php }  ?>
