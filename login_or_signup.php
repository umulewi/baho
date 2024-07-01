<?php
session_start();
?>
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['select_service'] = $_POST['select_service'];
    $_SESSION['select_price'] = $_POST['select_price'];
    $_SESSION['comments'] = $_POST['comments'];

    header("Location: login_or_signup.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login or Signup</title>
</head>
<body>
    <h2>Login or Signup</h2>
    <a href="login.php">Login</a> or <a href="signup.php">Signup</a>
</body>
</html>

<div class="login-container" class="container-fluid">
        <div class="login-image"></div>
        <div class="login-form">
            <h2 style="font-family: 'michroma';">Continue as</h2>
            <div class="options-container">
        <div class="option" onclick="window.location.href='job_seeker_login.php?role_id=<?php echo $workerRoleId; ?>'">
            <div class="circle">
                <img src="uploads/worker.png" alt="Worker Icon">
            </div>
            <div class="option-title">Worker</div>
        </div>
        <div class="option" onclick="window.location.href='job_provider_login.php?role_id=<?php echo $employerRoleId; ?>'">
            <div class="circle">
                <img src="uploads/employer.png" alt="Employer Icon">
            </div>
            <div class="option-title">Employer</div>
        </div>
    </div>
