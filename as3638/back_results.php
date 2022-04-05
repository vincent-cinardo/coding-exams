<?php
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if(!empty($_POST['student']) && empty($_POST['eid']))
    {
      include './php/dblogin.php';
      $student = $_POST['student'];
  
      $result = mysqli_query($con, "SELECT DISTINCT `Grades`.eid, student, name FROM `Grades`, `Exam` WHERE student='$student' AND Exam.number = Grades.eid");
      
      $exams = [];
      while($exam = mysqli_fetch_assoc($result))
      {
        $exams[] = $exam;
      }
      
      echo json_encode($exams, JSON_PRETTY_PRINT);
    }
    
    if(!empty($_POST['student']) && !empty($_POST['eid']))
    {
      include './php/dblogin.php';
      
      $eid = $_POST['eid'];
      $student = $_POST['student'];
  
      $result = mysqli_query($con, "SELECT Grades.`eid`, Grades.`student`, Grades.`question`, Grades.`answer` as student_answer, Grades.`score`, Grades.`comments`, Grades.`feedback`, Exam.score as max_score, Exam.answer as correct_answer, Questions.difficulty, Questions.type FROM `Grades`, `Exam`, `Questions` WHERE Grades.eid=$eid AND Grades.student='$student' AND Grades.eid = Exam.number AND Grades.question = Exam.question AND `Questions`.question = `Exam`.question");
      
      $exams = [];
      while($exam = mysqli_fetch_assoc($result))
      {
        $exams[] = $exam;
      }
      
      echo json_encode($exams, JSON_PRETTY_PRINT);
    }
  }
?>