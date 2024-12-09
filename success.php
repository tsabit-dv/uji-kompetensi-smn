<?php
session_start();
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <script>
        // Function to get user's location
        function showPosition(position) {
            document.getElementById('latitude').textContent = position.coords.latitude;
            document.getElementById('longitude').textContent = position.coords.longitude;
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
    </script>
</head>
<body onload="getLocation()">
    <h2>Login Successful!</h2>
    <p>Your location:</p>
    <p>Latitude: <span id="latitude">Loading...</span></p>
    <p>Longitude: <span id="longitude">Loading...</span></p>
    <a href="logout.php">Logout</a>
</body>
</html>
