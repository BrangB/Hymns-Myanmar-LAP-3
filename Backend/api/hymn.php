<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json; charset=utf-8');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

// Include the database connection
include 'db.php';

// Set the charset for the connection to ensure proper encoding
$conn->set_charset("utf8mb4");

// Hymn ID
$hymn_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Execute SQL query to fetch hymn, verses, and choruses
$sql = "
    SELECT hymns.hymn_id, hymns.burmeseTitle, hymns.englishTitle, hymns.author, hymns.publishedYear, hymns.hymnNumber, hymns.bibleVerse, categories.categoryName,
           verses.verseNumber, verses.text AS verseText, 
           choruses.chorusNumber, choruses.text AS chorusText
    FROM hymns
    LEFT JOIN verses ON hymns.hymn_id = verses.hymn_id
    LEFT JOIN choruses ON hymns.hymn_id = choruses.hymn_id
    LEFT JOIN categories ON hymns.category_id = categories.category_id
    WHERE hymns.hymn_id = $hymn_id
";

$result = $conn->query($sql);

$hymn_data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $hymn_data['hymn'] = [
            'hymn_id' => $row['hymn_id'],
            'burmeseTitle' => $row['burmeseTitle'],
            'englishTitle' => $row['englishTitle'],
            'author' => $row['author'],
            'publishedYear' => $row['publishedYear'],
            'hymnNumber' => $row['hymnNumber'],
            'bibleVerse' => $row['bibleVerse'],
            'categoryName' => $row['categoryName'],
        ];

        if (!empty($row['verseText'])) {
            $hymn_data['verses'][] = [
                'verseNumber' => $row['verseNumber'],
                'text' => $row['verseText'],
            ];
        }

        if (!empty($row['chorusText'])) {
            $hymn_data['choruses'][] = [
                'chorusNumber' => $row['chorusNumber'],
                'text' => $row['chorusText'],
            ];
        }
    }

    // Check if the choruses array is empty
    if (empty($choruses)) {
        $hymn_data['choruses'] = "N/A";
    } else {
        $hymn_data['choruses'] = $choruses;
    }

    echo json_encode($hymn_data, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(array("message" => "Hymn not found."), JSON_UNESCAPED_UNICODE);
}

// Close the connection
$conn->close();

?>
