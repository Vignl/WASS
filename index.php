<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['bpmsuid']);

// If the user is not logged in, show the modal
if (!$isLoggedIn) {
    echo '<script type="text/javascript">$(document).ready(function () { $("#loginModal").modal("show"); });</script>';
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>J. Castillon Dental Clinic | Home Page</title>
    <link type="image/png" sizes="32x32" rel="icon" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">
    <!-- Include jQuery and Bootstrap JS before your custom script -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <script>
      $(document).ready(function () {
        $(".logo-button").click(function (e) {
          e.preventDefault();

          // Check if the user is logged in (you may need to modify this condition based on your authentication logic)
          var isLoggedIn = <?php echo isset($_SESSION['bpmsuid']) ? 'true' : 'false'; ?>;

          if (!isLoggedIn) {
            // User is not logged in, show a modal with a message and a button to redirect to the login page
            $('#loginModal').modal('show');
          } else {
            // User is logged in, redirect to the appointment page
            window.location.href = "book-appointment.php";
          }
        });
      });
    </script>
  </head>
  <body id="home">

<?php include_once('includes/header.php');?>
 <!-- Common jquery plugin -->
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
<!-- disable body scroll which navbar is in active -->

<div class="w3l-hero-headers-9">
  <div class="css-slider">
    <input id="slide-1" type="radio" name="slides" checked>
    <section class="slide slide-one">
      <div class="container">
        <div class="banner-text">
          <h4>Opening hours:</h4>
          <?php
              $ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
              $cnt=1;
              while ($row=mysqli_fetch_array($ret)) {
                ?>
                  <?php
                                        // Convert StartTime and EndTime to "10 AM" and "3 PM" format
                                        $startTime = date("h:i A", strtotime($row['StartTime']));
                                        $endTime = date("h:i A", strtotime($row['EndTime']));
                                        ?>
                                        <h4> <?php echo $startTime; ?> to <?php echo $endTime; ?></h4>
                                    </div>
          <?php } ?>
            <a href="book-appointment.php" class="btn logo-button top-margin">Get An Appointment</a>
        </div>
      </div>
      
  </div>
</div> 
<section class="w3l-teams-15">
	<div class="team-single-main ">
		<div class="container">
		
				<div class="column2 image-text">
        <?php

          $ret=mysqli_query($con,"select * from tblpage where PageType='aboutus' ");
          $cnt=1;
          while ($row=mysqli_fetch_array($ret)) {

        ?>
					<h3 class="team-head ">Your Smile, Our Priority: Bringing Dentistry to Your Doorstep!</h3>
					<p class="para  text "><strong><?php  echo $row['PageDescription'];?></strong></p><?php } ?>
						<a href="reviews.php" class="btn logo-button top-margin mt-4">Check out our Reviews!</a>
				</div>
			</div>
		</div>
	</div>
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
<!-- Modal for if user isnt logged in -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Login Required</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>You are not logged in. Please log in to book an appointment.</p>
          </div>
          <div class="modal-footer">
            <a href="login.php" class="btn btn-primary" style="margin: 0 auto;">Log In</a>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>
