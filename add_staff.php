<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin.html");
    exit;
}

include_once "db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO staff (name, position, address, contact) VALUES ('$name', '$position', '$address', '$contact')";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_staff.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
