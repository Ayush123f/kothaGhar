<?php
include ("../../config/config_db.php");

$user_id = $_SESSION['user']['id'];

// Prepare the SQL query using a prepared statement
$query = "SELECT * FROM booked_rooms br INNER JOIN add_room ar ON br.room_id = ar.roomID WHERE br.user_id = ?";
$stmt = $conn->prepare($query);

// Bind the user ID parameter
$stmt->bind_param("i", $user_id);

// Execute the query
$stmt->execute();

// Get the result set
$result = $stmt->get_result();
// $result = $conn->query($query);
?>

<div id="wrapper">
  <h1>My Bookings</h1>
  <table id="keywords" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th><span>ID</span></th>
        <th><span>Room Title</span></th>
        <th><span>Location</span></th>
        <th><span>Price</span></th>
        <th><span>Verification Status</span></th>
        <th><span>Action</span></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
        // Loop through each row and display room details
        while ($room_details = $result->fetch_assoc()) {
          echo '<tr>';
          echo '<td>' . $room_details['id'] . '</td>';
          echo '<td>' . $room_details['Title'] . '</td>';
          echo '<td>' . $room_details['Location'] . '</td>';
          echo '<td>' . $room_details['Price'] . '</td>';
          echo '<td>' . ($room_details['is_verified'] == 1 ? 'Yes' : 'No') . '</td>';
          // Check if booking is cancelled
          if ($room_details['is_cancelled'] == 1) {
            echo '<td>Cancelled</td>';
          } else {
            // Display cancel button if booking is not cancelled
            echo '<td> 
              <button type="button" class="btn btn-default cancel-btn" data-booking-id="' . $room_details['id'] . '">
                Cancel
              </button>  
            </td>';
          }
          echo '</tr>';
        }
      } else {
        // If the query didn't return any results, display an error message
        echo 'Error: No rooms found.';
      }

      // Close the database connection
      $conn->close();
      ?>
    </tbody>
  </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  // Add event listener to cancel buttons
  const cancelButtons = document.querySelectorAll('.cancel-btn');
  cancelButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      const bookingId = this.getAttribute('data-booking-id');
      // Prompt confirmation dialog
      if (confirm('Are you sure you want to cancel this booking?')) {
        // Redirect to cancellation page
        window.location.href = '/kothaGhar/views/pages/booking_cancel.php?booking_id=' + bookingId;
      }
    });
  });
});
</script>