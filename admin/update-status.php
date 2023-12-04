<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['appointmentId']) && isset($_POST['status'])) {
    $appointmentId = $_POST['appointmentId'];
    $status = $_POST['status'];

    // Update the status in the database
    $updateQuery = "UPDATE tblbook SET Status = '$status' WHERE ID = '$appointmentId'";
    $result = mysqli_query($con, $updateQuery);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
