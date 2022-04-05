<?php
  if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(!empty($_POST['array'])) {
      include './php/dblogin.php';
      
      $grades = json_decode($_POST['array'], true);
      
      $eid = $grades[0]['eid'];
      $student = $grades[0]['student'];
      
      $query = mysqli_query($con, "SELECT * from `Grades` WHERE eid=$eid AND student='$student';");
      
      if(mysqli_num_rows($query) > 0)
      {
        echo "Exam already taken, cannot grade this again.";
      }
      else
      {
        foreach($grades as $grade)
        {
          $eid = $grade['eid'];
          $student = $grade['student'];
          $question = $grade['question'];
          $answer = $grade['answer'];
          $score = $grade['score'];
          $comments = $grade['comments'];
          $feedback = mysqli_real_escape_string($con, $grade['feedback']);
          
          mysqli_query($con, "INSERT INTO `Grades`(`eid`, `student`, `question`, `answer`, `score`, `comments`, `feedback`) VALUES ($eid, '$student', '$question', '$answer', $score, '$comments', '$feedback');");
        }
        
        echo "Exam has been successfully graded.";
      }
      
    }
  }
?>