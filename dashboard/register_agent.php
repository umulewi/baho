<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("location:../index.php");
    exit();
}
include('../connection.php');

// Retrieve the email from the session
$email = $_SESSION['email'];
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
            box-sizing: border-box; 
        }
        .form-container input[type="password"] {
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
 
    <h2 style="text-align:center;margin-top:2rem">Register Job Provider</h2><br>
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
                <label for="phone">PROVINCE:</label>
                <input type="text"  name="province" required>
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
            <label for="physical_code">Email:</label>
            <input type="text" id="email" name="email" required>
        </div>
        
        <div>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="telephone" required>
        </div>

        <div>
            <label for="email">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

            <div>
                <label for="phone">ID</label>
                <input type="text"  name="id" required>
            </div>

            
            <div>
                <input type="submit" name="register" value="Register" stayle="background-color:red">
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
    $sector = $_POST['sector'];
    $cell = $_POST['cell'];
    $village = $_POST['village'];
    $id=$_POST['id'];
    $created_by = $_SESSION['email'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $telephone = $_POST['telephone'];
    $role_id = $_GET['role_id'];
    $stmt_user = $pdo->prepare("INSERT INTO users (telephone, email, password, role_id) VALUES (:telephone, :email, :password, :role_id)");
    $stmt_user->bindParam(':telephone', $telephone);
    $stmt_user->bindParam(':email', $email);
    $stmt_user->bindParam(':password', $password);
    $stmt_user->bindParam(':role_id', $role_id);
    $stmt_user->execute();
    $users_id = $pdo->lastInsertId();

        $stmt_agent=$pdo->prepare("INSERT INTO agent (users_id,role_id, firstname, lastname,  province, district, sector, cell, village, id, created_by) 
                VALUES (:users_id,:role_id, :firstname, :lastname, :province, :district, :sector, :cell, :village, :id, :created_by)");
        $stmt_agent->bindParam(':users_id', $user_id); 
        $stmt_agent->bindParam(':role_id', $role_id); 
        $stmt_agent->bindParam(':firstname', $firstname);
        $stmt_agent->bindParam(':lastname', $lastname);
        $stmt_agent->bindParam(':province', $province);
        $stmt_agent->bindParam(':district', $district);
        $stmt_agent->bindParam(':sector', $sector);
        $stmt_agent->bindParam(':cell', $cell);
        $stmt_agent->bindParam(':village', $village);
        $stmt_agent->bindParam(':id', $id);
        $stmt_agent->bindParam(':created_by', $created_by);

        try {
            if ($stmt_agent->execute()) {
                echo "<script>alert('New Agent has been added');</script>";
            } else {
                echo "<script>alert('Error: Unable to execute statement');</script>";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
