<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

// Include the database connection
include 'db.php';

// Set the charset for the connection to ensure proper encoding
$conn->set_charset("utf8mb4");

// Execute SQL query to fetch hymn number, hymn name, author, bible verse, and category name
$sql = "
    SELECT hymns.hymn_id, hymns.hymnNumber, hymns.burmeseTitle, hymns.englishTitle, hymns.author, hymns.bibleVerse, categories.categoryName
    FROM hymns
    LEFT JOIN categories ON hymns.category_id = categories.category_id
";

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
