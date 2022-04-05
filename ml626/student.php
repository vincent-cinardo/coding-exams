<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Student") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Student</title>
    <h4>
      <?php
        echo "Welcome " . $_SESSION["user"] . "!";
      ?>
    </h4>
  </head>
  <body>
    <a href="https://afsaccess4.njit.edu/~ml626/takeexam.php">Take Exam</a>
    <br>
    <a href="https://afsaccess4.njit.edu/~ml626/viewresults.php">View Results</a>
  </body>
</html>