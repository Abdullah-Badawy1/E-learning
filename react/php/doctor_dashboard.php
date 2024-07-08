<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header('Location: index.html');
    exit();
}
include 'db.php';

$stmt = $conn->prepare("SELECT quiz_results.*, users.username FROM quiz_results JOIN users ON quiz_results.user_id = users.id");
$stmt->execute();
$result = $stmt->get_result();
$results = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Doctor Dashboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Total Questions</th>
                    <th>Correct Answers</th>
                    <th>Time Taken</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['username']); ?></td>
                        <td><?php echo $result['total_questions']; ?></td>
                        <td><?php echo $result['correct_answers']; ?></td>
                        <td><?php echo gmdate("H:i:s", $result['time_taken'] / 1000); ?></td>
                        <td>
                            <button onclick="showDetails(<?php echo htmlspecialchars(json_encode($result['questions_and_answers'])); ?>)">Details</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function showDetails(details) {
            const detailWindow = window.open('', 'Detail Window', 'width=800,height=600');
            detailWindow.document.write('<pre>' + JSON.stringify(JSON.parse(details), null, 2) + '</pre>');
        }
    </script>
</body>
</html>

