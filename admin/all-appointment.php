<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsaid']) == 0) {
    header('location:logout.php');
} else {
    if ($_GET['delid']) {
        $sid = $_GET['delid'];
        mysqli_query($con, "delete from tblbook where ID ='$sid'");
        echo "<script>alert('Data Deleted');</script>";
        echo "<script>window.location.href='all-appointment.php'</script>";
    }

    $limit = 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;
    $start = max(0, $start);

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
    $sortColumn = isset($_GET['column']) ? $_GET['column'] : 'Status';

    $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    $query = "SELECT tbluser.FirstName, tbluser.LastName, tbluser.Email, tbluser.MobileNumber, tblbook.ID as bid, tblbook.AptNumber, tblbook.ServiceName, tblbook.AptDate, tblbook.AptTime, tblbook.Message, tblbook.BookingDate, tblbook.Status 
        FROM tblbook 
        JOIN tbluser ON tbluser.ID = tblbook.UserID";

    if (!empty($statusFilter) && $statusFilter !== 'all') {
        $query .= " WHERE tblbook.Status = '$statusFilter'";
    }

    if (!empty($searchTerm)) {
		if (!empty($statusFilter) && $statusFilter !== 'all') {
			$query .= " AND (";
		} else {
			$query .= " WHERE (";
		}
		$query .= "tbluser.FirstName LIKE '%$searchTerm%' OR tbluser.LastName LIKE '%$searchTerm%' 
				   OR tblbook.ServiceName LIKE '%$searchTerm%' OR tblbook.Status LIKE '%$searchTerm%'
				   OR DATE(tblbook.AptDate) = '$searchTerm' OR TIME_FORMAT(tblbook.AptTime, '%H:%i') = '$searchTerm')";
	}
	
    $query .= " ORDER BY $sortColumn $sort, AptTime $sort LIMIT $start, $limit";

    $count_query = "SELECT COUNT(*) as total FROM tblbook";
    if (!empty($statusFilter) && $statusFilter !== 'all') {
        $count_query .= " WHERE Status = '$statusFilter'";
    }

    $result = mysqli_query($con, $query);
    $count_result = mysqli_query($con, $count_query);

    $count_row = mysqli_fetch_assoc($count_result);
    $total_records = $count_row['total'];
    $total_pages = ceil($total_records / $limit);
    ?>
<!DOCTYPE HTML>
<html>
<head>
<title>J. Castillon Dental Clinic || All Appointment</title>
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
<script>
    function applyFilter() {
        var statusFilter = document.getElementById('statusFilter').value;
        window.location.href = '?page=<?php echo $page; ?>&sort=<?php echo $sort; ?>&column=<?php echo $sortColumn; ?>&status=' + statusFilter;
    }
