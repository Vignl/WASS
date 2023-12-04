<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsuid'] == 0)) {
  header('location:logout.php');
} else {
  $cid = $_GET['aptnumber'];
  $ret = mysqli_query($con, "SELECT tbluser.FirstName, tbluser.LastName, tbluser.Email, tbluser.MobileNumber, tblbook.ID as bid, tblbook.AptNumber, tblbook.ServiceName, tblbook.AptDate, tblbook.AptTime, tblbook.Message, tblbook.BookingDate, tblbook.Reason, tblbook.Status, tblbook.RemarkDate from tblbook join tbluser on tbluser.ID=tblbook.UserID where tblbook.AptNumber='$cid'");
  $cnt = 1;
}
  while ($row = mysqli_fetch_array($ret)) {
    if (isset($_POST['submitCancellation'])) {
      $cancelReason = mysqli_real_escape_string($con, $_POST['cancelReason']);

      // Update the appointment status and cancellation reason in the database
      $updateQuery = "UPDATE tblbook SET Reason='" . $cancelReason . "', Status='Cancelled', RemarkDate=NOW() WHERE AptNumber='$cid'";

      if (mysqli_query($con, $updateQuery)) {
        // Appointment was successfully canceled and updated
        echo '<script>alert("Appointment has been canceled.");</script>';
      } else {
        // There was an error updating the appointment
        echo '<script>alert("Error: Unable to cancel the appointment. Please try again later.");</script>';
      }

      echo "<script>window.location.href='booking-history.php'</script>";

    }
    ?>
<!doctype html>
<html lang="en">

<head>
    <title>J. Castillon Dental Clinic | Booking History</title>
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>


<style>
/* Add this style inside your <head> section or in an external CSS file */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0,0,0,0.7);
}

.modal-content {
  background-color: #fff;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 60%;
}

.close {
  position: absolute;
  right: 10px;
  top: 10px;
  cursor: pointer;
}

textarea {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
}

button {
  background-color: red;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
}
</style>
</head>

<body id="home">

<div id="cancelModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Cancel Appointment</h2>
                <form method="post">
                    <p>Enter the reason for cancellation:</p>
                    <textarea id="cancelReason" rows="4" cols="50" name="cancelReason" required></textarea>
                    <button type="submit" name="submitCancellation">Confirm Cancellation</button>
                </form>
            </div>
        </div>

    <?php include_once('includes/header.php'); ?>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <!-- Common jquery plugin -->
    <!--bootstrap working-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- //bootstrap working-->
    <!-- disable body scroll which navbar is in active -->
    <script>
        $(function () {
            $('.navbar-toggler').click(function () {
                $('body').toggleClass('noscroll');
                }
              )
             }
          );
        </script>
         <script>
        function openModal() {
            document.getElementById("cancelModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("cancelModal").style.display = "none";
            document.getElementById("cancelReason").value = ""; // Clear the input
        }

        function confirmCancellation() {
            var reason = document.getElementById("cancelReason").value;
            
            // Send the cancellation reason to the server via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "appointment-detail.php", true); // Provide the URL to this same page
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Handle the response from the server, e.g., display a message
                    alert(xhr.responseText);
                }
            };

            // Prepare the data to send
            var data = "cancelReason=" + encodeURIComponent(reason);

            // Send the POST request
            xhr.send(data);
            closeModal(); // Close the modal
        }
    </script>
        <!-- disable body scroll which navbar is in active -->
        <!-- breadcrumbs -->
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
                        <li class="right-side propClone"><a href="index.php" class="">Home <span
                                    class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
                        <li class="active ">
                            Booking History</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- breadcrumbs //-->
        <section class="w3l-contact-info-main" id="contact">
            <div class="contact-sec	">
                <div class="container">
                    <div>
                        <div class="cont-details">
                            <div class="table-content table-responsive cart-table-content m-t-30">
                                <h4 style="padding-bottom: 20px;text-align: center;color: #28a745;">Appointment details</h4>
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
                                            } elseif ($row['Status'] == "Completed") {
                                                echo "Completed";
                                              } 
                                            ;?></td>
                                    </tr>
                                </table>
                                <?php 
                                  if ($row['Status'] == "Pending") {
                                    echo '<div style="text-align: center;"><button onclick="openModal()" class="btn btn-danger">Cancel Appointment</button></div>';
                                };
                                ?>
                                <button class="btn btn-danger" onclick="downloadAppointmentDetailsToPDF()">Download Appointment Details</button>
                    </div>
                </div>
            </div>
            <script>
                function downloadAppointmentDetailsToPDF() 
                {
                    // Create a new jsPDF instance
                    var doc = new jsPDF();
                     // Load your logo image
                    var logoImage = new Image();
                    logoImage.src = 'assets/images/logo.png'; // Update the path to your logo

                    // Define the data you want to include in the PDF as a 2D array
                    var appointmentDetails = [
                        ['Appointment Number', '<?php echo $row['AptNumber']; ?>'],
                        ['Name', '<?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?>'],
                        ['Dental Service', '<?php echo $row['ServiceName']; ?>'],
                        ['Appointment Date', '<?php echo date('F j, Y', strtotime($row['AptDate'])); ?>'],
                        ['Appointment Time', '<?php echo date('g:i A', strtotime($row['AptTime'])); ?>'],
                    ];

                     // Add the logo to the PDF
                     doc.addImage(logoImage, 'PNG', 0, 0, 110, 60);
                      // Adjust the position and size of the logo as needed

                    // Create a table using the table plugin
                    doc.autoTable({
                        body: appointmentDetails,
                        startY: 60 // Adjust the vertical position of the table as needed
                    });

                    // Save the PDF with a specific filename
                    doc.save('appointment_details.pdf');
                }
            </script>
        </section>
        <?php include_once('includes/footer.php'); ?>
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
<?php } ?>