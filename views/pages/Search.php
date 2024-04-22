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
// Include necessary files and establish database connection
include("config/config.php");
session_start();

// Check if the search query is set
if(isset($_POST['search_property'])) {
    // Sanitize the input
    $q_string = mysqli_real_escape_string($db, $_POST['search_property']);

    // Perform the database query
    $sql = "SELECT * FROM add_room WHERE CONCAT(zone, district, province, city, tole, property_type, country) LIKE '%$q_string%'";
    $query = mysqli_query($db, $sql);

    // Display the search results
    if(mysqli_num_rows($query) > 0) {
        echo '<div class="container">';
        echo '<h1>Searched Properties</h1>';
        while($rows = mysqli_fetch_assoc($query)) {
            // Display each search result
            // You can use the same HTML structure as in your original code snippet
            // Just make sure to adjust the paths and links accordingly
        }
        echo '</div>';
    } else {
        echo "<div class='container'><h3>No properties found...</h3></div>";
    }
} else {
    // Redirect user to homepage if search query is not set
    header("Location: /kothaGhar/index.php");
    exit();
}
?>
