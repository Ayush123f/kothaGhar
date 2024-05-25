<?php
session_start();

include ("views/components/nav.php");

?>
<style>
  body,
  html {
    height: 100%;
    margin: 0;
  }

  .bg {
    /* The image used */
    background-image: url("image/house.jpg");

    /* Full height */
    height: 500px;

    /* Center and scale the image nicely */
    background-position: bottom;
    background-repeat: no-repeat;
    background-size: cover;
  }

  .fa {
    padding: 20px;
    font-size: 30px;
    text-align: left;
    text-decoration: none;
    margin: 5px 2px;
  }

  .fa:hover {
    opacity: 0.7;
  }

  .fa-facebook {
    background: #3B5998;
    color: white;
  }

  .fa-linkedin {
    background: #007bb5;
    color: white;
  }

  .active-cyan-3 input[type=text] {
    border: 1px solid #4dd0e1;
    box-shadow: 0 0 0 1px #4dd0e1;
  }

  .search-container-wrapper {
    text-align: center;
  }

  .search-container {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .search-input {
    width: 75%;
    padding: 5px;
  }
</style>

<div class="bg"></div><br>
<div class="search-container-wrapper">
  <form method="GET">
    <div class="search-container active-cyan-4 mb-4 inline">
      <input class="search-input" type="text" placeholder="Enter Location to search room." name="search"
        aria-label="Search">
      <button type="submit" class="search-button">
        <img src="image/search.svg" height="25px" width="25px" alt="Logo" class="search-logo">
      </button>
    </div>
  </form>
</div>

</div>
<br><br>
<?php

include ("property-list.php");

?>
<br><br>