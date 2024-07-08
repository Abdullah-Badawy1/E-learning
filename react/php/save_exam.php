<?php
header('Content-Type: application/json');
include 'db.php';

$examId = $_POST['id'];
$name = $_POST['name'];
$questions = $_POST['questions'];

// Update exam name
$sql = "UPDATE exams SET name = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $name, $examId);
$stmt->execute();
$stmt->close();

// Update exam questions
$sql = "DELETE FROM questions WHERE exam_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $examId);
$stmt->execute();
$stmt->close();

foreach ($questions as $question) {
    $options = json_encode($question['options']);
    $sql = "INSERT INTO questions (exam_id, question, options, correct_answer) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $examId, $question['question'], $options, $question['correct_answer']);
    $stmt->execute();
    $stmt->close();
}

echo json_encode(['status' => 'success', 'message' => 'Exam updated successfully']);
$conn->close();
?>

