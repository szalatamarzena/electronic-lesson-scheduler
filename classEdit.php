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
  if (!isset($_POST['classId']) || !isset($_POST['className']))
  {
    header("Location: error.php?message=" . "Nastąpił błąd w trakcie edycji nazwy zajęć");
    die();
  }
  else
  {
    $sql = "UPDATE classes SET name = :name WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $_POST['className']);
    $stmt->bindParam(':id', $_POST['classId']);
    $result = $stmt->execute();

    if ($result === TRUE)
    {
      header("Location: classes.php");
      die();
    }
    else
    {
      header("Location: error.php?message=" . "Nastąpił błąd w trakcie edycji nazwy zajęć");
      die();
    }
  }
}
else if (!isset($_GET['id']))
{
  header("Location: classes.php");
  die();
}

$sql = "SELECT name FROM classes WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();
$result = $stmt->fetch();

if ($result === FALSE)
{
  header("Location: error.php?message=" . "Dany rekord nie istnieje");
  die();
}

$className = $result['name'];

?>

<html>

<?php include('layout/head.php'); ?>

<body>

<?php include('layout/header.php'); ?>

<main role="main">

  <div class="container">
    
    <h2>Edycja przedmiotu</h2>
    <br>

    <form class="edit-form" method="post">
      <div class="clearfix">
        <input hidden name="classId" id="classId" value="<?php echo $_GET['id']; ?>">
        <div class="form-group">
          <label for="className">Nazwa przedmiotu</label>
          <input name="className" type="text" class="form-control" id="className" value="<?php echo $className; ?>">
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