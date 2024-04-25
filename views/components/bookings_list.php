<?php
include ("../../config/config_db.php");

// Function to update verification status in the database
function updateVerificationStatus($roomId, $isVerified, $conn) {
    $stmt = $conn->prepare("UPDATE booked_rooms SET is_verified = ? WHERE room_id = ?");
    $stmt->bind_param("ii", $isVerified, $roomId);
    $stmt->execute();
    $stmt->close();
}

$query = "SELECT * FROM booked_rooms br inner join add_room ar on br.room_id = ar.roomID inner join users u on br.user_id = u.user_id";
$result = $conn->query($query);
?>

<div id="wrapper">
  <h1>Record of Rooms</h1>
  <table id="keywords" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th><span>ID</span></th>
        <th><span>User name</span></th>
        <th><span>Email</span></th>
        <th><span>Room Title</span></th>
        <th><span>Verification Status</span></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
        // Loop through each row and display room details
        while ($room_details = $result->fetch_assoc()) {
          echo '<tr>';
          echo '<td>' . $room_details['id'] . '</td>';
          echo '<td>' . $room_details['full_name'] . '</td>';
          echo '<td>' . $room_details['email'] . '</td>';
          echo '<td>' . $room_details['Title'] . '</td>';
          echo '<td>';
          echo '<label class="switch">';
          echo '<input type="checkbox" class="verification-checkbox" data-room-id="' . $room_details['room_id'] . '" ' . ($room_details['is_verified'] == 1 ? 'checked' : '') . '>';
          echo '<span class="slider"></span>';
          echo '</label>';
          echo '</td>';
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
    const checkboxes = document.querySelectorAll('.verification-checkbox');
    checkboxes.forEach(function(checkbox) {
      checkbox.addEventListener('click', function() {
        const roomId = this.getAttribute('data-room-id');
        const isVerified = this.checked ? 1 : 0;
        if (!confirm('Are you sure you want to change the verification status?')) {
          // Revert checkbox state if user cancels
          this.checked = !this.checked;
          return;
        }
        // If user confirms, update verification status in the database
        fetch('update_verification.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            roomId: roomId,
            isVerified: isVerified
          }),
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to update verification status');
          }
          // Success message or additional actions if needed
          console.log('Verification status updated successfully');
        })
        .catch(error => {
          console.error('Error:', error);
          // Revert checkbox state if there's an error
          this.checked = !this.checked;
        });
      });
    });
  });
</script>
