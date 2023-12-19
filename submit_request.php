<?php
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

// Retrieve and sanitize form data
$comment = $_POST['comment'];
$contact = $_POST['contact'];

// File upload handling
$targetDir = "uploads/"; // Directory where uploaded files will be stored
$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Check if file is a valid image (PNG or JPEG)
if ($fileType != "png" && $fileType != "jpeg") {
    echo "Only PNG and JPEG files are allowed.";
    exit;
}

// Move uploaded file to the specified directory
if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
    exit;
}

// Prepare SQL statement to insert data into the database
$stmt = $conn->prepare("INSERT INTO evaluation_requests (comment, contact_method, image_path) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $comment, $contact, $targetFile);
$stmt->execute();

echo "Request submitted successfully.";

// Close database connection
$stmt->close();
$conn->close();
?>
