<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>J. Castillon Dental Clinic | Reviews</title>
    <link rel="icon" type="image/png" sizes="32x32" href="https://cdn-icons-png.flaticon.com/128/2441/2441054.png">
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        .review-container {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
        }

        .review-container h5 {
            color: #28a745;
        }

        .review-details {
            color: #6c757d;
        }

        .review-text {
            max-height: 100px; /* Adjust the height as needed */
            overflow: hidden;
            position: relative;
        }

        .read-more-btn {
            color: #28a745;
            cursor: pointer;
            display: none;
        }

        .expanded {
            max-height: none;
        }

        .expanded ~ .read-more-btn {
            display: block;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 12px;
            margin: 0 5px;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination a:hover {
            background-color: #218838;
        }

        #movetop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
        }

        #movetop:hover {
            background-color: #218838;
        }
    </style>
</head>
<body id="home">

    <!-- Your Original Header -->
    <?php include_once('includes/header.php'); ?>

    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            $('.navbar-toggler').click(function () {
                $('body').toggleClass('noscroll');
            })
        });

        function toggleReadMore(element) {
            var reviewText = element.previousSibling;
            var isExpanded = reviewText.classList.toggle('expanded');
            element.innerText = isExpanded ? 'Read Less' : 'Read More';
        }
    </script>

    <section class="w3l-inner-banner-main">
        <div class="about-inner services">
            <div class="container">
                <div class="main-titles-head text-center">
                    <!-- Title and content for your banner section -->
                </div>
            </div>
        </div>
        <div class="breadcrumbs-sub">
            <div class="container">
                <ul class="breadcrumbs-custom-path">
                    <li class="right-side propClone">
                        <a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a>
                    </li>
                    <li class="active">Reviews</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <div class="container">
        <h4 style="padding-top: 20px; padding-bottom: 20px; text-align: center; color: #28a745;">User Reviews:</h4>

        <?php
        $reviewsPerPage = 5;
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $reviewsPerPage;

        // Updated query to order by ReviewDate in descending order
        $query = "SELECT sr.*, s.ServiceName FROM tblservicereviews sr INNER JOIN tblservices s ON sr.ServiceID = s.ID ORDER BY sr.ReviewDate DESC LIMIT $offset, $reviewsPerPage";
        $reviews = mysqli_query($con, $query);

        while ($review = mysqli_fetch_array($reviews)) {
            echo '<div class="review-container">
                    <div class="review-details">
                        <p style="padding-bottom: 15px;"><strong style="color: #28a745;">'.$review['ServiceName'].'</strong></p>
                        <div class="review-text">"'.$review['Review'].'"</div>
                        <p class="read-more-btn" onclick="toggleReadMore(this)">Read More</p>
                        <p style="padding-top: 20px;">-<strong> '.$review['FirstName'].' '.$review['LastName'].'</strong></p>';
                        $originalDate = $review['ReviewDate'];
                        $newDate = date("F j, Y", strtotime($originalDate));
                        $newTime = date("h:i A", strtotime($originalDate));
                        echo '<p style="font-size: 13px; color:">'.$newDate . " " . $newTime.'</p>
                    </div>
                </div>';
        }
        ?>

        <!-- Pagination links -->
        <div style="padding-bottom: 40px; "class="pagination">
            <?php
            $totalReviews = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblservicereviews"));
            $totalPages = ceil($totalReviews / $reviewsPerPage);

            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href='?page=$i'>$i</a> ";
            }
            ?>
        </div>
    </div>

    <!-- Your Original Footer -->
    <?php include_once('includes/footer.php'); ?>

    <!-- move top -->
    <button onclick="topFunction()" id="movetop" title="Go to top">
        <span class="fa fa-long-arrow-up"></span>
    </button>
    <!-- /move top -->
</body>
</html>
