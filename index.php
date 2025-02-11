<?php
session_start();
include("./connect.php");
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

</head>

<body>
    <div class="welcome-container">
        <a href="./signup.php" class="btn">Sign Up</a>
        <a href="./login.php" class="btn">Login</a>
        <a href="./home.php" class="btn">Enter as Guest</a>
        <div class="footer">
            <p>&copy; 2025. All rights reserved. <a href="#">Privacy Policy</a></p>
        </div>
    </div>
</body>

</html>