<?php
$servername = "localhost";
$username = "root";
$password = "1810";
$dbname = "thiyagamDB"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $name = $_POST['name'];
    $date = $_POST['date'];

    // Fetch current image to check if a new one is uploaded
    $sql = "SELECT image FROM Gallery WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $currentImage = $row['image'];

    // Handle Image Upload
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "gallery/";
        $newImageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $newImageName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allow specific file formats
        $allowedTypes = array("jpg", "png", "jpeg", "gif");
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // Delete old image
                if ($currentImage && file_exists($targetDir . $currentImage)) {
                    unlink($targetDir . $currentImage);
                }
                $currentImage = $newImageName; // Update image name for DB
            }
        }
    }

    // Update Media Record
    $updateSQL = "UPDATE Gallery SET title=?, name=?, date=?, image=? WHERE id=?";
    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bind_param("ssssi", $title, $name, $date, $currentImage, $id);

    if ($updateStmt->execute()) {
        echo "<script>alert('Media updated successfully!'); window.location.href='../gallery.php';</script>";
    } else {
        echo "<script>alert('Error updating media!'); window.history.back();</script>";
    }

    $updateStmt->close();
}

$conn->close();
?>
