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
  
  echo $result;
  echo "<br><br>";
  echo "<a href='https://afsaccess4.njit.edu/~ml626/student.php'>Back</a>";
?>