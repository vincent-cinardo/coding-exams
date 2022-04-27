<?php
  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    if(!empty($_POST['name']) && !empty($_POST['exam']))
    {

      //echo $_POST['exam'];
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      #curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/back_make.php");
      curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~as3638/back_make.php");
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array('name' => $_POST['name'], 'exam' => $_POST['exam']));
      
      $result = curl_exec($curl);
      
      echo $result;
      
      curl_close($curl);
    }
  }
?>