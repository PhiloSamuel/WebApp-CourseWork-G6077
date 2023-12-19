<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== "admin") {
    header("Location: admin_login.php"); // Redirect unauthorized access to login page
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SocNet";



// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve evaluation requests from the database
$sql = "SELECT comment, contact_method, image_path FROM evaluation_requests";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Page - Evaluation Requests</title>
</head>
<body>
    <h2>Admin Page - Evaluation Requests</h2>
    <table border="1">
        <tr>
            <th>Comment</th>
            <th>Contact Method</th>
            <th>Image Path</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row['comment']."</td>";
            echo "<td>".$row['contact_method']."</td>";
            // Display image directly within the table cell
            echo "<td><img src='".$row['image_path']."' alt='Image' style='width: 50px;' ></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
