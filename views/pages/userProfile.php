<style>
  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    max-width: 300px;
    margin: auto;
    margin-right: auto!important;
    text-align: center;
    font-family: arial;
  }

  button {
    border: none;
    outline: 0;
    display: inline-block;
    padding: 8px;
    color: white;
    background-color: #000;
    text-align: center;
    cursor: pointer;
    width: 100%;
    font-size: 18px;
  }

  button:hover,
  a:hover {
    opacity: 0.7;
  }

  .form-group {
    text-align: left;
  }

  .form-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
  }
</style>

<?php
const BASE_DIR = __DIR__ . '/../../';

require_once BASE_DIR . 'views/components/head.php';
require_once BASE_DIR . 'views/components/nav.php';

include ("../../config/config_db.php");

$u_email = $_SESSION["user"]['email'];

$sql = "SELECT * from users where email='$u_email'";
$result = mysqli_query($conn, $sql);
?>

<div class="room-details-container">
  <?php
  if (mysqli_num_rows($result) > 0) {
    while ($rows = mysqli_fetch_assoc($result)) {
      ?>
      <div class="card">
        <h3><?php echo $rows['email']; ?></h1>
          <p class="title"><?php echo $rows['full_name']; ?></p>
          <p><b>Contact: </b><span id="contact"><?php echo $rows['contact']; ?></span></p>
          <!-- Button to toggle edit mode -->
          <button type="button" class="btn btn-lg btn-info" id="editButton">Edit</button>
          <!-- Form for updating profile (initially hidden) -->
          <form method="POST" action="updateProfile.php" id="updateForm" style="display: none;">
            <div class="form-group">
              <label for="full_name">Full Name:</label>
              <input type="hidden" value="<?php echo $rows['user_id']; ?>" name="user_id">
              <input type="text" class="form-control" id="full_name" value="<?php echo $rows['full_name']; ?>"
                name="full_name">
            </div>
            <div class="form-group">
              <label for="phone_no">Phone No.:</label>
              <input type="text" class="form-control" id="contactInput" value="<?php echo $rows['contact']; ?>"
                name="contact">
            </div>
            <div class="form-buttons">
            <button type="submit" name="tenant_update" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-danger" id="cancelButton">Cancel</button>
            </div>
          </form>
      </div>
      <?php
    }
  }
  ?>
</div>

<?php
$conn->close();

require_once BASE_DIR . 'views/components/footer.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    // Click event for edit button
    $("#editButton").click(function () {
      // Hide paragraphs and show form
      $("p").hide();
      $("#editButton").hide();
      $("#updateForm").show();
    });

    // Click event for cancel button
    $("#cancelButton").click(function () {
      // Show paragraphs and hide form
      $("p").show();
      $("#updateForm").hide();
      $("#editButton").show();
    });
  });
</script>