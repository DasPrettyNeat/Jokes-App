<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (! $_SESSION['username']) {
	echo "Only logged in users may access this page. Click <a href='login_form.php'here </a> to login<br>";
	exit;
}

include "db_connect.php";

$new_joke_question = $_POST["newjoke"];
$new_joke_answer = $_POST["newanswer"];
$userid = $_SESSION['userid'];

// add slashes to allow special characters in the submit fields
$new_joke_question = addslashes($new_joke_question);
$new_joke_answer = addslashes($new_joke_answer);

$new_joke_user_id = $_SESSION['userid'];

// search the database for the keyword inputted
echo "<h2>Trying to add a new joke: $new_joke_question and $new_joke_answer for id $new_joke_user_id</h2>";

// use prepared statement to add to the data base
$stmt = $mysqli->prepare("INSERT INTO Jokes_table (JokeID, Joke_question, Joke_answer, user_id) VALUES (NULL, ?, ?, ?)");
$stmt->bind_param("sss", $new_joke_question, $new_joke_answer, $new_joke_user_id);
$stmt->execute();
$stmt->close();

// old way before prepared statement
// select data from our jokes table
//$sql = "INSERT INTO Jokes_table (JokeID, Joke_question, Joke_answer, users_id) VALUES (NULL, '$new_joke_question', '$new_joke_answer', '$userid')";
//$result = $mysqli->query($sql) or die("mysqli_error($mysqli)");

include "search_all_jokes.php";

?>

<a href="index.php">Return to main page</a>