<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './php/dblogin.php';  
    
    $result = mysqli_query($con, "SELECT DISTINCT `number`, `name` FROM Exam;");
    
    $exams = [];
    
    while($row = mysqli_fetch_row($result))
    {
      $exams[] = array('number' => $row[0], 'name' => $row[1]);
    }
    echo json_encode($exams, JSON_PRETTY_PRINT);
  }
?>