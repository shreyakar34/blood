<?php 
session_start();
require 'connection.php';
if (isset($_SESSION['rid'])) {
if(isset($_POST['update'])){
    $id=$_SESSION['rid'];
    $rname = $_POST['rname'];
    $remail = $_POST['remail'];
    $rphone = $_POST['rphone'];
    $bg = $_POST['bg'];
    $rcity = $_POST['rcity'];
    $rpassword = $_POST['rpassword'];
    $update = "UPDATE receivers SET rname='$rname', remail='$remail', rpassword='$rpassword', rphone='$rphone', rbg='$bg',rcity='$rcity' WHERE rid='$id'";
    if ($conn->query($update) === TRUE) {
        $msg = "Your profile is updated successfully.";
        header( "location:../rprofile.php?msg=".$msg);
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
        header( "location:../rprofile.php?error=".$error );
    }
    $conn->close();
}


}elseif (isset($_SESSION['hid'])) {
    if(isset($_POST['update'])){
        $id=$_SESSION['hid'];
    $hname = $_POST['hname'];
    $hemail = $_POST['hemail'];
    $hphone = $_POST['hphone'];
    $hcity = $_POST['hcity'];
    $hpassword = $_POST['hpassword'];
    $update = "UPDATE hospitals SET hname='$hname', hemail='$hemail', hpassword='$hpassword', hphone='$hphone', hcity='$hcity' WHERE hid='$id'";
    if ($conn->query($update) === TRUE) {
        $msg= "Your profile is updated successfully.";
        header( "location:../hprofile.php?msg=".$msg);
    } else {
        $error= "Error: " . $sql . "<br>" . $conn->error;
        header( "location:../hprofile.php?error=".$error);
    }
    $conn->close();
}
}
elseif (isset($_SESSION['did'])) {
    if(isset($_POST['update'])){
        $id=$_SESSION['did'];
    $hname = $_POST['dname'];
    $hemail = $_POST['demail'];
    $hphone = $_POST['dphone'];
    $bg = $_POST['bg'];
    $hcity = $_POST['dcity'];
    $hpassword = $_POST['dpassword'];
    $update = "UPDATE donors SET dname='$dname', demail='$demail', dpassword='$dpassword', dphone='$dphone', dbg='$bg', dcity='$dcity' WHERE did='$id'";
    if ($conn->query($update) === TRUE) {
        $msg= "Your profile is updated successfully.";
        header( "location:../dprofile.php?msg=".$msg);
    } else {
        $error= "Error: " . $sql . "<br>" . $conn->error;
        header( "location:../dprofile.php?error=".$error);
    }
    $conn->close();
}
}
else{
    header("location:../login.php");
}
?>