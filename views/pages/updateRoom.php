<?php
// Start the session and include the database configuration file
session_start();
include ("../../config/config_db.php");

// Check if the user is authenticated, otherwise redirect to the login page
if (!isset($_SESSION['user'])) {
    header("Location: /kothaGhar/views/pages/Login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $roomId = $_POST['RoomId'];
    $title = $_POST['Title'];
    $numberOfRooms = $_POST['NumberOfRoom'];
    $bedroom = $_POST['bedroom'];
    $livingroom = $_POST['livingroom'];
    $bathroom = $_POST['bathroom'];
    $kitchen = $_POST['kitchen'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    // $is_booked =$_POST['is_booked'];

    // Perform validation (optional)

    // Update the room details in the database
    $query = "UPDATE add_room 
    SET Title='$title', NumberOfRooms='$numberOfRooms', 
    Price='$price', Location='$location', Bedroom='$bedroom', 
    Livingroom='$livingroom', Bathroom='$bathroom', Kitchen='$kitchen'
    -- is_booked='$is_booked'
    WHERE RoomID='$roomId'
    ";
    $result = $conn->query($query);

    // Check if the update was successful
    if ($result === TRUE) {
        // Redirect the user back to the room list page
        header("Location: /kothaGhar/views/pages/roomList.php");
        exit();
    } else {
        // If the update fails, display an error message
        echo "Error updating room details: " . $conn->error;
    }
}
?>