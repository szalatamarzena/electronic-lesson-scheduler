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
  if (!isset($_POST['teacherId']) || !isset($_POST['teacherName']))
  {
    header("Location: error.php?message=" . "Nastąpił błąd w trakcie edycji nauczyciela");
    die();
  }
  else
  {
    $sql = "UPDATE teachers SET name = :name WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $_POST['teacherName']);
    $stmt->bindParam(':id', $_POST['teacherId']);
    $result = $stmt->execute();

    if ($result === TRUE)
    {
      header("Location: teachers.php");
      die();
    }
    else
    {
      header("Location: error.php?message=" . "Nastąpił błąd w trakcie edycji nauczyciela");
      die();
    }
  }
}
else if (!isset($_GET['id']))
{
  header("Location: teachers.php");
  die();
}

$sql = "SELECT name FROM teachers WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();
$result = $stmt->fetch();

if ($result === FALSE)
{
  header("Location: error.php?message=" . "Dany rekord nie istnieje");
  die();
}

$teacherName = $result['name'];

?>

<html>

<?php include('layout/head.php'); ?>

<body>

<?php include('layout/header.php'); ?>

<main role="main">

  <div class="container">
    
    <h2>Edycja nauczyciela</h2>
    <br>

    <form class="edit-form" method="post">
      <div class="clearfix">
        <input hidden name="teacherId" id="teacherId" value="<?php echo $_GET['id']; ?>">
        <div class="form-group">
          <label for="teacherName">Nazwa nauczyciela</label>
          <input name="teacherName" type="text" class="form-control" id="teacherName" value="<?php echo $teacherName; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Zatwierdź</button>
      </div>
    </form>

  </div>

  <?php include('layout/footer.php'); ?>

</main>

<?php include('layout/scripts.php'); ?>

</body>

</html>