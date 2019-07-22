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
  if (!isset($_POST['timetableId']) || !isset($_POST['time']) || !isset($_POST['class']) || !isset($_POST['teacher']) || !isset($_POST['day']))
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

    if (count($result) > 0 && $_POST['timetableId'] != $result[0]['id'])
    {
      header("Location: error.php?message=" . "Danego dnia o danej godzinie już są zajęcia!");
      die();
    }

    $sql = "UPDATE timetable SET time_id = :time_id, class_id = :class_id, teacher_id = :teacher_id, day = :day WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':time_id', $_POST['time']);
    $stmt->bindParam(':class_id', $_POST['class']);
    $stmt->bindParam(':teacher_id', $_POST['teacher']);
    $stmt->bindParam(':day', $_POST['day']);
    $stmt->bindParam(':id', $_POST['timetableId']);
    $stmt->execute();
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

$sql = "SELECT id, time_id, class_id, teacher_id, day FROM timetable WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();
$result = $stmt->fetch();

if ($result === FALSE)
{
  header("Location: error.php?message=" . "Dany rekord nie istnieje");
  die();
}

$timetableRecord = $result;

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
      <input hidden name="timetableId" id="timetableId" value="<?php echo $_GET['id']; ?>">
      <div class="form-group">
        <label for="day">Dzień</label>
        <select name="day" class="form-control" id="day">
          <option value="1" <?php if ($timetableRecord['day'] == '1') echo "selected='true'"; ?>>Poniedziałek</option>
          <option value="2" <?php if ($timetableRecord['day'] == '2') echo "selected='true'"; ?>>Wtorek</option>
          <option value="3" <?php if ($timetableRecord['day'] == '3') echo "selected='true'"; ?>>Środa</option>
          <option value="4" <?php if ($timetableRecord['day'] == '4') echo "selected='true'"; ?>>Czwartek</option>
          <option value="5" <?php if ($timetableRecord['day'] == '5') echo "selected='true'"; ?>>Piątek</option>
        </select>
      </div>
      <div class="form-group">
        <label for="time">Czas</label>
        <select name="time" class="form-control" id="time">
        <?php
          foreach ($times as $time)
          {
            $start = DateTime::createFromFormat('H:i:s', $time['start']);
            $end = DateTime::createFromFormat('H:i:s', $time['end']);

            if ($timetableRecord['time_id'] == $time['id'])
            {
              echo "<option value='" . $time['id'] ."' selected='true'>" . $start->format('H:i') ." - " . $end->format('H:i') . "</option>";
            }
            else
            {
              echo "<option value='" . $time['id'] ."'>" . $start->format('H:i') ." - " . $end->format('H:i') . "</option>";
            }
          }
        ?>
        </select>
      </div>
      <div class="form-group">
        <label for="class">Przedmiot</label>
        <select name="class" class="form-control" id="class">
        <?php
          foreach ($classes as $class)
          {
            if ($timetableRecord['class_id'] == $class['id'])
            {
              echo "<option value='" . $class['id'] ."' selected='true'>" . $class['name'] ."</option>";
            }
            else
            {
              echo "<option value='" . $class['id'] ."'>" . $class['name'] ."</option>";
            }
          }
        ?>
        </select>
      </div>
      <div class="form-group">
        <label for="teacher">Nauczyciel</label>
        <select name="teacher" class="form-control" id="teacher">
        <?php
          foreach ($teachers as $teacher)
          {
            if ($timetableRecord['teacher_id'] == $teacher['id'])
            {
              echo "<option value='" . $teacher['id'] ."' selected='true'>" . $teacher['name'] ."</option>";
            }
            else
            {
              echo "<option value='" . $teacher['id'] ."'>" . $teacher['name'] ."</option>";
            }
          }
        ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary float-right" style="margin: 5px;">Zatwierdź</button>
      <button type="button" onclick="TimetableDelete(<?php echo $_GET['id']; ?>)" class="btn btn-danger float-right" style="margin: 5px;">Usuń</a>
    </div>
  </form>

  </div>

  <?php include('layout/footer.php'); ?>

</main>

<?php include('layout/scripts.php'); ?>

<script>

function TimetableDelete(id)
{
  var form = document.createElement("form");
  form.method = "post";
  form.action = "timetableDelete.php";

  var node = document.createElement("input");
  node.name = "id";
  node.value = id;

  form.appendChild(node);
  document.body.appendChild(form);

  form.submit();

  document.body.removeChild(form);
}

</script>

</body>

</html>