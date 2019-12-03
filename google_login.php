<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// session start
session_start();

// access the google functionality
require_once('vendor/autoload.php');

// google credentials custom to our application
$client_id = '169975129901-mdjv7uim91jlugqceav5oulsrju1kkno.apps.googleusercontent.com';
$client_secret = 'iPW5F8PH2m9cMzeBd_eyepVj';
$redirect_uri = 'http://localhost/Jokes/google_login.php';

// MySql details
$db_username = "root"; // Database username
$db_password = ""; // Database password
$host_name = "localhost"; // MySql hostname
$db_name = "test"; // Database name

// create a new connection to the google login service
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
$service = new Google_Service_0auth2($client);

// There are multiple cases that this page handles depending on what GET values and Session variables are set.
// case 1 - logout the user
if (isset($_GET['logout'])){
	$client->revokeToken($_SESSION['access_token']);
	session_destroy();
	header('Location: index.php');
}

// case 2 - the URL contains a code from the google login service.
if (isset($_GET['code'])){
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	exit;
}

// case 3 - the access_token session variable is set. The user has been logged in.
// If the user has not been logged in, set the variable $authUrl to the login page.
if (isset($_SESSION['access_token']) && $_SESSION['access_token']){
	$client->setAccessToken($_SESSION['access_token']);
} else {
	$authUrl = $client->createAuthUrl();
}

// case 4 - the user is not logged in. Display the login page.
echo '<div style="margin:20px">';
if (isset($authUrl)){
	// show login url
	echo '<div align="center">';
	echo '<h3>Login</h3>';
	echo '<div>You will need a Google account to sign in.</div>';
	echo '<a class="login" href="' . $authUrl . '">Login here</a>';
	echo '</div>';
}
else {
	// case 5 - user has been logged in. Display data about him and add him to the MySql database.
	$user = $service->userinfo->get(); // get user info
	
	// connect to the database
	$mysqli = new mysqli($host_name, $db_username, $db_password, $db_name);
	if ($mysqli->connect_error){
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}
	
	// check if the user exists in the google_users table
	$result = $mysqli->query("SELECT C0UNT(google_id) as usercount FROM google_users WHERE google_id=$user->id");
	$user_count = $result->fetch_object()->usercount; // will return 0 if user doesn't exists
	
	// show user picture
	echo '<img src="'.$user->picture.'" style="float: right;margin-top: 33px;" />';
	
	if($user_count) // if user already exist change greeting text to "Welcome Back"
	{
		echo 'Welcome back '.$user->name.'! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
	}
	else // else greeting text "Thanks for registering"
	{
		echo 'Hi '.$user->name.', Thanks for Registering! [<a href="'.$redirect_uri.'?logout=1">Log Out</a>]';
		$statement = $mysqli->prepare("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?)");
		$statement->bind_param('issss', $user->id, $user->name, $user->email, $user->link, $user->picture);
		$statement->execute();
		echo $mysqli->error;
	}
	
	// print user details
	echo "<p>Data about this user. <ul><li>Username: " . $user->name . "</li> <li>user id: " . $user->id . " </li><li>email: " . $user->email . "</li></ul></p>";
	
	// set session variables that will be used by other pages in the application
	$_SESSION['username']=$user->name;
	$_SESSION['userid']=$user->id;
	$_SESSION['useremail']=$user->email;
}
echo '</div>';
?>