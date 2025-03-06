<?php 
require_once "class_autoloader.php";

if (isset($_POST["submit"])) {
  
  $Username = $_POST["username"];
  $Password = $_POST["pwd"];

  $login = new LoginContr($Username, $Password);

  $login->LoginUser();
} else
{
  header("location: ../login.php");
  exit();
}
