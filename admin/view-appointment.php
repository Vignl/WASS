<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $cid = $_GET['viewid'];
        $reason = $_POST['reason'];
        $status = $_POST['status'];

        if ($status == "Cancelled") {
            $updateQuery = "UPDATE tblbook SET Reason='$reason', Status='$status' WHERE ID='$cid'";
        } else {
            $updateQuery = "UPDATE tblbook SET Remark='$reason', Status='$status' WHERE ID='$cid'";
        }

        $query = mysqli_query($con, $updateQuery);
        if ($query) {
            echo '<script>alert("Remark/Reason and Status have been updated.")</script>';
            echo "<script type='text/javascript'> document.location ='all-appointment.php'; </script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>J. Castillon Dental Clinic || View Appointment</title>
    <!-- Your head content here -->
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
        <?php include_once('includes/sidebar.php'); ?>
        <!--left-fixed -navigation-->
        <!-- header-starts -->
        <?php include_once('includes/header.php'); ?>
        <!-- //header-ends -->
        <!-- main content start-->
        <div id="page-wrapper">
            <div class="main-page">
                <div class="tables">
                    <h3 class="title1">View Appointment</h3>
                    <div class="table-responsive bs-example widget-shadow">
                        <h4>View Appointment:</h4>
                        <?php
                        $cid = $_GET['viewid'];
                        $ret = mysqli_query($con, "SELECT tbluser.FirstName,tbluser.LastName,tbluser.Email,tbluser.MobileNumber,tblbook.ID as bid,tblbook.AptNumber,tblbook.ServiceName,tblbook.AptDate,tblbook.AptTime,tblbook.Message,tblbook.Reason,tblbook.BookingDate,tblbook.Remark,tblbook.Status,tblbook.RemarkDate from tblbook join tbluser on tbluser.ID=tblbook.UserID where tblbook.ID='$cid'");
                        $cnt = 1;
                        while ($row = mysqli_fetch_array($ret)) {
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <th>Appointment Number</th>
                                <td><?php echo $row['AptNumber']; ?></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $row['Email']; ?></td>
                            </tr>
                            <tr>
                                <th>Mobile Number</th>
                                <td><?php echo $row['MobileNumber']; ?></td>
                            </tr>
                            <tr>
                                <th>Dental Service:</th>
                                <td><?php echo $row['ServiceName']; ?></td>
                            </tr>
                            <tr>
                                <th>Appointment Date</th>
                                <td><?php echo date('F j, Y', strtotime($row['AptDate'])); ?></td>
                            </tr>
                            <tr>
                                <th>Appointment Time</th>
                                <td><?php echo date('g:i A', strtotime($row['AptTime'])); ?></td>
                            </tr>
                            <tr>
                                <th>Apply Date</th>
                                <td><?php echo date('F j, Y g:i A', strtotime($row['BookingDate'])); ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php
                                    if ($row['Status'] == "Pending") {
                                        echo "Not Updated Yet";
                                    } elseif ($row['Status'] == "Accepted") {
                                        echo "Accepted";
                                    } elseif ($row['Status'] == "Rejected") {
                                        echo "Rejected";
                                    } elseif ($row['Status'] == "Cancelled") {
                                        echo "Cancelled";
                                    } elseif ($row['Status'] == "Done") {
                                        echo "Done";
                                    } elseif ($row['Status'] == "Completed") {
                                        echo "Completed";
                                    }   
                                    ;?>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-bordered">
                            <?php if ($row['Status'] == "Pending") { ?>
                            <form name="submit" method="post" enctype="multipart/form-data">
                                <tr>
                                    <th><?php echo ($row['Status'] == "Cancelled") ? 'Reason' : 'Remark'; ?>:</th>
                                    <td>
                                        <textarea name="reason" placeholder="" rows="12" cols="14" class="form-control wd-450" required="true"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status :</th>
                                    <td>
                                        <select name="status" class="form-control wd-450" required="true">
                                            <option selected="true" value="" disabled selected>Set status</option>
                                            <option value="Accepted">Accepted</option>
                                            <option value="Rejected">Rejected</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td colspan="2"><button type="submit" name="submit" class="btn btn-primary">Submit</button></td>
                                </tr>
                            </form>
                            <?php } else { ?>
                        </table>
                        <table class="table table-bordered">
                        <tr>
                          <th>
                            <?php echo ($row['Status'] == "Cancelled") ? 'Reason' : 'Remark'; ?>:
                          </th>
                            <td>
                                  <?php
                                  if ($row['Status'] == "Cancelled") {
                                      echo $row['Reason'];
                                  } else {
                                      echo $row['Remark'];
                                  }
                                  ?>
                            </td>
                        </tr>
                            <tr>
                                <th>Status</th>
                                <td><?php echo $row['Status']; ?></td>
                            </tr>
                            <tr>
                                <th>Remark date</th>
                                <td><?php echo date('F j, Y g:i A', strtotime($row['RemarkDate'])); ?></td>
                            </tr>
                        </table>
                        <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!--footer-->
        <!--//footer-->
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
<?php
}
?>
