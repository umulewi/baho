<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:../index.php");
    exit();
}
include('../connection.php');
$email = $_SESSION['user_email'];
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

$email = $_SESSION['user_email'];
$id = $_GET['job_provider_id'];
include '../connection.php';
$stmt = $pdo->prepare("SELECT *
FROM users
JOIN job_provider ON users.users_id = job_provider.users_id
WHERE job_provider.job_provider_id = :job_provider_id");
$stmt->bindParam(':job_provider_id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?> 
<h2 style="text-align:center"></h2><br>
<div class="form-container">
<!DOCTYPE html>
<html>
<head>
    <title>Update Job Provider</title>
</head>
<body>
    <form action="" method="post">
        <div>
            <label for="name">JOB FIRST NAME:</label>
            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required>
        </div>
        <div>
            <label for="name">JOB LAST NAME:</label>
            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>
        </div>
        <div>
            <label for="gender">GENDER:</label>
            <input type="text" id="gender" name="gender" required>
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
    $job_provider_id = $_GET['job_provider_id'];
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $full_name = $first_name . ' ' . $last_name; 
    $gender = $_POST['gender'];
 

    $province = htmlspecialchars($_POST['province']);
    $district = htmlspecialchars($_POST['district']);
    $sector = htmlspecialchars($_POST['sector']);
    $village = htmlspecialchars($_POST['village']);
    $cell = htmlspecialchars($_POST['cell']);
    $ID = htmlspecialchars($_POST['ID']);

    try {  
        // Update job_seeker table
        $sql = "UPDATE job_provider
                SET
                    province = :province,
                    district = :district,
                    sector = :sector,
                    cell = :cell,
                    village = :village,
                    date_of_birth = :date_of_birth,
                    ID = :ID
                WHERE job_provider_id = :job_provider_id";

        $stmt = $pdo->prepare($sql);
  
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':sector', $sector);
 
        $stmt->bindParam(':cell', $cell);
        $stmt->bindParam(':village', $village);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':ID', $ID);
 
        $stmt->bindParam(':job_provider_id', $job_provider_id);
        $stmt->execute();

        // Update users table
        $sql2 = "UPDATE users
                 SET first_name = :first_name,
                     last_name = :last_name,
                     full_name=:full_name,
                     gender = :gender
                 WHERE users_id = :user_id";

        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':first_name', $first_name);
        $stmt2->bindParam(':last_name', $last_name);
        $stmt2->bindParam(':full_name', $full_name);
        $stmt2->bindParam(':gender', $gender);
        $stmt2->bindParam(':user_id', $user_id);
        $stmt2->execute();

        if ($stmt2->rowCount() > 0) { 
            echo "Well updated";
        } else {
            echo "<script>alert('Error updating record');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }}
    ?>