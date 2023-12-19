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

// Retrieve verification code from the URL parameter
if (isset($_GET['code'])) {
    $verificationCode = $_GET['code'];

        // Prepare SQL statement to select user by verification code
        $stmt = $conn->prepare("SELECT * FROM SystemUser WHERE verification_code = ?");
        $stmt->bind_param("s", $verificationCode);
        $stmt->execute();
        $result = $stmt->get_result();

        // If a matching verification code is found, update user status
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $userId = $user['ID']; // Assuming 'id' is the primary key of your 'SystemUser' table

        // Update user status as verified (assuming 'verified' is a column in your 'SystemUser' table)
        $updateStmt = $conn->prepare("UPDATE SystemUser SET verified = 1 WHERE ID = ?");
        $updateStmt->bind_param("i", $userId);
        $updateStmt->execute();

        echo "Email verified successfully.";
    } else {
        echo "Invalid verification code.";
    }

    // Close prepared statements
    $stmt->close();
    $updateStmt->close();
}

// Close database connection
$conn->close();
?>
