<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aname = $_POST["aname"]; // Retrieve username from $_POST["aname"]
    $pass = $_POST["pass"]; // Retrieve password from $_POST["pass"]

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

    // Prepare and execute SQL statement to retrieve admin credentials
    $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $aname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Admin found, verify password
        $admin = $result->fetch_assoc();
        $stored_password = $admin['password'];

        if ($pass === $stored_password) {
            // Password is correct, set admin_id in session
            $_SESSION["admin_id"] = $admin['id'];
            $stmt->close();
            $conn->close();
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid password.";
        }
    } else {
        // Admin not found
        echo "Admin not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
