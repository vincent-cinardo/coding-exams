<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Student") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }

  $curl = curl_init();
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_results.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("eid" => $_SESSION["pexams"][$_POST["exams"]]["eid"], "student" => $_SESSION["user"]));

  $result = curl_exec($curl);
  $decoded = json_decode($result, true);
  
  curl_close($curl);
  
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
      display: inline-block;
    }

    table, th, td {
      border: 1px solid;
      border-color: white;
    }
    
  </style>
</head>

<body>
  <div style="display: flex;">
    <div style="flex:1;">
    <?php
      foreach($decoded as $value)
      {  
        echo "<h3>" . $c . ". " . $value["question"] . " " . $value['score'] ."/". $value['max_score'] . "</h3>";
        echo "<p>Student Answer: ".$value["student_answer"]."</p>";
        echo "<p>Correct Answer: ".$value["correct_answer"]."</p>";
        
        echo "<table style=\"width: 30%;\">";
        
        echo "<tr><th>Test Case</th> <th>Expected</th> <th>Answer</th> <th>Score</th></tr>";
        
        foreach(explode("%", $value['feedback']) as $feedback)
        {
          
          if(!empty($feedback[0]))
          {
            $feedback = explode("_", $feedback);
            echo "<tr><td>";
            echo $feedback[0];
            echo "</td>";
            
            echo "<td>";
            echo $feedback[1];
            echo "</td>";
            
            echo "<td>";
            echo $feedback[2];
            echo "</td>";
            
            $color = "#FFCCCB";
            
            if($feedback[3] > 0)
            {
              $color = "#90EE90";
            }
            
            echo "<td style=\"text-align: center; background-color: $color; color: black; width: 10%;\">";
            echo round($feedback[3], 2);
            echo "</td></tr>";
          }
        }
        
        echo "<tr><td style=\"text-align: center;\" colspan=\"3\">"."Total"."</td><td style=\"text-align: center;\">".$value['score']."</td></tr>";
        
        echo "</table>";
        
        echo "<p>Comments</p><textarea readonly name=textarea$c rows=5 cols=60>" . $value["comments"] . "</textarea><br><br>";
        
        $c++;
      }
    ?>
    </div>
  </div>
  
  <a href="https://afsaccess4.njit.edu/~ml626/viewresults.php">
    <input type="button" value="Back" id="button-back" class="button">
  </a>
</body>

</html>