<?php
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if(!empty($_POST['array']))
    {
      $curl = curl_init();
      
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      //curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~as3638/back_finalized.php");
      curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/back_finalized.php");
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array('array' => $_POST['array']));
  
      $result = curl_exec($curl);
      echo $result;
      curl_close($curl);
    }
  }
?>