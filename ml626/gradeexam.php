<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }

  $curl = curl_init();
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_gradees.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("exams" => "exams"));

  $result = curl_exec($curl);
  $decoded = json_decode($result, true);
  //echo $result;
  
  $_SESSION["gexams"] = $decoded;
  
  curl_close($curl);
  
  $c = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grade Exams</title>  
  <h1>Grade Exams</h1>
  <p>Please select an exam to grade.</p>  
</head>

<body>
  <form method="post" action="/~ml626/gradeexam_student.php">
    <select name="exams" id="exams">
      <?php
        foreach ($decoded as $value) {
          echo "<option value=" . $value["eid"] . ">" . $value["student"] . " - " . $value["name"] . "</option>";
          $c++;
        }
      ?>
    </select><br><br>
    <?php
      echo "<input type=\"hidden\" id=\"student\" name=\"student\" value=".$value["student"].">";
    ?>
    
    <input type="submit" name="grade" id="grade" value="Grade Exam">
  </form>
    
  <br><br>
  <a href="https://afsaccess4.njit.edu/~ml626/teacher.php">Back</a>
</body>

</html>