</script>
<script>
    function markAsDone(appointmentId) {
        if (confirm('Are you sure you want to mark this procedure as done?')) {
            // AJAX request to update the status
            $.ajax({
                type: 'POST',
                url: 'update-status.php', // Create a new PHP file for handling status updates
                data: { appointmentId: appointmentId, status: 'Done' },
                success: function(response) {
                    if (response == 'success') {
                        // Reload the page after successful update
                        location.reload();
                    } else {
                        alert('Failed to update status. Please try again.');
                    }
                }
            });
        }
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
                    <h3 class="title1">All Appointment</h3>
                    <form method="get" action="">
                        <input type="text" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <input type="submit" value="Search">
                    </form>
                
                    <div class="table-responsive bs-example widget-shadow">
                        <h4>All Appointment:</h4>
                        <div class="form-group" style="display: inline-block; margin-right: 20px;">
                        <label for="statusFilter">Status Filter:</label>
                        <select class="form-control custom-dropdown" id="statusFilter" name="status" onchange="applyFilter()">
                            <option value="all" <?php echo ($statusFilter == 'all') ? 'selected' : ''; ?>>All</option>
                            <option value="Completed" <?php echo ($statusFilter == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="Done" <?php echo ($statusFilter == 'Done') ? 'selected' : ''; ?>>Done</option>
                            <option value="Accepted" <?php echo ($statusFilter == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                            <option value="Cancelled" <?php echo ($statusFilter == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            <option value="Rejected" <?php echo ($statusFilter == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                            <option value="Pending" <?php echo ($statusFilter == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        </select>
                    </div>
                            <table class="table table-bordered"> <thead> <tr> <th>#</th> 
                            <th>Appointment Number <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=AptNumber&status=<?php echo $statusFilter; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"></a></th> 
                            <th>Name <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=FirstName&status=<?php echo $statusFilter; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"></a></th>
                            <th>Dental Service <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=ServiceName&status=<?php echo $statusFilter; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"></a></th>
                            <th>Mobile Number</th> 
                            <th>Appointment Date <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=AptDate&status=<?php echo $statusFilter; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"></a></th>
                            <th>Appointment Time <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=AptTime&status=<?php echo $statusFilter; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"></a></th>
							<th>Status <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=Status&status=<?php echo $statusFilter; ?>&search=<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"></a></th>
                            <th>Action</th>
                            <?php
        $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';

        $query = "SELECT tbluser.FirstName, tbluser.LastName, tbluser.Email, tbluser.MobileNumber, tblbook.ID as bid, tblbook.AptNumber, tblbook.ServiceName, tblbook.AptDate, tblbook.AptTime, tblbook.Message, tblbook.BookingDate, tblbook.Status 
            FROM tblbook 
            JOIN tbluser ON tbluser.ID = tblbook.UserID
            WHERE (tbluser.FirstName LIKE '%$searchTerm%' OR tbluser.LastName LIKE '%$searchTerm%' 
                   OR tblbook.ServiceName LIKE '%$searchTerm%' OR tblbook.Status LIKE '%$searchTerm%'
                   OR DATE(tblbook.AptDate) = '$searchTerm' OR TIME_FORMAT(tblbook.AptTime, '%H:%i') = '$searchTerm')";

        if ($statusFilter !== 'all') {
            $query .= " AND tblbook.Status = '$statusFilter'";
        }

        $query .= " ORDER BY BookingDate DESC, AptTime $sort LIMIT $start, $limit";


        $ret = mysqli_query($con, $query);
        $cnt = ($page - 1) * $limit + 1;

        while ($row = mysqli_fetch_array($ret)) {
            ?>
            <tr>
                <th scope="row"><?php echo $cnt; ?></th>
                <td><?php echo $row['AptNumber']; ?></td>
                <td><?php echo $row['FirstName']; ?> <?php echo $row['LastName']; ?></td>
                <td><?php echo $row['ServiceName']; ?></td>
                <td><?php echo $row['MobileNumber']; ?></td>
                <td><?php echo date('F j, Y', strtotime($row['AptDate'])); ?></td>
                <td><?php echo date("h:i A", strtotime($row['AptTime'])); ?></td>
                <td><?php echo $row['Status']; ?></td>
                <td>
                    <a align="center" href="view-appointment.php?viewid=<?php echo $row['bid']; ?>" class="btn btn-primary">View</a>
                    <?php
                    if ($row['Status'] == 'Accepted') {
                        echo '<button onclick="markAsDone(' . $row['bid'] . ')" class="btn btn-success">Procedure Done</button>';
                    }
                    ?>
                </td>
            </tr>
            <?php
            $cnt = $cnt + 1;
        }
            if (!empty($searchTerm)) {
                echo "<tr>";
                echo "<td colspan='9'>Search results for '$searchTerm'</td>";
                echo "</tr>";
            }
        ?>
                            </tbody>
                        </table>
                        <?php
                            $count_query = "SELECT COUNT(*) as total FROM tblbook";
                            $count_result = mysqli_query($con, $count_query);
                            $count_row = mysqli_fetch_assoc($count_result);
                            $total_records_all = $count_row['total'];

                            $count_query = ($statusFilter !== 'all') ?
                                "SELECT COUNT(*) as total FROM tblbook WHERE Status = '$statusFilter'" :
                                "SELECT COUNT(*) as total FROM tblbook";
                            $count_result = mysqli_query($con, $count_query);
                            $count_row = mysqli_fetch_assoc($count_result);
                            $total_records = $count_row['total'];
                            $total_pages = ceil($total_records / $limit);

                            if ($total_pages > 0) {
                                echo "<div>";
                                echo "<ul class='pagination'>";
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    $active_class = ($i == $page) ? 'active' : '';
                                    echo "<li class='page-item $active_class'><a class='page-link' href='?page=$i&sort=$sort&column=$sortColumn&status=$statusFilter'>" . $i . "</a></li>";
                                }
                                echo "</ul>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
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
