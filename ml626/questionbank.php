<?php
  session_start();
  $status = $_SESSION["status"];

  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Question</title>
  <h1>New Question</h1>
  <p>Double check all fields are correct before submitting.</p>
  
  <style>
  textarea {
    resize: none;
  }
  </style>
</head>

<body>
  <main id="main-holder">
    <form id="question-form" action="/~ml626/questionbank_front.php" method="post">
      <label for="difficulty">What difficulty is this question?</label>
      <select name="difficulty" id="cases">
        <option value="easy">Easy</option>
        <option value="medium">Medium</option>
        <option value="hard">Hard</option>
      </select><br><br>
      
      <label for="type">What type of question is it?</label>
      <select name="type" id="type">
        <option value="for">for loop</option>
        <option value="while">while loop</option>
        <option value="switch">switch statement</option>
        <option value="arithmetic">arithmetic</option>
        <option value="recursion">recursion</option>
        <option value="string">string</option>
      </select><br><br>
      
      <textarea name="question" id="question" placeholder="Enter the question" rows=10 cols=50></textarea><br><br>
      <textarea name="answer" id="answer" placeholder="Enter an answer" rows=10 cols=50></textarea><br><br>
      
      Test Cases:<br>
      While entering test cases, <strong>enter the parameters with a space between each parameter, commas for each test case.</strong><br>
                                 <strong>Enclose strings in single or double quotes.</strong>
                                 <br><br>
      <textarea name="testcases" id="testcases" placeholder="Test Cases&#13;&#10;Example: 2 3 \"yes\",1 2 \"no\"" rows=2 cols=50></textarea><br><br>
      
      <input type="submit" value="Submit Question" id="question-submit">
    </form>
  </main>    
  
  <br><br>
  <a href="https://afsaccess4.njit.edu/~ml626/teacher.php">Back</a>
</body>

</html>