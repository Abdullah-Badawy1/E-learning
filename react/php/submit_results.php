<?php
header('Content-Type: application/json');
session_start();
include 'db.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents('php://input');
    $result = json_decode($input, true);

    $userId = $_SESSION['user_id'];
    $totalQuestions = $result['totalQuestions'];
    $correctAnswers = $result['correctAnswers'];
    $timeTaken = $result['timeTaken'];
    $questionsAndAnswers = json_encode($result['questionsAndAnswers']);

    $stmt = $conn->prepare("INSERT INTO quiz_results (user_id, total_questions, correct_answers, time_taken, questions_and_answers) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $userId, $totalQuestions, $correctAnswers, $timeTaken, $questionsAndAnswers);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Results submitted successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to submit results!';
    }

    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request!';
}

echo json_encode($response);
$conn->close();
?>

