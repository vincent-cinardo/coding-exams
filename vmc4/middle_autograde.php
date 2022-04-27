<?php
  #For grading of students

  if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(!empty($_POST['eid']) && !empty($_POST['student'])) {
      #AKHIL: Use new address depending on backend
      $curl = curl_init("https://afsaccess4.njit.edu/~as3638/back_autograde.php");
      #$curl = curl_init("https://afsaccess4.njit.edu/~vmc4/back_autograde.php");
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, array('eid' => $_POST['eid'], 'student' => $_POST['student']));
      
      $result = curl_exec($curl);
      
      if(curl_errno($curl)){
        echo 'Curl error: ' . curl_error($ch);
      }

      $cases = json_decode($result, true);
      $grades = [];
      
      foreach($cases as $case)
      {
        $grade["score"] = 0;
        $grade["max_score"] = $case['score'];
        $grade['eid'] = $case['eid'];
        $grade['name'] = $case['name'];
        $grade['question'] = $case['question'];
        $grade['student_answer'] = $case['student_answer'];
        $grade['correct_answer'] = $case['correct_answer'];
        $grade['type'] = $case['type'];
        $grade['constraint'] = $case['constraint'];
        $grade['feedback'] = '';
        $correct = $case['correct_answer'];
        $student = $case['student_answer'];
        $correct_name = '';
        $student_name = '';
        $def = '';
        
        for($j = preg_match("/def $/", $student)+4; $j < strpos($student, ")")+1; $j++) //If things go wrong, trade spots with $correct loop below
        {
          $def .= $student[$j];
        }
        
        $grade['student_def'] = $def;
        $def = '';

        for($j = preg_match("/def $/", $correct)+4; $j < strpos($correct, ")")+1; $j++)
        {
          $def .= $correct[$j];
        }        
        
        $grade['correct_def'] = $def;
        
        for($j = preg_match("/def $/", $correct)+4; $j < strpos($correct, "("); $j++)
        {
          $correct_name .= $correct[$j];
        }
        
        for($j = preg_match("/def $/", $student)+4; $j < strpos($student, "("); $j++)
        {
          $student_name .= $student[$j];
        }
        
        $corrected_def = '';
        $corrected_def .= $correct_name;
        
        for($j = strpos($student, "("); $j < strpos($student, ")")+1; $j++)
        {
          $corrected_def .= $student[$j];
          if($j > 50)
          {
            break;
          }
        }
        
        //Score is used to put show points +/- in each correct/incorrect answer
        $score = 0.1 * $case['score'];
        
        //Assign 10% for the name
        if($student_name == $correct_name)
        {
          $grade['score'] = 0.1 * $case['score'];
          $grade['feedback'] .= "Method name_".$grade['correct_def']."_".$grade['student_def']."_$score%";
        }
        else
        {
          $grade['feedback'] .= "Method name_".$grade['correct_def']."_".$grade['student_def']."_0%";
        }
        
        //Checks if student code contains the type. If type exists, 
        //reserve 10% of the max_point for the type. If it is of normal type, the weight is 90% for testcases.
        $percentage = 0.8;
        $iscorrect = "True";
        
        switch($grade['constraint'])
        {
          case 'for':
            if(preg_match("/for.*:/", $grade['student_answer']))
            {
              $grade['score'] += 0.1 * $case['score'];
            }
            else
            {
              $score=0;
              $iscorrect = "False";
            }
            $grade['feedback'] .= "Uses for loop._for...:_"."$iscorrect"."_$score%";
            break;
          case 'while':
            if(preg_match("/while.*:/", $grade['student_answer']))
            {
              $grade['score'] += 0.1 * $case['score'];
            }
            else
            {
              $score=0;
              $iscorrect = "False";
            }
            $grade['feedback'] .= "Uses while loop._while...:_"."$iscorrect"."_$score%";
            break;
          case 'recursion':
            if(preg_match_all("/".$student_name."/", $grade['student_answer']) > 1)
            {
              $grade['score'] += 0.1 * $case['score'];
            }
            else
            {
              $score=0;
              $iscorrect = "False";
            }
            $grade['feedback'] .= "Is a recursive function._Function calls itself._"."$iscorrect"."_$score%";
            break;
          default:
            $percentage = 0.9;
        }
        
        //Max points for each test case possible.
        
        $testcases = preg_replace('/^ */', '', $case['testcases']);
        $testcases = preg_replace('/  +/', ' ', $testcases);
        $testcases = preg_replace('/ + /', ' ', $testcases);
        $testcases = preg_replace('/,+ +/', ',', $testcases);
        $testcases = preg_replace('/ *,+ *$/', '', $testcases);
        $testcases = explode(",", preg_replace('/ *,+ */', ',', $testcases));
        $max_point = ($percentage * $case["score"]) / count($testcases);
        
        foreach($testcases as $testcase)
        {
          $params = '';
          $args = '';
          $final_params = '(';
          $arg_num = 1;
          
          #Get all test case args for current question.
          foreach(explode(" ", $testcase) as $arg)
          {
          
            if(ctype_digit($arg))
            {
              $params .= "int(sys.argv[".$arg_num."]), ";
            }
            else if(is_numeric($arg))
            {
              $params .= "float(sys.argv[".$arg_num."]), ";
            }
            else
            {
              $params .= "sys.argv[".$arg_num."], ";
            }

            $args .= $arg." ";
            $final_params .= $arg . ", ";
            $arg_num++;
          }
          
          if(!empty($final_params))
            $final_params = substr($final_params, 0, -1);
          
          $final_params[-1] = ')';
          
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
          {
            $grade["score"] += $max_point;
            $grade['feedback'] .= " $correct_name$final_params _ $output_correct _ $output_student _$max_point%";
            //$grade['feedback'] .= "$corrected_def →	$output_student | $def → $output_correct _+$max_point%";
          }
          else
          {
            $grade['feedback'] .= " $correct_name$final_params _ $output_correct _ $output_student _0%";
            //$grade['feedback'] .= "$corrected_def →	$output_student | $def → $output_correct _-$max_point%";
          }
        }
        
        $grades[] = $grade;
        
      } //Foreach case loop end
      
      $json = json_encode($grades, JSON_PRETTY_PRINT);
      echo $json;
    }
  }
?>