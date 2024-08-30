<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// Include the database connection
include 'db.php';

// Set the charset for the connection to ensure proper encoding
$conn->set_charset("utf8mb4");

// Initialize the base SQL query
$sql = "
    SELECT hymns.hymn_id, hymns.hymnNumber, hymns.burmeseTitle, hymns.englishTitle, hymns.author, hymns.bibleVerse, categories.categoryName
    FROM hymns
    LEFT JOIN categories ON hymns.category_id = categories.category_id
";

$hasHymnName = isset($_GET['hymnname']) && !empty($_GET['hymnname']);

if ($hasHymnName) {
    $hymnname = $conn->real_escape_string($_GET['hymnname']);
    // Remove spaces from the input hymn name
    $hymnname = str_replace(' ', '', $hymnname);
    // Modify the SQL query to remove spaces from the title fields during the comparison
    $sql .= " WHERE REPLACE(hymns.burmeseTitle, ' ', '') LIKE '%$hymnname%' 
              OR REPLACE(hymns.englishTitle, ' ', '') LIKE '%$hymnname%'";
}

// Pagination logic
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of hymns per page
$offset = ($page - 1) * $limit;

// Add LIMIT to the SQL query
$sql .= " LIMIT $limit";

// Conditionally add OFFSET based on the presence of 'hymnname'
if (!$hasHymnName) {
    $offset = ($page - 1) * $limit;
    $sql .= " OFFSET $offset";
}

// Execute the query
$result = $conn->query($sql);

$hymns_data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hymns_data[] = [
            'hymn_id' => $row['hymn_id'],
            'hymnNumber' => $row['hymnNumber'],
            'burmeseTitle' => $row['burmeseTitle'],
            'englishTitle' => $row['englishTitle'],
            'author' => $row['author'],
            'bibleVerse' => $row['bibleVerse'],
            'categoryName' => $row['categoryName']
        ];
    }

    echo json_encode($hymns_data, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(array("message" => "No hymns found."), JSON_UNESCAPED_UNICODE);
}

// Close the connection
$conn->close();
?>
