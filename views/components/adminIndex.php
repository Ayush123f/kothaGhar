<?php
// Include necessary files and functions
include ("../../config/config_db.php");

// Function to retrieve total rooms booked
function getTotalRoomsBooked($conn)
{
    $query = "SELECT COUNT(*) AS total FROM booked_rooms";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Function to retrieve total cancellations
function getTotalCancellations($conn)
{
    $query = "SELECT COUNT(*) AS total FROM booked_rooms WHERE is_cancelled = 1";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Function to retrieve total pending bookings
function getTotalPendingBookings($conn)
{
    $query = "SELECT COUNT(*) AS total FROM booked_rooms WHERE is_cancelled='0' and is_approved = '0' AND is_rejected = '0'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Function to retrieve total rooms available
function getTotalRoomsAvailable($conn)
{
    $query = "SELECT COUNT(*) AS total FROM add_room";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Function to retrieve recent pending bookings
function getRecentPendingBookings($conn, $limit)
{
    $query = "SELECT * FROM booked_rooms br
    inner join add_room ar 
    on br.room_id = ar.roomID 
    inner join users u 
    on br.user_id = u.user_id
    WHERE is_approved = '0' AND is_rejected ='0' and is_cancelled ='0' 
    ORDER BY id DESC LIMIT $limit";
    $result = $conn->query($query);
    $bookings = array();
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    return $bookings;
}

// Retrieve statistics
$totalRoomsBooked = getTotalRoomsBooked($conn);
$totalCancellations = getTotalCancellations($conn);
$totalPendingBookings = getTotalPendingBookings($conn);
$totalRoomsAvailable = getTotalRoomsAvailable($conn);

// Retrieve recent pending bookings (limit 5)
$recentPendingBookings = getRecentPendingBookings($conn, 5);
?>

<div class="container">
    <div class="stats">
        <!-- Display statistics in cards -->
        <div class="card">
            <h4>Total Rooms Booked: <?php echo $totalRoomsBooked; ?></h4>
        </div>
        <div class="card">
            <h4>Total Cancellations: <?php echo $totalCancellations; ?></h4>
        </div>
        <div class="card">
            <h4>Total Pending Bookings: <?php echo $totalPendingBookings; ?></h4>
        </div>
        <div class="card">
            <h4>Total Rooms Available: <?php echo $totalRoomsAvailable; ?></h4>
        </div>
    </div>
    <div class="recent-bookings">
        <!-- Display recent pending bookings -->
        <h2>Recent Pending Bookings</h2>
        <table id="keywords" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th><span>ID</span></th>
                    <th><span>User name</span></th>
                    <th><span>Email</span></th>
                    <th><span>Room Title</span></th>
                    <th><span>Cancellation Status</span></th>
                    <th><span>Approval Status</span></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($recentPendingBookings as $booking) {
                    echo '<tr>';
                    echo '<td>' . $booking['id'] . '</td>';
                    echo '<td>' . $booking['full_name'] . '</td>';
                    echo '<td>' . $booking['email'] . '</td>';
                    echo '<td>' . $booking['Title'] . '</td>';
                    echo '<td>' . ($booking['is_cancelled'] == 1 ? 'Yes' : 'No') . '</td>';
                    echo '<td>';
                    // Check if room is approved or rejected
                    if ($booking['is_approved'] == 1) {
                        echo 'Approved';
                    } elseif ($booking['is_rejected'] == 1) {
                        echo 'Rejected';
                    } elseif ($booking['is_cancelled'] == 1) {
                        echo '-';
                    } else {
                        echo 'Pending';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>