<?php
const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';

include ("../../config/config_db.php");

// Check if room ID is provided
if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    $sql = "SELECT * FROM add_room ar LEFT JOIN booked_rooms br ON ar.RoomID = br.room_id WHERE RoomID = $roomId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="room-details-container">
                <div class="room-image">
                    <img src="<?php echo $row['ImagePath'] ?>" alt="<?php echo $row['Title'] ?>">
                </div>
                <div class="room-details">
                    <h2 class="title"><?php echo $row['Title'] ?></h2>
                    <p class="location">Location: <?php echo $row['Location'] ?></p>
                    <p class="no-of-rooms">Number of rooms: <?php echo $row['NumberOfRooms'] ?></p>
                    <p class="price">Price: Rs.<?php echo $row['Price'] ?></p>

                    <?php
                    // Check if the room is cancelled or not booked
                    if ($row['is_cancelled'] == true || $row['id'] == null) {
                        // Display the book button only if the room is cancelled or not booked
                        ?>
                        <form class="booking-form" method="post" action="roomDetails.php?id=<?php echo $roomId ?>">
                            <button type="submit" name="book_room" class="book-button">BOOK</button>
                        </form>
                        <?php
                    } else {
                        echo '<p class="availability">Room is not available.</p>';
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    } else {
        echo '<p class="error">Room not found.</p>';
    }
} else {
    echo '<p class="error">Room ID not provided.</p>';
}

// Handle booking submission
if (isset($_POST['book_room'])) {
    if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['id'];
        $room_id = $roomId;
        $sql = "INSERT INTO booked_rooms (user_id, room_id) VALUES ('$user_id', '$room_id')";
        if (mysqli_query($conn, $sql)) {
            echo '<script type="text/JavaScript">';
            echo 'alert("Booked Successfully")';
            echo '</script>';
        } else {
            echo '<p class="error">Error: ' . mysqli_error($conn) . '</p>';
        }
    } else {
        echo '<p class="error">You need to login to book a room.</p>';
    }
}

$conn->close();

require_once BASE_DIR . 'views/components/footer.php';
?>