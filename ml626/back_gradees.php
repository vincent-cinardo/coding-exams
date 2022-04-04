<?php
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if(!empty($_POST['students']))
    {
      include './php/dblogin.php';   
    }
    if(!empty($_POST['exams']))
    {
      include './php/dblogin.php';
      
      $result = mysqli_query($con, "SELECT DISTINCT `eid`, `student`, Exam.name FROM `Answers` INNER JOIN `Exam` where eid = number");
      $exams = [];
      
      while ($row = mysqli_fetch_assoc($result))
      {
        $exams[] = $row;
      }
      
      echo json_encode($exams, JSON_PRETTY_PRINT);
    }
  }
?>