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

require_once("dbconfig.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  if (!isset($_POST['time']) || !isset($_POST['class']) || !isset($_POST['teacher']) || !isset($_POST['day'])
  || $_POST['time'] == 0 || $_POST['class'] == 0 || $_POST['teacher'] == 0 || $_POST['day'] == 0)
  {
    header("Location: error.php?message=" . "Nastąpił błąd w trakcie edycji planu zajęć");
    die();
  }
  else
  {
    $sql = "SELECT id FROM timetable WHERE day = :day AND time_id = :time_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':day', $_POST['day']);
    $stmt->bindParam(':time_id', $_POST['time']);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if (count($result) > 0)
    {
      header("Location: error.php?message=" . "Danego dnia o danej godzinie już są zajęcia!");
      die();
    }

    $sql = "INSERT INTO timetable (time_id, class_id, teacher_id, day) VALUES (:time_id, :class_id, :teacher_id, :day)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':time_id', $_POST['time']);
    $stmt->bindParam(':class_id', $_POST['class']);
    $stmt->bindParam(':teacher_id', $_POST['teacher']);
    $stmt->bindParam(':day', $_POST['day']);
    $result = $stmt->execute();

    if ($result === TRUE)
    {
      header("Location: landingPage.php");
      die();
    }
    else
    {
      header("Location: error.php?message=" . "Nastąpił błąd w trakcie edycji planu zajęć");
      die();
    }
  }
}

$sql = "SELECT id, start, end FROM times ORDER BY id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$times = $stmt->fetchAll();

$sql = "SELECT id, name FROM classes ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$classes = $stmt->fetchAll();

$sql = "SELECT id, name FROM teachers ORDER BY name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$teachers = $stmt->fetchAll();

?>

<html>

<?php include('layout/head.php'); ?>

<body>

<?php include('layout/header.php'); ?>

<main role="main">

  <div class="container">

  <h2>Edycja zajęć</h2>
  <br>

  <form class="edit-form" method="post">
    <div class="clearfix">
      <div class="form-group">
        <label for="day">Dzień</label>
        <select name="day" class="form-control" id="day">
          <option value="0">- Wybierz -</option>
          <option value="1">Poniedziałek</option>
          <option value="2">Wtorek</option>
          <option value="3">Środa</option>
          <option value="4">Czwartek</option>
          <option value="5">Piątek</option>
        </select>
      </div>
      <div class="form-group">
        <label for="time">Czas</label>
        <select name="time" class="form-control" id="time">
          <option value="0">- Wybierz -</option>
        <?php
          foreach ($times as $time)
          {
            $start = DateTime::createFromFormat('H:i:s', $time['start']);
            $end = DateTime::createFromFormat('H:i:s', $time['end']);

            echo "<option value='" . $time['id'] ."'>" . $start->format('H:i') ." - " . $end->format('H:i') . "</option>";
          }
        ?>
        </select>
      </div>
      <div class="form-group">
        <label for="class">Przedmiot</label>
        <select name="class" class="form-control" id="class">
          <option value="0">- Wybierz -</option>
        <?php
          foreach ($classes as $class)
          {
            echo "<option value='" . $class['id'] ."'>" . $class['name'] ."</option>";
          }
        ?>
        </select>
      </div>
      <div class="form-group">
        <label for="teacher">Nauczyciel</label>
        <select name="teacher" class="form-control" id="teacher">
          <option value="0">- Wybierz -</option>
        <?php
          foreach ($teachers as $teacher)
          {
            echo "<option value='" . $teacher['id'] ."'>" . $teacher['name'] ."</option>";
          }
        ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary float-right" style="margin: 5px;">Zatwierdź</button>
    </div>
  </form>

  </div>

  <?php include('layout/footer.php'); ?>

</main>

<?php include('layout/scripts.php'); ?>

</body>

</html>