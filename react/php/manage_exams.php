<?php
header('Content-Type: application/json');
include 'db.php';

// Fetch exams
$sql = "SELECT id, name FROM exams";
$result = $conn->query($sql);

$exams = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $exams[] = $row;
    }
}

echo json_encode(['exams' => $exams]);
$conn->close();
?>

