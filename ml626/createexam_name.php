<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <h1>Create Exam</h1>
  
  <style>
  textarea {
    resize: none;
  }
  </style>
</head>

<body>
  <main id="main-holder">
    <form method="post" action="/~ml626/createexam_front.php">
      <input type="text" name="name" id="name" placeholder="Exam name"><br><br>
      <input type="submit" value="Finalize Questions" id="submit">
    </form>
  </main>
</body>