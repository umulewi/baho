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
echo "User ID: " . $user_id;
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
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($row['first_name']); ?>" required>
        </div>
        <div>
            <label for="name">JOB SEEKER LAST NAME:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($row['last_name']); ?>" required>
        </div>
        </div>
        <div class="form-row">
        <div>
            <label for="fathers_name">FATHER'S NAME:</label>
            <input type="text" id="fathers_name" name="fathers_name" value="<?php echo htmlspecialchars($row['fathers_name']); ?>" required>
        </div>
        <div>
            <label for="mothers_name">MOTHER'S NAME:</label>
            <input type="text" id="mothers_name" name="mothers_name" value="<?php echo htmlspecialchars($row['mothers_name']); ?>" required>
        </div>
    </div>
    <div class="form-row">
    <div>
        <label for="email">EMAIL:</label>
            <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
        </div>
        <div>
            <label for="province">PROVINCE:</label>
            <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($row['province']); ?>" required>
        </div>
    </div>
        
    <div class="form-row">
    <div>
            <label for="district">DISTRICT:</label>
            <input type="text" id="district" name="district" value="<?php echo htmlspecialchars($row['district']); ?>" required>
        </div>
        <div>
            <label for="sector">SECTOR:</label>
            <input type="text" id="sector" name="sector" value="<?php echo htmlspecialchars($row['sector']); ?>" required>
        </div>
    </div>

        <div class="form-row">
        <div>
            <label for="village">VILLAGE:</label>
            <input type="text" id="village" name="village" value="<?php echo htmlspecialchars($row['village']); ?>" required>
        </div>
        <div>
            <label for="cell">CELL:</label>
            <input type="text" id="cell" name="cell" value="<?php echo htmlspecialchars($row['cell']); ?>" required>
        </div>
        </div>
        <div class="form-row">
            <div>
                <label for="dob">DATE OF BIRTH:</label>
                <input type="date" id="dob" name="date_of_birth" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" required>
            </div>
            <div>
                <label for="gender">GENDER:</label>
                <select name="gender">
                    <option value="male" <?php echo ($row['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($row['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
        </div>

        <div class="form-row">
        <div>
            <label for="cell">SALARY:</label>
            <input type="number" id="cell" name="salary" value="<?php echo htmlspecialchars($row['salary']);?>" required>
        </div>
        <div>
            <label for="bio">BIO:</label>
            <textarea id="bio" name="bio" required><?php echo ($row['bio']); ?></textarea>
        </div>
        </div>
        
        
        <div>
            <label for="ID">ID CARDS:</label>
            <input type="text" id="ID" name="ID" value="<?php echo htmlspecialchars($row['ID']); ?>" required>
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
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $full_name = $first_name . ' ' . $last_name; 
    $gender = $_POST['gender'];
    $salary = $_POST['salary'];
    $fathers_name = htmlspecialchars($_POST['fathers_name']);
    $mothers_name = htmlspecialchars($_POST['mothers_name']);
    $province = htmlspecialchars($_POST['province']);
    $district = htmlspecialchars($_POST['district']);
    $sector = htmlspecialchars($_POST['sector']);
    $village = htmlspecialchars($_POST['village']);
    $cell = htmlspecialchars($_POST['cell']);
    $bio = htmlspecialchars($_POST['bio']);
    $date_of_birth = htmlspecialchars($_POST['date_of_birth']);
    $ID = htmlspecialchars($_POST['ID']);

    try {  
        // Update job_seeker table
        $sql = "UPDATE job_seeker
                SET fathers_name = :fathers_name,
                    mothers_name = :mothers_name,
                    province = :province,
                    district = :district,
                    salary=:salary,
                    bio=:bio,
                    sector = :sector,
                    cell = :cell,
                    village = :village,
                    date_of_birth = :date_of_birth,
                    ID = :ID
                WHERE job_seeker_id = :job_seeker_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fathers_name', $fathers_name);
        $stmt->bindParam(':mothers_name', $mothers_name);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':sector', $sector);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':cell', $cell);
        $stmt->bindParam(':village', $village);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':ID', $ID);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':job_seeker_id', $job_seeker_id);
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