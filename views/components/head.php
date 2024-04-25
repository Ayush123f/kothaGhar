<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Room Rental System</title>

    <?php
    $styles = [
        'login.php' => ['loginAndSignup.css'],
        'signup.php' => ['loginAndSignup.css'],
        'adminLogin.php'=> ['loginAndSignup.css'],
        'index.php' => ['style.css'],
        'about.php'  => ['about.css'],
        'adminIndex.php' =>['adminStyle.css'],
        'uploadForm.php' => ['loginAndSignup.css'],
        'Search.php'=> ['search.css'],
        'roomDetails.php'=> ['style.css'],
        'roomList.php' => ['adminStyle.css'],
        'editRoom.php' => ['loginAndSignup.css'],
        'updateRoom.php'=> ['loginAndSignup.css'],
        'bookings_list.php'=> ['adminStyle.css'],
        'mybookings.php'=> ['adminStyle.css'],
    ];

    $scripts = [
        'login.php' => ['xyz.js'],
        'signup.php' => ['xyz.js'],
        'index.php' => ['roomInfoOverlay.js'],
        'is_admin.php' =>['is_admin.js']
    ];

    $uri = parse_url($_SERVER["REQUEST_URI"])['path'];
    $uri = basename($uri);

    if(array_key_exists($uri, $styles)){
        foreach ( $styles[$uri] as $style ) { ?>
           <link rel="stylesheet" href="./../../css/<?=$style?>">
       <?php }   
		}

    if(array_key_exists($uri, $scripts)){
        foreach ( $scripts[$uri] as $script ) { ?>
            <script src="./../../js/<?= $script ?>" defer></script>
						<?php }
        }

    ?>

</head>

<body>
