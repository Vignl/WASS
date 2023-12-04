<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsuid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_GET['booking_id'])) {
        $booking_id = $_GET['booking_id'];
        $userid = $_SESSION['bpmsuid'];

        // Fetch booking details
        $booking_query = mysqli_query($con, "SELECT tblbook.ID as bid, tblbook.ServiceName, tblbook.AptDate, tblbook.AptTime, tblbook.Status, tbluser.FirstName, tbluser.LastName, tbluser.Email, tbluser.MobileNumber 
            FROM tblbook 
            JOIN tbluser ON tbluser.ID = tblbook.UserID 
            WHERE tblbook.ID = '$booking_id' AND tbluser.ID = '$userid'");

        $booking_details = mysqli_fetch_assoc($booking_query);

        if (!$booking_details) {
            // Redirect if the booking does not belong to the logged-in user
            header('location:all-appointment.php');
        }

        // Fetch the corresponding ServiceID from tblservices based on ServiceName
        $service_query = mysqli_query($con, "SELECT ID FROM tblservices WHERE ServiceName = '" . $booking_details['ServiceName'] . "'");
        $service_data = mysqli_fetch_assoc($service_query);

        $service_id = ($service_data) ? $service_data['ID'] : 0;
    } else {
        // Redirect if the booking_id is not set
        header('location:all-appointment.php');
    }
}

// Handle form submission
if (isset($_POST['submit_review'])) {
    $review = $_POST['review_content'];

    // Insert the review into the tblservicereviews table
    $insert_review_query = "INSERT INTO tblservicereviews (ServiceID, FirstName, LastName, Phone, Email, Review) 
        VALUES ('$service_id', '" . $booking_details['FirstName'] . "', '" . $booking_details['LastName'] . "', '" . $booking_details['MobileNumber'] . "', '" . $booking_details['Email'] . "', '$review')";
    mysqli_query($con, $insert_review_query);

    // Update booking status to "Done" in the database
    $update_query = "UPDATE tblbook SET Status = 'Completed' WHERE ID = '$booking_id'";
    mysqli_query($con, $update_query);

    echo "<script>alert('Review submitted successfully');</script>";
    echo "<script>window.location.href='booking-history.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>J. Castillon Dental Clinic | Rate Service</title>
    <link rel="icon" type="image/png" sizes="32x32" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body id="home">
    <?php include_once('includes/header.php'); ?>

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
                        <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a>
                            <p></li>
                        <li class="active ">
                            Rate</li>
                    </ul>
                </div>
            </div>
            </div>
        </section>
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

    <div class="container">
        <h4 style="padding-bottom: 30px; font-size: 30px; text-align: center; color: #28a745;"><strong><?php echo $booking_details['ServiceName']; ?></strong></h4>
        <div class="twice-two"> 
            <p style="font-size: 20px;"><strong style="color: #28a745;">Date:</strong> <?php echo date('F j, Y', strtotime($booking_details['AptDate'])); ?></p>
            <p style="font-size: 20px;"><strong style="color: #28a745;">Time:</strong> <?php echo date('h:i A', strtotime($booking_details['AptTime'])); ?></p>
            <p style="font-size: 20px;"><strong style="color: #28a745;">Status:</strong> <?php echo $booking_details['Status']; ?></p>
        </div>    
        <form method="post" action="">
            <label style="font-size: 20px;" for="review_content">Your Review:</label>
            <input type="text" required minlength="4" maxlength="250" class="form-control" name="review_content" placeholder="Review" required></input>
            <button type="submit" class="btn btn-contact" name="submit_review">Submit review</button>
        </form>
    </div>
</section>
    <?php include_once('includes/footer.php'); ?>

    <button onclick="topFunction()" id="movetop" title="Go to top">
        <span class="fa fa-long-arrow-up"></span>
    </button>

    <script>
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

            function topFunction() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
        </script>
</body>
</html>
