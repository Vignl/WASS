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
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = md5($_POST['password']); // Hash the password for security

        // New field for password confirmation
        $confirmpassword = md5($_POST['confirmpassword']);

        if ($password == $confirmpassword) {
            // Password and Confirm Password match, proceed with the update
            $eid = $_GET['editid'];

            $query = "UPDATE tbladmin SET AdminName='$adminname', UserName='$username', MobileNumber='$phone', Email='$email', Password='$password' WHERE ID='$eid'";

            if (mysqli_query($con, $query)) {
                $msg = "Staff member details have been updated.";
            } else {
                $msg = "Something went wrong. Please try again.";
            }
        }
    }

    $eid = $_GET['editid'];
    $ret = mysqli_query($con, "SELECT * FROM tbladmin WHERE ID='$eid' AND role='Staff'");
    $cnt = 1;
    $row = mysqli_fetch_array($ret);
}
?>


<!DOCTYPE HTML>
<html>
<head>
    <title>J. Castillon Dental Clinic | Edit Staff</title>
    <link type="image/png" sizes="32x32" rel="icon" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<script>
function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmpassword").value;

    if (password !== confirmPassword) {
        alert("Passwords do not match. Please check your password entries.");
        return false; // Prevent form submission
    }
    alert("Staff member details have been updated.");
    return true; // Allow form submission if passwords match
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
        <!-- main content start -->
        <div id="page-wrapper">
            <div class="main-page">
                <div class="forms">
                    <h3 class="title1">Edit Staff</h3>
                    <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Edit Staff Information:</h4>
                        </div>
                        <div class="form-body">
                        <form method="post" onsubmit="return validateForm()">
                            
                            <?php
                                $cid=$_GET['editid'];
                                $ret=mysqli_query($con,"SELECT * from  tbladmin where ID='$cid'");
                                $cnt=1;
                                while ($row=mysqli_fetch_array($ret)) {
                            ?>     

                                <div class="form-group">
                                    <label for="adminname">Full Name</label>
                                    <input type="text" class="form-control" id="adminname" name="adminname" value="<?php echo $row['AdminName']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['UserName']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Mobile Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['MobileNumber']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['Email']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter a new password">
                                </div>
                                <div class="form-group">
                                    <label for="confirmpassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm New Password" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-default">Update Staff</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--footer-->
        <?php include_once('includes/footer.php');?>
    </div>
    <!-- Classie -->
    <script src="js/classie.js"></script>
    <script>
        var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

        showLeftPush.onclick = function () {
            classie.toggle(this, 'active');
            classie.toggle(body, 'cbp-spmenu-push-toright');
            classie.toggle(menuLeft, 'cbp-spmenu-open');
            disableOther('showLeftPush');
        };

        function disableOther(button) {
            if (button !== 'showLeftPush') {
                classie.toggle(showLeftPush, 'disabled');
            }
        }
    </script>
    <!--scrolling js-->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!--//scrolling js-->
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"></script>
</body>
</html>
<?php } ?>
