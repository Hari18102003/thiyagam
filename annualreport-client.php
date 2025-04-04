<?php
$servername = "localhost";
$username = "root";
$password = "1810";
$dbname = "thiyagamDB"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch media data
$sql = "SELECT id, year, image FROM Annual ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thiyagam - Annual Reports</title>
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/navbar.css">
    <style>
        .media-container-outer{
            padding: 20px;
        }
        .media-container-outer h1{
            color:#7E02B4;
        }
        .media-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .media-item {
            width: 22%;
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .media-name a {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            font-size: 16px;
            color: #007BFF;
            text-decoration: none;
        }

        .media-name a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1024px) {
            .media-item {
                width: 45%;
            }
        }

        @media (max-width: 768px) {
            .media-item {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div id="navbar-container"></div>
    <div class="media-container-outer">
        <h1>Annual Reports</h1>

        <div class="media-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='media-item'>
                            <div class='media-name'><a href='admin/{$row['image']}' target='_blank'>{$row['year']}</a></div>
                        </div>";
                }
            } else {
                echo "<p>No media found.</p>";
            }
            ?>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/4373bbb4a8.js" crossorigin="anonymous"></script>
    <script src="js/navbarLoader.js"></script>
</body>

</html>

<?php
$conn->close();
?>
