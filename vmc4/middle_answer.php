<?php
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(!empty($_POST['answers']))
    {
      $curl = curl_init("https://afsaccess4.njit.edu/~as3638/back_answer.php");
      //$curl = curl_init("https://afsaccess4.njit.edu/~vmc4/back_answer.php");
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array('answers' => $_POST['answers']));
        
      $result = curl_exec($curl);
        
      if(curl_errno($curl)){
        echo 'Curl error: ' . curl_error($ch);
      }
        
      echo $result; 
        
      curl_close($curl);
    }
  }
?>