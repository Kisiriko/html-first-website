<?php
//  Database Connection Settings 
$host = "localhost";
$username = "root";
$password = "";
$database = "sacco_db";

//  Connect to MySQL 
$conn = new mysqli($host, $username, $password, $database);

//  Checking fr Connection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//  Get and Sanitize Form Inputs 
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

//  Validate Inputs 
if (empty($name) || empty($email) || empty($message)) {
    die("❌ All fields are required.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("❌ Invalid email format.");
}

//  Prepare & Insert into Database 
$stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo "✅ Thank you! Your message has been saved.";
} else {
    echo "❌ Error: " . $stmt->error;
}

//  Clean Up 
$stmt->close();
$conn->close();
?>
