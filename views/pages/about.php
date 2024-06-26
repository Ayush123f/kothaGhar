<?php 

const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';
?>

<div class="container">
    <div class="div-left">
        <img src="../../image/home.jpg" alt="Google Home" width="100%">
    </div>
    <div class="div-right">
        <h4>Kothaghar</h4>
        <p>Kothaghar is Nepal's premier online real estate platform for renting both residential
            and commercial properties. It serves as the top choice for individuals seeking properties in Nepal,
            bridging the gap between users and property owners effortlessly. Kothaghar Rental is dedicated to
            providing comprehensive property information, ensuring that potential customers can find their ideal
            property quickly and conveniently. It offers a user-friendly interface for property owners to list
            their properties and connect with genuine customers seamlessly.
            Kothaghar goes beyond just facilitating property exploration online.
            It caters to every need, from property search to relocation.
            With the 'Find me Room' feature, users can request a personal visit from a representative 
            who will recommend the best locations tailored to their preferences with a simple click.
            Additionally, the 'Shift Home' service eliminates the stress of finding transportation
            for belongings by allowing users to find their desired vehicle at their location with ease, ensuring 
            a smooth and hassle-free moving experience.
            <br><br>
            For more information, contact us at: <strong>+977-1234567890</strong>
        </p>
        <a class="btn btn-light btn-lg showcase-btn">Read More</a>
    </div>
</div>

<?php
require_once BASE_DIR . 'views/components/footer.php';
?>
