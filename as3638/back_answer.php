<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['answers'])) {
      include './php/dblogin.php';
      //Con is connection to database in login.php
      $cases = json_decode($_POST['answers'], true);

      foreach($cases as $case) {
        $eid = $case['eid'];
        $student = $case['student'];
        $question = mysqli_real_escape_string($con, $case['question']);
        $answer = mysqli_real_escape_string($con, $case['answer']);
        
        mysqli_query($con, "INSERT INTO `Answers`(`eid`, `student`, `question`, `answer`) VALUES ($eid, '$student', '$question', '$answer')");
      }
      
      echo "Exam successfully submitted!";
    }
  }
?>