<?php
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if(!empty($_POST['student']) && empty($_POST['eid']))
    {
      include './php/dblogin.php';
      $student = $_POST['student'];
  
      $result = mysqli_query($con, "SELECT DISTINCT eid, name FROM `Grades` WHERE student='$student'");
      
      $exams = [];
      while($exam = mysqli_fetch_assoc($exams))
      {
        $exams[] = $exam;
      }
      
      echo json_encode($exams, JSON_PRETTY_PRINT);
      curl_close($curl);
    }
    
    if(!empty($_POST['student']) && !empty($_POST['eid']))
    {
      include './php/dblogin.php';
      $student = $_POST['student'];
      $eid = $_POST['eid'];
  
      $result = mysqli_query($con, "SELECT * FROM `Grades` WHERE student='$student' AND eid='$eid'");
      
      $exams = [];
      while($exam = mysqli_fetch_assoc($exams))
      {
        $exams[] = $exam;
      }
      
      echo json_encode($exams, JSON_PRETTY_PRINT);
      curl_close($curl);
    }
  }
?>