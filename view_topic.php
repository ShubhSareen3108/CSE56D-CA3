<?php
session_start();
include 'config.php';

$topic_id = $_GET['id'];

// Display the topic title
$sql = "SELECT title FROM topics WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$topic = $stmt->get_result()->fetch_assoc();
echo "<h1 class='topic-header'>" . htmlspecialchars($topic['title']) . "</h1>";

// Display all posts in the topic
$sql = "SELECT posts.message, users.username, posts.created_at FROM posts JOIN users ON posts.user_id = users.id WHERE topic_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$posts = $stmt->get_result();

while ($post = $posts->fetch_assoc()) {
    echo "<div class='post-message'>
            <p><strong class='post-author'>" . htmlspecialchars($post['username']) . ":</strong> " . htmlspecialchars($post['message']) . " <span class='post-time'>- " . $post['created_at'] . "</span></p>
          </div>";
}

// Add a new post
if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO posts (topic_id, user_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $topic_id, $user_id, $message);
    if ($stmt->execute()) {
        header("Location: view_topic.php?id=$topic_id");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="POST" action="">
    <textarea name="message" required></textarea><br>
    <button type="submit">Post Message</button>
</form>

<a href="view_topics.php">Back to Topics</a>
<link rel="stylesheet" href="main.css">
