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
  <title>Exams</title>
  
  <style>
    textarea {
      resize: none;
      display: inline-block;
    }

    table, th, td {
      border: 1px solid;
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
        echo "<p>Comments</p><textarea readonly name=textarea$c rows=5 cols=60>" . $value["comments"] . "</textarea><br><br>";
        
        $c++;
      }
    ?>
    </div>
    
    <div style="flex:1;">
      
      <?php
        $types = array(); //switch probably not needed, we can delete after we ask
        
        foreach($decoded as $value)
        {
          if(!in_array($value['type'], $types))
          {
            $types[] = $value['type'];
          }
        }
        
        foreach($types as $type)
        {
          
          $difficulties = array();
          
          foreach($decoded as $value)
          {
            if(!in_array($value['difficulty'], $difficulties))
            {
              $difficulties[] = $value['difficulty'];
            }
          }
          
          echo "<table style=\"width: 100%;\">";
          echo "<tr>";
            switch($type)
            {
              case "for":
                echo "<td colspan=100 style=\"text-align: center;\"><h3>For Loops</h3></td>";
                break;
              case "while":
                echo "<td colspan=100 style=\"text-align: center;\"><h3>While Loops</h3></td>";
                break;
              case "switch":
                echo "<td colspan=100 style=\"text-align: center;\"><h3>Switch Statements</h3></td>";
                break;
              case "arithmetic":
                echo "<td colspan=100 style=\"text-align: center;\"><h3>Arithmetic</h3></td>";
                break;                
              case "recursion":
                echo "<td colspan=100 style=\"text-align: center;\"><h3>Recursion</h3></td>";
                break;
              case "string":
                echo "<td colspan=100 style=\"text-align: center;\"><h3>Strings</h3></td>";
                break;
            }
          echo "</tr>";
          
          foreach($difficulties as $difficulty)
          {
            echo "<tr>";
            
            switch($difficulty)
            {
              case "EASY":
                echo "<td rowspan=100 style=\"text-align: center; width: 15%;\"><h4>Easy</h4></td>";
                break;
              case "MEDIUM":
                echo "<td rowspan=100 style=\"text-align: center; width: 15%;\"><h4>Medium</h4></td>";
                break;
              case "HARD":
                echo "<td rowspan=100 style=\"text-align: center; width: 15%;\"><h4>Hard</h4></td>";
                break;
            }
            
            echo "</tr>";
            
            foreach($decoded as $value)
            {
              if($value['difficulty'] == $difficulty && $value['type'] == $type)
              {
                echo "<tr><td colspan=100>Question: " . $value['question'] . "</td></tr>";
                foreach(explode("%", $value['feedback']) as $feedback)
                {
                  
                  if(!empty($feedback[0]))
                  {
                    $feedback = explode("_", $feedback);
                    echo "<tr><td>";
                    echo $feedback[0];
                    echo "</td>";
                    
                    $color = "red";
                    
                    if(preg_match('/\+/', $feedback[1]))
                    {
                      $color = "green";
                    }
                    
                    echo "<td style=\"text-align: center; background-color: $color; color: black; width: 10%;\">";
                    echo $feedback[1];
                    echo "</td></tr>";
                  }
                }
              }
            }
          }
          
          echo "</table>";
        }
        
      ?>
      
    </div>
  </div>
  
  <br><br>
  <a href="https://afsaccess4.njit.edu/~ml626/viewresults.php">Back</a>
</body>

</html>