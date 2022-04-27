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
  <title>Create Exam</title>
  <h4>Create Exam Result</h4>
</head>

<body>
  <?php
    $encoded = json_encode($_SESSION["exam"], JSON_PRETTY_PRINT);
    
    $curl = curl_init();
        
    curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_make.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, array("name" => $_POST["name"], "exam" => $encoded));
    
    $result = curl_exec($curl);
    
    $_SESSION["exam"] = array();
      
    curl_close($curl);
    
    if (!empty($result)) {
      echo "<p>" . $result . "<p>";
    }
    
    echo "<br><br>";
    echo "<a href='https://afsaccess4.njit.edu/~ml626/teacher.php'>
            <input type='button' value='Back' id='button-back' class='button'>
          </a>";
  ?>
</body>

</html>