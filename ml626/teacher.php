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
    <link rel="stylesheet" href="page.css">
    <title>Teacher Landing</title>
    <h4>
      <?php
        echo "Welcome " . $_SESSION["user"] . "!";
      ?>
    </h4>
  </head>
  
  <body>
    <a href="https://afsaccess4.njit.edu/~ml626/questionbank.php">
      <input type="button" value="Create Question" id="button-createquestion" class="button">
    </a>
    <br>
    <a href="https://afsaccess4.njit.edu/~ml626/createexam.php">
      <input type="button" value="Create Exam" id="button-createexam" class="button">
    </a>
    <br>
    <a href="https://afsaccess4.njit.edu/~ml626/gradeexam.php">
      <input type="button" value="Grade Exams" id="button-gradeexam" class="button">
    </a>
    <br><br>
    <a href="https://afsaccess4.njit.edu/~ml626">
      <input type="button" value="Log Out" id="button-viewresults" class="button">
    </a>
  </body>
</html>