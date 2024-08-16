<?php
session_start(); // Start or resume existing session

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "sizzling";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Valid credentials, set user_id in session
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $stmt->close();
        $conn->close();
        header("Location: dashboard.php"); // Redirect to dashboard
        exit(); // Ensure no further script execution
    } else {
        // Invalid credentials
        echo "Invalid email or password.";
    }

    $stmt->close();
}

$conn->close();
?>
