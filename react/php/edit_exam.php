<?php
header('Content-Type: application/json');
include 'db.php';

$examId = $_GET['id'];

// Fetch exam details
$sql = "SELECT id, name FROM exams WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $examId);
$stmt->execute();
$stmt->bind_result($id, $name);
$stmt->fetch();
$stmt->close();

// Fetch exam questions
$sql = "SELECT id, question, options, correct_answer FROM questions WHERE exam_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $examId);
$stmt->execute();
$stmt->bind_result($question_id, $question, $options, $correct_answer);

$questions = [];
while ($stmt->fetch()) {
    $questions[] = [
        'id' => $question_id,
        'question' => $question,
        'options' => json_decode($options),
        'correct_answer' => $correct_answer
    ];
}
$stmt->close();

echo json_encode(['exam' => ['id' => $id, 'name' => $name, 'questions' => $questions]]);
$conn->close();
?>

