<?php
  session_start();
  $status = $_SESSION["status"];
    
  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }

  $curl = curl_init();
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_autograde.php");
  curl_setopt($curl, CURLOPT_POST, true);
  //curl_setopt($curl, CURLOPT_POSTFIELDS, array("eid" => $_SESSION["gexams"][$_POST["exams"]]["eid"], "student" => $_SESSION["gexams"][$_POST["exams"]]["student"]));
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("eid" => $_POST['exams'], "student" => $_POST['student']));
  
  $result = curl_exec($curl);
  //echo var_dump($result); //NOTE THE ARRAY THAT COMES BACK DOES NOT HAVE STUDENT IN IT. We don't need anyway but idk wby this is happening
  $decoded = json_decode($result, true);
  
  //echo $_POST['student'] . " This is post";
  //echo $decoded['student'] . " This is decoded";
  
  curl_close($curl);
  
  $_SESSION["neid"] = $_SESSION["gexams"][$_POST["exams"]]["eid"];
  $_SESSION["nstudent"] = $_SESSION["gexams"][$_POST["exams"]]["student"];
  $_SESSION["gexams2"] = $decoded;
  
  $c = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Exams</title>
  
  <style>
  textarea {
    resize: none;
  }
  
  table {
    border: 1px solid black;
    width: 30%;
  }
  
  td {
    border: 1px solid black;
  }
  </style>
</head>

<body>
    
  <form method="post" action="/~ml626/gradeexam_finalize.php">
    <?php
    if($result)
    {
    
    
    }
      foreach($decoded as $value)
      {  
        $score = $value['max_score'];
        echo "<h3>" . $c . ". " . $value["question"] . " $score Points"."</h3>";
        echo "<p>Student Answer: ".$value["student_answer"]."</p>";
        echo "<p>Correct Answer: ".$value["correct_answer"]."</p>";
        echo "<table>";
        echo "<tr>";
          echo "<td colspan=\"2\" style=\"width: 100%;\">Scores</td>";
        echo "</tr>";
        
          foreach(explode("%", $value['feedback']) as $feedback)
          {
            $parsed = explode("_", $feedback);
            if(!empty($parsed[0]))
            {
              echo "<tr>";
              echo "<td>";
              echo $parsed[0];
              echo "</td>";
              echo "<td style=\"width: 10%; text-align:center;\">";
              echo $parsed[1];
              echo "</td>";
              echo "</tr>";
            }
          }
          
          echo "<tr>";
          echo "<td>Total Score (edit)</td>";
          echo "<td> " . "<input style=\"width: 100px; text-align: center;\" value=" . $value["score"] . " name=score$c>" . "</td>";
          echo "</tr>";
        
        echo "</table>";
        echo "<p>Comments</p><textarea name=textarea$c rows=5 cols=60></textarea><br><br>";
        $c++;
      }
      
      echo "<input type=\"hidden\" id=\"student\" name=\"student\" value=\"".$_POST['student']."\">";
      echo "<br><br>";
      echo "<input type=\"submit\" value=\"Finalize Scores\">";
      echo "</form>";
    //}
  ?>
</body>

</html>