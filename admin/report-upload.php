<?php
$servername = "localhost";
$username = "root"; // Change this according to your DB credentials
$password = "1810";
$database = "thiyagamDB"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['year'];

    // Handling Image Upload
    $target_dir = "report/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . uniqid() . "_" . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ["pdf", "doc", "docx"];

    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Store data in database
            $sql = "INSERT INTO Annual (year,image) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $title, $target_file);
            if ($stmt->execute()) {
                echo "<script>alert('Media uploaded successfully!'); window.location.href='../annualreport.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error uploading file.');</script>";
        }
    } else {
        echo "<script>alert('Invalid file format. PDF,DOCS & DOCX allowed.');</script>";
    }
}
$conn->close();
?>
