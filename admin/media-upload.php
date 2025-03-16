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
    $title = $_POST['title'];
    $name = $_POST['name'];
    $date = $_POST['date'];

    // Handling Image Upload
    $target_dir = "media/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . uniqid() . "_" . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ["jpg", "jpeg", "png", "gif"];

    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Store data in database
            $sql = "INSERT INTO Media (title, name, image, date) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $title, $name, $target_file, $date);
            if ($stmt->execute()) {
                echo "<script>alert('Media uploaded successfully!'); window.location.href='../dashboard.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error uploading file.');</script>";
        }
    } else {
        echo "<script>alert('Invalid file format. Only JPG, JPEG, PNG & GIF allowed.');</script>";
    }
}
$conn->close();
?>
