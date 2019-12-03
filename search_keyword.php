<head>
<style>
#main_container {
	margin:20px;
}
</style>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.is"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/is/bootstrap.min.is"></script>
</head>

<body>
<div id="main_container">

<?php

include "db_connect.php";

$keywordfromform = addslashes($_GET["keyword"]);
$keywordfromform = "%" . $keywordfromform . "%";

// search the database for the keyword inputted
echo "<h1>Showing all jokes with the word " . $keywordfromform . "</h1>";

// search key words using statements

// join the results togther to show ther owner of the joke's name from the google stuff
$res = mysqli->query("SELECT google_users.google_name, Jokes_table.JokeID, Jokes_table.user_id, Jokes_table.Joke_question,
Jokes_table.Joke_answer FROM google_users INNER JOIN Jokes_table ON google_users.google_id = Jokes_table.user_id
WHERE Jokes_table.Joke_question LIKE '%$keywordfromform%'");

// old prepared statement
//$stmt = $mysqli->prepare("SELECT JokeID, Joke_question, Joke_answer, user_id, username 
//FROM Jokes_table 
//JOIN users ON users.id = jokes_table.users_id 
//WHERE Joke_question LIKE ?");

//$stmt->bind_param("s", $keywordfromform);

//$stmt->execute();
//$stmt->store_result();

//$stmt->bind_result($JokeID, $Joke_question, Joke_answer, user_id, username);

// old way of searching key words
// select data from our jokes table and join with
//$result = $mysqli->query("SELECT JokeID, Joke_question, Joke_answer, user_id, username 
//FROM Jokes_table 
//JOIN users ON users.id = jokes_table.users_id 
//WHERE Joke_question LIKE '%" . $keywordfromform . "%'");
//echo "Select returned $result->num_rows rows of data<br>";
?>

<div class="panel-group" id="accordion">

<?php while($row = $res->fetch_assoc()) { ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">
		<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row['JokeID']?>"><?php echo $row['Joke_question']?></a>
		</h4>
	</div>
	<div id="collapse<?php echo $row['JokeID']?>" class="panel-collapse collapse">
		<div class="panel-body"><?php echo $row['Joke_answer'] . " Submitted by " . $row['google_name']?></div>
	</div>
</div>
<?php } ?>
<!---f ($stmt->num_rows > 0) {
    // output data of each row
    while($stmt->fetch()) {
		// output of joke and answer using an accordion format to hide the answer
		// protection from cross site scripting
		$safe_joke_question = htmlspecialchars($Joke_question);
		$safe_joke_answer = htmlspecialchars($Joke_answer);
		
        echo "<h3>" . $safe_joke_question . "</h3>";
		echo "<div><p>" . $safe_joke_answer . " -- Submitted by user " . $username . "</p></div>";
		//echo "JokeID: " . $row["JokeID"]. " - Joke Question: " . $row["Joke_question"]. " " . $row["Joke_answer"]. "<br>";
    }
} else {
    echo "0 results";
} --->

<?php } ?>

</div>

<a href='index.php'>return to main page</a>

</div>
</body>