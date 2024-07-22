<?php
// Start or resume a session
session_start();

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
    // Redirect to admin login page if not logged in
    header("Location: admin.html");
    exit;
}

include_once "db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $sql = "UPDATE staff SET name='$name', position='$position', address='$address', contact='$contact' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_staff.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM staff WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: admin_staff.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Staff</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #191c24;
            padding: 20px;
        }

        h2, h3 {
            color: #eb1616;
        }

        a {
            font-size: 15px;
            color: #eb1616;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            text-transform: uppercase;
            color: #eb1616;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        .add-form {
            margin-top: 20px;
        }

        .add-form input {
            padding: 8px;
            width: 200px;
        }

        .add-form button {
            font-weight: bold;
            padding: 8px 16px;
            background-color: #fff;
            color: #eb1616;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-form button:hover {
            background-color: #333;
        }
    </style>
</head>

<body>
    <h2>Manage Staff</h2>

    <!-- Display staff details in a table -->
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Fetch and display staff data from the database -->
            <?php
            $sql = "SELECT * FROM staff";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<form method='POST'>";
                    echo "<td><input type='text' name='name' value='{$row['name']}'></td>";
                    echo "<td><input type='text' name='position' value='{$row['position']}'></td>";
                    echo "<td><input type='text' name='address' value='{$row['address']}'></td>";
                    echo "<td><input type='number' name='contact' value='{$row['contact']}'></td>";
                    echo "<td>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit' name='update'>Update</button>
                        <button type='submit' name='delete'>Delete</button>
                    </td>";
                    echo "</form>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <!-- Form to add new staff -->
    <div class="add-form">
        <h3>Add New Staff</h3>
        <form action="add_staff.php" method="post">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="position" placeholder="Position" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="number" name="contact" placeholder="Contact" required>
            <button type="submit">Add Staff</button>
        </form><br>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>

</html>
