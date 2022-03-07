<?php
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //$curl = curl_init("https://afsaccess4.njit.edu/~as3638/backend.php"); #use new address depending on backend
    $curl = curl_init("https://afsaccess4.njit.edu/~as3638/questionsend.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);

    $result = curl_exec($curl);
      
    if(curl_errno($curl)){
      echo 'Curl error: ' . curl_error($ch);
    }
      
    echo $result; #An array of questions to be put in the word bank, for the teacher to select for the exam.
      
    curl_close($curl);
  }
?>