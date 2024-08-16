<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "sizzling";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"]; // Note: Password is stored in plaintext
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, gender, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullname, $email, $password, $gender, $phone, $address);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful, redirect to login page
        header("Location: login.html");
        exit; // Ensure script stops execution after redirection
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
