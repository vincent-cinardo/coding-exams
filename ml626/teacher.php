<?php
  session_start();
  $status = $_SESSION["status"];

  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Teacher Landing</title>
    <h4>
      <?php
        echo "Welcome " . $_SESSION["user"] . "!";
      ?>
    </h4>
  </head>
  <body>
    <a href="https://afsaccess4.njit.edu/~ml626/questionbank.php">Create Question</a>
    <br>
    <a href="https://afsaccess4.njit.edu/~ml626/createexam.php">Create Exam</a>
    <br>
    <a href="https://afsaccess4.njit.edu/~ml626/gradeexam.php">Grade Exams</a>
  </body>
</html>