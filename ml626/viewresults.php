<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Student") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
  
  $curl = curl_init();
    
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_results.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("student" => $_SESSION["user"]));

  $result = curl_exec($curl);
  $decoded = json_decode($result, true);
  
  curl_close($curl);
  
  $c = 0;
    
  $_SESSION["pexams"] = $decoded;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="page.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Results</title>  
  <h4>View Results</h4>
  <p>Please select an exam to review.</p>  
</head>

<body>
  <form method="post" action="/~ml626/viewresults_front.php">
    <select name="exams" id="exams">
      <?php
        foreach ($decoded as $value) {
          echo "<option value=$c>" . $value["student"] . " - ". $value['name'] . "</option>";
          $c++;
        }
      ?>
    </select><br><br>
          
    <input type="submit" name="view" id="view" value="View Results" class="button">
  </form>
  <a href="https://afsaccess4.njit.edu/~ml626/student.php">
    <input type="button" value="Back" id="button-back" class="button">
  </a>
</body>

</html>