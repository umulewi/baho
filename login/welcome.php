<?php

require_once 'config.php'; // Assuming this file contains the database connection and Google OAuth client setup

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
    'gender' => $google_account_info['gender'],
    'full_name' => $google_account_info['name'],
    'picture' => $google_account_info['picture'],
    'verifiedEmail' => $google_account_info['verifiedEmail'],
    'token' => $google_account_info['id'],
  ];

  // checking if user exists in the database
  $sql = "SELECT * FROM users WHERE email ='{$userinfo['email']}'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // user exists
    $userinfo = mysqli_fetch_assoc($result);
    $token = $userinfo['token'];
  } else {
    // user does not exist, insert into database
    $country = "Rwanda";
    $role_id = "1"; // Assuming default role is 1
    $sql = "INSERT INTO users (email, first_name, last_name, gender, full_name, picture, verifiedEmail, token, country, role_id) VALUES ('{$userinfo['email']}', '{$userinfo['first_name']}', '{$userinfo['last_name']}', '{$userinfo['gender']}', '{$userinfo['full_name']}', '{$userinfo['picture']}', '{$userinfo['verifiedEmail']}', '{$userinfo['token']}','$country',$role_id)";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $token = $userinfo['token'];
    } else {
      echo "User is not created";
      die();
    }
  }

  // save user data into session
  $_SESSION['user_token'] = $token;

  // Fetching role_name from role based on role_id
  $sql = "SELECT role_name FROM role WHERE role_id = {$userinfo['role_id']}";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $role_info = mysqli_fetch_assoc($result);
    $role_name = $role_info['role_name'];

    // Redirect based on role_name
    if ($role_name == "admin") {
      header("Location:admin.php");
      exit();
    } elseif ($role_name == "job_provider") {
      header("Location: provider.php");
      exit();
    } elseif ($role_name == "job_seeker") {
      header("Location: seekeer.php");
      exit();
    } else {
      // Handle if role_name is neither "job_seeker" nor "job_provider"
      echo "Invalid role";
      exit();
    }
  } else {
    // Handle error if role_id not found in role
    echo "Role not found";
    exit();
  }
} else {
  if (!isset($_SESSION['user_token'])) {
    header("Location: index.php");
    die();
  }

  // checking if user is already exists in database
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
    <!-- Remove the password display -->
    <li><a href="logout.php">Logout</a></li>
  </ul>
</body>
</html>
