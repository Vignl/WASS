<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['bpmsuid']) == 0) {
    header('location:logout.php');
} else {
    if ($_GET['delid']) {
        $sid = $_GET['delid'];
        mysqli_query($con, "DELETE FROM tblbook WHERE ID ='$sid'");
        echo "<script>alert('Data Deleted');</script>";
        echo "<script>window.location.href='all-appointment.php'</script>";
    }

    $limit = 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = max(0, ($page - 1) * $limit);

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';
    $sortColumn = isset($_GET['column']) ? $_GET['column'] : 'Status';

    $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    $userid = $_SESSION['bpmsuid'];

    $query = "SELECT tbluser.FirstName, tbluser.LastName, tbluser.Email, tbluser.MobileNumber, tblbook.ID as bid, tblbook.AptNumber, tblbook.ServiceName, tblbook.AptDate, tblbook.AptTime, tblbook.Message, tblbook.BookingDate, tblbook.Status 
        FROM tblbook 
        JOIN tbluser ON tbluser.ID = tblbook.UserID
        WHERE tbluser.ID='$userid'";

    if (!empty($statusFilter) && $statusFilter !== 'all') {
        $query .= " AND tblbook.Status = '$statusFilter'";
    }

    if (!empty($searchTerm)) {
        $query .= " AND (tbluser.FirstName LIKE '%$searchTerm%' OR tbluser.LastName LIKE '%$searchTerm%' 
                   OR tblbook.ServiceName LIKE '%$searchTerm%' OR tblbook.Status LIKE '%$searchTerm%'
                   OR DATE(tblbook.AptDate) = '$searchTerm' OR TIME_FORMAT(tblbook.AptTime, '%H:%i') = '$searchTerm')";
    }

    $query .= " ORDER BY BookingDate DESC, $sortColumn $sort, AptTime $sort LIMIT $start, $limit";

    $count_query = "SELECT COUNT(*) as total FROM tblbook WHERE UserID='$userid'";
    if (!empty($statusFilter) && $statusFilter !== 'all') {
        $count_query .= " AND Status = '$statusFilter'";
    }

    $result = mysqli_query($con, $query);
    $count_result = mysqli_query($con, $count_query);

    $count_row = mysqli_fetch_assoc($count_result);
    $total_records = $count_row['total'];
    $total_pages = ceil($total_records / $limit);
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
        <style>
            .select {
                position: relative;
                display: inline-block;
                margin-bottom: 13px;
                width: 32%;
            }    .select select {
                    font-family: 'Arial';
                    display: inline-block;
                    width: 33%;
                    cursor: pointer;
                    padding: 9px 20px;
                    outline: 0;
                    border: 1px solid #28a745;
                    border-radius: 21px;
                    background: #28a745;
                    color: #ffffff;
                    appearance: none;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                }
                    .select select::-ms-expand {
                        display: none;
                    }
                    .select select:hover,
                    .select select:focus {
                        color: #28a745;
                        background: #ffffff;
                    }
                    .select select:disabled {
                        opacity: 0.1;
                        pointer-events: none;
                    }
            .select_arrow {
                position: absolute;
                top: 9px;
                right: 15px;
                width: 7px;
                height: 7px;
                border: solid #ffffff;
                border-width: 0 3px 3px 0;
                display: inline-block;
                padding: 3px;
                transform: rotate(45deg);
                -webkit-transform: rotate(45deg);
            }
            .select select:hover ~ .select_arrow,
            .select select:focus ~ .select_arrow {
                border-color: #28a745;
            }
            .select select:disabled ~ .select_arrow {
                border-top-color: #cccccc;
            } .css-input {
                padding: 3px;
                font-size: 16px;
                border-width: 2px;
                border-color: #28a745;
                background-color: #ffffff;
                color: #28a745;
                border-style: solid;
                border-radius: 12px;
                box-shadow: 0px 0px 0px rgba(66,66,66,.75);
            }
            .css-input:focus {
                outline:none;
            } ::placeholder {
            color: #28a745;
            opacity: 1;
            }
        </style>   
    </head>

    <body id="home">
        <?php include_once('includes/header.php'); ?>
        <script src="assets/js/jquery-3.3.1.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script>
            $(function () {
                $('.navbar-toggler').click(function () {
                    $('body').toggleClass('noscroll');
                })
            });
        </script>

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
                            Booking History</li>
                    </ul>
                </div>
            </div>
            </div>
        </section>

        <section class="w3l-contact-info-main" id="contact">
            <div class="contact-sec	 ">
                <div class="container">
                    <div class="form-group" style="display: inline-block; margin-right: 20px;">
                        <form method="get" action="">
                            <input type="text" class="css-input" name="search" placeholder="Search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                            <input type="submit" class="btn btn-primary" value="Search">
                        </form>
                    </div>

                    <div class="select" style="display: inline-block; margin-right: 20px;">
                        <label for="statusFilter"></label>
                        <select class="select" id="statusFilter" name="status" onchange="applyFilter()">
                            <option value="all" <?php echo ($statusFilter == 'all') ? 'selected' : ''; ?>>All</option>
                            <option value="Completed" <?php echo ($statusFilter == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="Done" <?php echo ($statusFilter == 'Done') ? 'selected' : ''; ?>>Done</option>
                            <option value="Accepted" <?php echo ($statusFilter == 'Accepted') ? 'selected' : ''; ?>>Accepted</option>
                            <option value="Cancelled" <?php echo ($statusFilter == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            <option value="Rejected" <?php echo ($statusFilter == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                            <option value="Pending" <?php echo ($statusFilter == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        </select>
                    </div>

                    <script>
                        function applyFilter() {
                            var statusFilter = document.getElementById("statusFilter").value;
                            window.location.href = "?status=" + statusFilter;
                        }
                    </script>

                    <div>
                        <div class="cont-details">
                            <div class="table-content table-responsive cart-table-content m-t-30">
                                <h4 style="padding-bottom: 20px;text-align: center;color: #28a745;">Appointment details</h4>
                                <table border="2" class="table">
                                    <thead class="gray-bg">
                                        <tr>
                                            <th>#</th>
                                            <th>
                                                Appointment Number
                                                <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=AptNumber&status=<?php echo $statusFilter; ?>&search=<?php echo htmlspecialchars($searchTerm); ?>"></a>
                                            </th>
                                            <th>
                                                Dental Service
                                                <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=ServiceName&status=<?php echo $statusFilter; ?>&search=<?php echo htmlspecialchars($searchTerm); ?>"></a>
                                            </th>
                                            <th>
                                                Appointment Date
                                                <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=AptDate&status=<?php echo $statusFilter; ?>&search=<?php echo htmlspecialchars($searchTerm); ?>"></a>
                                            </th>
                                            <th>
                                                Appointment Time
                                                <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=AptTime&status=<?php echo $statusFilter; ?>&search=<?php echo htmlspecialchars($searchTerm); ?>"></a>
                                            </th>
                                            <th>
                                                Appointment Status
                                                <a class="fa fa-sort" href="?page=<?php echo $page; ?>&sort=<?php echo ($sort == 'ASC' ? 'DESC' : 'ASC'); ?>&column=Status&status=<?php echo $statusFilter; ?>&search=<?php echo htmlspecialchars($searchTerm); ?>"></a>
                                            </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $userid = $_SESSION['bpmsuid'];
                                        $query = mysqli_query($con, "SELECT tbluser.ID as uid, tbluser.FirstName,tbluser.LastName,tbluser.Email,tbluser.MobileNumber,tblbook.ID as bid,toblbook.AptNumber,tblbook.ServiceName,tblbook.AptDate,tblbook.AptTime,tblbook.Message,tblbook.BookingDate,tblbook.Status FROM tblbook JOIN tbluser ON tbluser.ID=tblbook.UserID WHERE tbluser.ID='$userid'");
                                        $cnt = 1;
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                            <tr>
                                                <td><?php echo $cnt; ?></td>
                                                <td><?php echo $row['AptNumber']; ?></td>
                                                <td><?php echo $row['ServiceName']; ?></td>
                                                <td>
                                                <p><?php echo date('F j, Y', strtotime($row['AptDate'])); ?></p>
                                                </td>
                                                <td><?php echo date("h:i A", strtotime($row['AptTime'])); ?></td>
                                                <td>
                                                    <?php
                                                    $status = $row['Status'];
                                                    if ($status == 'Pending') {
                                                        echo "Waiting for confirmation";
                                                    } else {
                                                        echo $status;
                                                    }
                                                    ?>
                                                </td>

                                                <td>
                                                    <a href="appointment-detail.php?aptnumber=<?php echo $row['AptNumber']; ?>" class="btn btn-primary">View</a>
                                                    <?php
                                                    // Add the "Leave Review" button if the status is "Accepted"
                                                    if ($status == 'Done') {
                                                        ?>
                                                        <a href="rate.php?booking_id=<?php echo $row['bid']; ?>" class="btn btn-primary">Rate</a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php $cnt = $cnt + 1;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <ul class="pagination">
                                <?php
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    $active_class = ($i == $page) ? 'active' : '';
                                    ?>
                                    <li class='page-item <?php echo $active_class; ?>'>
                                        <a class='page-link' href='?page=<?php echo $i; ?>&sort=<?php echo $sort; ?>&column=<?php echo $sortColumn; ?>&status=<?php echo $statusFilter; ?>&search=<?php echo htmlspecialchars($searchTerm); ?>'>
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
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
<?php
}
?>