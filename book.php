<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is authenticated (logged in)
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo "User not authenticated.";
    exit();
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = ""; // SQL password
    $database = "sizzling"; // database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve booking details from POST data
    $service_id = $_POST["service"];
    $date = $_POST["date"];
    $time = $_POST["time"];

    // Retrieve user data from session
    $user_id = $_SESSION['user_id'];

    // Retrieve user details (fullname) based on user_id
    $stmt_user = $conn->prepare("SELECT fullname FROM users WHERE id = ?");
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $stmt_user->bind_result($fullname);
    $stmt_user->fetch();
    $stmt_user->close();

    // Retrieve service details (name and price) based on service_id
    $stmt_service = $conn->prepare("SELECT name, price FROM services WHERE id = ?");
    $stmt_service->bind_param("i", $service_id);
    $stmt_service->execute();
    $stmt_service->bind_result($service_name, $price);

    // Fetch service details
    if ($stmt_service->fetch()) {
        $stmt_service->close();

        // Insert booking data into the database
        $stmt_insert = $conn->prepare("INSERT INTO bookings (user_id, service_name, booking_date, booking_time, price) VALUES (?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("issss", $user_id, $service_name, $date, $time, $price);

        if ($stmt_insert->execute()) {
            // Check if action is download for PDF generation
            if (isset($_GET['action']) && $_GET['action'] === 'download') {
                // Generate PDF receipt
                require('./fpdf186/fpdf.php');

                // Clear the output buffer to avoid any issues
                ob_clean();

                // Create new PDF document
                $pdf = new FPDF('P','mn','A4');
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 16);

                // Set logo (JPEG format)
                $logo = './images/logo.jpg'; // Update with the actual path to your JPEG logo
                if (file_exists($logo)) {
                    $pdf->Image($logo, 10, 10, 40);
                } else {
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Cell(0, 10, 'Logo file not found: ' . $logo, 0, 1);
                }

                // Construct receipt content
                $pdf->Cell(0, 10, 'Booking Receipt', 0, 1, 'C');
                $pdf->Ln();

                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(0, 10, 'Full Name: ' . $fullname, 0, 1);
                $pdf->Cell(0, 10, 'Service: ' . $service_name, 0, 1);
                $pdf->Cell(0, 10, 'Date: ' . $date, 0, 1);
                $pdf->Cell(0, 10, 'Time: ' . $time, 0, 1);
                $pdf->Cell(0, 10, 'Price: ' . $price, 0, 1);

                // Output PDF
                $pdf->Output('D', 'booking_receipt.pdf');

                exit(); // Ensure no further output
            } else {
                echo "Booking successful!";
            }

            $stmt_insert->close();
            $conn->close();
        }
    }
}
?>
