<?php
// Include database configuration
include("../../config/config_db.php");

// Check if booking ID is provided
if(isset($_GET['booking_id'])) {
    // Sanitize and store the booking ID
    $booking_id = intval($_GET['booking_id']);

    // Prepare SQL statement to update the booking status to cancelled
    $stmt = $conn->prepare("UPDATE booked_rooms SET is_cancelled = 1 WHERE id = ?");
    $stmt->bind_param("i", $booking_id);

    // Execute the SQL statement
    if($stmt->execute()) {
        // If booking cancellation is successful, redirect back to the booking page
        header("Location: ./mybookings.php");
        exit;
    } else {
        // If an error occurs during booking cancellation, display an error message
        echo "Error: Unable to cancel booking.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
