<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $adminname = $_POST['adminname'];
        $username = $_POST['username'];
        $phone = $_POST['mobilenumber'];
        $email = $_POST['email'];
        $password=md5($_POST['password']); // Hash the password for security
        $role = $_POST['role'];
        
        // You can perform data validation here

        $query = "INSERT INTO tbladmin (AdminName, UserName, MobileNumber, Email, Password, role) VALUES ('$adminname', '$username', '$phone', '$email', '$password', '$role')";

        if (mysqli_query($con, $query)) {
            echo "<script>alert('Staff member has been added.');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>J. Castillon Dental Clinic | Add Staff</title>
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
				<div class="forms">
					<h3 class="title1">Add Staff</h3>
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Staff Information:</h4>
						</div>
                        <div class="form-body">
                            <form method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                                <label for="adminname">Full Name</label>
                                <input type="adminname" class="form-control" id="adminname" name="adminname" placeholder="Full Name" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="username" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Mobile Number</label>
                                <input type="phone" class="form-control" id="phone" name="phone" pattern="[0-9]+" maxlength="11" placeholder="Mobile Number" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <input type="role" class="form-control" id="role" name="role" placeholder="Role" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-default">Add Staff</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
					</div>
				
				
			</div>
		</div>
		 <?php include_once('includes/footer.php');?>
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