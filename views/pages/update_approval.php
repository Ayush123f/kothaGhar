<?php
// Include database configuration
include("../../config/config_db.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the JSON data sent from the client
    $data = json_decode(file_get_contents("php://input"));

    // Check if all required fields are present
    if (isset($data->roomId, $data->isApproved, $data->isRejected)) {
        // Sanitize and validate the input
        $roomId = intval($data->roomId);
        $isApproved = intval($data->isApproved);
        $isRejected = intval($data->isRejected);

        // Update the approval status in the database
        $stmt = $conn->prepare("UPDATE booked_rooms SET is_approved = ?, is_rejected = ? WHERE room_id = ?");
        $stmt->bind_param("iii", $isApproved, $isRejected, $roomId);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Send a success response
            http_response_code(200);
            echo json_encode(array("message" => "Approval status updated successfully"));
        } else {
            // Send an error response if the update fails
            http_response_code(500);
            echo json_encode(array("error" => "Failed to update approval status"));
        }

        // Close the prepared statement
        $stmt->close();
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
