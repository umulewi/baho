<?php
require_once 'config.php';

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $userinfo = [
    'email' => $google_account_info['email'],
    'first_name' => $google_account_info['givenName'],
    'last_name' => $google_account_info['familyName'],
    'full_name' => $google_account_info['name'],
    'picture' => $google_account_info['picture'],
    'verifiedEmail' => $google_account_info['verifiedEmail'],
    'token' => $google_account_info['id'],
    'role_id'=>"1",
  ];
  if (isset($google_account_info['gender'])) {
    $userinfo['gender'] = $google_account_info['gender'];
  } else {
    $userinfo['gender'] = 'Unknown';
  }

  

  // checking if user already exists in the database
  $sql = "SELECT * FROM users WHERE email ='{$userinfo['email']}'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    // user exists
    $userinfo = mysqli_fetch_assoc($result);
    $token = $userinfo['token'];
  } else {
    // user does not exist
    $sql = "INSERT INTO users (email, first_name, last_name, gender, full_name, picture, verifiedEmail, token, country, phone_number) 
    VALUES ('{$userinfo['email']}', '{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['gender']}', '{$userinfo['full_name']}', '{$userinfo['picture']}', '{$userinfo['verifiedEmail']}', '{$userinfo['token']}', '{$userinfo['country']}', '{$userinfo['phone_number']}')";


    $result = mysqli_query($conn, $sql);
    if ($result) {
        $token = $userinfo['token'];
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn); // Print the SQL query and the error message
        die();
    }
  }

  // save user data into session
  $_SESSION['user_token'] = $token;
} else {
  if (!isset($_SESSION['user_token'])) {
    header("Location: index.php");
    die();
  }

  // checking if user already exists in the database
  $sql = "SELECT * FROM users WHERE token ='{$_SESSION['user_token']}'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    // user exists
    $userinfo = mysqli_fetch_assoc($result);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>

<body>
  <img src="<?= $userinfo['picture'] ?>" alt="" width="90px" height="90px">
  <ul>
    <li>Full Name: <?= $userinfo['full_name'] ?></li>
    <li>Email Address: <?= $userinfo['email'] ?></li>
    <li>Gender: <?= $userinfo['gender'] ?></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</body>

</html>
