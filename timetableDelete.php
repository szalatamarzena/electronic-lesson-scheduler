<?php

session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true)
{
  header("Location: login.php");
  die();
}
else if (!isset($_SESSION['accountRole']) || $_SESSION['accountRole'] != 1)
{
  header("Location: landingPage.php");
  die();
}
else if (!isset($_POST['id']))
{
  header("Location: landingPage.php");
  die();
}

require_once("dbconfig.php");

$sql = "SELECT id FROM timetable WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_POST['id']);
$stmt->execute();
$result = $stmt->fetchAll();

if (count($result) == 1)
{
  $sql = "DELETE FROM timetable WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':id', $_POST['id']);
  $stmt->execute();

  header("Location: landingPage.php");
  die();
}
else
{
  header("Location: error.php?message=" . "Dany rekord nie istnieje");
  die();
}