
<?php


// Database connection parameters
$servername = "sql12.freesqldatabase.com";
$username = "sql12728284";
$password = "D5ucZQK3Vu";
$dbname = "sql12728284";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "hymns_myanmar";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

