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
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("eid" => $_POST['exams'], "student" => $_POST['student']));
  
  $result = curl_exec($curl);
  $decoded = json_decode($result, true);
  
  #echo var_dump($result);
  
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
  <link rel="stylesheet" href="page.css">
  <title>Exams</title>
  
  <style>
  textarea {
    resize: none;
  }
  
  table {
    border: 1px solid;
    border-color: white;
    width: 40%;
  }
  
  td, th {
    border: 1px solid;
    border-color: white;
  }
  </style>
  
  <script>
    function()
    {
    
    }
  </script>
  
</head>

<body>
    
  <form method="post" action="/~ml626/gradeexam_finalize.php" name="scores">
    <?php
      $index = 0;
      foreach($decoded as $value)
      {  
        echo "<h3>" . $c . ". " . $value["question"] . " " . $value['score'] . "/" . $value['max_score'] . " Points"."</h3>";
        echo "<p>Student Answer: ".$value["student_answer"]."</p>";
        echo "<p>Correct Answer: ".$value["correct_answer"]."</p>";
        echo "<p>Constraint: ".$value["constraint"]."</p>";
        echo "<table>";
        echo "<tr>
          <th>Test Case</th> <th>Expected</th> <th>Answer</th> <th>Score</th>
        </tr>";
    
          
          foreach(explode("%", $value['feedback']) as $feedback)
          {
            $parsed = explode("_", $feedback);
            if(!empty($parsed[0]))
            {
              echo "<tr>";
              echo "<td>";
              echo $parsed[0];
              echo "</td>";
              echo "<td style=\"width: 20%; text-align:center;\">";
              echo $parsed[1];
              echo "</td>";
              echo "<td style=\"width: 20%; text-align:center;\">";
              echo $parsed[2];
              echo "</td>";
              echo "<td style=\"width: 20%; text-align:center;\">";
              echo "<input style=\"width: 92%; text-align:center;\" value=\"" . round(htmlspecialchars($parsed[3]), 2) . "\" name=\"scores[$index][score][]\">";
              echo "<input type=\"hidden\" value=\"" . htmlspecialchars($parsed[0]) . "_" . htmlspecialchars($parsed[1]) . "_" . htmlspecialchars($parsed[2]) . "\" name=\"scores[$index][feedback][]\">";

              echo "</td>";
              echo "</tr>";
            }   
          }
          $index++;
         echo "<tr><td style=\"text-align: center;\" colspan=\"3\">"."Total"."</td><td style=\"text-align: center;\">".$value['score']."</td></tr>";
        echo "</table>";
        echo "<p>Comments</p><textarea name=textarea$c rows=5 cols=60></textarea><br><br>";
        $c++;
      }
      
      echo "<input type=\"hidden\" id=\"student\" name=\"student\" value=\"".$_POST['student']."\">";
      echo "<input type=\"submit\" value=\"Finalize Scores\" class=\"button\">";
      echo "</form>";
    //}
  ?>
</body>

</html>