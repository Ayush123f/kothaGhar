<?php
session_start();

const BASE_DIR = __DIR__ . '/../../';

// Check if the user is not authenticated, redirect to login
if (!isset($_SESSION['user'])) {
    header("Location: /kothaGhar/views/pages/Login.php");
    exit();
}

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';
require_once BASE_DIR . 'views/components/mybookings.php';
require_once BASE_DIR . 'views/components/footer.php';
?>