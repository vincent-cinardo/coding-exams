<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['name']) && !empty($_POST['exam'])) {
      include './php/dblogin.php';
      //Con is connection to database in login.php
      
      $name = $_POST['name'];
      $exam = json_decode($_POST['exam'], true);
      $question = mysqli_real_escape_string($con, $_POST['question']);
      $answer = mysqli_real_escape_string($con, $_POST['answer']);
      $score = $_POST['score'];
      
      $result = mysqli_query($con, "SELECT Max(`number`) FROM Exam WHERE 1;");
      $result = mysqli_fetch_array($result);
      
      if($result[0] == NULL)
      {
        foreach($exam as $case)
        {
          $question = mysqli_real_escape_string($con, $case['question']);
          $answer = mysqli_real_escape_string($con, $case['answer']);
          $score = $case['score'];
          mysqli_query($con, "INSERT INTO `Exam`(`number`, `name`, `question`, `answer`, `score`) VALUES (1, '$name', '$question', '$answer', $score)");
        }
        echo "Added first exam into database: $name";
      }
      else
      {
        $num = $result[0] + 1;
        foreach($exam as $case)
        {
          $question = mysqli_real_escape_string($con, $case['question']);
          $answer = mysqli_real_escape_string($con, $case['answer']);
          $score = $case['score'];
          mysqli_query($con, "INSERT INTO `Exam`(`number`, `name`, `question`, `answer`, `score`) VALUES ($num, '$name', '$question', '$answer', $score)");
        }
        echo "Added exam into database: $name";
      }
    }
  }
?>