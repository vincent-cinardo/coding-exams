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
    <link rel="stylesheet" href="page.css">
    <title>Student Landing</title>
    <h4>
      <?php
        echo "Welcome " . $_SESSION["user"] . "!";
      ?>
    </h4>
  </head>
  
  <body>
    <a href="https://afsaccess4.njit.edu/~ml626/takeexam.php">
      <input type="button" value="Take Exam" id="button-takeexam" class="button">
    </a>
    <br>
    <a href="https://afsaccess4.njit.edu/~ml626/viewresults.php">
      <input type="button" value="View Results" id="button-viewresults" class="button">
    </a>
    <br><br>
    <a href="https://afsaccess4.njit.edu/~ml626">
      <input type="button" value="Log Out" id="button-viewresults" class="button">
    </a>
  </body>
</html>