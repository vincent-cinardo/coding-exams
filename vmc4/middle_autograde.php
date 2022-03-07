<?php
  #For grading of students
  #Verify if student account?!

  if($_SERVER['REQUEST_METHOD'] === "POST") {
    #MICHAEL: Send questions as array.

    if(!empty($_POST['examnum']) && !empty($_POST['student'])) {
      #AKHIL: Use new address depending on backend
      $curl = curl_init("https://afsaccess4.njit.edu/~vmc4/back_exam.php");
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array('examnum' => $_POST['examnum'], 'student' => $_POST['student']));

      $result = curl_exec($curl);
      
      if(curl_errno($curl)){
        echo 'Curl error: ' . curl_error($ch);
      }
      
      #AKHIL: Send back answers to questions in the same order which they are recieved. [answer => $answer, testcase1 => [1, 2], testcase2 => [3, 4]]
      $correct_answers = json_decode($result);
      $scores = []
      
      for($i = 0; $i < sizeof($student_answers); $i++)
      {
        $score = [];
        $correct = $correct_answers[$i];
        $student = $student_answers[$i];
        $correct_name = '';
        $student_name = '';
        for($j = preg_match("/def $/", $correct)+4; $j < strpos($correct, "("); $j++)
        {
          $correct_name .= $correct[$j];
        }
        
        for($j = preg_match("/def $/", $student)+4; $j < strpos($student, "("); $j++)
        {
          $student_name .= $student[$j];
        }
        
        if($student_name == $correct_name)
          $score_name = 2;
        else 
          $score_name = 0;
          
        $score[] = $score_name;
        
        for($j = 0; $j < 2; $j++)
        {
          $params = '';
          $args = '';
          $arg_num = 1;
          #Get all test case args for current question.
          foreach($correct_answers[$i]["testcase".$j] as $arg)
          {
            switch(gettype($arg))
            {
              case 'integer':
                $params .= "int(sys.argv[".$arg_num."]), ";
                break;
              case 'double':
                $params .= "float(sys.argv[".$arg_num."]), ";
                break;
              case 'string':
                $params .= "sys.argv[".$arg_num."], ";
                break;
            }
            $args .= $arg." ";
            $arg_num++;
          }
          
          if(!empty($params))
            $params = substr($params, 0, -2);
          
          #Make a python file
          $file = fopen("test.py","w");
          fwrite($file, "import sys\n\n".$student."\n\nprint(".$student_name."(".$params." ))");
          fclose($file);
          shell_exec("chmod +x test.py");
          $output_student = shell_exec("python test.py ".$args);
          
          #Make a python file
          $file = fopen("test.py","w");
          fwrite($file, "import sys\n\n".$correct."\n\nprint(".$correct_name."(".$params." ))");
          fclose($file);
          shell_exec("chmod +x test.py");
          $output_correct = shell_exec("python test.py ".$args);
          
          if($output_student == $output_correct)
            $score_test = 4;
          else
            $score_test = 0;
          
          $score[] = $score_test;
        }
        
        $scores[] = $score;
      }
      
      $json = json_encode($scores);
      echo $json;
    }
  }
?>