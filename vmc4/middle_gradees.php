<?php
  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if(!empty($_POST['students']))
    {
      $curl = curl_init();
      
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~as3638/back_gradees.php");
      #curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/back_gradees.php");
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array('students' => $_POST['students']));
  
      $result = curl_exec($curl);
      echo $result;
      curl_close($curl);
    }
    if(!empty($_POST['exams']))
    {
      $curl = curl_init();
      
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~as3638/back_gradees.php");
      #curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/back_gradees.php");
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array('exams' => $_POST['exams']));
  
      $result = curl_exec($curl);
      echo $result;
      curl_close($curl);
    }
  }
?>