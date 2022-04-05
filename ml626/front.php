<?php
  session_start();
  
  $username = $_POST["username"];
  $password = $_POST["password"];
  
  if (!empty($username) && !empty($password)) {
    $curl = curl_init();
    
    curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle.php");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, array('username' => $username, 'password' => $password));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($curl);
    $decoded = json_decode($result);
    $status = $decoded->status;
    $_SESSION["status"] = $status;
    $_SESSION["user"] = $username;
    
    if (strcmp($status, "Student") == 0) {
      header("Location: https://afsaccess4.njit.edu/~ml626/student.php");
    } elseif (strcmp($status, "Teacher") == 0) {
      header("Location: https://afsaccess4.njit.edu/~ml626/teacher.php");
    } else {
      header("Location: https://afsaccess4.njit.edu/~ml626");
    }
    
    curl_close($curl);
  }
?>