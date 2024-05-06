<?php
session_start();

include("../../config/config_db.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data and sanitize
  $user_id = $_SESSION["user"]["id"];
  $rating = mysqli_real_escape_string($conn, $_POST["rating"]);
  $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
  $room_id = mysqli_real_escape_string($conn, $_POST["room_id"]);

  // Update profile data in the database
  $sql = "INSERT INTO REVIEW (reviewby, rating, comment, room_id) VALUES ('$user_id', '$rating', '$comment', '$room_id')";
  if (mysqli_query($conn, $sql)) {
    // Profile updated successfully
    $_SESSION["success_message"] = "Feedback updated successfully.";
  } else {
    // Error updating profile
    $_SESSION["error_message"] = "Error providing feedback: " . mysqli_error($db);
  }

  // Redirect back to tenant profile page
  header("location:/kothaGhar/views/pages/roomDetails.php?id={$room_id}");
  exit; // Stop further execution
} else {
  // If the form was not submitted, redirect to tenant profile page
  header("location:/kothaGhar/views/pages/roomDetails.php?id={$room_id}");
  exit; // Stop further execution
}
?>