<?php

// create variables to connect to the database
$host = "localhost";
$username = "root";
$user_pass = "";
$database_in_use = "test";

// connect to the database
$mysqli = new mysqli($host, $username, $user_pass, $database_in_use);

?>