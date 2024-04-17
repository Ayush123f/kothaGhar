<?php 
const BASE_DIR = __DIR__ . '/../../';
require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';
?>

<div class="signup-page">
  <div class="form">
    <form class="sign-up-form" action="signup.php" method="post">
      <input type="text" id="fullName" name="fullName" placeholder="Full Name" required>
      <input type="email" id="email" name="email" placeholder="Email" required>
      <input type="tel" id="contact" name="contact" placeholder="Contact No." required>
      <input type="password" id="pwd" name="pwd" placeholder="Password" required>
      <input type="password" id="cpwd" name="cpwd" placeholder="Confirm Password" required>
      <button type="submit">Create</button>
      <p class="message">Already registered? <a href="/Project1/views/pages/login.php">Log In</a></p>
    </form>
  </div>
</div>

<?php
require_once BASE_DIR . 'views/components/footer.php';


// Signup request received
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  require_once BASE_DIR . "config/config_db.php";
  require_once BASE_DIR . "config/functions.php";

  $name = htmlspecialchars($_POST["fullName"]);
  $userEmail = htmlspecialchars($_POST["email"]);
  $phoneNumber = htmlspecialchars($_POST["contact"]);
  $passWord = $_POST["pwd"];
  $c_password = $_POST["cpwd"];

  // Check if email already exists
  $query = "SELECT email FROM users WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('s', $userEmail);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    alert('Email already exists.');
    exit(); // Stop script execution if email exists
  }


  // Fullname < 50 chars
  if (strlen($name) > 50) {
      alert('name must be less tha 50 characters');
      return;
  }

  // Email validation
  if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    alert('Invalid emai');
    return;
  }

  // 8 < password < 16
  if (strlen($passWord) < 8 || strlen($passWord) > 16) {
    alert('password need to be 8 - 16 characters long');
    return;
  }

  // Password match
  if ($passWord !== $c_password) {
    alert('password dont  match!');
    return; 
  }

      // If no error save user to db
      $query = "INSERT INTO users (full_name, email, contact, password) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($query);
      $stmt->bind_param('ssss', $name, $userEmail, $phoneNumber, password_hash($passWord, PASSWORD_BCRYPT));
      $result = $stmt->execute();

      if (!$result) {
         alert('Error in saving data');
      } else {
         alert('User created successfully, Login now');
          // Redirect to login page
          header('location:login.php');
          exit(); // Stop script execution after redirection
      }
  }

?>
