<?php
  session_start();
  $status = $_SESSION["status"];

  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
  
  $curl = curl_init();
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_bank.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, 0);

  $result = curl_exec($curl);
  $decoded = json_decode($result, true);
  
  curl_close($curl);
  
  $c = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="page.css">
  <script type="text/javascript" src="./js/retfunc.js"></script>
  <title>New Question</title>
  <h4>New Question</h4>
  <p>Double check all fields are correct before submitting.</p>
</head>

<body>

  <div style="display: flex;">
    <div style="flex: 1;">
      <main>
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
            <option value="if">if statement</option>
            <option value="arithmetic">arithmetic</option>
            <option value="recursion">recursion</option>
            <option value="string">string</option>
          </select><br><br>
          
          <label for="constraint">What constraints?</label>
          <select name="constraint" id="constraint">
            <option value="none">none</option>
            <option value="for">for loop</option>
            <option value="while">while loop</option>
            <option value="recursion">recursion</option>
          </select><br><br>
          
          <textarea name="question" id="question" placeholder="Enter the question" rows=10 cols=50></textarea><br><br>
          <textarea name="answer" id="answer" placeholder="Enter an answer" rows=10 cols=50></textarea><br><br>
          
          <p>Test Cases:</p>  
          <p>While entering test cases, <strong>enter the parameters with a space between each parameter, commas for each test case.</strong></p>
                                     <p><strong>Enclose strings in single or double quotes.</strong></p>
          <?php
            echo "<textarea name=\"testcases\" id=\"testcases\" placeholder=" . "\"Test Cases&#13;&#10;Example: 2 3 'yes',1 2 'no'\" rows=2 cols=50></textarea><br><br>";
          ?>
          
          <input type="submit" value="Submit Question" id="question-submit" class="button">
          
          <br>
          <a href="https://afsaccess4.njit.edu/~ml626/teacher.php">
            <input type="button" value="Back" id="button-back" class="button">
          </a>
        </form>
      </main>    
    </div>
    
    <div style="flex: 1;">
      <label for="filter-difficulty">Filter by difficulty:</label>
      <select name="filter-difficulty" id="filter-difficulty">
        <option value="none">Not Specified</option>
        <option value="EASY">Easy</option>
        <option value="MEDIUM">Medium</option>
        <option value="HARD">Hard</option>
      </select><br><br>
      
      <label for="filter-type">Filter by type:</label>
      <select name="filter-type" id="filter-type">
        <option value="none">Not Specified</option>
        <option value="for">for loop</option>
        <option value="while">while loop</option>
        <option value="if">if statement</option>
        <option value="arithmetic">arithmetic</option>
        <option value="recursion">recursion</option>
        <option value="string">string</option>
      </select><br><br>
              
      <label for="filter-constraint">Filter by constraints:</label>
      <select name="filter-constraint" id="filter-constraint">
        <option value="none">Not Specified</option>
        <option value="for">for loop</option>
        <option value="while">while loop</option>
        <option value="recursion">recursion</option>
      </select><br><br>
      
      <label for="filter-keyword">Filter by keyword:</label>
      <input name="filter-keyword" id="filter-keyword" onkeyup="handle()"><br><br>
      
      <select name="filtered-result" id="filtered-result" size="28"></select>
      
      <script>
        const array = <?php echo($result); ?>;
        
        const filteredSelect = document.getElementById("filtered-result");
        const difficultySelect = document.getElementById("filter-difficulty");
        const typeSelect = document.getElementById("filter-type");
        const constraintSelect = document.getElementById("filter-constraint");
        const keyword = document.getElementById("filter-keyword");
        
        function handle(e) {
          let d = difficultySelect.value;
          let t = typeSelect.value;
          let c = constraintSelect.value;
          let k = keyword.value;
          
          let filtered = array;
          
          if (d !== "none") {
            filtered = filtered.filter(obj => (obj["difficulty"] === d));
          }
          
          if (t !== "none") {
            filtered = filtered.filter(obj => (obj["type"] === t));
          }
          
          if (c !== "none") {
            filtered = filtered.filter(obj => (obj["constraint"] === c));
          }
          
          if (k.length !== 0) {
            filtered = filtered.filter(obj => (obj["question"].toLowerCase().includes(k.toLowerCase())));
          }
          
          filteredSelect.innerHTML = "";
          for(let t of filtered) {
            let opt = document.createElement("option");
            opt.value = t["question"];
        
            if (t["question"].length > 120) {
              opt.innerText = t["question"].substring(0, 117).concat("...");
            } else {
              opt.innerText = t["question"];
            }
            
            filteredSelect.appendChild(opt);
          }
        }
        
        handle();
        
        typeSelect.onchange = handle;
        difficultySelect.onchange = handle;
        constraintSelect.onchange = handle;
        keyword.onchange = handle;
      </script>
    </div>
  </div>
</body>

</html>