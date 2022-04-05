<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Exams</title>
  </head>
  <body>
    <?php
      $curl = curl_init();
          
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_show_exams.php");
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, 0);
        
      $result = curl_exec($curl);
      $exams = json_decode($result, true);
      
      ?>
      
      <form action="./takeexam_front.php" method="post">
        <select id="choice" name="choice">
          <?php
          
            foreach($exams as $exam)
            {  
              $number = $exam['number'];
              $name = $exam['name'];
              echo "<option value=\"$number\">$name</option>";
            }
        
            curl_close($curl);
          ?>
        </select>
        <br><br>
        <input type="submit" value="submit">
      </form>
  </body>
</html>