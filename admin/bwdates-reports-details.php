<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!DOCTYPE HTML>
<html>
<head>
<title>J. Castillon Dental Clinic || B/W date Reports</title>
<link type="image/png" sizes="32x32" rel="icon" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
				<div class="tables">
					<h3 class="title1">Between dates reports</h3>
					
					
				
					<div class="table-responsive bs-example widget-shadow">
						<h4>Between dates reports:</h4><div class="form-group" style="display: inline-block; margin-right: 20px;"> 
              <a href="bwdates-reports-ds.php" class="btn btn-primary">Choose a date</a></td>
          </div> 
						
 <?php
$fdate=$_POST['fromdate'];
$tdate=$_POST['todate'];

?>
<h5 align="center" style="font-size: 20px; padding-bottom: 30px; color:#28a745;">Report from <strong><?php echo date('F j, Y g:i A', strtotime($fdate)); ?></strong> to <strong><?php echo date('F j, Y g:i A', strtotime($tdate)); ?></strong></h5>

						<table class="table table-bordered"> 
							<thead> <tr> 
								<th>#</th> 
								<th>Invoice Id</th> 
								<th>Customer Name</th> 
								<th>Invoice Date</th>
								<th>Service</th>
								<th>Cost</th> 
								<th>Action</th>
							</tr> 
							</thead><tbody>
                                    <?php
                                    $ret = mysqli_query($con, "SELECT 
                                        tbluser.FirstName,
                                        tbluser.LastName,
                                        tblinvoice.BillingId,
                                        tblinvoice.ServiceCost,
                                        tblinvoice.PostingDate,
                                        GROUP_CONCAT(tblservices.ServiceName SEPARATOR ', ') AS ServiceNames,
                                        SUM(tblinvoice.ServiceCost) AS TotalCost
                                    FROM
                                        tbluser
                                    JOIN tblinvoice ON tbluser.ID = tblinvoice.Userid
                                    JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId
                                    WHERE
                                        DATE(tblinvoice.PostingDate) BETWEEN '$fdate' AND '$tdate'
                                    GROUP BY tblinvoice.BillingId
									ORDER BY tblinvoice.PostingDate DESC");
                                    $cnt = 1;
                                    $grandTotal = 0; // Initialize the grand total variable

                                    while ($row = mysqli_fetch_array($ret)) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $cnt; ?></th>
                                            <td><?php echo $row['BillingId']; ?></td>
                                            <td><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></td>
                                            <td><?php echo date('F j, Y', strtotime($row['PostingDate'])); ?></td>
                                            <td><?php echo $row['ServiceNames']; ?></td>
                                            <td>₱<?php echo $row['ServiceCost']; ?></td>
                                            <td><a href="view-invoice.php?invoiceid=<?php echo $row['BillingId']; ?>" class="btn btn-primary">View</a></td>
                                        </tr>
                                    <?php
                                        // Increment the grand total with the current row's total cost
                                        $grandTotal += $row['ServiceCost'];
                                        $cnt = $cnt + 1;
                                    }
                                    ?>
                                    <!-- Add the Grand Total row after the table -->
                                    <tr>
                                        <td colspan="5" align="right"><strong>Grand Total:</strong></td>
                                        <td>₱<?php echo $grandTotal; ?></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
							<button class="btn btn-primary" onclick="printTable()">Print Table</button> 
					</div>
				</div>
			</div>
		</div>
		<script>
        function printTable() {
            // Clone the table
            var clonedTable = document.querySelector('.table').cloneNode(true);

            // Remove the "Action" column from all rows
            clonedTable.querySelectorAll('tr').forEach(function (row) {
                row.deleteCell(-1);
            });

            // Create a new div for the logo
            var logoDiv = document.createElement('div');
            logoDiv.innerHTML = '<img src="images/logo.png" alt="Logo" style="width: 300px; height: auto; margin-bottom: 1px;">';

            var containerDiv = document.createElement('div');
            containerDiv.appendChild(logoDiv);

            // Loop through rows and add borders to rows
            clonedTable.querySelectorAll('tr').forEach(function (row, index) {
                if (index === clonedTable.rows.length - 1) {
                    row.style.textAlign = 'right'; // Center align the "Total" row
                    row.style.fontWeight = 'bold'; // Make the "Total" row bold
                } else {
                    row.style.border = '1px solid #000'; // Add border to each row
                }
            });

            // Loop through columns and add borders to column headers
            clonedTable.querySelectorAll('th').forEach(function (header) {
                header.style.border = 'px solid #000'; // Add border to each column header
                header.style.padding = '8px'; // Add padding to each column header
                header.style.textAlign = 'left'; // Adjust text alignment for better appearance
            });

            containerDiv.appendChild(clonedTable);

            // Create a new window and write the content to it
            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Castillon Dental Clinic Sales Report</title></head><body>');
            printWindow.document.write('<style>table { border-collapse: collapse; width: 100%; } th, td { border: 1px solid #000; padding: 8px; text-align: left; }</style>');
            printWindow.document.write('<div>' + containerDiv.innerHTML + '</div>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            // Print the window
            printWindow.print();
        }
    </script>
		<!--footer-->
		 <?php include_once('includes/footer.php');?>
        <!--//footer-->
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
<?php }  ?>