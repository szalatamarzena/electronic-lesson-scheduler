<?php

session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true)
{
  header("Location: login.php");
  die();
}

$consts['currentPage'] = 'landingPage';

require_once("dbconfig.php");

$dateTime = DateTime::createFromFormat('H:i:s', '07:10:00');

$sql = " SELECT timetable.id as id, 
                timetable.time_id as time_id, 
                timetable.day as day, 
                times.start as start, 
                times.end as end,
                classes.name as name,
                teachers.name as teacher
           FROM timetable 
LEFT OUTER JOIN times ON timetable.time_id = times.id
LEFT OUTER JOIN classes ON timetable.class_id = classes.id
LEFT OUTER JOIN teachers ON timetable.teacher_id = teachers.id
       ORDER BY times.start";

$classData = [];
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

$sql = "SELECT id, start, end FROM times ORDER BY id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$times = $stmt->fetchAll();

?>

<html>

<?php include('layout/head.php'); ?>

<body>

<?php include('layout/header.php'); ?>

<main role="main">

  <div class="container">

    <table class="table">
      <thead>
        <th>Godz.</th>
        <th>Poniedziałek</th>
        <th>Wtorek</th>
        <th>Środa</th>
        <th>Czwartek</th>
        <th>Piątek</th>
      </thead>
      <tbody>
      <?php

      foreach ($result as $row)
      {
        $classData[$row['start'] . "-" . $row['end']][$row['day']] = $row;
      }

      foreach ($times as $time)
      {
        if (!isset($classData[$time['start'] . "-" . $time['end']]))
        {
          $classData[$time['start'] . "-" . $time['end']] = [];
        }
      }

      ksort($classData);

      foreach ($classData as $time => $row)
      {
        $time = explode('-', $time);
        $startTime = explode(':', $time[0]);
        $endTime = explode(':', $time[1]);

        echo "<tr>";

        echo "<td><i>" . $startTime[0] . ':' . $startTime[1] . " - " . $endTime[0] . ":" . $endTime[1] . "</i></td>";

        if ($_SESSION['accountRole'] == 1)
        {
          for ($i = 1; $i <= 5; $i++)
          {
            if (isset($row[$i]))
            {
              echo "<td><a href='timetableEdit.php?id=" . $row[$i]['id'] . "'><strong>" . $row[$i]['name'] . "</strong><br>" . $row[$i]['teacher'] . "</a></td>";
            }
            else
            {
              echo "<td>-</td>";
            }
          }
        }
        else if ($_SESSION['accountRole'] == 2)
        {
          for ($i = 1; $i <= 5; $i++)
          {
            if (isset($row[$i]))
            {
              echo "<td><strong>" . $row[$i]['name'] . "</strong><br>" . $row[$i]['teacher'] . "</td>";
            }
            else
            {
              echo "<td>-</td>";
            }
          }
        }

        echo "</tr>";
      }

      ?>
      </tbody>
    </table>

    <?php

    if ($_SESSION['accountRole'] == 1)
    {
      echo '
      <div class="clearfix">
        <a class="btn btn-primary float-right" style="color: white" href="timetableAdd.php">Dodaj lekcję</a>
      </div>
      ';
    }

    ?>

  </div>

  <canvas id="clock" width="600" height="600"></canvas>

  <?php include('layout/footer.php'); ?>

</main>

<?php include('layout/scripts.php'); ?>
<script src="js/clock.js"></script>

</body>

</html>