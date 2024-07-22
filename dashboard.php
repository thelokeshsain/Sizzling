<?php
session_start(); // Resume existing session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

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

// Retrieve user details from the database based on session user_id
$user_id = $_SESSION['user_id'];

// Prepare SQL statement to fetch user details
$stmt_user = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
} else {
    echo "User not found.";
}

// Prepare SQL statement to fetch booking details for the user
$stmt_booking = $conn->prepare("SELECT * FROM bookings WHERE user_id = ?");
$stmt_booking->bind_param("i", $user_id);
$stmt_booking->execute();
$result_booking = $stmt_booking->get_result();

$bookings = [];
if ($result_booking->num_rows > 0) {
    while ($row = $result_booking->fetch_assoc()) {
        $bookings[] = $row;
    }
}

$stmt_user->close();
$stmt_booking->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Sizzling</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="style.css"> Include your custom styles here -->
    <link rel="icon" href="./images/icons8-scissor-64.png" type="image/x-icon">
   <style>
        /* Reset default margin and padding */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Oswald', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Container styles */
        .container {
            max-width: 100%;
            margin: 0 auto;
            /* padding: 20px; */
        }

        /* Navbar styles */
        .navbar {
            background-color: #191c24;
            color: #fff;
            padding: 20px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            text-decoration: none;
            color: #6c7293;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 20px;
            transition: color 0.3s ease;
            margin-left: 20px;
        }

        .navbar a:hover {
            color: #eb1616;
        }
        .logo {
  display: flex;
  align-items: center;
}

.logo i {
  color: #eb1616;
  font-size: 20px;
  margin-right: 5px;
}

.logo span {
  font-weight: bold;
  color: #eb1616;
  font-size: 20px;
}
        /* User details section */
        .user-details {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .user-details h2 {
            color: #eb1616;
            margin-bottom: 10px;
        }

        .user-details p {
            margin-bottom: 10px;
            font-size: 16px;
        }
        .user-details a{
            background-color: #eb1616;
            text-decoration: none;
            font-size: 20px;
            padding: 10px;
            color:#fff;
            border-radius: 10px;
            margin-left:800px ;
        }
        /* Booking section */
        .booking-section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .booking-section h3 {
            color: #eb1616;
            margin-bottom: 10px;
        }

        .booking-table {
            width: 100%;
            border-collapse: collapse;
        }

        .booking-table th, .booking-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .booking-table th {
            background-color: #f2f2f2;
            color: #333;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="index.html"><i class="fa fa-cut me-3"></i><span>SIZZLING</span></a>
            </div>
            <!-- <div class="nav-links"> -->
                <!-- <a href="dashboard.php" class="active">Home</a> -->
                <!-- <a href="about.html">About</a> -->
                <!-- <a href="login.html">Login</a> -->
                <a href="logout.php">Logout</a>
                <!-- <a href="registration.html">Registration</a> -->
                <!-- <a href="admin.html">Admin</a> -->
            <!-- </div> -->
        </div>
        
        <div class="user-details">
            <h2>Welcome, <?php echo $user['fullname']; ?></h2>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>Gender: <?php echo $user['gender']; ?></p>
            <p>Phone: <?php echo $user['phone']; ?></p>
            <p>Address: <?php echo $user['address']; ?></p>
            <a href="booking.html">Book</a>
        </div>

        <div class="booking-section">
            <h3>Booking Details:</h3>
            <?php if (count($bookings) > 0): ?>
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo $booking['service_name']; ?></td>
                        <td><?php echo $booking['booking_date']; ?></td>
                        <td><?php echo $booking['booking_time']; ?></td>
                        <td>₹<?php echo $booking['price']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No bookings found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
