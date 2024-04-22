<?php


const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';

$host = 'localhost';
$user = 'root';
$pass = '';
$conn   = 'room_rental';

$conn = new mysqli($host, $user, $pass, $conn);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['id'])) {
    $roomId = $_GET['id'];
    
    $sql = "SELECT * FROM add_room WHERE RoomID = $roomId";
    $result = $conn->query($sql);
    // $user_id = $_SESSION['user'];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { ?>
            <h2 id="title"><?php echo $row['Title'] ?> </h2>
            <p id="location">Location: <?php echo $row['Location'] ?></p>
            <p id="no-of-rooms">Number of rooms: <?php echo $row['NumberOfRooms'] ?></p>
            <p id="price">Price: Rs.<?php echo $row['Price'] ?></p>
            <form id="bookingForm" method="post" action="roomDetails.php?id=<?php echo $roomId ?>">
                <button type="submit" name="book_room">BOOK</button>
            </form>
            <?php echo '<img width="500px" src="' . $row['ImagePath'] . '" alt="' . $row['Title'] . '" />'; 
        }
    } else {
        echo 'Room not found.';
    }
} else {
    echo 'Room ID not provided.';
}






// if(isset($_POST['book_room'])) {
//     if(isset($_SESSION['user'])) {
//         $user_id = $_SESSION['user']; 
//         $room_id = $roomId; 
//         $id=$user_id['id'];
//         $sql = "INSERT INTO booked_rooms (user_id, room_id) VALUES ('$id', '$room_id')";
//         if(mysqli_query($conn, $sql)) {
//             echo '<script type ="text/JavaScript">';  
//             echo 'alert("Booked Sucessfully")';  
//             echo '</script>';  
//         } else {
//             echo "Error: " . mysqli_error($conn);
//         }
//     } else {
//         echo "You need to login to book a room."; // Handle this case appropriately
//     }
// }

$conn->close();

require_once BASE_DIR . 'views/components/footer.php';
?>
