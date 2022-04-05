<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Student") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }

  $curl = curl_init();
          
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_take.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("choice" => $_POST["exams"]));
  
  $result = curl_exec($curl);
  $decoded = json_decode($result, true);
  //echo print_r($decoded);
  $_SESSION["qs"] = [];
  curl_close($curl);
  
  $c = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Taking Exam</title>
</head>

<body>
  <form method="post" action="/~ml626/takeexam_submit.php">
    <?php
        if(empty($decoded))
        {
          //echo $result;
          echo "You have already taken this exam, choose another.";
          echo "<br><br>";
          echo "<a href=\"https://afsaccess4.njit.edu/~ml626/takeexam.php\">Back</a>";
        }
        else
        {
          foreach ($decoded as $value) {
            $_SESSION["qs"][] = $value["question"];
            echo "<p>" . $c . ". " . $value["question"] . "<b> " . $value['score'] ." Points " . "</b></p>";
            //echo "<b>Attention Michael, replace 'score1' with 'score' when backend is updated, in takeexam_front.php<br>"."</b>"; 
            echo "<textarea id=$c name=$c rows='10' cols='60'></textarea><br><br>";
            $c++;
          }
          $_SESSION["eid"] = $_POST["exams"];
          $_SESSION["numquestions"] = $c;
          
          echo "<br><br>";
          echo "<input type=\"submit\" name=\"take\" id=\"take\" value=\"Submit Exam\">";
          echo "</form>";
        }
    ?>
          

</body>

</html>