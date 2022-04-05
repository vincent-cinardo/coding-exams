<?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(!empty($_POST['eid']) && !empty($_POST['student']))
    {
      include './php/dblogin.php';
      
      $eid = $_POST['eid'];
      $student = $_POST['student'];
  
      $query = mysqli_query($con, "SELECT eid, student, name, Exam.question, Answers.answer as student_answer, Exam.answer as correct_answer, score, type, testcases FROM `Exam`, `Questions`, `Answers` WHERE `Exam`.question = `Answers`.question AND eid = `Exam`.number AND `Questions`.question = Exam.question AND Exam.question = Answers.question AND eid = $eid AND Answers.student = '$student';");
      
      $cases = [];
      while($case = mysqli_fetch_assoc($query))
      {
        $cases[] = $case;
      }
      
      echo json_encode($cases, JSON_PRETTY_PRINT);
    }
  }
?>