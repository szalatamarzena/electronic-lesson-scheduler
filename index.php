<?php

session_start();

if (isset($_SESSION['logged']) && $_SESSION['logged'] === true)
{
  header("Location: landingPage.php");
  die();
}
else
{
  header("Location: login.php");
  die();
}