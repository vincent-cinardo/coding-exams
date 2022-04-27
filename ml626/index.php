<?php
  session_start();
  session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="index.css">
</head>

<body>
  <main id="main-holder">
    <h1 id="login-header">Login</h1>
    <form id="login-form" action="/~ml626/front.php" method="post">
      <input type="text" name="username" id="username-field" class="login-form-field" placeholder="Username">
      <input type="password" name="password" id="password-field" class="login-form-field" placeholder="Password">
      <input type="submit" value="Login" id="submit">
    </form>
  </main>
</body>

</html>