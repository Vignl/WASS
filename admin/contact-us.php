<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
		$bpmsaid = $_SESSION['bpmsaid'];
		$pagetitle = $_POST['pagetitle'];
		$pagedes = $_POST['pagedes'];
		$email = $_POST['email'];
		$mobnumber = $_POST['mobnumber'];
		$startTime = $_POST['start_time'];
		$endTime = $_POST['end_time'];
	
		// Update the database with the calculated end time
		$query = mysqli_query($con, "UPDATE tblpage set PageTitle='$pagetitle',Email='$email',MobileNumber='$mobnumber',StartTime='$startTime' ,EndTime='$endTime',PageDescription='$pagedes' where  PageType='contactus'");
	
		if ($query) {
			$msg = "Contact Us has been updated.";
		} else {
			$msg = "Something Went Wrong. Please try again";
		}
	}
	?>
<!DOCTYPE HTML>
<html>

<head>
    <title>J. Castillon Dental Clinic | Contact Us</title>
    <link type="image/png" sizes="32x32" rel="icon" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
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
    <!-- Font CSS -->
    <!-- Font-awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //Font-awesome icons -->
    <!-- JS -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>
    <!-- Webfonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <!-- //Webfonts -->
    <!-- Animate -->
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
	<script>
									$(document).ready(function () {
										// Initialize timepickers for start and end times
										$('.timepicker').timepicker({
											format: 'h:i A', // Display hours and AM/PM
											interval: 60, // Set interval to 60 minutes
											dynamic: false,
											dropdown: true,
											scrollbar: true
										});

										// Ensure that end time is always after start time
										$('#start_time').on('change', function () {
											var startTime = $(this).val();
											$('#end_time').val('').timepicker('option', 'minTime', startTime);
										});

										$('#end_time').on('change', function () {
											var endTime = $(this).val();
											$('#start_time').timepicker('option', 'maxTime', endTime);
										});
									});
								</script>
    <!-- //Animate -->
    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(nicEditors.allTextAreas);
    </script>
</head>

<body class="cbp-spmenu-push">
    <div class="main-content">
        <!-- Left-fixed -navigation -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- Left-fixed -navigation -->
        <!-- Header-starts -->
        <?php include_once('includes/header.php'); ?>
        <!-- //Header-ends -->
        <!-- Main content start -->
        <div id="page-wrapper">
            <div class="main-page">
                <div class="forms">
                    <h3 class="title1">Update Contact Us</h3>
                    <div class="form-grids row widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Update Contact Us:</h4>
                        </div>
                        <div class="form-body">
                            <form method="post">
                                <p style="font-size:16px; color:red" align="center">
                                    <?php if ($msg) {
                                        echo $msg;
                                    }  ?>
                                </p>
                                <?php
                                $ret = mysqli_query($con, "select * from  tblpage where PageType='contactus'");
                                $cnt = 1;
                                while ($row = mysqli_fetch_array($ret)) {
                                ?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Page Title</label>
                                        <input type="text" class="form-control" name="pagetitle" id="pagetitle" value="<?php echo $row['PageTitle']; ?>" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $row['Email']; ?>" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Mobile Number</label>
                                        <input type="text" class="form-control" name="mobnumber" id="mobnumber" value="<?php echo $row['MobileNumber']; ?>" required="true">
                                    </div>
									<div class="form-group">
										<label for="exampleInputEmail1">Start Time</label>
										<input type="time" class="form-control timepicker" name="start_time" id="start_time" value="<?php echo $row['StartTime']; ?>" required="true">
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1">End Time</label>
										<input type="time" class="form-control timepicker" name="end_time" id="end_time" value="<?php echo $row['EndTime']; ?>" required="true">
									</div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Page Description</label>
                                        <textarea name="pagedes" id="pagedes" rows="5" class="form-control">
                                            <?php echo $row['PageDescription']; ?>
                                        </textarea>
                                    </div>
                                <?php } ?>
                                <button type="submit" name="submit" class="btn btn-default">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('includes/footer.php'); ?>
    </div>
    <!-- Classie -->
    <script src="js/classie.js"></script>
    <script>
        var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

        showLeftPush.onclick = function() {
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
    <!-- Scrolling JS -->
    <script src="js/jquery.nicescroll.js"></script>
    <script src="js/scripts.js"></script>
    <!-- //Scrolling JS -->
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"> </script>
</body>

</html>
<?php } ?>
