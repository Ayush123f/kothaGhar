<?php 

include ("../../config/config.php");


if(isset($_POST['review'])){
	review();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once BASE_DIR . "config/config_db.php";
  require_once BASE_DIR . "config/functions.php";

  $rating = $_POST['rating'];
  $comment = $_POST['comment'];
}

function review(){
	global $db;
	$room_id=$_GET['room_id'];
  $comment=$_POST['comment'];
  $rating=$_POST['rating'];
  $reviewby=$_SESSION["user"]["email"];

$sql= "INSERT INTO review(comment,rating,reviewby,room_id) VALUES('$comment','$rating','$reviewby','$room_id')";
$query=mysqli_query($db,$sql);
if(!empty($query)){
	?>

<style>
.alert {
  padding: 20px;
  background-color: #DC143C;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>
<script>
	window.setTimeout(function() {
    $(".alert").fadeTo(1000, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
</script>
<div class="container">
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Your review has been recorded.</strong>
</div></div>


<?php
}

}

 ?>