<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "form_data_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $contact = htmlspecialchars(strip_tags(trim($_POST['contact'])));

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO form_data (name, email, contact) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $contact);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
