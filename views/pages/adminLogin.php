<?php 

const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are provided
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Your code for verifying admin credentials and redirecting to dashboard goes here
        // Example:
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Add your logic to verify credentials here
        if ($username === "admin" && $password === "admin_password") {
            // Redirect to admin dashboard
            header("Location: admin/dashboard.php");
            exit(); // Stop further execution
        } else {
            // Display error message if credentials are incorrect
            $error_message = "Incorrect username or password";
        }
    } else {
        // Display error message if username or password is not provided
        $error_message = "Please enter username and password";
    }
}

?>

<div class="login-page">
  <div class="form">
    <h2>Admin Login</h2>
    <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <input type="text" name="username" placeholder="Username" required/>
      <input type="password" name="password" placeholder="Password" required/>
      <button type="submit">Login</button>
      <!-- Display error message if any -->
      <?php if (isset($error_message)): ?>
          <p class="error"><?php echo $error_message; ?></p>
      <?php endif; ?>
      <p class="message">Not registered? <a href="/Project1/views/pages/signup.php">Create an account</a></p>
    </form>
  </div>
</div>

<?php
require_once BASE_DIR . 'views/components/footer.php';
?>
