<?php
include ("config/config_db.php");
?>
<style>
  .card-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 40px;
    justify-content: space-between;
  }

  .card {
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px;
    overflow: hidden;
  }

  .card img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 10px;
  }

  .card h4 {
    font-size: 18px;
    margin-bottom: 5px;
  }

  .card p {
    margin-bottom: 5px;
  }
</style>


<?php
include ("config/config_db.php");

// Check if the ID parameter is set in the URL
//if (isset($_GET['id'])) {
// Sanitize the ID parameter to prevent SQL injection
// $room_id = $conn->real_escape_string($_GET['room_id']);

// Query to fetch the record based on the provided ID

include ("config/config_db.php");

$query = "SELECT * FROM add_room";

if (isset($_GET['search']) && !empty($_GET['search'])) {
  if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $query = "SELECT * FROM add_room WHERE CONCAT(Title, Location) LIKE '%$search%'";
  }
}

$result = $conn->query($query);

// Check if the query returned any results
echo "<div class='card-container'>";
if ($result->num_rows > 0) {
  // Loop through each row and display room details
  while ($room_details = $result->fetch_assoc()) {
    echo <<<HTML
    <div class="card">
        <img class="image" src="{$room_details['ImagePath']}" alt="Room Image">
        <h4><b>{$room_details['Title']}</b></h4>
        <!-- <p>Number of Rooms: {$room_details['NumberOfRooms']}</p>
        <p>Price: {$room_details['Price']}</p> -->
        <p>Location: {$room_details['Location']}</p>
        <a href="views/pages/roomDetails.php?id={$room_details['RoomID']}"><button type="button">View</button></a>
    </div>
    HTML;
    
  }
} else {
  // If the query didn't return any results, display an error message
  echo 'Error: No rooms found.';
}
echo "</div>";

// Close the database connection
$conn->close();
?>