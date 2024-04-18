<?php
// Database details
$host = 'localhost';
$user = 'root';
$pass = '';
$conn   = 'room_rental';

// Connect to the database
$conn = new mysqli($host, $user, $pass, $conn);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch room data
$sql = "SELECT * FROM add_room";
$result = $conn->query($sql);

// Display records in HTML format
if ($result->num_rows > 0) {
    echo '<section class="card-section">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo '<img src="' . $row['ImagePath'] . '" alt="' . $row['Title'] . '" style="width:100%">';
        echo '<h3 class="title">' . $row['Title'] . '</h3>';
        echo '<p class="price">Rs.' . $row['Price'] . '</p>';
				echo '<a href="roomDetails.php?id=' . $row['RoomID'] . '"><button>View room</button></a>';


        echo '</div>';
    }
    echo '</section>';
} else {
    echo 'No rooms found.';
}

// Close database connection
$conn->close();
?>


