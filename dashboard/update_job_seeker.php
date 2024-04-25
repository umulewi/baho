<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:../index.php");
    exit();
}
include('../connection.php');
$username = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT users_id FROM users WHERE username = ?");
$stmt->execute([$username]); 
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
$id = $_GET['job_seeker_id'];
include'../connection.php';
$stmt = $pdo->prepare("SELECT * FROM job_seeker WHERE job_seeker_id = :job_seeker_id");
$stmt->bindParam(':job_seeker_id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<h2 style="text-align:center"></h2><br>
<div class="form-container">
    <form action="" method="post">
        <div>
            <label for="name">JOB SEEKER NAME:</label>
            <input type="text" name="firstname" value="<?php echo $row['firstname']; ?>" required>
        </div>
        <div>
            <label for="name">JOB SEEKER NAME:</label>
            <input type="text" name="lastname" value="<?php echo $row['lastname']; ?>" required>
        </div>
        <div>
            <label for="fathers_name">FATHER'S NAME:</label>
            <input type="text" id="fathers_name" name="fathers_name" value="<?php echo $row['fathers_name']; ?>" required>
        </div>
        <div>
            <label for="mothers_name">MOTHER'S NAME:</label>
            <input type="text" id="mothers_name" name="mothers_name" value="<?php echo $row['mothers_name']; ?>" required>
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
            <label for="cell">DATE OF BIRTH:</label>
            <input type="text" id="dob" name="date_of_birth" value="<?php echo $row['date_of_birth']; ?>" required>
        </div>
        <div>
            <label for="id">ID CARDS:</label>
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
  $job_seeker_id = $_GET['job_seeker_id'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $fathers_name = $_POST['fathers_name'];
  $mothers_name = $_POST['mothers_name'];
  $province = $_POST['province'];
  $district = $_POST['district'];
  $sector = $_POST['sector'];
  $village = $_POST['village'];
  $cell = $_POST['cell'];
  $date_of_birth = $_POST['date_of_birth'];
  $ID = $_POST['ID'];

  $updated_on = date('Y-m-d H:i:s');

  try {
    // Fetch existing values (optional, not used in update)
    // $stmt_existing = $pdo->prepare("SELECT * FROM job_seeker WHERE job_seeker_id = :job_seeker_id");
    // $stmt_existing->bindParam(':job_seeker_id', $job_seeker_id);
    // $stmt_existing->execute();
    // $row_existing = $stmt_existing->fetch(PDO::FETCH_ASSOC);
    // $created_by = $row_existing['created_by']; // Use existing created_by value

    // Prepare the SQL statement
    $sql = "UPDATE job_seeker 
            SET user_id =:user_id,
            firstname = :firstname,
                lastname = :lastname,
                fathers_name = :fathers_name,
                mothers_name = :mothers_name,
                province = :province,
                district = :district,
                sector = :sector,
                cell = :cell,
                village = :village,
                date_of_birth = :date_of_birth,
                ID = :ID
            WHERE job_seeker_id = :job_seeker_id";

    // Prepare statement
    $stmt = $pdo->prepare($sql);

    // Bind parameters (ensure the number matches placeholders)
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':fathers_name', $fathers_name);
    $stmt->bindParam(':mothers_name', $mothers_name);
    $stmt->bindParam(':province', $province);
    $stmt->bindParam(':district', $district);
    $stmt->bindParam(':sector', $sector);
    $stmt->bindParam(':cell', $cell);
    $stmt->bindParam(':village', $village);
    $stmt->bindParam(':date_of_birth', $date_of_birth);
    $stmt->bindParam(':ID', $ID);
    $stmt->bindParam(':job_seeker_id', $job_seeker_id);

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

