<?php

  #Verify if teacher account here?!
  if($_SERVER["REQUEST_METHOD"] == 'POST') {
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $difficulty = $_POST['difficulty'];
    $testcases = $_POST['testcases'];
    $type = $_POST['type'];
    $constraint = $_POST['constraint'];

    if(!empty($question) && !empty($answer) && !empty($difficulty) && !empty($constraint)) {
      #Before sending, need to check the question for syntax errors.
      
      #Make a python file
      $file = fopen("/afs/cad/u/v/m/vmc4/public_html/test.py","w");
      fwrite($file, $answer);
      
      #Run it to check for syntax errors
      $cmd = exec('python test.py', $out, $res);
          
      fclose($file);
      
      if($res == 1) { #Michael expect false, else say teacher has SyntaxError. I think the syntax error will automatically echo.
        echo "Syntax";
        exit();
      }
    
      #$curl = curl_init("https://afsaccess4.njit.edu/~vmc4/back_question.php"); #use new address depending on backend
      $curl = curl_init("https://afsaccess4.njit.edu/~as3638/back_question.php"); #use new address depending on backend
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array("question" => $question, "answer" => $answer, "difficulty" => $difficulty, "testcases" => $testcases, "type" => $type, "constraint" => $constraint));

      $result = curl_exec($curl);
      
      if(curl_errno($curl)){
        echo 'Curl error: ' . curl_error($ch);
      }
      
      echo $result;
      
      curl_close($curl);
    }
  }
?>