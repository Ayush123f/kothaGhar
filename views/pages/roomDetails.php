<style>
    .review-container {
        margin-top: 20px;
    }

    .review {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 20px;
    }

    .review .user-rating {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .review .star {
        font-size: 20px;
        color: #ccc;
    }

    .review .star.filled {
        color: #ffc107;
        /* Yellow color for filled stars */
    }

    .review .comment {
        margin-top: 5px;
    }

    .no-review {
        font-style: italic;
        color: #999;
        /* Gray color for no reviews message */
    }

    .review-form {
        /* max-width: 500px; */
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .review-form h3 {
        margin-top: 0;
    }

    .review-form .form-group {
        margin-bottom: 15px;
    }

    .review-form label {
        font-weight: bold;
    }

    .review-form input[type="number"],
    .review-form textarea {
        width: 100%;
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .review-form textarea {
        resize: vertical;
    }

    .review-form button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .review-form button:hover {
        background-color: #0056b3;
    }
</style>

<?php
const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';

include ("../../config/config_db.php");

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
                </div>
            </div>
            <div class="review-container">
                <!-- Review Section -->
                <?php 
                if (isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 0) { ?>
                    <div class="review-form">
                        <!-- Review Form -->
                        <h3>Add Your Review</h3>
                        <form method="post" action="/kothaGhar/views/pages/review.php">
                            <input type="hidden" name="room_id" value="<?php echo $roomId ?>">
                            <div class="form-group">
                                <label for="rating">Rating:</label>
                                <input type="number" name="rating" id="rating" min="1" max="5" required>
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <textarea name="comment" id="comment" rows="4" required></textarea>
                            </div>
                            <button type="submit">Post</button>
                        </form>
                    </div>
                <?php } else if (!(isset($_SESSION['user']))) { ?>
                    <p class="error">You need to login to post a review.</p>
                <?php 
                } ?>
                <div class="well well-sm">
                    <!-- Display existing reviews for the room -->
                    <?php
                    $reviewSql = "SELECT * FROM review WHERE room_id = $roomId";
                    $reviewResult = $conn->query($reviewSql);

                    if ($reviewResult->num_rows > 0) {
                        while ($review = $reviewResult->fetch_assoc()) {
                            $userId = $review['reviewby'];
                            $userSql = "SELECT full_name, email FROM users WHERE user_id = $userId";
                            $userResult = $conn->query($userSql);
                            if ($userResult->num_rows > 0) {
                                $user = $userResult->fetch_assoc();
                                $rating = $review['rating'];
                                echo "<div class='review'>";
                                echo "<p class='user-rating'><strong></strong> {$user['full_name']} - {$user['email']} ";
                                // Fill stars based on the rating
                                for ($i = 1; $i <= 5; $i++) {
                                    echo "<span class='star" . ($i <= $rating ? ' filled' : '') . "'>&#9733;</span>";
                                }
                                echo "</p>";
                                echo "<p class='comment'><strong>Comment:</strong> {$review['comment']}</p>";
                                echo "</div>";
                            }
                        }
                    } else {
                        echo "<p class='no-review'>No reviews yet.</p>";
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