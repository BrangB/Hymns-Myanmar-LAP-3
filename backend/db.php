
<?php
// Set CORS headers to allow access from any origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Send 200 OK response for preflight request
    header("HTTP/1.1 200 OK");
    exit();
}

// Database connection parameters
// $servername = "sql12.freesqldatabase.com";
// $username = "sql12725901";
// $password = "KNcp87Xjdr";
// $dbname = "sql12725901";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hymns_myanmar";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

