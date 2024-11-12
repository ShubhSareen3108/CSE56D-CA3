<?php
include 'config.php';

$sql = "SELECT topics.id, topics.title, users.username FROM topics JOIN users ON topics.user_id = users.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Topics</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header>
        Forum Header
    </header>

    <div class="container">
        <h1 class="topic-header">Forum Topics</h1>

        <?php while ($row = $result->fetch_assoc()) : ?>
            <a href="view_topic.php?id=<?php echo $row['id']; ?>" class="topic-link">
                <?php echo htmlspecialchars($row['title']); ?> by <?php echo htmlspecialchars($row['username']); ?>
            </a>
        <?php endwhile; ?>

        <a href="create_topic.php" class="create-topic-btn">Create New Topic</a>
    </div>
</body>
</html>
