<?php

  if($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = $_POST['username'];
    $pass = $_POST['password'];

    if(!empty($name) && !empty($pass)) {
      $curl = curl_init("https://afsaccess4.njit.edu/~as3638/backend.php");
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array("username" => $name, "password" => $pass));

      $result = curl_exec($curl);
      
      if(curl_errno($curl)){
        echo 'Curl error: ' . curl_error($ch);
      }
      
      $decoded = json_decode($result);
      $json = json_encode($decoded);
      
      echo $json;
      
      curl_close($curl);
    }
  }
  
?>