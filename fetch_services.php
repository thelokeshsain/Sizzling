<?php
// Include database connection file
include_once "db_config.php";

// Fetch service data
$sql = "SELECT * FROM services";
$result = $conn->query($sql);

// Initialize service list array
$serviceList = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $serviceList[] = $row;
    }
}

// Output service data as JSON
header('Content-Type: application/json');
echo json_encode($serviceList);
?>
