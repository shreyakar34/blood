<?php
    session_start();
    session_unset();
    session_destroy();
    $msg="You have logged out.";
    header( "Location:index.php?msg=".$msg );
?>