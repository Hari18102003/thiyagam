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

// Fetch data from the Media table
$sql = "SELECT id, year FROM Annual ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thiyagam - Admin Portal</title>
    <link rel="stylesheet" href="styles/dashboard.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #7E02B4;
            color: white;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }

        .edit-btn {
            background-color: #ffc107;
            color: black;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body>
    <nav>
        <h1>Admin Panel</h1>
        <button><a href="index.html">Logout <i class="fa-solid fa-right-from-bracket"></a></i></button>
    </nav>

    <div class="main">
        <div class="sidebar" id="sidebar">
            <ul>
                <li><a href="dashboard.php">Media</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="annualreport.php">Annual Report</a></li>
                <li><a href="award.php">Awards</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="header">
                <h2>Annual Report</h2>
                <button><a href="add-annual.html">Add Annual Report</a></button>
            </div>
            <table>
                <tr>
                    <th>Year</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['year']}</td>
                                <td>
                                    <a href='add-annual.html?id={$row['id']}' class='btn edit-btn'>Edit</a>
                                    <a href='admin/report-delete.php?id={$row['id']}' class='btn delete-btn' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/4373bbb4a8.js" crossorigin="anonymous"></script>
</body>

</html>

<?php
$conn->close();
?>