<?php
// Include database connection file
include_once "db_config.php";

// Process form data upon submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addService"])) {
    // Retrieve form data
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // Handle image upload
    $image = $_FILES["image"]["name"];
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($image);

    // Check if image file is valid
    $validExtensions = ["jpg", "jpeg", "png", "gif"];
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (in_array($imageFileType, $validExtensions)) {
        // Move uploaded image to target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Insert service data into database
            $sql = "INSERT INTO services (name, description, price, image_url) 
                    VALUES ('$name', '$description', $price, '$targetFile')";
            
            if ($conn->query($sql) === TRUE) {
                // Service added successfully
                header("Location: admin_services.php");
                exit;
            } else {
                // Error inserting service
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading image.";
        }
    } else {
        echo "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
}
?>
