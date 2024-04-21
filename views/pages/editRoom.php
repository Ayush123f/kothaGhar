<?php
session_start();
include("../../config/config_db.php");

// Check if the user is not authenticated, redirect to login
if (!isset($_SESSION['user'])) {
    header("Location: /kothaGhar/views/pages/Login.php");
    exit();
}

// Check if the RoomID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: /kothaGhar/views/pages/roomList.php"); // Redirect to room list if RoomID is not provided
    exit();
}

$roomId = $_GET['id'];

// Fetch room details from the database based on RoomID
$query = "SELECT * FROM add_room WHERE RoomID = $roomId";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $room_details = $result->fetch_assoc();
} else {
    echo 'Error: Room not found.';
    exit();
}

// Now you can use $room_details array to populate the edit form
// Add your HTML and form elements here to allow users to edit room details
?>

<!-- Your HTML code for the edit room form goes here -->
<!-- Start of the HTML form for editing room details -->
<div id="wrapper">
    <h1>Edit Room Details</h1>
    
    <form action="updateRoom.php" method="POST"> <!-- Assuming you have an update script named updateRoom.php -->
        <input type="hidden" name="RoomId" value="<?php echo $room_details['RoomID']; ?>"> <!-- Hidden input field to pass RoomID -->
        
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $room_details['Title']; ?>"><br>
        
        <label for="numberOfRooms">Number of Rooms:</label>
        <input type="number" id="numberOfRooms" name="numberOfRooms" value="<?php echo $room_details['NumberOfRooms']; ?>"><br>
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo $room_details['Price']; ?>"><br>
        
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo $room_details['Location']; ?>"><br>
        
        <button type="submit">Update</button>
    </form>
</div>

