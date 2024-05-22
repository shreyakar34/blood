<?php 
session_start(); 
require 'connection.php';

if (!isset($_SESSION['rid'])) {
    header('location:../login.php');
    exit(); // Ensure script execution stops after redirection
}

if (isset($_POST['request'])) {
    // Retrieve and sanitize input data
    $hid = mysqli_real_escape_string($conn, $_POST['hid']);
    $rid = $_SESSION['rid'];
    $bg = mysqli_real_escape_string($conn, $_POST['bg']);
    $units = intval($_POST['no_of_units']); // Ensure it's an integer

    // Check if the number of units is valid
    if ($units <= 0) {
        $error = "Number of units must be greater than zero.";
        header("location:../abs.php?error=" . $error);
        exit(); // Stop script execution
    }

    // Call the stored procedure to check stock and request blood
    $sql = "CALL check_stock_and_request_blood(?, ?, ?, ?, @message)";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        $error = "Error preparing query: " . mysqli_error($conn);
        header("location:../abs.php?error=" . $error);
        exit(); // Stop script execution
    }

    mysqli_stmt_bind_param($stmt, 'iisi', $hid, $rid, $bg, $units);

    if (mysqli_stmt_execute($stmt)) {
        // Retrieve the output parameter value
        $result = mysqli_query($conn, "SELECT @message AS Message");
        $row = mysqli_fetch_assoc($result);
        $message = $row['Message'];

        if ($message === 'Request Submitted') {
            // Successful procedure execution, handle success
            $msg = "You have requested $units units of blood group $bg. Our team will contact you soon.";
            header("location:../sentrequest.php?msg=" . $msg);
            exit(); // Stop script execution
        } else {
            // Procedure execution succeeded but with a different message
            header("location:../abs.php?error=" . $message);
            exit(); // Stop script execution
        }
    } else {
        // Handle error when procedure execution fails
        $error = "Error executing stored procedure: " . mysqli_error($conn);
        header("location:../abs.php?error=" . $error);
        exit(); // Stop script execution
    }

    mysqli_stmt_close($stmt); // Close the statement
}

$conn->close(); // Close database connection
?>

