<?php
$servername = "localhost";
$username = "webappuser"; // New username
$password = "securepassword"; // New password
$dbname = "login_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
