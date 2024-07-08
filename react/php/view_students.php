<?php
header('Content-Type: application/json');
include 'db.php';

// Fetch students
$sql = "SELECT username FROM users WHERE role = 'student'";
$result = $conn->query($sql);

$students = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

echo json_encode(['students' => $students]);
$conn->close();
?>

