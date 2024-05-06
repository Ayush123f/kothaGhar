<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
    header("location:/kothaGhar/views/pages/index.php");
    exit; // Stop further execution
}

// Include the database configuration file
include("../../config/config_db.php");

<div class="modal-body">
<form method="POST" action="updateProfile.php">
  <div class="form-group">
    <label for="full_name">Full Name:</label>
    <input type="hidden" value="<?php echo $rows['user_id']; ?>" name="user_id">
    <input type="text" class="form-control" id="full_name" value="<?php echo $rows['full_name']; ?>" name="full_name">
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id="email" value="<?php echo $rows['email']; ?>" name="email" readonly>
  </div>
  <div class="form-group">
    <label for="phone_no">Phone No.:</label>
    <input type="text" class="form-control" id="contact" value="<?php echo $rows['contact']; ?>" name="contact">
  </div>

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tenant_update"])) {
    // Retrieve form data and sanitize
    $user_id = $_POST["user_id"];
    $full_name = mysqli_real_escape_string($db, $_POST["full_name"]);
    $contact = mysqli_real_escape_string($db, $_POST["contact"]);
    $address = mysqli_real_escape_string($db, $_POST["address"]);

    // Update profile data in the database
    $sql = "UPDATE users SET full_name='$full_name', contact='$contact', WHERE user_id='$user_id'";
    if (mysqli_query($db, $sql)) {
        // Profile updated successfully
        $_SESSION["success_message"] = "Profile updated successfully.";
    } else {
        // Error updating profile
        $_SESSION["error_message"] = "Error updating profile: " . mysqli_error($db);
    }

    // Redirect back to tenant profile page
    header("location:/kothaGhar/views/pages/userProfile.php");
    exit; // Stop further execution
} else {
    // If the form was not submitted, redirect to tenant profile page
    header("location:/kothaGhar/views/pages/userProfile.php");
    exit; // Stop further execution
}
?>
