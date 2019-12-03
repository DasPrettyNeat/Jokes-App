<html>

<head>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</head>

<body>

<h1>Jokes Page.</h1>
<a href="logout.php">Click here to log out.<a>
<a href="login_form.php">Click here to login<a><br>
<a href="register_new_user.php">Click here to register<a><br>

<?php

include "db_connect.php";

//include "search_all_jokes.php";

?>

<!-- old form -->
<!-- <form action="search_keyword.php">
  Joke keyword:<br>
  <input type="text" name="keyword"><br>
  <input type="submit" name="Submit">
</form>
-->

<form class="form-horizontal" action="search_keyword.php">
<fieldset>

<!-- Form Name -->
<legend>Search for a joke</legend>

<!-- Search input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="keyword">Search Input</label>
  <div class="col-md-5">
    <input id="keyword" name="keyword" type="search" placeholder="e.g. chicken" class="form-control input-md">
    <p class="help-block">Enter a keyword to search for.</p>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Search</button>
  </div>
</div>

</fieldset>
</form>

<hr>

<?php
session_start();
if (isset($_SESSION[userid])):
?>

<form class="form-horizontal" action="add_joke.php" method="POST">
<fieldset>

<!-- Form Name -->
<legend>Enter a new joke</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="newjoke">Enter the question to your new joke.</label>  
  <div class="col-md-6">
  <input id="newjoke" name="newjoke" type="text" placeholder="" class="form-control input-md">
  <span class="help-block">Enter the first half of your joke.</span>  
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="newanswer">Answer</label>  
  <div class="col-md-5">
  <input id="newanswer" name="newanswer" type="text" placeholder="" class="form-control input-md">
  <span class="help-block">Enter the punchline to your new joke.</span>  
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Add new joke</button>
  </div>
</div>

</fieldset>
</form>

<?php else: ?>

<!-- login message will go here -->
<div align="center">
<h3>Login</h3>
<div>You will need a Google account to add a new joke.</div>
<a href="google_login.php">Login here</a>
</div>

<?php endif; ?>

<?php

$mysqli->close();

?>

</body>

</html>