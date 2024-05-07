<!DOCTYPE html>
<html lang="en">
<head>
  <title>RentHouse</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-sm navbar-light justify-content-between" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <div class="navbar-header">
      <!-- Add button to add room -->
      <button type="button" class="btn btn-default navbar-btn" onclick="location.href='/kothaGhar/views/pages/AddRoom.php';">Add Room</button>
      <a class="navbar-brand" href="/kothaGhar/index.php">
      <!-- <span style="font-size: 20px;">KothaGhar</span> -->

        <!-- <img src="image/rent1.jpg" alt="logo" style="height:50px;"> -->
      </a>
    </div>

    <nav class="navbar navbar-expand-sm navbar-light justify-content-between" style="background-color: #e3f2fd;">
  <div class="container-fluid">
    <div class="navbar-header">
      <!-- Add button to add room -->
      <a class="navbar-brand" href="/kothaGhar/index.php">
      <span style="font-size: 20px;">KothaGhar</span>

        <!-- <img src="images/logo.png" alt="logo" style="height:50px;"> -->
      </a>
    </div>
  
    <!-- Links -->
    <ul class="nav navbar-nav">
      <li class="nav-item">
        <?php
          if (isset($_SESSION["user"]) && !empty($_SESSION['user']) && boolval($_SESSION["user"]["is_admin"])) {
            echo '<a class="nav-link" href="/kothaGhar/views/pages/adminIndex.php">Home</a>';
          } else {
            echo '<a class="nav-link" href="/kothaGhar/index.php">Home</a>';
          }
        ?>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/kothaGhar/views/pages/about.php">About Us</a>
      </li>
      <?php
      if(isset($_SESSION["user"]) && !empty($_SESSION['user']) && boolval($_SESSION["user"]["is_admin"])){
        ?>
        <li class="nav-item">
          <a class="nav-link" href="/kothaGhar/views/pages/roomList.php">Rooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/kothaGhar/views/pages/bookings_list.php">Bookings</a>
        </li>
        <?php    
      } else {
        if(isset($_SESSION["user"]) && !empty($_SESSION['user']) && !boolval($_SESSION["user"]["is_admin"])){
      ?>
        <li class="nav-item">
          <a class="nav-link" href="/kothaGhar/views/pages/mybookings.php">My Bookings</a>
        </li>
        <?php
        }
      }
     ?>
    </ul>
   
    <ul class="nav navbar-nav navbar-right">
      <?php 
      if(isset($_SESSION["user"]) && !empty($_SESSION['user'])){
      ?>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> My Profile
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/KothaGhar/views/pages/userProfile.php">Profile</a></li>
            <?php if(isset($_SESSION["user"]) && !empty($_SESSION['user']) && !boolval($_SESSION["user"]["is_admin"])){ ?>
            <li><a href="/KothaGhar/views/pages/mybookings.php">Booked Property</a></li>
            <?php } ?>
            <li><a href="/KothaGhar/views/pages/logout.php">Logout</a></li>
          </ul>
        </li>
      <?php
      } else {
      ?>
        <li><a href="/kothaGhar/views/pages/signup.php"><span class="glyphicon glyphicon-user"></span>Signup</a></li>
        <li><a href="/kothaGhar/views/pages/login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      <?php
      }
      ?>
    </ul>
  </div>
</nav>

</body>
</html>
