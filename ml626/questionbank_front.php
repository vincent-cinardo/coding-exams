<?php
  session_start();
  $status = $_SESSION["status"];

  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
  
  $difficulty = strtoupper($_POST["difficulty"]);
  $question = $_POST["question"];
  $answer = $_POST['answer'];
  $testcases = $_POST['testcases'];
  $type = $_POST['type'];
  $constraint = $_POST['constraint'];
  
  $curl = curl_init();
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_question.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("question" => $question, "answer" => $answer, "difficulty" => $difficulty, "testcases" => $testcases, "type" => $type, "constraint" => $constraint));
  
  $result = curl_exec($curl);
  curl_close($curl);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="page.css">  <title>New Question Result</title>
  <h4>New Question Result</h4>
</head>

<body>
  <?php
    switch ($result)
    {
      case 'Success':
        echo "<p>Successfully added to database.</p>";
        break;
      default:
        echo "<p>Failed to add to database.</p>";
    }
    
    echo "<br>";
    echo "<a href='https://afsaccess4.njit.edu/~ml626/teacher.php'>
            <input type='button' value='Back' id='button-back' class='button'>
          </a>";
  ?>
</body>

</html>