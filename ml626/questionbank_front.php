<?php
  session_start();
  $status = $_SESSION["status"];

  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
  
  $difficulty = strtoupper($_POST["difficulty"]);
  $question = $_POST["question"];
  $answer = $_POST['answer'];
  $testcases = $_POST['testcases'];
  $type = $_POST['type'];
  
  $curl = curl_init();
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_question.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("question" => $question, "answer" => $answer, "difficulty" => $difficulty, "testcases" => $testcases, "type" => $type));
  
  $result = curl_exec($curl);
  
  switch ($result)
  {
    case 'Success':
      echo "Successfully added to database.";
      break;
    default:
      echo "Failed to add to database";
  }
  
  curl_close($curl);
  
  echo "<br><br>";
  echo "<a href='https://afsaccess4.njit.edu/~ml626/teacher.php'>Back</a>";
?>