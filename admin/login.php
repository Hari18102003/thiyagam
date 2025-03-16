<?php
session_start();
$servername = "localhost";  // Change if needed
$username = "root";  // Your MySQL username
$password = "1810";  // Your MySQL password
$dbname = "thiyagamDB";  // Database name

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user = $_POST['username'];
$pass = $_POST['password'];

// Hash entered password

// Query to check credentials
$sql = "SELECT * FROM User WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Login successful, redirect to new page
    $_SESSION['username'] = $user;
    header("Location: ../dashboard.php");
    exit();
} else {
    echo "Invalid username or password.";
}

// Close connection
$stmt->close();
$conn->close();
?>
