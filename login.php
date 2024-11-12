<?php
// login.php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if connection is still open and valid
    if ($conn->ping()) {
        // Prepare the SQL statement
        $sql = "SELECT id, password FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Verify the password
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $stmt->close(); // Close statement
                    header("Location: view_topics.php");
                    exit();
                } else {
                    echo "Invalid password!";
                }
            } else {
                echo "User not found!";
            }

            $stmt->close(); // Close the statement after execution
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Database connection lost.";
    }
}

// Close the connection
$conn->close();
?>

<!-- HTML form for login -->
<form method="POST" action="login.php">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
<link rel="stylesheet" type="text/css" href="main.css">
