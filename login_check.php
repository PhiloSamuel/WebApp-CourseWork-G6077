<?php
session_start();

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

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the user is admin
if ($username === "admin" && $password === "admin") {
    $_SESSION['admin'] = $username;
    header("Location: admin_page.php"); // Redirect admin to admin page
    exit();
}

// Retrieve hashed password from the database for regular users
$stmt = $conn->prepare("SELECT password FROM SystemUser WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Password is correct for a regular user
        $_SESSION['username'] = $username;
        header("Location: home.php"); // Redirect regular user to home page
        exit();
    } else {
        // Password is incorrect for regular user
        echo "Invalid username or password.";
    }
} else {
    // Username not found
    echo "Invalid username or password.";
}

// Close database connection
$stmt->close();
$conn->close();
?>
