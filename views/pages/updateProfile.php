<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
    header("location:index.php");
    exit; // Stop further execution
}

// Include the database configuration file
include("../../config/config_db.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tenant_update"])) {
    // Retrieve form data and sanitize
    $user_id = $_POST["tenant_id"];
    $full_name = mysqli_real_escape_string($db, $_POST["full_name"]);
    $phone_no = mysqli_real_escape_string($db, $_POST["phone_no"]);
    $address = mysqli_real_escape_string($db, $_POST["address"]);

    // Update profile data in the database
    $sql = "UPDATE users SET full_name='$full_name', phone_no='$phone_no', address='$address' WHERE user_id='$user_id'";
    if (mysqli_query($db, $sql)) {
        // Profile updated successfully
        $_SESSION["success_message"] = "Profile updated successfully.";
    } else {
        // Error updating profile
        $_SESSION["error_message"] = "Error updating profile: " . mysqli_error($db);
    }

    // Redirect back to tenant profile page
    header("location:userProfile.php");
    exit; // Stop further execution
} else {
    // If the form was not submitted, redirect to tenant profile page
    header("location:userProfile.php");
    exit; // Stop further execution
}
?>
