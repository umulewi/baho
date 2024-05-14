<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
    <input type="email" name="email" placeholder="EMAIL" required><br>
    <input type="text" name="first_name" placeholder="FIRST NAME" required><br>
    <input type="text" name="last_name" placeholder="LAST NAME" required><br>

  
    Female:<input type="radio" name="gender" value="female" required>Male:<input type="radio" name="gender" value="male" required><br>
    <input type="password" name="password" placeholder="PASSWORD" required><br><br><br>
    <input type="submit" value="Submit">
</form>



<?php
include 'connection.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_reporting(E_ALL);
ini_set('display_errors', 1);
    
    $role_id = $_GET['role_id'];
    $stmt = $pdo->prepare("INSERT INTO users (role_id, email, first_name, last_name, gender, password) VALUES (:role_id, :email, :first_name, :last_name, :gender, :password)");
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':first_name', $_POST['first_name']);
    $stmt->bindParam(':last_name', $_POST['last_name']);
    $stmt->bindParam(':gender', $_POST['gender']);
    $stmt->bindParam(':password', $_POST['password']);
    $stmt->bindParam(':role_id', $role_id);
   
    $stmt->execute();
    $users_id = $pdo->lastInsertId();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stmt = $pdo->prepare("INSERT INTO job_seeker (users_id, role_id) VALUES (:users_id, :role_id)");
        $stmt->bindParam(':users_id', $users_id);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();
    }

    $pdo = null;
    $message = "Data submitted successfully!";
    echo "Message: " . $message;
}

?>

<?php
require_once 'job_seeker_login/config.php';

if (isset($_SESSION['user_token'])) {
  header("Location: job_seeker_login/welcome.php");
} else {
  echo "<a href='" . $client->createAuthUrl() . "'>Google Login</a>";
}

?>
</body>
</html>
