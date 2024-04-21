<?php
// Include the file where the database connection is established
require_once __DIR__ . '/../../config/config_db.php';

if(isset($_GET['id'])) {
    $roomId = $_GET['id'];
    
    // Perform the delete operation
    $sql = "DELETE FROM add_room WHERE RoomID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $roomId);
        mysqli_stmt_execute($stmt);
        
        echo "<script>alert('Room deleted successfully');</script>";
    } else {
        echo "Error: Failed to prepare the SQL statement";
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('Room ID not provided');</script>";
}

// Redirect back to the room list page
header("Location: /kothaGhar/views/pages/roomList.php");
exit();
?>
