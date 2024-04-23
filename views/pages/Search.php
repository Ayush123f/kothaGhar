<!-- <div class="wrap">
   <div class="search">
      <input type="text" class="searchTerm" placeholder="What are you looking for?">
      <button type="submit" class="searchButton">
        <i class="fa fa-search"></i>
     </button>
   </div>
</div> -->

<div class="wrap">
   <div class="search">
      <form action="search.php" method="POST">
         <input type="text" class="searchTerm" name="search_property" placeholder="What are you looking for?">
         <button type="submit" class="searchButton">
            <i class="fa fa-search"></i>
         </button>
      </form>
   </div>
</div>

<?php
include("config/config.php");
session_start();

if(isset($_POST['search_property'])) {
    $search_location = mysqli_real_escape_string($db, $_POST['search_property']);

    // Perform the database query to search for the entered location
    $sql = "SELECT * FROM add_room WHERE concat(title,NumberOfRooms,Price,Location,ImagePath) LIKE '%$search_location%'";
    $query = mysqli_query($db, $sql);

    if(mysqli_num_rows($query) > 0) {
        echo '<div class="container">';
        echo '<h1>Searched Properties</h1>';
        while($row = mysqli_fetch_assoc($query)) {
            // Display search results
            // Here you can echo out the HTML structure to display each search result
            echo "<p>Location: " . $row['Location'] . "</p>";
            // You can add more details if needed
        }
        echo '</div>';
    } else {
        echo "<div class='container'><h3>No properties found in the entered location...</h3></div>";
    }
} else {
    // Redirect user to homepage if search query is not set
    header("Location:/kothaGhar/index.php");
    exit();
}
?>
