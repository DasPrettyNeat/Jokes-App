<?php

include "db_connect.php";

$new_username = $_POST['username'];
$new_password1 = $_POST['password1'];
$new_password2 = $_POST['password2'];

// hash the password
$hashed_password = password_hash($new_password1, PASSWORD_DEFAULT);

echo "<h2>Trying to add a new user: " . $new_username . " pw = " . $new_password1 . " and " . $new_password2 . "</h2>";

//check to see if password inputted match
if ($new_password1 != $new_password2){
	echo "Passwords do not match. Please try again";
	exit;
}

// password requirements
// search password of a digit
preg_match('/[0-9]+/', $new_password1, $matches);
if (sizeof($matches) == 0){
	echo "The password must have at least one number<br>";
	exit;
}

// search pasword for special characters
preg_match('/[!@#$%^&*()]+/', $new_password1, $matches);
if (sizeof($matches) == 0){
	echo "The password must have at least one special character<br>";
	exit;
}

// length of at least 8
if (strlen($new_password1) <= 8) {
	echo "The password must be at least 8 characters long<br>";
	exit;
}

// check to see if the user already has registered
$sql = "SELECT * FROM users WHERE username = '$new_username'";
$result = $mysqli->query($sql) or die (mysqli_error($mysqli));
if ($result->num_rows > 0) {
	// someone with that name is already registered
	echo "The username " . $new_username . " is already registered. Can't register twice!";
	exit;
}

// insert new user
// old way
//$sql = "INSERT INTO users (id, username, password) VALUES (NULL, '$new_username', '$hashed_password')";
//$result = $mysqli->query($sql) or die (mysqli_error($mysqli));

// prepared statement to insert new user
$stmt = $mysqli->prepare("INSERT INTO users (id, username, password) VALUES (NULL, ?, ?)");
$stmt->bind_param("ss", $new_username, $hashed_password);
$result = $stmt->execute();

if ($result) {
	echo "Registration success";
}
else {
	echo "Something went wrong";
}

echo "<br><a href='index.php'>return to main page </a>";
?>