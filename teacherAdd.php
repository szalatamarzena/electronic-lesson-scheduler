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
  if (!isset($_POST['teacherName']))
  {
    header("Location: error.php?message=" . "Nastąpił błąd w trakcie dodawania nauczyciela");
    die();
  }
  else
  {
    $sql = "INSERT INTO teachers (name) VALUES (:name)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $_POST['teacherName']);
    $result = $stmt->execute();

    if ($result === TRUE)
    {
      header("Location: teachers.php");
      die();
    }
    else
    {
      header("Location: error.php?message=" . "Nastąpił błąd w trakcie dodawania nauczyciela");
      die();
    }
  }
}

?>

<html>

<?php include('layout/head.php'); ?>

<body>

<?php include('layout/header.php'); ?>

<main role="main">

  <div class="container">
    
    <h2>Dodawanie nauczyciela</h2>
    <br>

    <form class="edit-form" method="post">
      <div class="clearfix">
        <div class="form-group">
          <label for="teacherName">Nazwa nauczyciela</label>
          <input name="teacherName" type="text" class="form-control" id="teacherName">
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