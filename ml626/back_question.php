<?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include './php/dblogin.php';
    
    if( !empty($_POST['question']) && !empty($_POST['answer']) && !empty($_POST['difficulty']) && !empty($_POST['testcases']) && !empty($_POST['type']) ) 
    {
      $question = $_POST['question'];
      $answer = $_POST['answer'];
      $difficulty = $_POST['difficulty'];
      $testcases = $_POST['testcases'];
      $type = $_POST['type'];
      
      //Con is connection to database in login.php
      if(!empty($testcases))
      {
        $status = mysqli_query($con, "INSERT INTO `Questions`(`question`, `answer`, `difficulty`, `testcases`, `type`) VALUES ('$question','$answer','$difficulty','$testcases','$type');");
      }
      
      if ($status)
      {
        echo "Success";
      }
      else
      { 
        echo 0;
      }
    }
  }
?>