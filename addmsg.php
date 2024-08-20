<?php
session_start();
include 'db.php';

if (isset($_SESSION["phone"]) && isset($_GET["msg"])) {
    $msg = mysqli_real_escape_string($db, $_GET["msg"]);
    $phone = $_SESSION["phone"];

    $q = "INSERT INTO `msg`(`phone`, `msg`) VALUES ('$phone', '$msg')";
    if (mysqli_query($db, $q)) {
        // Message inserted successfully
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
?>
