<?php
  session_start();
  $status = $_SESSION["status"];
    
  if(strcmp($status, "Student") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }

  $curl = curl_init();
      
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_show_exams.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, 0);
    
  $result = curl_exec($curl);
  $decoded = json_decode($result, true);
  
  curl_close($curl);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="page.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Take Exam</title>  
  <h4>Take Exam</h4>
  <p>Please select an exam to take.</p>  
</head>

<body>
  <form method="post" action="/~ml626/takeexam_front.php">
    <select name="exams" id="exams">
      <?php
        foreach ($decoded as $value) {
          echo "<option value=".$value['number'].">" . $value["name"] . "</option>";
        }
      ?>
    </select><br><br>
          
    <input type="submit" name="take" id="take" value="Take Exam" class="button">
  </form>
  
  <a href="https://afsaccess4.njit.edu/~ml626/student.php">
    <input type="button" value="Back" id="button-back" class="button">
  </a>
</body>

</html>