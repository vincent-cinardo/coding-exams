<?php
  session_start();
  $status = $_SESSION["status"];

  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
  
  $encoded = json_encode($_SESSION["exam"], JSON_PRETTY_PRINT);
  
  $curl = curl_init();
      
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_make.php");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, array("name" => $_POST["name"], "exam" => $encoded));
  
  $_SESSION["exam"] = array();
  
  $result = curl_exec($curl);
    
  curl_close($curl);
  
  if (!empty($result)) {
    echo $result;
  }
  
  echo "<br><br>";
  echo "<a href='https://afsaccess4.njit.edu/~ml626/teacher.php'>Back</a>";
?>
