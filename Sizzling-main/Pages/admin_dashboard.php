<?php
// Start or resume a session
session_start();

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
    // Redirect to admin login page if not logged in
    header("Location: admin.html");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="icon" href="./images/icons8-scissor-64.png" type="image/x-icon">
    <style>
        *{
            font-family: "Oswald", sans-serif;
        }
        body {
            background-image: url("./images/carousel-2.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            /* opacity: 0.5; */
            background-color: #191c24;
            padding: 20px;
        }

        h2 {
            text-transform: uppercase;
            color: #eb1616
        }

        .dashboard-btns {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 130px;
        }

        .dashboard-btn {
            font-weight: bolder;
            font-size: 20px;
            padding: 10px 20px;
            background-color: #fff;
            color: #eb1616;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dashboard-btn:hover {
            color: #191c24;
            background-color:#eb1616 ;
        }
    </style>
</head>

<body>
    <h2>Welcome Admin</h2>

    <div class="dashboard-btns">
        <button class="dashboard-btn" onclick="window.location.href='admin_staff.php'">Manage Staff</button>
        <button class="dashboard-btn" onclick="window.location.href='admin_services.php'">Manage Services</button>
    </div>

    <a href="admin_logout.php" style=" font-size: 20px; display: block; margin-top: 20px; text-align: center; color: #eb1616; text-decoration: underline;">Logout</a>
</body>

</html>
