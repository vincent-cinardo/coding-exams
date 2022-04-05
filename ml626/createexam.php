<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
  
  $_SESSION["exam"];
  
  $curl = curl_init();
    
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_bank.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, 0);

  $result = curl_exec($curl);
  $decoded = json_decode($result, true);
  
  curl_close($curl);
  
  $c = 0;
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Exam</title>
  <h1>Create Exam</h1>
</head>

<body>
  <main id="main-holder">
    <form method="post">
      <select name="questions" id="questions">
        <?php
          foreach ($decoded as $value) {
            echo "<option value=$c>" . $value["question"] . "</option>";
            $c++;
          }
        ?>
      </select><br>
      
      <p>Score:</p>
      <input type="number" name="score" id="score" placeholder="Enter a value"><br><br>
      
      <!--  NOTE TO MICHAEL: Commented out your stuff here
      <input type="number" name="score_function" id="score_function" placeholder="Function name"> -->
      <!-- <input type="number" name="score_tc1" id="score_tc1" placeholder="Test case 1"><br> -->
      <!--<input type="number" name="score_tc2" id="score_tc2" placeholder="Test case 2"><br><br>  -->

      <input type="submit" value="Add to Exam" name="add" id="add"><br>
    </form>
    
    <?php
      if(!empty($_POST["score"])/*!empty($_POST["score_function"]) && !empty($_POST["score_tc1"]) && !empty($_POST["score_tc2"]) ANOTHER NOTE TO MICHAEL: edited this, hope I didn't fuck it up*/) 
      {
        if(isset($_POST["add"])) {
          /*$_SESSION["exam"][] = array("question" => $decoded[$_POST["questions"]]["question"], "answer" => $decoded[$_POST["questions"]]["answer"], "score1" => $_POST["score_function"], "score2" => $_POST["score_tc1"], "score3" => $_POST["score_tc2"]);*/
          
          $_SESSION["exam"][] = array("question" => $decoded[$_POST["questions"]]["question"], "answer" => $decoded[$_POST["questions"]]["answer"], "score" => $_POST["score"]);
          
          if (!empty($_SESSION["exam"])) {
            echo "<h1>Current Exam Questions</h1>";
          }
          
          foreach ($_SESSION["exam"] as $value) {
            //echo $value["question"] . "\t" . $value["score1"] . "\t" . $value["score2"] . "\t" . $value["score3"] . "<br>";
            echo $value["question"] . "\t" . "<b>". $value["score"] . " Points". "</b>" . "<br>";
          }
        }
      }
    ?>
    
    <br>
    <form method="post" action="/~ml626/createexam_name.php">
      <input type="submit" value="Finalize Questions" id="submit">
    </form>
  </main>
    
  <br><br>
  <a href="https://afsaccess4.njit.edu/~ml626/teacher.php">Back</a>
</body>

</html>