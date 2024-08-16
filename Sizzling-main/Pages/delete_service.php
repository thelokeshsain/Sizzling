<?php
// Include database connection file
include_once "db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["service_id"])) {
    $serviceId = $_POST["service_id"];

    // Delete service from the database
    $deleteSql = "DELETE FROM services WHERE id=$serviceId";
    if ($conn->query($deleteSql) === TRUE) {
        // Service deleted successfully
        header("Location: admin_services.php");
        exit;
    } else {
        echo "Error deleting service: " . $conn->error;
    }
}
?>
