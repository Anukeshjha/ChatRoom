<?php
session_start();
include 'db.php';

if (isset($_SESSION["userName"]) && isset($_SESSION["phone"])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatRoom</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script>
        // Function to send a new message
        function update() {
            var inputMsg = document.getElementById("input_msg").value.trim();
            if (inputMsg === '') {
                alert('Message cannot be empty.');
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "addmsg.php?msg=" + encodeURIComponent(inputMsg), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    loadMessages();
                    document.getElementById("input_msg").value = '';
                }
            };
            xhr.send();
        }

        // Function to load messages
        function loadMessages() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "readmsg.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("chatBox").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Load messages when the page loads and set an interval to refresh messages
        window.onload = function() {
            loadMessages();
            setInterval(loadMessages, 3000); // Refresh messages every 3 seconds
        }
    </script>
</head>
<body>
    <h1>ChatRoom</h1>
    <div class="chat">
        <h2>Welcome to <span><?= htmlspecialchars($_SESSION["userName"]) ?></span></h2>
        <div id="chatBox" class="msg"></div>
        <div class="input_msg">
            <input type="text" placeholder="Write msg Here" id="input_msg">
            <button onclick="update()">Send</button>
        </div>
    </div>
</body>
</html>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>
