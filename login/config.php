<?php
require_once 'vendor/autoload.php';
session_start();

// init configuration
$clientID = '67536973859-u2fsecvceffqtbaik2tnlkj2he7g5scl.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/baho/login/welcome.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
// Connect to database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "google";

$conn = mysqli_connect($hostname, $username, $password, $database);