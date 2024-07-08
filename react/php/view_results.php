<?php
header('Content-Type: application/json');
include 'db.php';

// Fetch exam results
$sql = "SELECT users.username AS student, exams.name AS exam, results.score FROM results JOIN users ON results.user_id = users.id JOIN exams ON results.exam_id = exams.id";
$result = $conn->query($sql);

$results = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
}

echo json_encode(['results' => $results]);
$conn->close();
?>

