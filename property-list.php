
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 100%;
  min-width: 100%;
  margin: auto;
  text-align: center;
  font-family: arial;
  display: inline;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  opacity: 0.8;
}

.container {
  padding: 2px 16px;
}

.btn {
  width: 100%;
}

.image {
  min-width: 100%;
  min-height: 200px;
  max-width: 100%;
  max-height:200px;
}
</style>
</head>
<body>

<?php

// Check if the ID parameter is set in the URL
//if (isset($_GET['id'])) {
    // Sanitize the ID parameter to prevent SQL injection
    // $room_id = $conn->real_escape_string($_GET['room_id']);

    // Query to fetch the record based on the provided ID
    
    include("config/config_db.php");
    
    $query = "SELECT * FROM add_room";
    $result = $conn->query($query);

    // Check if the query returned any results
    if ($result->num_rows > 0) {
        // Loop through each row and display room details
        while ($room_details = $result->fetch_assoc()) {
            echo '<div class="card">';
            echo '<img class="image" src="' . $room_details['ImagePath'] . '" alt="Room Image">';
            echo '<div class="container">';
            echo '<h4><b>' . $room_details['Title'] . '</b></h4>';
            echo '<p>Number of Rooms: ' . $room_details['NumberOfRooms'] . '</p>';
            echo '<p>Price: $' . $room_details['Price'] . '</p>';
            echo '<p>Location: ' . $room_details['Location'] . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        // If the query didn't return any results, display an error message
        echo 'Error: No rooms found.';
    }
    
    // Close the database connection
    $conn->close();
    ?>
    

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 100%;
  min-width: 100%;
  margin: auto;
  text-align: center;
  font-family: arial;
  display: inline;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  opacity: 0.8;
}

.container {
  padding: 2px 16px;
}

.btn {
  width: 100%;
}

.image {
  min-width: 100%;
  min-height: 200px;
  max-width: 100%;
  max-height:200px;
}
</style>
</head>
<body>

<!-- Your index page content here -->

</body>
</html>



