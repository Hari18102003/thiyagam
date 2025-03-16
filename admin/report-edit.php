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
    $title = $_POST['year'];

    // Fetch current image to check if a new one is uploaded
    $sql = "SELECT image FROM Annual WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $currentImage = $row['image'];

    // Handle Image Upload
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "report/";
        $newImageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $newImageName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allow specific file formats
        $allowed_types = ["pdf", "doc", "docx"];
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
    $updateSQL = "UPDATE Annual SET year=?, image=? WHERE id=?";
    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bind_param("ssi", $title, $currentImage, $id);

    if ($updateStmt->execute()) {
        echo "<script>alert('Media updated successfully!'); window.location.href='../annualreport.php';</script>";
    } else {
        echo "<script>alert('Error updating media!'); window.history.back();</script>";
    }

    $updateStmt->close();
}

$conn->close();
?>
