<?php
  if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(!empty($_POST['examnum']) && !empty($_POST['student'])) {
      include './php/dblogin.php';
      
      $number = $_POST['examnum'];
      $student = $_POST['student'];
      
      $query = mysqli_query($con, "SELECT `number`, `student`, `question`, `answer` FROM Exam WHERE eid=$number AND student='$student';");
      
      $questions = [];
    
      while($row = mysqli_fetch_row($query))
      {
        $questions[] = array('number' => $row[0], 'name' => $row[1], 'number' => $row[2], 'name' => $row[3]);
      }
      
      echo json_encode($questions, JSON_PRETTY_PRINT);
    }
  }
?>