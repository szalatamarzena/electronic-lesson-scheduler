<?php

session_start();

$consts['currentPage'] = 'login';
$errors = [];

if (isset($_SESSION['logged']) && $_SESSION['logged'] === true)
{
  header("Location: landingPage.php");
  die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  if (isset($_POST['login']) && isset($_POST['password']))
  {
    require_once("dbconfig.php");

    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, role, password FROM accounts WHERE login = ?");

    if ($stmt->execute([$login]))
    {
      $row = $stmt->fetch();

      if ($row !== false)
      {
        
        if (!password_verify($password, $row['password']))
        {
          header("Location: login.php");
          die();
        }

        $_SESSION['logged'] = true;
        $_SESSION['accountId'] = $row['id'];
        $_SESSION['accountRole'] = $row['role'];

        header("Location: landingPage.php");
        die();
      }
      else
      {
        $errors['login'] = true;
        $errors['password'] = true;
      }
    }
  }
  else
  {
    $errors['login'] = true;
    $errors['password'] = true;
  }
}

?>

<html>

<?php include('layout/head.php'); ?>

<body>

<?php include('layout/header.php'); ?>

<main role="main">

  <div class="container">

    <form class="form-signin" method="post">
      <h1 class="form-signin-heading text-muted">Logowanie</h1>

      <input name="login" type="text" class="form-control <?php echo (isset($errors['login']) ? "is-invalid" : ""); ?>" placeholder="Login" required="true" autofocus="">
      <input name="password" type="password" class="form-control <?php echo (isset($errors['password']) ? "is-invalid" : ""); ?>" placeholder="Hasło" required="true">

      <button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj</button>
    </form>

  </div>

  <?php include('layout/footer.php'); ?>

</main>

<?php include('layout/scripts.php'); ?>

</body>

</html>