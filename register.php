<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$contact = $_POST['contact'];

// Password complexity check
if (strlen($password) < 8 || !preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/\d/", $password)) {
    die("Password should be at least 8 characters long, contain at least one digit, one lowercase letter, and one uppercase letter.");
}

// Hash password
$password = password_hash($password, PASSWORD_DEFAULT);

// Prepare SQL statement to insert user data into the database
$stmt = $conn->prepare("INSERT INTO SystemUser (username, password, email, contact, verified, verification_code) VALUES (?, ?, ?, ?, ?, ?)");
$verified = 0; // Assuming 0 indicates non-verified status
$verificationCode = generateVerificationCode();
$stmt->bind_param("ssssis", $username, $password, $email, $contact, $verified, $verificationCode);
$stmt->execute();

// configure php mailer and send verify email

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload.php file
require 'vendor/autoload.php'; // Path to PHPMailer's autoload.php

$mail = new PHPMailer(true);

try {
    // SMTP Configuration for Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'philopater.samuel@gmail.com'; // Your Gmail address
    $mail->Password = 'mhhr wema mrzg uurh'; // Your Gmail password or app-specific password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Sender and recipient details
    $mail->setFrom('philopater.samuel@gmail.com', 'Farida Ghanem'); // Sender's email address and name
    $mail->addAddress($email, $username); // Recipient's email and username

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Account Verification';
    $verificationLink = 'http://localhost/WebApp-CourseWork-G6077/verify_email.php?code=' . $verificationCode;
    $mail->Body = "Welcome! Please verify your email by clicking <a href='$verificationLink'>here</a>.";

    // Send email
    $mail->send();
    echo 'Verification email sent successfully.';
} catch (Exception $e) {
    echo 'Error: ' . $mail->ErrorInfo;
}

echo "Account created successfully.";

// Close database connection
$stmt->close();
$conn->close();

// Function to generate a random verification code
function generateVerificationCode() {
    return bin2hex(random_bytes(16));
}
?>
