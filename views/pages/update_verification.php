<?php
include ("../../config/config_db.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Decode the JSON data sent in the request body
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract room ID and verification status from the decoded data
    $roomId = $data['roomId'];
    $isVerified = $data['isVerified'];

    // Update verification status in the database
    $stmt = $conn->prepare("UPDATE booked_rooms SET is_verified = ? WHERE room_id = ?");
    $stmt->bind_param("ii", $isVerified, $roomId);
    $stmt->execute();
    $stmt->close();

    // Respond with success status
    http_response_code(200);
    echo json_encode(array("message" => "Verification status updated successfully"));
} else {
    // Respond with error status if request method is not POST
    http_response_code(405);
    echo json_encode(array("error" => "Method Not Allowed"));
}
?>
