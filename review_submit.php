<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);

if (isset($_POST['submit'])) {
    $service_id = $_POST['service_id'];
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $review=$_POST['review'];

    $query = mysqli_query($con, "INSERT into tblservicereviews(ServiceID, FirstName, LastName, Phone, Email, Review) values('$service_id', '$fname', '$lname', '$phone', '$email', '$review')");

    if ($query) {
        echo "<script>alert('Your review was submitted successfully.');</script>";
        echo "<script>window.location.href='reviews.php'</script>";
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>J. Castillon Dental Clinic | Submit a Review</title>
    <link type="image/png" sizes="32x32" rel="icon" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
  </head>
  <body id="home">
    <?php include_once('includes/header.php'); ?>

    <script src="assets/js/jquery-3.3.1.min.js"></script> <!-- Common jquery plugin -->
    <!--bootstrap working-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- //bootstrap working-->
    <!-- disable body scroll which navbar is in active -->
    <script>
$(function () {
  $('.navbar-toggler').click(function () {
    $('body').toggleClass('noscroll');
  })
});
</script>
    </script>
    <!-- disable body scroll which navbar is in active -->

    <!-- Page content -->
    <section class="w3l-inner-banner-main">
        <div class="about-inner contact ">
            <div class="container">   
                <div class="main-titles-head text-center">
                </div>
            </div>
        </div>
        <div class="breadcrumbs-sub">
            <div class="container">   
            <ul class="breadcrumbs-custom-path">
                <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a></li>
                <li class="active">Submit a Review</li>
            </ul>
            </div>
        </div>
        </section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec	">
        <div class="container">

            <div class="d-grid contact-view">
                <div class="cont-details">
                    <?php

$ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                    <div class="cont-top">
                        <div class="cont-left text-center">
                            <span class="fa fa-phone text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Contact Us</h6>
                            <p class="para"><a href="tel:+44 99 555 42">+<?php  echo $row['MobileNumber'];?></a></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-envelope-o text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Email Us</h6>
                            <p class="para"><a href="mailto:example@mail.com" class="mail"><?php  echo $row['Email'];?></a></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-map-marker text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Address</h6>
                            <p class="para"> <?php  echo $row['PageDescription'];?></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-map-marker text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Time</h6>
                            <?php
                                 // Convert StartTime and EndTime to "10 AM" and "3 PM" format
                                $startTime = date("h:i A", strtotime($row['StartTime']));
                                 $endTime = date("h:i A", strtotime($row['EndTime']));
                            ?>
                            <p class="para"> <?php echo $startTime; ?> to <?php echo $endTime; ?></p>
                        </div>
                    </div>
               <?php } ?> </div>
               <div style="padding-top: 30px;">
               <br><h4 style="padding-bottom: 20px;text-align: center;color: #28a745;">Submit a review</h4>
               <form method="post">
                                    <label for="service_id">Select a Service:</label>
                                    <select class="form-control" name="service_id" id="service_id" required>
                                        <option value="" disabled selected>Select a Service</option>
                                        <?php
                                    $ret = mysqli_query($con, "SELECT * FROM tblservices WHERE IsEnabled = 1");
                                    while ($row = mysqli_fetch_array($ret)) 
                                        {
                                            echo "<option value='" . $row['ID'] . "'>" . $row['ServiceName'] . "</option>";
                                        }
                                ?></select>
                        <div style="padding-top: 30px;" class="twice-two">
                            <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" required="">
                            <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" required="">
                        </div>
                        <div class="twice-two">
                           <input type="text" class="form-control" placeholder="Phone" required="" name="phone" pattern="[0-9]+" maxlength="10">
                            <input type="email" class="form-control" class="form-control" placeholder="Email" required="" name="email">
                        </div>
                        
                        <input type="text" required minlength="4" maxlength="250" class="form-control" id="review" name="review" placeholder="Review" required=""></input>
                        <button type="submit" class="btn btn-contact" name="submit">Submit review</button>
                    </form>
                </div>
    </div>
   
    </div></div>
</section>
    <?php include_once('includes/footer.php');?>
<!-- move top -->
<button onclick="topFunction()" id="movetop" title="Go to top">
	<span class="fa fa-long-arrow-up"></span>
</button>
<script>
	// When the user scrolls down 20px from the top of the document, show the button
	window.onscroll = function () {
		scrollFunction()
	};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			document.getElementById("movetop").style.display = "block";
		} else {
			document.getElementById("movetop").style.display = "none";
		}
	}

	// When the user clicks on the button, scroll to the top of the document
	function topFunction() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	}
</script>
<!-- /move top -->
</body>

</html>

<div style="padding-top: 30px;">
                                <label>Service:</label>
                                <select class="form-control" name="category" id="category" required="true">
                                <option value="" disabled selected>Select a Service</option>
                                <?php
                                    $ret = mysqli_query($con, "SELECT * FROM tblservices WHERE IsEnabled = 1");
                                    while ($row = mysqli_fetch_array($ret)) 
                                        {
                                            echo "<option value='" . $row['ServiceName'] . "'>" . $row['ServiceName'] . "</option>";
                                        }
                                ?></div>
                                    </select>