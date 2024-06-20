<?php
// Include database configuration
include("../../config/config_db.php");


// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the JSON data sent from the client
    $data = json_decode(file_get_contents("php://input"));


    // Check if all required fields are present
    if (isset($data->roomId) && (isset($data->isApproved) || isset($data->isRejected) || isset($data->isCompleted))){
        // Sanitize and validate the input
        $booking_id = intval($data->roomId);
        $isApproved = intval($data->isApproved);
        $isRejected = intval($data->isRejected);
        $isCompleted = intval($data->isCompleted);


        if($isCompleted == 1 || $isRejected == 1) {
            // Update the completion status in the database
            $stmt = $conn->prepare("UPDATE booked_rooms SET is_completed = 1 WHERE id = ?");
            $stmt->bind_param("i",$booking_id);
            $stmt->execute();
            $stmt->close();
        }
        if ($isApproved || $isRejected) {
            // Update the approval status in the database
            $stmt = $conn->prepare("UPDATE booked_rooms SET is_approved = ?, is_rejected = ? WHERE id = ?");
            $stmt->bind_param("iii", $isApproved, $isRejected, $booking_id);
            $stmt->execute();
            $stmt->close();
    
        }
    
        // Select the room_id from the booked_rooms table
        $stmt = $conn->prepare("SELECT room_id FROM booked_rooms WHERE id = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $roomId = $row['room_id'];
        $stmt->close();




        if($isCompleted == 1 || $isRejected == 1) {
            $stmt = $conn->prepare("UPDATE add_room SET is_booked = 0 WHERE room_id = ?");
            $stmt->bind_param("i", $roomId);
            $stmt->execute();
            $stmt->close();
    
        }
        if($isApproved == 1 ) {
            $stmt = $conn->prepare("UPDATE add_room SET is_booked = 1 WHERE room_id = ?");
            $stmt->bind_param("i", $roomId);
            $stmt->execute();
            $stmt->close();
    
        }


        // Execute the prepared statement
        if ($stmt->execute()) {
            // Close the prepared statement
            $stmt->close();


            // Send a success response
            http_response_code(200);
            echo json_encode(array("message" => "Status updated successfully"));
        } else {
            // Send an error response if the update fails
            http_response_code(500);
            echo json_encode(array("error" => "Failed to update approval status"));
        }


    } else {
        // Send an error response if required fields are missing
        http_response_code(400);
        echo json_encode(array("error" => "Missing required parameters"));
    }
} else {
    // Send an error response if the request method is not POST
    http_response_code(405);
    echo json_encode(array("error" => "Method Not Allowed"));
}
?>




