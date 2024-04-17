<!-- <div id="roomInfoOverlay" class="">
  <div  class="roomInfoWrapper">
    <button id="roomInfoOverlay-close-btn" onclick="toggleOverlay()">Close</button>
    <div class="room-images">
    <div class="info">
      <h2 id="title">
      </h2>
  
      <a id="location" > </a>

      <p id="no-of-rooms"></p>
    
      <p id="price"></p>
      <button>BOOK</button>
    </div>
    <img src="../../images/kitchen.jpg"  alt="" />

  </div>
</div> -->

<?php
// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    // Sanitize the ID parameter to prevent SQL injection
    $room_id = $conn->real_escape_string($_GET['id']);

    // Query to fetch the record based on the provided ID
    $query = "SELECT * FROM rooms WHERE RoomID = $room_id";
    $result = $conn->query($query);

    // Check if the query returned any results
    if ($result->num_rows > 0) {
        // Fetch room details as an associative array
        $room_details = $result->fetch_assoc();

        // Display the room details
        echo '<h2>' . $room_details['Title'] . '</h2>';
        echo '<p>Number of Rooms: ' . $room_details['NumberOfRooms'] . '</p>';
        echo '<p>Price: $' . $room_details['Price'] . '</p>';
        echo '<p>Location: ' . $room_details['Location'] . '</p>';
        echo '<img src="' . $room_details['ImagePath'] . '" alt="Room Image">';
    } else {
        // If the query didn't return any results, display an error message
        echo 'Error: Room not found.';
    }
} else {
    // If the ID parameter is not set, display an error message or redirect to another page
    echo 'Error: Room ID not provided.';
}

// Close the database connection
$conn->close();
?>





