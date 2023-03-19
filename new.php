<?php
include 'templates/header.php';
session_start();
if(isset($_SESSION['user'])){
$u=$_SESSION['user'];
echo "<h1>Hello" .$u." !!</h1>";
}
else{
 
    header('location: userlogin.php');
}
?>
 <?php
  include("templates/footer.php");
  ?>