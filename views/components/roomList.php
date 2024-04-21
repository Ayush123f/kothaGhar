<?php
include("../../config/config_db.php");
    
$query = "SELECT * FROM add_room";
$result = $conn->query($query);
?>

<div id="wrapper">
  <h1>Record of Rooms</h1>
  <a href="/kothaGhar/views/pages/uploadForm.php" class="btn btn-default navbar-btn">Add Room</a>
  <table id="keywords" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
        <th><span>Title</span></th>
        <th><span>No.of rooms</span></th>
        <th><span>Price</span></th>
        <th><span>Location</span></th>
        <th><span>Edit</span></th>
        <th><span>Delete</span></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
          // Loop through each row and display room details
          while ($room_details = $result->fetch_assoc()) { 
           echo <<<HTML
                <tr>
                  <td> {$room_details['Title']} </td>
                  <td> {$room_details['NumberOfRooms']} </td>
                  <td> {$room_details['Price']} </td>
                  <td> {$room_details['Location']} </td>
                
                  <!-- Edit button -->
                  <td><a id="location" href="editRoom.php?id={$room_details['RoomID']}">Edit</a></td>
                  <td><a id="location" href="delete.php?id={$room_details['RoomID']}">Delete</a></td>
                </tr>
          HTML;
          }
      } else {
          // If the query didn't return any results, display an error message
          echo 'Error: No rooms found.';
      }
    
      // Close the database connection
      $conn->close();
      ?>
    </tbody>
  </table>
</div>

    </tbody>
  </table>
 </div> 

 