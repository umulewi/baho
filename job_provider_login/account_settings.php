<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: ../index.php");
    exit();
}

include('../connection.php');
$email = $_SESSION['email'];
$stmt = $pdo->prepare("SELECT users_id FROM users WHERE email = ?");
$stmt->execute([$email]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 
echo "User ID: " . $user_id;
$pdo = null;
?>



<?php
include'dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <style>
        /* Form container */
        .form-container { 
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        /* Form fields */
        .form-container div {
            margin-bottom: 15px;
        }
        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"],
        form select,
        .form-container input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; 
        }


        .form-container input[type="submit"] {
            width: 20%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: teal;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: teal;
        }
    </style>
    
</head>
<body>

<?php

include'../connection.php';
$stmt = $pdo->prepare("SELECT * FROM users  WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2 style="text-align:center"></h2><br>
<div class="form-container">
    <form action="" method="post">
      
        
        <div>
            <label for="id">Telephone:</label>
            <input type="text" id="telephone" name="telephone" value="<?php echo $row['telephone']; ?>" required>
        </div>
        <div>
            <label for="id">password:</label>
            <input type="text" id="password" name="password" value="<?php echo $row['password']; ?>" required>
        </div>
        <div>
            <input type="submit" name="update" value="Update" style="background-color: teal;">
        </div>
    </form>
</div>

</body>
</html>
<?php
include '../connection.php';
if (isset($_POST['update'])) {
  $telephone = $_POST['telephone'];

  $password = $_POST['password'];

  try {  
    $sql = "UPDATE users 
            SET 
            telephone = :telephone,
            password = :password  
            WHERE users_id = :users_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':telephone', $telephone);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':users_id', $user_id);

    
    if ($stmt->execute()) {
    //   echo "<script>window.location.href = 'view_job-seeker.php';</script>";
    echo"well updated";
      exit();
    } else {
      echo "<script>alert('Error updating record');</script>";
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>

