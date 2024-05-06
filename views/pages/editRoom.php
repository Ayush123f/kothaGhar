<?php
session_start();
include("../../config/config_db.php");

const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';
require_once BASE_DIR . "config/config_db.php";
require_once BASE_DIR . "config/functions.php";


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
<div class="signup-page">
    <div class="form">
        <h1>Edit Room </h1>
        <form class="sign-up-form" action="updateRoom.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="RoomId" value="<?php echo $room_details['RoomID']; ?>">

            <input type="text" id="Title" name="Title" placeholder="Title" required value="<?php echo $room_details['Title']; ?>">

            <input type="number" id="NumberOfRooms" name="NumberOfRoom" placeholder="NumberofRooms" required value="<?php echo $room_details['NumberOfRooms']; ?>">

            <input type="number" id="bedroom" name="bedroom" placeholder="bedroom" required value="<?php echo $room_details['Bedroom']; ?>">

            <input type="number" id="livingroom" name="livingroom" placeholder="livingroom" required value="<?php echo $room_details['Livingroom']; ?>">

            <input type="number" id="bathroom" name="bathroom" placeholder="bathroom" required value="<?php echo $room_details['Bathroom']; ?>">

            <input type="number" id="kitchen" name="kitchen" placeholder="kitchen" required value="<?php echo $room_details['Kitchen']; ?>">

            <input type="number" id="price" name="price" placeholder="Price" required value="<?php echo $room_details['Price']; ?>"><br>

            <input type="text" id="location" name="location" placeholder="Location" required value="<?php echo $room_details['Location']; ?>"><br>


            <button type="submit">Submit</button>
        </form>
    </div>
</div>

