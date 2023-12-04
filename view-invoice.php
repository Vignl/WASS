<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsuid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!doctype html>
<html lang="en">
  <head>

    <title>J. Castillon Dental Clinic | Booking History</title>
    <link type="image/png" sizes="32x32" rel="icon" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
  </head>
  <body id="home">
<?php include_once('includes/header.php');?>

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
    <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">
        Invoice History</li>
</ul>
</div>
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
    <?php
    $invid=intval($_GET['invoiceid']);
$ret=mysqli_query($con,"select DISTINCT  date(tblinvoice.PostingDate) as invoicedate,tbluser.FirstName,tbluser.LastName,tbluser.Email,tbluser.MobileNumber,tbluser.RegDate
    from  tblinvoice 
    join tbluser on tbluser.ID=tblinvoice.Userid 
    where tblinvoice.BillingId='$invid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>              
                
                    <div class="table-responsive bs-example widget-shadow">
                        <h4 style="padding-bottom: 25px;">Invoice #<?php echo $invid;?></h4>
                        <table class="table table-bordered" width="100%" border="1"> 
<tr>
<th colspan="6">Customer Details</th>   
</tr>
                             <tr> 
                                <th>Name</th> 
                                <td><?php echo $row['FirstName']?> <?php echo $row['LastName']?></td> 
                                <th>Contact no.</th> 
                                <td><?php echo $row['MobileNumber']?></td>
                                <th>Email </th> 
                                <td><?php echo $row['Email']?></td>
                            </tr> 
                             <tr> 
                                <th>Registration Date</th> 
                                <td><?php echo date('F j, Y', strtotime($row['RegDate'])); ?></td> 
                                <th>Invoice Date</th> 
                                <td colspan="3"><?php echo date('F j, Y', strtotime($row['invoicedate'])); ?>
</td> 
                            </tr> 
<?php }?>
</table> 
<table class="table table-bordered" width="100%" border="1"> 
<tr>
<th colspan="3">Services Details</th>   
</tr>
<tr>
<th>#</th>  
<th>Service</th>
<th>Cost</th>
</tr>
<?php
$uniqueBillingIds = []; // Initialize an array to track unique BillingIds
$gtotal = 0; // Initialize the grand total

$ret = mysqli_query($con, "SELECT tblservices.ServiceName, tblinvoice.ServiceCost, tblinvoice.BillingId
    FROM tblinvoice 
    JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId 
    WHERE tblinvoice.BillingId = '$invid'");

while ($row = mysqli_fetch_array($ret)) {
    $billingId = $row['BillingId'];

    // Check if the BillingId is already in the array
    if (!isset($uniqueBillingIds[$billingId])) {
        // If not, add it to the array and collect service details for that BillingId
        $uniqueBillingIds[$billingId] = true;
        $serviceNames = [];
        $serviceNames[] = $row['ServiceName'];
        $gtotal += $row['ServiceCost'];
    } else {
        // If BillingId is already in the array, add the additional service name but don't add the cost
        $serviceNames[] = $row['ServiceName'];
    }
}

// Display a single row with concatenated service names
?>
<tr>
    <th><?php echo $cnt; ?></th>
    <td><?php echo implode(", ", $serviceNames); ?></td>
    <td>₱<?php echo $gtotal; ?></td>
</tr>
<?php
$cnt = $cnt + 1;
?>

<tr>
<th colspan="2" style="text-align:center">Grand Total</th>
<th>₱<?php echo $gtotal?></th>   

</tr>
</table>
  <p style="margin-top:1%"  align="center">
 <!-- print 
    <i class="fa fa-print fa-2x" style="cursor: pointer;"  OnClick="CallPrint(this.value)" ></i>
-->
</p>
                    </div> </div>
                
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

</html><?php } ?>