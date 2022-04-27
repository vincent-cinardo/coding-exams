<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Student") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }

  $answers = [];
  $b = 0;
  
  for ($a = 1; $a < $_SESSION["numquestions"]; $a++) {
    $answers[] = array("eid" => $_SESSION["eid"], "student" => $_SESSION["user"], "question" => $_SESSION["qs"][$b], "answer" => $_POST[$a]);
    $b++;
  }
  
  $curl = curl_init();
      
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_answer.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("answers" => json_encode($answers, JSON_PRETTY_PRINT)));
  
  $result = curl_exec($curl);
  $decoded = json_decode($result, true);
  
  curl_close($curl);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="page.css">  <title>Submit Exam Result</title>
  <h4>Submit Exam Result</h4>
</head>

<body>
  <?php
    echo "<p>" . $result . "</p>";
    echo "<br>";
    echo "<a href='https://afsaccess4.njit.edu/~ml626/student.php'>
            <input type='button' value='Back' id='button-back' class='button'>
          </a>";
  ?>
</body>

</html>