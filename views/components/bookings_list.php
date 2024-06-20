<?php
include ("../../config/config_db.php");

// Function to update approval status in the database
function updateApprovalStatus($roomId, $isApproved, $isRejected, $conn) {
    $stmt = $conn->prepare("UPDATE booked_rooms SET is_approved = ?, is_rejected = ? WHERE room_id = ?");
    $stmt->bind_param("iii", $isApproved, $isRejected, $roomId);
    $stmt->execute();
    $stmt->close();
}

$query = "SELECT * FROM booked_rooms br inner join add_room ar 
on br.room_id = ar.roomID inner join users u 
on br.user_id = u.user_id
order by br.id desc";
$result = $conn->query($query);
?>

<div id="wrapper">
  <h1>Booking Records</h1>
  <table id="keywords" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th><span>ID</span></th>
        <th><span>User name</span></th>
        <th><span>Email</span></th>
        <th><span>Room Title</span></th>
        <th><span>Cancellation Status</span></th>
        <th><span>Approval Status</span></th>
        <th><span>Completion Status</span></th>
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
          echo '<td>' . ($room_details['is_cancelled'] == 1 ? 'Yes' : 'No') . '</td>';
          echo '<td>';
          // Check if room is approved or rejected
          if ($room_details['is_approved'] == 1) {
            echo 'Approved';
          } elseif ($room_details['is_rejected'] == 1) {
            echo 'Rejected';
          } elseif ($room_details['is_cancelled'] == 1) {
            echo '-';
          } else {
            // If not approved or rejected, display approve and reject buttons
            echo '<button class="approve-button" data-room-id="' . $room_details['id'] . '">Approve</button>';
            echo '<button class="reject-button" data-room-id="' . $room_details['id'] . '">Reject</button>';
          }
          echo '</td>';
          echo '<td>';
          // Check if room is approved or rejected
          if ($room_details['is_completed'] == 1) {
            echo 'Completed';
          } else {
            // If not approved or rejected, display approve and reject buttons
            echo '<button class="complete-button" data-room-id="' . $room_details['id'] . '">Complete</button>';
           
          }
          echo '</td>';
          echo '</tr>';
        }
      }

      // Close the database connection
      $conn->close();
      ?>
    </tbody>
  </table>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const approveButtons = document.querySelectorAll('.approve-button');
    const rejectButtons = document.querySelectorAll('.reject-button');
    const completeButtons = document.querySelectorAll('.complete-button');

    approveButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        const roomId = this.getAttribute('data-room-id');
        if (!confirm('Are you sure you want to approve this booking?')) {
          return;
        }
        // If user confirms, update approval status in the database
        updateStatus(roomId, true, false);
      });
    }); 

    rejectButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        const roomId = this.getAttribute('data-room-id');
        if (!confirm('Are you sure you want to reject this booking?')) {
          return;
        }
        // If user confirms, update rejection status in the database
        updateStatus(roomId, false, true);
      });
    });

    completeButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        const roomId = this.getAttribute('data-room-id');
        if (!confirm('Are you sure you want to complete this booking?')) {
          return;
        }
        // If user confirms, update rejection status in the database
        updateCompleteStatus(roomId, true);
      });
    });

    function updateStatus(roomId, isApproved, isRejected) {
      fetch('update_approval.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          roomId: roomId,
          isApproved: isApproved,
          isRejected: isRejected
        }),
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to update approval status');
        }
        // Success message or additional actions if needed
        console.log('Approval status updated successfully');
        // Reload the page to reflect the changes
        location.reload();
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }

    function updateCompleteStatus(roomId, isCompleted) {
      fetch('update_approval.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          roomId: roomId,
          isCompleted: isCompleted,
        }),
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Failed to update completion status');
        }
        // Success message or additional actions if needed
        console.log('Completion status updated successfully');
        // Reload the page to reflect the changes
        location.reload();
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }
  });
</script>
