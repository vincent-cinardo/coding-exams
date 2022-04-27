<?php
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if(!empty($_POST['student']) && empty($_POST['eid']))
    {
      $curl = curl_init();
      
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~as3638/back_results.php");
      //curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/back_results.php");
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array('student' => $_POST['student']));
  
      $result = curl_exec($curl);
      echo $result;
      curl_close($curl);
    }
    
    if(!empty($_POST['student']) && !empty($_POST['eid']))
    {
      $curl = curl_init();
      
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~as3638/back_results.php");
      //curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/back_results.php");
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array('eid' => $_POST['eid'], 'student' => $_POST['student']));
  
      $result = curl_exec($curl);
      echo $result;
      curl_close($curl);
    }
  }
?>