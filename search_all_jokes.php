<?php

// if it doesn't connect show an error message
if ($mysqli->connect_errno){
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
// print the info of the connected host
echo $mysqli->host_info . "<br>";

// select data from our jokes table
$sql = "SELECT JokeID, Joke_question, Joke_answer, user_id FROM Jokes_table";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "JokeID: " . $row["JokeID"]. " - Joke Question: " . $row["Joke_question"]. " " . $row["Joke_answer"]. "<br>";
		echo "Submitted by user #" . $row['user_id'];
    }
} else {
    echo "0 results";
}

?>