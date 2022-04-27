<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
?>
  
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="page.css">
    <title>Finalize Exam</title>
  </head>

  <body>
    <?php
    
    if(strcmp($status, "Teacher") != 0) {
      header("Location: https://afsaccess4.njit.edu/~ml626");
    }
    
    $death = [];
    $c = 1;
    
    /*echo "<pre>";
    print_r($_POST['scores']);
    echo "<pre>";*/
    
    $feedbacks = array();
    $scores = array();
    
    foreach($_POST['scores'] as $case)
    {
      $feedback = '';
      $score = 0;
      for($i = 0; $i < count($case['score']); $i++)
      {
         $feedback .= $case['feedback'][$i] . "_" . $case['score'][$i] . "%";
         $score += $case['score'][$i];
      }
      $feedbacks[] .= $feedback;
      $scores[] += $score;
    }
    
    /*echo "<pre>";
    print_r($feedbacks);
    echo "<pre>";*/
    
    foreach($_SESSION["gexams2"] as $value) {
      $death[] = array("eid" => $value['eid'], "student" => $_POST['student'], "question" => $value["question"], "answer" => $value["student_answer"], "correct" => $value["correct_answer"], "score" => $scores[$c-1],"type" => $value['type'], "comments" => $_POST["textarea".$c], "feedback" => $feedbacks[$c-1]);
      $c++;
    }
  
    $encoded = json_encode($death, JSON_PRETTY_PRINT);
    //echo var_dump($encoded);
    //echo $encoded;
    $curl = curl_init();
    
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_finalize.php");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, array("array" => $encoded));
  
    $result = curl_exec($curl);
    $decoded = json_decode($result, true);
    
    curl_close($curl);
    
    echo "<p>" . $result . "</p>";
    echo "<br>";
    echo "<a href='https://afsaccess4.njit.edu/~ml626/teacher.php'>
            <input type='button' value='Back' id='button-back' class='button'>
          </a>";
  ?>
  </body>
</html>