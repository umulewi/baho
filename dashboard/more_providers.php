<?php
session_start();
if (!isset($_SESSION['admin_email'])) {
    header("location:login.php");
    exit();
}
include('../connection.php');

$job_provider_id = $_GET['job_provider_id'];
$stmt = $pdo->prepare("SELECT users_id FROM job_provider WHERE job_provider_id = ?");
$stmt->execute([$job_provider_id]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 

$pdo = null;
?>

<?php
include 'dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Job Provider</title>
    <style>
        
       .form-container {
        max-width: 750px;
            margin: 0 auto;
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
        .form-container input[type="email"],xta
        .form-container input[type="tel"],
        .form-container input[type="number"],
        select,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: teal;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: darkslategray;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-row > div {
            flex: 1;
            min-width: 300px;
        }


        @media (max-width: 600px) {
            .form-row > div {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>

<?php
$id = $_GET['job_provider_id'];
include '../connection.php';

// Retrieve job provider details
$stmt = $pdo->prepare("SELECT * FROM users JOIN job_provider ON users.users_id = job_provider.users_id WHERE job_provider.job_provider_id = :job_provider_id");
$stmt->bindParam(':job_provider_id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<h2 style="text-align:center"></h2><br>

<div class="form-container">
		
		<main>
            <div class="table-data">
    <form action="" method="post">
        <div class="form-row">
        <div>
            <label for="name">JOB FIRST NAME1:</label>
            <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required readonly>
        </div>
        <div>
            <label for="name">Last name:</label>
            <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required readonly>
        </div>
        </div>
        <div class="form-row">
        <div>
            <label for="gender">GENDER:</label>
            <input type="text" id="gender" name="gender" value="<?php echo $row['gender']; ?>" required readonly>
        </div>
        <div>
            <label for="province">PROVINCE:</label>
            <input type="text" id="province" name="province" value="<?php echo $row['province']; ?>" required readonly>
        </div>
        </div>
        
        <div class="form-row">
        <div>
            <label for="district">DISTRICT:</label>
            <input type="text" id="district" name="district" value="<?php echo $row['district']; ?>" required readonly>
        </div>
        <div>
            <label for="sector">SECTOR:</label>
            <input type="text" id="sector" name="sector" value="<?php echo $row['sector']; ?>" required readonly>
        </div>
        </div>
        <div class="form-row">
        <div>
            <label for="dob">DATE OF BIRTH:</label>
            <input type="date" id="dob" name="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" required readonly>
        </div>
        <div>
            <label for="village">VILLAGE:</label>
            <input type="text" id="village" name="village" value="<?php echo $row['village']; ?>" required readonly>
        </div>
        </div>
        <div class="form-row">
        <div>
            <label for="cell">CELL:</label>
            <input type="text" id="cell" name="cell" value="<?php echo $row['cell']; ?>" required readonly>
        </div>
        <div>
            <label for="id">ID CARDS:</label>
            <input type="text" id="ID" name="ID" value="<?php echo $row['ID']; ?>" required readonly>
        </div>
        </div>  
        
        
    </form>
</div>

</body>
</html>


