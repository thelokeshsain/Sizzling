<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin.html");
    exit;
}

include_once "db_config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM staff WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_staff.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
