  <?php
  include 'connection.php';

  if (isset($_POST['user_login'])) {
    $email = $_POST['email']; // Change from username to email
    $password = $_POST['password'];

    // Fetch user record from the database (with password check)
    $statement = $pdo->prepare("SELECT users.*, role.role_name FROM users INNER JOIN role ON users.role_id = role.role_id WHERE email=:email AND password=:password");
    $statement->bindParam(':email', $email); // Changed from username to email
    $statement->bindParam(':password', $password); // Note: It's not recommended to store passwords in plain text. Hash them before storing and comparing.
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC); 

    if ($user) {
      session_start();
      $_SESSION['user_email'] = $email; 

      $role_name = $user['role_name'];
      switch ($role_name) {
        case 'admin':
          header("Location: dashboard/index.php");
          exit();
        case 'job_seeker':
          header("Location: job_seeker_login/my_profile.php");
        
          exit();
        case 'job_provider':
          header("Location: job_provider_login/my_profile.php");
          exit();
        case 'agent':
          header("Location: agent/index.php");
          exit();
        default:
          // Default redirect if role is not recognized
          header("Location: default_dashboard.php");
          exit();
      }
    } else {
      echo "<script>alert('Incorrect email or password');</script>";
    }
  }
  ?>




<!-- comment-->

          <!-- <form method="post" action="">
            <div class="mb-3">
              <label class="form-label">Emil:</label>
              <input type="text" name="email" class="form-control shadow-none" re4>
            </div>
            <div class="mb-4">
              <label class="form-label">Password:</label>
              <input type="password" name="password" class="form-control shadow-none" required>
            </div>
            <input type="submit" name="user_login" value="Login" style="background-color:teal" class="btn"> -->
            

            <h2>continue with google:</h2>
            <?php
            include'connection.php';
            function getRoleId($pdo, $roleName) {
              $stmt = $pdo->prepare("SELECT role_id FROM role WHERE role_name = :role_name");
              $stmt->execute(array(':role_name' => $roleName));
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              return $row['role_id'];
            }
            $roleId = getRoleId($pdo, 'job_seeker');
            $link = "<a href='job_seeker_login.php?role_id=$roleId'>AS JOB SEEKER</a>";
            echo $link;
            ?>
<br><br>
<?php
function getRoleId2($pdo, $roleName) {
    $stmt = $pdo->prepare("SELECT role_id FROM role WHERE role_name = :role_name");
    $stmt->execute(array(':role_name' => $roleName));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['role_id'];
}
$roleId2 = getRoleId2($pdo, 'job_provider');
$link = "<a href='job_provider_login.php?role_id=$roleId2'>AS JOB provider</a>";

echo $link;
?>
<br>
          





            
            

            
  
  




