<?php
// Start or resume a session
session_start();

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
    // Redirect to admin login page if not logged in
    header("Location: admin.html");
    exit;
}

// Include database connection file
include_once "db_config.php";

// Initialize variables for form data
$serviceName = $serviceDescription = $servicePrice = '';
$serviceImage = '';

// Check if form is submitted for updating
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["service_id"])) {
    // Retrieve service details based on service_id
    $serviceId = $_POST["service_id"];
    
    // Fetch service data from the database
    $sql = "SELECT * FROM services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $serviceId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
        $serviceName = $service["name"];
        $serviceDescription = $service["description"];
        $servicePrice = $service["price"];
        $serviceImage = $service["image_url"];
    } else {
        echo "Service not found.";
    }

    $stmt->close();
}

// Handle form submission to update service details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_service"])) {
    $serviceId = $_POST["service_id"];
    $serviceName = $_POST["name"];
    $serviceDescription = $_POST["description"];
    $servicePrice = $_POST["price"];
    
    // Check if a new image was uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES["image"]["tmp_name"];
        $fileName = basename($_FILES["image"]["name"]);
        $targetDir = "uploads/";
        $targetPath = $targetDir . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmpName, $targetPath)) {
            // Update service with new image path in the database
            $updateSql = "UPDATE services SET name=?, description=?, price=?, image_url=? WHERE id=?";
            $stmt = $conn->prepare($updateSql);

            if ($stmt) {
                // Bind parameters and execute the statement
                $stmt->bind_param("ssdsi", $serviceName, $serviceDescription, $servicePrice, $targetPath, $serviceId);

                if ($stmt->execute()) {
                    // Redirect back to admin services page after successful update
                    header("Location: admin_services.php");
                    exit;
                } else {
                    echo "Error updating service: " . $stmt->error;
                }
            } else {
                echo "Error preparing update statement: " . $conn->error;
            }

            $stmt->close();
        } else {
            echo "Error uploading file.";
        }
    } else {
        // Update service without changing the image
        $updateSql = "UPDATE services SET name=?, description=?, price=? WHERE id=?";
        $stmt = $conn->prepare($updateSql);

        if ($stmt) {
            // Bind parameters and execute the statement
            $stmt->bind_param("ssdi", $serviceName, $serviceDescription, $servicePrice, $serviceId);

            if ($stmt->execute()) {
                // Redirect back to admin services page after successful update
                header("Location: admin_services.php");
                exit;
            } else {
                echo "Error updating service: " . $stmt->error;
            }
        } else {
            echo "Error preparing update statement: " . $conn->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #eb1616;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        img {
            max-width: 300px;
            height: 300px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        button {
            padding: 12px 20px;
            background-color: #eb1616;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Service</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <!-- Hidden input to store service_id -->
            <input type="hidden" name="service_id" value="<?php echo $serviceId; ?>">
            
            <!-- Service Name -->
            <label for="name">Service Name:</label>
            <input type="text" name="name" value="<?php echo $serviceName; ?>" required>
            
            <!-- Service Description -->
            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo $serviceDescription; ?>" required>
            
            <!-- Service Price -->
            <label for="price">Price:</label>
            <input type="number" name="price" value="<?php echo $servicePrice; ?>" step="0.01" required>
            
            <!-- Current Service Image -->
            <label for="image">Current Image:</label><br>
            <img src="<?php echo $serviceImage; ?>" alt="<?php echo $serviceName; ?>"><br>
            
            <!-- Upload New Image -->
            <label for="image">Upload New Image:</label>
            <input type="file" name="image" accept="image/*">
            
            <!-- Submit Button -->
            <button type="submit" name="update_service">Update Service</button>
        </form>
    </div>
</body>

</html>
