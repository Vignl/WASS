<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['bpmsaid']==0)) {
  header('location:logout.php');
} else{ 
  if($_GET['delid']){
    $sid=$_GET['delid'];
    mysqli_query($con,"delete from tblinvoice where BillingId ='$sid'");
    echo "<script>alert('Data Deleted');</script>";
    echo "<script>window.location.href='invoices.php'</script>";
  }
?>
<!DOCTYPE HTML>
<html>
<head>
  <title>J. Castillon Dental Clinic || Invoices</title>
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
  <!-- print -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
  <script>
    function filterByMonth() {
      var selectedMonth = document.getElementById("monthFilter").value;
      var selectedYear = document.getElementById("yearFilter").value;
      var selectedService = document.getElementById("serviceFilter").value;

      var url = 'invoices.php';

      // Check if "Select Month" is selected
      if (selectedMonth !== "") {
        url += '?month=' + selectedMonth;
      }

      // Check if a year is selected
      if (selectedYear !== "") {
        url += (url.indexOf('?') !== -1 ? '&' : '?') + 'year=' + selectedYear;
      }

      // Check if a service is selected
      if (selectedService !== "") {
        url += (url.indexOf('?') !== -1 || selectedMonth !== "") ? '&' : '?';
        url += 'service=' + selectedService;
      }

      // Redirect to the constructed URL
      window.location.href = url;
    }

    function filterByYear() {
      var selectedMonth = document.getElementById("monthFilter").value;
      var selectedYear = document.getElementById("yearFilter").value;
      var selectedService = document.getElementById("serviceFilter").value;

      var url = 'invoices.php';

      // Check if "Select Year" is selected
      if (selectedYear !== "") {
        url += '?year=' + selectedYear;
      }

      // Check if a month is selected
      if (selectedMonth !== "") {
        url += (url.indexOf('?') !== -1 ? '&' : '?') + 'month=' + selectedMonth;
      }

      // Check if a service is selected
      if (selectedService !== "") {
        url += (url.indexOf('?') !== -1 || selectedMonth !== "" || selectedYear !== "") ? '&' : '?';
        url += 'service=' + selectedService;
      }

      // Redirect to the constructed URL
      window.location.href = url;
    }

    function filterByService() {
      var selectedService = document.getElementById("serviceFilter").value;
      var selectedMonth = document.getElementById("monthFilter").value;
      var selectedYear = document.getElementById("yearFilter").value;

      var url = 'invoices.php';

      // Check if a service is selected
      if (selectedService !== "") {
        url += (url.indexOf('?') !== -1 ? '&' : '?') + 'service=' + selectedService;
      }

      // Check if a month is selected
      if (selectedMonth !== "") {
        url += (url.indexOf('?') !== -1 || selectedService !== "") ? '&' : '?';
        url += 'month=' + selectedMonth;
      }

      // Check if a year is selected
      if (selectedYear !== "") {
        url += (url.indexOf('?') !== -1 || selectedService !== "" || selectedMonth !== "") ? '&' : '?';
        url += 'year=' + selectedYear;
      }

      // Redirect to the constructed URL
      window.location.href = url;
    }
  </script>

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
          <h3 class="title1">Sales List</h3>
          <div class="form-group" style="display: inline-block; margin-right: 20px;">
            <label for="monthFilter">Select Month:</label>
            <select class="form-control custom-dropdown" id="monthFilter" onchange="filterByMonth()">
              <option value="" selected>All</option>
              <?php
              $months = array(
                "01" => "January", "02" => "February", "03" => "March",
                "04" => "April", "05" => "May", "06" => "June",
                "07" => "July", "08" => "August", "09" => "September",
                "10" => "October", "11" => "November", "12" => "December"
              );

              foreach ($months as $value => $label) {
                $selected = (isset($_GET['month']) && $_GET['month'] == $value) ? 'selected' : '';
                echo "<option value=\"$value\" $selected>$label</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group" style="display: inline-block; margin-right: 20px;">
            <label for="yearFilter">Select Year:</label>
            <select class="form-control custom-dropdown" id="yearFilter" onchange="filterByYear()">
              <option value="" selected>All</option>
              <?php
              $currentYear = date("Y");
              for ($year = $currentYear; $year >= ($currentYear - 10); $year--) {
                $selected = (isset($_GET['year']) && $_GET['year'] == $year) ? 'selected' : '';
                echo "<option value=\"$year\" $selected>$year</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group" style="display: inline-block;"> 
            <label for="serviceFilter">Filter Service:</label>
            <select class="form-control custom-dropdown" id="serviceFilter" onchange="filterByService()">
              <option value="" selected>All</option>
              <?php
              // Fetch services from the database and populate the dropdown
              $serviceQuery = "SELECT ID, ServiceName FROM tblservices";
              $serviceResult = mysqli_query($con, $serviceQuery);

              while ($serviceRow = mysqli_fetch_assoc($serviceResult)) {
                $selected = (isset($_GET['service']) && $_GET['service'] == $serviceRow['ID']) ? 'selected' : '';
                echo '<option value="' . $serviceRow['ID'] . '" ' . $selected . '>' . $serviceRow['ServiceName'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="form-group" style="display: inline-block; margin-right: 20px;"> 
              <a href="bwdates-reports-ds.php" class="btn btn-primary">Choose a date</a></td>
          </div>  
          <div class="table-responsive bs-example widget-shadow">
            <h4>Invoice List:</h4>
            <table class="table table-bordered"> 
              <thead> <tr> 
                <th>#</th> 
                <th>Invoice Id</th> 
                <th>Customer Name</th> 
                <th>Invoice Date</th> 
                <th>Service </th>
                <th>Cost</th>
                <th>Action</th>
              </tr> 
              </thead> <tbody>
              <?php
// Add this code before the existing SQL query
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';
$selectedYear = isset($_GET['year']) ? $_GET['year'] : '';
$selectedService = isset($_GET['service']) ? $_GET['service'] : '';

// Modify the SQL query to include the month and year filters
$sql = "SELECT DISTINCT tbluser.FirstName, tbluser.LastName, tblinvoice.BillingId, 
        tblinvoice.PostingDate as invoicedate, tblinvoice.ServiceCost
        FROM tbluser
        JOIN tblinvoice ON tbluser.ID = tblinvoice.Userid ";

if (!empty($selectedMonth)) {
    $sql .= "WHERE MONTH(tblinvoice.PostingDate) = '$selectedMonth' ";
}

if (!empty($selectedYear)) {
    $sql .= (!empty($selectedMonth) ? "AND " : "WHERE ") . "YEAR(tblinvoice.PostingDate) = '$selectedYear' ";
}

if (!empty($selectedService)) {
    $sql .= (!empty($selectedMonth) || !empty($selectedYear) ? "AND " : "WHERE ")
            . "tblinvoice.ServiceId = '$selectedService' ";
}

$sql .= "ORDER BY tblinvoice.ID DESC";

$ret = mysqli_query($con, $sql);
$cnt = 1;
$grandTotal = 0; // Initialize grand total

while ($row = mysqli_fetch_array($ret)) {
  // Fetch all services associated with the current invoice
  $invid = $row['BillingId'];
  $retServices = mysqli_query($con, "SELECT tblservices.ServiceName
                                      FROM tblinvoice 
                                      JOIN tblservices ON tblservices.ID = tblinvoice.ServiceId 
                                      WHERE tblinvoice.BillingId='$invid'");
  
  // Initialize an array to store service names
  $serviceNames = array();
  $invoiceTotal = $row['ServiceCost']; // Initialize total for the current invoice
  
  while ($serviceData = mysqli_fetch_assoc($retServices)) {
      $serviceNames[] = $serviceData['ServiceName'];
  }
      ?>
<tr>
    <th scope="row"><?php echo $cnt; ?></th>
    <td><?php echo $row['BillingId']; ?></td>
    <td><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></td>
    <td>
        <?php
        $invoicedate = strtotime($row['invoicedate']);
        $formattedDate = date('F j, Y', $invoicedate);
        $formattedTime = date('h:i A', $invoicedate);

        echo $formattedDate;
        ?>
    </td>
    <td><?php echo implode(' , ', $serviceNames); ?></td>
    <td>₱<?php echo $invoiceTotal; ?></td>
    <td><a href="view-invoice.php?invoiceid=<?php echo $row['BillingId']; ?>" class="btn btn-primary">View</a></td>
</tr>
<?php

$cnt = $cnt + 1; // Accumulate the invoice total in the grand total
$grandTotal += $invoiceTotal; 
}
?>
      <!-- Add the Grand Total row -->
      <tr>
        <td colspan="5" align="right"><b>Total:</b></td>
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
    <!--Print Script -->
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
<?php } ?>