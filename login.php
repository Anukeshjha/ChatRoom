<?php
include 'db.php';
session_start();

if (isset($_POST["name"]) && isset($_POST["phone"])) {
    $name = $_POST["name"];
    $phone = $_POST["phone"];

    // Check if the user exists with the provided name and phone
    $q = "SELECT * FROM `user` WHERE uname='$name' AND phone='$phone'";
    if ($rq = mysqli_query($db, $q)) {
        if (mysqli_num_rows($rq) == 1) {
            // User exists
            $_SESSION["userName"] = $name;
            $_SESSION["phone"] = $phone;
            header("location: index.php");
            exit();
        } else {
            // Check if the phone number is already registered
            $q = "SELECT * FROM `user` WHERE phone='$phone'";
            if ($rq = mysqli_query($db, $q)) {
                if (mysqli_num_rows($rq) == 1) {
                    echo "<script>alert('Phone number is already registered');</script>";
                } else {
                    // Register new user
                    $q = "INSERT INTO `user` (`uname`, `phone`) VALUES ('$name', '$phone')";
                    if ($rq = mysqli_query($db, $q)) {
                        $_SESSION["userName"] = $name;
                        $_SESSION["phone"] = $phone;
                        header("location: index.php");
                        exit();
                    } else {
                        echo "<script>alert('Error registering user');</script>";
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatRoom</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <h1>ChatRoom</h1>
    <div class="login">
        <h2>Login</h2>
        <p>This ChatRoom is the best example to demonstrate the concept of ChatBot and it's completely for beginners.</p>
        <form action="" method="post">
            <h3>UserName</h3>
            <input type="text" placeholder="Short Name" name="name" required>
            <h3>Mobile No:</h3>
            <input type="text" placeholder="with country code" name="phone" required>
            <button type="submit">Login / Register</button>
        </form>
    </div>
</body>
</html>
