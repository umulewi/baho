<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:../index.php");
    exit();
}
include('../connection.php');

$job_seeker_id = $_GET['job_seeker_id'];
$stmt = $pdo->prepare("SELECT users_id FROM job_seeker WHERE job_seeker_id = ?");
$stmt->execute([$job_seeker_id]); 
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
    <title>Update Student</title>
    <style>
        .form-container {
            max-width: 800px;
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
        .form-container input[type="email"],
        .form-container input[type="tel"],
        .form-container input[type="number"],
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

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .form-row > div {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>

<?php

$email = $_SESSION['user_email'];
$id = $_GET['job_seeker_id'];
include '../connection.php';
$stmt = $pdo->prepare("SELECT *
FROM users
JOIN job_seeker ON users.users_id = job_seeker.users_id
WHERE job_seeker.job_seeker_id = :job_seeker_id");
$stmt->bindParam(':job_seeker_id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?> 

<h2 style="text-align:center"></h2><br>
<div class="form-container">
    <form action="" method="post">
        <div class="form-row">
            <div>
                <label for="name">JOB SEEKER NAME:</label>
                <input type="text" name="first_name" value="<?php echo htmlspecialchars($row['first_name']); ?>" required readonly>
            </div>
            <div>
                <label for="name">JOB SEEKER LAST NAME:</label>
                <input type="text" name="last_name" value="<?php echo htmlspecialchars($row['last_name']); ?>" required readonly>
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="fathers_name">FATHER'S NAME:</label>
                <input type="text" id="fathers_name" name="fathers_name" value="<?php echo htmlspecialchars($row['fathers_name']); ?>" required readonly>
            </div>
            <div>
                <label for="mothers_name">MOTHER'S NAME:</label>
                <input type="text" id="mothers_name" name="mothers_name" value="<?php echo htmlspecialchars($row['mothers_name']); ?>" required readonly>
            </div>
        </div>
        
        <div class="form-row">
        <div>
            <label for="email">EMAIL:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required readonly>
        </div>
        <div>
            <label for="province">PROVINCE:</label>
            <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($row['province']); ?>" required readonly>
        </div>
        </div>

        <div class="form-row">
        <div>
            <label for="district">DISTRICT:</label>
            <input type="text" id="district" name="district" value="<?php echo htmlspecialchars($row['district']); ?>" required readonly>
        </div>
        <div>
            <label for="sector">SECTOR:</label>
            <input type="text" id="sector" name="sector" value="<?php echo htmlspecialchars($row['sector']); ?>" required readonly>
        </div>
        </div>
        
        <div class="form-row">
        <div>
            <label for="village">VILLAGE:</label>
            <input type="text" id="village" name="village" value="<?php echo htmlspecialchars($row['village']); ?>" required readonly>
        </div>
        <div>
            <label for="cell">CELL:</label>
            <input type="text" id="cell" name="cell" value="<?php echo htmlspecialchars($row['cell']); ?>" required readonly>
        </div>
        </div>
        <div class="form-row">
        <div>
            <label for="dob">DATE OF BIRTH:</label>
            <input type="date" id="dob" name="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" required readonly>
        </div>
        <div>
            <label for="dob">GENDER:</label>
            <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($row['gender']); ?>" required readonly>
        </div>
        </div>
        <div class="form-row">
        <div>
            <label for="bio">BIO:</label>
            <textarea id="bio" name="bio" required readonly><?php echo ($row['bio']); ?></textarea>
        </div>
        <div>
            <label for="ID">ID CARDS:</label>
            <input type="text" id="ID" name="ID" value="<?php echo htmlspecialchars($row['ID']); ?>" required readonly>
        </div>
        </div>
        

    </form>
</div>

</body>
</html>
