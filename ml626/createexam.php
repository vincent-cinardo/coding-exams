<?php
  session_start();
  $status = $_SESSION["status"];
  
  if(strcmp($status, "Teacher") != 0) {
    header("Location: https://afsaccess4.njit.edu/~ml626");
  }
  
  $_SESSION["exam"];
  
  $curl = curl_init();
    
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_URL, "https://afsaccess4.njit.edu/~vmc4/middle_bank.php");
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, 0);

  $result = curl_exec($curl);
  $decoded = json_decode($result, true);
  
  curl_close($curl);
  
  $c = 0;
  $answer;
  $exists = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="page.css">
  <title>Create Exam</title>
  <h4>Create Exam</h4>
</head>

<body>
  <div style="display: flex;">
    <div style="flex: 1;">
    <main>
      <p>Current Exam Questions:</p><br>
      
      <?php
        if (!empty($_POST["score"]) && !empty($_POST["score"])) {
          if (isset($_POST["add"])) {
            if (!empty($_SESSION["exam"])) {
              foreach ($_SESSION["exam"] as $value) {
                if ($value["question"] == $_POST["filtered-result"]) {
                  $exists = true;
                }
              }
            }
            
            foreach ($decoded as $value) {
              if ($value["question"] == $_POST["filtered-result"]) {
                $answer = $value["answer"];
              }
            }
            
            if (!$exists) {
              $_SESSION["exam"][] = array("question" => $_POST["filtered-result"], "answer" => $answer, "score" => $_POST["score"]);
            }
          }
        }
        
        if (!empty($_SESSION["exam"]) && !isset($_POST["clear"])) {        
          foreach ($_SESSION["exam"] as $value) {
            if (strlen($value["question"]) > 80) {
              echo "<p>" . substr($value["question"], 0, 80) . "...\t" . $value["score"] . "</p>";
            } else {
              echo "<p>" . $value["question"] . "\t" . $value["score"] . "</p>";
            }
          }
        }                  
      ?>
      
      <br><br>
      <form method="post" action="/~ml626/createexam_name.php">
        <input type="submit" value="Finalize Questions" id="submit" class="button">
      </form>
      
      <form method="post">
        <input type="submit" value="Clear Current Exam" name="clear" id="clear" class="button">
      </form>
      
      <?php
        if (isset($_POST["clear"])) {
          unset($_SESSION["exam"]);
        }
      ?>
    </main>
    
    <a href="https://afsaccess4.njit.edu/~ml626/teacher.php">
      <input type="button" value="Back" id="button-back" class="button">
    </a>
    </div>

    <div style="flex: 1;">
      <form method="post">
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
        
        <select name="filtered-result" id="filtered-result" size="28"></select><br><br>
        
        <label for="score">Score:</label>
        <input type="number" name="score" id="score" placeholder="Enter a value"><br><br>
        <input type="submit" value="Add to Exam" name="add" id="add" class="button"><br>
      </form>
    </div>
  </div>
  
      
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
      for (let t of filtered) {
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
</body>

</html>