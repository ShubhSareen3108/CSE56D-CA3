<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in to create a topic.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO topics (user_id, title) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $title);

    if ($stmt->execute()) {
        header("Location: view_topics.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Topic</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header>
        Forum Header
    </header>

    <div class="container">
        <h1 class="topic-header">Create New Topic</h1>

        <form method="POST" action="create_topic.php">
            <input type="text" name="title" placeholder="Topic Title" required><br>
            <button type="submit">Create Topic</button>
        </form>

        <a href="view_topics.php">Back to Topics</a>
    </div>
</body>
</html>
