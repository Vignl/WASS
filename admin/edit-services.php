<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{

	if (isset($_POST['submit'])) {
		$sername = $_POST['sername'];
		$serdesc = $_POST['serdesc'];
		$cost = $_POST['cost'];
	
		$eid = $_GET['editid'];
	
		// Fetch the current cost of the service
		$currentCostQuery = "SELECT Cost FROM tblservices WHERE ID='$eid'";
		$currentCostResult = mysqli_query($con, $currentCostQuery);
		$currentCostRow = mysqli_fetch_assoc($currentCostResult);
		$currentCost = $currentCostRow['Cost'];
	
		// Check if the service cost is being updated
		if ($currentCost != $cost) {
			// If the cost is being updated, update both Cost and HistoricalCost
			$query = "UPDATE tblservices set ServiceName='$sername',ServiceDescription='$serdesc',Cost='$cost', HistoricalCost='$currentCost' where ID='$eid'";
		} else {
			// If the cost is not being updated, only update ServiceName and ServiceDescription
			$query = "UPDATE tblservices set ServiceName='$sername',ServiceDescription='$serdesc' where ID='$eid'";
		}
	
		$result = mysqli_query($con, $query);
	
		if ($result) {
			echo "<script>alert('Service has been Updated.');</script>";
		} else {
			echo "<script>alert('Something Went Wrong. Please try again.');</script>";
		}
	}
?>	
<!DOCTYPE HTML>
<html>
<head>
<title>J. Castillon Dental Clinic | Update Services</title>
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
					<h3 class="title1">Update Services</h3>
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Update Dental Services:</h4>
						</div>
						<div class="form-body">
							<form method="post">
								
  <?php
 $cid=$_GET['editid'];
$ret=mysqli_query($con,"SELECT * from  tblservices where ID='$cid'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?> 

  
							 <div class="form-group"> <label for="exampleInputEmail1">Service Name</label> <input type="text" class="form-control" id="sername" name="sername" placeholder="Service Name" value="<?php  echo $row['ServiceName'];?>" required="true"> </div>
							 <div class="form-group"> <label for="exampleInputEmail1">Service Description</label> <textarea type="text" class="form-control" id="sername" name="serdesc" placeholder="Service Name" value="" required="true"><?php  echo $row['ServiceDescription'];?></textarea> </div>
							 <div class="form-group"> <label for="exampleInputPassword1">Cost</label> <input type="text" id="cost" name="cost" class="form-control" placeholder="Cost" value="<?php  echo $row['Cost'];?>" required="true"> </div>
							 <div class="form-group"> <label for="exampleInputPassword1">Image</label>  <img src="images/<?php echo $row['Image']?>" width="120">
               <a href="update-image.php?lid=<?php echo $row['ID'];?>">Update Image</a> </div>
							 <?php } ?>
							  <button type="submit" name="submit" class="btn btn-default">Update</button> </form> 
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
<?php } ?>