<?php
const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';
?>
<?php
// login.php

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once BASE_DIR . "config/config_db.php";
  require_once BASE_DIR . "config/functions.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script> alert('Invalid email format'); </script>";
        return;
    }

    // Retrieve user from the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, verify password
        $user = $result->fetch_assoc();
        $hashedPassword = $user['password'];

        if (password_verify($password, $hashedPassword)) {
            // Passwords match, login successful

            $_SESSION['user'] =[
              'id' => $user['user_id'],
              'fullname'=> $user['full_name'],
              'email'=> $user['email'],
              'contact'=> $user['contact']
            ];
            
            header('location: index.php');
            exit();
        } else {
            // Passwords don't match
            alert('Incorrect email or password');
        }
    } else {
        // User not found
        alert('Incorrect email or password');

    }

    $stmt->close(); // Close statement
    $conn->close(); // Close connection
}
?>

<div class="login-page">
  <div class="form">
  <form method="post" action="login.php">
  <h1 id="title">Log In</h1>
    <input type="text" name="email" id="email" placeholder="E-mail" required title="Enter e-mail address">
    <input type="password" name="password" id="password" placeholder="Password" required title="Enter password" minlength="8" maxlength="16">
    <button class="input" type="submit" id="button">Log In</button>
  </form>
  </div>
</div>

<?php
require_once BASE_DIR . 'views/components/footer.php';
?>