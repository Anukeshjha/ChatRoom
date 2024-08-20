<?php
session_start();
include 'db.php';

if (!isset($_SESSION["phone"])) {
    echo "<h3>Please log in to view the chat.</h3>";
    exit();
}

$q = "SELECT * FROM `msg` ORDER BY `id` ASC";
if ($rq = mysqli_query($db, $q)) {
    if (mysqli_num_rows($rq) > 0) {
        while ($data = mysqli_fetch_assoc($rq)) {
            if ($data["phone"] == $_SESSION["phone"]) {
                echo '<p class="sender"><span>' . htmlspecialchars($data["phone"]) . '</span> ' . htmlspecialchars($data["msg"]) . '</p>';
            } else {
                echo '<p class="receiver"><span>' . htmlspecialchars($data["phone"]) . '</span> ' . htmlspecialchars($data["msg"]) . '</p>';
            }
        }
    } else {
        echo "<h3>Chat is empty at this moment</h3>";
    }
} else {
    echo "<h3>Error retrieving messages: " . mysqli_error($db) . "</h3>";
}
?>
