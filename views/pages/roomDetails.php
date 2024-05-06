<?php
const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';

include("../../config/config_db.php");

// Check if room ID is provided
if (isset($_GET['id'])) {
    $roomId = $_GET['id'];

    // Fetch room details
    $sql = "SELECT * FROM add_room ar 
    LEFT JOIN booked_rooms br ON ar.RoomID = br.room_id 
    WHERE RoomID = $roomId 
    ORDER BY br.id DESC
    LIMIT 1";
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
                    <p class="Bedroom">Bedroom: <?php echo $row['Bedroom'] ?></p>
                    <p class="livingroom">livingroom: <?php echo $row['Livingroom'] ?></p>
                    <p class="Bathroom">Bathroom: <?php echo $row['Bathroom'] ?></p>
                    <p class="Kitchen">Kitchen: <?php echo $row['Kitchen'] ?></p>
                    <p class="location">Location: <?php echo $row['Location'] ?></p>
                    <p class="no-of-rooms">Number of rooms: <?php echo $row['NumberOfRooms'] ?></p>
                    <p class="price">Price: Rs.<?php echo $row['Price'] ?></p>

                    <!-- Check room availability for booking -->
                    <?php
                    if ($row['is_cancelled'] == 1 || $row['is_cancelled'] == null || $row['is_rejected'] == 1 || $row['is_rejected'] == null) {
                        ?>
                        <form class="booking-form" method="post" action="roomDetails.php?id=<?php echo $roomId ?>">
                            <button type="submit" name="book_room" class="book-button">BOOK</button>
                        </form>
                    <?php
                    } else {
                        echo '<p class="availability">Room is not available.</p>';
                    }
                    ?>

                    <!-- Review Section -->
                    <div class="container-fluid">
                      <h2>Review Property:</h2>
                      <div class="well well-sm">
                      <div class="text-right">
                        <!-- Display existing reviews for the room -->
                        <?php
                        $reviewSql = "SELECT * FROM review WHERE room_id = $roomId";
                        $reviewResult = $conn->query($reviewSql);

                        if ($reviewResult->num_rows > 0) {
                            while ($review = $reviewResult->fetch_assoc()) {
                                echo "<p><strong>User:</strong> {$review['reviewby']}</p>";
                                echo "<p><strong>Rating:</strong> {$review['rating']}</p>";
                                echo "<p><strong>Comment:</strong> {$review['comment']}</p>";
                                echo "<hr>";
                            }
                        } else {
                            echo "<p>No reviews yet.</p>";
                        }
                        ?>

                        <!-- Review Form -->
                        <h3>Add Your Review</h3>
                        <form method="post" action="/kothaGhar/views/pages/review.php">
                            <input type="hidden" name="room_id" value="<?php echo $roomId ?>">
                            <label for="rating">Rating:</label>
                            <input type="number" name="rating" id="rating" min="1" max="5" required>
                            <label for="comment">Comment:</label>
                            <textarea name="comment" id="comment" rows="4" required></textarea>
                            <button type="submit">Submit Review</button>
                        </form>
                    </div>
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
