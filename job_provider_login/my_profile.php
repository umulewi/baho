<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: ../index.php");
    exit();
}
$user_email = $_SESSION['user_email']; 
echo  $user_email;

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
        .form-container input[type="date"],
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
include '../connection.php';  
$stmt = $pdo->prepare("SELECT * FROM job_provider JOIN users ON job_provider.users_id = users.users_id WHERE users.email = :user_email");
$stmt->bindParam(':user_email', $user_email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<h2 style="text-align:center"></h2><br>
<div class="form-container">
    <form action="" method="post">
    <input type="hidden" name="job_provider_id" value="<?php echo $row['job_provider_id']; ?>">
        <div>
            <label for="name">FIRST NAME:</label>
            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required>
        </div>
        <div>
            <label for="name">LAST NAME:</label>
            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>
        </div>
        <div>
            <label for="name">DATE OF BIRTH:</label>
            <input type="date" name="date_of_birth" value="<?php echo $row['date_of_birth']; ?>" required>
        </div>
        
        <div>
            <label for="province">PROVINCE:</label>
            <input type="text" id="province" name="province" value="<?php echo $row['province']; ?>" required>
        </div>
        <div>
            <label for="district">DISTRICT:</label>
            <input type="text" id="district" name="district" value="<?php echo $row['district']; ?>" required>
        </div>
        <div>
            <label for="sector">SECTOR:</label>
            <input type="text" id="sector" name="sector" value="<?php echo $row['sector']; ?>" required>
        </div>
        <div>
            <label for="village">VILLAGE:</label>
            <input type="text" id="village" name="village" value="<?php echo $row['village']; ?>" required>
   
        </div>
        
        <div>
        
            <label for="village">GENDER:</label>
        <select name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
        </div>
        <div>
            <label for="cell">CELL:</label>
            <input type="text" id="cell" name="cell" value="<?php echo $row['cell']; ?>" required>
        </div>
        <div>
            <label for="id">IDENTIFICATION CARD</label>
            <input type="text" id="ID" name="ID" value="<?php echo $row['ID']; ?>" required>
        </div>
        <div>
            <label for="id">TELEPHONE:</label>
            <input type="text" id="ID" name="telephone" value="<?php echo $row['telephone']; ?>" required>
        </div>
        <div>
            <label for="id">PASSWORD:</label>
            <input type="text" id="ID" name="password" value="<?php echo $row['password']; ?>" required>
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
  $job_provider_id = $_POST['job_provider_id'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $province = $_POST['province'];
  $district = $_POST['district'];
  $sector = $_POST['sector'];
  $village = $_POST['village'];
  $gender=$_POST['gender'];
  $cell = $_POST['cell'];
  $ID = $_POST['ID'];
  $date_of_birth=$_POST['date_of_birth'];
  $telephone = $_POST['telephone'];
  $password = $_POST['password'];
  $updated_on = date('Y-m-d H:i:s');
  $full_name = $first_name . ' ' . $last_name;
  try {
    $sql = "UPDATE job_provider 
            SET users_id =:users_id,
                province = :province,
                district = :district,
                sector = :sector,
                cell = :cell,
                village = :village,
                telephone=:telephone,
                ID = :ID,
                date_of_birth=:date_of_birth
            WHERE job_provider_id = :job_provider_id";
$sql2 = "UPDATE users SET 
first_name = :first_name,
gender=:gender,
last_name=:last_name,
gender=:gender,
full_name=:full_name,
password = :password  
WHERE users_id = :users_id";
$stmt = $pdo->prepare($sql);
$stmt_user = $pdo->prepare($sql2); 

$stmt->bindParam(':users_id', $row['users_id']);
$stmt->bindParam(':province', $province);
$stmt->bindParam(':district', $district);
$stmt->bindParam(':sector', $sector);
$stmt->bindParam(':cell', $cell);
$stmt->bindParam(':village', $village);
$stmt->bindParam(':ID', $ID);
$stmt->bindParam(':date_of_birth', $date_of_birth);

$stmt->bindParam(':job_provider_id', $job_provider_id);
$stmt->bindParam(':telephone', $telephone);
$stmt_user->bindParam(':full_name', $full_name);
$stmt_user->bindParam(':first_name', $first_name);
$stmt_user->bindParam(':last_name', $last_name);
$stmt_user->bindParam(':gender', $gender); 
$stmt_user->bindParam(':password', $password);
$stmt_user->bindParam(':users_id', $row['users_id']); 

    // Execute the statement
    if ($stmt->execute() && $stmt_user->execute()) {
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

