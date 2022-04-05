<?php
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //if(!empty($_POST[0]))
    //{
      include './php/dblogin.php';
        
      //Con is connection to database in login.php
      $bank = mysqli_query($con, "SELECT * FROM `Questions`;");
      
      $questions = [];
      while($row = mysqli_fetch_assoc($bank))
      {
        $questions[] = $row;
      }
      
      echo json_encode($questions, JSON_PRETTY_PRINT);
    //}
  }
?>