<?php
const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';

include("../../config/config_db.php");

if(isset($_GET['id'])) {
    $roomId = $_GET['id'];

    $sql = "SELECT * FROM add_room ar LEFT JOIN booked_rooms br ON ar.RoomID = br.room_id WHERE RoomID = $roomId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
            ?>
            <h2 id="title"><?php echo $row['Title'] ?> </h2>
            <p id="location">Location: <?php echo $row['Location'] ?></p>
            <p id="no-of-rooms">Number of rooms: <?php echo $row['NumberOfRooms'] ?></p>
            <p id="price">Price: Rs.<?php echo $row['Price'] ?></p>
            <?php
            // Check if the room is cancelled or not booked
            if ($row['is_cancelled'] == true || $row['id'] == null) {
                // Display the book button only if the room is cancelled or not booked
                echo '<form id="bookingForm" method="post" action="roomDetails.php?id=' . $roomId . '">';
                echo '<button type="submit" name="book_room">BOOK</button>';
                echo '</form>';
            } else {
                echo 'Room is not available.';
            }
            ?>
            <img width="500px" src="<?php echo $row['ImagePath'] ?>" alt="<?php echo $row['Title'] ?>" />
            <?php
        }
    } else {
        echo 'Room not found.';
    }
} else {
    echo 'Room ID not provided.';
}

if(isset($_POST['book_room'])) {
    if(isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']; 
        $room_id = $roomId; 
        $id = $user_id['id'];
        $sql = "INSERT INTO booked_rooms (user_id, room_id) VALUES ('$id', '$room_id')";
        if(mysqli_query($conn, $sql)) {
            echo '<script type="text/JavaScript">';  
            echo 'alert("Booked Successfully")';  
            echo '</script>';  
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "You need to login to book a room."; 
    }
}

$conn->close();

require_once BASE_DIR . 'views/components/footer.php';
?>
