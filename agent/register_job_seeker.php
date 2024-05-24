<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location:../index.php");
    exit();
}
include('../connection.php');
$user_email = $_SESSION['user_email'];
$stmt = $pdo->prepare("SELECT users_id FROM users WHERE email = ?");
$stmt->execute([$user_email]); 
$user_id = $stmt->fetchColumn(); 
$stmt->closeCursor(); 
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
    <title>Document</title>
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
        select,
        

        .form-container input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure padding and border are included in width */
        }
        .form-container input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure padding and border are included in width */
        }

        /* Submit button */
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
 
    <h2 style="text-align:center;margin-top:2rem">Register Job Seeker</h2><br>
<div class="form-container">
    
<form action="" method="post">
            <div>
                <label for="name">FIRSTNAME:</label>
                <input type="text"  name="firstname" required>
            </div>
            <div>
                <label for="physical_code">LASTNAME:</label>
                <input type="text"  name="lastname" required>
            </div>
            <div>
                <label for="email">FATHER'S NAME:</label>
                <input type="text"  name="fathers_name" required>
            </div>
            <div>
                <label for="phone">MOTHER'S NAME:</label>
                <input type="text"  name="mothers_name" required>
            </div>
            <div>
                <label for="gender">GENDER:</label>
                <select name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div>
    <label for="date_of_birth">DATE OF BIRTH:</label>
    <input type="date" name="date_of_birth" id="date_of_birth" required>
</div>

            <div>
                <label for="phone">PROVINCE:</label>
                <input type="text"  name="province" required>
            </div>
            <div>
                <label for="province">PROVINCE:</label>
                <select name="province">
                    <option value="KIGALI CITY">KIGALI CITY</option>
                    <option value="WESTERN PROVINCE">WESTERN PROVINCE</option>
                    <option value="WESTERN PROVINCE">WESTERN PROVINCE</option>
                </select>
            </div>
            <div>
                <label for="phone">DISTRICT:</label>
                <input type="text"  name="district" required>
            </div>
            <div>
                <label for="phone">SECTOR:</label>
                <input type="text"  name="sector" required>
            </div>
            <div>
                <label for="phone">CELL:</label>
                <input type="text"  name="cell" required>
            </div>
            <div>
                <label for="phone">VILLAGE:</label>
                <input type="text"  name="village" required>
            </div>
            <div>
            <label for="physical_code">EMAIL:</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div>
            <label for="phone">PHONE NUMBER:</label>
            <input type="text" id="phone" name="telephone" required>
        </div>

        <div>
            <label for="email">PASSWORD:</label>
            <input type="password" id="password" name="password" required>
        </div>
            <div>
                <label for="phone">ID</label>
                <input type="text"  name="id" required>
            </div>
            
            <div>
                <input type="submit" name="register" value="Register" style="width:104px;">
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
    $fathers_name = $_POST['fathers_name'];
    $mothers_name = $_POST['mothers_name'];
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
    $created_by=$user_email;

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


    $stmt_job_provider = $pdo->prepare("INSERT INTO job_seeker (users_id, role_id,  province,fathers_name,mothers_name, district, sector, cell, village, date_of_birth,id,created_by) VALUES (:users_id, :role_id, :province,:fathers_name,:mothers_name, :district, :sector, :cell, :village,:date_of_birth, :id,:created_by)");
    $stmt_job_provider->bindParam(':users_id', $users_id);
    $stmt_job_provider->bindParam(':role_id', $role_id);
    $stmt_job_provider->bindParam(':province', $province);
    $stmt_job_provider->bindParam(':district', $district);
    $stmt_job_provider->bindParam(':fathers_name', $fathers_name);
    $stmt_job_provider->bindParam(':mothers_name', $mothers_name);
    $stmt_job_provider->bindParam(':sector', $sector);
    $stmt_job_provider->bindParam(':cell', $cell);
    $stmt_job_provider->bindParam(':village', $village);
    $stmt_job_provider->bindParam(':date_of_birth', $date_of_birth);
    $stmt_job_provider->bindParam(':id', $id);
    $stmt_job_provider->bindParam(':created_by', $created_by);
    try {
        if ($stmt_job_provider->execute()) {
            echo "<script>alert('New job seeker has been added');</script>";
        } else {
            echo "<script>alert('Error: Unable to execute statement');</script>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<script>
    var today = new Date();
    var maxDate = new Date();
    maxDate.setFullYear(today.getFullYear() - 18);
    var maxDateFormatted = maxDate.toISOString().split('T')[0];
    document.getElementById("date_of_birth").setAttribute("max", maxDateFormatted);
</script>



