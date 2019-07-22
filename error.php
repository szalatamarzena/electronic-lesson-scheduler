<html>

<?php include('layout/head.php'); ?>

<body>

<?php include('layout/header.php'); ?>

<main role="main">

  <div class="container">

    <p><?php if (isset($_GET['message'])) echo $_GET['message']; ?></p>

  </div>

  <?php include('layout/footer.php'); ?>

</main>

<?php include('layout/scripts.php'); ?>

</body>

</html>