<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['choice'])) {
      include './php/dblogin.php';
      //Con is connection to database in login.php
      $choice = $_POST['choice'];
      
      $exams_taken = mysqli_query($con, "SELECT * FROM `Answers` WHERE eid=$choice;");
      //echo $choice;
      if(mysqli_num_rows($exams_taken) > 0)
      {
        echo json_encode(array(), JSON_PRETTY_PRINT);
        exit();
      }
      
      $query = mysqli_query($con, "SELECT * FROM `Exam` where number=$choice;");
      
      $questions = [];
      
      while($row = mysqli_fetch_assoc($query)) {
        $questions[] = $row;
      }
      
      echo json_encode($questions, JSON_PRETTY_PRINT);
    }
  }
?>