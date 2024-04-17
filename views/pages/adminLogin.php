<?php 

const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';
?>
<div class="login-page">
  <div class="form">
    <h2>Admin Login</h2>
    <form class="login-form">
      <input type="text" placeholder="username"/>
      <input type="password" placeholder="password"/>
      <button>login</button>
      <p class="message">Not registered? <a href="/Project1/views/pages/signup.php">Create an account</a></p>
    </form>
  </div>
</div>
  <?php
require_once BASE_DIR . 'views/components/footer.php';
?>