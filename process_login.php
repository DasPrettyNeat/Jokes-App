<head>

</head>

<?php

session_start();

// display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db_connect.php";

$username = $_POST["username"];
$password = $_POST["password"];

echo "You attempt to login with " . $username . " and " . $password . "<br>";

$stmt = $mysqli->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);

$stmt->execute();
$stmt->store_result();

$stmt->bind_result($userid, $uname, $pw);

// unhash the password
if ($stmt->num_rows == 1){
	echo "I found one user with that username<br>";
	$stmt->fetch();
	if (password_verify($password, $pw)){
		echo "The password matches<br>";
		echo "Login successful";
		$_SESSION['username'] = $uname;
	    $_SESSION['userid'] = $userid;
		exit;
	}
	else {
		$_SESSION = [];
	    session_destroy();
	}
}
else {
	$_SESSION = [];
	session_destroy();
}
echo "Login failed<br>";

// old form of logging in
// select data from our jokes table
//$sql = "SELECT id, username, password FROM users WHERE username = '$username' AND password = '$password'";
// print to discover weakness
//echo "SQL = " . $sql . "<br>";
//$result = $mysqli->query($sql);
// print result statement
//echo "<pre>";
//print_r($result);
//echo "</pre>";

//if ($stmt->num_rows > 0) {
    // output one row of data that matches
    //$row = $stmt->fetch();
	//$userid = $row['id'];
	//echo "Login successful!<br>";
	//$_SESSION['username'] = $uname;
	//$_SESSION['userid'] = $userid;
		
//} else {
    //echo "0 results. Nobody with that username and password";
	//$_SESSION = [];
	//session_destory();
//}

// print session details
echo "SESSION = <br>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "<br><a href='index.php'>return to main page </a>";

?>