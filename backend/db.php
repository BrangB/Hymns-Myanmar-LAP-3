<?php
$servername = "sql12.freesqldatabase.com";
$username = "sql12725901";
$password = "KNcp87Xjdr";
$dbname = "sql12725901";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
