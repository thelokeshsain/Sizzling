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

// Add New Service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_service"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $image = $_FILES["image"];

    // Check if file was uploaded without errors
    if ($image["error"] === UPLOAD_ERR_OK) {
        $tmpName = $image["tmp_name"];
        $fileName = basename($image["name"]);
        $targetDir = "uploads/";
        $targetPath = $targetDir . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmpName, $targetPath)) {
            // Insert new service into the database with the image path
            $insertSql = "INSERT INTO services (name, description, price, image_url) VALUES ('$name', '$description', $price, '$targetPath')";
            if ($conn->query($insertSql) === TRUE) {
                // Service added successfully
                header("Location: admin_services.php");
                exit;
            } else {
                echo "Error adding new service: " . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "File upload error: " . $image["error"];
    }
}

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Services</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: "Oswald", sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #191c24;
            color: #6c7293;
            padding-top: 60px;
        }
        a{
            /* text-decoration: none; */
            font-size: 15px;
            color: #eb1616;
        }
        .container {
            margin: 0 auto;
            padding: 0 20px;
        }

        h2 {
            color: #eb1616;
            margin-bottom: 20px;
        }

        .service-item {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .service-item img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            margin-top: 10px;
            object-fit: cover;
            max-height: 200px;
        }

        .service-item h3 {
            color: #6c7293;
            margin-bottom: 10px;
        }

        .service-item p {
            color: #666;
            font-size: 20px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .service-item .actions {
            display: flex;
            justify-content: space-between;
        }

        .service-item form {
            display: inline;
        }

        form button {
            font-size: 16px;
            background-color: #eb1616;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        form button:hover {
            background-color: #000000;
        }

        .add-form {
            margin-top: 20px;
        }

        .add-form input {
            padding: 8px;
            width: 50%;
            margin-bottom: 10px;
        }

        .add-form button {
            font-size: 16px;
            background-color: #eb1616;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .add-form button:hover {
            background-color: #000000;
        }
        .service-grid {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Admin Services</h2>
        <a href="admin_dashboard.php">Back to Dashboard</a>

        <!-- Display existing services -->
        <div class="service-grid" id="servicesContainer">
        <?php foreach ($serviceList as $service) : ?>
            <div class="service-item">
                <h3><?php echo $service["name"]; ?></h3>
                <p><?php echo $service["description"]; ?></p>
                <img src="<?php echo $service["image_url"]; ?>" alt="<?php echo $service["name"]; ?>">
                <h2><?php echo "₹".$service["price"]; ?></h2>
                <div class="actions">
                    <form action="edit_service.php" method="post">
                        <input type="hidden" name="service_id" value="<?php echo $service["id"]; ?>">
                        <button type="submit">Edit</button>
                    </form>
                    <form action="delete_service.php" method="post">
                        <input type="hidden" name="service_id" value="<?php echo $service["id"]; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

        <!-- Form to add new service -->
        <div class="add-form">
            <h3>Add New Service</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Service Name" required>
                <input type="text" name="description" placeholder="Description" required>
                <input type="number" name="price" placeholder="Price" step="0.01" required>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit" name="add_service">Add Service</button>
            </form>
        </div>
    </div>
</body>

</html>
