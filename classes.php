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

$consts['currentPage'] = 'classes';

require_once("dbconfig.php");

$sql = "SELECT id, name FROM classes ORDER BY id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

?>

<html>

<?php include('layout/head.php'); ?>

<body>

<?php include('layout/header.php'); ?>

<main role="main">

  <div class="container">

    <h2>Lista przedmiotów</h2>
    <br>

    <table class="table">
      <colgroup>
        <col style="width:10%;">
        <col>
        <col style="width:10%">
      </colgroup>  
      <thead>
        <th>LP</th>
        <th>Nazwa przedmiotu</th>
        <th></th>
      </thead>
      <tbody>
      <?php

      $i = 1;
      foreach ($result as $class)
      {
        echo "
        <tr>
          <td>" . $i . "</td>
          <td>" . $class['name'] . "</td>
          <td class='table-actions'>
            <div>
              <button type='button' class='btn btn-primary editButton' data-id='" . $class['id'] . "'>Edytuj</button>
              <button type='button' class='btn btn-danger deleteButton' data-id='" . $class['id'] . "'>Usuń</button>
            </div>
          </td>
        </tr>";

        $i++;
      }

      ?>
      </tbody>
    </table>

    <div class="clearfix">
      <a class="btn btn-primary float-right" style="color: white" href="classAdd.php">Dodaj przedmiot</a>
    </div>

  </div>

  <?php include('layout/footer.php'); ?>

</main>

<?php include('layout/scripts.php'); ?>

<script>

var editButtons = document.getElementsByClassName("editButton");
for (var i = 0; i < editButtons.length; i++) {
  editButtons[i].addEventListener('click', function() { EditClass(this.getAttribute('data-id')); }, false);
}

var deleteButtons = document.getElementsByClassName("deleteButton");
for (var i = 0; i < deleteButtons.length; i++) {
  deleteButtons[i].addEventListener('click', function() { DeleteClass(this.getAttribute('data-id')); }, false);
}

function EditClass(id)
{
  var form = document.createElement("form");
  form.method = "get";
  form.action = "classEdit.php";

  var node = document.createElement("input");
  node.name = "id";
  node.value = id;

  form.appendChild(node);
  document.body.appendChild(form);

  form.submit();

  document.body.removeChild(form);
}

function DeleteClass(id)
{
  var form = document.createElement("form");
  form.method = "post";
  form.action = "classDelete.php";

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