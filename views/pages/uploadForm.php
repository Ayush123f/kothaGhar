<?php

const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';
require_once BASE_DIR . "config/config_db.php";
require_once BASE_DIR . "config/functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $numOfRooms = $_POST["numOfRoom"];
    $price = $_POST["price"];
    $location = $_POST["location"];
    $imageFiles = $_FILES["uploadImage"];

    // Validate image files size and move them to a directory
    $uploadDirectory = './uploadImg/';
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true); // Create the directory if it doesn't exist
    }

    $uploadedFilePaths = [];
    foreach ($imageFiles["tmp_name"] as $key => $tmp_name) {
        $file_extension = pathinfo($imageFiles["name"][$key], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_extension;
        $file_path = $uploadDirectory . $file_name;
        if (move_uploaded_file($tmp_name, $file_path)) {
            $uploadedFilePaths[] = $file_path;
        } else {
            echo "<script>alert('Error uploading file: $file_name');</script>";
        }
    }

    // Check if any files were uploaded successfully
    if (!empty($uploadedFilePaths)) {
        // Prepare and execute SQL insert query using prepared statements
        $sql = "INSERT INTO add_room (Title, NumberOfRooms, Price, Location, ImagePath) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        // Check if the statement was prepared successfully
        if ($stmt) {
            foreach ($uploadedFilePaths as $imagePath) {
                mysqli_stmt_bind_param($stmt, "ssiss", $title, $numOfRooms, $price, $location, $imagePath);
                mysqli_stmt_execute($stmt);
            }
            echo "<script>alert('Request submitted successfully')</script>";
        } else {
            echo "Error: Failed to prepare the SQL statement";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('No files were uploaded. Please try again.')</script>";
    }
}
?>

<div class="signup-page">
    <div class="form">
        <form class="sign-up-form" action="" method="post" enctype="multipart/form-data">

            <input type="text" id="title" name="title" placeholder="Title" required>

            <input type="number" id="numOfRooms" name="numOfRoom" placeholder="No. of rooms" required>

            <input type="number" id="price" name="price" placeholder="Price" required>

            <input type="text" id="location" name="location" placeholder="Location" required>

            <input type="file" accept="image/jpeg,image/jpg,image/png" id="uploadImage" name="uploadImage[]" required multiple>

            <button type="submit">Submit</button>
        </form>
    </div>
</div>

<?php
require_once BASE_DIR . 'views/components/footer.php';
?>
