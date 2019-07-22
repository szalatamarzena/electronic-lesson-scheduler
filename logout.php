<?php

session_start();

if (isset($_SESSION['logged']) && $_SESSION['logged'] === true)
{
  $_SESSION['logged'] = false;
  $_SESSION['accountId'] = null;
  $_SESSION['accountRole'] = null;

  header("Location: login.php");
}
else
{
  header("Location: login.php");
  die();
}