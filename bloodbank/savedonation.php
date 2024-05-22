<?php
session_start();
require 'file/connection.php';

if(isset($_POST['submit_donation'])) {
    $dname = $_POST['dname'];
    $hname = $_POST['hname'];
    $hcity = $_POST['hcity'];
    $bg = $_POST['dbg'];
    $units = $_POST['units'];
    $did = $_SESSION['did']; // Use donor id from session
   
    $checkDonor = "SELECT * FROM donors WHERE did = ?";
    $stmt = $conn->prepare($checkDonor);
    $stmt->bind_param("i", $did);
    $stmt->execute();
    $result = $stmt->get_result();

    $hospital_query = "SELECT hid FROM hospitals WHERE hname='$hname' AND hcity='$hcity'";
    $hospital_result = mysqli_query($conn, $hospital_query);

    if (mysqli_num_rows($hospital_result) > 0 && mysqli_num_rows($result) > 0) {
        $hospital_row = mysqli_fetch_assoc($hospital_result);
        $hid = $hospital_row['hid'];

    $sql = "INSERT INTO donates (did, hid, dname, hname, hcity, bg, units) VALUES ('$did', '$hid', '$dname', '$hname', '$hcity', '$bg', '$units')";
    
    /*$sql1 = "INSERT INTO bloodstock (hid, bg, stock_quantity) VALUES ('$hid', '$bg', '$units)";*/

    if(mysqli_query($conn, $sql) ) {
        $msg = "Donation details saved successfully.";
        header("location:donationhistory.php?msg=".$msg);
    } else {
        $error = "Error: " . mysqli_error($conn);
        header("location:donateinfo.php?error=".$error);
    }
    $sql1 = "INSERT INTO bloodstock (hid, bg, stock_quantity) VALUES ('$hid', '$bg', '$units')";
    mysqli_query($conn, $sql1);
} else {
    $error = "Invalid donor or hospital details.";
    header("location:donateinfo.php?error=".$error);
}
}

?>