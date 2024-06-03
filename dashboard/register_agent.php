<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:../index.php");
    exit();
}
include('../connection.php');

// Retrieve the email from the session
$email = $_SESSION['user_email'];
$stmt = $pdo->prepare("SELECT users_id FROM users WHERE email = ?");
$stmt->execute([$email]); 
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
    <title>Document</title>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Form container */
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

<h2 style="text-align:center;margin-top:2rem">Register Agent</h2><br>
<div class="form-container">
    <form action="" method="post">
        <div class="form-row">
            <div>
                <label for="firstname">FIRSTNAME:</label>
                <input type="text" name="firstname" required>
            </div>
            <div>
                <label for="lastname">LASTNAME:</label>
                <input type="text" name="lastname" required>
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="gender">GENDER:</label>
                <select name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div>
                <label for="date_of_birth">DATE OF BIRTH:</label>
                <input type="date" name="date_of_birth" required>
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="province">PROVINCE:</label>
                <input type="text" name="province" required>
            </div>
            <div>
                <label for="district">DISTRICT:</label>
                <input type="text" name="district" required>
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="sector">SECTOR:</label>
                <input type="text" name="sector" required>
            </div>
            <div>
                <label for="cell">CELL:</label>
                <input type="text" name="cell" required>
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="village">VILLAGE:</label>
                <input type="text" name="village" required>
            </div>
            <div>
                <label for="email">EMAIL:</label>
                <input type="email" name="email" required>
            </div>
        </div>
        <div class="form-row">
            <div>
                <label for="telephone">PHONE NUMBER:</label>
                <input type="tel" name="telephone" required>
            </div>
            <div>
                <label for="password">PASSWORD:</label>
                <input type="password" name="password" required>
            </div>
        </div>
        <div>
            <label for="id">ID:</label>
            <input type="text" name="id" required>
        </div>
        <div>
            <input type="submit" name="register" value="Register">
        </div>
    </form>
</div>

</body>
</html>


<?php
include '../connection.php';

if (isset($_POST["register"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $province = $_POST['province'];
    $district = $_POST['district'];
    $full_name = $firstname . ' ' . $lastname; 
    $sector = $_POST['sector'];
    $gender=$_POST['gender'];
    $cell = $_POST['cell'];
    $village = $_POST['village'];
    $date_of_birth = $_POST['date_of_birth'];
    $id=$_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $telephone = $_POST['telephone'];
    $role_id = $_GET['role_id'];

    //Insert into users table
    $stmt_user = $pdo->prepare("INSERT INTO users (role_id, email, first_name, last_name, full_name, gender, password)
    VALUES (:role_id, :email, :first_name, :last_name, :full_name, :gender, :password)");
    $stmt_user->bindParam(':email', $email);
    $stmt_user->bindParam(':first_name', $firstname);
    $stmt_user->bindParam(':last_name', $lastname);
    $stmt_user->bindParam(':full_name', $full_name);
    $stmt_user->bindParam(':password', $password);         
    $stmt_user->bindParam(':gender', $gender);         
    $stmt_user->bindParam(':role_id', $role_id);
    $stmt_user->execute();
    $users_id = $pdo->lastInsertId();


    $stmt_job_provider = $pdo->prepare("INSERT INTO agent (users_id, role_id,  province, district, sector, cell, village, date_of_birth,id) VALUES (:users_id, :role_id, :province, :district, :sector, :cell, :village,:date_of_birth, :id)");
    $stmt_job_provider->bindParam(':users_id', $users_id);
    $stmt_job_provider->bindParam(':role_id', $role_id);
    $stmt_job_provider->bindParam(':province', $province);
    $stmt_job_provider->bindParam(':district', $district);
    $stmt_job_provider->bindParam(':sector', $sector);
    $stmt_job_provider->bindParam(':cell', $cell);
    $stmt_job_provider->bindParam(':village', $village);
    $stmt_job_provider->bindParam(':date_of_birth', $date_of_birth);
    $stmt_job_provider->bindParam(':id', $id);
    try {
        if ($stmt_job_provider->execute()) {
            echo "<script>alert('New agent has been added');</script>";
        } else {
            echo "<script>alert('Error: Unable to execute statement');</script>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
