<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../index.php");
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
include '../connection.php';

$stmt = $pdo->prepare("SELECT * FROM job_provider JOIN users ON job_provider.users_id = users.users_id WHERE users.email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// // Echo job_provider_id
// echo $row['job_provider_id'];
?>

<h2 style="text-align:center"></h2><br>
<div class="form-container">
    <form action="" method="post">
    <input type="hidden" name="job_provider_id" value="<?php echo $row['job_provider_id']; ?>">
        <div>
            <label for="name">FIRST NAME:</label>
            <input type="text" name="firstname" value="<?php echo $row['firstname']; ?>" required>
        </div>
        <div>
            <label for="name">LAST NAME:</label>
            <input type="text" name="lastname" value="<?php echo $row['lastname']; ?>" required>
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
            <label for="cell">CELL:</label>
            <input type="text" id="cell" name="cell" value="<?php echo $row['cell']; ?>" required>
        </div>
        <div>
            <label for="id">IDENTIFICATION CARD</label>
            <input type="text" id="ID" name="ID" value="<?php echo $row['ID']; ?>" required>
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
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $province = $_POST['province'];
  $district = $_POST['district'];
  $sector = $_POST['sector'];
  $village = $_POST['village'];
  $cell = $_POST['cell'];
  $ID = $_POST['ID'];

  $updated_on = date('Y-m-d H:i:s');

  try {
    
    $sql = "UPDATE job_provider 
            SET users_id =:users_id,
            firstname = :firstname,
                lastname = :lastname,
                province = :province,
                district = :district,
                sector = :sector,
                cell = :cell,
                village = :village,
                ID = :ID
            WHERE job_provider_id = :job_provider_id";

    // Prepare statement
    $stmt = $pdo->prepare($sql);

    // Bind parameters (ensure the number matches placeholders)
    $stmt->bindParam(':users_id', $user_id);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':province', $province);
    $stmt->bindParam(':district', $district);
    $stmt->bindParam(':sector', $sector);
    $stmt->bindParam(':cell', $cell);
    $stmt->bindParam(':village', $village);
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':job_provider_id', $job_provider_id);

    // Execute the statement
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

