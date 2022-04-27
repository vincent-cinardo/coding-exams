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
  $_SESSION["qs"] = [];
  $_SESSION["exam_data"] = $decoded;
  curl_close($curl);
  
  $b = 1;
  $c = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="page.css">
  <title>Taking Exam</title>
</head>

<body>
  <?php
    if(!empty($decoded)) {
      foreach ($decoded as $value) {
        echo "<button class='button2' onclick='show(this.id)' id='button". $b . "'>#" . $b . "</button>";
        $b++;
      }
    }
  ?>
  <form method="post" action="/~ml626/takeexam_submit.php">
    <?php
        if(empty($decoded))
        {
          echo "<p>You have already taken this exam, choose another.</p>";
          echo "<br>";
          echo "<a href='https://afsaccess4.njit.edu/~ml626/student.php'>
                  <input type='button' value='Back' id='button-back' class='button'>
                </a>";
        }
        else
        {
          foreach ($decoded as $value) {
            $_SESSION["qs"][] = $value["question"];
            echo "<p id=p" . $c . ">" . $c . ". " . $value["question"] . "<b> " . $value['score'] ." Points " . "</b></p>";
            echo "<textarea id=$c name=$c rows='10' cols='60'></textarea>";
            $c++;
          }
          
          $_SESSION["eid"] = $_POST["exams"];
          $_SESSION["numquestions"] = count($decoded) + 1;
          
          echo "<br>";
          echo "<input type=\"submit\" name=\"take\" id=\"take\" value=\"Submit Exam\" class=\"button\">";
          echo "</form>";
        }
    ?>
  </form>
    
  <script>
    var m = <?php echo($b); ?>;
    show("button1", m);
  
    function show(id) 
    {
      var n = id.substring(6);
      var max = <?php echo($b); ?>;
      
      for (let i = 1; i < max; i++) {
        var x = document.getElementById(i);
        var px = document.getElementById("p" + i);
        
        if (i != n) {
          x.style.display = "none";
          px.style.display = "none";
        } else {
          x.style.display = "block";
          px.style.display = "block";
        }
      }
    }
  </script>

</body>

</html>