<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
  
  $death = [];
  $c = 1;
  
  foreach($_SESSION["gexams2"] as $value) {
    $death[] = array("eid" => /*$_SESSION["neid"]*/ $value['eid'], "student" => $_POST['student'], "question" => $value["question"], "answer" => $value["student_answer"], "correct" => $value["correct_answer"], "score" => $_POST["score".$c],"type" => $value['type'], "comments" => $_POST["textarea".$c], "feedback" => $value['feedback']);
    $c++;
  }
  
  

  $encoded = json_encode($death, JSON_PRETTY_PRINT);
  //echo var_dump($encoded);
  //echo $encoded;
  $curl = curl_init();
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_finalize.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("array" => $encoded));

  $result = curl_exec($curl);
  echo $result;
  $decoded = json_decode($result, true);
  
  curl_close($curl);
  
  echo "<br><br>";
  echo "<a href='https://afsaccess4.njit.edu/~ml626/teacher.php'>Back</a>";
?>